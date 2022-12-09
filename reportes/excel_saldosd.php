<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$codigo = $_GET["id"];
 

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
        where registro = ".$bd->sqlvalue_inyeccion($ruc,true)." and 
			  idbodega=".$bd->sqlvalue_inyeccion($codigo,true)." and 
			  tipo= ".$bd->sqlvalue_inyeccion('B',true)." and saldo > 0
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

 
