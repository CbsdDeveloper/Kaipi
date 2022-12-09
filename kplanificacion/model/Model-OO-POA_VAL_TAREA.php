<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$IDACTIVIDAD= $_GET['IDACTIVIDAD'];
 
 


 
 
$AIdactividad = $bd->query_array('VIEW_ACTIVIDAD_POA',
							'TIPO_GESTION', 
							'IDACTIVIDAD='.$bd->sqlvalue_inyeccion($IDACTIVIDAD,true) 
							);
 
$validatarea = 'N';

if ($AIdactividad['TIPO_GESTION'] == 'Sin Presupuesto' ){
	
	$validatarea = 'N';
}else{
	$validatarea = 'S';
}
 

echo $validatarea;


?>
 
 
 