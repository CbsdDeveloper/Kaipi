<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id= $_GET['id'];

 
$tipo 		      = $bd->retorna_tipo();

$cadena  = " || '  '   ";

$cadena1 = " ' G-' ||   ";

$sql = ' SELECT  tipo,tipo_reforma,
                 funcion '.$cadena.'   programa,
                 partida  '.$cadena.' partida_presupuestaria,
                 detalle,
                 clasificador  '.$cadena.' item_presupuestario, 
                 saldo as saldo_fecha, 
                 aumento, 
                 disminuye,
                 '.$cadena1.' partida as partida
              FROM presupuesto.view_reforma_detalle
              where id_reforma='.$bd->sqlvalue_inyeccion($id, true);

 

echo 'Exportar archivo';

$resultado	= $bd->ejecutar($sql);
 
//excel.php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header('Content-disposition: attachment; filename='.rand().'.xls');
header("Pragma: no-cache");
header("Expires: 0");

echo utf8_decode($obj->grid->KP_GRID_EXCEL($resultado,$tipo)) ;
 
?> 
 
 
 