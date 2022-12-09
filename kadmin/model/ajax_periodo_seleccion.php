<?php
session_start( );

$anio		=   $_GET["anio"];


$_SESSION['anio'] = $anio;

 

$response = 'Periodo de gestion '.$anio;

echo $response;



?>