<?php
session_start( );
require '../controller/Controller-prov_proveedor.php';    

$gestion   = 	new componente;

  
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/proveedor.js"></script> 
 	 		 
	<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
             	 jQuery('#result').html(data);

            	 jQuery( "#result" ).fadeOut( 1600 );

            	 jQuery("#result").fadeIn("slow");
            
			}
        })        
        return false;
    }); 
 })
</script>	
</head>
<body>
  <?php  $gestion->Formulario( );
	
		if (isset($_GET['accion']))	{

			$accion    = $_GET['accion'];

			$id        = $_GET['id'];
 
			$gestion->consultaId($accion,trim($id));


		}  	
  ?>	
 
  </body>
</html>
