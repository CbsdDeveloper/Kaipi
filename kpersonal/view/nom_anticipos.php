<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
 	<script type="text/javascript" src="../js/nom_anticipos.js"></script> 
 	
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
		
	    <div class="row">
			
 		 	     <div class="col-md-12">
							  
								<ul id="mytabs" class="nav nav-tabs">   
									
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b> Resumen De Gestión de Anticipos</b></a>
										</li>
 									 
										<li><a href="#tab2" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b> Detalle De Gestión de Anticipos</b></a>
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

													    <div class="col-md-12">
														   
														   	  <div class="col-md-2">
																  
																 <select id="anio" name = "anio" class="form-control">
																	   <option value="2024">2024</option>
																	   <option value="2023">2023</option>
																	   <option value="2022">2022</option>
																	   <option value="2021">2021</option>
																	   <option value="2020">2020</option>
																	   <option value="2019">2019</option>
																	   <option value="2018">2018</option>
																 </select> 
															  </div>  
													
														         
															 			   
														      <div class="col-md-2" style="padding: 1px"> 

																 <button type="button" class="btn btn-primary btn-sm btn-block" id="load311">  
																			<i class="icon-white icon-search"></i> Busqueda</button>	

															</div>
 														     
														      <div class="col-md-2" style="padding: 1px"> 
																  <button type="button" class="btn btn-default btn-sm btn-block" id="loadxls31" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i> Descargar
															  </button>	

															  </div>
															
															  <div class="col-md-2" style="padding: 1px" > 
																  <button type="button" class="btn btn-sm btn-default"  id="loadp11"  >
																   <span class="glyphicon glyphicon-print"></span> Reporte</button>
																</div>  
 														   
													   </div>  
													
													   	<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">
																
																	 <div id="ViewBalancePrint1"> 
 
															     		 <div id="ViewFormAuxc1"> </div>
																		 
																		 
																	 </div>  	 

														   </div>  

 				 
													</div>

											   </div>  
											 </div> 
											  
										  </div>
									
											<div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
												
												<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">
												
														 <div class="col-md-2" style="padding: 1px" > 
																  <button type="button" class="btn btn-sm btn-default"  id="loadp41"  >
																   <span class="glyphicon glyphicon-print"></span> Reporte</button>
														 </div>  
												 </div>  
												
												<div class="col-md-12">
													  <div class="panel panel-default">

															<div class="panel-body" > 
																
																  <div class="col-md-9" id="reporte_detalle">
																   
																	  	<div id="ViewForm"> </div>

																   		<div id="ViewFormDetalle"> </div>
																	  
																  </div>
														   </div>
													  </div>
												 </div>	
											</div>
   
							    </div>
			    </div>	  
 		</div>

      <!-- /.auxiliar -->

	  <input type="hidden" id="prove" name="prove">

     
  <div class="container"> 
	  
	  <div class="modal fade" id="myModalCxp" tabindex="-1" role="dialog">
						  <div class="modal-dialog" id="mdialTamanio">
									<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h3  class="modal-title">Detalle </h3>
											  </div>
											  <div class="modal-body">

												<div class="form-group" style="padding-bottom: 2px">
															 <div class="panel panel-default">

																		 <div class="panel-body">
																			 <div id="ViewFiltroAux" style="height: 420px"> var</div> 
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
	
  
	
  	<!-- Page Footer-->

    <div id="FormPie"></div>  
   
 </body>
</html>
 