<?php
/**
 * Gets both public and private keys from a PKCS#12 certificate store or a PEM
 * file (X.509 certificate).
 */
class KeyPairReader {

  private $publicKey;
  private $privateKey;
  private $extras;


  /**
   * Get public key
   * @return string Public Key
   */
  public function getPublicKey() {
    return $this->publicKey;
  }


  /**
   * Get private key
   * @return string Private Key
   */
  public function getPrivateKey() {
    return $this->privateKey;
  }


  /**
   * KeyPairReader constructor
   *
   * @param string $publicPath  Path to public key in PEM or PKCS#12 file
   * @param string $privatePath Path to private key (null for PKCS#12)
   * @param string $passphrase  Private key passphrase
   */
  public function __construct($publicPath, $privatePath=null, $passphrase="") {
    if (is_null($privatePath)){
		if($this->endsWith($publicPath,'p12'))
			$this->readPkcs12($publicPath, $passphrase);
		else
			$this->readP12ConvertPem($publicPath, $passphrase);
    }
    $this->readX509($publicPath, $privatePath, $passphrase);
  }
  function endsWith($haystack, $needle)
  {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
  }

  /**
   * Read a X.509 certificate and PEM encoded private key
   *
   * @param string $publicPath  Path to public key PEM file
   * @param string $privatePath Path to private key PEM file
   * @param string $passphrase  Private key passphrase
   */
  private function readX509($publicPath, $privatePath, $passphrase) {
    if (!is_file($publicPath) || !is_file($privatePath)) return;
    $this->publicKey = openssl_x509_read(file_get_contents($publicPath));
    $this->privateKey = openssl_pkey_get_private(
      file_get_contents($privatePath),
      $passphrase
    );
  }
  private function readP12ConvertPem($publicPath, $passphrase) {
    if (!is_file($publicPath)) return;
    
	  $key=false;
	  $matches=null;
	  $keys = file_get_contents($publicPath);
	  
	  $explode = explode("Bag Attributes",$keys);
	  $private_keys="";
	  $public_keys="";
	  foreach($explode as $aux){
		  if(!empty(trim($aux))){
			  $aux="Bag Attributes".$aux;
			  if (strpos($aux, '-----BEGIN CERTIFICATE-----') !== false){
				  $public_keys.=$aux;
			  }else{
				  $private_keys.=$aux;
			  }
		  }
	  }
	  preg_match_all('/(Bag Attributes.*.*-----END CERTIFICATE-----)/Us', $public_keys, $matches);
	  if(count($matches[0])>0)
		  foreach($matches[0] as $match){
			//if (strpos($match, 'Encryption') !== false) {				
				$keyAux=openssl_x509_parse($match);
				if(/*$keyAux['extensions']['1.3.6.1.4.1.37947.3.11'] &&*/ $keyAux['purposes'][4][0] && $keyAux['validTo_time_t']>=time() && $keyAux['validFrom_time_t']<=time()){
					$key=$match;
					break;
				}
			}
		  //}
	//var_dump($key);	  
	$this->publicKey =	openssl_x509_read($key);
	$publicData = (openssl_pkey_get_details(openssl_pkey_get_public($key)));	
	$modulus=base64_encode($publicData['rsa']['n']); //$xml->getElementsByTagName('Modulus')->item(0)->nodeValue;
	//var_dump($modulus);
	
	  $pkey=false;
	  $matches=null;
	  //$keys = file_get_contents($publicPath);
	  //var_dump($keys);
	  preg_match_all('/(Bag Attributes.*-----END ENCRYPTED PRIVATE KEY-----)/Us', $private_keys, $matches);
	  if(count($matches[0])>0)
		  foreach($matches[0] as $match){
			 $privateData= openssl_pkey_get_details(openssl_pkey_get_private($match,$passphrase));

			 if (base64_encode($privateData['rsa']['n']) == $modulus) {	
				$pkey=openssl_pkey_get_private($match,$passphrase);				
				break;
			}
		  }
	  $this->privateKey = $pkey;
  }
  
  /**
   * Read a PKCS#12 Certificate Store
   *
   * @param string $certPath   The certificate store file name
   * @param string $passphrase Password for unlocking the PKCS#12 file
   */
  private function readPkcs12($certPath, $passphrase) {
    if (!is_file($certPath)) return false;
    if (openssl_pkcs12_read(file_get_contents($certPath), $certs, $passphrase)) {
      
      $this->privateKey = openssl_pkey_get_private($certs['pkey']);
	  $this->publicKey = openssl_x509_read($certs['cert']);
	  $this->extras = $certs['extracerts'];
	  
	  /*var_dump( $this->getTo(openssl_x509_parse($certs['cert'])['validTo_time_t']) );
	  foreach($this->extras as $cert){
		  var_dump( $this->getTo(openssl_x509_parse($cert)['validTo_time_t']) );
	  }*/
    }
  }
    public static function getValidTo($validTo)
    {
        return date('Y-m-d H:i:s',$validTo);
    }

}
