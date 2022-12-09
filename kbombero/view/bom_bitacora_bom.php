<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>KGestiona - Bomberos</title>
	
    <!--  INICIALIZACION DE PLANTILLA BOOTSTRAP ---------------------------------->
	
    <?php  require('Head.php')  ?> 
	
	
	<!--  FUNCIONES DEL FORMULARIO JAVASCRIPT ---------------------------------->
 
 	<script type="text/javascript" src="../js/bom_bitacora_bom.js"></script> 
 
	
	
</head>
	
<body>

	
	<!--  CABECERA INICIO DE OPCIONES DE LA PLATAFORMA  ---------------------------------->
	
	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
 	
	
	<!--  MENU LATERAL DE OPCIONES DE LA PLATAFORMA  ---------------------------------->
	
	<div id="mySidenav" class="sidenav" >
		
		<div class="panel panel-primary">
			
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
			
				<div class="panel-body">
					
					<div id="ViewModulo"></div>
					
				</div>
			
		</div>
		
   </div>
	
	
    <!-- CONTENIDO DEL FORMULARIO PRINCIPAL -->
       
    <div class="col-md-12"> 
      
       		 <!-- TAB DE INFORMACION  -->
		
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
			   
			   		<!-- FORMULARIO DE BUSQUEDAS PRINCIPAL -->
			   
                 		<li class="active">
							<a href="#tab1" data-toggle="tab"> 
								<span class="glyphicon glyphicon-th-list"></span> <b>LISTA DE BITACORA</b>  
			   				</a>
						</li>
	 
			   		 <!-- FORMULARIO DE INFORMACION DE DATOS -->
			   
                  		<li>
							<a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Formulario de Ingreso
							</a>
                  		</li>
			   
			   	 
			   
	 				
	 
           </ul>
                    
           <!---------------------------------------------------------->
           <!-- CONTENIDO  DEL FORMULARIO -->
      	   <!---------------------------------------------------------->
		
           <div class="tab-content">
			   
          					<!-- FORMULARIO DE BUSQUEDAS PRINCIPAL -->
           
							 <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

							  <div class="panel panel-default">

								  <div class="panel-body" > 

									<div class="col-md-12" > 

													 <div class="alert alert-info">

														 <div class="row">
															 
															 		<!-- FILTRO DE INFORMACION FORMULARIO DE BUSQUEDAS PRINCIPAL -->

																	<div id = "ViewFiltro" > </div>

																	 

																	<div class="col-md-4" style="padding-top: 5px;">

																		<button type="button" class="btn btn-sm btn-primary" id="load">
																			<i class="icon-white icon-search"></i> Buscar</button>

																	 
																	</div>

														</div>

													</div>

									 </div> 

									   <div class="col-md-12"> 

										      <!-- GRILLA DE INFORMACION FORMULARIO DE BUSQUEDAS PRINCIPAL -->
										   
												<table id="jsontable" class="display table-condensed"   width="100%">
												 <thead>
												   <tr>   
															<th width="10%">Codigo</th>
															<th width="20%">Usuario/Responsable</th>
															<th width="10%">Fecha</th>
															<th width="10%">Peloton</th>
															<th width="30%">Novedad</th>
															<th width="10%">Estado</th>
															<th width="10%"></th>
 												   </tr>
												</thead>
											 </table>

									 </div>  
									  
							 

								  </div>  

							 </div> 

							</div>
             		
            				<!-- FORMULARIO DE INFORMACION DE DATOS -->
             
							 <div class="tab-pane fade in" id="tab2">
								 
								<div class="panel panel-default" style="padding: 1px">
									
										<div class="panel-body" style="padding: 1px"> 
											
											 <!-- FORMULARIO DE INFORMACION DE INGRESO -->
											
											
											<div class="alert alert-success">
														  <strong>TIPS!</strong></br> 1. Para crear un registros presione el icono + NUEVO, complete la informacion base.	</br>
									2. Guarde la informacion con el icono guardar (color naranja)</br> 3. Ingrese las novedades y el detalle de la bitacora por grupos.</div>

											 <div id="ViewForm"> </div>

											 <div class="col-md-12" style="padding: 20px;padding-left: 50;padding-right: 50px">
												
												 
												  <!-- FORMULARIO DE DETALLE INFORMACION DE INGRESO -->
												 
												   <ul class="nav nav-pills">
													  
														<li class="active"><a data-toggle="tab" href="#home"><b>1. PERSONAL DE TURNO</b></a></li>
													   
														<li><a data-toggle="tab" href="#menu1"><b>2. NOVEDADES DE LA ESTACION</b></a></li>
													   
														<li><a data-toggle="tab" href="#menu2">3. PARQUE AUTOMOTOR DE LA ESTACION</a></li>
													   
														<li><a data-toggle="tab" href="#menu3">4. EQUIPOS, HERRAMIENTAS Y MATERIALES</a></li>
													   
													   <li><a data-toggle="tab" href="#menu4">5. EVIDENCIA FOTOGRAFICA</a></li>
													  
													  </ul>

												 
													  <div class="tab-content">
														  
														<div id="home" class="tab-pane fade in active">
															
																 <div class="col-md-12" style="padding: 20px">
																		  <button type="button" class="btn btn-info btn-sm" onclick="LimpiaPersonal()">Agregar Personal</button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewGrillaPersonal"> </div>

																	</div>	 
															
														</div>
														  
														  
														  
														<div id="menu1" class="tab-pane fade">
														  
																 <div class="col-md-12" style="padding: 20px">
																		  <button type="button" class="btn btn-info btn-sm" onclick="LimpiaActividades()">Agregar Actividades</button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewGrillaActividades"> </div>

																	</div>	 
															
														</div>
														<div id="menu2" class="tab-pane fade">
														
																 <div class="col-md-12" style="padding: 20px">
																		  <button type="button" class="btn btn-info btn-sm" onclick="LimpiaVehiculos()">Agregar Novedades Vehiculos</button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewGrillaVehiculos"> </div>

																	</div>	 
															
														</div>
														  
														<div id="menu3" class="tab-pane fade">
															
														  <div class="col-md-12" style="padding: 20px">
																		  <button type="button" class="btn btn-info btn-sm" onclick="LimpiaMateriales()">Agregar Novedades</button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewGrillaMateriales"> </div>

																	</div>	 
														</div>
														  
														  
														  <div id="menu4" class="tab-pane fade">
															
														  <div class="col-md-12" style="padding: 20px">
																		  <button type="button" class="btn btn-info btn-sm" onclick="openFile()">Cargar Imagen</button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		 	<div class="col-md-6" style="padding: 20px">
																				
																		    <img id="url" name="url" src="../../kimages/adm_mante.png" width="540" height="390" /> </div>	
																	</div>	 
														</div>
														  
													  </div>

												 
												
											 
												
											 </div>

									   </div>
								  </div>

							 </div>
			   
              
							 
			 	   
          	 	</div>
		   
 		</div>
	
	
	
 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
 
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">NOVEDADES DE PERSONAL</h4>
		   </div>
			   <form action="../model/Model-bom_bitacora_bom_01.php" method="POST" id="fo2"   name="fo2" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormPersonal"> var</div> 


											   <div id="guardarDocumento" style="padding: 5px;" align="center"></div>   
										
										
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									

									  <button  type="submit" class="btn btn-sm btn-primary">
									 <i class="icon-white icon-search"></i> Guardar</button> 
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
				 
			</form>
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->


   <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
 
 <div class="modal fade" id="myModalActividad" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ACTIVIDADES GENERALES</h4>
		   </div>
			   <form action="../model/Model-bom_bitacora_bom_02.php" method="POST" id="fo33"   name="fo33" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewActividad"> var</div> 


											   <div id="guardarActividad" style="padding: 5px;" align="center"></div>   
										
										
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									

									  <button  type="submit" class="btn btn-sm btn-primary">
									 <i class="icon-white icon-search"></i> Guardar</button> 
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
				 
			</form>
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

   

	   <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
 
 <div class="modal fade" id="myModalCarro" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ACTIVIDADES GENERALES MOVILIZACION</h4>
		   </div>
			   <form action="../model/Model-bom_bitacora_bom_03.php" method="POST" id="fo4"   name="fo4" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewCarro"> var</div> 


											   <div id="guardarCarro" style="padding: 5px;" align="center"></div>   
										
										
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									

									  <button  type="submit" class="btn btn-sm btn-primary">
									 <i class="icon-white icon-search"></i> Guardar</button> 
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
				 
			</form>
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

       
	
		   <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
 
 <div class="modal fade" id="myModalMaterial" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ACTIVIDADES GENERALES MATERIALES</h4>
		   </div>
			   <form action="../model/Model-bom_bitacora_bom_05.php" method="POST" id="fo5"   name="fo5" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewMaterial"> var</div> 


											   <div id="guardarMaterial" style="padding: 5px;" align="center"></div>   
										
										
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									

									  <button  type="submit" class="btn btn-sm btn-primary">
									 <i class="icon-white icon-search"></i> Guardar</button> 
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
				 
			</form>
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

		  
      </div>
      
    </div>
  </div>
	

 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
	 

	
 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
	 
	
   <div id="FormPie"></div>  
 
 </body>
	
</html>
