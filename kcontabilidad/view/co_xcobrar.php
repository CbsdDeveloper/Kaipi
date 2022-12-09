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
    
 <script type="text/javascript" src="../js/co_xcobrar.js"></script> 
    
</head>
<body>
  <!-- ------------------------------------------------------ -->  
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
								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>CUENTAS POR COBRAR</b></a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Cuenta por cobrar - Registro de facturas</a>
										</li>
										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Cobro de Facturas</a>
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
 										  
 										   
  												<div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);
box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
													    
														    <h5>Filtro búsqueda</h5>
														    <div id="ViewFiltro"></div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
															<div style="padding-top: 5px;" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
																
																<button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
																
															</div>
													
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
													<h6>&nbsp;  </h6>
												</div>
												
											    <div class="col-md-9">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Asiento</th>
																						<th width="10%">Fecha</th>
																						<th width="10%">Factura</th>	
																						<th width="20%">Responsable</th>
																						<th width="20%">Detalle</th>
																						<th width="10%">Pagado</th>	
																						<th width="10%">Monto</th>		
																						<th width="10%">Acción</th>
																						</tr>
																					</thead>
														  </table>
													
													<div id="totalPago" 
														  align="right" 
														  style="font-size: 30px;font-weight: 700;padding: 10px"> $
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
									
								<!-- Tab 3 -->
								 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
										   
 											   
											   <div id="ViewFormCxc"> </div>
											   
											   <div class="panel panel-default">
													  <div class="panel-heading">Detalle de Movimiento Auxiliar</div>
													  <div class="panel-body">
											   				<div id="ListaViewFormCxc"> </div>
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
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 