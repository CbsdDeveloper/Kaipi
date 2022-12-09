<?php
session_start();

include ('../../kconfig/Db.class.php');
include ('../../kconfig/Obj.conf.php');

$obj   = 	new objects;
$bd	   =    new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

if (isset($_GET['id']))	{
    
    $id_detalle = $_GET['id'];
    
    $idcodigo   = $_GET['codigo'];
    
    
    /// elimina la cuenta
    $sql = " delete from co_costo
		 		       where id_costo=".$bd->sqlvalue_inyeccion($id_detalle, true);
    
    $bd->ejecutar($sql);
    
}

$div = '#view_detalle_costo';

$url = '../model/ajax_view_costo.php?id_asiento='.$idcodigo;

echo '<script type="text/javascript">';
echo "  opener.$('".$div."').load('".$url."');   ";
echo '</script>';

$obj->var->kaipi_cierre_pop();


?>