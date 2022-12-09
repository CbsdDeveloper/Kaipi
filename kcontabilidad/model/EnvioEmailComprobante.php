<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

require '../../kconfig/Db.emailMarket.php'; 

 
$obj   = 	new objects;
$bd	   =	new Db;
$mail  =	new EmailEnvio;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$sesion 	   =  trim($_SESSION['email']);

$ruc           =  $_SESSION['ruc_registro'];

$razon_social  = $_SESSION['razon'] ;

$mail->_DBconexion( $obj, $bd );

$mail->_smtp_factura_electronica( );

$id     = $_GET['id'] ;


$Contenido = $bd->query_array(
    'ven_plantilla',
    'contenido,   variable',
    'id_plantilla='.$bd->sqlvalue_inyeccion(-1,true)
    );


$url = $bd->query_array(
    'web_registro',
    'web,felectronica,smtp,carpeta',
    'ruc_registro='.$bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']),true)
    );


if ( $url['felectronica'] == 'S' ) {
             
            $sql = "SELECT id_compras, id_asiento, secretencion1,  idprov,   autretencion1, fecharegistro,razon,correo, detalle
                        FROM  view_anexos_compras
                        where
                                registro   = ".$bd->sqlvalue_inyeccion( $ruc ,true)." and
                                codigoe      = ".$bd->sqlvalue_inyeccion( 1,true)." and
                                id_asiento  = ".$bd->sqlvalue_inyeccion( $id ,true)." and
                                autretencion1 is not null  and
                                transaccion  =  'E'   
                        order by id_compras desc
                        limit 1";
            
            
            
            $stmt = $bd->ejecutar($sql);
            
            
            while ($fila=$bd->obtener_fila($stmt)){
                
           
                
                $idprov          = $fila['idprov'];
                
                $x = $bd->query_array(
                    'par_ciu',
                    'idprov, razon,  correo ',
                    'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true)
                    );
                   
                
                //------------------------------------------------------------------
                //------------------------------------------------------------------
                $asunto = 'Comprobante Electronico '.$idprov.'-'.$fila['secretencion1'];
                
                $content =  str_replace ( '#PROVEEDOR' , trim($x['razon']) ,  $Contenido['contenido']);
                
                $content =  str_replace ( '#IDENTIFICACION' , trim($idprov) ,  $content);
                
                $content =  str_replace ( '#FECHA' , trim($fila['fecharegistro']) ,  $content);
                
                $content =  str_replace ( '#FACTURA' , trim($fila['secretencion1']) ,  $content);
                
                $content =  str_replace ( '#AUTORIZACION' , trim($fila['autretencion1']) ,  $content);
                
                $content =  str_replace ( '#EMPRESA' , trim($razon_social) ,  $content);
                
                // #pdf base64_decode $imagen
                
                $xml     = trim($fila['autretencion1']) ;
                
                $imagen  =  trim( $url['carpeta'] );
                
                $pa = base64_encode($imagen) ;
                  
               // $pathimagen = 'https://g-kaipi.cloud/kaipi/facturae/firmas/'.$imagen;
                //$pathimagen = 'http://www.s2i.com.ec/kaipi/facturae/firmas/'.$imagen;
                
				$pathimagen = 'https://k-pyme.com/Qvial/facturae/firmas/'.$imagen;
				
	 
				
				
                $content =  str_replace ( '#LOGO' , trim($pathimagen) ,  $content);
                
                $pa = base64_encode($imagen) ;
                
                
                //  $enlace = 'https://g-kaipi.cloud/kaipi/facturae/ride/RideComprobante?xml='.$xml.'&file='.$pa;
                //$enlace = 'http://www.s2i.com.ec/kaipi/facturae/ride/RideComprobante?xml='.$xml.'&file='.$pa;
				
				$enlace = 'https://k-pyme.com/Qvial//facturae/ride/RideComprobante?xml='.$xml.'&file='.$pa;
                
                $content =  str_replace ( '#pdf' , trim($enlace) ,  $content);
                
                
                // $url = 'https://g-kaipi.cloud/kaipi/facturae/xml/'.$xml.'_A'.'.xml';
                //$url = 'http://www.s2i.com.ec/kaipi/facturae/xml/'.$xml.'_A'.'.xml';
				
				 $url = 'https://k-pyme.com/Qvial/facturae/xml/'.$xml.'_A'.'.xml';
                
                $mail->_adjuntar($xml.'.xml',$url);
                
                
                $mail->_DeCRM( $sesion, $_SESSION['razon']);
                
                $mail->_ParaCRM(trim($x['correo']),trim($x['razon']));
                
                
                $mail->_AsuntoCRM($asunto,$content );
                
                
                $response = $mail->_EnviarElectronica();
                
                
            }
                
    }


 


echo $response;


 
?>
 
  