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
		      <div class="col-md-6">
						   <div class="panel panel-default">
							 <div class="panel-heading">Gestión BLD</div>
							  <div class="panel-body">
									 <div id="ParametroContable"></div>	 
						      
							  </div>
						 </div>	   
				 </div>
		   
 		 		<div class="col-md-6">
						 <div class="panel panel-default">
							 <div class="panel-heading">Bienes de Larga Duración -  Grupo</div>
							  <div class="panel-body">
									  <div class="widget box">
                                                <div class="widget-content">
                                                
                                               	 <div id="ViewGrupo"></div>
                                                         
                                                </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
				 </div>
		  	  </div>    
		   
		    <div class="col-md-12">
						   	 <script src="https://code.highcharts.com/highcharts.js"></script>
							 <script src="https://code.highcharts.com/modules/exporting.js"></script>
							 <script src="https://code.highcharts.com/modules/export-data.js"></script>

							 <script type="text/javascript" src="../js/gestion_grafico.js"></script> 

				
					  <div class="col-md-6">
						 <div class="panel panel-success">
							 <div class="panel-heading">Unidades Bienes de Larga Duración -  Unidades</div>
							  <div class="panel-body">
 									 
												 
 											<div id="ViewUnidad" style="height: 350px"> </div>
 												 
									   
  										 		
  								</div><!--/.row-->
 							</div>
						</div>
				
				
				<div class="col-md-6">
						 <div class="panel panel-default">
							 <div class="panel-heading">Bienes de Larga Duración -  Ubicacion</div>
							  <div class="panel-body">
									  <div class="widget box">
                                                <div class="widget-content">
                                                
                                               	 <div id="ViewSede"></div>
                                                         
                                                </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
				 </div>
			 		 
 		  </div>    
      
    </div>   
	<!-- Page Footer-->
	
	    <div id="FormPie"></div>    
</body>
</html>