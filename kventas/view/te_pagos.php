<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/te_pagos.js"></script> 
    
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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
       
		<!-- Content Here -->
	    
		<div class="row">
			
 		 	     <div class="col-md-12">
					
					  	 
					 
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>PAGOS POR REALIZAR</b></a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Comprobante de Pago</a>
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
 							
 										   
  												<div class="col-md-2" style="background-color:#ededed;">
													    
														   
														    <div id="ViewFiltro"></div> 
														   
															 
													
															<div style="padding-top: 15px;padding-bottom: 15px" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
															</div>
													
															 
												</div>
												
											    <div class="col-md-10">
												        <h5>Transacciones por periódo</h5>
													     <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Asiento</th>
																						<th width="10%">Fecha</th>
																						<th width="10%">Comprobante</th>
																						<th width="10%">Identificación</th>
																						<th width="20%">Beneficiario</th>
																						<th width="20%">Detalle</th>
																						<th width="10%">Apagar</th>
																						<th width="10%">Accion</th>
																						</tr>
																					</thead>
														  </table>
													
													 <div id="totalPago" 
														  align="right" 
														  style="font-size: 30px;font-weight: 700;padding: 10px"> 
													</div>  
                                                    
                                                     <div id="mensajeEstado" 
														  align="right" 
														  style="font-size: 18px;font-weight: 700;padding: 10px"> 
													</div>  
                                                     
                                                    <div style="padding-top: 5px;" align="right" class="col-md-12">
																	<button type="button" onClick="PagoVarios()" class="btn btn-sm btn-danger" id="Selec">  
																	<i class="icon-white icon-money"></i>  Generar pago a proveedor</button>	
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
											   
											      <div class="col-md-6">
												   
													<div class="alert al1ert-info fade in">
														
															<div id="DivAsientosTareas"></div>
														 

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
	
	  <div class="modal fade" id="myModalciu" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio2">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Auxilar (Beneficiario)</h3>
								  </div>

								  <div class="modal-body">
											 <div class="form-group" style="padding-bottom: 10px">
													 <div class="panel panel-default">

														 <div class="panel-body">

															 <div id="ViewFiltroProv"> </div> 
															 
															

														 </div>

													 </div>   
											 </div>
								  </div>

								  <div class="modal-footer" >

									   <div id="guardarciu">  </div> 
									  
									 <button type="button" id="GuardaCiu" class="btn btn-info btn-sm">Actualizar Informacion</button>
									  
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
 </div>   
 </body>
</html>
 