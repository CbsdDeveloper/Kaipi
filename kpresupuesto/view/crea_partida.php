<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
 
<script  type="text/javascript" language="javascript" src="../js/crea_partida.js?n=1"></script>
	
	
	
 <style type="text/css">
	 
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
	 
	   #mdialTamanio{
  					width: 75% !important;
		}
	 
	 	 
	 .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
	 .di {
  			 background-color:#F5C0C1;
	  }
		
</style>		     	     	    		

	
</head>
<body>


 <div id="mySidenav" class="sidenav hijo">
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
   </div>
    

<div id="main">
	<!-- Header -->
	
   <div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
		
 
    
   <div class="col-md-12" > 
 
 			
				<h4 align="center"><b>GESTION PRESUPUESTARIA  </b></h4>	 
 			   
			
 		 	     <div class="col-md-12">
							  
					 
								<ul id="mytabs" class="nav nav-tabs"> 
									
 									
									    <li class="active"><a href="#tab1" data-toggle="tab">
											<span class="glyphicon glyphicon-new-window"></span> <b>Creacion de Partidas</b></a>
										</li>
									
									
									    <li><a href="#tab2" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> INGRESOS</a>
										</li>
										 
										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> GASTOS</a>
										</li>
			
			 							<li ><a href="#tab4" data-toggle="tab">
											<span class="glyphicon glyphicon-alert"></span> CREACION/ACTUALIZACION PERIODO PRESUPUESTARIO</a>
										</li>
			
			
								</ul>
	   
								<!-- ------------------------------------------------------ -->
								<!-- Tab panes -->
								<!-- ------------------------------------------------------ -->
	   
								<div class="tab-content">
  									
									
									 <div class="tab-pane fade in active" id="tab1"  style="padding-top: 3px">
										 
 											  <div class="panel panel-default">
												  
 												   <div class="panel-body"> 

															    <div class="col-md-12" style="padding-top: 10px">
																	
																         <h3> Creacion de partidas</h3> 
																		 
																		 <div class="col-md-12" style="padding: 5px">
																			 
																			 <div class="col-md-1">
																				 
																					<button type="button" class="btn btn-sm btn-info"  onclick="javascript:window.location.reload();">  
																					<i class="icon-white icon-plus"></i> Nueva partida
																			 		</button>
																				 
																			  </div> 
																			 
																			 <div class="col-md-3">
																				 
																					<select id="anio_crea" name = "anio_crea" class="form-control" >
 																					</select>
																				 
																	         </div> 	
 																			 
																			 <div class="col-md-3">
																					<select onChange="LimpiaDatos(this.value)" id="tipo_crea" class="form-control" >
																					  <option value="-">SELECCIONE EL TIPO DE PRESUPUESTO</option>
																					  <option value="I">INGRESO</option>
																					  <option value="G">GASTO</option>
																					</select>
																	         </div> 
																			 
																		  </div> 
																	
 																		 <div id="ViewFormPartida"> </div>
 																 </div> 
 															   
													   
													            <div class="col-md-12" id="Sinicial" style="padding: 5px">
																   
																	<div class="col-md-6">
																				<div class="alert alert-success">
																					
																					<div class="row">
																						
																							 <div style="padding-top: 9px;" class="col-md-3">
																								 <b>(*) Agregar Saldo Inicial </b>
																							  </div>	 
																							 <div style="padding-top: 5px;" class="col-md-3">
																								  <input type="number" placeholder="Saldo Inicial" class="form-control" id="vinicial" name="vinicial"  >

																							 </div>
																			  		</div>	
																			</div>		
																	</div>		
																	
															    </div>
													   
													    		<div class="col-md-12" style="padding: 1px">
																	
																		 <div style="padding-top: 5px;" class="col-md-9">
 																			 
																					<button type="button" class="btn btn-sm btn-primary" id="loadpartidas">  
																					<i class="icon-white icon-save"> </i> Guardar Informacion
																			 		</button>	
																         </div>
																	
															    </div>
													   
 																<div align="center" id="ResultadoPartida"> </div>
												   </div>
												  
 											  </div>
									 </div>	
								 
									
 									
									 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
										 
										 
										  <div class="panel panel-default">
											  
											  <div class="panel-body"> 
												  
													<div class="col-md-12" style="padding: 10px">
														
														<div class="col-md-9">
																<div id="ViewFiltro"></div> 
														
														</div>
														<div class="col-md-3" style="padding-top: 5px">
																					<button type="button" class="btn btn-sm btn-primary" id="load">  
																					<i class="icon-white icon-search"></i> Buscar</button>	

																				   <button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																					<i class="icon-white icon-download-alt"></i></button>	
														</div>	
													</div>

													

														 <div class="col-md-12" style="padding-top: 10px">

															<div class="table-responsive" id="employee_table">  

																<div id="ViewFormIngresos"> </div>

														    </div>    	
															 
														 </div>  

													
											  </div>  
										  </div> 
							  	     </div>
									
									
								   	 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
										 
 										  <div class="panel panel-default">
											  
 												   <div class="panel-body"> 
													   
														 <div class="col-md-12" style="padding: 10px">
															<div id="ViewFiltrog"></div> 
														 </div>
										   
														 <div class="col-md-12" style="padding: 1px">

																 <div style="padding-top: 5px;" class="col-md-9">
																					<button type="button" class="btn btn-sm btn-primary" id="loadg">  
																					<i class="icon-white icon-search"></i> Buscar</button>	

																				   <button type="button" class="btn btn-sm btn-default" id="loadxlsg" title="Descargar archivo en excel">  
																					<i class="icon-white icon-download-alt"></i></button>	


																</div>

																<div class="col-md-4 mb-3">
																	<label for="searchInput" class="form-label">Busqueda en tabla de resultados:</label>
																	<input type="text" class="form-control" id="searchInput" onkeyup="filterTable()" placeholder="Buscar en el listado de partidas presupuestarias...">
																</div>

																 <div class="col-md-12" style="padding-top: 10px">

																	<div class="table-responsive" id="employee_table">  

																		<div id="ViewFormGastos"> </div>

																   </div>   

																</div>  

														</div>
													   
										  		  </div>
 									      </div>
										 
 								     </div>
 									  
									
									 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
										  
										  <div class="panel panel-default">
											  <div class="panel-body"> 
 													<div class="col-md-12" style="padding: 1px">
														<div class="alert alert-warning">
															
														    <div class="container">
																
 																 <div style="padding-top: 5px;" class="col-md-9">
 																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalPeriodo" onClick="LimpiaPeriodos()"><i class="icon-white icon-plus"></i> Crear Periodo</button>
																 </div>

																 <div class="col-md-12" style="padding-top: 10px">
																	 
																	  <table id="jsontable_ingreso" class="display table table-condensed table-hover datatable"  width="80%">
																						<thead>
																							<tr>
																								<th width="10%">Id</th>
																								<th width="10%">Periodo</th>
																								<th width="30%">Detalle</th>	
																								<th width="10%">Estado</th>
																								<th width="10%">Modificado</th>
																								<th width="10%">Acción</th>
																							</tr>
																						</thead>
																			</table>
																</div>  
																
															</div>  
															
														 </div>  	
													</div>
											  </div>  
										  </div> 
									 </div> 	  
									
				 				</div>
			   </div>	  
 	 
	 			 <div class="col-md-12">
		  			<div align="center" style="font-size: 25px;font-weight: 500" id="presupuesto_total">	</div>	   
 				 </div>	  
	
    </div>
     <!-- /.auxiliar -->
	
	<input type="hidden" id="estado_presupuesto" name="estado_presupuesto">
	<input type="hidden" id="bi" value="0">
	<input type="hidden" id="bg" value="0">
   
	
  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
		  
  	  <div class="modal-dialog" id="mdialTamanio">
		  
		<div class="modal-content">
			
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Asignacion inicial</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroAux"> var</div> 
 					  		
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
			   <div id="guardarAux">Guardar informacion </div> 
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAuxiliar()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			  
			    <button type="button" class="btn btn-sm btn-default"  onClick="EliminarAuxiliar()">
		    <i class="icon-white icon-trash"></i> Eliminar</button> 
			  
			  
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  

  <div class="container"> 
	  <div class="modal fade" id="myModalCostos" tabindex="-1" role="dialog">
  	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Selección de Costos</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroCosto"> var</div> 
 					  		 <div id="guardarCosto"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarCosto()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 

  <div class="container"> 
	  <div class="modal fade" id="myModalPeriodo" tabindex="-1" role="dialog">
  	 <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Creacion de Periodo</h3>
		  </div>
				 <form id="fo2" action="../model/Model_periodo" accept-charset="UTF-8" method="post">
				 <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 3x">
			          <div class="panel panel-default">
  				         <div class="panel-body">
 					  		 <div id="ViewPeriodo"> var</div> 
							  <div style="padding: 15px">&nbsp;</div> 
							 <div id="guardarDocumento"  align="center">  </div> 
 					     </div>
					     </div>   
  					 </div>
				  </div>
				
				  <div class="modal-footer">
					 	<button type="submit" class="btn btn-sm btn-info">Guardar</button>  
					    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
				</form> 	 
 		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 	
	
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 