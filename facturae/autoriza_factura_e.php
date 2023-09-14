<?php
date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");


$autretencion1  = trim($_POST['autretencion1']);

$archivo        = trim($_POST['autretencion1']);

$clave          = trim($_POST['clave']);

$firma          = trim($_POST['firma']);

$ambiente       = trim($_POST['ambiente']);


$clave         = base64_decode(trim($clave));

$ruta          = 'https://g-kaipi.cloud/EP-Const/facturae/xml/';

echo $autretencion1;
 

$echo = true; // solo para ver los procesos

$file_signed    = $ruta.$autretencion1.'_F.xml';
$archivo_signed = 'xml/'.$autretencion1.'_F.xml';

$file_to_sign    =  $ruta.$autretencion1.'.xml';
$archivo_to_sign =  'xml/'.$autretencion1.'.xml';

//------------------------------
$ch = curl_init($file_signed);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

$output = curl_exec($ch);

//Guardamos la imagen en un archivo
$fh = fopen($archivo_signed , 'w');
fwrite($fh, $output);
fclose($fh);
//------------------------------
$ch = curl_init($file_to_sign);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

$output = curl_exec($ch);

 

//Guardamos la imagen en un archivo
$fh = fopen($archivo_to_sign , 'w');
fwrite($fh, $output);
fclose($fh);
//------------------------------


 

$ruta  ='';

$envio = 'N' ;

// A veces el internet esta lento y toma mas de 30 segundos el ws del SRI, se puede mejorar
ini_set('max_execution_time', 300);


require_once("./FirmaXades/FirmaElectronicaNativa.php");

// $ruta = dirname(__file__);

$ruta ='xml/';


if ( $envio == 'S') {
    $FacturaElectronica = 'Comprobante electronico autorizado';
}
else {
    
    $echo = true; // solo para ver los procesos
    // Este config es opcional, se puede manejar los argumentos directo de cada funcion
    $config=array(
        'pass_p12'		=>$clave,
        'file_p12'		=>$ruta.'firmas/'.$firma,
        'access_key'	=>trim($archivo), // la clave de acceso es necesaria para la autorizacion
        'file_to_sign'	=>$ruta.''.$archivo.'.xml',
        'file_signed'	=>$ruta.''.$archivo.'_F.xml',
        'file_autorized'=>$ruta.''.$archivo.'_A.xml'
    );
    // NOTA: las funciones estan seccionadas por procesos, osea se debe llevar control del estado del documento,
    // Ejemplo: si se envio pero quedo pendiente la autorizacion solo se tendria que volver a autorizar, etc.
    
    
    try{
        
        $signer=new FirmaElectronica($config); // Instancio la clase
        // Arg1 true=Links Online, false= Links Offline
        // Arg2 true=Produccion, false=development
        
        if ( $ambiente == '1') {
            $signer->setProduction(false); // IMPORTANTE: setear el ambiente, por default PRUEBAS
        }else {
            $signer->setProduction(true);
        }
        
   
     //  FIRMADO DEL XML  
        //NOTA: sendToSign(); usa el WS de firmado gratuito de EN Systems
        if(!$signer->isKeyActive())
            if(!$signer->setKey($config['file_p12'],$config['pass_p12']))
                throw new Exception("No se pudo leer la firma digital entro aqui "); // error al firmar
                
                $signatured = $signer->signXmlPem(); // no lleva argumentos, xq ya los cogio del config
                
                if($signatured['success']==false)
                    throw new Exception("Error al Firmar el XML: ".$signatured['message']); // error al firmar
                    if($echo)  $FacturaElectronica.=  ' XML Signature-> Correctamente  ';
                    
                    
                    
                    //NOTA: Funciona con cualquier documento electronico mientras el XSD exista en la ruta, con el nombre de acuerdo al formato
                    $xsd_validation = $signer->validaXml(); // no lleva argumentos, xq ya los cogio del config
                    if($xsd_validation['success']==false)
                        throw new Exception($xsd_validation['message']); // error validando xsd
                        if($echo) $FacturaElectronica = 'XSD Validation-> <b>Correctamente</b>!</br>';
                        
                        // ENVIO AL SRI 
                        $sri_send = $signer->sendToSri(); // no lleva argumentos, xq ya los cogio del config
                        if($sri_send['success']==false)
                            throw new Exception($sri_send['message'].(isset($sri_send['informacionAdicional'])?' - '.$sri_send['informacionAdicional']:'')); // error envio SRI
                            if($echo) $FacturaElectronica .= 'SRI Sending ----> <b>Correctamente</b>!</br>';
                            
                            /// AUTORIZACION DEL SRI  
                            $sri_aut = $signer->autorizarSri(); // no lleva argumentos, xq ya los cogio del config
                            if($sri_aut['success']==false)
                                throw new Exception($sri_aut['message'].(isset($sri_aut['informacionAdicional'])?' - '.$sri_aut['informacionAdicional']:'')); // error autorizacion SRI
                                if($echo) $FacturaElectronica .= "SRI Autorizat. --> <b>Correctamente</b> [Aut.Num.: <u>{$sri_aut['numeroAutorizacion']}</u>]!</br>";
                               
                                $FacturaElectronica =  "OK SRI Autorizat. --> Correctamente [Aut.Num.:  {$sri_aut['numeroAutorizacion']} ]! ";
                                
                                if($echo) $FacturaElectronica .= '<br/><b>termino correctamente!.</b>';
                                else{
                                    header("Content-Type: application/xml; charset=utf-8");
                                    echo $sri_aut['xml'];
                                }
    }catch (Exception $e) {
        $FacturaElectronica .= ' EJECUTAR EL SCRIPT ';
        $FacturaElectronica .=  '<b>Excepcion Capturada[ '. $e->getMessage(). "] " . $ambiente;
    }
    
}
 
 echo $FacturaElectronica;

 
?>