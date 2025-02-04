<?php
session_start( );

function proceso($obj,$bd,$idcaso,$email_notifica,$nombre_notifica){
    

require '../../kconfig/Db.emailMarket.php'; 

$mail  =	new EmailEnvio;


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$mail->_DBconexion( $obj, $bd );

$mail->_smtp_factura_electronica( );

$sesion 	   =  trim($_SESSION['email']);
 
$Contenido = $bd->query_array(
    'ven_plantilla',
    'contenido,   variable',
    'id_plantilla='.$bd->sqlvalue_inyeccion(-4,true)
    );


$url = $bd->query_array(
    'view_proceso_caso',
    ' nombre_solicita, movil_solicita, email_solicita, direccion_solicita,proceso,caso,fecha, fvencimiento, estado,dias_trascurrido,nombre,ambito',
    'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true)
    );
 
 
                   //------------------------------------------------------------------
$asunto = 'Notificacion Tramite '.$idcaso.'-'.$url['nombre_solicita'];


                
                $content =  str_replace ( '#NOMBRE' , trim($nombre_notifica) ,  $Contenido['contenido']);
                
                $content =  str_replace ( '#CASO' , $idcaso,  $content);
                
                $content =  str_replace ( '#FECHA' , trim($url['fecha']) ,  $content);
                
                $content =  str_replace ( '#PROCESO' , trim($url['proceso']) ,  $content);
                
                $content =  str_replace ( '#AMBITO' , trim($url['ambito']) ,  $content);
                
                $content =  str_replace ( '#DETALLE' ,trim($url['caso']) ,  $content);
                
                $content =  str_replace ( '#USUARIO' ,trim($url['nombre_solicita']) ,  $content);
                
                $content =  str_replace ( '#DIAS' ,trim($url['dias_trascurrido']) ,  $content);
  
                
                $mail->_DeCRM( $sesion, $_SESSION['razon']);
                
                $mail->_ParaCRM(trim($email_notifica),trim($nombre_notifica));
                
                
                $mail->_AsuntoCRM($asunto,$content );
                
                
                $response = $mail->_EnviarElectronica();
                
  
                echo $response;
 

   
}
 





 
?>
 
  