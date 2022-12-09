<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
 

		$sql ="SELECT   idproducto,producto,referencia,
		   tipo,
		   categoria,
			marca,
		   unidad,
		   costo,
		   ingreso,
		   egreso,
		   saldo,
		   lifo,
		   minimo
		FROM view_saldos_bod 
        where saldo  < 1 and registro = ".$bd->sqlvalue_inyeccion($ruc,true)." and tipo= ".$bd->sqlvalue_inyeccion('B',true)." 
        order by producto" ;

 
$resultado	= $bd->ejecutar($sql);
$tipo 		= $bd->retorna_tipo();

 
//excel.php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header('Content-disposition: attachment; filename='.rand().'.xls');
header("Pragma: no-cache");
header("Expires: 0");

echo utf8_decode($obj->grid->KP_GRID_EXCEL($resultado,$tipo)) ; 

?>  

 
