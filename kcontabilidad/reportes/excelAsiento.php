<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id= $_GET['id'];


$tipo 		      = $bd->retorna_tipo();

$cadena  = " || '  '   ";

 

$sql = ' SELECT  id_asiento,id_asientod,
                 cuenta '.$cadena.'   cuenta, detalle,
                 partida  '.$cadena.' partida_presupuestaria,
                 item  '.$cadena.' item_presupuestario,
                 debe, haber,
                 id_tramite
              FROM view_diario_conta
              where id_asiento='.$bd->sqlvalue_inyeccion($id, true);


 
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
 