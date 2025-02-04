<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$unidad  = $_GET['unidad'];

$anio    =  $_SESSION['anio'];
 
if ( $unidad  > 0 ) {
    
    $sql1 = "SELECT id_pac,procedimiento ,detalle,partida
            FROM adm.adm_pac
            where anio = ".$bd->sqlvalue_inyeccion($anio,true) . ' and
                id_departamento ='.$bd->sqlvalue_inyeccion($unidad,true) . ' order by 2';
    
}else{
    $sql1 = "SELECT id_pac,procedimiento ,detalle,partida
            FROM adm.adm_pac
            where anio = ".$bd->sqlvalue_inyeccion($anio,true) . ' order by 2';
    
}


 
$stmt1 = $bd->ejecutar($sql1);


echo '<option value="0">-- No Aplica -- </option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    
    $detalle =strtolower(trim($fila['detalle']));
    
    $partida =  trim($fila['partida']) ;
    
    echo '<option value="'.$fila['id_pac'].'">'.trim($fila['procedimiento']).': '.ucfirst($detalle).' - Partida: '.$partida.'</option>';
    
}


?>
 
  