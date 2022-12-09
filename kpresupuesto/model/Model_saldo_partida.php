<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$partida          = $_GET['partida'];
 
$anio = $_SESSION['anio'];



$sql = "SELECT  disponible
		 FROM presupuesto.pre_gestion
		WHERE partida=".$bd->sqlvalue_inyeccion($partida,true). ' and 
              anio='.$bd->sqlvalue_inyeccion($anio,true) ;


$resultado1 = $bd->ejecutar($sql);

$dataProv  = $bd->obtener_array( $resultado1);


echo json_encode(  array("a"=>trim($dataProv['disponible']) )  );

 
?>
