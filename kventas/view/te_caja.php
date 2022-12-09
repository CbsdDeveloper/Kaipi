<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
	
 <style type="text/css">
	 
  		#mdialTamanio{
  					width: 75% !important;
		}
  </style>
	
 <script type="text/javascript" src="../js/te_caja.js"></script> 
    
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

												<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 

												<ul id="mytabs" class="nav nav-tabs">                    
														<li class="active"><a href="#tab1" data-toggle="tab"></span>
															<span class="glyphicon glyphicon-th-list"></span> <b>Caja Bancos Recaudacion</b>  </a>
														</li>
														<li><a href="#tab2" data-toggle="tab">
															<span class="glyphicon glyphicon-link"></span> Registro Depositos</a>
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

																								<div class="col-md-12" style="background-color:#ededed;padding-bottom: 15px;padding-top: 10px ">

																										<div id="ViewFiltro"></div> 


																										<div style="padding-top: 5px;" class="col-md-3">
																												<button type="button" class="btn btn-sm btn-primary" id="load">  
																												<i class="icon-white icon-search"></i> Buscar</button>	
																										</div>

																							</div>

																								 <div class="col-md-12">
																									<h5>Transacciones por periodo</h5>
																								   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																																<thead>
																																	<tr>
																																	<th width="10%">Asiento</th>
																																	<th width="10%">Fecha</th>
																																	<th width="10%">Estado</th>
																																	<th width="10%">Comprobante</th>
																																	<th width="40%">Detalle</th>
																																	<th width="10%">Transaccion</th>
																																	<th width="20%">Acción</th>
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

														   </div>
													  </div>
												 </div>

									 </div>
				  </div>	  



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


					<!-- Page Footer-->
					<div id="FormPie"></div>  
	
 </div>   
 </body>
</html>
 