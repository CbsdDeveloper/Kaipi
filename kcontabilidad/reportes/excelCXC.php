<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$festado= $_GET['festado'];
$ffecha1= $_GET['ffecha1'];
$ffecha2= $_GET['ffecha2'];

$cadena = '( fecha BETWEEN '.$bd->sqlvalue_inyeccion($ffecha1,true)." and ".$bd->sqlvalue_inyeccion($ffecha2,true)." )   ";

$p = "' '";

$sql ="SELECT id_asiento as asiento, 
              fecha,   
              anio, 
              mes, 
              ".$p."  ||  idprov  as identificacion, 
              razon as proveedor,
              detalle, 
              comprobante, 
              estado_pago, 
              cuenta ,   
              txtcuenta as detalle_cuenta,
              apagar
FROM view_asientocxc
where registro=".$bd->sqlvalue_inyeccion($ruc, true).' and
      estado='.$bd->sqlvalue_inyeccion($festado, true).' and '.$cadena;

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

 
