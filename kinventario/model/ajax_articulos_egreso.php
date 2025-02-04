<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$tipo 		= $bd->retorna_tipo();

$anio       =  $_SESSION['anio'];

$sql = "SELECT producto ,max(fecha) fecha,sum(cantidad) as cantidad,sum(total) as total
        FROM view_inv_movimiento_det
        where anio =" .$bd->sqlvalue_inyeccion($anio,true)." and 
              tipo = 'E'
        group by producto
        order by 3 desc limit 8";
  
 
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Articulos mas solicitados ,Ultima Salida,Cantidad,Total";


$evento   = "";
$obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);


$sql = "SELECT producto ,max(fecha) fecha,sum(cantidad) as cantidad,sum(total) as total
        FROM view_inv_movimiento_det
        where anio =" .$bd->sqlvalue_inyeccion($anio,true)." and 
              tipo = 'I'
        group by producto
        order by 3 desc limit 8";
  
 
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Articulos mas adquiridos,Ultima Compra,Cantidad,Total";


$evento   = "";
$obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);


$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>
 
  