<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 

$tipo 		      = $bd->retorna_tipo();





$sql = $_SESSION['sql_activo'];

/*

if ( $tipo_presupuesto == 'G'){
    $p = "' G-'";
    
    $sql ="SELECT ".$p."  || partida  as Partida ,funcion as programa,clasificador,
              detalle,
             inicial,  codificado, certificado, compromiso, devengado, pagado, disponible
FROM presupuesto.pre_gestion
where tipo = ".$bd->sqlvalue_inyeccion($tipo_presupuesto, true)." and
       anio = ".$bd->sqlvalue_inyeccion($fanio, true)."
order by partida" ;
    
}else{
    $p = "' I-'";
    $sql ="SELECT ".$p."  || partida   as Partida , clasificador,
              detalle,
             inicial,  codificado, certificado, compromiso, devengado, pagado, disponible
FROM presupuesto.pre_gestion
where tipo = ".$bd->sqlvalue_inyeccion($tipo_presupuesto, true)." and
       anio = ".$bd->sqlvalue_inyeccion($fanio, true)."
order by partida" ;
}
*/






$resultado	= $bd->ejecutar($sql);
 
//excel.php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header('Content-disposition: attachment; filename='.rand().'.xls');
header("Pragma: no-cache");
header("Expires: 0");

echo utf8_decode($obj->grid->KP_GRID_EXCEL($resultado,$tipo)) ;

?>  

 
