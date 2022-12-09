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
    
 <script type="text/javascript" src="../js/co_pagos.js"></script> 
    
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
					 
 								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
					 
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>COMPROBANTES DE PAGO</b></a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Emisión de Comprobantes de Pago</a>
										</li>
								</ul>
	
								<!-- ------------------------------------------------------ -->
								<!-- Tab panes -->
								<!-- ------------------------------------------------------ -->
	
								<div class="tab-content">
								   <!-- Tab 1 -->
								   <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
									  <div class="panel panel-default">
										  <div class="panel-body" > 
 										   <div class="col-md-12" style="padding: 1px">
 										   
  												<div class="col-md-12" style="background-color:#F7F7F7">
													    
														    <h5>Filtro búsqueda</h5>
														    <div id="ViewFiltro"></div> 
 															 
															<div style="padding-top: 15px;padding-bottom: 10px" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															 
												</div>
												
											    <div class="col-md-12">
												        <h5>Transacciones por periódo</h5>
      
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																						<th width="7%">Asiento</th>	
																					    <th width="8%">Fecha</th>
																						<th width="20%">Beneficiario</th>
																						<th width="10%">Documento/Cheque</th>
																						<th width="30%">Detalle</th>
																						<th width="10%">Monto</th>
																						<th width="10%">FormaPago</th>
																						<th width="5%">Acción</th>
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
			<h3 class="modal-title">Selección Filtro</h3>
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
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 