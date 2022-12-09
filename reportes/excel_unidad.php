<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$ruc       =  $_SESSION['ruc_registro'];


			$sql ="SELECT id_departamento, 
					      nombre, atribuciones, competencias, ubicacion, nivel, estado, ambito, siglas, secuencia, programa, techo
				FROM nom_departamento order by id_departamento,id_departamentos" ;

 
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

 
