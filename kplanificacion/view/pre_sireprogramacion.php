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
    
	
 <style type="text/css">
  		#mdialTamanio{
  					width: 90% !important;
		}
	    #mdialTamanio1{
  					width: 90% !important;
		}
	 #mdialTamanio2{
  					width: 65% !important;
		}
  </style>

  <script type="text/javascript" src="../js/pre_sireprogramacion.js"></script> 
    
</head>
<body>

  <!-- ------------------------------------------------------ -->  
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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
 								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>REFORMAS PRESUPUESTARIAS</b>  </a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> FORMULARIO DE INGRESO DE DATOS</a>
										</li>
								</ul>
								<!-- ------------------------------------------------------ -->
								<!-- Tab panes -->
								<!-- ------------------------------------------------------ -->
								<div class="tab-content">
								   <!-- Tab 1 -->
								    <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
									  <div class="panel panel-default">
										  <div class="panel-body" > 
 										   <div class="col-md-12" style="padding: 1px">
 										   
  													<div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);
box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
													    
														    <h5>Filtro búsqueda</h5>
														    <div id="ViewFiltro"></div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
															<div style="padding-top: 5px;" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
												</div>
												
											        <div class="col-md-9">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="10%">Reforma</th>
																						<th width="10%">Tipo</th>
																						<th width="10%">Fecha</th>	
																						<th width="10%">Comprobante</th>
																						<th width="20%">Solicitado</th>
																						<th width="30%">Detalle</th>
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
								 
								</div>
	</div>	  
 	 
     <!-- /.auxiliar -->  

    

	  <!-- /. costos  -->  

  <div class="container"> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
				  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 class="modal-title">Selección de partida </h5>
		  </div>
				  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
			         	   <div class="panel panel-default">
								 <div class="panel-body">
									 <table id="jsontable_gasto" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th width="15%">Partida</th>
														<th width="25%">Detalle</th>
 														<th width="10%">Item</th>
														<th width="10%">Fuente</th>
														<th width="8%">Inicial</th>	
														<th width="8%">Codificado</th>	
														<th width="8%">Reformas</th>	
														<th width="8%">Disponible</th>
														<th width="8%">Acción</th>
													</tr>
												</thead>
									</table>
									 
									 <div id="guardarCosto"></div> 
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
	
		 

  <div class="container"> 
	  <div class="modal fade" id="myModalimportar" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio2">
		<div class="modal-content">
				  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 class="modal-title">Exportar e Importar Reforma Presupuesto</h5>
		  </div>
				  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
			         	   <div class="panel panel-default">
								 <div class="panel-body">
									  <div class="col-md-12">
 	    									  <h4><b>EL proceso de importacion solo se genera con la reforma de gasto y traslado.</b></h4>
 									   </div> 
									  <div class="col-md-12">
 	    									<h5><b>Exportar formato reforma traslado</b></h5>
										   <button type="button" onClick="Exporta_reforma_formato()" class="btn btn-success">Exportar formato reforma</button>    
										  <h5>Verifique el archivo y <b> elimine la primera fila para importar la informacion</b>... Advertencia respete el formato del archivo para la importacion de datos.  </h5>
 									   </div>
									 
									   <div class="col-md-12">
										   
									   <iframe width="100%" id="archivocsv" name = "archivocsv" height="150px" src="../model/Model-xls_reforma.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
										   
									   </div>
									 
									  <div class="col-md-12">
 										   <button type="button" onClick="DetalleAsiento()" class="btn btn-warning">Actualizar Informacion</button>    
										  
 									   </div>
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
 </div>   
 </body>
</html>
 