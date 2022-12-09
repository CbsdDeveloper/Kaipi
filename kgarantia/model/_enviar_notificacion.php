<?php
     session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
     
     $obj      = 	new objects;
     $bd	   =	new Db;
     $mail     =	new EmailEnvio;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
     $sesion 	    =  trim($_SESSION['email']);
      
     $response = 'Error de conexion...';
     
     $mail->_DBconexion( $obj, $bd );
     
     $mail->_smtp_factura_electronica( );
     
     $id       = trim($_GET['id']) ;
      
        
     $plantilla = $bd->query_array(
         'ven_plantilla',
         'contenido,   variable',
         'id_plantilla='.$bd->sqlvalue_inyeccion(-4,true)
         );
      
      
     $x = $bd->query_array(
         'adm.view_comb_vehi',
         'id_prov,referencia,fecha,razon,codigo_veh,   unidad, cargo, marca',
         'id_combus='.$bd->sqlvalue_inyeccion(trim($id),true)
         );
     
     $acorreo = $bd->query_array(
         'par_usuario',
         'email',
         'cedula='.$bd->sqlvalue_inyeccion( trim($x['id_prov']),true)
         );
     
 
     
     
     $detalle = 'Ud tiene un comprobante por realizar la actualizacion Nro.'.$x['referencia'].' <br>';
     $detalle .= 'Con fecha de  '.$x['fecha'].' <br>';
     $detalle .= 'Vehiculo  '.$x['codigo_veh'].' '.$x['marca'].' <br>';
    
     
     $asunto = 'NOTIFICACIONES - CONTROL DE COMBUSTIBLES';
     
     $content =  str_replace ( '#NOMBRE' , trim($x['razon']) ,  $plantilla['contenido']);
      $content =  str_replace ( '#DETALLE' , trim($detalle) ,  $content);
     
      
     
 
    
     $mail->_DeCRM( $sesion, $_SESSION['razon']);

          
     $mail->_ParaCRM(trim($acorreo['email']),trim($x['razon']));
 
         
      $mail->_AsuntoCRM($asunto,$content );
         
         
      $response = $mail->_EnviarElectronica();
         
 
     
     echo $response;
     
      
?>
 
  