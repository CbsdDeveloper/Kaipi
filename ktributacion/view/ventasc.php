<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/ventasc.js"></script> 
    
</head>
<body >

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
                   			<span class="glyphicon glyphicon-th-list"></span><b> VENTAS MENSUALES</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> INFORMACION FACTURA</a>
                  		</li>
			
			 			<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-download-alt"></span> Importar Informacion Ventas</a>
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
													   
														<div style="padding-top: 10px;padding-bottom: 10px" class="col-md-10">
																
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar Informacion</button>	
															 
															</div>	
										
														   <label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
										
															<div style="padding-top: 10px" class="col-md-10">
																	<button type="button" class="btn btn-sm btn-default" id="loadr">  <i class="icon-white icon-download"></i> Reporte Facturacion</button>	
										
 														 
																	
															</div>
													   
										 				  <label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
										
														  <div style="padding-top:5px;padding-bottom: 15px" class="col-md-10">
															  <button type="button" class="btn btn-sm btn-danger" id="loaddato">  <i class="icon-white icon-ambulance"></i> Enlace Facturacion</button>	
															  
															  </div>
													       
															 
													</div>
										<div class="col-md-9">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Fecha</th>
																					    <th width="10%">Identificación</th>
																						<th width="30%">Nombre Contribuyente</th>
 																						<th width="10%">Nro.Factura</th>
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
							       <h5> <b>Formato Importar archivo XLS </b> </h5>   
	                 		   <img src="../../kimages/excel_ventas.jpg" /> 
								 <h6> <a href="../../archivos/FormatoVentas.xls">Descarga Aqui</a> </h6>
								   <h5><b>Generar archivo CSV</b></h5>   
								 <img src="../../kimages/excel_csv.jpg" /> 
					        </div>
							  
							  	 <div class="col-md-12" style="background-color:cadetblue">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="160" src="../model/Model_ventas_excel.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
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
 