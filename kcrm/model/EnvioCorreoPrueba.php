<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Db.emailMarket.php'; 

$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$mail  =	new EmailEnvio;


$email_notifica = 'jasapas@hotmail.com' ;
$nombre_notifica = 'jose';
$asunto = 'hola prueba de correos';
$content = 'xxx';



$mail->_DBconexion( $obj, $bd );

$mail->_smtp_factura_electronica( );

$sesion 	   =  trim($_SESSION['email']);
 
 
$mail->_AsuntoCRM($asunto,$content );

                
                $mail->_DeCRM( $sesion, $_SESSION['razon']);
                
                
                $mail->_ParaCRM($email_notifica,$nombre_notifica);
                
                 
                $mail->_CopiaCRM('jasapas77@gmail.com' , 'Jose');
                
                 
                
                $response = $mail->_EnviarElectronica();
                
  
                echo $response;
 

   
 




 
?>
 
  