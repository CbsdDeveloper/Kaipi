<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id   =  $_GET['id'];
$item =  "%".trim($_GET['item'])."%";

$accion   =  $_GET['accion'];
 

if ( $accion == 1){
    $sql1 = 'SELECT partida,detalle
		   FROM presupuesto.view_dettramites
			where id_tramite = '.$bd->sqlvalue_inyeccion($id,true).' and
                  partida like '. $bd->sqlvalue_inyeccion($item,true);
}else{
    $sql1 = 'SELECT partida,detalle
		   FROM presupuesto.view_dettramites
			where id_tramite = '.$bd->sqlvalue_inyeccion($id,true) ;
}
    

    
    
 


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="'.'-'.'">- 0. Seleccione la partida </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.trim($fila['partida']).'">'.trim($fila['partida']).' ' .trim($fila['detalle']).'</option>';
    
}


?>
 
  