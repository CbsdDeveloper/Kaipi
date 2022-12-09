<!DOCTYPE html>

<html lang="en">
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
    
 	<script type="text/javascript" src="../js/comprasc.js"></script> 
	 
	<script type="text/javascript" src="../js/facturac.js"></script> 
	
    
</head>
	
<body>

<!--  pantalla principal  --------------->
	
<div id="main">
	
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
	
	
    <div class="col-md-12"  > 
		
       
		<!-- Content Here -->
	    
		<div class="row">
	
			
 		 	     <div class="col-md-12">
					 
					 
					 
					  <ul id="mytabs" class="nav nav-tabs">            
						  
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
							
                   			<span class="glyphicon glyphicon-th-list"></span><b> LISTA COMPRAS MENSUALES</b></a>
					 
                   		</li>
			
                  		<li><a href="#tab2" data-toggle="tab">
							
                  			<span class="glyphicon glyphicon-link"></span> REGISTRO DE INFORMACION FACTURA</a>
							
                  		</li>
			
			
					    <li><a href="#tab3" data-toggle="tab">
							
                  			<span class="glyphicon glyphicon-download-alt"></span> ( * ) Importar Informacion Compras</a>
							
                  		</li>
			
			
                    </ul>
		
                      <!-- Tab panes -->
		
 		
                      <div class="tab-content">
					   
						   <!-- Tab 1 -->
						
					       <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
						   
									  <div class="panel panel-default">
								  
								  <div class="panel-body" > 
									  
										<div class="col-md-12" style="padding: 5px">
											
												  <div class="col-md-12" style="background-color:#ededed;">
 
													 	 	<div class="col-md-8" style="padding-bottom: 10px; padding-top: 5px">
																
																	<div id="ViewFiltro"> </div> 
																
 															</div>
													 
															<div style="padding-bottom: 10px; padding-top: 15px" class="col-md-4">
																
																			<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
 
																		    <button type="button" class="btn btn-sm btn-default" id="loadSri" title="Cargar Comprobante electronico XML">  
																			  <i class="icon-white icon-desktop"></i></button>	

																		    <button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i></button>	
																
																
																 		 <button type="button" class="btn btn-sm btn-default" id="loadpp" title="Resumen proveedores">  
																			<i class="icon-white icon-print"></i></button>	
																
 
															</div>
  
												 </div>
											
												  <div class="col-md-12" style="padding: 10px">
													 
															   <h5>Transacciones por periódo</h5>
													 
															   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																							<thead>
																								<tr>
																								<th width="10%">Fecha</th>
																								<th width="10%">Identificación</th>
																								<th width="20%">Nombre Contribuyente</th>
																								<th width="5%">Nro.Factura</th>
																								<th width="5%">Nro.Retencion</th>
																								<th width="10%">Base Imponible</th>
																								<th width="10%">Monto Iva</th>
																								<th width="10%">Base Tarifa 0</th>
																								<th width="5%">Nro.Tramite</th>
																								<th width="5%"></th>
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
										
									</div>
									 
								</div> 	 
						   
						   </div>
					   
						   <!-- Tab 3 -->

						   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px" >
							   
							  <div class="panel panel-default">
								  
								  <div class="panel-body" > 

										 <div class="col-md-12" style="padding: 15p">
										 
										   <h5> <b>Formato Importar archivo XLS </b> </h5>   
										 
									       <img src="../../kimages/excel_compras.jpg" />
										 
										   <h6> <a href="../../archivos/FormatoCompras.xls">Descarga Aqui</a> </h6>
										 
										   <h5><b>Generar archivo CSV</b></h5>   
										 
										   <img src="../../kimages/excel_csv.jpg" /> 
									</div>

										 <div class="col-md-12" style="background-color:cadetblue">
											 
											<iframe width="100%" id="archivocsv" name = "archivocsv" height="160" src="../model/Model_compras_excel.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
											</iframe>
	
											 
									   </div>


								  </div>
								  
							  </div>
							   
						   </div>		   

        			</div>
		 
			     </div>	  
	
 		</div>
	
	
    </div>
	
  
   	<!-- Page Footer-->  
	
    <div id="FormPie"></div>  
	
	
	
 </div>   



<!--  pantalla modal  --------------->



<!-- Modal -->

  <div class="modal fade" id="myModal" role="dialog">
	  
   <div class="modal-dialog" id="mdialTamanio">  
	   
      <!-- Modal content-->
	   
      <div class="modal-content">
		  
       			 <div class="modal-header">
			
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
			
          <h4 class="modal-title">Compromisos-Devengados</h4>
			
        </div>
		  
   			     <div class="modal-body">
			
       	   <p id="presupuesto_tramite"> </p>
			
        </div>
		  
     		     <div class="modal-footer">
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
        </div>
		  
      </div>
      
    </div>
	  
  </div>


<!-- Modal -->

  <div class="modal fade" id="myModalCIU" role="dialog">
	  
   <div class="modal-dialog">  
	   
      <!-- Modal content-->
	   
      <div class="modal-content">
		  
        <div class="modal-header">
			
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
			
          <h4 class="modal-title">Actualiza Identificacion de proveedor</h4>
			
        </div>
		  
        <div class="modal-body">
          
			<p> 
				
				<div class="form-group">
					
				  <label for="usr">Identificación</label>
				  <input type="text" class="form-control" id="usr" name="usr" readonly>
					
				</div>
			
			</p>
			
        </div>
		  
        <div class="modal-footer">
		  
		  <button type="button" class="btn btn-danger" onClick="ActualizaProveedor()" data-dismiss="modal">Actualiza Identificacion</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
        </div>
      </div>
      
    </div>
	  
  </div>



 

 </body>
</html>
 