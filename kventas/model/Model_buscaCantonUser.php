<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$cprov  = $_GET['cprov'];

$user   = $_SESSION['usuario'] ;


$sql1 = 'SELECT sector
		 FROM ven_cliente_zona
		 where zona      = '.$bd->sqlvalue_inyeccion($cprov,true).' and 
               idusuario ='.$bd->sqlvalue_inyeccion($user,true).'
         group by sector';

 


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="">'.'[Seleccione Actividad]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['canton'].'">'.$fila['canton'].'</option>';
    
}

?>
 
  