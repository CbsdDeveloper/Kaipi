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
    
 <script type="text/javascript" src="../js/prov_proveedor.js"></script> 
    
</head>
<body>

	<div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
 	
	<div id="mySidenav" class="sidenav" >
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
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Lista de Proveedores</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Proveedor</a>
                  		</li>
			
						<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> Historial del Auxiliar</a>
						 </li>
					 
					   <li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-download-alt"></span> Importar Informacion</a>
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
														    <div id="ViewFiltro"></div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
															<div style="padding-top: 5px;" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
													</div>
													 <div class="col-md-9">
												        <h5>Proveedores</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					   <th width="18%">Identificación</th>
																						<th  width="40%">Proveedor</th>
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
					   
				 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							 <div class="col-md-12">
							       <h5> <b>Formato Importar archivo XLS (Modulo P=Proveedor, C=Cliente)</b></h5>   
				                 		 <img src="../../kimages/excel_proveedor.jpg" /> 
								   <h5><b>Generar archivo CSV</b></h5>   
								 <img src="../../kimages/excel_csv.jpg" /> 
						      </div>
							  
							  	 <div class="col-md-12" style="background-color:cadetblue">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="160" src="../model/moduloxlsCliente.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
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
 