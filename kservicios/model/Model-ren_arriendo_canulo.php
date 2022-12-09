<?php

session_start( );

require '../../kconfig/Db.class.php';  

require '../../kconfig/Obj.conf.php'; 


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
$idfacturas       = $_GET['idfacturas'];
$idprov           = $_GET['idprov'];



$sqlEdit = "update inv_movimiento
				     set  estado = ".$bd->sqlvalue_inyeccion('anulado',true)."
 				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $idfacturas, true);

$bd->ejecutar($sqlEdit);


$anulado_fac = 'Tramite anulado ( '.$idprov.' ) Nro.Transaccion '.$idfacturas;

echo $anulado_fac;
 
?>