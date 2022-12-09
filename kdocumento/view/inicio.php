<!DOCTYPE html>
<html lang="en">
	
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
  
    <style type="text/css">  
  	
 		 .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
			position: relative;
			min-height: 1px;
			padding-right: 10px;
			padding-left: 10px;
			font-style: normal;
			font-weight: normal;
			font-size: 13px;
			font-family: "Segoe UI", "Trebuchet MS", sans-serif;
		}	 
	 
	</style>
 	
	 	
	 <script language="javascript" src="../js/cli_incidencias.js"></script>
	 
	
		<script type="text/javascript" src="../../app/bootstrap-wysihtml5/wysihtml5.min.js"></script>
	
		<script type="text/javascript" src="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
	
	    <link href="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">
	
  	    <link href="tabi.css" rel="stylesheet" type="text/css" />
 	
</head>
	
<body>

<div id="main">
	
    <div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
 	
	
	<div id="mySidenav" class="sidenav" style="z-index: 100" >
		
		 <div class="panel panel-primary">
			
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
			
				<div class="panel-body">
					
					<div id="ViewModulo"></div>
					
				</div>
			
		  </div>
		
   </div>
	
 
 	
    <div class="col-md-12"> 
 	    
 					  <ul id="mytabs" class="nav nav-tabs">  
						  
							<li class="active"><a href="#tab1" data-toggle="tab">
								<span class="glyphicon glyphicon-th-list"></span> Portafolio de Mis Documentos</a>
							</li>

							<li><a href="#tab2" data-toggle="tab">
								<span class="glyphicon glyphicon-link"></span> Formulario </a>
							</li>

							<li><a href="#tab3" data-toggle="tab">
								<span class="glyphicon glyphicon-calendar"> </span> Recorrido Documentos</a>
							</li>
	
							<li><a href="#tab4" data-toggle="tab">
								<span class="glyphicon glyphicon-apple"> </span> Grafico Proceso</a>
							</li>
			
                      </ul>
		
                     <!-- ------------------------------------------------------ -->
                     <!-- Tab panes -->
                     <!-- ------------------------------------------------------ -->
                   
				<div class="tab-content">
                  
						 <input name="codigoproceso" type="hidden" id="codigoproceso" value='0'>

							 <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

								  <div class="panel panel-default">

										 <div class="panel-body"  > 
											
											 <div class="col-md-2">
												 
												  <div class="col-md-12" style="padding-top: 5px" >
													  
														  		<div id="ViewFormArbol"></div>
												  </div>	
												 
												 
												 
												 
												   <div class="col-md-12" style="padding-top: 13px;padding-bottom:5px" >												 
														   
													  	<button type="button" class="btn btn-sm btn-success btn-block" onClick="MisMemos()" id="loadavanzada1" data-toggle="modal" data-target="#myModalMemo">  
															 Documentos Enviados&nbsp;&nbsp; <i class="icon-white icon-search"></i></button>	

													  
 												  </div> 
												 
												 
												  
												 
												 
												 
												 <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"  >
															  <h6>Busqueda avanzada</h6>   
												 
														   <input type="text" placeholder="Nro.Documento" name="iddocaso" id="iddocaso" class="form-control">
												 
												  </div>  
												 
												  <div class="col-md-12" style="padding-top: 3px;padding-bottom: 3px" >												 
														   <input type="text" placeholder="Asunto" name="idasunto" id="idasunto" class="form-control">
 												  </div> 
												 
												   <div class="col-md-12" style="padding-top: 3px;padding-bottom: 3px" >												 
														   <input type="text" placeholder="Nombre" name="aquien" id="aquien" class="form-control">
 												  </div> 
												  
												  <div class="col-md-12" style="padding-top: 3px;padding-bottom: 3px" >												 
														   
													  	<button type="button" class="btn btn-sm btn-primary btn-block" id="loadavanzada" >  
																				<i class="icon-white icon-search"></i> Búsqueda Avanzada</button>	

													  
 												  </div> 
												 
												
												 
												 
												 
											 </div>   
											
											  <div class="col-md-10" style="padding: 5px;" >

 												  	   <div id="mySidenav_proceso" class="sidenav_proceso">
														   
 													  	   <div id="ViewFormProceso"  style="padding:10px"></div>
														   
 												   		</div> 
  												  
 
 												    <div class="col-md-12" id="main_proceso">
 														
														  <div class="col-md-12" >
															 <table id="json_variable" style="font-size: 11px" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																 <thead>
																	<tr>
																		<th style="background-color: #f8f8f8" width="5%">Nro</th>
																		<th style="background-color: #f8f8f8" width="8%">Fecha</th>
																		<th style="background-color: #f8f8f8" width="15%">De</th>	
																		<th style="background-color: #f8f8f8" width="25%">Asunto</th>
																		<th style="background-color: #f8f8f8" width="30%">Ultimo Comentario</th>
																		<th style="background-color: #f8f8f8" width="10%">Trascurridos</th>	
																		<th style="background-color: #f8f8f8" width="15%">Acción</th>
																	</tr>
																</thead>
															</table>
												         </div>
														
											       </div>
												  
												  
											  </div>  
 
											
										 </div>
									  
								  </div>
							 
					     </div>

					     
							 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">

										 <div class="panel panel-default">

													  <div class="col-md-12"> 

																<div id="ViewFormularioTarea"> </div> 



																<div id="VisorTarea">  </div> 

													  </div>

										  </div>

								</div>	 
					
					  
							 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							    <div class="panel-body" > 
									
									  <div class="col-md-12"> 
 											<div id="ViewRecorrido"> </div> 
									   </div>
									
							  </div>
								
						   </div>
							  
					      </div>	 
					   
            				 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							    <div class="panel-body" > 
 										<div id="DibujoFlujo">  </div> 
 							  </div>
								
						   </div>
							 
					    </div>	 
            
 				</div>
		
    </div>
 	<input name="bandera1" type="hidden" id="bandera1" value="N">
    <input name="bandera2" type="hidden" id="bandera2" value="N">
 	<input name="bandera3" type="hidden" id="bandera3" value="N" class="glyphicon-edit">
      
 </div>   
 <div id="FormPie"></div> 
	 
	
		<div class="modal fade" id="myModalDocVisor" role="dialog">
		
		  <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
			  
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Visor de Documento</h4>
				</div>
				<div class="modal-body">


					<embed src="" width="100%" height="450" id="DocVisor">

				</div>

				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

 						</div>
					  </div>
    			 </div>
 		 </div>
	
	
		<!-- Modal -->
	
	 	 <div class="modal fade" id="myModal" role="dialog">
	  
				<div class="modal-dialog">

				  <!-- Modal content-->

				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Cambiar de Usuario</h4>
					</div>
					<div class="modal-body">
					 <form class="login" action='../controller/login_cambio.php' method="post" enctype="application/x-www-form-urlencoded"   accept-charset="UTF-8">


								  <div class="col-md-12" style="padding: 6px"> 
										<input class="form-control" type="text" placeholder="Username" required   name="username" />
								  </div>

								<div class="col-md-12" style="padding: 6px"> 
									<input class="form-control" type="password" placeholder="Password" required name="password" />
								</div>
										<input name="s" type="hidden" id="s" value="register">

								<div class="col-md-12" style="padding: 6px"> 
										<input type="submit" value="Cambiar Sesión" class="btn btn-primary btn-sm" />

								   </div>		  

							</form>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
  </div>
	
	
	
	<div class="modal fade" id="myModalMemo" role="dialog">
	  
			 <div class="modal-dialog" id="mdialTamanio">

				  <!-- Modal content-->

				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Documentos Generados</h4>
					</div>
					<div class="modal-body">
 								  <div class="col-md-12" style="padding: 10px"> 
 										 <div class="panel panel-default">
											 
											  <div class="panel-body"> 
												  
												  
												  		 	<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;"> 
																
																 <div class="col-md-3"> 
																	 <input type="date" id="f1_v" name="f1_v" class="form-control">
																 </div> 
																<div class="col-md-3"> 
																	 <input type="date" id="f2_v" name="f2_v" class="form-control">
																 </div> 
																	
															 
															  <button type="button" onClick="MisMemosL(2)" class="btn btn-primary btn-sm">Enviados Periodo</button>
															 
															  <button type="button" onClick="MisMemosL(3)" class="btn btn-success btn-sm">Marcado Leidos</button>
																
																  <button type="button" onClick="MisMemosL(4)" class="btn btn-info btn-sm">Tramites Reasignados</button>
															 
															 </div> 
															 
														  <div class="col-md-12"> 
												  
																<div  style="width:100%; height:450px;">

																	<div id="visor_doc">  </div> 

															  </div>
															 
													 </div>		  
												  
 											  </div>
											 
											</div>
 								  </div>
 									 

								   

 					</div>
					<div class="modal-footer">
						
						  <button type="button" class="btn btn-info" onClick="MisMemos()">Regresar</button>
						
						
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
  </div>
	
	
	<div class="modal fade" id="myModalCambio" role="dialog">
	  
				<div class="modal-dialog">

				  <!-- Modal content-->

				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Asignar a responsables</h4>
					</div>
					<div class="modal-body">
 								  <div class="col-md-12" style="padding: 10px"> 
 										 <div class="panel panel-default">
											  <div class="panel-body"> 
												    <div id="visor_usuario">  </div> 
 											  </div>
											</div>
 								  </div>
 									 
						

								<div class="col-md-12" style="padding: 6px"> 
 									
									 <button type="button" onClick="CambiarTramite();" class="btn btn-primary"  >Reasigar documento</button>

								   </div>		  

 					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
  </div>
	
	
	
 </body>
</html>
 