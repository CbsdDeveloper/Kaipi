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
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 
    
  <script type="text/javascript" src="../js/inicio_pla.js"></script> 
     
</head>

<body>
	
	<!-- MENU SUPERIOR INFORMACION DE SISTEMA Y USUARIO   -->	
 	
	<div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
 	
	<!-- MENU LATERAL DE OPCIONES  -->	
	
	<div id="mySidenav" class="sidenav">
		
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
		
   </div>
	
 
	
 
	
    <div class="col-md-12"> 
		
       <!-- Content Here -->
	    
		<div class="row">
			
 		 	     <div class="col-md-12">
  					   	 
                    <ul id="mytabs" class="nav nav-tabs">      
						
                   
						<li class="active">><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-alert"></span> Gestion FINANCIERA</a>
                  		</li>
                  		 
 			
                   </ul>
		
                     <!-- ------------------------------------------------------ -->
                     <!-- Tab panes -->
                     <!-- ------------------------------------------------------ -->
		
							 <div class="tab-content">

							   <!-- Tab 1 -->

							   <div class="tab-pane fade" id="tab1" style="padding-top: 3px">

								   <div class="panel panel-default">

									  <div class="panel-body" > 

											<div class="col-md-12" style="padding: 10px">

													<div class="col-md-12" style="background-color:#ededed;padding: 10px">
							   
  									    <div class="col-md-10"> 
   										        <div id = "ViewFiltro" > </div>
 										  </div> 
							   			  <div class="col-md-2" style="padding: 10px"> 
											  
											  <button type="button" id="load" class="btn btn-success">Buscar</button>
										 
     								      </div> 
     								  </div>

																 <div class="col-md-12">

																	<h5>Transacciones por periódo</h5>

																	 
																	  <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																				 <thead bgcolor=#F5F5F5> 
																				 <tr> 
																				 <th width="5%">Id</th>
																				<th width="10%">Cpc</th>
																				<th width="8%">Fecha Inicio</th>
																				<th width="7%">(%) Avance</th>
																				<th width="10%">Estado</th>
																				<th width="50%">Detalle</th>
																				<th width="10%">($) Total</th>
																				<th width="10%">Acción</th> 
																				</tr>
																				</thead> 
																				 </table>
																   

																</div>  
											 </div>
								   </div>  
								 </div> 
							</div>

							    <!-- Tab 2 -->
								 
							   <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
								   
								  <div class="panel panel-default">
									  <div class="panel-body" > 
										   <div id="ViewForm"> </div>
									  </div>
								  </div>
							  </div>

 							  <div class="tab-pane fade in active" id="tab3"  style="padding-top: 3px">
								  
								  <div class="panel panel-default">
									  
									  <div class="panel-body" > 
										  
										     <div class="panel panel-default">

												  <div class="panel-heading">ACTIVIDADES PENDIENTES DE EJECUCION</div>

												  <div class="panel-body">

														<div class="col-md-3" style="padding-bottom: 10px;padding-top: 15px"> 

															<div class="list-group">
															  <a href="#" class="list-group-item active">EJECUCIÓN DE PROCESOS</a>
																
																  <a href="#" onClick="busqueda_proceso('requerimiento')" class="list-group-item"><b>1. EJECUCION PROCESO DE FINANCIERO - POA</b></a>
																
																
																
														     <a href="#"  onClick="busqueda_pac()"  class="list-group-item"><b>2. HISTORIAL ACTIVIDADES </b> <div id="npac"></div> </a>
																
															
															 
															</div>

													   </div>

													  <div class="col-md-9" style="padding-bottom: 10px;padding-top: 10px"> 

														  <div class="col-md-12"> 
																  <div class="alert alert-success">
																	  <strong>Nota!</strong> Seleccione el tipo de proceso y Verifique la información para registrar el evento asignado
																	</div>
															</div>

														   <div class="col-md-12"> 
																<div id="PendientesVisor"></div>
														  </div>

													  </div>





													</div>
												</div>
									  </div>
								  </div>
							  </div>

											<input type="hidden" id='proceso_nombre' name = 'proceso_nombre'>

											<input type="hidden" id="idtarea1" name="tarea1">
											<input type="hidden" id="idtarea_seg" name="idtarea_seg">
											<input type="hidden" id="idtarea_segcom" name="idtarea_segcom">								 

								 
											  <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
								  
								   
								  <div class="panel panel-default">
									  <div class="panel-body" > 

										 <div class="col-md-12">
											   <h5> <b>Formato Importar archivo XLS - Plan Anual de Contratación </b>
													<a href="subidas/formato_pac_sistema.csv" title="Descargar archivos">
														<img src="../../kimages/Download_183297.png" />
												   </a> 
											   </h5>   
  
										</div>
										  
										   <div class="col-md-12">
 														<img src="subidas/formato.png" width="1500" height="260" />
  										    </div>

											 <div class="col-md-12" >
												<iframe width="100%" id="archivocsv" name = "archivocsv" height="300" src="sube.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
												</iframe>
										   </div>


									  </div>
								  </div>
								  
							  </div>
								 
				  
                     
       						 </div>
					 
			   </div>	
	
 		</div>
	
    </div>
   
  	<!-- Page Footer-->

    <div id="FormPie"></div>  




 <!---------------  FORMULARIO MODAL DE COMPRAS  ----------------->	
 
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
			  
			 <div class="modal-content">
			   <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				 <h4 class="modal-title">ACTIVIDAD PLANIFICADA</h4>
			   </div>

			 
			  
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormTarea"> var</div> 
								   
  				
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									 <div id="guardarPac" style="padding: 15px;" align="center"></div>   

									 <button type="button" class="btn btn-sm btn-info" onClick="ActualizarPAC()" >Actualizar PAC</button>
									   
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 		 
			 
		 </div>
	   </div>

	 <!-- /.modal-dialog -->

	</div>

<!-- /.modal -->

	
	
<input type="hidden" id="tareaf" name="tareaf">
<input type="hidden" id="idtarea_segf" name="idtarea_segf">
	
	
 	<div class="modal fade" id="myModalArchivo" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">INICIO DE PROCESO:: DOCUMENTOS HABILITANTES</h4>
		   </div>
			 
			 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12"  style="padding: 15px">

								      <h5>Archivos Adjuntos  </h5>
								   
							   				<div id="Seguimiento_archivo"> var</div> 
								   
  				
							   </div>
							  
								<div class="col-md-12" style="padding: 15px" align="right">
								
 
									  <button  type="button" onClick="AdjuntarDoc()" class="btn btn-sm btn-primary">
									 <i class="icon-white icon-search"></i> Cargar archivos</button> 
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div> 
	

	<!-- /.modal-content --> 
	 
    <div class="modal fade" id="myModalActualiza" tabindex="-1" role="dialog">
		  
		<div class="modal-dialog" id="mdialTamanio1">
			  
		 <div class="modal-content">
			 
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">Siguiente Paso</h4>
		   </div>
			 
			 
			  
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormComentario"> var</div> 
								   
								   			 <div id="guardarDatosCom" style="padding: 15px;" align="center"></div>   
  				
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									
									    <button type="button" class="btn btn-sm btn-danger" onClick="NoProceso()" >NO Procede!</button>
									

									    <button type="button" class="btn btn-sm btn-success" onClick="SiguienteProceso()" >Guardar / Enviar Proceso</button>
									
									
									 <button type="button" class="btn btn-sm btn-info" onClick="VerPac()" >Certificación PAC</button>
									
									 <button type="button" class="btn btn-sm btn-warning" onClick="VerPac1()" >Certificación CATE</button>
									
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 		 
			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div>


<!-- /.modal -->

	

 <div class="modal fade" id="myModalRecorrido" role="dialog">
		
		  <div class="modal-dialog" id="mdialTamanior">
    
      <!-- Modal content-->
			  
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Recorrido de Documento</h4>
				</div>
				<div class="modal-body">


					<div class="col-md-12">

							   				<div id="ViewFormRecorrido"> var</div> 
								   
   				
							   </div>

				</div>

				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

 						</div>
					  </div>
    			 </div>
 		 </div>
	
  




 <div class="modal fade" id="myModalActividad" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ACTIVIDADES GENERALES</h4>
		   </div>
			   <form action="../model/Model_seg_pac02.php" method="POST" id="fo33"   name="fo33" enctype="multipart/form-data" accept-charset="UTF-8"> 
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


 </body>
</html>
 
 