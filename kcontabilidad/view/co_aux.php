<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
 <script type="text/javascript" src="../js/co_aux.js"></script> 
 
     
	
</head>
<body>

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
	
       <!-- Content Here -->
	
    <div class="col-md-12"> 
		
       <!-- Content Here -->
		
	    <div class="row">
			
 		 	     <div class="col-md-12">
							  
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b> Auxiliares</b></a>
										</li>
										 
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Detalle de Auxiliares</a>
										</li>
			
									    <li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-dashboard"></span> Resumen Cuenta x Pagar Auxiliares</a>
										</li>
			
										<li><a href="#tab4" data-toggle="tab">
											<span class="glyphicon glyphicon-dashboard"></span> Resumen General</a>
										</li>
			
		 			
								</ul>
		
								<!-- ------------------------------------------------------ -->
								<!-- Tab panes -->
								<!-- ------------------------------------------------------ -->
		
								<div class="tab-content">
									
										   <!-- Tab 1 -->
									
										  <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
											  
											  <div class="panel panel-default">
												  
												  <div class="panel-body" > 

												   <div class="col-md-12" style="padding: 1px">

													   <div class="col-md-12">
														   
														   	  <div class="col-md-3">
																 <select id="anio" name = "anio" class="form-control">
																   <option value="2025">2025</option>	 
																   <option value="2024">2024</option>	 
																   <option value="2023">2023</option>
																   <option value="2022">2022</option>
																   <option value="2021">2021</option>
																   <option value="2020">2020</option>
																   <option value="2019">2019</option>
																   <option value="2018">2018</option>
																 </select> 
															  </div>  
													
														      <div class="col-md-3">
																 <select id="tipo" name="tipo" class="form-control">
																   <option value="P">Proveedores</option>
																   <option value="C">Clientes</option>
																   <option value="N">Nomina</option>
																  </select>
															  </div>  
														   
														      <div class="col-md-2" style="padding: 1px"> 

																 <button type="button" class="btn btn-primary btn-sm btn-block" id="load">  
																			<i class="icon-white icon-search"></i> Busqueda</button>	

															</div>
 														     
														      <div class="col-md-2" style="padding: 1px"> 
																  <button type="button" class="btn btn-default btn-sm btn-block" id="loadxls" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i> Descargar
															  </button>	

															  </div>
 														   
													   </div>  
													
													   	<div class="col-md-10">

 															<div class="table-responsive" id="employee_table">  

															   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 10px"  >
																							<thead>
																								<tr>
																								<th width="10%">Identificacion</th>
																								<th width="30%">Nombre</th>
																								<th width="30%">Ultima Transaccion</th>	
																								<th bgcolor=#E5F8E9 width="30%">Transacciones</th>
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

										 <!-- Tab 2 -->

										  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">

											  <div class="panel panel-default">

												   <div class="panel-body" > 

													 <div class="col-md-12" style="padding: 1px">
 														 
 														   
																	   	  <div class="col-md-2">
																 <select id="bandera" name = "bandera" class="form-control">
																   <option value="S">[ Por Cuenta ]</option>
																   <option value="N">[ Todas las Cuentas ] </option>
 																 </select>
															  </div>  
													
																		  <div class="col-md-3">
																			 <select id="cuenta" name="cuenta" class="form-control"> </select>
																		  </div>  
  														   
														     			   <div class="col-md-7" style="padding: 1px"> 

																				 <button type="button" class="btn btn-primary btn-sm" id="load2">  
																					<i class="icon-white icon-search"></i> Busqueda</button>	
 
																 				<button type="button" class="btn btn-warning btn-sm" id="load30">  
																					<i class="icon-white icon-search"></i> Agrupar</button>	
  																  
																  				<button type="button" class="btn btn-default btn-sm" id="loadxls2" title="Descargar archivo en excel">  
																					<i class="icon-white icon-download-alt"></i> Descargar
															 					 </button>	
 															 
																  				<button type="button" class="btn btn-default btn-sm" onClick="imprimir('ImpresionAux')">  
																					<i class="icon-white icon-print"></i> Imprimir
															 				   </button>	
    
													   					</div>  

																	    	<div class="col-md-12" id="ImpresionAux">
																
																 <h4><b>Resumen de Transacciones por Auxiliar</b> </h4>
																
																 <h4><b> <div id="ViewProveedor">Nombre Auxiliar </div></b> </h4>

															      <div id="ViewFormAux"> </div>

														   </div>  
 

 
													   
												   </div>
											      </div>

										  </div>
											  
										    </div>  	  

										<!-- Tab 3 -->	
									
									  	   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">

											  <div class="panel panel-default">

												   <div class="panel-body" > 

															 <div class="col-md-12" style="padding: 1px">
 														 
														 
														     <div class="col-md-12">
  													
															  <div class="col-md-4">
																 <select id="cuenta1" name="cuenta1" class="form-control">
 																  </select>
																  
															  </div>  
															 
														      <div class="col-md-2" style="padding: 1px"> 

																 <button type="button" class="btn btn-primary btn-sm btn-block" id="load21">  
																			<i class="icon-white icon-search"></i> Busqueda</button>	

															  </div>
 														     
														      <div class="col-md-2" style="padding: 1px"> 
																  <button type="button" class="btn btn-default btn-sm btn-block" id="loadxls21" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i> Descargar
															  </button>	

															  </div>
															 
															   <div class="col-md-2" style="padding: 1px" > 
																  <button type="button" class="btn btn-sm btn-default"  id="loadp"  >
																   <span class="glyphicon glyphicon-print"></span> Reporte</button>
																</div>  
 														   
													   </div>  
 
															<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">
																
																	 <div id="ViewBalancePrint"> 
 
															     		 <div id="ViewFormAuxc"> </div>
																		 
																		 
																	 </div>  	 

														   </div>  
 

													</div>

												   </div>
											  </div>

										  </div>
									
									
										   <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">

											  <div class="panel panel-default">

												   <div class="panel-body" > 

													 <div class="col-md-12" style="padding: 1px">
 														 
														 
														 <div class="col-md-12">
  													
															  <div class="col-md-4">
																 <select id="cuenta131" name="cuenta131" class="form-control">
																   <option value="112.01">112.01 Anticipos a Servidores Públicos</option>
																   <option value="112.03">112.03 Anticipos a Contratistas de Obras de Infraestructura</option>
																   <option value="112.05">112.05 Anticipos a Proveedores de Bienes y/o Servicios</option>
																   <option value="212">212. Depósitos y Fondos de Terceros </option>
																   <option value="213">213. Cuentas por Pagar</option>
																   <option value="213.51">213.51 Gastos en Personal</option>
																   <option value="213.53">213.53 Bienes y Servicios de Consumo</option>
																   <option value="213.57">213.57 Otros Gastos</option>	 
																   <option value="213.58">213.58 Transferencias y Donaciones Corrientes</option>	 
																   <option value="213.71">213.71 Cuentas por Pagar Gastos en Personal para Inversión</option>	 
																   <option value="213.73">213.73 Cuentas por Pagar Bienes y Servicios para Inversión</option>	 
																   <option value="213.75">213.75 Cuentas por Pagar Obras Públicas</option>	 
																   <option value="213.84">213.84 Inversiones en Bienes de Larga Duración</option>
																   <option value="224.97">224.97 Depósitos y Fondos de Terceros de Años Anteriores</option>
															   	   <option value="224.85">224.85 Cuentas por Pagar del Año Anterior</option>	 
																   <option value="224.98">224.98 Cuentas por Pagar de Años Anteriores</option>	 
																	 
																	 
 																  </select>
															  </div>  
															 
															 
															 
 
 														   
														      <div class="col-md-2" style="padding: 1px"> 

																 <button type="button" class="btn btn-primary btn-sm btn-block" id="load311">  
																			<i class="icon-white icon-search"></i> Busqueda</button>	

															  </div>
 														     
														      <div class="col-md-2" style="padding: 1px"> 
																  <button type="button" class="btn btn-default btn-sm btn-block" id="loadxls31" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i> Descargar
															  </button>	

															  </div>
															 
															   <div class="col-md-2" style="padding: 1px" > 
																  <button type="button" class="btn btn-sm btn-default"  id="loadp11"  >
																   <span class="glyphicon glyphicon-print"></span> Reporte</button>
																</div>  
															  
 														   
													   </div>  
 
															<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">
																
																	 <div id="ViewBalancePrint1"> 
 
															     		 <div id="ViewFormAuxc1"> </div>
																		 
																		 
																	 </div>  	 

														   </div>  
 

													</div>

												   </div>
											  </div>

										  </div>
									
 
							    </div>
			    </div>	
	
 		</div>
	
    </div>
     <!-- /.auxiliar -->

  <input type="hidden" id="prove" name="prove">

  <div id="ViewFormAux">  </div>
    
  <div class="container"> 
	  <div class="modal fade" id="myModalCxp" tabindex="-1" role="dialog">
						  <div class="modal-dialog" id="mdialTamanio">
									<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h3  class="modal-title">Detalle </h3>
											  </div>
											  <div class="modal-body">

												<div class="form-group" style="padding-bottom: 2px">
															 <div class="panel panel-default">

																		 <div class="panel-body">
																			 <div id="ViewFiltroAux" style="height: 420px"> var</div> 
																		 </div>

															 </div>   
														 </div>
											  </div>

											  <div class="modal-footer">
												<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
											  </div>
									</div>
									<!-- /.modal-content --> 
						  </div>
						  <!-- /.modal-dialog -->
	  </div>
       <!-- /.modal -->
</div>  
	
  <div class="container"> 
	  <div class="modal fade" id="myModalNovedad" tabindex="-1" role="dialog">
  	 		 <div class="modal-dialog" id="mdialNovedad">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Novedades</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 
								 <div class="form-group">
								  <label for="comment">Novedad:</label>
								  <textarea class="form-control" rows="5" id="comment"></textarea>
								 </div>
							 
				  		   <div id="guardarNovedad"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarNovedad()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div>
		  	  <!-- /.modal-dialog -->
	  </div>
	  <!-- /.modal -->
   </div> 
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 