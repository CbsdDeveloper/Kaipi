<?php
function envio_tramite($bd, $obj,$id_rol1 ,$regimen,$sesion_asigna){
 
require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/

$mail  =	new EmailEnvio;

$sesion 	    =  trim($_SESSION['email']);


$de = $bd->query_array('par_usuario','completo', 'email='.$bd->sqlvalue_inyeccion($sesion,true));

$razon_social   = $de['completo'] ;


 

$mail->_DBconexion( $obj, $bd );


$mail->_smtp_factura_electronica( );
 


$plantilla = $bd->query_array(
    'ven_plantilla',
    'contenido,   variable',
    'id_plantilla='.$bd->sqlvalue_inyeccion(-4,true)
    );

 
$apara = $bd->query_array('par_usuario','completo', 'email='.$bd->sqlvalue_inyeccion($sesion_asigna,true));
 

$content =  str_replace ( '#NOMBRE' , trim($apara['completo']) ,  $plantilla['contenido']);

 

$periodo = 'GENERACION DE ROLES DE NOMINA REFERENCIA '.$id_rol1. ' DEL REGIMEN '. $regimen ;

$content =  str_replace ( '#CASO' , trim($periodo) ,  $content);

$DETALLE = "Solicitud de emision de certificacion presupuestaria para la emision de roles de pago del regimen ".$regimen;
$content =  str_replace ( '#DETALLE' ,  $DETALLE,  $content);

$USUARIO = $sesion.' '.$razon_social;
$content =  str_replace ( '#USUARIO' , $USUARIO ,  $content);
 
$FECHA = date('y-m-d');
$content =  str_replace ( '#FECHA' , $FECHA ,  $content);

$asunto = 'Solicitud de requerimiento de certificacion para el pago de roles de nomina';

 


$mail->_DeCRM( $sesion, $razon_social);

$nombre_de =  $apara['completo'];
$correo_de =  trim($sesion_asigna);

$mail->_ParaCRM($correo_de,$nombre_de);


$mail->_AsuntoCRM($asunto,$content );


$response = $mail->_EnviarElectronica();



echo $response;
 
}

?>
 
  