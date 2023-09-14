<?php
session_start( );
require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
require_once(dirname(__file__)."/RideSRI/RideSRI.php");
$ruta = dirname(__file__);


$id          = $_GET['id'];

$Array_Cabecera = $bd->query_array(
    'doctor_vta',
    'idcliente, tipocomprobante, comprobante1, secuencial, codestab,
     coddocmodificado, numdocmodificado, fechaemision,
     secuencial1,
     cab_autorizacion, fechaemisiondocsustento, fecha_factura, estab1, ptoemi1',
    'id_diario ='.$bd->sqlvalue_inyeccion($id,true)
    );

$ruc         = $_SESSION['ruc_registro'];

//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );



$sql = "UPDATE inv_movimiento
		SET 	estado=".$bd->sqlvalue_inyeccion('notacredito', true)."
 		WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true). " and  
 		       estado=".$bd->sqlvalue_inyeccion('aprobado', true);

$bd->ejecutar($sql);



$imagen = trim($ADatos['carpeta']);

$carpeta = 'xml';

$archivo = '/'.$carpeta.'/'.trim($Array_Cabecera['cab_autorizacion']);

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
    $FacturaElectronica = $ride->createRide($file_autorized, $logo_path, 'I', true); // Instancio la clase, y muestro el ride
    
 
    
}catch (Exception $e) {
    echo '<br/><b>ERROR AL EJECUTAR EL SCRIPT</b><br/>';
    echo '<b>Excepción Capturada[</b> ',  $e->getMessage(), "]\n";
}
