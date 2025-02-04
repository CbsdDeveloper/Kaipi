<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$tipo 		= $bd->retorna_tipo();

$anio       =  $_SESSION['anio'];

$sql = " SELECT   cuenta_inv, ncuenta_inv,   round(sum(costo_total),2) as total
FROM public.view_inv_movimiento_det
where anio = ".$bd->sqlvalue_inyeccion($anio,true)." and tipo = 'E' and estado = 'aprobado'
group by cuenta_inv, ncuenta_inv" ;

 
 
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Cuenta,Detalle,Costo";


$evento   = "";
$obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>
 
  