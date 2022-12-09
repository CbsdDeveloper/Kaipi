<?php

session_start( );


$email = "https://srienlinea.sri.gob.ec/sri-catastro-sujeto-servicio-internet/rest/ConsolidadoContribuyente/existePorNumeroRuc?numeroRuc=2390031494001";


// Create a new cURL resource with URL to POST
$ch = curl_init($email);

// We set parameter CURLOPT_RETURNTRANSFER to read output
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$post ='';
// Let's pass POST data
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// We execute our request, and get output in a $response variable
$response = curl_exec($ch);

echo $response;

// Close the connection
curl_close($ch);


 /*

$path="../../archivos/pdf/"; 

$directorio=dir($path); 
        echo "Directorio ".$path.":<br><br>"; 
        
        while ($archivo = $directorio->read()) { 
        
            echo $archivo."<br>"; 
        } 
        
        $directorio->close();
        
        */

?>