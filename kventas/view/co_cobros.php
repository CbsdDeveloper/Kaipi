<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/co_cobros.js"></script> 
    
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
					 
 					 
								<ul id="mytabs" class="nav nav-tabs">      
									
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>COMPROBANTES DE INGRESO</b></a>
										</li>
	
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Emisión de Comprobantes de Ingreso</a>
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
																	<i class="icon-white icon-search"></i> Búsqueda de Comprobantes</button>	
																
															</div>	 
												</div>
												
											    <div class="col-md-12">
												        <h5>Transacciones por periódo</h5>
      
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																						<th width="7%">Asiento</th>	
																					    <th width="8%">Fecha</th>
																						<th width="10%">Comprobante</th>
																						<th width="8%">Forma Cobro</th>	
																						<th width="19%">Beneficiario</th>
																						<th width="36%">Detalle</th>
																						<th width="7%">Monto</th>
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
									
									
									<!-- Tab 2 -->
									
								 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
											   
											   <div class="panel panel-default">
                                  					<div class="panel-heading">Registro</div>
														<div class="panel-body"> 
															<button type="button" class="btn btn-sm btn-default" id="loadDoc" >  
															  Registro Documentos anulado</button>	
															
															<button type="button" class="btn btn-sm btn-default" id="loadDocBuscar" >  
															  Buscar Documentos anulado</button>	
 														</div>
                                  				</div>
											   
										   
											   <div class="panel panel-default">
                                  					<div class="panel-heading">Documentos</div>
                                   						 <div class="panel-body"> 
                                       					 <div id="ViewFormfile"> </div>
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
			<h3 class="modal-title">Selección Filtro</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroAux"> var</div>
  					  		
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
			   <div align="center" id="guardarAux"></div> 
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAuxiliar()">
		    <i class="icon-white icon-search"></i> Actualizar</button> 
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
   
 </body>
</html>
 