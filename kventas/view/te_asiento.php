<?php
	session_start( );
?>	
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
	 
	    #mdialTamanio4{
  					width: 65% !important;
		}
	 
	 	#mdialTamanio_aux_d{
  					width: 80% !important;
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
	
 <script type="text/javascript" src="../js/te_asiento.js"></script> 
    
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

														<a href="#" title= "Ver Auxiliares" onClick="VerBeneficiarios()"  data-toggle="modal" data-target="#myModalprov"><img src="../../kimages/03_.png" align="absmiddle"/> Ver Auxiliares</a>  &nbsp;


												   	<a href="#" title= "Ver Cuentas por Pagar/Cobrar" data-toggle="modal" data-target="#myModalcc"><img src="../../kimages/02_.png" align="absmiddle"/> Ver CxPagar/Cobrar</a>  &nbsp;

												   
												   
														<a href="#" title= "Ver Comprobantes relacionados" onClick="BusquedaGrillaFactura(oTableFactura)"  data-toggle="modal" data-target="#myModalfactura">
															<img src="../../kimages/3p.png" align="absmiddle" /> Comprobantes Electronicos
														</a>  

													<a href="#" title= "Enlace Presupuesto Ingreso" onClick="VerIngresos(oTableIngreso)"  data-toggle="modal" data-target="#myModalIngresos">
                 									<img src="../../kimages/5p.png" align="absmiddle"/> Enlace Presupuesto Ingreso</a>
													
												   </div>
 											   
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
											   
											  	 
											       <div class="col-md-12">
													   
													   <div class="alert alert-success">
															  <strong>Advertencia!</strong> Para cerrar cuentas de años anteriores por pagar no se olvide de realizar juego de cuentas con 213.81/83/85 etc. en el caso que no tengan afectación presupuestaria/ para las de afectación debe realizar certificación presupuestaria.	
															</div>

															<div class="alert alert-info">
															  <strong>Información!</strong> Para las cuentas por cobrar debe tomar en cuenta realizar el cruce de las cuentas 124.98/113.98/ Enlazar con las cuentas que tienen afectación presupuestaria.
															</div>

												   </div>
											   
										   </div>
										   
									   </div>
									   
								   </div>
									
 								</div>
	 </div>	  
  <input type="hidden" value="0" id="xid_asientod" name="xid_asientod">

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
	
	  <div class="modal fade" id="myModalcc" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio_aux_d">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Cuentas por Pagar/Cobrar</h3>
								  </div>

								  <div class="modal-body">
 													 <div class="panel panel-default">

														 <div class="panel-body">
															 
															  <div class="col-md-12" style="padding: 10px">
 																	   <div class="col-md-6">
 																	  			<select name="cfiltro" id="cfiltro" class="form-control"></select>
 															  			</div>
																         <div class="col-md-3">
 																			  <button type="button" onClick="BuscaCxPC()" class="btn btn-sm btn-info">Buscar</button>
 															  			</div>
 															  </div>
															 
															 
															    <div class="col-md-12" style="padding: 10px">
 																	 <div id="ViewCxC">  </div> 
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

															 
															   <table id="jsontableIngreso" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="15%">Partida</th>
																									<th width="25%">Nombre</th>
																									<th width="10%">Clasificador</th>				
																									<th width="15%">Cuenta</th>
																									<th width="25%">Nombre</th>	
																									<th width="10%">Acción</th>
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
											   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  

 

 </body>

</html>
 