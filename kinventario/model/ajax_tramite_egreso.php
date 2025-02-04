<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$tipo 		= $bd->retorna_tipo();

$anio       =  $_SESSION['anio'];

$sql = "SELECT unidad   ,
	   count(*) || ' ' as transaccion,
		sum(total) as total
   FROM  view_inv_transaccion
   where tipo = 'E' and
         estado = 'aprobado'  and
         anio = ".$bd->sqlvalue_inyeccion($anio,true)."
         group by  unidad,transaccion
         order by unidad";

 
 
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Unidad,Tramites,Costo";


$evento   = "";
$obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>
 
  