<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
	
 <style type="text/css">
  		#mdialTamanio{
  					width: 75% !important;
		}
	 
	   .highlight {
				 background-color: #FF9;
		   }
		  .de {
				 background-color:#c3e1fb;
		  }
		  .ye {
				 background-color:#93ADFF;
		  }
		 .di {
				 background-color:#F5C0C1;
		  }
  </style>
 <script type="text/javascript" src="../js/co_asientos_rev.js"></script> 
    
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
 								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
								<ul id="mytabs" class="nav nav-tabs">        
									
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>REVISION DE ASIENTOS CONTABLES</b>  </a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Novedades Enlaces</a>
										</li>
	
										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Revision de datos</a>
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
																<div class="col-md-12"   style="background-color:#ededed;padding: 5px">

																		<div id="ViewFiltro"></div> 
																		<div style="padding-top: 5px;" class="col-md-1" align="left">
																				<button type="button" class="btn btn-sm btn-primary" id="load">  
																				<i class="icon-white icon-search"></i> Buscar</button>	
																		</div>

																</div>

																<div class="col-md-12">
																	<h5>Transacciones por periódo</h5>
																   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="10%"><b>Asiento</b></th>
																									<th width="10%">Fecha</th>
																									<th width="10%">Estado</th>
																									<th width="10%">Comprobante</th>
																									<th width="30%">Detalle</th>
																									<th width="5%">Debe</th>
																									<th width="5%">Haber</th>
																									<th width="5%"><b>Tramite</b>	</th>	
																									<th width="15%">Acción</th>
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

														   <div class="panel-body"> 

																  <div class="col-md-12">
																	  
 																			 <div class="col-md-12">
																				 
																			   <h5>( NOVEDADES ASIENTOS SIN AUXILIARES )</h5>

																			   <div style="padding-top:3px;" class="col-md-4" align="left">
																							<button type="button" class="btn btn-sm btn-primary" id="loadAux">  
																							<i class="icon-white icon-search"></i> Buscar Ctas Sin Auxiliar</button>	
																				   
																				   
																						   <button type="button" class="btn btn-sm btn-default" id="loadAuxD">  
																							<i class="icon-white icon-search"></i> Generar Ctas Sin Auxiliar</button>	

																							 <button type="button" class="btn btn-sm btn-info" id="loadAuxPago">  
																							<i class="icon-white icon-search"></i> Buscar Auxiliar estado</button>	

																				  </div>

																			   <div class="col-md-3">

																							  <input type="text" maxlength="13" name="dato_ruc" id="dato_ruc" class="form-control" placeholder="Ruc beneficiario">

																		       </div>
																				 
																				 <div class="col-md-3">

																							 

																		       </div>
																				 			 <div class="col-md-3">

																							 <select name="dato_mes" id="dato_mes" class="form-control">
																							   <option value="1">Enero</option>
																								   <option value="2">Febrero</option>
																								   <option value="3">Marzo</option>
																								   <option value="4">Abril</option>
																								   <option value="5">Mayo</option>
																								   <option value="6">Junio</option>
																								   <option value="7">Julio</option>
																								   <option value="8">Agosto</option>
																								   <option value="9">Septiembre</option>  
																								 <option value="10">Octubre</option>
																								 <option value="11">Noviembre</option>
																								 <option value="12">Diciembre</option>
																								 
																							 </select>

																		       </div>

																	</div>  



																	   <table id="jsontable_aux" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																									<thead>
																										<tr>
																										<th width="5%">Id</th>
																										<th width="5%">Fecha</th>	
																										<th width="8%">Cuenta</th>
																										<th width="30%">Detalle / Cuenta</th>
																										<th width="40%">Descripcion / Nombre Auxiliar</th>
																										<th width="5%">Ref/Pago</th>
																										<th width="5%">Debe</th>
																										<th width="5%">Haber</th>
																										</tr>
																									</thead>
																		  </table>
																</div>  

														   </div>
													  </div>
												 </div>



												  <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">

														   <div class="panel panel-default">

																   <div class="panel-body"> 



																		 <div class="container">
																			 
																			  <h2>Alerta</h2>

																			  <div class="alert alert-success">
																				  
																				  <div class="container">
																						<strong>Success!</strong> Asientos Descuadrados
																							<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
																								<button id="buno" type="button" class="btn btn-default  btn-sm">Busqueda transaccion </button>
																						   </div>

																						   <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
																								 <div id="ver_dato">  </div>
																						   </div>
																				   </div>
																			  </div>


																			  <div class="alert alert-info">

																				  <div class="container">
																					<strong>Info!</strong> Gestion Presupuestaria Revision


																							 <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
																								<div class="col-md-3"> <select id="cod_estado" class="form-control">

																								<option value="-">Estados Tramite </option>

																								    <option value="1">1. Requerimiento Solicitado </option>
																								    <option value="2">2. Tramite Autorizado</option>
																									 <option value="3">3. Certificacion Presupuestaria</option>
																									 <option value="5"> 5. Compromiso Presupuestario  </option>
																									  <option value="6"> 6. Devegado Presupuestario  </option>
																									 <option value="0"> 0. Anular  </option>
																								</select>  

																								</div>
																								<div class="col-md-4"> 
																									<input type="text" id="cod_tramite" placeholder="Codigo Tramite"  class="form-control">  
																								 </div>
																						   </div>


																						  <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 

																								<button type="button" id="bdos" class="btn btn-default  btn-sm"> Procesar >>>>   </button>


																								<button type="button" onclick="CargaDatos()" data-toggle="modal" data-target="#myModalProducto" class="btn btn-warning  btn-sm"> Ver fechas  </button>

																						   </div>

																				   </div>

																			  </div>



																			  



																			  <div class="alert alert-danger">

																				  <div class="container">
																					<strong>Danger!</strong> ENLAZAR TRAMITES PARA ASIENTOS CONTABLES


																					   <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
																						   
																								<a href="co_asientos_tramite" class="btn btn-info" role="button">Ir a la opcion</a>
 

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
									
								 
	 

<input type="hidden" id="id_asiento" name="id_asiento">

<input type="hidden" id="codigodet" name="codigodet">

 

     <!-- /.auxiliar -->  

		  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
		  
  	  <div class="modal-dialog">
		  
		<div class="modal-content">
			
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Selección de Auxilar (Beneficiario)</h3>
		  </div>
			
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroAux"> var</div> 
							  <p>&nbsp; 	     </p>   
 					  		 <div align="center" id="guardarAux"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		    <div class="modal-footer">
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAuxiliar()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
			
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  

	  <!-- /. costos  -->  

		  <div class="container"> 
	  
	 <div class="modal fade" id="myModalCostos" tabindex="-1" role="dialog">
		 
  	  <div class="modal-dialog" id="mdialTamanio">
		  
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 class="modal-title">Selección de Costos</h5>
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
	
		  <!-- /. pagos  -->  

 		 <div class="container"> 
	  
	  <div class="modal fade" id="myModalPago" tabindex="-1" role="dialog">
		  
  	     <div class="modal-dialog" id="mdialTamanio">
			 
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 class="modal-title">Comprobante de pago</h3>
				  </div>
						  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
							  <div class="panel panel-default">

								 <div class="panel-body">
									 <div id="ViewPago" >xxxx</div> 

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
	
              <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
				  
                <div class="modal-dialog" id="mdialProducto">
					
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Verificacion de datos</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
											  <div class="panel-body">
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Id.Tramite</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="text" name="tramite" id="tramite" readonly autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Solicitud</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fecha" id="fecha" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												 
												  <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Certificacion</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fechac" id="fechac" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Compromiso</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fechacc" id="fechacc" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Estado</label>
												  	<div  style="padding-top: 5px;" class="col-md-9">
														
												  	<select name="festado"  id="estado_p" name ="estado_p" class="form-control">
														<option value="1">1. Requerimiento Solicitado</option>
														<option value="2">2. Tramite Autorizado</option>
														<option value="3">3. (*) Emitir Certificacion</option>
														<option value="5">5. Compromiso Presupuestario</option>
														<option value="6">6. Tramites Devengado</option>
														<option value="0">Anulada transaccion</option>
														</select>
												  </div>
												  
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Devengado</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fechacd" id="fechacd" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												  <label style="padding-top: 12px;text-align: right;" class="col-md-3">Asiento</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="text" name="idasiento" id="idasiento" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												  
												  
												  
												   
											 </div>
  											<div align="center"  style="font-size: 13px"id="guardarProducto" ></div> 
							   </div> 
							 
							  <div class="modal-footer">

								  <button type="button" class="btn btn-sm btn-info" onClick="ActualizaInformacion()">Actualizar</button>
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
	 
	  <div class="modal fade" id="myModalAuxPago" tabindex="-1" role="dialog">
		  
  	     <div class="modal-dialog">
			 
		<div class="modal-content">
			
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Estado auxiliar</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		  
							 		   <div class="col-md-12">
										    <div class="col-md-3" style="padding-top: 5px">
												Estado Pago Auxiliar
												 </div> 	
										   	 <div class="col-md-6">
												 <select name="pagado" id="pagado" class="form-control">
																							      <option value="S">Pagado</option>
																								   <option value="N">No Pagado</option>
 																							 </select>
											 </div> 	 
										     <input type="hidden" name="id_auxd" id="id_auxd">
 										   
										</div>  
							 
										 <div class="col-md-12" style="padding: 20px">
							 					 <div id="result_dato"> </div> 
										</div>  	 
 					  	 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
			  	<button type="button" onClick="CambioEstado()" class="btn btn-sm btn-success" >Actualizar Estado Pago</button>
			  
 			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div>
			 <!-- /.modal-content --> 
			 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 




  	<!-- Page Footer-->
    <div id="FormPie"></div>  
  
 </body>
</html>
 