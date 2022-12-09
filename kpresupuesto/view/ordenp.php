<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
	
 
	
 <script type="text/javascript" src="../js/ordenp.js"></script> 
    
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
 							
		<!-- Nav tabs     -->     
		                      
								<ul id="mytabs" class="nav nav-tabs">

															<li class="active"><a href="#tab1" data-toggle="tab"></span>
																<span class="glyphicon glyphicon-th-list"></span> <b>TRAMITES EMITIDOS POR CONTABILIDAD</b>  </a>
															</li>
															<li><a href="#tab2" data-toggle="tab">
																<span class="glyphicon glyphicon-link"></span> Recorrido y detalle del tramite</a>
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
																									<th width="10%">Tramite</th>	
																									<th width="10%">Fecha</th>
																									<th width="10%">Comprobante</th>				
																									<th width="40%">Detalle</th>
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
											   
											  	 
											   <div class="col-md-7">

												     <h5  class="modal-title"><b>Comprobantes electronicos emitidos por tramite </b></h5>
												   
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

														 

												   </div>
											   
										   </div>
										   
									   </div>
									   
								   </div>
									
 								</div>
	 </div>	  

  <input type="hidden" value="0" id="xid_asientod" name="xid_asientod">
 


 
			 

   <div class="container"> 
	
	  <div class="modal fade" id="myModalciu" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio_aux_d">

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

 

 </body>

</html>
 