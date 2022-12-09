<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>KGestiona - Inventarios</title>
	
    <!--  INICIALIZACION DE PLANTILLA BOOTSTRAP ---------------------------------->
	
    <?php  require('Head.php')  ?> 
	
	
	<!--  FUNCIONES DEL FORMULARIO JAVASCRIPT ---------------------------------->
 
 	<script type="text/javascript" src="../js/inv_movimiento.js"></script> 
 
	
	
</head>
	
<body>

	
	<!--  CABECERA INICIO DE OPCIONES DE LA PLATAFORMA  ---------------------------------->
	
	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
 	
	
	<!--  MENU LATERAL DE OPCIONES DE LA PLATAFORMA  ---------------------------------->
	
	<div id="mySidenav" class="sidenav" >
		
		<div class="panel panel-primary">
			
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
			
				<div class="panel-body">
					
					<div id="ViewModulo"></div>
					
				</div>
			
		</div>
		
   </div>
	
	
    <!-- CONTENIDO DEL FORMULARIO PRINCIPAL -->
       
    <div class="col-md-12"> 
      
       		 <!-- TAB DE INFORMACION  -->
		
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
			   
			   		<!-- FORMULARIO DE BUSQUEDAS PRINCIPAL -->
			   
                 		<li class="active">
							<a href="#tab1" data-toggle="tab"> 
								<span class="glyphicon glyphicon-th-list"></span> <b>MOVIMIENTO DE INVENTARIOS</b>  
			   				</a>
						</li>
	 
			   		 <!-- FORMULARIO DE INFORMACION DE DATOS -->
			   
                  		<li>
							<a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Orden de Ingreso
							</a>
                  		</li>
			   
			   		<!-- FORMULARIO COMPLEMENTARIO   -->
	 
			  			 <li>
							<a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-arrow-right"></span> Ruta del Tramite
							</a>
                  		</li>
			   
	 				
	 
           </ul>
                    
           <!---------------------------------------------------------->
           <!-- CONTENIDO  DEL FORMULARIO -->
      	   <!---------------------------------------------------------->
		
           <div class="tab-content">
			   
          					<!-- FORMULARIO DE BUSQUEDAS PRINCIPAL -->
           
							 <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

							  <div class="panel panel-default">

								  <div class="panel-body" > 

									<div class="col-md-12" > 

													 <div class="alert alert-info">

														 <div class="row">
															 
															 		<!-- FILTRO DE INFORMACION FORMULARIO DE BUSQUEDAS PRINCIPAL -->

																	<div id = "ViewFiltro" > </div>

																	<div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 

																	<div class="col-md-4" style="padding-top: 5px;">

																		<button type="button" class="btn btn-sm btn-primary" id="load">
																			<i class="icon-white icon-search"></i> Buscar</button>

																		<button type="button" class="btn btn-sm btn-default" id="loadSaldo" title="Saldos de bodega">  
																			<i class="icon-white icon-ambulance"></i></button>

																	</div>

														</div>

													</div>

									 </div> 

									   <div class="col-md-12"> 

										      <!-- GRILLA DE INFORMACION FORMULARIO DE BUSQUEDAS PRINCIPAL -->
										   
												<table id="jsontable" class="display table-condensed"   width="100%">
												 <thead>
												   <tr>   
																<th width="10%">Movimiento</th>
																<th width="10%">Fecha</th>
																<th width="20%">Detalle</th>
																<th width="10%">Comprobante</th>
																<th width="10%">Documento</th>
																<th width="10%">Identificacion</th>
																<th width="20%">Responsable</th>
																<th width="10%">Accion</th>
												   </tr>
												</thead>
											 </table>

									 </div>  
									  
									 <div id="SaldoBodega"></div>

								  </div>  

							 </div> 

							</div>
             		
            				<!-- FORMULARIO DE INFORMACION DE DATOS -->
             
							 <div class="tab-pane fade in" id="tab2">
								 
								<div class="panel panel-default" style="padding: 1px">
									
										<div class="panel-body" style="padding: 1px"> 
											
											 <!-- FORMULARIO DE INFORMACION DE INGRESO -->

											 <div id="ViewForm"> </div>

											 <div class="col-md-12">
												
												<div class="alert al1ert-info fade in">
													
													  <!-- DETALLE DE LA INFORMACION MAESTRO/DETALLE  -->
													
														<div id="DivMovimiento"></div>
													
												</div>
												
												<div id="DivProducto"></div>
												
											 </div>

									   </div>
								  </div>

							 </div>
			   
			 			     <!-- FORMULARIO COMPLEMENTARIO   -->
             
							 <div class="tab-pane fade in" id="tab3">
								 
								<div class="panel panel-default" style="padding: 1px">
									
										<div class="panel-body" style="padding: 1px"> 

											 <div class="col-md-12" style="padding: 10px" > 
													<h4>Ruta Tramite Administrativo -  Financiero</h4>

												 <button type="button" class="btn btn-sm btn-primary" id="loadt"><i class="icon-white icon-search"></i> Buscar</button>
											 </div>		 

											<div class="col-md-12" style="padding: 10px" > 

													<div id="ViewFormRuta"> </div>

											  </div>	 


									   </div>
									
								  </div>

							 </div>
			 	   
          	 	</div>
		   
 		</div>
	
	
	
 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
 
  
  <div class="modal fade" id="myModal" role="dialog">
	  
      <div class="modal-dialog" id="mdialTamanio">
    
      <!-- MODAL CONTENIDO -->
		  
      <div class="modal-content">
		  
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Articulo</h4>
        </div>
		  
        <div class="modal-body">
       		  <div id='VisorArticulo'></div>
        </div>
		  
        <div class="modal-footer">
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
        </div>
		  
      </div>
      
    </div>
  </div>
	

 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
	
  <div class="modal fade" id="myModalActualiza" role="dialog">
	  
      <div class="modal-dialog" id="mdialTamanio2">
    
   	  <!-- MODAL CONTENIDO -->
		  
      <div class="modal-content">
		  
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Articulo</h4>
        </div>
		  
        <div class="modal-body">
			
				 <div id='VisorArticuloActualiza'></div>

				 <p id="GuardaDatoA">&nbsp;   </p>	
			
        </div>
		  
        <div class="modal-footer">
			<button type="button" onClick="ActualizaCuenta();" class="btn btn-warning" >Actualizar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		  
      </div>
      
    </div>
  </div>


	
 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	
	
  <div class="modal fade" id="myModalSerie" role="dialog">
	  
		  <div class="modal-dialog" id="mdialTamanio1">
			  
			<!-- Modal content-->
			 <div class="modal-content">
				 
					 <div class="modal-header">
					  <button type="button" class="close"  data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Articulo</h4>
					 </div>
				 
					 <div class="modal-body">
						 
						 <div class='row'>
							 
								 <div class="alert alert-info">
									 <div class="row">
										<div class="col-md-2" style="padding-top: 5px;">Cargar Series de articulos</div> 
										<div class="col-md-4" style="padding-top: 5px;">

											<input type="hidden" id="idproducto_serie" name="idproducto_serie">
										 <input type="text" class="form-control" name="serie" id="serie" value="0" readonly>
										 </div>  

									 </div>
								 </div>
							 
								<div class="col-md-12" style="padding-top: 5px;">
									  <div id='global' >
												<div id='VisorSerie'></div>
												<div id='GuardaSerie'></div>
									  </div>
								 </div>	
						  </div>	 
					</div>
				 
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				 
		  </div>
			  
		</div>
  </div>

	
 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->	

  <div class="modal fade" id="myModalTramite" role="dialog">
	  
		  <div class="modal-dialog" id="mdialTamanio1">
			  
			<!-- Modal content-->
			  
			 <div class="modal-content">
				 
				 <div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Tramites Disponibles</h4>
				 </div>
				 
				 <div class="modal-body">

					 <div class='row'>

							<div class="col-md-12" style="padding-top: 5px;">
 											<div id='VisorTramite'></div>
  							 </div>	
					  </div>	 
				</div>

				<div class="modal-footer">
					
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
				</div>
				 
		  </div>
		</div>
  </div>

	
 <!---------------  FORMULARIO MODAL DE DATOS  ----------------->		

<div class="modal fade" id="myModalEnlace" role="dialog">
	
		  <div class="modal-dialog" id="mdialTamanio1">
			  
			<!-- Modal content-->
			  
			 <div class="modal-content">
				 
					 <div class="modal-header">
					  <button type="button" class="close"  data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Tramites Disponibles</h4>
					 </div>
				 
					 <div class="modal-body">
						 <div class='row'>
 								<div class="col-md-12" style="padding-top: 5px;">
 												<div id='VisorEnlaceValida'></div>
 								 </div>	
						  </div>	 
					</div>
				 
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
		  </div>
		</div>
  </div> 
	
   <div id="FormPie"></div>  
 
 </body>
	
</html>
