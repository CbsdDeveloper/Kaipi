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

<div id="mySidenav" class="sidenav">
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 </div>

<div id="main">
	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="NavMod"></div>
 	</header> 
    
    <div class="col-md-12" style="padding-top: 60px"> 
       <!-- Content Here -->
	   <div class="row">
 		 	
				 <div class="col-md-12">
					  <div class="col-md-6">
							 <div class="panel panel-success">
								 <div class="panel-heading">PROCESO PRE VENTA</div>
								  <div class="panel-body">
										 <div id="ParametroVentas"></div>	   
								  </div>
							 </div>
						</div>  
						<div class="col-md-6">  
							<div class="panel panel-info">
								 <div class="panel-heading">PROCESO POST VENTA</div>
								  <div class="panel-body">
										 <div align="center" id="ParametropostVentas"></div>	   
								</div>
							</div>
						 </div>	
				 </div>
		   
		        <div class="col-md-12">
					
					<div class="col-md-4">
						 <div class="row">
 							  <div class="alert alert-danger">
								     <h5> <b>Avance</b></h5>
									 <div id="ActividadUltima3"></div>	   
  							</div>
						</div>
					</div>	
				   
					
					<div class="col-md-4">
						 <div class="row">
 							  <div class="alert alert-info">
								    <h5> <b>Ultima Actividades </b></h5>
									 <div id="ActividadUltima2"></div>	   
  							</div>
						</div>
					</div>	
					
					 <div class="col-md-4">
						 <div class="row">
 							  <div class="alert alert-warning">
 								     <h5> <b>Ultima Actualización de Datos </b></h5>
									 <div id="ActividadUltima1"></div>	   
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
 