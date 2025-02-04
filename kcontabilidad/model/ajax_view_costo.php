<?php
session_start();

include ('../../kconfig/Db.class.php');
include ('../../kconfig/Obj.conf.php');

$obj   = 	new objects;

$bd	   =	    new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_asiento= $_GET['id_asiento'];

$sql = 'SELECT  id_costo as "Referencia",
                    nombre as "Proyecto",
                    tipo as "Tipo", 
                    detalle as "Detalle",
                    costo as "Costo"
      FROM view_asiento_costo
      where id_asiento = '.$bd->sqlvalue_inyeccion($id_asiento ,true);

 

///--- desplaza la informacion de la gestion
$resultado  = $bd->ejecutar($sql);

$tipo 		= $bd->retorna_tipo();

$enlace    = '../model/Model-ajax_costo_del';

$variables = 'ref=Codigo&codigo='.$id_asiento;

$obj->grid->KP_GRID_POP($resultado,$tipo,'Referencia', $enlace,$variables,'S','','','del',250,120,'');

$precio_grilla ='';

echo $precio_grilla;

?>