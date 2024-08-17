<!DOCTYPE html>
<html lang="en">
 	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ren_caja.js"></script> 
	
 		
	<script type="text/javascript" src="../js/facturae.js"></script> 
	
  	 
	<style>
		
    	#mdialTamanio{
      			width: 55% !important;
   			 }
		#mdialTamanio_dato{
      			width: 85% !important;
   			 }
		
		#mdialTamanio_externo{
      			width: 95% !important;
   			 }
		
		iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
  
	</style>
	
	 
	
</head>
	
	
<body>
 
 
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
 
	
    <!-- Content Here -->
	
    <div class="col-md-12"> 
        
		  <!-- Content Here -->
		
                   <ul id="mytabs" class="nav nav-tabs">          

                                <li class="active"><a href="#tab2" data-toggle="tab">
                                    <span class="glyphicon glyphicon-link"></span>Recaudacion de Servicios</a>
                                </li>

                                <li ><a href="#tab1" data-toggle="tab"></span>
                                <span class="glyphicon glyphicon-th-list"></span> <b>Detalle de Recaudacion Diaria</b>  </a>
                                </li>

                    </ul>

                   <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
	
                   <div class="tab-content" >

									 <!-- ------------------------------------------------------ -->
									 <!-- Tab 2 -->
									 <!-- ------------------------------------------------------ -->

									 <div class="tab-pane fade in active" id="tab2"  style="padding-top: 3px">

											  <div class="panel panel-default" style="padding: 1px">

												<div class="panel-body" style="padding: 1px" > 

															<div id="ViewForm"> </div>
													
													 
													<div style="padding: 10px">
														  <button type="button" class="btn btn-info btn-lg" onClick="BuscaExterno()" data-toggle="modal" data-target="#myModalExterno">Tramites Pendientes</button>
														  <!-- <button type="button" class="btn btn-primary btn-lg" onClick="BuscaCapacitacionesExterno()" data-toggle="modal" data-target="#myModalCapacitacionesExterno">Capacitaciones Pendientes</button> -->
														  <button type="button" class="btn btn-secondary btn-lg" onClick="limpiarCampos()" data-toggle="modal" data-target="#myModalTramiteNuevo">Trámite Nuevo</button>
												   </div>  
													
												</div>
												  
											


											  </div>

									  </div>
					   
 
								   <!-- ------------------------------------------------------ -->
								   <!-- Tab 1 -->
								   <!-- ------------------------------------------------------ -->
					   

									<div class="tab-pane fade in" id="tab1" style="padding-top: 3px">
										
										
											  <div class="panel panel-default">
												  
												  <div class="panel-body" > 

														<div class="col-md-12"> 

															<div class="alert alert-info">

																		<div class="row">

																				<div id = "ViewFiltro" > </div>

																				<div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 

																			  
																				<div class="col-md-4" style="padding-top: 5px;">
																					<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
																				</div>
 
																		 </div>
															</div>

														 </div> 

														<div class="col-md-12"> 
															
															
															 <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																				 <thead>
																					   <tr>   
																						     <th width="10%">Nro.Pago</th>
																							 <th width="10%">Fecha</th>
																						     <th width="10%">Identificacion</th>
																						     <th width="30">Nombre</th>
  																							 <th width="10%">Forma Pago</th>
																							 <th width="10%">Usuario</th>
																							 <th width="10%">Total</th>
																							 <th width="10%">Accion</th>
																					   </tr> 
																				</thead>
																 </table>


													 </div>  

													 

													   <div id="ViewCuenta">  </div>

												  </div>  
											 </div> 
									 </div>


                       		 

                    </div>

         </div>

 
	
	
    <!-- Modal -->
	
    <div class="modal fade" id="myModal" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">

                                <!-- Modal content-->
                                 <div class="modal-content" >
                            <div class="modal-header">
                              <button type="button" class="close"  data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Detalle de Emision</h4>
                            </div>
                            <div class="modal-body">
                                    <div id='VisorArticulo'></div>
								    <div id='GuardaArticulo'></div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>

                            </div>
     </div>
	
	<!-- Modal -->
	
    <div class="modal fade" id="myModalIva" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Emitir Comprobante electronico</h4>
											</div>
											<div class="modal-body">
												 
													<div class="row">
														
														<div class="col-md-12"> 
															
															 <button id="botonn" onClick="_Generar_factura()" type="button" class="btn btn-success"  >Generar Comprobante Electronico</button>
															
															 <button id="botonn" onClick="_Imprimir_factura()" type="button" class="btn btn-danger"  >Descargar Comprobante Electronico</button>
															
															
															<div style="padding:10px" align="center" id='Resultado_facturae'></div>
															
															<input type="hidden" id="emision_iva" name="emision_iva">
														</div>	
													</div>	
												 
											</div>
											<div class="modal-footer">
  												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
                             </div>
     </div>
	
 	
	
    <div class="modal fade" id="myModalFac_view" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Emitir Comprobante electronico</h4>
											</div>
											<div class="modal-body">
												 
													<div class="row">
														
														<div class="col-md-12"> 
															
															<div id="lista_datos"> </div>	
														 
														</div>	
														
														 <div align="center" id="Resultado_facturae_id"> </div>	
													</div>	
												 
											</div>
											<div class="modal-footer">
  												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
                             </div>
     </div>
	
 		
    <div class="modal fade" id="myModalExterno" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio_externo">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Tramites Pendientes</h4>
											</div>
											<div class="modal-body">
												 
													<div class="row">
														
														<div class="col-md-12"> 
															
														 <table id="jsontable_externo" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																				 <thead>
																					   <tr>   
																						     <th width="5%">Referencia</th>
																							 <th width="10%">Orden</th>
																						     <th width="10%">Identificacion</th>
																						     <th width="30">Solicita/Nombre Contribuyente/Beneficiario</th>
  																							 <th width="25%">Detalle (Concepto/Descripcion/Novedad)</th>
 																							 <th width="10%">A pagar</th>
																							 <th width="10%">Accion</th>
																					   </tr> 
																				</thead>
																 </table>
														 
														</div>	
														
														 <div align="center" id="Resultado_facturae_id"> </div>	
													</div>	
												 
											</div>
											<div class="modal-footer">
  												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
                             </div>
     </div>
	
	 <div class="modal fade" id="myModalCapacitacionesExterno" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio_externo">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Capacitaciones Pendientes</h4>
											</div>
											<div class="modal-body">
												 
													<div class="row">
														
														<div class="col-md-12"> 
															
														 <table id="jsontablecapacitaciones_externo" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																				 <thead>
																					   <tr>   
																						     <th width="5%">Referencia</th>
																							 <th width="10%">Orden</th>
																						     <th width="10%">Identificacion</th>
																						     <th width="30">Solicita/Nombre Contribuyente/Beneficiario</th>
  																							 <th width="25%">Detalle (Concepto/Descripcion/Novedad)</th>
 																							 <th width="10%">A pagar</th>
																							 <th width="10%">Accion</th>
																					   </tr> 
																				</thead>
																 </table>
														 
														</div>	
														
														 <div align="center" id="Resultado_facturae_id"> </div>	
													</div>	
												 
											</div>
											<div class="modal-footer">
  												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
                             </div>
     </div>
	 
	 
	<div class="modal fade" id="myModalTramiteNuevo" role="dialog">
		<div class="modal-dialog" id="mdialTamanio_externo">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close"  data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Trámite Nuevo</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label col-sm-3" style="padding-bottom:3px;">Orden de Cobro:</label>
								<div class="col-sm-9" style="padding-bottom:3px;">
									<input type="text" class="form-control input-lg" style="background-color:#337ab7;color:#ffffff;" id="capacitacion_codigo" placeholder="Ej: CBSD24CAP00015" name="capacitacion_codigo">
								</div>
							</div> 
						</div>	
						<div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label col-sm-3" style="padding-bottom:3px;">Cedula/RUC:</label>
								<div class="col-sm-9" style="padding-bottom:3px;">
									<input type="text" class="form-control" id="persona_cedula" placeholder="Ej: 9999999999" name="persona_cedula">
								</div>
							</div> 
						</div>	

					</div>

					<div class="row">

						<!-- <div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label col-sm-3" style="padding-bottom:3px;">Apellidos:</label>
								<div class="col-sm-9" style="padding-bottom:3px;">
									<input type="text" class="form-control" id="persona_apellidos" placeholder="Ej: Ramirez Lopez" name="persona_apellidos">
								</div>
							</div> 
						</div>	
						<div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label col-sm-3" style="padding-bottom:3px;">Nombres:</label>
								<div class="col-sm-9" style="padding-bottom:3px;">
									<input type="text" class="form-control" id="persona_nombres" placeholder="Ej: Rafael Arturo" name="persona_nombres">
								</div>
							</div> 
						</div>	 -->
						<div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label col-sm-3" style="padding-bottom:3px;">Razón Social:</label>
								<div class="col-sm-9" style="padding-bottom:3px;">
									<input type="text" class="form-control" id="persona_razon" placeholder="Ej: Pronaca Cia. Ltda." name="persona_razon">
								</div>
							</div> 
						</div>	
						
						<div class="col-md-12"> 
							<div class="form-group">
								<label class="control-label col-sm-1" style="padding-bottom:3px;">Concepto/Motivo:</label>
								<div class="col-sm-11" style="padding-bottom:3px;">
									<input type="text" class="form-control" id="capacitacion_motivo" placeholder="Ej: Capacitacion para el dia 20 de julio a 30 personas" name="capacitacion_motivo">
								</div>
							</div> 
						</div>	
						<div class="col-md-12"> 
							<div class="form-group">
								<label class="control-label col-sm-1" style="padding-bottom:3px;">Dirección:</label>
								<div class="col-sm-11" style="padding-bottom:3px;">
									<input type="text" class="form-control" id="persona_direccion" placeholder="Ej: Coop. Santa Martha Sector 3" name="persona_direccion">
								</div>
							</div> 
						</div>	

						<div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label col-sm-3" style="padding-bottom:3px;">Monto:</label>
								<div class="col-sm-9" style="padding-bottom:3px;">
									<input type="number" step="0.01" min="0" class="form-control input-lg" style="background-color:#ff0945;color:#ffffff" id="orden_monto" placeholder="Ej: 30.00" name="orden_monto">
								</div>
							</div> 
						</div>	

					</div>	

					<div align="center" id="Resultado_facturae_id"> </div>	

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onClick="GuardarRecaudacionManual()">Guardar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	
	
	 <!-- Modal -->
	
    <div class="modal fade" id="myModalDocumento" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio_dato">

                                <!-- Modal content-->
                                 <div class="modal-content" >
                            <div class="modal-header">
                              <button type="button" class="close"  data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Busqueda Avanzada</h4>
                            </div>
                            <div class="modal-body">
                                   
									<div class="form-group"  >
									  <label class="control-label col-sm-2" style="padding-bottom:3px;">Busqueda Referencia avanzada:</label>
									  <div class="col-sm-10" style="padding-bottom:3px;">
										<input type="text" class="form-control" id="doc_busqueda" placeholder="Ingrese documento/clave/referencia" name="doc_busqueda">
									  </div>
									</div> 
								
								<div class="form-group">
									  <label class="control-label col-sm-2" style="padding-bottom:3px;">Busqueda Nombre avanzada:</label>
									 <div class="col-sm-10" style="padding-bottom:3px;">
										<input type="text" class="form-control" id="doc_nombre" placeholder="Ingrese Nombre Conribuyente" name="doc_nombre">
									  </div>
									</div> 
								
								  <div class="form-group" >
									  
								    <div id='Visor_Busqueda' style="padding-bottom:3px;"></div>
									  
								  </div> 	  
                            </div>
                            <div class="modal-footer">
								
								<button type="button" onClick="BuscarDocumento()" class="btn btn-info" >Buscar</button>
								
								<button type="button" onClick="LimpiarDocumento()" class="btn btn-success" >Limpiar</button>
								
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>

                            </div>
     </div>
	
	
	
    <div id="FormPie"></div>  
    
</div>

</body>
</html>
