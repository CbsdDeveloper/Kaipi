<?php
session_start( );

require_once('PHPMailer/class.phpmailer.php');

require_once('PHPMailer/class.smtp.php');

class EmailEnvio{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    
    private $mail;
  
    private $tipo_enlace;
    
    
    private $email_envio;
    private $puerto;
    private $clave;
    private $Host;
    private $SMTPSecure;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function EmailEnvio( ){
         
        date_default_timezone_set('Etc/UTC');
        
        $this->mail         = new PHPMailer();
      
        $this->tipo_enlace  = 0;  // 1 gmail  0 propio
     
    }
  
    //-----------------------------------------------------------------------------------------------------------
    function WebEnvio( ){
        
            $Smpt = $this->bd->query_array( 'web_registro',  '*',   'tipo='.$this->bd->sqlvalue_inyeccion('principal',true)    );
            
            return trim($Smpt['web']);
    
   
    }
    //-------------------------------------
    function EmailEnvioAdmin( ){
         
        
        $this->mail->SMTPSecure =    $this->SMTPSecure;
        $this->mail->Host       =    $this->Host ;
        $this->mail->Port 	    =    $this->puerto ;
        
        
        if (  $this->tipo_enlace == 1 ){
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
         }
          
        
         $this->mail->Username =   $this->email_envio;
         $this->mail->Password =   $this->clave ;
        
        
    }
    //-------------------------------------
    function _smtp( $email_envio  ){
        
     
        $this->mail->IsSMTP();
        //permite modo debug para ver mensajes de las cosas que van ocurriendo
        $this->mail->SMTPDebug = 2;
        //Debo de hacer autenticaci�n SMTP
        $this->mail->SMTPAuth   = true;
         
        if ( trim($email_envio) == '-')  {
             
            if (  $this->tipo_enlace == 1 ){
                $this->mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }
            $this->mail->SMTPSecure  =  $this->SMTPSecure;
            $this->mail->Host        =  $this->Host  ;
            $this->mail->Port 	     =  $this->puerto;
            $this->mail->Username    =  $this->email_envio;
            $this->mail->Password    =  $this->clave ;
         }
         else {
             
             $Smpt = $this->bd->query_array( 'view_ventas_correo',
                 'smtp1, puerto1, acceso1',
                 'email='.$this->bd->sqlvalue_inyeccion(trim($email_envio),true)
                 );
             
             //indico el servidor de Gmail para SMTP
              if (trim($Smpt['puerto1']) == '993') {
                 $this->mail->SMTPSecure = "tls";
             }else{
                 $this->mail->SMTPSecure = "ssl";
             }
              
             if (  $this->tipo_enlace == 1 ){
                 $this->mail->SMTPOptions = array(
                     'ssl' => array(
                         'verify_peer' => false,
                         'verify_peer_name' => false,
                         'allow_self_signed' => true
                     )
                 );
             }
             $this->mail->Host       = trim($Smpt['smtp1']);
             $this->mail->Port 	     = trim($Smpt['puerto1']);
             $this->mail->Username =  trim($email_envio);
             $this->mail->Password =  base64_decode(trim($Smpt['acceso1']));
             
             
         }
 
    }
  //--------------------
  //-----------------------
    function _smtp_factura_electronica(   ){
        

        $this->mail->IsSMTP();
        
        $this->mail->IsHTML(true);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->setLanguage('es');
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug  = 0; // 0 = no debug || 3 = debug con mensajes
        // Configurar parámetros de correo
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        // $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $this->mail->Host = 'mail.cbsd.gob.ec';
        $this->mail->Port = '587';
        $this->mail->Username = 'no-replay@cbsd.gob.ec';
        $this->mail->Password = 'ZUu3YyLLLvv';
        // Parámetros de remitente
        $this->mail->FromName = 'Cuerpo de Bomberos Santo Domingo | Notificaciones';
        $this->mail->From = 'no-replay@cbsd.gob.ec';

        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
         
         
    }
    //-------------------------
    function _smtp_correo_notificacion(   ){
        
        
        $this->mail->IsSMTP(); // Indicamos que vamos a utilizar SMTP
        $this->mail->Host = 'smtp.mandrillapp.com'; // El Host de Mandrill
        $this->mail->Port = 587;  // El puerto que Mandrill nos indica utilizar
        $this->mail->SMTPAuth = true; // Indicamos que vamos a utilizar auteticaci�n SMTP
        $this->mail->Username = 'jasapas77@gmail.com'; // Nuestro usuario en Mandrill
        $this->mail->Password = 'ecf2257ba0e98f0b1525b36bf77a30bf-us10'; // Key generado por Mandrill
        $this->mail->SMTPSecure = 'tls'; // Activamos el cifrado tls (tambi�n ssl)
        
 
        
    }
    //-------------------------
    function _smtp_factura_soporte(   ){
        
        
        $x = $this->bd->query_array(
            'web_registro',
            'email,puerto',
            'ruc_registro='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']),true)
            );
        
        $this->mail->IsSMTP();
        //permite modo debug para ver mensajes de las cosas que van ocurriendo
        
        $this->mail->SMTPDebug = 0;
        //Debo de hacer autenticaci�n SMTP
        
        $clave =   trim($x['puerto']);
         
        $this->mail->SMTPAuth   = true;
        $this->mail->SMTPSecure = "ssl";
        $this->mail->Host       = "smtp.gmail.com";
        $this->mail->Port 	    = 465;
        
        
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $clave = "Barce$.J2014.1977@EmailUser";
        $this->mail->Username = trim($x['email']);
        $this->mail->Password =  $clave;
        
  }
    //-------
    function _smtp_tramites( ){
          
             
        if ( $this->tipo_enlace  == 1 ){
            
            $this->mail->IsSMTP();
            $this->mail->SMTPDebug   =  0;
            $this->mail->Host        =  $this->Host ;
            $this->mail->Port 	     =  $this->puerto;
            $this->mail->SMTPAuth    = true;
            $this->mail->SMTPSecure  =  $this->SMTPSecure;
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $this->mail->Username   =  $this->email_envio;
            $this->mail->Password   =  $this->clave ;
        }
        else
        {
            $this->mail->SMTPDebug   =  2;
            $this->mail->IsSMTP(); // Indicamos que vamos a utilizar SMTP
            $this->mail->Host       =  $this->Host ;
            $this->mail->Port       =  $this->puerto ;
            $this->mail->SMTPAuth   =  true; // Indicamos que vamos a utilizar auteticaci�n SMTP
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $this->mail->SMTPSecure =  $this->SMTPSecure;
            $this->mail->Username   =  $this->email_envio;
            $this->mail->Password   =  $this->clave ;
        }
 
        
    }
   
    
    //-------------------------------------
    function _smtp_email( $tipo_envio  ){
        
        
        if ( $this->tipo_enlace  == 1 ){
            $this->mail->IsSMTP();
            $this->mail->SMTPDebug   =  0;
            $this->mail->Host        =  $this->Host ;
            $this->mail->Port 	     =  $this->puerto;
            $this->mail->SMTPAuth    = true;
            $this->mail->SMTPSecure  =  $this->SMTPSecure;
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $this->mail->Username   =  $this->email_envio;
            $this->mail->Password   =  $this->clave ;
        }
        else
        {
            $this->mail->IsSMTP(); // Indicamos que vamos a utilizar SMTP
            $this->mail->Host       =  $this->Host ;
            $this->mail->Port       =  $this->puerto ;
            $this->mail->SMTPAuth   =  true; // Indicamos que vamos a utilizar auteticaci�n SMTP
            $this->mail->SMTPSecure =  $this->SMTPSecure;
            $this->mail->Username   =  $this->email_envio;
            $this->mail->Password   =  $this->clave ;
        }
        
        
    }
      //-----------------------------------------------------------------------------------------------------------
    function _DeCRM($email,$nombre){
 
         
        $this->mail->From     = $email;
        $this->mail->FromName = $nombre;
        
    }
    //-----------------------------------------------------------------------------------------------------------
    function _adjuntar($nombre,$url){
        
         // $url = 'https://www.miweb.com/uploads/archivo.pdf';  
        
        $fichero = file_get_contents($url); //Aqui guardas el archivo temporalmente.
        
        $this->mail->addStringAttachment($fichero, $nombre);
        
        
        
        
    }
    //----------------------------------------
   
    //-----------------------------------------------------------------------------------------------------------
    function _ParaCRM( $email,$nombre ){
      
        
        $this->mail->AddAddress($email,$nombre);
 
 
        
        
    }
    
    function _CopiaCRM( $email,$nombre ){
        
     
        
        $this->mail->AddCC($email, $nombre);
        
        
        
    }
    //----------------
    function Sustituto_Cadena($rb){
        ## Sustituyo caracteres en la cadena final
        $rb = str_replace("�", "n", $rb);
        $rb = str_replace("�", "N", $rb);
        
        $rb = str_replace("á", "&aacute;", $rb);
        $rb = str_replace("é", "&eacute;", $rb);
        $rb = str_replace("®", "&reg;", $rb);
        $rb = str_replace("í", "&iacute;", $rb);
        $rb = str_replace("�", "&iacute;", $rb);
        $rb = str_replace("ó", "&oacute;", $rb);
        $rb = str_replace("ú", "&uacute;", $rb);
        $rb = str_replace("n~", "�", $rb);
        $rb = str_replace("º", "&ordm;", $rb);
        $rb = str_replace("ª", "&ordf;", $rb);
        $rb = str_replace("Ã¡", "&aacute;", $rb);
        $rb = str_replace("ñ", "&ntilde;", $rb);
        $rb = str_replace("Ñ", "&Ntilde;", $rb);
        $rb = str_replace("Ã±", "&ntilde;", $rb);
        $rb = str_replace("n~", "&ntilde;", $rb);
        $rb = str_replace("Ú", "&Uacute;", $rb); 
        return $rb;
    }  
    //--------------------------------------------
    function adjunto( $url,$nombre ){
        
        $this->mail->addAttachment($url,$nombre);
        
    }
  
    //--------------------------------------------------------------------------------
    function _AsuntoCRM($asunto,$mensaje ){
        
        $this->mail->IsHTML(true); // Indicamos que el email tiene formato HTML         
        
        
        $this->mail->Subject = utf8_decode($asunto);
         
         
         
        $this->mail->msgHTML( utf8_decode($mensaje));
        
   }
 
//--------------------------------------------------------------------------------
function _Enviar(  ){
    
    if(! $this->mail->Send()) {
        
        return "Error al enviar: " . $this->mail->ErrorInfo;
        
    } else {
        
        return " <h6><b> Mensaje Enviado </b></h6>";
        
    }
}
//--------------------------------------------------------------------------------
function _EnviarElectronica(  ){
    
    if(! $this->mail->Send()) {
        
        return "Error al enviar: OJO " . $this->mail->ErrorInfo;
        
    } else {
        
        return "<b> Mensaje Enviado </b>";
        
    }
}

//--------------------------------------------------------------------------------
    function _DBconexion( $obj, $bd ){
        
        $this->obj     = 	$obj;
        $this->bd	   =	$bd ;
        
        
        $x = $this->bd->query_array(
            'web_registro',
            'email,puerto,smtp',
            'ruc_registro='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']),true)
            );
       
            
                 
            $this->email_envio      = trim($x['email']);
            $this->puerto           = trim($x['smtp']);
            $this->clave            = base64_decode(trim($x['puerto']));
            
            // 1 gmail  0 propio)
            
            if ( $this->tipo_enlace  == 1 ){
                
                $this->Host         =  "smtp.gmail.com";
                $this->SMTPSecure   =  "ssl";
                $this->clave        =  'kvsboxklbufvjeae';
                
            }else{
                
                $this->email_envio  =  "no-replay@cbsd.gob.ec";
                $this->Host         =  "190.152.212.251";
                $this->SMTPSecure   =  'tls' ;
                $this->clave        =  "ZUu3YyLLLvv";
                $this->puerto       =  '587';
            }
 
            
          
              
         
        
    }
 
 
  }
