<?php
session_start( );

require_once('PHPMailer/class.phpmailer.php');


require_once('PHPMailer/class.smtp.php');



class EmailEnvio{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    
    private $mail;
  
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function EmailEnvio( ){
         
        
        $this->mail = new PHPMailer();
        //indico a la clase que use SMTP
        $this->mail->IsSMTP();
        //permite modo debug para ver mensajes de las cosas que van ocurriendo
        $this->mail->SMTPDebug = 0;
        //Debo de hacer autenticaci�n SMTP
        $this->mail->SMTPAuth   = true;
        
        $this->mail->SMTPSecure = "ssl";
        
        //indico el servidor de Gmail para SMTP
        $this->mail->Host       = "smtp.gmail.com";
        
        $this->mail->Port 	    = 465; 
        
        
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $this->mail->Username = "no-replay@cbsd.gob.ec";
        $this->mail->Password = "ZUu3YyLLLvv";
        
     
    }
     //-----------------------------------------------------------------------------------------------------------
    function _DeCRM($email,$nombre){
 
        
        $this->mail->SetFrom   ($email, $nombre.' - CRMPymes');
   //     $this->mail->AddReplyTo($email, $nombre.' - CRMPymes');
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
   
    //-----------------------------------------------------------------------------------------------------------
    function _ParaCRM( $email,$nombre ){
      
      
        $this->mail->AddAddress($email,$nombre);
 
        
    }
    //--------------------------------------------------------------------------------
    function _AsuntoCRM($asunto,$mensaje ){
        
        $this->mail->Subject = utf8_decode($asunto);
        
        //  html_entity_decode(htmlspecialchars($contenido['contenido']));
        
        $this->mail->MsgHTML( ($mensaje));
        
    }
 
//--------------------------------------------------------------------------------
function _Enviar(  ){
    
    if(! $this->mail->Send()) {
        
        return "Error al enviar: " . $this->mail->ErrorInfo;
        
    } else {
        
        return " <h6><b> Mensaje Enviado </b></h6>";
        
    }
 //------------------
    function _DBconexion( $obj, $bd ){
        
        $this->obj     = 	$obj;
        $this->bd	   =	$bd ;
    }
  
    
}
     
    //--------------------------------------------------------------------------------
  }
 



?>
 
  