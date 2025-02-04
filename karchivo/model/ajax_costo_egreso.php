 <?php 
 session_start();
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
 
 $idproducto  = $_GET['prod'];
 $id          = $_GET['mov'];
 
 
 $costo       = $_GET['costo'];
 $cantidad    = $_GET['cantidad'];
 
 $total = $cantidad * $costo;
  
 $sql = "update inv_movimiento_det
                   set costo =".$bd->sqlvalue_inyeccion($costo, true).",
                       total =".$bd->sqlvalue_inyeccion($total, true).",
                       tarifa_cero =".$bd->sqlvalue_inyeccion($total, true)."
                where idproducto = ". $bd->sqlvalue_inyeccion($idproducto, true). ' and 
                      id_movimiento = '. $bd->sqlvalue_inyeccion($id, true);
  
 
 $bd->ejecutar($sql);
 
 echo 'Actualizacion realizada... ';
 
?>