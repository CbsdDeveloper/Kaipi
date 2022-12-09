<?php
	session_start( );

    if (empty($_SESSION['usuario']))  {
	
	    header('Location: ../../kadmin/view/login');
 	
	}
?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
    <script type="text/javascript" src="../js/modulo_pyme.js"></script>
 	
	 
 
</head>

<body>

<div id="main">
	
	<div class="col-md-12" role="banner">
 	   <div id="NavMod"></div>
 	</div> 
 	
	 
	
       <!-- Content Here -->
    <div class="col-md-12"> 
       <!-- Content Here -->
	   <div class="row">	  
			  <div class="col-md-12">
				  
							  <div class="col-md-8">
									 <div class="panel panel-success">
										 <div class="panel-heading">PROCESO   VENTA</div>
										  <div class="panel-body" style="background-color: #000000" align="center">
												 <div id="ParametroVentas"></div>	   
										  </div>
									 </div>
								</div>  
				  
								 
				  
								 <div class="col-md-4">  
									<div class="panel panel-info">
										 <div class="panel-heading">REDES SOCIALES</div>
										  <div class="panel-body">
												  <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FKaipiGrupoEmpresarial%2F&tabs=timeline&width=340&height=370&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=551521728615781" width="340" height="280" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
										  </div>
									</div>
								 </div>	
				</div>

		        <div class="col-md-12">
					
					 
				   
					
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
 