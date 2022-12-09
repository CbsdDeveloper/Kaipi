<?php
session_start( );

require '../kconfig/Db.class.php';    
require '../kconfig/Obj.conf.php'; 
 
$obj   = 	new objects;
$bd	   =	new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$p = "' '";

$sql ="SELECT ".$p."  ||  idprov  as identificacion, 
              razon as funcionario,
              actividad as codigo
FROM par_ciu
where modulo=".$bd->sqlvalue_inyeccion('N', true).' and
      estado='.$bd->sqlvalue_inyeccion('S', true).' order by razon ';

 


$resultado	= $bd->ejecutar($sql);
$tipo 	= $bd->retorna_tipo();
 
header("Content-Transfer-Encoding: UTF-8");

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
 
header('Content-disposition: attachment; filename='.rand().'.xls');
header("Pragma: no-cache");
header("Expires: 0");

 

echo utf8_decode($obj->grid->KP_GRID_EXCEL($resultado,$tipo)) ;
 
?>  

 
