<?php
session_start( );

require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$obj   = 	new objects;
$bd	   =    new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
$accion     = trim($_GET["accion"]);
$idcodigo   = $_GET["idcodigo"];
$id_combus  = $_GET["id_combus"];
 
$sesion 	 =     trim($_SESSION['email']);
$hoy 	     =     date("Y-m-d");  


 $InsertQuery = array(
    array( campo => 'id_combus', valor => $id_combus ),
    array( campo => 'id_orden', valor =>  $idcodigo),
    array( campo => 'fecha',    valor =>  $hoy),
    array( campo => 'sesion',   valor => $sesion),
    array( campo => 'fecha_creacion', valor => $hoy),
    array( campo => 'fecha_modifica', valor => $hoy)
    );
    
    $bd->pideSq(0);
    $bd->JqueryInsertSQL('adm.ad_orden_comb',$InsertQuery);
  
 
 
    
    echo 'Enlace agregado a la orden de combustible y de movilizacion '.$id;
 
?>
  
  