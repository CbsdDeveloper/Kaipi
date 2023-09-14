<?php
     session_start( );
 
require '../../kconfig/PHPMailer/class.phpmailer.php';
require '../../kconfig/PHPMailer/class.smtp.php';


 
 $To = 'jasapas@hotmail.com';
$Subject = 'Topic';
$Message = 'msg test';

$Host = 'mail.tce.gob.ec';
$Username = 'roberto.vicuna@tce.gob.ec';
$Password = 'RV1_2022';
$Port = "587";

$mail = new PHPMailer();
$body = $Message;
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host = $Host; // SMTP server
$mail->SMTPDebug = 1; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
$mail->SMTPAuth = true; // enable SMTP authentication
//$mail->SMTPSecure = 'ssl'; //or tsl -> switched off
$mail->Port = $Port; // set the SMTP port for the service server
$mail->Username = $Username; // account username
$mail->Password = $Password; // account password

$mail->SetFrom($Username);
$mail->Subject = $Subject;
$mail->MsgHTML($Message);
$mail->AddAddress($To);

if(!$mail->Send()) {
    $mensagemRetorno = 'Error: '. print($mail->ErrorInfo);
    echo $mensagemRetorno;
} else {
    $mensagemRetorno = 'E-mail sent!';
    echo $mensagemRetorno;
}


     
     /*
     require '../../kconfig/Db.class.php';    
     require '../../kconfig/Obj.conf.php';  
     require '../../kconfig/Db.emailMarket.php'; 
     
     $obj   = 	new objects;
     $bd	   =	new Db;
     
 
         
 
     $mail  =	new EmailEnvio;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
     $mail->_DBconexion( $obj, $bd );
     
     $mail->_smtp_correo_notificacion( );

     
     echo  'dsdsd';
     
    // $mail->_smtp_factura_electronica( );
    
     $asunto = 'SALUDPS EMAPA';
     $content = 'SALUDPS EMAPA';
     
 
        
      
             $mail->_DeCRM( 'jasapas@hotmail.com', 'Tics EPMAPA-SD');
 
         
         $mail->_ParaCRM('jasapas@hotmail.com', 'hola');
     
         $mail->_AsuntoCRM($asunto,$content );
         
         
        $response = $mail->_EnviarElectronica();
  
 
     
       echo $response;
     */
     
      
?>
 
  