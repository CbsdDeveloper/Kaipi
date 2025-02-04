<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.email.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;
$mail  =	new EmailEnvio;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

$contenido   =  trim($_POST['detalle']);
$arrayNombre =  explode('-',$contenido);
 

$asunto = 'Recordatorio agenda '. rtrim(ltrim($_POST['fecha']));





$sesion 	   =  $_SESSION['email'];
$sesion_nombre = _usuario( $sesion,$bd  ) ;


 $para 	      = _usuario_login(trim($arrayNombre['0']),$bd );
 $para_nombre = _usuario( $para,$bd  ) ;
 
 $mensaje_adicional = '<br><br><br><br><br><br><hr>
                    <span style="color: #6A6A6A;align-items: center;font-size: 10px">Te enviamos este email informativo como parte de tu membresia a la plataforma.<br>
                     No respondas a este email, ya que no podemos contestarte desde esta direccion.<br>
                    Si necesitas ayuda o deseas contactarnos, visita nuestro Centro de ayuda.</span>';     
 
 
 
 $content =  'Estimado '.$para_nombre.'<br><br>'.  
             'Ud tiene un recordatorio que cumplir segun su agenda <br> '. 
             $arrayNombre[1]. ' '.rtrim(ltrim($_POST['fecha'])).'<br><img src="http://www.g-kaipi.com/kaipi/kimages/relojwk.png"/>'.
             $mensaje_adicional;
 

        
             
if (!empty($content)){
    
    
    
    $mail->_DeCRM( $sesion,$sesion_nombre);
    
    $mail->_ParaCRM($para,$para_nombre);
    
    $mail->_AsuntoCRM($asunto,$content );
    
      
     $mensaje_enviado = $mail->_Enviar();
    
   // agregar_email($bd,$asunto,$content,$sesion,$idtransaccion,$para );
    
  
    
    echo $mensaje_enviado;
 
    
}
//-------------------------------------------
//--------------------------------------------
function agregar_email($bd,$asunto,$content	,$sesion,$idtransaccion,$para ) {
    
    
    $fecha  = date("Y-m-d");
    
    
    $﻿ATabla = array(
        array( campo => 'idven_email',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idvengestion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idtransaccion, key => 'N'),
        array( campo => 'estado',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '0', key => 'N'),
        array( campo => 'asunto',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $asunto, key => 'N'),
        array( campo => 'de',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
        array( campo => 'para',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $para, key => 'N'),
        array( campo => 'texto',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $content, key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $fecha, key => 'N'),
    );
    
    $bd->_InsertSQL('ven_cliente_email',$﻿ATabla,'ven_cliente_email_idven_email_seq');
    
}
//--------------------------------------------
function _usuario( $sesion,$bd  ) {
    
    $Ausuario = $bd->query_array( 'par_usuario',
        'completo',
        'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
        );
    
    return $Ausuario['completo'];
    
}

//--------------------------------------------
function _usuario_login( $login,$bd  ) {
    
    $Ausuario = $bd->query_array( 'par_usuario',
        'email',
        'login='.$bd->sqlvalue_inyeccion(trim($login),true)
        );
    
    return $Ausuario['email'];
    
}


?>
 
  