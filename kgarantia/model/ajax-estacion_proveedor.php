<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
 

$anio = date('Y');
 
    
    $sql1 = "SELECT idprov ,razon as nombre
		      FROM  adm.view_comb_vehi_estacion
			 WHERE anio = ".$bd->sqlvalue_inyeccion($anio,true). ' group by idprov, razon order by razon' ;
    
 
 

$stmt1 = $bd->ejecutar($sql1);

echo '<option value="0"> [  Seleccione Proveedor Estacion  ]</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['idprov'].'">'.trim($fila['nombre']).'</option>';
    
}
 

?>
 
  