<?php

class P12{
    public $active=false;
    public $from=null;
    public $to=null;
    /**
     * Loads the given cryptographic key for the class.
     *
     * @param string  $key        Key string or filename
     * @param boolean $isFile     Is parameter key a filename
     * @param string  $passphrase Passphrase for given key
     */
    public function __construct($key, $isFile=true, $passphrase=null){
        $this->digest =OPENSSL_ALGO_SHA1;
        $this->padding=OPENSSL_PKCS1_PADDING;
        $this->config =array(
            'file' => $key,
            'pass' => $passphrase,
            'data' => null,
            'wordwrap' => 76,
        );
        $this->config['data'] = $isFile?file_get_contents($this->config['file']):$this->config['file'];
        if(openssl_pkcs12_read($this->config['data'], $this->certs, $this->config['pass'])==false) return false;
        if(isset($this->certs['extracerts'])&&is_array($this->certs['extracerts'])){
            array_unshift($this->certs['extracerts'],$this->certs['cert']);
            foreach($this->certs['extracerts'] as $i=>$cert) {
                $keyAux=openssl_x509_parse($cert);
                if(/*$keyAux['extensions']['1.3.6.1.4.1.37947.3.11'] &&*/ $keyAux['purposes'][4][0] && $keyAux['validTo_time_t']>=time() && $keyAux['validFrom_time_t']<=time()){
                    $this->setCert($i,$keyAux); break;
                }else if($keyAux['purposes'][4][0]) $this->setCert($i,$keyAux);
            }
        }else $this->data=openssl_x509_parse($this->certs['cert']); //dd($this->data);
        $this->from=$this->getDate($this->data['validFrom_time_t']);
        $this->to=$this->getDate($this->data['validTo_time_t']);
        $this->active=true;
        $this->passphrase=$passphrase;
        $this->opensslResource=$this->certs['pkey'];
        $this->key=base64_decode($this->certs['pkey']); //var_dump($this->certs['cert']);
        unset($this->config['data']);
    }
    public function setCert($i,$key=null){
        $this->certs['cert']= $this->certs['extracerts'][$i];
        $this->data = $key?:openssl_x509_parse($this->certs['cert']); 
    }
    public function getDataKey(){
        $x509 = openssl_x509_parse($this->certs['cert']);
        return $x509;
    }
    public function getSerialNumber(){ if(isset($this->data['serialNumber'])) return $this->data['serialNumber']; }
    public function getDate($val){ return date('Y-m-d H:i:s', $val); }    
    public function getName(){
        if(isset($this->data['subject']['CN'])) return $this->data['subject']['CN'];
        return $this->error('No fue posible obtener el Name (subject.CN) de la firma');
    }
    public function getEmail(){
        if(isset($this->data['subject']['emailAddress'])) return $this->data['subject']['emailAddress'];
        return $this->error('No fue posible obtener el Email (subject.emailAddress) de la firma');
    }
    public function getFrom(){ return date('Y-m-d H:i:s', $this->data['validFrom_time_t']); }
    public function getTo(){ return date('Y-m-d H:i:s', $this->data['validTo_time_t']); }
    public function getIssuer(){ return $this->data['issuer']['CN']; }
    public function getIssuerName(){
        $is=$this->data['issuer'];
        return "CN=$is[CN],L=$is[L],OU=$is[OU],O=$is[O],C=$is[C]";
    }
    public function getData(){ return $this->data; }
    public function getModulus(){
        $details=openssl_pkey_get_details(openssl_pkey_get_private($this->certs['pkey']));
        return wordwrap(base64_encode($details['rsa']['n']), $this->config['wordwrap'], "\n", true);
    }
    public function getExponent(){
        $details=openssl_pkey_get_details(openssl_pkey_get_private($this->certs['pkey']));
        return wordwrap(base64_encode($details['rsa']['e']), $this->config['wordwrap'], "\n", true);
    }
    public function getCertificate($clean=false,$wrap=false){
        $cert=$this->certs['cert'];        
        if($clean) $cert=trim(str_replace(array('-----BEGIN CERTIFICATE-----','-----END CERTIFICATE-----'),'',$cert));
        if($wrap) $cert=wordwrap(eregi_replace( "[\n]",'',$cert), $this->config['wordwrap'], "\n", true); //var_dump($this->config['wordwrap']);
        return $cert;
    }
    public function getPrivateKey($clean=false){ return $clean?trim(str_replace(array('-----BEGIN PRIVATE KEY-----', '-----END PRIVATE KEY-----'),'',$this->certs['pkey'])):$this->certs['pkey']; }
}
