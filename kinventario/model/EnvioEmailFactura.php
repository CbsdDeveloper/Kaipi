<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$bd	   =	new Db;
$mail  =	new EmailEnvio;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$sesion 	   =  trim($_SESSION['email']);

$ruc           =  $_SESSION['ruc_registro'];


$mail->_DBconexion( $obj, $bd );

$mail->_smtp_factura_electronica( );

$razon_social  = $_SESSION['razon'] ;


$Contenido = $bd->query_array(
    'ven_plantilla',
    'contenido,   variable',
    'id_plantilla='.$bd->sqlvalue_inyeccion(0,true)
    );


$url = $bd->query_array(
    'web_registro',
    'web',
    'ruc_registro='.$bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']),true)
    );


$sql = "SELECT id_movimiento,  comprobante,  idprov,   autorizacion,fecha
            FROM  inv_movimiento
            where
                    registro   = ".$bd->sqlvalue_inyeccion( $ruc ,true)." and
                    envio      = ".$bd->sqlvalue_inyeccion( 'S' ,true)." and
                    idprov    <> ".$bd->sqlvalue_inyeccion( '9999999999999'  ,true)." and
                    autorizacion is not null  and
                    transaccion   = ".$bd->sqlvalue_inyeccion('E'  ,true)." and
                    estado    = ".$bd->sqlvalue_inyeccion('aprobado',true)."  and 
                    sesion    =".$bd->sqlvalue_inyeccion($sesion,true)." 
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
           
                        $xml = trim($fila['autorizacion']).'.xml' ;
                        
                        
                     //   $urlxml = trim($url['web']).'/facturae/xml/'.trim($fila['autorizacion']).'_A.xml';
                        
                   //    $urlxml = 'https://g-kaipi.com/kaipi/facturae/xml/0101201901189177543800110020010000002574924470813_A.xml';
                        
                  //     $mail->adjunto($urlxml,$xml);
                        
                        
                        $mail->_DeCRM( $sesion, $_SESSION['razon']);
                        
                        $mail->_ParaCRM(trim($x['correo']),trim($x['razon']));
                        
                        
                        $mail->_AsuntoCRM($asunto,$content );
                        
                         
                       $response = $mail->_EnviarElectronica();
                        
                       
                       $sqlEdit = "update inv_movimiento
                                      set transaccion  =".$bd->sqlvalue_inyeccion( 'X',true)."
                                    where    id_movimiento= ".$bd->sqlvalue_inyeccion($id_movimiento,true) ;
               
                       $bd->ejecutar($sqlEdit);
                        
                    }
 

              
                  

echo $response;




/*
 * 
 * 
 * 
 * 
 
    $sqlEdit = "update inv_movimiento
                                  set transaccion  =".$bd->sqlvalue_inyeccion( 'X',true)."
                                where    id_movimiento= ".$bd->sqlvalue_inyeccion($idvencliente,true) ;
        
        
        
        $bd->ejecutar($sqlEdit);
 
 
 * SELECT 
FROM  
where idprov  = '1000049476001'
//-----------------------------------------------------------------------

$ASesion = $bd->query_array(
    'par_usuario',
    'completo',
    'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
    );


$sesion_nombre 	   =  trim($ASesion['completo']);


$sql = "SELECT idvencliente,  razon,  correo,  proceso,  sesion,  id_campana
            FROM  ven_cliente
            where
                  proceso   = ".$bd->sqlvalue_inyeccion( 'enviar' ,true)." and
                  estado    = ".$bd->sqlvalue_inyeccion('2',true)." and
                  sesion    =".$bd->sqlvalue_inyeccion($sesion,true)." limit 1";



$stmt = $bd->ejecutar($sql);

//-----------------------------------------------------------------------

while ($fila=$bd->obtener_fila($stmt)){
    
    $id_campana   = $fila['id_campana'];
    $idvencliente = $fila['idvencliente'];
    
    
    $ACampana = $bd->query_array(
        'ven_campana',
        'publica,  titulo, tipo_envio, plantilla, fecha_email,asunto',
        'id_campana='.$bd->sqlvalue_inyeccion(trim($id_campana),true). ' and
                 estado='.$bd->sqlvalue_inyeccion('ejecucion',true)
        );
    
    $AContenido = $bd->query_array(
        'ven_plantilla',
        'contenido,   variable',
        'id_plantilla='.$bd->sqlvalue_inyeccion(trim($ACampana['plantilla']),true)
        );
    
    
    // Formulario   Suscribete    Mas informacion -----------------------------------------
    
    $APie = $bd->query_array(
        'ven_registro',
        'pie,variable_mas,suscribete,formulario,urlmensaje',
        'idven_registro=1');
    
    $url_enlace = trim($APie['urlmensaje']);
    
    $var_url = '?ca='.base64_encode($id_campana).'&te='.
        base64_encode($idvencliente).'&us='.
        $bd->_us().'&db='.
        $bd->_db().'&ac='.$bd->_ac();
        
        
        
        if (trim($AContenido['variable']) == 'Mas informacion'){
            $mensaje_sistema =  trim($APie['variable_mas']);
            $url = $url_enlace.'MasInformacion'.$var_url;
        }
        elseif(trim($AContenido['variable']) == 'Formulario'){
            $mensaje_sistema =  trim($APie['formulario']);
            $url = $url_enlace.'FormularioDatos'.$var_url;
        }
        elseif(trim($AContenido['variable']) == 'Suscribete'){
            $mensaje_sistema =  trim($APie['suscribete']);
            $url = $url_enlace.'SuscribeteAqui'.$var_url;
        }
        
        //-------------------------------------------------------------------------------------
        
        $variable =  str_replace ( '#url_email' , trim($url) ,  $mensaje_sistema);
        
        $contenido = str_replace ( '$nombre_email' , trim($fila['razon']) ,  $AContenido['contenido'] );
        
        if (trim($AContenido['variable']) == 'Mas informacion'){
            $contenido1 = str_replace ( '$mas_informacion' ,$variable , $contenido );
        }
        elseif(trim($AContenido['variable']) == 'Formulario'){
            
        }
        elseif(trim($AContenido['variable']) == 'Suscribete'){
            
        }
        
        
        $pie = str_replace ( '$nombre_email' ,  trim($fila['correo']),  $APie['pie'] );
        
        
        $urlBaja = $url_enlace.'DarBaja'.$var_url;
        
        $pie1 = str_replace ( '$baja' , $urlBaja ,  $pie );
        
        
        $content = trim($contenido1).$pie1;
        
        //-------------------------------------------------------------------------------------
        
        
        $mail->_DBconexion( $obj, $bd );
        
        $mail->_smtp_email(  trim($ACampana['tipo_envio']) );
        
        
        //------------------------------------------------------------------
        $asunto = trim($ACampana['asunto']) ;
        
        
        $mail->_DeCRM( $sesion,$sesion_nombre);
        
        $mail->_ParaCRM(trim($fila['correo']),trim($fila['razon']));
        
        
        $mail->_AsuntoCRM($asunto,$content );
        
        
        
        $mensaje_enviado = $mail->_Enviar();
        
        
        
        
        $sqlEdit = "update ven_cliente
                                  set proceso  =".$bd->sqlvalue_inyeccion( 'enviado',true)."
                                where id_campana= ".$bd->sqlvalue_inyeccion($id_campana,true)." and
                                      estado= ".$bd->sqlvalue_inyeccion('2',true)." and
                                      sesion= ".$bd->sqlvalue_inyeccion($sesion,true)." and
                                      idvencliente= ".$bd->sqlvalue_inyeccion($idvencliente,true) ;
        
        
        
        $bd->ejecutar($sqlEdit);
        
        
        echo $mensaje_enviado;
        
        
}
*/















?>
 
  