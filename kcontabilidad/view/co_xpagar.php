<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
 
<script  type="text/javascript" language="javascript" src="../js/co_xpagar.js"></script>
	
 <style type="text/css">
	 
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
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
	 
	 #mdialTamanio{
  					width: 90% !important;
		}
	 #mdialTamanio1{
  					width: 90% !important;
		}
	 
	 .form-control_asiento {  
		  display: block;
		  width: 100%;
		  height: 28px;
		  padding: 3px 3px;
		  font-size: 12px;
		  line-height: 1.428571429;
		  color: #555555;
		  vertical-align:baseline;
		  text-align: right;
		  background-color: #ffffff;
		  background-image: none;
		  border: 1px solid #cccccc;
		  border-radius: 4px;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
				  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
				  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
   }
 
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 4px;
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
 	
	<div id="mySidenav" class="sidenav" >
		
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
		
   </div>
	
	
     <div class="col-md-12"> 
       
		 <!-- Content Here -->
		 
	    <div class="row" >
			
 		 	<div class="col-md-12">
		  	 
				<ul id="mytabs" class="nav nav-tabs">  
					 
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>TRAMITES PENDIENTES POR DEVENGAR</b></a>
										</li>
			
			 
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-forward"></span> Generar Asiento Cuentas por Pagar</a>
										</li>
			
										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-duplicate"></span> Comprobantes electronicos relacionados/Ruta del Tramite</a>
										</li>
  			
				 </ul>
		 
		 
                <!-- ------------------------------------------------------ -->
				<!-- Tab panes -->
				<!-- ------------------------------------------------------ -->
		 
				<div class="tab-content">
					
 					 <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
						 
									  <div class="panel panel-default">
										   <div class="panel-body" > 
										   
											   <div class="col-md-12" >
												   
												   <div class="col-md-4" >
													   
													   <select id='vestado' onChange="Busqueda();" name ="vestado"  class="form-control" style="background-color:#e5e5ff">
														   
														 <option value="5">Tramites Por Devengar</option>
														 <option value="6">Tramites Devengados</option>
														   
													   </select>
													   
												  </div>  
												   
												   
												   
												   <div class="col-md-3" >
 														<input type="number" name="qtramite" id="qtramite" autocomplete="off" class="form-control" style="background-color:#FFFE97" placeholder="Buscar Tramite">
												    </div>   
												   
												   <div style="padding-top: 3px;" class="col-md-2">

																				<button type="button" class="btn btn-sm btn-primary" id="load">  
																				<i class="icon-white icon-search"></i> Buscar</button>	

													 </div>
												   
										     </div>
											   
											    <div class="col-md-12" >
											   
													  <div class="table-responsive" id="employee_table1">
												  
													<table id="jsontable_tramite" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																							<thead>
																								<tr>
																								<th width="5%">Tramite</th>
																								<th width="8%">Fecha</th>
																							    <th width="21%">Beneficiario</th>	
																								<th width="8%">Comprobante</th>	
																								<th width="15%">Unidad</th>
																								<th  width="30%">Detalle</th>
																								<th  width="6%">Control</th>
																								<th width="7%">Acción</th>
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
										   
											       <div class="col-md-12">
												   
													<div class="alert al1ert-info fade in">
														
															<div id="DivAsientosTareas"></div>
															<div class="col-md-12">
															 <div class="col-md-6"> &nbsp; </div>
															 <div class="col-md-2"><div id="taumento" align="right"></div></div>
															 <div class="col-md-2"><div id="tdisminuye" align="right"></div></div>
															 <div class="col-md-2"><div id="SaldoTotal" align="right"></div></div>
														    </div>

													 </div>
												   
                     						      </div>
											   
											       <div class="col-md-12">
  
													<div class="col-md-4">  

														<select id="norma" name="norma" class="form-control">
														  <option value="S">Aplicación Acuerdo Nro.0075</option>
														  <option value="N">Aplica ( Certificacion incluido IVA)</option>
														  <option value="X">No Aplica</option>	
														</select>

												    </div>	
												   
												  </div>	   
 											 
											       <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px">

																			  <div class="col-md-3">

																					<input type="text" readonly class="cla_sesion" name="modulo" id="modulo">
																			  </div> 

													</div> 
 
												   <div class="col-md-12">


																				<div class="col-md-3">
																					<input type="text" readonly class="cla_sesion" name="sesion" id="sesion">
																				 </div> 	
																				<div class="col-md-3">
																					<input type="text" readonly class="cla_sesion" name="creacion" id="creacion">
																				 </div> 	
																				<div class="col-md-3">
																					<input type="text" readonly class="cla_sesion" name="sesionm" id="sesionm">
																				 </div> 	
																				<div class="col-md-3">
																					<input type="text" readonly class="cla_sesion" name="modificacion" id="modificacion">
																				 </div> 	
													 </div> 
											   
										   </div>
										  
									  </div>
					 </div>
					
					<!-- Tab 3  -->
					
					<div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
										   
											   <h4> Comprobantes electronicos emitidos por tramite </h4>
											   
											   
											   
											     <div class="col-md-12" style="padding: 10px" > 
 
																	 <button type="button" onClick="AbrirTributacion()" class="btn btn-sm btn-success"><i class="icon-white icon-ambulance"></i> Generar Retención</button>
													
																	 
												 </div>		
											   
										   
											   <div class="col-md-12">
												   
													<div class="alert al1ert-info fade in">
														
														
														  <div class="col-md-12">
																	 <table id="jsontable_factura" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																			<thead>
																				<tr>
																											<th width="10%">Fecha</th>
																											<th width="10%">Identificacion</th>
																											<th width="30%">Beneficiario</th>
																											<th width="10%">Factura</th>	
																											<th width="10%">Tarifa 0%</th>	
																											<th width="5%">Base Imponible</th>
																											<th  width="5%">Monto Iva</th>
																											<th width="10%">Retencion</th>
																					<th width="5%">Fuente</th>
																					<th width="5%">IVA</th>
																				</tr>
																			 </thead>
																			  </table>
														  </div>	
														
														 
															 
 														 </div>		
														
 													 </div>
												   
												   
                      						  </div>
											   
											   <hr>
												   
											   <h4>Ruta Tramite Administrativo -  Financiero</h4>
											   
											    <div class="col-md-12" style="padding: 10px" > 
																		
 													
																	 
												 </div>		 

												<div class="col-md-12" style="padding: 10px" > 

																		<div id="ViewFormRuta"> </div>

												</div>	
											   
 										   </div>
									  </div>
					 </div>
					
					
					
  									
	 			</div>
       
			 </div>	  
 		</div>
    
    </div>

	<input type="hidden" value="0" id="xid_asientod" name="xid_asientod">

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
 					  		 <div id="guardarAux"></div> 
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

	
  <div class="container"> 
	  <div class="modal fade" id="myModalGasto" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Enlace contable presupuestario</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
						 <div class="panel-body">
 					  		  <table id="jsontable_gasto" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th width="10%">Partida</th>
														<th width="10%">Clasificador</th>
														<th width="10%">Cuenta</th>	
														<th width="50%">Detalle</th>
														<th width="10%">Disponible</th>
														<th width="10%">Acción</th>
													</tr>
												</thead>
									</table>
 					  		 <div id="guardarGasto"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
			  
 					<button type="button" onClick="CalcularIvaTramite()" class="btn btn-sm btn-info">Verificar Impuesto</button>

					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 				
		 
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 

   
  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAsistente" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio1">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Asistente de asientos</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewAsientoGasto"> var</div> 
 					  		 <div id="guardarGasto"></div> 
							 
							   <div class="col-md-12" style="padding: 10px" id="sumair"  name="sumair"> 
					     </div>
					     </div>   
  					 </div>
					  
					
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAsientoDetalle()">
				<i class="icon-white icon-search"></i> Guardar</button> 
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
	  
	  <div class="modal fade" id="myModalAuxIng" tabindex="-1" role="dialog">
		  
  		  <div class="modal-dialog" id="mdialTamanio4">
		  
				<div class="modal-content">

								    <div class="modal-header">

									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h5 class="modal-title">Asistente de asientos por pagar</h5>

								  </div>

									<div class="modal-body">

										   <div class="form-group" style="padding-bottom: 5px">

												<div class="panel panel-default">

													   <div class="panel-body">
																 <div id="ViewFiltroIngreso"> var</div> 
																 <div id="guardarIngreso"></div> 
													   </div>

												 </div> 

											 </div>

								  </div>

									<div class="modal-footer">
								<button type="button" class="btn btn-sm btn-primary"  onClick="AgregaCuenta_enlace()">
								<i class="icon-white icon-search"></i> Guardar</button> 
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							</div>

				</div>
			  
		  <!-- /.modal-content --> 
	  	  
		  </div>
		  
		  <!-- /.modal-dialog -->
	  </div>
	  
  </div> 



	<div class="container"> 
	
	   <div class="modal fade" id="myModalprov" tabindex="-1" role="dialog">
		  
  	  		<div class="modal-dialog" id="mdialTamanio">
		  
				<div class="modal-content">

						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3  class="modal-title">Auxilar (Beneficiario)</h3>
						  </div>

						  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
							  <div class="panel panel-default">

								 <div class="panel-body">
									 <div id="ViewFiltroProv"> var</div> 

								 </div>
								 </div>   
							 </div>
						  </div>

						  <div class="modal-footer" >

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
	  <div class="modal fade" id="myModalCostos" tabindex="-1" role="dialog">
  	 <div class="modal-dialog" id="mdialTamanio">
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
							  <div style="padding: 10px" id="guardarCosto"></div> 
							  <div id="view_detalle_costo"></div> 
 					  		
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
	  <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarCosto()">
		      Guardar</button> 
			  
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 

  	<!-- Page Footer-->
  <div id="FormPie"></div>  
    
 </div>   

 </body>

</html>
 