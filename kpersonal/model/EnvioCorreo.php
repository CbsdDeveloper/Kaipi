<?php
     session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
     
     $obj   = 	new objects;
     $bd	   =	new Db;
     
     
     try {
         
 
     $mail  =	new EmailEnvio;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
 
     
     
     $mail->_DBconexion( $obj, $bd );
     
//     $mail->_smtp_tramites_emapa( );
     
     $mail->_smtp_tramites( );
    
     $asunto = 'SALUDPS EMAPA';
     $content = 'SALUDPS EMAPA';
     
 
        
     //    $mail->_DeCRM( 'soporte@epmapasd.gob.ec', 'Tics EPMAPA-SD');
     
             $mail->_DeCRM( 'jasapas77@gmail.com', 'Tics EPMAPA-SD');
         
    //     $mail->_ParaCRM('k.community.team@gmail.com', 'hola');
         
         
         $mail->_ParaCRM('jasapas@hotmail.com', 'hola');
     
         $mail->_AsuntoCRM($asunto,$content );
         
         
        $response = $mail->_EnviarElectronica();
  
 
     
       echo $response;
     
     } catch (phpmailerException $e) {
         echo $e->errorMessage();
     }
      
?>
 
  