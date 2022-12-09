<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$servicio= $_GET['servicio'];
 
 
$p = "' '";

$sql =" SELECT id_ren_tramite,comprobante,  
               ".$p."  ||  idprov || ' ' as ruc, 
             razon, 
             direccion,
             correo,contacto, cmovil, ctelefono,
            estado, fecha_inicio, fecha_cierre, detalle, resolucion, multa, base, 
            anio, mes, apago, fecha_pago 
        FROM rentas.view_ren_tramite
        where id_rubro =  ".$bd->sqlvalue_inyeccion($servicio, true);


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

 
