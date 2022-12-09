<!DOCTYPE html>
<html lang="en"><head>
		<meta charset="utf-8">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

		<title>Plataforma de Gestión Empresarial</title>

		<?php  require('Head.php')  ?> 


	 <style type="text/css">

			#mdialTamanio{
						width: 75% !important;
			}

			#mdialTamanio4{
						width: 65% !important;
			}

			#mdialTamanio_aux_d{
						width: 85% !important;
			}


		 #mdialTamanio_aux1{
						width: 70% !important;
			}


			 .form-control_asiento {  
			  display: block;
			  width: 85%;
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

	 <script type="text/javascript" src="../js/co_asientos.js"></script> 

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
 
		
		<!-- Nav tabs     -->     
		                      
								<ul id="mytabs" class="nav nav-tabs">

															<li class="active"><a href="#tab1" data-toggle="tab"></span>
																<span class="glyphicon glyphicon-th-list"></span> <b>ASIENTOS CONTABLES</b>  </a>
															</li>
															<li><a href="#tab2" data-toggle="tab">
																<span class="glyphicon glyphicon-link"></span> Registro Asientos Contables</a>
															</li>
	
															<li>
																<a href="#tab3" data-toggle="tab">
																<span class="glyphicon glyphicon-arrow-right"></span> Ruta del Tramite/Documentos
																</a>
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

												   				<div class="col-md-12">

																	<div class="col-md-12" style="background-color:#ededed;padding-top: 10px;padding-bottom: 10px">

																			<div id="ViewFiltro"></div> 

																			<div style="padding-top: 9px;" class="col-md-2">

																					<button type="button" class="btn btn-sm btn-primary" id="load">  
																					<i class="icon-white icon-search"></i> Buscar</button>	

																			</div>



																	 </div>

																	<div class="col-md-12">

																			  <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																									<thead>
																										<tr>
																										<th width="10%">Asiento</th>
																										<th width="10%">Fecha</th>
																										<th width="10%">Comprobante</th>				
																										<th width="50%">Detalle</th>
																										<th width="10%">Creado</th>	
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

																	   <div class="panel-body"> 
 
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
																					   <div id="montoDetalleAsiento"></div>

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

 									
												 <div class="tab-pane fade in" id="tab3">
											 
													<div class="panel panel-default" style="padding: 1px">
														
															<div class="panel-body" style="padding: 1px"> 

																 <div class="col-md-12" style="padding: 10px" > 
																		<h4>Ruta Tramite Administrativo -  Financiero</h4>

																	 <button type="button" class="btn btn-sm btn-primary" id="loadt"><i class="icon-white icon-search"></i> Buscar</button>
																	 
																 </div>		 

																<div class="col-md-8" style="padding: 10px" > 

																		<div id="ViewFormRuta"> </div>

																  </div>	 


														   </div>
														
													  </div>

										 </div>
									
 								</div>
	
	 </div>	  

   
  <input type="hidden" id='id_asientoda' name="id_asientoda" value="0">

  <input type="hidden" value="0" id="xid_asientod" name="xid_asientod">

<input type="hidden" value="0" id="xid_asientoaux" name="xid_asientoaux">

  <input type="hidden" value="0" id="xtipo" name="xtipo">


   <div class="container"> 
	  
			  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">

						<div class="modal-dialog" id="mdialTamanio_aux1">

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
							 
						</div>
				  
			   <!-- /.modal-content --> 
				  
			  </div>
			  
		 	  <!-- /.modal-dialog -->
			  
	  	   </div>
	  
	<!-- /.modal -->
	  
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
			</div>
			 
	   	    <!-- /.modal-content --> 
 	  </div>
      <!-- /.modal-dialog -->
	</div>
	  <!-- /.modal -->
   </div> 

	

  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAsistente1" tabindex="-1" role="dialog">
		  
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
	


  <!-- /. costos  -->  

  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAuxIng" tabindex="-1" role="dialog">
		  
  		  <div class="modal-dialog" id="mdialTamanio4">
		  
				<div class="modal-content">

								    <div class="modal-header">

										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h5 class="modal-title">Asistente de asientos</h5>

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
	  
				  <div class="modal fade" id="myModalAsistente" tabindex="-1" role="dialog">

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
																						<th width="20%">Partida</th>
																						<th width="10%">Clasificador</th>
																						<th width="10%">Cuenta</th>	
																						<th width="50%">Detalle</th>
																						<th width="10%">Disponible</th>
																					</tr>
																				</thead>
																	</table>

																   <div id="guardarGasto"></div> 
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

						  <!-- /.modal-dialog myModalAsistente
						  </div><!-- /.modal -->

				  </div> 
  
  </div> 	


 
	

  <div class="container"> 
	
	  <div class="modal fade" id="myModalprov" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio_aux_d">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Auxilar (Beneficiarios)</h3>
								  </div>

								  <div class="modal-body">
 													 <div class="panel panel-default">

														 <div class="panel-body">

															 <div id="ViewFiltroProv"> var</div> 

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


<!-- enlace comprobantes -->


  <div class="container"> 
	
	  <div class="modal fade" id="myModalfactura" tabindex="-1" role="dialog">
		  
			  <div class="modal-dialog" id="mdialTamanio">

				<div class="modal-content">

						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3  class="modal-title">Comprobantes electronicos emitidos por tramite </h3>
						  </div>

						  <div class="modal-body">

								<div class="form-group" style="padding-bottom: 10px">

									 <div class="panel panel-default">

												 <div class="panel-body">

																  <div class="col-md-12">

																		<div class="alert al1ert-info fade in">

																			 <table id="jsontable_factura" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																													<th width="10%">Fecha</th>
																													<th width="10%">Identificacion</th>
																													<th width="30%">Beneficiario</th>
																													<th width="10%">Factura</th>	
																													<th width="10%">Tarifa 0%</th>	
																													<th width="10%">Base Imponible</th>
																													<th  width="10%">Monto Iva</th>
																													<th width="10%">Retencion</th>
																						</tr>
																					 </thead>
																					  </table>

																		 </div>

																  </div>

												 </div>
									 </div>   

								 </div>

						  </div>

						  <div class="modal-footer" >

							<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>

						  </div>

				</div><!-- /.modal-content --> 

			  </div><!-- /.modal-dialog -->
		  
	  </div>
	  
	  <!-- /.modal -->
	
  </div>  


<!-- enlace gastos presupuesto -->


  <div class="container"> 
	
	  <div class="modal fade" id="myModalIngresos" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio_aux_d">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Enlace Presupuesto - Ingresos</h3>
								  </div>

								  <div class="modal-body">
 													 <div class="panel panel-default">

														 <div class="panel-body">
															 
															 <div class="col-md-12"> 
															 
															    <div class="col-md-5"> 
																   
 																	
																	<select name="ingreso_lista" onChange="VerIngresos(oTableIngreso,this.value)"   id="ingreso_lista" class="form-control"></select>
																	
															    </div>
																 
																 
															  </div>	 

															 
																   <table id="jsontableIngreso" width="100%" class="display table table-condensed table-hover datatable">
																								<thead>
																									<tr>
																									<th width="10%">Partida</th>
																									<th width="30%">Nombre</th>
																									<th width="10%">Clasificador</th>				
																									<th width="10%">Cuenta</th>
																									<th width="30%">Nombre</th>	
																									<th width="1%">Seleccionar</th>
																									</tr>
																								</thead>
																	  </table>
															 
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
  
  
<!-- enlace gastos presupuesto -->

  <div class="container"> 
	
	  <div class="modal fade" id="myModalGastoDev" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio_aux_d">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Enlace Presupuesto - Gasto</h3>
								  </div>

								  <div class="modal-body">
 													 <div class="panel panel-default">

														 <div class="panel-body">
															 
															   <div class="col-md-12">
																     <div class="col-md-6" style="padding: 15px">
																  			 <select id="tramite_dato" onChange="BusquedaTramite(oTableGastoDev,this.value)" name = "tramite_dato" class="form-control"></select>
																	 </div>	 
																   
																    <div class="col-md-3" style="padding: 15px">
																			<input class="form-control" id="tramite_e" name="tramite_e" type="text">
																    </div>	 
																   <div class="col-md-2" style="padding: 15px">
																		 <button type="button" onClick="BusquedaTramiteId(oTableGastoDev)" class="btn btn-warning">Buscar</button>

																    </div>	
																   
															    </div>	   
															 
															  
															 
															  <div class="col-md-12">
																 
																  
 															   <table id="jsontableGastoDev" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="10%">Tramite</th>
																									<th width="20%">Partida</th>
																									<th width="30%">Detalle</th>				
																									<th width="10%">Clasificador</th>
																									<th width="10%">Cuenta</th>	
																								    <th width="10%">Monto</th>	
																									<th width="10%">Acción</th>
																									</tr>
																								</thead>
																	  </table>
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

<!-- cierre de anticipos -->

  <div class="modal fade" id="myModalAnticipo" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio_a">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Asistente de Cierre Anticipos</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewAsientoAnticipo"> var</div> 
 					  		 <div id="guardarAnticipo"></div> 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAsientoAnticipo()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>
				

<!-- enlace partidas  -->

 <div class="modal fade" id="myModalpartidas" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio_a">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Enlace con partidas</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="Viewpartidas"> var</div> 
							 <hr> 
 					  		 <div align="center" id="guardarpartidas"></div> 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAsientoOtro()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>


	<!-- Actualizar monto aux -->

<div class="modal fade" id="myModalvalor" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Actualizar valor auxiliar</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		   <div class="col-md-4">
							   	Actualizar Monto Auxiliar
							   </div>
							   <div class="col-md-8">
								   <input type="text" id="monto_pone" name="monto_pone" class="form-control">
							   </div>
							 
							 <hr> 
 					  		 <div align="center" id="guardar_valor"></div> 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="guarda_monto_aux()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>



  	<!-- Page Footer-->

    <div id="FormPie"></div>  

 

 </body>

</html>
 