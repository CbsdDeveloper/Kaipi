 <?php 

 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
 
 $id              = $_GET['id'];
 $accion          = $_GET['accion'];
  
 $sql = "update inv_movimiento 
            set autorizacion = ''  ,  transaccion =''
            where envio is null and 
                  estado = 'aprobado' and
                   tipo = 'F' and 
                  id_movimiento = ".$bd->sqlvalue_inyeccion($id, true);

 if ( $accion == 'limpiar'){
     
     $bd->ejecutar($sql);
 }

 
 $mensajeEstado = 'DATO PROCESADO... GENERAR NUEVAMENTE LA TRANSACCION Ok';
 
 echo $mensajeEstado;
 
?>