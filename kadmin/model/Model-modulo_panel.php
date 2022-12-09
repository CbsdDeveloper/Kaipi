<?php 
session_start( );  
  
    // retorna el valor del campo para impresion de pantalla
 
require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php';  
 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$identificacion   = $_GET['identificacion'];

$sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre,a.fondo
          FROM web_registro a , par_catalogo b
         where b.idcatalogo =  a.idciudad and
               a.ruc_registro =".$bd->sqlvalue_inyeccion(trim($identificacion) ,true);



$resultado = $bd->ejecutar($sql);

$datos1 = $bd->obtener_array( $resultado);

$_SESSION['ciudad']       = trim($datos1['nombre']);
$_SESSION['razon']        = trim($datos1['razon']);
$_SESSION['ruc_registro'] = trim($datos1['ruc_registro']); 
$_SESSION['fondo']       =  trim($datos1['fondo']);
$_SESSION['logo']		  = trim($datos1['url']); 
 

$data = $_SESSION['ruc_registro'].' '.$_SESSION['razon'];

echo $data;

?>
 