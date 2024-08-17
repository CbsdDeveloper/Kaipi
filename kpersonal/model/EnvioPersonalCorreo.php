<?php
     session_start();
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/
     

    //  error_reporting(E_ALL);
    //  ini_set('display_errors', 1);

     $obj      = 	new objects;
     $bd	   =	new Db;
     $mail     =	new EmailEnvio;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

     $idprov             = trim($_GET['id']) ;
     $id_rol             = $_GET['id_rol1'];

     $sesion 	         =  trim($_SESSION['email']);
     $razon_social       = $_SESSION['razon'] ;
     
     $response           = 'Error de conexion...';
     


     $mail->_DBconexion( $obj, $bd );
     $mail->_smtp_factura_electronica( );

     
     $plantilla     =   $bd->query_array(
        'ven_plantilla',
        'contenido,   variable',
        'id_plantilla='.$bd->sqlvalue_inyeccion(-3,true)
        );
     $datos_web     =   $mail->WebEnvio();
    //  print_r($datos_web);
     $pagina_web    =   trim($datos_web);
     $pagina_web    =   trim('https://kaipi.cbsd.gob.ec/');
        
       
     $x         = $bd->query_array(  'view_nomina_rol', 'idprov,razon,emaile,correo',  'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true) );
     
     $sql = "SELECT novedad,id_periodo  FROM nom_rol_pago where id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true);
     
     $resultado     = $bd->ejecutar($sql);
     $datos         = $bd->obtener_array( $resultado);
     $periodo       = $datos['novedad'];
     $id_periodo    = $datos['id_periodo'];
     $imagen        = $pagina_web.'kimages/'. trim($_SESSION['logo']) ;
 
    //  $mail->_DeCRM( $sesion, $_SESSION['razon']);


     //---------------------------------------------------------------------
     
     $sql = "SELECT *  FROM view_nomina_rol where idprov = ".$bd->sqlvalue_inyeccion($idprov,true);

     
     $resultado = $bd->ejecutar($sql);
     $datos     = $bd->obtener_array( $resultado);
     
     //-------------------------------------------------------------------------
     
     if (  trim($datos['sifondo']) == 'N') {
         $sql = 'SELECT sum(ingreso) as ingreso,sum(descuento) as egreso
           				   FROM view_rol_personal
        		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov ,true)." and
        		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and
        						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true) ;
     }else{
         $sql = 'SELECT sum(ingreso) as ingreso,sum(descuento) as egreso
           				   FROM view_rol_personal
        		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov ,true)." and
        		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and
        						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true)." and
                               id_config_matriz not in ( '2','11')" ;
     }
   
     
     
     $resultado = $bd->ejecutar($sql);
     $datos1    = $bd->obtener_array( $resultado);
     $total     = $datos1['ingreso'] -  $datos1['egreso'];
     
    
     
     $content =  str_replace ( '#empleado' , trim($x['razon']) ,  $plantilla['contenido']);
    
     $content =  str_replace ( '#periodo' , trim($periodo) ,  $content);
     
     $content =  str_replace ( '#ingresos' ,  $datos1['ingreso'] ,  $content);
     
     $content =  str_replace ( '#descuentos' ,  $datos1['egreso'] ,  $content);
     
     $content =  str_replace ( '#recibe' , trim($total) ,  $content);
     
     $content =  str_replace ( '#empresa' , trim($razon_social) ,  $content);
 
     
     $content =  str_replace ( '#imagen' , trim($imagen) ,  $content);
      
      $enlace = $pagina_web.'reportes/R9lpxGq?us='.$_SESSION['us'].'&rd='. $_SESSION['ruc_registro'].'&db='.$_SESSION['db'].'&ac='.$_SESSION['ac'].'&i='.$idprov.'&r='.$id_rol;
      
     $content =  str_replace ( '#enlace' , trim($enlace) ,  $content);  
     
     
     $asunto = 'Resumen '.$periodo;
    
 
         if ( trim($x['correo']) == trim($x['emaile']) ){
         
                $mail->_ParaCRM(trim($x['correo']),trim($x['razon']));

        }else {

            $mail->_ParaCRM(trim($x['correo']),trim($x['razon']));

            $mail->_ParaCRM(trim($x['emaile']),trim($x['razon']));

        }
         
          
         $mail->_AsuntoCRM($asunto,$content );
  
         $response = $mail->_EnviarElectronica();
         
         sleep(2);
     
     echo $response.' '.trim($x['razon']);
