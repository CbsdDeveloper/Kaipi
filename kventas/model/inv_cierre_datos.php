 <?php 

 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
 
 $id_movimiento        = $_GET['id'];
 $tipo                 = $_GET['tipo'];
 $comprobante          = $_GET['comprobante'];
 $fecha                = $_GET['fecha'];
 $fechaa               = $_GET['fechaa'];
  
 $VisorArticuloPrecios = 'Datos actualizados';
         
         if ( $tipo == '1'){
             
             $sql1 = 'UPDATE inv_movimiento
                       SET estado = '.$bd->sqlvalue_inyeccion('digitado',true).' 
                     where id_movimiento ='.$bd->sqlvalue_inyeccion($id_movimiento,true) ;
             
             $bd->ejecutar($sql1);
 
             
         }
         
         
         if ( $tipo == '2'){
             
             $fecha1		= $bd->fecha($fecha);
             $fecha2		= $bd->fecha($fechaa);
             
             
             
             $sql1 = 'UPDATE inv_movimiento
                       SET fecha = '.$fecha1.',
                           fechaa = '.$fecha2.',
                           comprobante = '.$bd->sqlvalue_inyeccion(trim($comprobante),true).'
                     where id_movimiento ='.$bd->sqlvalue_inyeccion($id_movimiento,true) ;
             
             $bd->ejecutar($sql1);
             
             
         }
 
         
         
         if ( $tipo == '3'){
             
             $sql1 = 'UPDATE inv_movimiento
                       SET autorizacion = '.$bd->sqlvalue_inyeccion('',true).',
                           envio = '.$bd->sqlvalue_inyeccion('',true).',
                           transaccion = '.$bd->sqlvalue_inyeccion('',true).'
                     where id_movimiento ='.$bd->sqlvalue_inyeccion($id_movimiento,true) ;
             
             $bd->ejecutar($sql1);
             
             
         }
         
         if ( $tipo == '4'){
             
             $sql1 = 'UPDATE inv_movimiento
                       SET id_asiento_ref = '.$bd->sqlvalue_inyeccion(0,true).'
                     where id_movimiento ='.$bd->sqlvalue_inyeccion($id_movimiento,true) ;
             
             $bd->ejecutar($sql1);
             
             
         }
 
 
     
 echo $VisorArticuloPrecios;
 
 
 
?>