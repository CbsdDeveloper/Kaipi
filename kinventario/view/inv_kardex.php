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

 
	<script type="text/javascript" src="../js/inv_kardex.js"></script> 
    
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
 			
 					 
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
					 
                    <ul id="mytabs" class="nav nav-tabs">    
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   		 <span class="glyphicon glyphicon-th-list"></span> <b>KARDEX POR BODEGA</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle de Movimientos</a>
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


															  <div class="col-md-12" style="background-color:#ededed; ">
																		<h5>Filtro búsqueda</h5>
																		<div id="ViewFiltro"></div> 

																		<label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
																  
																		<div style="padding-top: 5px;padding-bottom: 10px" class="col-md-6">
																			
																				<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																			
																			<button type="button" class="btn btn-sm btn-warning" id="loadp">  <i class="icon-white icon-print"></i> Reporte</button>	
																			
																		</div>
																  
																		<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
																</div>
																 <div class="col-md-12" style="padding-top: 10px">
																	<h5>Transacciones por periódo</h5>
																   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">

																								<thead>
																									<tr>
																									<th width="5%">Codigo</th>
																									<th width="30%">Producto</th>
																									<th width="5%">Cuenta</th>
																									<th width="5%" bgcolor=#C0AFCC>Ingreso</th>
																									<th width="5%" bgcolor=#FD999B> Egreso</th>
																									<th width="5%" bgcolor="#E0F79A">Saldo</th>
																									<th width="5%">Promedio</th>
																									<th width="15%">U.Transaccion</th>
																									<th width="20%">Constatacion</th>	
																									<th width="5%">Acción</th>
																									</tr>
																								</thead>
																	  </table>
																</div>  
									 </div>  

								 </div> 
								  
               				 </div>
					   
                 <!-- Tab 2 -->
					   
               				  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
					 
					  <div class="col-md-12" style="padding: 15px"> 
					 
					 	<button  id="printButton" type="button" class="btn btn-default">Impresión</button>

					   <button  id="ExcelButton" type="button" class="btn btn-default">Excel</button>
						 
					 </div>
					 
					   <div class="col-md-12" id="Impresion"> 
							  <div class="col-md-12"> 
									  <div class="panel panel-default">
										  <div class="panel-body" > 
												 <div id="ViewForm"> </div>

										  </div>
									  </div>
							 </div>	  
					 
					 
							 <div class="col-md-12"> 
								 <script src="https://code.highcharts.com/highcharts.js"></script>
								 <script src="https://code.highcharts.com/modules/exporting.js"></script>
										   <div class="panel panel-success">
																  <div class="panel-heading">Gestión Periodo Articulo</div>
																  <div class="panel-body">
																	   <div id="div_grafico"  style="height: 250px"> </div>
																  </div>
											</div>
							 </div>	
					 
 						     <div class="col-md-12"> 
									  <div class="panel panel-default">
										  <div class="panel-body" > 
												 <div id="ViewFormReporte"> </div>

										  </div>
									  </div>
							 </div>	  
						   
						    <div class="col-md-12"> 
										   <div class="panel panel-success">
																  <div class="panel-heading">Gestión Periodo Categoria </div>
																  <div class="panel-body">
																	   <div id="div_grafico1"  style="height: 250px"> </div>
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
 