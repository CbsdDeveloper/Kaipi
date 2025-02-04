 <?php 

 session_start( );
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
 
 $idproducto  = $_GET['codigo'];
 $id          = $_GET['estado'];
  
 $sql = "update co_catalogo
                   set activo =".$this->bd->sqlvalue_inyeccion($estado, true)."
                where secuencia = ". $this->bd->sqlvalue_inyeccion($id, true);
  
 
?>