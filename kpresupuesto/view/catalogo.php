<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
	<style type="text/css">
  		#mdialTamanio{
  					width: 90% !important;
		}
	    #mdialTamanio1{
  					width: 90% !important;
		}
  </style>

 
	
		<script language="javascript" src="../js/catalogo.js?n=1"></script>
    
</head>
<body>

  <!--    menu superior    ---------- -->  
	
	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
	
	
   <!--    menu lateral    ---------- -->  
 	
	<div id="mySidenav" class="sidenav">
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
   </div>

	
    <!-- Pantalla principal  -->
    
	<div class="col-md-12"> 
		
 								<!--    Nav tabs   controles de formularios  -->   
		
								<ul id="mytabs" class="nav nav-tabs">      
									
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b> CATALOGO PRESUPUESTARIO </b>  </a>
										</li>
	
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> FORMULARIO DE INGRESO DE DATOS</a>
										</li>
	
								</ul>
	
	 
								<!-- Tab panel contenedor  -->
							 
								<div class="tab-content">
									
								    <!-- Tab 1 -->
								    
									<div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
										
									  <div class="panel panel-default">
										  
										  <div class="panel-body" > 
											  
 										   		<div class="col-md-12" style="padding: 1px">
											   
											        <!-- FILTRO DE  INFORMACION   -->
 										   
  													<div class="col-md-3" style="background-color:#ededed;padding-bottom: 10px">
													    
														    <h5>Filtro búsqueda</h5>
														
														    <!-- CARGA OBJETOS PARA FILTRO DE INFORMACION   -->
														
														    <div id="ViewFiltro"></div> 
														   
 														    <!-- BOTON DE BUSQUEDA DE FILTRO   -->
														
															<div style="padding-top: 5px;" align="center" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															 
												    </div>
											   
											   
												     <!-- GRILLA DE  INFORMACION   -->
											   
											        <div class="col-md-9">
														
												        <h5>Transacciones por periódo</h5>
														
													      <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="10%">Id</th>
																						<th width="10%">Codigo</th>
																						<th width="50%">Detalle</th>	
																						<th width="10%">Nivel</th>
																						<th width="10%">Transaccion</th>
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
											   
											   <!-- FILTRO DE  INFORMACION   -->
										   
											   <div id="ViewForm"> </div>
										   
										   </div>
									  </div>
										
								 </div>
								 
								</div>
	</div>	  

 	 
     <!-- PANTALLA MODAL /.  -->  

  <div class="container"> 
	  <div class="modal fade" id="myModalIngreso" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio1">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Selección Ingresos</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		<table id="jsontable_ingreso" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th width="20%">Partida</th>
														<th width="30%">Detalle</th>
														<th width="10%">Actividad</th>	
														<th width="10%">Item</th>
														<th width="10%">Fuente</th>
														<th width="10%">Disponible</th>
														<th width="10%">Acción</th>
													</tr>
												</thead>
									</table>
 					  		 <div align="center" id="guardarAux"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
		    
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  

	 
		 
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
   
 </body>
</html>
 