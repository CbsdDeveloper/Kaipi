<?php
	session_start( );

     include ('../model/FichaProcesosReportes.php');


   if (isset($_GET['id']))	{
	
	       $gestion   = 	new proceso;
	 
			$id       = $_GET['id'];
 
 }

?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Reporte</title>
	
    <?php  require('../view/Head.php')  ?> 
	
  	<script type="text/javascript">
            function imprimir() {
                if (window.print) {
                       window.print();
					
					    ventana=window.self; 
						ventana.opener=window.self; 
						ventana.close();  
					
					
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
	
	
</head>
    <body onload="imprimir();">
<!-- ------------------------------------------------------ -->
<div class="col-md-12">
	<!-- Header -->
	<h5><b>GESTIÓN DE PROCESOS INSTITUCIONALES</b></h5>
	<h6><b>NOMBRE INSTITUCIÓN<br> 
	       FICHA TÉCNICA DEL PROCESO</b></h6>
	
 

	   <?php  $gestion->ProcesoNombre( $id );  ?>  
	
	   <?php  $gestion->Objetivo( );  ?>  
	
	   <?php  $gestion->Flujo( );  ?>  
                             
         
  </div>  
       
  <!-- Page Footer-->
    <div id="FormPie"></div>  
		
 
 </body>
</html>
 