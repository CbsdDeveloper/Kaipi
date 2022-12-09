<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>KGestiona - Hoja de Ruta</title>
	
    <!--  INICIALIZACION DE PLANTILLA BOOTSTRAP ---------------------------------->
	
    <?php  require('Head.php')  ?> 
	
	
	
	 <script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
	
	<!--  FUNCIONES DEL FORMULARIO JAVASCRIPT ---------------------------------->
 
 	<script type="text/javascript" src="../js/mis_hojas.js"></script> 
 <!-- 
	
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>--->
		
		 
	
</head>
	
<body>
	
	

	
	<!--  CABECERA INICIO DE OPCIONES DE LA PLATAFORMA  ---------------------------------->
	
	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
 	
	
	<!--  MENU LATERAL DE OPCIONES DE LA PLATAFORMA  ---------------------------------->
	
 
	
	
    <!-- CONTENIDO DEL FORMULARIO PRINCIPAL -->
       
    <div class="col-md-12"> 
      
       		 <!-- TAB DE INFORMACION  -->
		
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
			   
			   		<!-- FORMULARIO DE BUSQUEDAS PRINCIPAL -->
			   
                 		<li class="active">
							<a href="#tab1" data-toggle="tab"> 
								<span class="glyphicon glyphicon-th-list"></span> <b>HOJA DE RUTA</b>  
			   				</a>
						</li>
	 
			   		 <!-- FORMULARIO DE INFORMACION DE DATOS -->
			   
                  		<li>
							<a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> ACTIVIDADES DIARIAS
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
										
										  <div class="alert alert-success">
														  <strong>TIPS!</strong></br> 1. Para registrar una actividad seleccione el tipo y ponga el texto de la actividad.	</br>
									2. Guarde la informacion presionando el boton de + agregar  (color azul)</br> 3. La información se registra por sesion, no es editable verifique antes de guardar</div>

												<div class="col-md-12" > 	 
															 
															 		<!-- FILTRO DE INFORMACION FORMULARIO DE BUSQUEDAS PRINCIPAL -->

																	<div id = "ViewNovedad" > </div>
								 
								 				 </div>					 
 												 <div class="col-md-12" > 	 			 
																			<div class="col-md-4" style="padding-bottom: 10px;padding-top: 10px">

																				<button type="button" class="btn btn-sm btn-primary" id="load" onClick="AprobarBitacora()">
																					<i class="icon-white icon-plus"></i> Agregar Actividad</button>

 																			</div>
 												 </div> 
									 </div> 
									  
									


									   <div class="col-md-12"> 

										      <div id="ViewGrillaPersonal"> </div>

									 </div>  
									  
							 

								  </div>  

							 </div> 

							</div>
             		
            				<!-- FORMULARIO DE INFORMACION DE DATOS -->
             
							 <div class="tab-pane fade in" id="tab2">
								 
								<div class="panel panel-default" style="padding: 1px">
									
										<div class="panel-body" style="padding: 1px"> 
											
											 <!-- FORMULARIO DE INFORMACION DE INGRESO -->
											
											<div id = "ViewForm" > </div>
											
										  <div class="col-md-12">
												
											  
											   <h4>DIARIO DE NOVEDADES POR DIA	 </h4>	  
											
												 <div class="col-md-3" style="padding: 10px">
													 
													 <input type="date" class="form-control" name="fechad" id="fechad">
													
												 </div>	 
											  
											   <div class="col-md-3" style="padding: 10px">
													 
													 <input type="date" class="form-control" name="fechah" id="fechah">
													
												 </div>	 
											  
											  	<div class="col-md-3" style="padding: 10px">
												  
											 		 <button type="button" class="btn btn-sm btn-primary" onClick="BusquedaNovedad()">
																			<i class="icon-white icon-search"></i> ACTIVIDADES DIARIAS</button>
													
													
													 <button type="button" class="btn btn-sm btn-info" onClick="BusquedaNota()">
																			<i class="icon-white icon-search"></i> HOJA DE RUTA - PERIODO</button>
													
													
													<button type="button" class="btn btn-sm btn-default" id="loadprint1" title="Imprimir Reporte">  
																	<i class="icon-white icon-print"></i></button>
											   </div>	 
											  
										 </div>	  

											

											 <div class="col-md-12" style="padding: 20px;padding-left: 50;padding-right: 50px">
												
												  <div id="ViewFormDiario"> </div>
											  
												
											 
												
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
			 <h4 class="modal-title">CONTROL VEHICULAR</h4>
		   </div>
			 
			   <form action="../model/Model_bom_nov_01.php" method="POST" id="fo_carro"   name="fo_carro" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormControl"> var</div> 
 
 										
										
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
									
									<div id="guardarDocumento" style="padding: 5px;" align="center"></div>   
									
 
									  <button  type="submit" class="btn btn-sm btn-primary">  <i class="icon-white icon-search"></i> Guardar</button> 
									
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
 
 <div class="modal fade" id="myModalEmergencia" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ACTIVIDADES INICIO EMERGENCIA</h4>
		   </div>
			   <form action="../model/Model_bom_emergencia01.php" method="POST" id="fo5_emer"   name="fo5_emer" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewEmergencia"> var</div> 
  										
										
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									
											   <div id="guardarEmergencia" style="padding: 5px;" align="center"></div>   
									

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
