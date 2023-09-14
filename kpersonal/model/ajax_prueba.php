<?php   
/*
$fechaUno=new DateTime('07:56:23');
$fechaDos=new DateTime('08:30:00');

$dateInterval = $fechaUno->diff($fechaDos);

echo $dateInterval->format('Total: %H horas %i minutos %s segundos').PHP_EOL;


$entrada=new DateTime('07:56:23');
$salida=new DateTime('08:30:00');
 

$diferencia = $entrada->diff($salida);

echo $diferencia->format("%H:%i"); 

 */
require '../../kconfig/Db.class.php';


require '../../kconfig/Obj.conf.php';

 require 'Formulas-roles_nomina.php';


 $anio       =  $_SESSION['anio'];

 $bd	   =	new Db;
 $obj   = 	new objects;

 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
       



 $formula     = 	new Formula_rol(  $obj,  $bd);



 $anio            = $_GET['anio'];
 $mes             = $_GET['mes'];
 $idprov          = trim($_GET['idprov']);

 


 $rol = $bd->query_array('nom_rol_pago',
 'id_periodo, mes, anio, registro,tipo,id_rol',
 'anio='.$bd->sqlvalue_inyeccion($anio,true).' and mes='.$bd->sqlvalue_inyeccion($mes,true)
);
//---------------------------------------------------------------------------

$anio = $rol["anio"];
$mes  = $rol["mes"];


   $id_periodo = $rol["id_periodo"];
   $id_rol     = $rol["id_rol"];

 
   echo ' <h4>IMPUESTO A LA RENTA</h4>';
 $ingreso = $formula->_n_impuesto_renta( $id_periodo , $id_rol,  $idprov  ,$anio, $mes,'S');

 echo ' <br>';


 echo ' <h4>REBAJA</h4>';
 $ingreso = $formula->_n_rebaja_renta( $id_periodo , $id_rol,  $idprov  ,$anio, $mes,'S');
 


     
 ?>