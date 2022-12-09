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
    
 	<script type="text/javascript" src="../js/ven_potencia.js"></script> 
 
	
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>LISTA DE POTENCIALES CLIENTES</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Cliente</a>
                  		</li>
						
				        <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-download-alt"></span> Importar Cliente CSV</a>
                  		</li>
			
						<li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-envelope"></span> Importar GMail</a>
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
   							  <div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1); box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
									  <h5>Filtro búsqueda</h5>
									  <div id="ViewFiltro"></div> 
								
								      <label style="padding-top: 5px;text-align: right;" class="col-md-1"> </label>
									  <div style="padding-top: 5px;" class="col-md-11">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Busqueda  &nbsp; </button>	
									  </div>
								  
									  <label style="padding-top: 5px;text-align: right;" class="col-md-1"> </label> 

								     <div style="padding-top: 5px;" class="col-md-11">
											<a href="https://declaraciones.sri.gob.ec/sri-en-linea/#/SriRucWeb/ConsultaRuc/Consultas/consultaRuc" target="_blank" class="btn btn-sm btn-info" role="button">Consulta RUC</a>
									   </div>
								  
								  <h6>&nbsp;  </h6> 
								  
								 
								 </div>
								
							    <div class="col-md-9">
												        <h5>Posibles Clientes</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																						 <th width="10%">Codigo</th>
																						<th width="30%">Nombre</th>
																						<th width="30%">Direccion</th>
																						<th width="10%">Telefono</th>
																						<th width="10%">Correo</th>
																						<th width="10%">Acción</th>
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
							   <div id="ViewForm"> </div>
                		  </div>
                	  </div>
                 </div>
					   
			  <!-- Tab 3 -->
                 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							 <div class="col-md-12">
							       <h4>Formato Importar archivo CSV</h4>   
				                  <img src="../../kimages/formato_excel.png" /> 
						      </div>
							  
							  	 <div class="col-md-12">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="160" src="../model/moduloCliente.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
							   </div>
							  
							  
						  </div>
                	  </div>
                 </div>		   
					   
				<!-- Tab 4 -->
                 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							 <div class="col-md-12">
							       <h4>Formato Importar archivo GMAIL</h4>   
								  <a href="#" onClick="open_gmail();" class="btn btn-success" role="button">Importar contactos</a>
 						      </div>
							  
							  	 <div class="col-md-12">
 				                  <img src="../../kimages/importarGmail.jpg" /> 
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
 