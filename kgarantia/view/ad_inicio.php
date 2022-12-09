<?php
require '../model/_resumen_inicio.php'; /*Incluimos el fichero de la clase objetos*/
$gestion   = 	new proceso;
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
       
    <script type="text/javascript" src="../js/modulo.js"></script>
 
</head>
<body>

<div id="main">
	
	<div class="col-md-12" role="banner">
 	   <div id="NavMod"></div>
 	</div> 
 	
	<div id="mySidenav" class="sidenav">
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
   </div>
	
       <!-- Content Here -->
    <div class="col-md-12"> 
       <!-- Content Here -->
	   <div class="row">
		   
		      <div class="col-md-7">
						   <div class="panel panel-default">
							 <div class="panel-heading">Gestión Vehiculos</div>
							  <div class="panel-body">
									  <div class="col-md-3" align="center">
 								          <img src="../../kimages/adm_vehiculo.png" width="100" height="100" alt=""/> 
										   <h5 style="font-weight: bolder" align="center"><a href="ad_carro">Vehiculos</a></h5>
 								      </div> 
								  
								      
								  
								      <div class="col-md-3" align="center">
										  <img src="../../kimages/adm_chofer.png" width="100" height="100" alt=""/> 
										   <h5 style="font-weight: bolder" align="center"><a href="ad_chofer">Chofer</a></h5>
 								      </div> 
								  
								       <div class="col-md-3" align="center">
 								          <img src="../../kimages/adm_mante.png" width="100" height="100" alt=""/> 
										    <h5 style="font-weight: bolder" align="center"><a href="ad_mante">Mantenimiento</a></h5>
 								      </div> 
								  
								      <div class="col-md-3" align="center">
 								          <img src="../../kimages/adm_combustible.png" width="100" height="100" alt=""/> 
										  <h5 style="font-weight: bolder" align="center"><a href="ad_combustible">Combustible Vehiculos</a></h5>
 								      </div> 
								  
								   <div class="col-md-3" align="center">
 								          <img src="../../kimages/fuel1.png" width="100" height="100" alt=""/> 
										  <h5 style="font-weight: bolder" align="center"><a href="ad_combustible_in">Combustibles Uso Interno</a></h5>
 								      </div> 
								  
								    <div class="col-md-3" align="center">
 								          <img src="../../kimages/adm_moviliza.png" width="100" height="100" alt=""/>  
										 <h5 style="font-weight: bolder" align="center"><a href="ad_orden">Orden de Movilización</a></h5>
 								      </div> 
								  
								   <div class="col-md-3" align="center">
 								          <img src="../../kimages/servicios.png" width="100" height="100" alt=""/>  
										 <h5 style="font-weight: bolder" align="center"><a href="ad_combustible_re">Registro de Ordenes Estacion</a></h5>
 								      </div> 
						      
						     </div>
						 </div>	   
				 </div>
		   
   
		      <div class="col-md-5">
						   <div class="panel panel-default">
							 <div class="panel-heading">Gestión Vehiculos</div>
							  <div class="panel-body">
								 <div class="col-md-12" align="center">	   
								  <?php $gestion->_tipo_vehiculos() ?>
								    
								  <?php $gestion->_estado_vehiculo() ?>
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