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
		   
		    <div class="col-md-12"> 
		      <div class="col-md-5">
						   <div class="panel panel-default">
							 <div class="panel-heading">Gestión Administrativo PAC</div>
							  <div class="panel-body">
								  <div  style="width:100%; height:250px;">
									  <?php $gestion->_tipo_pac() ?>
						         </div>
							  </div>
						 </div>	   
				 </div>
		   
 		 		 
		      <div class="col-md-7">
						   <div class="panel panel-default">
							 <div class="panel-heading">Contratos/Garantias</div>
							  <div class="panel-body">
									 <?php $gestion->_tipo_garantias() ?>  
						   		     <button type="button" class="btn btn-danger"><?php $gestion->_vence(5) ?> polizas por vencer <br> ( 5 dias )</button>
								     <button type="button" class="btn btn-warning"><?php $gestion->_vence(15) ?> polizas por vencer <br> ( 15 dias )</button>
							  </div>
						 </div>	   
				 </div>
	        </div>
		   		 
		   
		    <div class="col-md-12"> 
		      <div class="col-md-5">
						   <div class="panel panel-default">
							 <div class="panel-heading">Vehiculos</div>
							  <div class="panel-body">
								  
								   <div class="col-md-10">
									 <?php $gestion->_tipo_vehiculos() ?>
								    
								     <?php $gestion->_estado_vehiculo() ?>
						           </div>
							  </div>
						 </div>	   
				 </div>
		   
 		 		 
		      <div class="col-md-7">
						   <div class="panel panel-default">
							 <div class="panel-heading">Combustibles</div>
							  <div class="panel-body">
									<?php $gestion->_combustible_p() ?>
								  
								  <div class="col-md-7">
						      
								     <?php $gestion->_combustible_galones() ?>
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