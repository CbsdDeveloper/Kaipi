<?php 
require_once("../RideSRI/RideSRI.php");
 

$archivo          = trim($_GET['xml']);
  

$imagen           = base64_decode(trim($_GET['file']));


$logo    = '../firmas/'.$imagen;


$file_autorized = '../xml/'.$archivo.'_A.xml';


$logo_path      = $logo;

 
	
        try{	
        	
        	$ride = new RideSRI();
        	// Arg1 ruta a archivo fisico xml
        	// Arg2 logo ride
        	// Arg3 I=Visualizar, D=Descargar
        	// Arg4 true=online, false=offline 
        	// NOTA le puse offline xq no esta autorizada y para q aparezca la clave como autorizacion
        	$ride->createRide($file_autorized, $logo_path, 'I', true); // Instancio la clase, y muestro el ride
        	
        }catch (Exception $e) { 
        	echo '<br/><b>ERROR AL EJECUTAR EL SCRIPT</b><br/>';
        	echo '<b>Excepción Capturada[</b> ',  $e->getMessage(), "]\n";	
        } 
  
?>