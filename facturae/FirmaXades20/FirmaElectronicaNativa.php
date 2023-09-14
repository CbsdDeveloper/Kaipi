<?php
/** 
* Copyright (c)2018 - EN Systems Apps
* @abstract Firma, Valida, Envia al SRI y Autoriza en el SRI
* @author Erik Niebla
* @mail ep_niebla@hotmail.com, ep.niebla@gmail.com
* @version 1.0
* Fecha de creación  2018-02-27
* http://ensystems.ddns.net
*/
require_once dirname(__FILE__)."/nuSoap/nusoap.php"; // Libreria para el uso del cliente soap
require_once dirname(__FILE__)."/Signer/FacturaeSigner.php"; // Libreria para el uso del cliente soap

class FirmaElectronica
{   
    protected $ws;
	private $signer;
	private $validator="https://ensystems-sri-xades.herokuapp.com/WS/validaXadesBes.wsdl"; // WS de validation, EN Systems
	private $rideWS="https://ensystems-sri-xades.herokuapp.com/WS/rideSri.wsdl"; // WS de Creacion de Rides, EN Systems
	private $P12toPem="https://ensystems-sri-xades.herokuapp.com/WS/P12toPEM.wsdl"; // WS de Creacion de Rides, EN Systems
    private $development=array(
		0=>array(
			'recept'=>"https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantes?wsdl",
			'autori'=>"https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantes?wsdl"
		),
		1=>array(
			'recept'=>"https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl",
			'autori'=>"https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"
		)
    );
    private $production=array(
		0=>array(
			'recept'=>"https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantes?wsdl",
			'autori'=>"https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantes?wsdl"
		),
		1=>array(
			'recept'=>"https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl",
			'autori'=>"https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"
		)
    );  
    protected $key=null;
    protected $data=array(
        'key_p12'=>null,
        'pass_key'=>null,
        'file_to_sign'=>null,
        'file_signed'=>null,
        'file_to_send'=>null,
        'file_autorized'=>null
    );
    public function __construct(array $config = array()){    
        $this->setConfig($config);
        $this->setAmbiente(true,false,null);
		$this->signer = new FacturaeSigner();
    }
    public function setConfig($config=array()){
		 $this->data=array_merge($this->data,$config);
	}
    public function setProduction($production=true){
        $this->setAmbiente(false,$production);
    }
	public function setAmbiente($online=true,$production=false,$signer=null){
		$k=$online==true?0:1;
		$this->ws=($production==true)?$this->production[$k]:$this->development[$k];        
	}	
    public function setFileToSignPath($file_to_sign){
        if(!empty($file_to_sign)) $this->data['file_to_sign']=$file_to_sign;
    }
    public function setFileSignedPath($file_signed){
        if(!empty($file_signed)) $this->data['file_signed']=$file_signed;
    }
    public function setFileAutorized($file_autorized){
        if(!empty($file_autorized)) $this->data['file_autorized']=$file_autorized;
    }
    public function isKeyActive(){ return $this->signer->keyActive; }
	/*public function setKeyPem($file_key, $pass, $echo=false){
        try {
            if(!empty($file_key)&&!empty($file_public_key)&&!empty($pass)&&is_readable($file_key)){  
                return $this->signer->setKey($file_public_key, $file_key, $pass);
            } return false;
        } catch (Exception $e) { 
            if($echo) echo 'ExcepciÃ³n Capturada: ',  $e->getMessage(), "\n";
            return false; 
        }    
    }*/
    public function setKey($file_key, $pass, $echo=false){
        try {
            if(!empty($file_key)&&!empty($pass)&&is_readable($file_key)){  
                return $this->signer->setKey($file_key, null, $pass);
            } return false;
        } catch (Exception $e) { 
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return false; 
        }    
    }
    public function signXmlPem($config = array(), $echo=false){
        $resps=array('success'=>true,'message'=>'');        
        try {
            if(!empty($config) && is_array($config)) $this->data = array_merge($this->data,$config);
            
            if( (empty($this->data['file_to_sign']) || !is_readable($this->data['file_to_sign'] ) ) )  throw new Exception("No se encontro el xml a firmar");
			if( !$this->isKeyActive() ) throw new Exception("No se ha configurado un certificado digital!");
			
            $firmado = $this->signer->injectSignature(file_get_contents($this->data['file_to_sign']));
            if(!empty($this->data['file_signed'])){
                file_put_contents($this->data['file_signed'], $firmado);  
                $this->data['file_to_send']=$this->data['file_signed'];
            }			
			$doc = new DOMDocument('1.0', 'utf-8');
            $doc->formatOutput = false;
            $xml = self::encode_utf8($firmado);
            $doc->loadXml($xml);
            $resps['xml']=$xml;
            $resps['document']=$doc;
        } catch(Exception $e) { 
            $resp['success']=false;
            $resp['message']=$e->getMessage();
            if($echo) echo 'Excepción Capturada: ', $resp['message'], "\n";            
        } return $resps;
    }
    public function signXml($config = array(), $echo=false){
        $resp=$this->signXmlPem($config,$echo);
        return $resp['success']?$resp['document']:false;
    }
	public function sendToValidate($file_signed=null, $echo=false){
		if(!empty($file_signed))$this->data['file_signed']=$file_signed; 
        try {
            if(empty($this->data['file_signed'])||!is_readable($this->data['file_signed'])) return array('success'=>false,'message'=>'Revise la ruta del xml!','type'=>'application');            
            $xml=file_get_contents($this->data['file_signed']);
            $xml_64=base64_encode(self::encode_utf8($xml));
            
            $cliente = new nusoap_client($this->validator, true);            
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'constructor');
            
            $result = $cliente->call("validateSignature", array("file" => $xml_64));
            
            if ($cliente->fault) return array('success'=>false,'message'=>'Fault','type'=>'call','data'=>$result);        
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'response');
            
            return $result;
        } catch (Exception $e) { 
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application'); 
        }     
    }
    public function validaXml($file_signed=null, $echo=false){
		if(!empty($file_signed)) $this->data['file_signed']=$file_signed;
		function libxml_display_error($error){
			$return = "<br/>\n";
			switch ($error->level) {
				case LIBXML_ERR_WARNING: $return .= "<b>Warning $error->code</b>: "; break;
				case LIBXML_ERR_ERROR: $return .= "<b>Error $error->code</b>: "; break;
				case LIBXML_ERR_FATAL: $return .= "<b>Fatal Error $error->code</b>: "; break;
			}
			$return .= trim($error->message); //if ($error->file) { $return .= " in <b>$error->file</b>"; }
			$return .= " on line <b>$error->line</b>\n";
			return $return;
		}
		function libxml_display_errors() {
			$html="<br/>\n";
			$errors = libxml_get_errors();    
			if(isset($errors)&&!empty($errors)){
				foreach ($errors as $error) {
					$html.=libxml_display_error($error);
				} libxml_clear_errors();
			} return $html;
		}
		libxml_use_internal_errors(true);
		try {
			if(empty($this->data['file_signed'])||!is_readable($this->data['file_signed'])) return array('success'=>false,'message'=>'No se especifico la ruta del archivo firmado!','type'=>'setter');
			$xml=file_get_contents($this->data['file_signed']);
			
			$doc = new DOMDocument('1.0', 'utf-8');
			$doc->formatOutput = true;
            $doc->loadXml(self::encode_utf8($xml));

			$doc_name   =strtoupper($doc->documentElement->nodeName);    
			$doc_version=str_replace('.','_',$doc->documentElement->getAttribute('version'));			
			
			if(isset($this->xsd_docs[$doc_name])) $doc_name=$this->xsd_docs[$doc_name];
			$xsd=dirname(__FILE__)."/xsd/{$doc_version}/{$doc_name}_V_{$doc_version}.xsd";    
			if(!file_exists($xsd)) throw new Exception("No existe Schema de Validacion para el documento $doc_name version $doc_version!");
	
			if(!$doc->schemaValidate($xsd)){ 
				throw new Exception("El XML no paso el Schema de Validacion del SRI, <b>XSD:{$doc_name}_V_{$doc_version}.xsd</b>! ".libxml_display_errors());
			}
			return array('success'=>true,'message'=>'XSD ha validado correctamente!','type'=>'application'); 
		} catch (Exception $e) { 
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application'); 
        }  
	}
    public function sendToSri($file_signed=null, $echo=false){
        try {
            if(!empty($file_signed)) $this->data['file_signed']=$file_signed; 
            if(empty($this->data['file_signed'])||!is_readable($this->data['file_signed'])) return array('success'=>false,'message'=>'No se especifico la ruta del archivo firmado!','type'=>'setter');
            if(!is_readable($this->data['file_signed'])) return array('success'=>false,'message'=>'No se encontro el archivo xml!','type'=>'setter');
            $cliente = new nusoap_client($this->ws['recept'], true);
            //$cliente->setCurlOption(CURLOPT_SSLVERSION,3);
            //$cliente->setCurlOption(CURLOPT_SSL_VERIFYPEER,false);
            //$cliente->setCurlOption(CURLOPT_SSL_VERIFYHOST,false);
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'constructor');
            
            $base_convert=base64_encode(file_get_contents($this->data['file_signed']));
            $result = $cliente->call("validarComprobante", array("xml" =>$base_convert));
            //var_dump($result);
            if ($cliente->fault) return array('success'=>false,'message'=>'Fault','type'=>'call','data'=>$result);        
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'response');
            // todo correcto
			//var_dump($result);             
            $resp = array('success'=>$result['RespuestaRecepcionComprobante']['estado']=='DEVUELTA'?false:true,'message'=>'','informacionAdicional'=>'','type'=>'response');
			if($resp['success']==false){
				$comp=$result['RespuestaRecepcionComprobante']['comprobantes']['comprobante'];
				$resp['claveAcceso']=$comp['claveAcceso'];
                $msgs=$comp['mensajes'];
                foreach($msgs as $msg){
                    if($resp['success']==false && $msg['identificador']*1==43) $resp['success']=true;
                    $resp['message'].=((isset($msg['tipo'])?"$msg[tipo] ":'')."$msg[identificador]: $msg[mensaje]!, ");
                    if(isset($msg['informacionAdicional'])) $resp['informacionAdicional'].="$msg[informacionAdicional]!, ";
                }
                $resp['message']=self::encode_utf8(substr($resp['message'],0,-2));
                if(!empty($resp['informacionAdicional']))$resp['informacionAdicional']=self::encode_utf8(substr($resp['informacionAdicional'],0,-2));
            }
            return $resp;
        } catch (Exception $e) {
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application');
        }
    }
    public function autorizarSri($claveAcceso=null, $file_autorized=null, $echo=false){
        try {
			if(!empty($claveAcceso)) $this->data['access_key']=$claveAcceso;
            if(!empty($file_autorized)) $this->data['file_autorized']=$file_autorized;
            if(empty($this->data['access_key'])) return array('success'=>false,'message'=>'No se especifico una Clave de Acceso','type'=>'setter');
            $cliente = new nusoap_client($this->ws['autori'], true);
            
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'constructor');
            
            $result = $cliente->call("autorizacionComprobante", array("claveAccesoComprobante" =>$this->data['access_key']));
            
            if ($cliente->fault) return array('success'=>false,'message'=>'Fault','type'=>'call','data'=>$result);        
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'response');
            // todo correcto
            $aut=$result['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']; 
            $autorizado=(trim(''.$aut['estado'])=='AUTORIZADO');
            $resp=array('success'=>$autorizado,'xml'=>'','message'=>'','informacionAdicional'=>'');
            if($autorizado){
                $doc = new DOMDocument('1.0', 'utf-8');
                $doc->formatOutput = true;   
                $autorizacion=$doc->createElement('autorizacion'); 
                $estado=$doc->createElement('estado',$aut['estado']); 
                $numeroAutorizacion=$doc->createElement('numeroAutorizacion',$aut['numeroAutorizacion']);
                $fechaAutorizacion=$doc->createElement('fechaAutorizacion',$aut['fechaAutorizacion']);
                $cdata = $doc->createCDATASection(self::encode_utf8($aut['comprobante']));
                $comprobante=$doc->createElement('comprobante');
                $comprobante->appendChild($cdata);

                $fechaAutorizacion->setAttribute('class','fechaAutorizacion');
                $autorizacion->appendChild($estado);
                $autorizacion->appendChild($numeroAutorizacion);
                $autorizacion->appendChild($fechaAutorizacion);
                $autorizacion->appendChild($comprobante);
                $doc->appendChild($autorizacion);
                if(!empty($this->data['file_autorized']))
                    $doc->save($this->data['file_autorized']);
                $resp['xml']=$doc->saveXML();
				$resp['numeroAutorizacion']=$aut['numeroAutorizacion'];
                $resp['fechaAutorizacion']=$aut['fechaAutorizacion'];
            }else{                
                $msgs=$aut['mensajes'];				
                foreach($msgs as $msg){                    
                    $resp['message'].=((isset($msg['tipo'])?"$msg[tipo] ":'')."$msg[identificador]: $msg[mensaje]!, ");
                    if(isset($msg['informacionAdicional'])) $resp['informacionAdicional'].="$msg[informacionAdicional]!, ";
                }
                $resp['message']=self::encode_utf8(substr($resp['message'],0,-2));
                if(!empty($resp['informacionAdicional']))$resp['informacionAdicional']=self::encode_utf8(substr($resp['informacionAdicional'],0,-2));
            }
            return $resp;
        } catch (Exception $e) { 
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application','informacionAdicional'=>''); 
        }
    }
    public function sendToRideWS($file, $logo="", $echo=false){
        try {
            if(empty($file)||!is_readable($file)) return array('success'=>false,'message'=>'Revise la ruta del xml!','type'=>'application');  
			$fileLogo="";
			$ext="";
			if($logo!=null && !empty($logo) && is_readable($logo)){
				$ext = pathinfo($logo, PATHINFO_EXTENSION);
				$flog=file_get_contents($logo);
				$fileLogo=base64_encode($flog);				
			}
            $xml=file_get_contents($file);
            $xml_64=base64_encode(self::encode_utf8($xml));
            
            $cliente = new nusoap_client($this->rideWS, true);            
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'constructor');
            
            $result = $cliente->call("getRide", array("file" => $xml_64, "logo"=>$fileLogo, "ext"=>$ext));
            //var_dump($result);
            if ($cliente->fault) return array('success'=>false,'message'=>'Fault','type'=>'call','data'=>$result);        
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'response');
            $result['pdf']=base64_decode($result['pdf']);
            return $result;
        } catch (Exception $e) { 
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application'); 
        }     
    }
    public function sendP12toPEM($file, $pass, $echo=false){
        try {
            if(empty($file)||!is_readable($file)) return array('success'=>false,'message'=>'Revise la ruta del archivo p12!','type'=>'application');            
            $xml=file_get_contents($file);
            $xml_64=base64_encode($xml);
            $pass_64=base64_encode($pass);  
			
            $cliente = new nusoap_client($this->P12toPem, true);            
            $error = $cliente->getError();
            if($error) return array('success'=>false,'message'=>$error,'type'=>'constructor');
            
			
            $result = $cliente->call("getFilePEM", array("key" => $xml_64, "pass"=>$pass_64 ));
            
            if ($cliente->fault) return array('success'=>false,'message'=>'Fault','type'=>'call','data'=>$result);        
            $error = $cliente->getError();
			
            if($error) return array('success'=>false,'message'=>$error,'type'=>'response');
			
            $result['pem']=base64_decode($result['pem']);
            return $result;
        } catch (Exception $e) { 
            if($echo) echo 'Excepción Capturada: ',  $e->getMessage(), "\n";
            return array('success'=>false,'message'=>$e->getMessage(),'type'=>'application'); 
        }     
    }
    private static function encode_utf8($text){
        return !mb_detect_encoding($text,'UTF-8',true)?mb_convert_encoding($text,'UTF-8','ISO-8859-1'):$text;
    }
}     