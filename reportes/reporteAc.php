<?php
session_start( );   

    require 'inicio.php';   
 	
    $g  = 	new componente;

	$tipo = $_GET["tipo"];
	
    $file	 = $g->_getCarpeta( $tipo );

    $formato = $g->_getFormato();
 
    $codigo 	 = $_GET["codigo"];
 	
	$file = trim($file).'?codigo='.$codigo;

	echo '<script>window.location.href = "'.$file.'" </script>';

?>