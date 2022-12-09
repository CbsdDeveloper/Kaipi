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
    
 <script type="text/javascript" src="../js/dependencia.js"></script> 
    
	<style>
	.nombre1{
				 	font-size: 8px;
					font-weight: bold;
					text-align:center ;
					padding: 4px;
					 
				}
				.nombre11{
				 	font-size: 12px;
					text-align:right;
  					padding: 4px; 
				}
				.nombre111{
				 	font-size: 12px;
  					padding: 4px;  
				}
	</style>
</head>
<body>

<div id="mySidenav" class="sidenav">
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 </div>

<div id="main">
	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
    
    <div class="col-md-12" style="padding-top: 60px"> 
       <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
					  <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> RESUMEN DE PERSONAL</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> FICHA TECNICA</a>
                  		</li>
			
			 			<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-download-alt"></span> RESUMEN </a>
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
  									<div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);
box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
														    <h5>Filtro búsqueda</h5>
														   
													        <div id="ViewFiltro"> </div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
													   
															<div style="padding-top: 5px;padding-bottom: 20px" class="col-md-10">
															
																<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																
																<button type="button" class="btn btn-sm btn-info" id="loade">  <i class="icon-white icon-mail-forward"></i> Notificar Formulario </button>	
																
																
															</div>
													   
													         <div id="ViewSave"> </div>  
															 
													</div>
										<div class="col-md-9">
												        <h5>Transacciones por periódo</h5>
											
											
 											
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="5%">id</th>
																					    <th width="10%">Identificación</th>
																						<th width="25%">Apellido</th>
 																						<th width="25%">Nombre</th>
																						<th width="7%">Salarios</th>
																						<th width="7%">Decimos</th>
																						<th width="7%">Fondo Reserva</th>
																						<th width="7%">Iess</th>	
																						<th width="7%">Acción</th>
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
					   
				  <!-- Tab 3 -->	   
				  <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							 <div class="col-md-12">
								 <div class="col-md-3">
								 
							     <h4>Generar Relacion de dependencia</h4>
									  <div class="list-group">
										<a href="#" onClick="resumen_rdep()" class="list-group-item active">Resumen Periodo</a>
										<a href="#" onclick="genera_xml()" class="list-group-item">Generación XML</a>
 									  </div>
					       		 </div>
								 
								  <div class="col-md-3">
							    		 <h4>Enlace Talento Humano</h4>
										   <div class="list-group">
											<a href="#" onClick="proceso_rdep()" class="list-group-item active">Generar Enlace TTHH Informacion</a>
 										  </div>
									     <div id="view_proceso"></div>
								 </div>
								 
								 <div class="col-md-3">
							    		 <h4>Formato Talento Humano</h2>
										   <div class="list-group">
											 
											<a href="#" class="list-group-item">Descargar Formato RDEP</a>   
											<a href="#" class="list-group-item">Importar Informacion RDEP</a>
										  </div>
 								 </div>
					        </div>
							  
							  	 <div class="col-md-12" style="padding:20px">
							   		 <div id="view_resumen"></div>
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
 </body>
</html>
 