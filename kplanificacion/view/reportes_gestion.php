<?php
	session_start( );

    if (empty($_SESSION['usuario']))  {
	
	    header('Location: ../../kadmin/view/login');
 	
	}

     require '../../kpresupuesto/model/resumen_panel.php';    

     $gestion   = 	new proceso;
 
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
 <script type="text/javascript" src="../js/reportes_gestion.js"></script> 
    
 <style type="text/css">
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
		
	 
	 .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
	 .di {
  			 background-color:#F5C0C1;
	  }
 	     	     	    		

 
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 3px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
     </style>
	
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
	   
       <!-- Content Here -->
	   
	    <div class="row">
			   
  		 
								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
			
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>GESTION PRESUPUESTARIA</b></a>
										</li>
										 
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span>RESUMEN EJECUTIVO</a>
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

																<div class="col-md-9" style="padding: 5px">
																			<div id="ViewFiltro"></div> 
 																</div>	
 
															<div class="col-md-3" style="padding: 7px">
																 

																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	

																   <button type="button" class="btn btn-sm btn-info" id="loadCer">  
																	<i class="icon-white icon-search"></i> Detalle Certificacion</button>	
																

																	<button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																	<i class="icon-white icon-download-alt"></i></button>	

																   <button type="button" class="btn btn-sm btn-default" id="loadprint" title="Imprimir Presupuesto de ingreso">  
																	<i class="icon-white icon-print"></i></button>	

															</div>	
													 

															<div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 

																	<div style="height: 500px; overflow-y: scroll;width: 100%">

																		
															<div id="ViewFormIngresos"> </div>
																	      
																	 

																   </div>   

															   </div>

													</div>
												  
								    		  </div>  

											 </div> 
 									
									    
										   <!-- Tab 2 -->

										   <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">

											  <div class="panel panel-default">

												   <div class="panel-body" > 

														 
														     <div class="col-md-12" style="padding: 10px">
   
 																   <button type="button" class="btn btn-sm btn-default" id="loadprintg" title="Imprimir Presupuesto de Gasto">  
																	<i class="icon-white icon-print"></i></button>	

															  </div>	
 														

														     <div class="col-md-12" style="padding: 1px">
 

														 <div class="col-md-12" id="ViewFormGastos" style="padding-bottom:8;padding-top:8px"> 
  
															     <div class="col-md-12">
																 	<div class="col-md-4"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Resumen de Certificaciones emitidas</div>
																						  <div class="panel-body">
																									   <?php    $gestion->tramites_certificaciones(); ?> 
																						  </div>	
																			 </div> 
																		</div>	
																	 
																	 <div class="col-md-4"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Certificaciones por mes</div>
																						  <div class="panel-body">
																							    <div   style="width:100%; height:180px;">
																									   <?php    $gestion->tramites_certificaciones_mes(); ?> 
																								 </div>	
																						  </div>	
																			 </div> 
																		</div>	
																	 
																	 <div class="col-md-4" > 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Tramites de gestion presupuestaria</div>
																						  <div class="panel-body">
																									   <?php    $gestion->tramites_gastos(); ?> 
																						  </div>	
																			 </div> 
																		</div>	
																	  
															     </div>	
																  
																  
															 	  <div class="col-md-12">
																  
																	   
																		
																	   <div class="col-md-6"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Tramites de Gestion por Programas</div>
																						  <div class="panel-body">
																							   <div   style="width:100%; height:250px;">
																									   <?php    $gestion->tramites_programa(); ?> 
																								 </div>   
																						  </div>	
																			 </div> 
																		</div>	

															 		  <div class="col-md-6"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Tramites de Gestion por Unidades</div>
																						  <div class="panel-body">
																							  <div  style="width:100%; height:250px;">
																										 <?php    $gestion->tramites_unidades(); ?> 
																											  
																											  </div>   
																							  
																									  
																						  </div>	
																			 </div> 
																		</div>	
															 </div>	
															 
																			 <div class="col-md-12">

																						<div class="col-md-6"> 
																							 <div class="panel panel-info">
																										  <div class="panel-heading">Tramites por Grupo Presupuestario</div>
																										  <div class="panel-body">
																											   <div id="div_gasto" style="width:100%; height:250px;">
																											 		 <?php    $gestion->tramites_grupo(); ?> 
																											  
																											  </div>    
																													   
																										  </div>	
																							 </div> 
																						</div>	

																						<div class="col-md-6"> 
																							 <div class="panel panel-info">
																										  <div class="panel-heading">Detalle de tramites</div>
																										  <div class="panel-body">
																													 <?php    $gestion->filtros_busqueda(); ?> 
																										  </div>	
																							 </div> 
																							<button type="button" class="btn btn-sm btn-primary" id="loadDetalle">  
																							<i class="icon-white icon-search"></i> Buscar</button>	
																							<button type="button" class="btn btn-sm btn-success" id="loadDetalleHis">  
																							<i class="icon-white icon-search"></i> Enlace Contable</button>	
																						</div>	

																			 </div>	
															 
															 				 <div class="col-md-12">
																						 <div class="panel panel-default">
																										  <div class="panel-heading">Detalle de tramites</div>
																										  <div class="panel-body">
																												  <div id="DetalleVistaInformacion">	 </div>	
																										  </div>	
																							 </div> 
																	 </div>
															 
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
 

<div class="container"> 
              <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
				  
                <div class="modal-dialog" id="mdialProducto">
					
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Verificacion de datos</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
											  <div class="panel-body">
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Id.Tramite</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="text" name="tramite" id="tramite" readonly autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Solicitud</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fecha" id="fecha" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												 
												  <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Certificacion</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fechac" id="fechac" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												   <label style="padding-top: 12px;text-align: right;" class="col-md-3">Fecha Compromiso</label>
													<div  style="padding-top: 5px;" class="col-md-9">
														<input type="date" name="fechacc" id="fechacc" required="required" autocomplete="offS" class="form-control" placeholder="requerido" size="80" maxlength="80" value="">
												    </div>
												  
												    <label style="padding-top: 12px;text-align: right;" class="col-md-3">Estado</label>
												  	<div  style="padding-top: 5px;" class="col-md-9">
												  	<select name="festado"  id="festado" class="form-control">
														<option value="1">1. Requerimiento Solicitado</option>
														<option value="2">2. Tramite Autorizado</option>
														<option value="3">3. (*) Emitir Certificacion</option>
														<option value="5">5. Compromiso Presupuestario</option>
														<option value="6">6. Tramites Devengado</option>
														<option value="0">Anulada transaccion</option>
														</select>
												  </div>
											 </div>
  											<div align="center"  style="font-size: 13px"id="guardarProducto" ></div> 
							   </div> 
                          <div class="modal-footer">
							  
							
							  
							  <button type="button" class="btn btn-sm btn-info" onClick="ActualizaInformacion()">Actualizar</button>
                              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
                          </div>
                </div>
					<!-- /.modal-content --> 
                </div>
				  <!-- /.modal-dialog -->
              </div>
			
			  <!-- /.modal -->
        </div>  	
 </body>
</html>
 