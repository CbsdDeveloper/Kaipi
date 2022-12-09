<?php 
session_start( );  
 

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  

 
 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$ruc = $_GET["ruc"];
$anio = $_GET["anio"];
  
 
 
$sql11 = "SELECT a.ruc_registro, a.url,a.razon, b.nombre
				    						FROM web_registro a , par_catalogo b
				    						where b.idcatalogo =  a.idciudad and a.ruc_registro =".$bd->sqlvalue_inyeccion($ruc ,true);
 

 
$resultado1 = $bd->ejecutar($sql11);

$datos11     = $bd->obtener_array( $resultado1);

$_SESSION['ruc_registro']   =  $datos11['ruc_registro'];
$_SESSION['logo']	 	    =  $datos11['url'];
$_SESSION['razon'] 	        =  $datos11['razon'];
$_SESSION['ciudad'] 		=  $datos11['nombre'];
$_SESSION['tiempo']         = time();

$_SESSION['anio']         = $anio;
	
$RucRegistro = 'Ud. Selecciono la empresa: '.$_SESSION['razon'].' Periodo: '.$anio 	 ;
	
	echo $RucRegistro;
 
?>