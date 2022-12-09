<?php
	session_start( );
    date_default_timezone_set('America/Guayaquil');
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/comprasc_emapa.js"></script> 
    
	 <style type="text/css">
		 
  		#mdialTamanio{
  					width: 75% !important;
		}
	 
	   #mdialTamanioCheque{
  					width: 65% !important;
		}
	 
	   #mdialTamanioNota{
  					width: 55% !important;
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
                   			<span class="glyphicon glyphicon-th-list"></span><b> COMPRAS MENSUALES</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> INFORMACION FACTURA</a>
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
  										 <div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);
box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
														    <h5>Filtro búsqueda</h5>
														   
													        <div id="ViewFiltro"> </div> 
														   
															<label style="padding-top: 2px;text-align: right;" class="col-md-2"> </label>
													   
															<div style="padding-top: 2px;" class="col-md-10">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																
																<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal" onClick="tramiteDato(oTableTramite);">  
																	<i class="icon-white icon-archive"></i> Tramite</button>	
																
																  <button type="button" class="btn btn-sm btn-default" id="loadSri" title="Cargar Comprobante electronico XML">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
																
															</div>
													        <div id="ViewEnlace"> </div> 
											
											 
													     	<h6>&nbsp;  </h6>
															 
										</div>
										<div class="col-md-9" style="padding: 10px">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Fecha</th>
																					    <th width="10%">Identificación</th>
																						<th width="45%">Nombre Contribuyente</th>
 																						<th width="10%">Nro.Factura</th>
																						<th width="10%">Total</th>
																					    <th width="5%">Estado</th>
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
                     
        </div>
			 </div>	  
 		</div>
    </div>
  
	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tramites Pendientes</h4>
      </div>
      <div class="modal-body">
		  
        <table id="jsontableTramite" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Fecha</th>
																					    <th width="10%">Tramite</th>
																					    <th width="10%">Comprobante</th>
 																						<th width="30%">Contribuyente</th>
 																						<th width="15%">Total Factura</th>
																						<th width="10%">Acción</th>
																						</tr>
																					</thead>
														  </table>
		  
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 