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
	
	
	
	<script type="text/javascript" src="../js/co_analisis.js"></script> 
	
	 <style type="text/css">
		 
		 .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
		 
	 

			#mdialTamanio{
						width: 75% !important;
			}
		 
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 6px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
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
										<span class="glyphicon glyphicon-bishop"></span> Cedula Presupuestaria</a>
									</li> 

									<li><a href="#tab4" data-toggle="tab">
										<span class="glyphicon glyphicon-wrench"></span> Diario Contable</a>
									</li> 

									<li><a href="#tab5" data-toggle="tab">
										<span class="glyphicon glyphicon-asterisk"></span> Enlace Contable Presupuestario</a>
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

									    <div class="col-md-9" style="padding-bottom:15;padding-top: 10px"> 

												  <button type="button" class="btn btn-sm btn-success" id="financiero3">
												 <span class="glyphicon glyphicon-cog"></span> Balance Comprobacion</button>
 
												
											  	<div class="btn-group">
													  
													<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
													Resumen ESIGEF  &nbsp;&nbsp; <span class="caret"></span></button>
													  
													<ul class="dropdown-menu" role="menu">
														
														 <li><a href="#" data-toggle="modal" data-target="#myModalVal">Matriz de validacion</a></li>
														
													     <li> &nbsp;&nbsp; </li>
														
													     <li><a href="#" onClick="ResumenBalance_Resumen()">1. Generar Balance Resumen </a></li>
														
														 <li><a href="#" onClick="Archivo_balance(0)">(*) 1.1 Archivo Balance Inicial</a></li>
														 <li><a href="#" onClick="Archivo_balance(11)">(*) 1.2 Detalle de Apertura</a></li>
														
													     <li><a href="#" onClick="Archivo_balance(1)">1.3 Archivo Balance</a></li>
														 <li><a href="#" onClick="Archivo_balance(12)">1.4 Transacciones Reciprocas</a></li>
														
														
 													     <li><a href="#" onClick="Archivo_balance(3)">Archivo Trasfer</a></li>
 													     <li><a href="#" onClick="Archivo_balance(7)">Balance BDE</a></li>
 														
 													</ul>
													  
												</div>
											
											
												<div class="btn-group">
												   
													<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
													Transacciones Reciprocas <span class="caret"></span></button>
												   
													<ul class="dropdown-menu" role="menu">
														
														 <li><a href="#" onClick="Reciprocas(0)">(*) 1.  Generar Transacciones</a></li>
														
													     <li><a href="#" onClick="Reciprocas(1)">2. Resumen Transacciones </a></li>
														
														 <li><a href="#" onClick="Reciprocas_val()">Validar Transacciones</a></li>
														
											 				
 													</ul>
												</div>
											
											
										  	    <button type="button" class="btn btn-sm btn-info" id="financiero_inicial">
												 <span class="glyphicon glyphicon-cog"></span> Balance Inicial</button>
											
											
												 <button type="button" class="btn btn-sm btn-default" id="financiero39">
												 <span class="glyphicon glyphicon-cog"></span> Balance Comprobacion Niveles</button>
										  
										         <button type="button" class="btn btn-sm btn-default" id="printButtonBalance">
												 <span class="glyphicon glyphicon-print"></span> Reporte</button>
 
										  		 <button type="button" class="btn btn-sm btn-default" id="excelButtonBalance">
												 <span class="glyphicon glyphicon-print"></span> Excel</button>
										  		 
												<!-- <button type="button" class="btn btn-sm btn-default" id="reciprocaAsientoButton"><span class="glyphicon glyphicon-cog"></span> Recíproca por Número de Asiento</button> -->
												 
										</div>   

										<!-- <div class="row"> -->
											<div class="col-md-3" > 
												<label for="id_asiento_reciproca" class="form-label">N° Asiento:</label>
												<input type="tel" class="form-control form-control-sm" style="width: 30%;" name="id_asiento_reciproca" id="id_asiento_reciproca">
												<button type="button" class="btn btn-sm btn-default" id="reciprocaAsientoButton" onClick="Reciprocas(2)"><span class="glyphicon glyphicon-cog"></span>Generar Recíproca por Número de Asiento</button>
											</div> 
											<!-- <div class="col-md-3" > 
												<input type="text" class="form-control form-control-sm" name="id_asiento_reciproca" id="id_asiento_reciproca">
												<button type="button" class="btn btn-sm btn-default" id="reciprocaAsientoButton"><span class="glyphicon glyphicon-cog"></span>Generar Recíproca por Número de Asiento</button>
											</div>  -->
										<!-- </div> -->
										
										  
									    <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
												 
													  <div id="ViewBalance"> </div>

												 
										 
									 	  </div>
										  
									  </div>
								  </div>
						      </div>
						   
						   
						   		<!-- Tab 3 -->
							
						       <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								   
								  <div class="panel panel-default">
									  
									  <div class="panel-body" > 
 										  
									    <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

												 <button type="button" class="btn btn-sm btn-success" id="financiero4">
												 <span class="glyphicon glyphicon-cog"></span> Cedula Presupuestaria</button>
 
									 			 <div class="btn-group">
													<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
													Resumen  <span class="caret"></span></button>
													<ul class="dropdown-menu" role="menu">
													     <li><a href="#" onClick="Cedula_Resumen('I')">1. Resumen Ingreso  </a></li>
													 	 <li><a href="#" onClick="Cedula_Resumen('G')">2. Resumen Gasto </a></li>
														 <li><a href="#" onClick="Cedula_Resumen('GD')">3. Resumen Gasto Detalle </a></li>
														 <li><a href="#" onClick="Archivo_balance(4)">(*) Archivo Presupuestario Inicial</a></li>
														 <li><a href="#" onClick="Archivo_balance(5)">Archivo Cedula Presupuestaria</a></li>
														 <li><a href="#" onClick="Archivo_balance(8)">Cedula Presupuestaria BDE</a></li>
													</ul>
												  
										 </div>   
										  
											
											<button type="button" class="btn btn-sm btn-info" id="presupuesto_inicio">
												 <span class="glyphicon glyphicon-cog"></span> Presupuesto Inicial</button>
											
										  
										  	     <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewCedulaPresupuestaria')">
										 		<span class="glyphicon glyphicon-print"></span> Reporte</button>
										  
										 </div>  
										  
									  <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
													<div style="height: 500px; overflow-y: scroll;">

													  <div id="ViewCedulaPresupuestaria"> </div>

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

														 <button type="button" class="btn btn-sm btn-default" id="financiero2">
														 <span class="glyphicon glyphicon-cog"></span> Libro Diario</button>

												   		<button type="button" class="btn btn-sm btn-default" id="financiero_grupo">
														 <span class="glyphicon glyphicon-alert"></span> Resumen grupo contable</button>
												   
												   
												   	<button type="button" class="btn btn-sm btn-default" id="financiero_flujo">
														 <span class="glyphicon glyphicon-apple"></span> Resumen contable </button>
												   
												   
												  
												   	<button type="button" class="btn btn-sm btn-info" id="financiero_flujo1">
														 <span class="glyphicon glyphicon-apple"></span> Flujo Efectivo</button>
												   
												   
												   
												   <div class="btn-group">
															<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
															Mayor General  <span class="caret"></span></button>
															<ul class="dropdown-menu" role="menu">
																 <li><a href="#" id="financiero_mayor">Mayor General  </a></li>
																 <li><a href="#" onClick="Libro_grupo_mayor_p('I')">1. Resumen Ingreso  </a></li>
															 	 <li><a href="#" onClick="Libro_grupo_mayor_p('G')">2. Resumen Gasto </a></li>
 															</ul>
												  
										 				</div>   
												   
												   

														 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('Viewlibro')">
														 <span class="glyphicon glyphicon-print"></span> Reporte</button>

														   <button type="button" class="btn btn-sm btn-default" id="excelButtonLibro">
														 <span class="glyphicon glyphicon-print"></span> Excel</button>


														  <button type="button" class="btn btn-sm btn-default" data-toggle="modal" onClick="NovedadAsiento();" data-target="#myModalNovedad">
														 <span class="glyphicon glyphicon-alert"></span> Novedades</button>

														  <button type="button" class="btn btn-sm btn-default" id="financiero21">
														 <span class="glyphicon glyphicon-cog"></span> Digitados</button>

											 </div>

											   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
													 <div style="width: auto; height: 500px; overflow-y: scroll">

															 <div id="Viewlibro"> </div>

													 </div>
											  </div> 


										  </div>

									  </div>
							   </div>    

							    <!-- Tab 5 -->

								 <div class="tab-pane fade in" id="tab5"  style="padding-top: 3px">

									  <div class="panel panel-default">

										  <div class="panel-body"  > 
											  
											  
											   <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

														  <div class="col-md-2" style="padding-bottom:15;padding-top: 10px"> 

															<select name="gtipo" id="gtipo" class="form-control" onChange="SeleccionaGrupo(this.value)">
																<option value="-">[ Grupo Contable ]</option>
																<option value="1">Activo</option>
																<option value="2">Pasivo</option>
																<option value="61">Patrimonio</option>
																<option value="62">Ingreso</option>
																<option value="63">Gasto</option>
															  </select>

														  </div> 

														   <div class="col-md-3" style="padding-bottom:15;padding-top: 10px"> 

																<select id="ngrupo" name="ngrupo" onChange="SeleccionaSubGrupo(this.value)" class="form-control"></select>

														  </div> 


														   <div class="col-md-4" style="padding-bottom:15;padding-top: 10px"> 

																<select id="nsubgrupo" name="nsubgrupo"  onChange="SeleccionaSubItem(this.value)"   class="form-control"></select>

														  </div> 

														   <div class="col-md-3" style="padding-bottom:15;padding-top: 10px"> 

																<select id="nitem" name="nitem"   class="form-control"></select>

														  </div> 
											  
										       </div>   
											 
											 
											  
											  <div class="col-md-12" style="padding-bottom:15;padding-top: 10px"> 

													  <button type="button" class="btn btn-sm btn-info" id="financiero22">
													 <span class="glyphicon glyphicon-cog"></span> Generar busqueda </button>
					
												  
												  
												   <button type="button" class="btn btn-sm btn-default" id="financiero23">
													 <span class="glyphicon glyphicon-bed"></span>  Busqueda Cuenta - Item Presupuestario </button>
												  
 
													 <button type="button" class="btn btn-sm btn-default" onClick="imprimir('ViewFlujo')"> 
													 <span class="glyphicon glyphicon-print"></span> Reporte</button>

											 </div>   
											  

											   <div class="col-md-12" style="padding: 10px"> 

												 

														  <div id="ViewFlujo"> </div>

													   

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
	  <div class="modal fade" id="myModalVal" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Validacion </h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
				         <div class="panel-body">
							 
							<div class="div_v">
							 
 					  		   <div id="Filtrovalidacion"> </div>
							 
							</div>	
 					     </div>
					     </div>   
  					 </div>
				  </div>
		   <div class="modal-footer">
			    <div id="result"> </div>
			   
			    <button type="button" onClick="ValidaCuenta()" class="btn btn-sm btn-info">Cuenta Matriz</button>
			   
			   <button type="button" onClick="ValidaEsigef()" class="btn btn-sm btn-success">Validar</button>
			   
 			  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 
	
	
	
	 <div class="container"> 
	  <div class="modal fade" id="myModalAsientos" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Detalle Movimientos</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
				         <div class="panel-body">
							 <div style="width: auto; height: 500px; overflow-y: scroll">
 					  		   <div id="FiltroPresupuesto"> </div>       
							 </div>
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
	  <div class="modal fade" id="myModalReci" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			  
			<h3 class="modal-title">Validacion Reciprocas</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
				         <div class="panel-body">
							 
							 
							 
 					  		   <div id="FiltroReciprocas"> </div>
							 
							    <div align="center" style="padding: 10px" id="DatosReciprocas"> </div>
							 
						 
 					     </div>
					     </div>   
  					 </div>
				  </div>
		   <div class="modal-footer">
			   
			   <div id="result"> </div>
			   
			         <button type="button" onClick="AnalisisReciproco(1)" class="btn btn-sm btn-info">Actualizar Pagos 213 sin afectacion</button>
			        <button type="button" onClick="AnalisisReciproco(2)" class="btn btn-sm btn-info">Actualizar Pagos 213 Anticipo 124</button>
			   
			        <button type="button" onClick="CopiarReciproco()" class="btn btn-sm btn-default">Copiar</button>
			   
			   
			      <button type="button" onClick="EliminarReciproco()" class="btn btn-sm btn-danger">Eliminar</button>
			   
 			   
			   <button type="button" onClick="ValidaReciproco()" class="btn btn-sm btn-success">Actualizar</button>
			   
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
 