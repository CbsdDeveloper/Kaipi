<?php
	session_start( );

     require '../model/compra_panel.php';    

     $gestion   = 	new proceso;
 
  	  
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/visor-compra.js"></script> 
 	 		 
</head>
<body>

<!-- ------------------------------------------------------ -->

<div id="mySidenav" class="sidenav">
 
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 
 </div>
 
<!-- ------------------------------------------------------ -->
 <div id="main">
	
	<!-- Header -->
	  <div class="col-md-12" role="banner"> 
		  <div id="MHeader"></div>
	 </div>
 	
  <!-- ------------------------------------------------------ -->  
   <div class="col-md-12"> 
       <!-- Content Here -->
       	 <div class="col-md-12"> 
			<script type="text/javascript" src="../js/gestion.js"></script>
             <script src="https://code.highcharts.com/highcharts.js"></script>
      		 <script src="https://code.highcharts.com/modules/exporting.js"></script>
   			  <div class="panel panel-success">
									  <div class="panel-heading">Gestión Mensual de Compras</div>
									  <div class="panel-body">
									 	  <script type="text/javascript" src="../js/gestionv.js"></script>
										   <div id="div_grafico"  style="height: 250px"> </div>
									  </div>
   				</div>
		 </div>	 
		 <div class="col-md-12"> 
			 <div class="panel panel-info">
				   <div class="panel-heading">Gestión Mensual de Compras</div>
				       <div class="panel-body">
						
						 <div class="col-md-6"> 
							  <div class="row"> 
								   <div class="alert alert-warning">
										<h4>Movimiento de productos adquiridos </h4> 
										<?php    $gestion->producto(); ?> 
								   </div>		
							  </div>	  
						 </div>	 
						 <div class="col-md-6"> 
							   <div class="row"> 
								   <div class="alert alert-info">
							  			<h4>Top 10 Proveedores  </h4> 
											<?php    $gestion->proveeedor(); ?> 
								   </div>	
						       </div>	
						 </div>	 
						    <div class="col-md-6"> 
								   <div class="row"> 
								 	  <div class="alert alert-success">
										 <h4>Resumen Mensual de Compras  </h4> 
										 <?php    $gestion->mensual(); ?> 
									</div>
							</div>		   
						 </div>	 
						   
						   
					  </div>	   
			 </div>  
		 </div>	 
		 
	      
         
          
 	 </div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
