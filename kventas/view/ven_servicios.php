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
   	
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

  	
	<script type="text/javascript" src="../js/inv_ventas.js"></script> 
    
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
    
       <div class="col-md-12" style="padding-top: 35px"> 
       <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   		 <span class="glyphicon glyphicon-th-list"></span> <b>MOVIMIENTO DE VENTAS</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Reportes</a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Gráficos</a>
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
 						   
  												   <div class="col-md-12" style="background-color:#EFEFEF">
													 
														    <div id="ViewFiltro"></div> 
													   
													    <label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
													
														<div style="padding-top: 5px;" class="col-md-10">
																		<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
														</div>
 													   
 															
													</div>
							 					   
 							  
													 <div class="col-md-12">
  													   <table id="jsontable" class="display table table-striped table-bordered" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																						<th width="5%">Transaccion</th>
																						<th width="5%">Asiento</th>	
																						<th width="10%">Fecha</th>
 																						<th width="10%">Comprobante</th>
																						<th width="15%">Detalle</th>
																						<th width="15%">Identificacion</th>
																						<th width="20%">Razon Social</th>	
 																						<th width="5%" bgcolor=#C0AFCC>Monto IVA</th>
																						<th width="5%" bgcolor=#FD999B>Base Imponible</th>
																						<th width="5%" bgcolor="#E0F79A">Tarifa 0%</th>
 																						<th width="5%" bgcolor=" #FC1E21">Total</th> 
																						</tr>
																					</thead>
														  </table>
													</div>  
  								 
                        </div>  
                     </div> 
                </div>
                 <!-- Tab 2 -->
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							<div class="btn-group btn-group-sm">
								<button type="button"  onClick="goToURL(1)" class="btn btn-primary">Resumen Mensual</button>
								<button type="button"  onClick="goToURL(2)" class="btn btn-primary">Resumen Cliente</button>
								<button type="button" onClick="goToURL(3)"  class="btn btn-primary">Resumen Anual</button>
								<button type="button" onClick="goToURL(4)"  class="btn btn-primary">Facturacion</button>
								<button type="button" onClick="goToURL(5)"  class="btn btn-info">Contabilizar</button>
								<button  id="printButton" type="button" class="btn btn-default">Impresión</button>
								
								<button  id="ExcelButton" type="button" class="btn btn-default">Excel</button>
								
							  </div>
							  <h4>&nbsp;  </h4>
							  	 <div style="overflow-y:scroll; overflow-x:hidden; height:400px; padding: 5px"> 
 							     
									  <div id="ViewForm"> </div>
								  
								  </div>
                		  </div>
                	  </div>
             </div>
 			 <script src="http://code.highcharts.com/highcharts.js"></script>
			 <script src="http://code.highcharts.com/modules/exporting.js"></script>
		     <script type="text/javascript" src="../js/grafico_ventas.js"></script> 
					   
					   <!-- Tab 3 -->
             <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							   <div class="col-md-12">
 								 		<button type="button" class="btn btn-sm btn-primary" id="loadGrafico" >  
											<i class="icon-white icon-search"></i> Generar Informacion</button>	
								  <h4>&nbsp;  </h4>
 								</div>
							  
							  
 						     <div class="col-md-6">     
								 <div class="panel panel-success">
									  <div class="panel-heading">Resumen por Cajeros</div>
									  <div class="panel-body">
									    <div id="div_grafico_caja"  style="height: 250px"> </div>
									  </div>
   								 </div>
                 		     </div>
 						     <div class="col-md-6">     
								 <div class="panel panel-success">
									  <div class="panel-heading">Movimiento de productos</div>
									  <div class="panel-body">
									    <div id="div_grafico_productos"  style="height: 250px"> </div>
									  </div>
   								 </div>
                 		     </div>							  
						     <div class="col-md-6">     
									 <div class="panel panel-success">
									  <div class="panel-heading">Movimiento Mensual</div>
									  <div class="panel-body">
									    <div id="div_grafico_mensual"  style="height: 250px"> </div>
									  </div>
   								 </div>
                 		     </div>
							  
 						    <div class="col-md-6">     
									 <div class="panel panel-success">
									  <div class="panel-heading">Top Clientes</div>
									  <div class="panel-body">
									    <div id="div_grafico_cliente"  style="height: 250px"> </div>
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
 </body>

</html>
 