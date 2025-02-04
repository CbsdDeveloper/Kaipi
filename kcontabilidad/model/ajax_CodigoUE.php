<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$ruc       =  trim($_SESSION['ruc_registro']);

$codigoc    = $_GET['codigoc'] ;
$unidade    = $_GET['unidade'] ;
 
$sql = 'update web_registro 
           set codigo1='.$bd->sqlvalue_inyeccion($codigoc, true).',
               unidade='.$bd->sqlvalue_inyeccion($unidade, true).'
        where ruc_registro= '.$bd->sqlvalue_inyeccion($ruc, true);

 
  $bd->ejecutar($sql);
 
$div_mistareas = 'ok';

echo $div_mistareas;

?>