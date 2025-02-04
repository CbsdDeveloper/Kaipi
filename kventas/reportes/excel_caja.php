<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

$fanio= $_GET['fanio'];
$fmes= $_GET['fmes'];
$cuenta= $_GET['cuenta'];

 
$p = "' '";

 
 

$sql ="SELECT id_asiento as asiento, 
              fecha,   
               ".$p."  ||  idprov  as identificacion, 
              razon as nombre,
              detalle, 
              comprobantec as comprobante,
              documento ,
              montoi as ingreso, 
              monto as egreso, 
              cuenta,anio, mes
FROM view_auxbancos
where registro=".$bd->sqlvalue_inyeccion($ruc, true)." and
      transaccion=".$bd->sqlvalue_inyeccion('X', true)." and
      anio=".$bd->sqlvalue_inyeccion($fanio, true)." and
      mes=".$bd->sqlvalue_inyeccion($fmes, true)." and
      estado=".$bd->sqlvalue_inyeccion('aprobado', true).' and
      cuenta='.$bd->sqlvalue_inyeccion($cuenta, true).' order by fecha asc , montoi desc';

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

 
