<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	     = new Db ;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

    
    require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
    
    $mail  =	new EmailEnvio;
    
    $sesion 	    =  trim($_SESSION['email']);
    
    
    $mail->_DBconexion( $obj, $bd );
    
    
    $mail->_smtp_factura_electronica( );
    
    
    
    $idtramite	=	$_GET["idtramite"];
    $solicita	=	$_GET["solicita"];
 
    
    $avalida = $bd->query_array('co_control',
        'fecha, detalle, motivo, idtramite, sesion, msesion, fmodificacion, estado, tipo',
        'idtramite='.$bd->sqlvalue_inyeccion($idtramite,true)
        );
 
    
    $de = $bd->query_array('par_usuario','completo', 'email='.$bd->sqlvalue_inyeccion($sesion,true));
    
    $razon_social   = $de['completo'] ;
    
      
    
    $plantilla = $bd->query_array(
        'ven_plantilla',
        'contenido,   variable',
        'id_plantilla='.$bd->sqlvalue_inyeccion(-5,true)
        );
    
    
    $apara = $bd->query_array('par_usuario','completo', 'email='.$bd->sqlvalue_inyeccion($solicita,true));
    
    
    $content =  str_replace ( '#NOMBRE' , trim($apara['completo']) ,  $plantilla['contenido']);
    
     
    
    
    $content =  str_replace ( '#CASO' , trim($idtramite) ,  $content);
    
    $DETALLE = $avalida["detalle"].' <br>'.$avalida["motivo"]; 
    
    $content =  str_replace ( '#DETALLE' ,  $DETALLE,  $content);
    
    $USUARIO = $sesion.' '.$razon_social;
    
    $content =  str_replace ( '#USUARIO' , $USUARIO ,  $content);
    
    $FECHA = date('y-m-d');
    $content =  str_replace ( '#FECHA' , $FECHA ,  $content);
    
    $asunto = 'Notificacion de Control Previo del tramite '.$idtramite;
    
    
    
    
    $mail->_DeCRM( $sesion, $razon_social);
    
    $nombre_de =  $apara['completo'];
    $correo_de =  trim($solicita);
    
    $mail->_ParaCRM($correo_de,$nombre_de);
    
    
    $mail->_AsuntoCRM($asunto,$content );
    
    
    $response = $mail->_EnviarElectronica();
    
    
    
    echo $response;
    
 

?>
 
  