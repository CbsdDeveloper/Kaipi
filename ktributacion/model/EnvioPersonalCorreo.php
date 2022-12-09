<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   =	new Db;
$mail  =	new EmailEnvio;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$sesion 	    =  trim($_SESSION['email']);
$razon_social   =  $_SESSION['razon'] ;
$id             =  trim($_GET['id']) ;
$canio          =  $_GET['canio'];

 
$mail->_DBconexion( $obj, $bd );

$mail->_smtp_factura_soporte( );
 
$pagina_web = $mail->WebEnvio();


$plantilla = $bd->query_array(
    'ven_plantilla',
    'contenido,   variable',
    'id_plantilla='.$bd->sqlvalue_inyeccion(-2,true)
    );


$x = $bd->query_array(
    'nom_redep',
    '* ',
    'id_redep='.$bd->sqlvalue_inyeccion(trim($id),true)
    );

$cedula = trim($x['idret']);

$xx = $bd->query_array(
    'par_ciu',
    '* ',
    'idprov='.$bd->sqlvalue_inyeccion(trim($cedula),true)
    );

$persona =  trim($x['apellidotrab']).' '. trim($x['nombretrab']);

$content =  str_replace ( '#empleado' , $persona ,  $plantilla['contenido']);

$content =  str_replace ( '#empresa' , trim($razon_social) ,  $content);

$content =  str_replace ( '#periodo' , trim($canio) ,  $content);

$archivo_promo = $pagina_web.'kimages/avento.gif';

$imagen = $pagina_web.'kimages/'. trim($_SESSION['logo']) ;

$content =  str_replace ( 'http://localhost/gkaipi/kadmin/view/logo.png' , trim($imagen) ,  $content);

$content =  str_replace ( 'http://localhost/gkaipi/kadmin/view/promo1.png' , trim($archivo_promo) ,  $content);


$url_reporte = 'reportes/informe107e?us='.$_SESSION['us'].'&rd='. $_SESSION['ruc_registro'].'&db='.$_SESSION['db'].'&ac='.$_SESSION['ac'];

$enlace = $pagina_web.$url_reporte.'&i='.$id.'&r='.$canio;

$content =  str_replace ( '#enlace' , trim($enlace) ,  $content);
 
 
$asunto = 'Resumen '.$canio;



$mail->_DeCRM( $sesion, $_SESSION['razon']);

$mail->_ParaCRM(trim($xx['correo']),trim($xx['razon']));


$mail->_AsuntoCRM($asunto,$content );


$response = $mail->_EnviarElectronica();

 

echo $response;
 
?>
 
  