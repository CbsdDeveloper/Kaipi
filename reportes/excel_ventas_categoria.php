<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$mes         = $_GET['mes'];
$anio        = $_GET['anio'];
$idproducto  = $_GET['idproducto'];
$idcategoria = $_GET['idcategoria'];
 

$select = " (select x.valor_variable from inv_movimiento_var x where x.id_movimiento = a.id_movimiento and x.idcategoriavar = 1) as Referencia, " ;

		$sql ="SELECT a.id_movimiento as Movimiento,
                      a.fechaa as fecha,
    		          a.idprov as Identificacion,
    		          a.razon as cliente,
    		          a.comprobante,
    			      a.detalle, ".$select." 
                      a.total
		FROM view_mov_aprobado a
        where a.idcategoria=".$bd->sqlvalue_inyeccion($idcategoria,true)." and 
                a.idproducto =".$bd->sqlvalue_inyeccion($idproducto,true)." and 
                a.mes=".$bd->sqlvalue_inyeccion($mes,true)." and 
                a.anio=".$bd->sqlvalue_inyeccion($anio,true)." and 
                a.estado=".$bd->sqlvalue_inyeccion('aprobado',true)." order by a.fechaa" ;

	 
 
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

 
