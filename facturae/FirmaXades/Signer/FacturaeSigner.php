<?php
require_once dirname(__FILE__).'/KeyPairReader.php';
require_once dirname(__FILE__).'/XmlTools.php';


/**
 * Implements all properties and methods needed for an instantiable
 * @link{josemmo\Facturae\Facturae} to be signed and time stamped.
 */
class FacturaeSigner {

  protected $signTime = null;
  protected $signPolicy = null;
  protected $timestampServer = null;
  private $timestampUser = null;
  private $timestampPass = null;
  private $publicKey = null;
  private $privateKey = null;
  public $keyActive = false;
  
  private $ds = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#"';
  private $etsi='xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#"';
	

    /*protected function getNamespaces() {
		$xmlns = array();
		$xmlns[] = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#"';
		//$xmlns[] = 'xmlns:fe="' . self::$SCHEMA_NS[$this->version] . '"';
		$xmlns[] = 'xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#"';
		return $xmlns;
	}*/
  /**
   * Set sign time
   *
   * @param int|string $time Time of the signature
   */
  public function setSignTime($time) {
    $this->signTime = is_string($time) ? strtotime($time) : $time;
  }


  /**
   * Set timestamp server
   *
   * @param string $server Timestamp Authority URL
   * @param string $user   TSA User
   * @param string $pass   TSA Password
   */
  public function setTimestampServer($server, $user=null, $pass=null) {
    $this->timestampServer = $server;
    $this->timestampUser = $user;
    $this->timestampPass = $pass;
  }


  /**
   * Sign
   *
   * @param  string  $publicPath  Path to public key PEM file or PKCS#12
   *                              certificate store
   * @param  string  $privatePath Path to private key PEM file (should be null
   *                              in case of PKCS#12)
   * @param  string  $passphrase  Private key passphrase
   * @param  array   $policy      Facturae sign policy
   * @return boolean              Success
   */
  public function setKey($publicPath, $privatePath=null, $passphrase="") {
    // Generate random IDs
    $tools = new XmlTools();
    $this->signatureID = $tools->randomId();
    $this->signedInfoID = $tools->randomId();
    $this->signedPropertiesID = $tools->randomId();
    $this->signatureValueID = $tools->randomId();
    $this->certificateID = $tools->randomId();
    $this->referenceID = $tools->randomId();
    $this->signatureSignedPropertiesID = $tools->randomId();
    $this->signatureObjectID = $tools->randomId();

    // Load public and private keys
    $reader = new KeyPairReader($publicPath, $privatePath, $passphrase);
    $this->publicKey = $reader->getPublicKey();
    $this->privateKey = $reader->getPrivateKey();
    //$this->signPolicy = $policy;
    unset($reader);
	$this->keyActive=(!empty($this->publicKey) && !empty($this->privateKey));
    // Return success
    return $this->keyActive;
  }


  /**
   * Inject signature
   *
   * @param  string $xml Unsigned XML document
   * @return string      Signed XML document
   */
  public function injectSignature($xml) {
	$xmlnsds=array($this->ds,$this->etsi);  
	$xmlnsetsi=array($this->ds,$this->etsi);
	
	// Normalize document
    $xml = str_replace("\r", "", $xml);
	//var_dump( $xml );
	$t_xml = new DOMDocument();
	$t_xml->loadXML($xml);	
	$root= $t_xml->documentElement->tagName;
	$xml_can = $t_xml->documentElement->C14N(false,false);
	//var_dump( $xml_can  );
	
    // Make sure we have all we need to sign the document
    if (empty($this->publicKey) || empty($this->privateKey)) return $xml;
    $tools = new XmlTools();

    

    // Prepare signed properties
    $signTime = is_null($this->signTime) ? time() : $this->signTime;
    $certData = openssl_x509_parse($this->publicKey);
	
    $certIssuer = array();
    foreach ($certData['issuer'] as $item=>$value) {
      $certIssuer[] = $item . '=' . $value;
    }
    $certIssuer = implode(',', array_reverse($certIssuer));

    // Generate signed properties
    $prop = '<etsi:SignedProperties Id="Signature' . $this->signatureID .'-SignedProperties' . $this->signatureSignedPropertiesID . '">' .
              '<etsi:SignedSignatureProperties>' .
                '<etsi:SigningTime>' . date('c', $signTime) . '</etsi:SigningTime>' .
                '<etsi:SigningCertificate>' .
                  '<etsi:Cert>' .
                    '<etsi:CertDigest>' .
                      '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>' .
                      '<ds:DigestValue>' . $tools->getCertDigest($this->publicKey) . '</ds:DigestValue>' .
                    '</etsi:CertDigest>' .
                    '<etsi:IssuerSerial>' .
                      '<ds:X509IssuerName>' . $certIssuer . '</ds:X509IssuerName>' .
                      '<ds:X509SerialNumber>' . $certData['serialNumber'] . '</ds:X509SerialNumber>' .
                    '</etsi:IssuerSerial>' .
                  '</etsi:Cert>' .
                '</etsi:SigningCertificate>' .(!is_null($this->signPolicy)?
                '<etsi:SignaturePolicyIdentifier>' .
                  '<etsi:SignaturePolicyId>' .
                    '<etsi:SigPolicyId>' .
                      '<etsi:Identifier>' . $this->signPolicy['url'] . '</etsi:Identifier>' .
                      '<etsi:Description>' . $this->signPolicy['name'] . '</etsi:Description>' .
                    '</etsi:SigPolicyId>' .
                    '<etsi:SigPolicyHash>' .
                      '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></ds:DigestMethod>' .
                      '<ds:DigestValue>' . $this->signPolicy['digest'] . '</ds:DigestValue>' .
                    '</etsi:SigPolicyHash>' .
                  '</etsi:SignaturePolicyId>' .
                '</etsi:SignaturePolicyIdentifier>' .
                '<etsi:SignerRole>' .
                  '<etsi:ClaimedRoles>' .
                    '<etsi:ClaimedRole>emisor</etsi:ClaimedRole>' .
                  '</etsi:ClaimedRoles>' .
                '</etsi:SignerRole>' :'').
              '</etsi:SignedSignatureProperties>' .
              '<etsi:SignedDataObjectProperties>' .
                '<etsi:DataObjectFormat ObjectReference="#Reference-ID-' . $this->referenceID . '">' .
                  '<etsi:Description>contenido comprobante</etsi:Description>' .
                  '<etsi:MimeType>text/xml</etsi:MimeType>' .
                '</etsi:DataObjectFormat>' .
              '</etsi:SignedDataObjectProperties>' .
            '</etsi:SignedProperties>';

    // Extract public exponent (e) and modulus (n)
    $privateData = openssl_pkey_get_details($this->privateKey);
    $modulus = chunk_split(base64_encode($privateData['rsa']['n']), 76);
    $modulus = str_replace("\r", "", $modulus);
    $exponent = base64_encode($privateData['rsa']['e']);

    // Generate KeyInfo
    $kInfo = '<ds:KeyInfo Id="Certificate' . $this->certificateID . '">' . "" .
               '<ds:X509Data>' . "" .
                 '<ds:X509Certificate>' . "" . $tools->getCert($this->publicKey) . '</ds:X509Certificate>' . "" .
               '</ds:X509Data>' . "" .
               '<ds:KeyValue>' . "" .
                 '<ds:RSAKeyValue>' . "" .
                   '<ds:Modulus>' . "" . $modulus . '</ds:Modulus>' . "" .
                   '<ds:Exponent>' . $exponent . '</ds:Exponent>' . "" .
                 '</ds:RSAKeyValue>' . "" .
               '</ds:KeyValue>' . "" .
             '</ds:KeyInfo>';

    // Calculate digests
    //$xmlns = $this->getNamespaces();
    $propDigest = $tools->getDigest($tools->injectNamespaces($prop, $xmlnsetsi));
    $kInfoDigest = $tools->getDigest($tools->injectNamespaces($kInfo, $xmlnsds));
    $documentDigest = $tools->getDigest($xml_can);

    // Generate SignedInfo
    $sInfo = '<ds:SignedInfo Id="Signature-SignedInfo' . $this->signedInfoID . '">' . "" .
               '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315">'.'</ds:CanonicalizationMethod>' . "" .
               '<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1">' .
               '</ds:SignatureMethod>' . "" .
               '<ds:Reference Id="SignedPropertiesID' . $this->signedPropertiesID . '" '.'Type="http://uri.etsi.org/01903#SignedProperties" ' .'URI="#Signature' . $this->signatureID . '-SignedProperties' .$this->signatureSignedPropertiesID . '">' . "" .
                 '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">' .
                 '</ds:DigestMethod>' . "" .
                 '<ds:DigestValue>' . $propDigest . '</ds:DigestValue>' . "" .
               '</ds:Reference>' . "" .
               '<ds:Reference URI="#Certificate' . $this->certificateID . '">' . "" .
                 '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">' .
                 '</ds:DigestMethod>' . "" .
                 '<ds:DigestValue>' . $kInfoDigest . '</ds:DigestValue>' . "" .
               '</ds:Reference>' . "" .
               '<ds:Reference Id="Reference-ID-' . $this->referenceID . '" URI="#comprobante">' . "" .
                 '<ds:Transforms>' . "" .
                   '<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature">' .
                   '</ds:Transform>' . "" .
                 '</ds:Transforms>' . "" .
                 '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">' .
                 '</ds:DigestMethod>' . "" .
                 '<ds:DigestValue>' . $documentDigest . '</ds:DigestValue>' . "" .
               '</ds:Reference>' . "" .
             '</ds:SignedInfo>';

    // Calculate signature
    $signaturePayload = $tools->injectNamespaces($sInfo, $xmlnsds);
    $signatureResult = $tools->getSignature($signaturePayload, $this->privateKey);

    // Make signature
    $sig = '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#" Id="Signature' . $this->signatureID . '">' . "" .
             $sInfo . "" .
             '<ds:SignatureValue Id="SignatureValue' . $this->signatureValueID . '">' . "" .
               $signatureResult .
             '</ds:SignatureValue>' . "" .
             $kInfo . "" .
             '<ds:Object Id="Signature' . $this->signatureID . '-Object' . $this->signatureObjectID . '">' .
               '<etsi:QualifyingProperties Target="#Signature' . $this->signatureID . '">' .
                 $prop .
               '</etsi:QualifyingProperties>' .
             '</ds:Object>' .
           '</ds:Signature>';

    // Inject signature
	$root=$t_xml->documentElement->tagName;
	//var_dump($xml);
	//var_dump($root);
	
    $xml = str_replace('</'.$root.'>', $sig . '</'.$root.'>', $xml);

    // Inject timestamp
    if (!empty($this->timestampServer)) $xml = $this->injectTimestamp($xml);
	
    return $xml;
  }


  /**
   * Inject timestamp
   *
   * @param  string $signedXml Signed XML document
   * @return string            Signed and timestamped XML document
   */
  private function injectTimestamp($signedXml) {
    $tools = new XmlTools();
	$xmlnsetsi=array($this->ds,$this->estsi);
    // Prepare data to timestamp
    $payload = explode('<ds:SignatureValue', $signedXml, 2)[1];
    $payload = explode('</ds:SignatureValue>', $payload, 2)[0];
    $payload = '<ds:SignatureValue' . $payload . '</ds:SignatureValue>';
    $payload = $tools->injectNamespaces($payload, $xmlnsetsi);

    // Create TimeStampQuery in ASN1 using SHA-1
    $tsq = "302c0201013021300906052b0e03021a05000414";
    $tsq .= hash('sha1', $payload);
    $tsq .= "0201000101ff";
    $tsq = hex2bin($tsq);

    // Await TimeStampRequest
    $chOpts = array(
      CURLOPT_URL => $this->timestampServer,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_BINARYTRANSFER => 1,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_FOLLOWLOCATION => 1,
      CURLOPT_CONNECTTIMEOUT => 0,
      CURLOPT_TIMEOUT => 10, // 10 seconds timeout
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $tsq,
      CURLOPT_HTTPHEADER => array("Content-Type: application/timestamp-query"),
      CURLOPT_USERAGENT => self::USER_AGENT
    );
    if (!empty($this->timestampUser) && !empty($this->timestampPass)) {
      $chOpts[CURLOPT_USERPWD] = $this->timestampUser . ":" . $this->timestampPass;
    }
    $ch = curl_init();
    curl_setopt_array($ch, $chOpts);
    $tsr = curl_exec($ch);
    if ($tsr === false) throw new \Exception('cURL error: ' . curl_error($ch));
    curl_close($ch);

    // Validate TimeStampRequest
    $responseCode = substr($tsr, 6, 3);
    if ($responseCode !== "\02\01\00") { // Bytes for INTEGER 0 in ASN1
      throw new \Exception('Invalid TSR response code');
    }

    // Extract TimeStamp from TimeStampRequest and inject into XML document
    $tools = new XmlTools();
    $timeStamp = substr($tsr, 9);
    $timeStamp = $tools->toBase64($timeStamp, true);
    $tsXml = '<etsi:UnsignedProperties Id="Signature' . $this->signatureID . '-UnsignedProperties' . $tools->randomId() . '">' .
               '<etsi:UnsignedSignatureProperties>' .
                 '<etsi:SignatureTimeStamp Id="Timestamp-' . $tools->randomId() . '">' .
                   '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315">' .
                   '</ds:CanonicalizationMethod>' .
                   '<etsi:EncapsulatedTimeStamp>' . "" . $timeStamp . '</etsi:EncapsulatedTimeStamp>' .
                 '</etsi:SignatureTimeStamp>' .
               '</etsi:UnsignedSignatureProperties>' .
             '</etsi:UnsignedProperties>';
    $signedXml = str_replace('</etsi:QualifyingProperties>', $tsXml . '</etsi:QualifyingProperties>', $signedXml);
    return $signedXml;
  }

}
