<?php
session_start();
date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");


require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
$id          = $_GET['id'];
$ruc         = $_SESSION['ruc_registro'];


$Array_Cabecera = $bd->query_array(
    'co_compras',
    'codigoe,secretencion1, autretencion1,transaccion',
    'id_compras ='.$bd->sqlvalue_inyeccion($id,true)
    );

//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso',
    'ruc_registro='.$bd->sqlvalue_inyeccion( trim($ruc),true)
    );

$archivo    = trim($Array_Cabecera['autretencion1']);
$clave      = base64_decode(trim($ADatos['acceso']));
$ambiente   = trim($ADatos['ambiente']);
$firma      = trim($ADatos['firma']);

$envio = trim($Array_Cabecera['transaccion']) ;

// A veces el internet esta lento y toma mas de 30 segundos el ws del SRI, se puede mejorar
ini_set('max_execution_time', 300); 
 
 
require_once("./FirmaXades20/FirmaElectronicaNativa.php");


$ruta_firma       =  $bd->_url_externo(74); // ruta xml 
$ruta_xml         =  $bd->_url_externo(72); // ruta xml 

$ruta_firma = '';

$ruta_xml = 'xml/';

if ( $envio == 'E') {
    $FacturaElectronica = 'Comprobante electronico autorizado';
}
else {

$echo = true; // solo para ver los procesos
// Este config es opcional, se puede manejar los argumentos directo de cada funcion
 
 
$config=array(
    'access_key'	=>trim($archivo), // la clave de acceso es necesaria para la autorizacion
    'pass_p12'		=>$clave,
    'file_p12'		=>$ruta_firma.'firmas/'.$firma,
    'file_to_sign'	=>$ruta_xml.$archivo.'.xml',
    'file_signed'	=>$ruta_xml.$archivo.'_F.xml',
    'file_autorized'=>$ruta_xml.$archivo.'_A.xml'
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
    
     
     
     if(!$signer->isKeyActive())
         if(!$signer->setKey($config['file_p12'],$config['pass_p12']))
             throw new Exception("No se pudo leer la firma digital "); // error al leer la firma, password equivocada, archivo da<C3><B1>ado o inexistente
             
             $signatured = $signer->signXmlPem(); // no lleva argumentos, xq ya los cogio del config
             if($signatured['success']==false)
                 throw new Exception("Error al Firmar el XML: ".$signatured['message']); // error al firmar
                 if($echo) echo 'XML Signature-> <b>Correctamente</b>!</br>';
                 
                 //* VALIDACION XML CON XSD
                 //NOTA: Funciona con cualquier documento electronico mientras el XSD exista en la ruta, con el nombre de acuerdo al formato
                 $xsd_validation = $signer->validaXml(); // no lleva argumentos, xq ya los cogio del config
                 if($xsd_validation['success']==false)
                     throw new Exception($xsd_validation['message']); // error validando xsd
                     if($echo) echo 'XSD Validation-> <b>Correctamente</b>!</br>';
                     
                     // ENVIO AL SRI
                     $sri_send = $signer->sendToSri(); // no lleva argumentos, xq ya los cogio del config
                     if($sri_send['success']==false)
                         throw new Exception($sri_send['message'].(isset($sri_send['informacionAdicional'])?' - '.$sri_send['informacionAdicional']:'')); // error envio SRI
                         if($echo) echo 'SRI Sending ----> <b>Correctamente</b>!</br>';
                         
                         // AUTORIZACION DEL SRI
                         // ESPERAMOS 2 SEGUNDOS ANTES DE OBTENER LA AUTORIZACIÓN DEL SRI
                         sleep(2);
                         $sri_aut = $signer->autorizarSri(); // no lleva argumentos, xq ya los cogio del config
                         if($sri_aut['success']==false)
                             throw new Exception($sri_aut['message'].(isset($sri_aut['informacionAdicional'])?' - '.$sri_aut['informacionAdicional']:'')); // error autorizacion SRI
                             if($echo) echo "SRI Autorizat. --> <b>Correctamente</b> [Aut.Num.: <u>{$sri_aut['numeroAutorizacion']}</u>] [Aut.Fec.: <u>{$sri_aut['fechaAutorizacion']}</u>]!!</br>";
                             
                             if($echo) echo  $bandera = 1;
                             else{
                                 header("Content-Type: application/xml; charset=utf-8");
                                 echo $sri_aut['xml'];
                             }
                             
                             if ($bandera == 1){
                                 
                                 $sql = "UPDATE co_compras
                						                    SET 	codigoe=".$bd->sqlvalue_inyeccion(1, true).",
                                                                    transaccion=".$bd->sqlvalue_inyeccion('E', true)."
                 						                  WHERE id_compras=".$bd->sqlvalue_inyeccion($id, true);
                                 
                                 $bd->ejecutar($sql);
                             }
                                     
                                     
        }catch(Exception $e){
            echo '<br/><b>ERROR AL EJECUTAR EL SCRIPT</b><br/>';
            echo '<b>Excepción Capturada[</b> ',  $e->getMessage(), "]\n";
            $sql = "UPDATE co_compras
            SET 	codigoe=".$bd->sqlvalue_inyeccion(0, true).",
                    transaccion=".$bd->sqlvalue_inyeccion('', true)."
                  WHERE id_compras=".$bd->sqlvalue_inyeccion($id, true);
            
            $bd->ejecutar($sql);
        }
     
}
     
 
      

echo $FacturaElectronica;
 
?>