<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_extra.js"></script> 
 	 	
	 	 		 
	 <style type="text/css">
  		#mdialTamanio{
  					width:55% !important;
		}
	   #mdialTamanio1{
  					width: 85% !important;
		}
	 
   </style>
	
</head>
<body>

<!-- ------------------------------------------------------ -->
 <!-- ------------------------------------------------------ -->
 <div id="main">
	
 <!-- ------------------------------------------------------ -->  
	 
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
 	
  <!-- ------------------------------------------------------ -->  
	 
 	<div class="col-md-12"> 
      
					 <!-- Content Here -->

				   <ul id="mytabs" class="nav nav-tabs">          

								<li class="active"><a href="#tab1" data-toggle="tab"></span>
									<span class="glyphicon glyphicon-th-list"></span> CONTROL DE INGRESO</a>
								</li>
								<li><a href="#tab2" data-toggle="tab">
									<span class="glyphicon glyphicon-link"></span> Detalle por Ingresos</a>
								</li>

				   </ul>

				   <!-- ------------------------------------------------------ -->
				   <!-- Tab panes -->
				   <!-- ------------------------------------------------------ -->

				   <div class="tab-content">

				   <!-- ------------------------------------------------------ -->
				   <!-- Tab 1 -->
				   <!-- ------------------------------------------------------ -->

						 <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

							  <div class="panel panel-default">

								  <div class="panel-body" > 

									 <div class="col-md-12"> 

											  <div class="alert alert-info">
												<div class="row">

													  <div class="col-md-12"  style="padding-top: 5px;">
														   <div id="ViewFiltro"> </div>
													   </div> 

													   <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px; padding-left: 25px"> 


															  <button type="button" class="btn btn-sm btn-default" id="load">
																<i class="icon-white icon-search"></i> BUSCAR INFORMACION</button>

														 	  <button type="button" data-toggle="modal" onClick="VerNovedades()"   data-target="#myModalNov" class="btn btn-sm btn-success" id="loadCnov">
																<i class="icon-white icon-ambulance"></i> Novedades de Rol</button>
 														   
														   
														      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModalGenerar"> <i class="icon-white icon-archive"></i> Generar x Regimen</button>


														      <button type="button" class="btn btn-sm btn-default" id="loadC">
																Generar por Programa</button>


															


															



																<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModalImportar">Importar</button>





															<button type="button" class="btn btn-sm btn-default" id="loadELiminar">
																<i class="icon-white icon-trash"></i> Eliminar</button>


														</div> 
													</div> 
												 </div> 		

									 </div> 


									  <div class="col-md-12"> 

											   <div id="ViewProceso"> </div>

									 </div>  

									  <div id="ViewSave"> </div>

										<hr style="width:50%;text-align:left;margin-left:0">

									  <div class="col-md-12" style="padding-top: 15px;padding-top: 15px"> 

										  <button type="button" onclick="window.open('nom_horas', '_self')" class="btn btn-success btn-sm">Horas E/S</button>
										  <button type="button" onclick="window.open('nom_extra', '_self')" class="btn btn-info btn-sm">Ingreso</button>
										  <button type="button" onclick="window.open('nom_descuento', '_self')" class="btn btn-warning btn-sm">Descuentos</button>
										  <button type="button" onclick="window.open('nom_roles', '_self')" class="btn btn-danger btn-sm">Resumen Rol</button>


									 </div>  

									  <input type="hidden" id="id_rol" name="id_rol">
									  <input type="hidden" id="id_periodo" name="id_periodo">
									  <input type="hidden" id="anio" name="anio">
									  <input type="hidden" id="mes" name="mes">

								 </div>  
							 </div> 
					 </div>


						 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">

							  <div class="panel panel-default">

									<div class="panel-body" > 

										<div class="col-md-4"> 

											  <div class="alert alert-success">
												<div class="row">

													  <div class="col-md-12"  style="padding-top: 5px;">
														   <select id="filtroDes" name="filtroDes" class="form-control"></select>
													   </div> 

														<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px; padding-left: 25px"> 

															   <button type="button" class="btn btn-sm btn-success" id="loadBuscar">
																<i class="icon-white icon-search"></i> Búsqueda</button>

														</div> 

													</div> 
												 </div> 		

									 </div> 

										<div class="col-md-8"> 

										   <div id="ViewFormDescuento" style="font-size: 11px"> </div>

										</div>		
								   </div>
							  </div>
						 </div>


					 </div>

 		</div>
 

 
   
	 <div class="container"> 
			
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  
  	  <div class="modal-dialog" id="mdialTamanio">
		  
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 class="modal-title"> <b>ROL DE PERSONAL</b></h5>
		  </div>
			
		<div class="modal-body">
			
 			          <div class="panel panel-default">
  				         <div class="panel-body">
							   <div class="row">
								 <div id="ViewFormRolPersona"> var</div> 
 							   </div>	   
					     </div>
   					 </div>
				  </div>
 				  <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 
	
		
	  

	
 		  <!-- Modal -->
	
	 <div class="modal fade" id="myModalImportar" role="dialog">
			 
 			  <div class="modal-dialog" id="mdialTamanio1">
    
      		   <!-- Modal content-->
					  
    				  <div class="modal-content">
       
						  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Importar Datos</h4>
						 </div>
		  
      				      <div class="modal-body">
			
          		 <div class="modal-body">
			   
 			          <div class="panel panel-default">
  				         <div class="panel-body">
							   <div class="row" style="padding: 10px">
								   <p style="font-size: 14px">	
								   1. Seleccione el rubro para importar la informacion<br>
								   2. Importe la informacion de acuerdo formato:  
								   </p>
							       <p style="font-size: 14px">	
									   <b> CEDULA | VALOR  (Formato CVS)</b>
								   </p>	   
								   
							     <iframe width="100%" id="archivocsv" name = "archivocsv" height="250px" src="../model/Model-xls_ingresos.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
								   
 							   </div>	   
					     </div>
   					 </div>
				  </div>
				  
        	 </div>
						  
						 <div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						 </div>
     				 </div>
      		   </div>
			 
 		 </div>
	

	
	<div class="modal fade" id="myModalGenerar" role="dialog">
			 
 			    <div class="modal-dialog">
    
     			 <!-- Modal content-->
				  
      			 <div class="modal-content">
		  
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Generar Datos</h4>
					</div>
        
					<div class="modal-body">
						
					   <div class="modal-body">
								  <div class="panel panel-default">
									 <div class="panel-body">
										   <div class="row" style="padding: 10px">
											   <p style="font-size: 14px">	
											   1. Seleccione el rubro para importar la informacion<br>
											   2. Generar la informacion de acuerdo al rubro:  
											   </p>
												<p style="font-size: 14px">	

														<select class="form-control" name="rubro_total" id="rubro_total"></select>

												  </p>	

												 <p>	
												  <div id="ViewFormproceso" style="font-size: 11px"> </div>

												 </p>	
										   </div>	   
									 </div>
								 </div>
							  </div>
					 
						<div class="modal-footer">

					   <button type="button" class="btn btn-danger"  onClick="GenerarDatosRegimen()">Generar Datos Regimen</button>

					   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
      		  </div>
			 
       			    </div>
				  
				 </div><!-- /.modal-dialog -->
			
				</div><!-- /.modal -->
   </div>  

				  
	 <div class="container"> 

			  <div class="modal fade" id="myModalNov" tabindex="-1" role="dialog">
			  <div class="modal-dialog" id="mdialTamanio1">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h5 class="modal-title"> <b>ACCIONES DE PERSONAL</b></h5>
				  </div>
						  <div class="modal-body">
							  <div class="panel panel-default">
								 <div class="panel-body">
									   <div class="row">
										 <div id="ViewFormAccion"> var</div> 
										   
										   <div id="AccionCreada"> var</div> 
									   </div>	   
								 </div>
							 </div>
						  </div>
					
						  <div class="modal-footer">
							<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
						  </div>
				</div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		   </div>  
 		 
	
 
	
  <!-- Page Footer-->
    <div id="FormPie"></div>  

 </div>   
 </body>
</html>
