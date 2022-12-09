<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ac_bienes_componente.js"></script> 
 	 		 
</head>
<body>

<?php
	session_start( );

	
	
	
	  if (isset($_GET["id"]))	{
		
		  require '../controller/Controller-ac_bienes_componente.php';  
		  
		  
		   $id 				=     $_GET["id"];
		  
		  
		   $ref 				=     $_GET["ref"];
		
		  $gestion   = 	new componente;
		  
		  $gestion->Formulario( $id ,$ref );
	
		 }
	
	
	
?>	
 
  

	
 
 </body>
</html>
