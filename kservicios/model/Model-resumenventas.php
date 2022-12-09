<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;



$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$fecha        = $_GET['fecha'];
$cajero       = $_GET['cajero'];


$tipo 		= $bd->retorna_tipo();


$sql = 'SELECT  razon,
				COALESCE(sum(interes),0) as interes,
				COALESCE(sum(descuento),0) as descuento,
				COALESCE(sum(recargo),0) as recargo,
				COALESCE(sum(apagar),0) as pagado,
				count(*) as titulos
		FROM rentas.view_ren_movimiento_pagos
		where sesion_pago = '.$bd->sqlvalue_inyeccion($cajero ,true).'  and 
			  fechap = '.$bd->sqlvalue_inyeccion($fecha ,true).' and 
			  cierre = '.$bd->sqlvalue_inyeccion('N' ,true).'
		group by razon
		order by razon';

 
///--- desplaza la informacion de la gestion
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Usuarios Contribuyentes,Interes,Descuento,Recargo,Total";


$obj->table->KP_sumatoria(5,4) ;

$obj->table->table_basic_js($resultado,$tipo,'','','' ,$cabecera);

$DivDetalleMovimiento= ' ';

echo $DivDetalleMovimiento;


?>