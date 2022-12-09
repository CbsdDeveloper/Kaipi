 <?php 

 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
 $obj   = 	new objects;
 $set   = 	new ItemsController;
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
 
 $dato  = $_GET['dato'];
  
 
 $sql1 = 'SELECT idproducto, producto
					FROM web_producto
					where idcategoria = '.$bd->sqlvalue_inyeccion($dato,true) ;
 
 
 $stmt1 = $bd->ejecutar($sql1);
 
 echo '<option value="">'.'[Seleccione Actividad]'.'</option>';
 
 while ($fila=$bd->obtener_fila($stmt1)){
     
     echo '<option value="'.$fila['idproducto'].'">'.$fila['producto'].'</option>';
     
 }
 
     
    
?>