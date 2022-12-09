<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$cprov  = $_GET['cprov'];
 

 
$sql1 = 'SELECT canton
		 FROM ven_cliente
		 where provincia = '.$bd->sqlvalue_inyeccion($cprov,true).' group by canton';


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="">'.'[Seleccione Actividad]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['canton'].'">'.$fila['canton'].'</option>';
    
}

?>
 
  