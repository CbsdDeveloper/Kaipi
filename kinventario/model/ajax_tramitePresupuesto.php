<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$tipo 		= $bd->retorna_tipo();

$anio       =  $_SESSION['anio'];

$sql = "select a.clasificador,b.detalle ,  a.codificado, a.certificado,a.devengado
from presupuesto.view_gestion_existencia a, presupuesto.pre_catalogo b 
where a.anio =".$bd->sqlvalue_inyeccion($anio,true)." and b.codigo = a.clasificador order by 1";



///--- desplaza la informacion de la gestion onclick="javascript:delRequisito('del',)"
$resultado  = $bd->ejecutar($sql);

$cabecera =  "Item,Detalle,Codificado,Certificado,Devengado";


$evento   = "";
$obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>
 
  