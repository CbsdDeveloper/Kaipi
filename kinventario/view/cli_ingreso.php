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
    
 	<script type="text/javascript" src="../js/cli_ingreso.js"></script> 
    
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
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
                 
					 <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Lista de Clientes</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Cliente</a>
                  		</li>
						
						<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Historial del Auxiliar</a>
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
  												   <div class="col-md-3" style="background-color:#EFEFEF">
														    <h5>Filtro búsqueda</h5>
														    <div id="ViewFiltro"></div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
															<div style="padding-top: 5px;" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
													</div>
													 <div class="col-md-9">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					   <th width="18%">Identificación</th>
																						<th  width="40%">Cliente</th>
																						<th width="15%">Email</th>
 																						<th width="15%">Telefono</th>
																						<th width="12%">Acción</th>
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
										   
 											   
											   <div id="ViewFormAux"> </div>
										   
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
 