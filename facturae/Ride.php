<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;


$a          = $_GET['us'];
$b          = $_GET['db'];
$c          = $_GET['ac'];
$ruc        = $_GET['ru'];
$autorizacion = $_GET['au'];

$bd->conectar($a,$b,$c);

 
require_once(dirname(__file__)."/RideSRI/RideSRI.php");

$ruta = dirname(__file__);

 
//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );

 

$imagen = trim($ADatos['carpeta']);

$carpeta = 'xml';

$archivo = '/'.$carpeta.'/'.trim($autorizacion);

$logo    = '/firmas/'.$imagen;


$echo = true; // solo para ver los procesos

// Muestro una Factura
$file_autorized = $ruta.$archivo.'_A.xml';

 $logo_path=$ruta.$logo;

 
try{
    
    $ride = new RideSRI();
    // Arg1 ruta a archivo fisico xml
    // Arg2 logo ride
    // Arg3 I=Visualizar, D=Descargar
    // Arg4 true=online, false=offline
    $FacturaElectronica = $ride->createRide($file_autorized, $logo_path, 'D', true); // Instancio la clase, y muestro el ride
    
 
    
}catch (Exception $e) {
    echo '<br/><b>ERROR AL EJECUTAR EL SCRIPT</b><br/>';
    echo '<b>Excepción Capturada[</b> ',  $e->getMessage(), "]\n";
}
