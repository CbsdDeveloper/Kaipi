<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$tipo 		= $bd->retorna_tipo();


$sql = "SELECT id_tramite, unidad , comprobante, detalle,   proveedor
            FROM presupuesto.view_pre_tramite
            where estado in ('4','5') and tipo is null";



///--- desplaza la informacion de la gestion onclick="javascript:delRequisito('del',)"
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Tramite,Unidad,Comprobante,Detalle,Beneficiario";


$evento   = "deltramite-0";
$obj->table->table_basic_seleccion($resultado,$tipo,'seleccion','',$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>
 
  