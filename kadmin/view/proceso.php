<!DOCTYPE html>
<html lang="en">
	
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial-Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/proceso.js"></script> 
    
</head>
	
<body>
	
	<!-- MENU SUPERIOR INFORMACION DE SISTEMA Y USUARIO   -->	
 	
	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
 	
	<!-- MENU LATERAL DE OPCIONES  -->	
	
	<div id="mySidenav" class="sidenav">
		
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
		
   </div>
	
 
	
 
	
    <div class="col-md-12"> 
		
       <!-- Content Here -->
	    
		<div class="row">
			
 		 	     <div class="col-md-12">
  					   	 
                    <ul id="mytabs" class="nav nav-tabs">      
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Información</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Formulario de Informacion </a>
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

															    <div class="col-md-12">
																	
																	   <div class="col-md-3">  
																	
																			<select id="moduloc" name="moduloc" class="form-control">
																				  <option value="-">-- Seleccionar Modulo -- </option>
																				  <option value="requerimiento">PROCESO DE CONTRATACIÓN</option>
																				  <option value="tareas">SEGUIMIENTO DE ACTIVIDADES SIN RECURSOS</option>
																				  <option value="viaticos">GESTIÓN DE CONTROL DE VIÁTICOS</option>	
																				  <option value="nomina">GESTIÓN DE PAGOS DE NÓMINA E INGRESOS COMPLEMENTARIOS</option>	
																				  <option value="caja">GESTIÓN DE OTROS GASTOS PLANIFICADOS (sin contratación)</option>	
																			</select>
																		</div>     
																	
																	  
																	
																	<div class="col-md-2"  style="padding-top: 5px;"> 
																				<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
									   								</div> 	  
																		  
																	
																</div>  
																	

																 <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">

																	<h5>Transacciones por periódo</h5>

																	 
																	  <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																		<thead> 
																		   <tr> 
																				<th width="10%">Codigo</th>
																				<th width="10%">Secuencia</th>
																				<th width="25%">Unidad Gestora</th>
																				<th width="25%">Proceso</th>
																				<th width="10%">Estado</th>
																			    <th width="10%">% Acumulado</th>
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
									  <div class="panel-body" > 
										   <div id="ViewForm"> </div>
									  </div>
								  </div>
							  </div>
				  
                     
       						 </div>
					 
			   </div>	
	
 		</div>
	
    </div>
   
  	<!-- Page Footer-->

    <div id="FormPie"></div>  
  
 </body>
</html>
 