<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   =	new Db;
$mail  =	new EmailEnvio;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$sesion 	   =  trim($_SESSION['email']);

$ruc           =  $_SESSION['ruc_registro'];

$razon_social  = $_SESSION['razon'] ;

$mail->_DBconexion( $obj, $bd );

$mail->_smtp_factura_electronica( );

$response = '';

$Contenido = $bd->query_array(
    'ven_plantilla',
    'contenido,   variable',
    'id_plantilla='.$bd->sqlvalue_inyeccion(0,true)
    );


$url = $bd->query_array(
    'web_registro',
    'web,felectronica,smtp,carpeta',
    'ruc_registro='.$bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']),true)
    );




if (trim($url['felectronica']) == 'S'){
               
              
            $sql = "SELECT id_movimiento,  comprobante,  idprov,   autorizacion,fecha
                        FROM  inv_movimiento
                        where
                                registro   = ".$bd->sqlvalue_inyeccion( $ruc ,true)." and
                                envio      = ".$bd->sqlvalue_inyeccion( 'S' ,true)." and
                                idprov    <> ".$bd->sqlvalue_inyeccion( '9999999999999'  ,true)." and
                                autorizacion is not null  and
                                transaccion   = ".$bd->sqlvalue_inyeccion('E'  ,true)." and
                                estado    = ".$bd->sqlvalue_inyeccion('aprobado',true)." 
                        order by id_movimiento desc 
                        limit 1";
            
            
            
              $stmt = $bd->ejecutar($sql);
                                
                                
                                while ($fila=$bd->obtener_fila($stmt)){
                                    
                                    $id_movimiento   = $fila['id_movimiento'];
                                    
                                    $idprov          = $fila['idprov'];
                                    
                                    $x = $bd->query_array(
                                        'par_ciu',
                                        'idprov, razon,  correo ',
                                        'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true)
                                        );
                                       
                                    
                                    //------------------------------------------------------------------  
                                    $asunto = 'Comprobante Electronico '.$idprov.'-'.$fila['comprobante'];
                                    
                                    $content =  str_replace ( '#PROVEEDOR' , trim($x['razon']) ,  $Contenido['contenido']);
                                    
                                    $content =  str_replace ( '#IDENTIFICACION' , trim($idprov) ,  $content);
                                     
                                    $content =  str_replace ( '#FECHA' , trim($fila['fecha']) ,  $content);
                                    
                                    $content =  str_replace ( '#FACTURA' , trim($fila['comprobante']) ,  $content);
                                     
                                    $content =  str_replace ( '#AUTORIZACION' , trim($fila['autorizacion']) ,  $content);
                       
                                    $content =  str_replace ( '#EMPRESA' , trim($razon_social) ,  $content);
                                    
                                    // #pdf base64_decode
                        
                                    $xml     = trim($fila['autorizacion']) ;
                                    
                                    $imagen  =  trim( $url['carpeta'] );
                                    
                                    $pa = base64_encode($imagen) ;
                                    
                                    $enlace = trim($url['smtp']).'ride/RideComprobante?xml='.$xml.'&file='.$pa;
                                    
                                    $content =  str_replace ( '#pdf' , trim($enlace) ,  $content);
                                    
                                    $enlace = trim($url['smtp']).'ride/downloadXml?xml='.$xml  ;
                                    
                                    $content =  str_replace ( '#xml' , trim($enlace) ,  $content);
                                    
                                    
                                    //-----------------------------------------------------------
                                    
                                    $mail->_DeCRM( $sesion, $_SESSION['razon']);
                                    
                                    $mail->_ParaCRM(trim($x['correo']),trim($x['razon']));
                                    
                                    
                                    $mail->_AsuntoCRM($asunto,$content );
                                    
                                     
                                    $response = $mail->_EnviarElectronica();
                                    
                                   
                                    $sqlEdit = "update inv_movimiento
                                                  set transaccion  =".$bd->sqlvalue_inyeccion( 'X',true)."
                                                where    id_movimiento= ".$bd->sqlvalue_inyeccion($id_movimiento,true) ;
                           
                                    $bd->ejecutar($sqlEdit);
                                    
                                }
             

  } 
                  

echo $response;

 
?>
 
  