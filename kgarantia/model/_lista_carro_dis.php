<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
 
    
    $sql1 = "SELECT id_departamento ,unidad nombre
		      FROM  adm.view_bien_vehiculo group by id_departamento,unidad order by nombre "  ;
    
 
 
 

$stmt1 = $bd->ejecutar($sql1);

echo '<option value="0"> [  Todas las Unidades ]</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['id_departamento'].'">'.trim($fila['nombre']).'</option>';
    
}
 

?>
 
  