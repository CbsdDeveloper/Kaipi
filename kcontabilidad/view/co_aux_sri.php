<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
 <script type="text/javascript" src="../js/co_aux_sri.js"></script> 
    
 <style type="text/css">
	 
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
		#mdialTamanio{
  					width: 65% !important;
        }   
     
       #mdialNovedad{
  					width: 55% !important;
        }  
	 
		.highlight {
  					background-color: #FF9;
		}
		.ye {
  					background-color:#93ADFF;
		}
            
	 
	 .ya {
  					background-color:#FDA9AB;
		}
            
</style>		     	     	    		

     
	
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
    
		<!-- Content Here -->
	    
		<div class="row">
 		
			<div class="col-md-12">
							  
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b> CUENTAS POR PAGAR - PROVEEDORES</b></a>
										</li>
										 
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> DETALLE DE TRANSACCIONES POR PAGAR</a>
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

													   <div class="col-md-12">
														   
														   	  <div class="col-md-3">
																  
																 <select id="anio" name = "anio" class="form-control">
																		   <option value="2024">2024</option>	 
																		   <option value="2023">2023</option>	 
																		   <option value="2022">2022</option>	 
																		   <option value="2021">2021</option>
																		   <option value="2020">2020</option>
																		   <option value="2019">2019</option>
																		   <option value="2018">2018</option>
																 </select>
																  
															  </div>  
													
														      <div class="col-md-3">
																  
																 <select id="tipo" name="tipo" class="form-control">
																   <option value="P">Proveedores</option>
 																  </select>
																  
															  </div>  
														   
														      <div class="col-md-2" style="padding: 1px"> 

																 <button type="button" class="btn btn-primary btn-sm btn-block" id="load">  
																			<i class="icon-white icon-search"></i> Busqueda</button>	

															</div>
 														     
														      <div class="col-md-2" style="padding: 1px"> 
																  <button type="button" class="btn btn-default btn-sm btn-block" id="loadxls" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i> Descargar
															  </button>	

															  </div>
 														   
													   </div>  
													
													   	<div class="col-md-10">

 															<div class="table-responsive" id="employee_table">  

															   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 10px"  >
																							<thead>
																								<tr>
																								<th width="10%">Identificacion</th>
																								<th width="30%">Nombre</th>
																								<th width="30%">Ultima Transaccion</th>	
																								<th bgcolor=#E5F8E9 width="30%">Transacciones</th>
																								<th width="10%">Acción</th>
 																								</tr>
																							</thead>
															  </table>
  														   </div>   
 														</div>  

 				 
													</div>

											   </div>  
											 </div> 
										  </div>

										 <!-- Tab 2 -->

										  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">

											  <div class="panel panel-default">

												   <div class="panel-body" > 

													 <div class="col-md-12" style="padding: 1px">
  														 
														 	  <div class="col-md-12" style="padding: 5px">
														   
 															 
															  <div class="col-md-2">
																 
																 <select id="cmes" name = "cmes" class="form-control">
																	   <option value="-">Todos</option>
																      <option value="1">Enero</option>
																      <option value="2">Febrero </option>
																	  <option value="3">Marzo </option>
																	  <option value="4">Abril </option>
																	  <option value="5">Mayo</option>
																	  <option value="6">Junio </option>
																	  <option value="7">Julio </option>
																	  <option value="8">Agosto </option>
																	  <option value="9">Septiembre</option>
																	 <option value="10">Octubre</option>
																	 <option value="11">Noviembre</option>
																	 <option value="12">Diciembre</option>
 																 </select>
																 
															  </div>  
															 
														   	  <div class="col-md-3">
																  
																 <select id="bandera" name = "bandera" class="form-control">
																   <option value="S">[ Por Cuenta ]</option>
																   <option value="N">[ Todas las Cuentas ] </option>
 																 </select>
																  
															  </div>  
													
														      <div class="col-md-3">
																 <select id="cuenta" name="cuenta" class="form-control">
 																  </select>
															  </div>  
															 
														  </div>
														   
														      <div class="col-md-12" style="padding: 5px"> 

																 <button type="button" class="btn btn-info btn-sm" id="load28">  
																	 
																			<i class="icon-white icon-android"></i> Busqueda Resumen
																  </button>	

																   <button type="button" class="btn btn-primary btn-sm" id="load2">  
																	 
																			<i class="icon-white icon-search"></i> Busqueda Detalle
																  </button>	
															 
																			   <div class="btn-group">
																					<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
																					Seleccionar <span class="caret"></span></button>
																					<ul class="dropdown-menu" role="menu">
																					  <li><a href="#" onClick="Marca_Datos(1)">Marcar Todo</a></li>
																					  <li><a href="#" onClick="Marca_Datos(0)">Desmarcar Todo</a></li>
																					</ul>
																				  </div>
														     
																  				<button type="button"   data-toggle="modal" onClick="TotalSeleccion()" data-target="#myModalCxp" class="btn btn-default btn-sm" id="loadxls2">  
																					<i class="icon-white icon-ambulance"></i> Contabilizar
															  					</button>	

															  </div>
 														   
													   </div>  

													     <div class="col-md-12">
																
																 <h4><b> <div id="ViewProveedor">Nombre Auxiliar </div></b> </h4>

															      <div id="ViewFormAux"> </div>
																
																
																   <div id="ViewData"> </div>
															 
															  		<div align="right" id="ViewParcial"> </div>
															 
																    <input type="hidden" name ="parcial" id="parcial">
														   </div>  
 

													</div>

												   </div>
											  </div>

										  </div>

										<!-- Tab 3 -->	
 
							    </div>
			    </div>	  
 		</div>
    </div>
     <!-- /.auxiliar -->

  <input type="hidden" id="prove" name="prove">

  <div id="ViewFormAux">  </div>
    
  <div class="container"> 
  	  
	  <div class="modal fade" id="myModalCxp" tabindex="-1" role="dialog">
						  <div class="modal-dialog" id="mdialTamanio">
									<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h3  class="modal-title">Detalle </h3>
											  </div>
											  <div class="modal-body">

												<div class="form-group" style="padding-bottom: 2px">
															 <div class="panel panel-default">

																		 <div class="panel-body">
																			 <div id="ViewFiltroAux"> var</div> 
																			 <p align="center">Resumen Seleccion</p> 
																			 <div id="ViewFormTotal" style="padding: 25px" align="center"> </div>
																		 </div>

															 </div>   
														 </div>
											  </div>

											  <div class="modal-footer">
												  
												  <button type="button" onClick="Contabilizar();" class="btn btn-sm btn-success">Contabilizar</button>
												  
												  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
											  </div>
									</div>
									<!-- /.modal-content --> 
						  </div>
						  <!-- /.modal-dialog -->
	  </div>
	  
 </div>  
 
  <div class="container"> 
  	  
	  <div class="modal fade" id="myModalAsiento" tabindex="-1" role="dialog">
						  <div class="modal-dialog" id="mdialTamanio">
									<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h3  class="modal-title">Detalle </h3>
											  </div>
											  <div class="modal-body">

												<div class="form-group" style="padding-bottom: 2px">
															 <div class="panel panel-default">

																		 <div class="panel-body">
																			 <div id="ViewFiltroCxp"> var</div> 
																			 
																			  <div id="ViewGuarda" style="padding: 25px" align="center"> </div>
																			 
																		 </div>

															 </div>   
														 </div>
											  </div>

											  <div class="modal-footer">
												  
												  <button type="button" onClick="CXPContabilizar();" class="btn btn-sm btn-success">Generar Contabilizar</button>
												  
												  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
											  </div>
									</div>
									<!-- /.modal-content --> 
						  </div>
						  <!-- /.modal-dialog -->
	  </div>
	  
 </div>  
   
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 