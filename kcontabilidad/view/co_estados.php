<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title><?php  echo trim($_SESSION['ruc_registro']).' '.trim($_SESSION['razon']) ?></title>
	
    <?php  require('Head.php')  ?> 
 		  
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
 	
	<script type="text/javascript" src="../js/co_estado.js"></script> 
	
	 <style type="text/css">
		 
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			padding: 3px;
			line-height: 1.42857143;
			vertical-align: top;
			border-top: 1px solid #ddd;
		}
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
	
	
<div class="col-md-12"> 
    
  <!-- Content Here -->
 		
  <div class="col-md-12" > 
			 
    <ul id="mytabs" class="nav nav-tabs">  
		
									<li class="active"><a href="#tab1" data-toggle="tab"> 
										<span class="glyphicon glyphicon-th-list"></span> Resumen Financiero</a>
									</li>
								
								    <li><a href="#tab0" data-toggle="tab">
										<span class="glyphicon glyphicon-search"></span> Filtro Parametros </a>
									</li> 
								
									<li><a href="#tab2" data-toggle="tab">
										<span class="glyphicon glyphicon-dashboard"></span> Balance Comprobación</a>
									</li> 

									<li><a href="#tab3" data-toggle="tab">
										<span class="glyphicon glyphicon-bishop"></span> Estado Situacion Financiera</a>
									</li> 

									<li><a href="#tab4" data-toggle="tab">
										<span class="glyphicon glyphicon-wrench"></span> Estado de Resultados</a>
									</li> 

									<li><a href="#tab5" data-toggle="tab">
										<span class="glyphicon glyphicon-asterisk"></span> Flujo del Efectivo</a>
									</li> 
								
									<li><a href="#tab6" data-toggle="tab">
										<span class="glyphicon glyphicon-asterisk"></span> Ejecucion Presupuestaria</a>
									</li> 
								
								    <li><a href="#tab7" data-toggle="tab">
										<span class="glyphicon glyphicon-asterisk"></span> Notas explicativas</a>
									</li> 

							   </ul>
			 
    <!-- ------------------------------------------------------ -->
							   <!-- Tab panes -->
					  <!-- ------------------------------------------------------ -->
					   <div class="tab-content">
						   
					 			<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
									
								  <div class="panel panel-default">
									  <div class="panel-body" > 
 										 <div id="ViewResumen"> </div> 
										 <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal">
										 <span class="glyphicon glyphicon-filter"></span>  Proceso Periodo</button>


										 <button type="button" class="btn btn-sm btn-default" id="financiero1">
										 <span class="glyphicon glyphicon-cog"></span> Resumen Financiero</button>
 								       </div>  
								   </div> 
									
					     </div>
						        <!-- ------------------------------------------------------ -->
					 	   
                               <div class="tab-pane fade in" id="tab0"  style="padding-top: 3px">
								   
                                      <div class="panel panel-default">
                                          <div class="panel-body" > 
                                                  <div class="col-md-10"> 
                                                          <div class="col-md-12"> 
                                                                <div id="Filtrolibro"> </div>   
                                                           </div>	  
                                                 </div>
                                          </div>
                                      </div>
                               </div>
						   
						   
						       <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
								   
								  <div class="panel panel-default">
									  <div class="panel-body" > 

									  <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

												   <button type="button" class="btn btn-sm btn-success" id="financiero3">
												 <span class="glyphicon glyphicon-cog"></span> Balance Comprobacion</button>

												
												 <div class="btn-group">
													<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
													Resumen  <span class="caret"></span></button>
													<ul class="dropdown-menu" role="menu">
													  <li><a href="#" onClick="ResumenBalance_Resumen()">1. Generar Balance Resumen </a></li>
														 <li><a href="#" onClick="Archivo_balance(0)">(*) Archivo Balance Inicial</a></li>

													</ul>
												  </div>
										  
										   <button type="button" class="btn btn-sm btn-default" id="financiero39">
												 <span class="glyphicon glyphicon-cog"></span> Balance Comprobacion Niveles</button>
										  
										    <button type="button" class="btn btn-sm btn-default" id="printButtonBalance">
												 <span class="glyphicon glyphicon-print"></span> Reporte</button>

										  
													  <button type="button" class="btn btn-sm btn-default" id="excelButtonBalance">
												 <span class="glyphicon glyphicon-print"></span> Excel</button>

										 </div>   
										  
										   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
													<div style="height: 750px; overflow-y: scroll;">

													  <div id="ViewBalance"> </div>

												   </div>   
										 
									 	  </div>
									  </div>
								  </div>
						   </div>
						   
						   		<!-- Tab 3 -->
							
						       <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								   
								  <div class="panel panel-default">
									  <div class="panel-body" > 
										  
										  
										  
									  <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 
										  
										    <div class="col-md-2"> 
												<select name='com1' id='com1' class="form-control">
													 <option value="-">Comparativo?</option>
												     <option value="N">NO</option>
												     <option value="S">SI</option>
												</select>
										    </div>  	 
										  
										    <div class="col-md-4" style="padding-top: 2px"> 

												  <button type="button" class="btn btn-sm btn-default" id="financiero4">
												 <span class="glyphicon glyphicon-cog"></span> Estado Situacion</button>
												
												  <button type="button" class="btn btn-sm btn-info" id="financiero400">
												 <span class="glyphicon glyphicon-cog"></span> Estado Situacion Detalle</button>
 

										  		 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewBalanceSituacion')">
														 <span class="glyphicon glyphicon-print"></span> Reporte</button>
										  
										  
													  <button type="button" class="btn btn-sm btn-default" id="excelButtonEstado">
												 <span class="glyphicon glyphicon-print"></span> Excel</button>

										  </div>  
										  
										 
										  
										 </div>   
										  
										   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
													<div style="height: 750px; overflow-y: scroll;">

													  <div id="ViewBalanceSituacion"> </div>

												   </div>   
										 
									 	  </div>


									  </div>
								  </div>
						 </div>  
						   
						   
						   <!-- Tab 4 -->
						   
							 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
								 
								  <div class="panel panel-default">
									  <div class="panel-body" > 
										  
										    <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

												 <div class="col-md-2"> 
														<select name='com2' id='com2' class="form-control">
															 <option value="-">Comparativo?</option>
															 <option value="N">NO</option>
															 <option value="S">SI</option>
														</select>
										        </div>  
												
												 <div class="col-md-4"> 
												
												  <button type="button" class="btn btn-sm btn-default" id="financiero44">
												 <span class="glyphicon glyphicon-cog"></span> Estado de Resultados</button>
													 
													   <button type="button" class="btn btn-sm btn-info" id="financiero441">
												 <span class="glyphicon glyphicon-cog"></span> Estado Resultados Detalle</button>
 
													 

												 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewResultadosEsigef')">
													 <span class="glyphicon glyphicon-print"></span> Reporte</button>
													 
													 
													   <button type="button" class="btn btn-sm btn-default" id="excelButtonResultado">
												 <span class="glyphicon glyphicon-print"></span> Excel</button>
													 
													 
												 </div>   
												
										    </div>   
										  
											   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 

 
														  <div id="ViewResultadosEsigef"> </div>

 
											  </div>
								 		  
		 
									  </div>
								  </div>
						 </div>    
						   
						   <!-- Tab 5 -->
						   
							 <div class="tab-pane fade in" id="tab5"  style="padding-top: 3px">
								 
								  <div class="panel panel-default">
									  <div class="panel-body"  > 
										 
										 
										  
										  <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

												  <button type="button" class="btn btn-sm btn-default" id="financiero6">
												 <span class="glyphicon glyphicon-cog"></span> Flujo del Efectivo</button>

												 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewFlujo')">
										 <span class="glyphicon glyphicon-print"></span> Reporte</button>
											  
											     <button type="button" class="btn btn-sm btn-default" id="excelButtonFlujo">
												 <span class="glyphicon glyphicon-print"></span> Excel</button>

										 </div>   
										  
										   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
 
													  <div id="ViewFlujo"> </div>

 										 
									 	  </div>
										  
									  </div>
								  </div>
						 </div>   
						   
						 
						   
						      <!-- Tab 6 -->
							 <div class="tab-pane fade in" id="tab6"  style="padding-top: 3px">
								 
								  <div class="panel panel-default">
									  
									  <div class="panel-body" > 
										  
										  <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

												  <button type="button" class="btn btn-sm btn-default" id="financiero66">
												 <span class="glyphicon glyphicon-cog"></span> Estado Ejecucion</button>
											  
											  
											    <button type="button" class="btn btn-sm btn-info" id="financiero661">
												 <span class="glyphicon glyphicon-cog"></span> Estado Ejecucion Detalle</button>
											  
											  

												 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewEjecucion')">
										 <span class="glyphicon glyphicon-print"></span> Reporte</button>
											  
											     <button type="button" class="btn btn-sm btn-default" id="excelButtonEjecucion">
												 <span class="glyphicon glyphicon-print"></span> Excel</button>

										 </div>   
										  
										   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
 
													  <div id="ViewEjecucion"> </div>

 										 
									 	  </div>
 										  
										   

										  
									  </div>
								  </div>
						 </div>   
						   
						   
						   <div class="tab-pane fade in" id="tab7"  style="padding-top: 3px">
								  <div class="panel panel-default">
									  <div class="panel-body" > 
										  
										  <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

												  <button type="button" data-toggle="modal" data-target="#myModalNotas" class="btn btn-sm btn-default" id="nota_agrega">
												 <span class="glyphicon glyphicon-cog"></span> Agregar Nota</button>

												 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewEjecucion')">
										 <span class="glyphicon glyphicon-print"></span> Reporte</button>

										 </div>   
										  
										   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
 
													  <div id="ViewNotasDetalle"> </div>

 										 
									 	  </div>
 										  
										   

										  
									  </div>
								  </div>
						 </div>   
						   
					   </div>  	   
 				 </div>
	    
    </div>
    
	 
<!-- Modal -->
    
     <div class="container"> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	  <div class="modal-dialog">
		<div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title">Selección Filtro</h3>
                  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
				         <div class="panel-body">
 					  		 <div id="ViewFiltro"> var</div> 
 					  		 <br>
							  <p>Calcule proceso de saldos</p> 
 					  		  <div id="resultadoFin" align="center"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Procesar información</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
                  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>   
   
     
	 <div class="container"> 
	  <div class="modal fade" id="myModalNovedad" tabindex="-1" role="dialog">
  	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Novedades</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
				         <div class="panel-body">
 					  		   <div id="FiltroNovedades"> </div>            
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
	
	
	<div class="container"> 
	  <div class="modal fade" id="myModalNotas" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Notas Explicativas</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
				         <div class="panel-body">
 					  		   <div id="ViewNotas"> </div>            
 					     </div>
					     </div>   
  					 </div>
				  </div>
		   <div class="modal-footer">
			   
			   <button type="button" class="btn btn-sm btn-success" >Guardar Notas</button>
			   
 			   <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			   
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
  
	
 </body>
</html>
 