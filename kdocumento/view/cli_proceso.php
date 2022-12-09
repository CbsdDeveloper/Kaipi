<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
	<title>Plataforma de Gestión Empresarial</title>
    
	<?php  require('Head.php')  ?> 
    
	<script type="text/javascript" src="../js/cli_proceso.js"></script> 
    
    <style type="text/css">
		
        #mdialTamanio{
        width: 75% !important;
       }
		
    </style>
	
</head>
	
<body>

	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
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
		
          <div class="row">
		   
 		 	     <div class="col-md-12">
					 
 					  <ul id="mytabs" class="nav nav-tabs">
						  
						  <li class="active"><a href="#tab2" data-toggle="tab">
							
                  			<span class="glyphicon glyphicon-link"></span> Definir el Proceso</a>
							
                  		</li>
						  
                   		 
		   
                  		
		   
                  	 </ul>
		
                      <!-- Tab panes -->
		
                      <!-- ------------------------------------------------------ -->
		
					   <div class="tab-content">

						   <!-- Tab 2 --> 

								<div class="tab-pane fade in active" id="tab2"  style="padding-top: 3px">

									 <div class="panel panel-default">

										  <div class="panel-body" > 

											  <div class="col-md-12">
												   <div class="col-md-3" style="padding: 10px">
													   <select class="form-control" id="ctipo" name="ctipo">
													        <option value="-">- Todos los Ambitos -</option>
														    <option value="Interno">Internos</option>
														    <option value="Externo">Externos</option>
 													   </select>
												 </div>	   
											   </div>	
											  
											  
											   <div class="col-md-12" style="padding-left: 20px">
												   
												   <a href="https://app.diagrams.net/" target="_blank" class="btn btn-danger btn-sm"   role="button">Diagramador de Flujos</a>
												   
												   
													<a href="#" class="btn btn-warning btn-sm" onClick="BusquedaGrilla();"  role="button">Pendientes</a>
												  
												   
												   
													<a href="#" class="btn btn-info btn-sm" onClick="BusquedaPublica();"  role="button">Aprobados</a>
											   </div>
											   	   
												   
											  <div class="col-md-12">

													<div id="listaproceso"> </div>
											  </div>	  
											 
										   </div>

									  </div>

								</div>
						   
						   
							   <!-- Tab 1 -->

								    


					  </div>

        	 </div>
	
		  </div>	  
	
</div>
 

 <!-- Modal  registro de datos -->

	<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
	
       <div class="modal-dialog" id="mdialTamanio" style="background-color: #FFFFFF">
      
		   <!-- Modal content-->
		   
           <div class="modal-content" style="background-color: #FFFFFF">
			   
        		<div class="modal-header">
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
         		</div>
			   
          		<div class="modal-body">
					<div class="row">
         						<div id="ViewForm"> </div>
						 </div>
        		</div>
			   
         		<div class="modal-footer">
      		  		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      			</div>
			   
      	   </div>
		   
       </div>
	
    </div>

   	<!-- Page Footer-->
    <div id="FormPie"></div>  
  </body>
</html>
 