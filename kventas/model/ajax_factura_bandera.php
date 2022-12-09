 <?php 

 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
 
 $id              = $_GET['id'];
 $estado          = $_GET['estado'];
  
 $sql = "update ven_cliente_gestion
                   set bandera =".$bd->sqlvalue_inyeccion($estado, true)."
                where idven_gestion = ". $bd->sqlvalue_inyeccion($id, true);
  
 
 $bd->ejecutar($sql);
 
 $mensajeEstado = 'Ok';
 
 echo $mensajeEstado;
 
?>