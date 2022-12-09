<!DOCTYPE html>
<html lang="en">
	
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Administación-Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/adm_pac.js"></script> 
    
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
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>  Lista por periodo </b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Información Pac</a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-alert"></span> Seguimiento Tramites/Pac</a>
                  		</li>
                  		<li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-alert"></span> Cargar Pac</a>
                  		</li>
 			
                   </ul>
		
                     <!-- ------------------------------------------------------ -->
                     <!-- Tab panes -->
                     <!-- ------------------------------------------------------ -->
		
							 <div class="tab-content">

							   <!-- Tab 1 -->

							   <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

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
																				<th width="10%">Partida</th>
																				<th width="10%">Tipo</th>
																				<th width="10%">Tipo proyecto</th>
																				<th width="15%">Procedimiento</th>
																				<th width="30%">Detalle</th>
																				<th width="10%">Total</th>
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

							  <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								  
								  <div class="panel panel-default">
									  
									  <div class="panel-body" > 
										  
										     <div class="panel panel-default">

												  <div class="panel-heading">ACTIVIDADES PENDIENTES DE EJECUCION</div>

												  <div class="panel-body">

														<div class="col-md-3" style="padding-bottom: 10px;padding-top: 15px"> 

															<div class="list-group">
															  <a href="#" class="list-group-item active">EJECUCIÓN DE PROCESOS</a>
															  <a href="#" onClick="busqueda_proceso('requerimiento')" class="list-group-item">PROCESO DE CONTRATACIÓN</a>
															  <a href="#"  onClick="busqueda_proceso('caja')"  class="list-group-item">GESTIÓN DE OTROS GASTOS PLANIFICADOS (sin contratación)</a>
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
								
									 <div id="guardarCompras" style="padding: 15px;" align="center"></div>   

									   
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 		 
			 
		 </div>
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

	
	

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
								
									

									    <button type="button" class="btn btn-sm btn-success" onClick="SiguienteProceso()" >Guardar / Enviar Proceso</button>
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 		 
			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

	

  
 </body>
</html>
 