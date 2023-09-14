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
	
 
    
 <script type="text/javascript" src="../js/liquidaciones.js"></script> 
    
</head>
<body>

<!-- ------------------------------------------------------ -->
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
	
	
    <div class="col-md-12"> 
       <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
					  <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> LIQUIDACONES DE COMPRAS</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> INFORMACION LIQUIDACION DE BIENES Y SERVICIOS</a>
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
						  		<div class="col-md-12" style="padding: 5px">
									
  										 <div class="col-md-3" >
														    <h5>Filtro búsqueda</h5>
														   
													        <div id="ViewFiltro"> </div> 
														   
 													   
															<div style="padding-top:15px;padding-bottom: 15px" align="center" class="col-md-10">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																
																
																  <button type="button" class="btn btn-sm btn-default" id="loadSri" title="Cargar Comprobante electronico XML">  
																	<i class="icon-white icon-desktop"></i></button>	
																
																  <button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
																
															</div>
													   
											
											 
													   
															 
										</div>
										<div class="col-md-9" style="padding: 10px">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Fecha</th>
																					    <th width="10%">Identificación</th>
																						<th width="30%">Nombre/Beneficiario</th>
 																						<th width="10%">Nro.Liquidacion</th>
																						<th width="10%">Base Imponible</th>
																						<th width="10%">Monto Iva</th>
																						<th width="10%">Base Tarifa 0</th>
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
								        <div id="ver_factura"> </div>
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
 