<?php
 	session_start();
	require '../controller/Controller-FiltroAgendaMain.php';  
     $gestion   = 	new componente;
 

?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
      <?php  require('HeadPanel.php')  ?> 
  	 
	<link href="../../kplanificacion/view/articula.css" rel="stylesheet">
   
    <style type="text/css">
 	
		  .actividad {
    border-collapse: collapse;
    width: 100%;
	font-size: 12px;
	table-layout: fixed;
 }
		.tree {
			min-height:20px;
			padding:1px;
			margin-bottom:10px;
			background-color:#fbfbfb;
			border:1px solid #D5D5D5;
		}
		.tree li {
			list-style-type:none;
			margin:0;
			padding:10px 5px 0 5px;
			position:relative
		}
		.tree li::before, .tree li::after {
			content:'';
			left:-20px;
			position:absolute;
			right:auto
		}
		.tree li::before {
			border-left:1px solid #D5D5D5;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #D5D5D5;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			display:inline-block;
			padding:3px 8px;
			text-decoration:none
		}
		.tree li.parent_li>span {
			cursor:pointer
		}
		.tree>ul>li::before, .tree>ul>li::after {
			border:0
		}
		.tree li:last-child::before {
			height:30px
		}
		.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
			  color:#000
		}
  		.tree li ul > li ul > li {
				display: none;
		}
	
	
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
  /*  background-color: #111;*/
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
	font-size: 11px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 11px;
    color:#322E2E;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover, .offcanvas a:focus{
    color:#BFBFBF;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 11px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 11px;}
	
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	
}
	 
 
.actividad {
    border-collapse: collapse;
    width: 100%;
	font-size: 12px;
   }
 
 .ex1 {
  width: 1950px;
  overflow-y: hidden;
  overflow-x: auto;
  }
	  
	 
 
	
.table1 {
  border-collapse: collapse;
}
	
 .filasupe {
 
 	border-bottom: 1px solid #ddd;
	border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
	border-top: 1px solid #ddd;
	padding-bottom: 4px; 
}
	
.derecha {
 
     border-right: 1px solid #ddd;
	  
 }
	
  #mdialTamanio{
      width: 70% !important;
    }

	
 #mdialTamanio1{
      width: 80% !important;
    }

	
  .bigdrop{
		
        width: 750px !important;

     }
		  
  .bigdrop1{
		
        width: 750px !important;

     }
		  
	  
	  resumen {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    text-align: center;
		  }
	.resumen_td {
	padding-top: 6px;
    text-align: center;
	font-size: 10px;	
	color: #FFFFFF
		  }
	  
	.resumen_tt {
    padding-bottom: 10px;
	padding-top: 1px;
    text-align: center;
	font-size: 22px;
	font-weight: 700;
	color: #FFFFFF
		  }  
</style>	
  
 
	
  <script language="javascript" src="../js/POASeguimientoUni.js?n=1"></script>
	
</head>
	
<body>
 
    
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
		
							 <ul id="mytabs" class="nav nav-tabs">
 															<li class="active"><a href="#tab1" data-toggle="tab"></span>
																<span class="glyphicon glyphicon-th-list"></span> <b>PLAN ANUAL DE OPERATIVO POR UNIDAD</b></a>  </a>
															</li>
															<li><a href="#tab2" data-toggle="tab">
																<span class="glyphicon glyphicon-link"></span> <b>SEGUIMIENTO DE PROCESO</b></a>
															</li>
   								 </ul>
	
		 	
		  <div class="tab-content">
		
			  	<div id="tab1" class="tab-pane fade in active">
					
					    <div class="panel panel-default">
						   
							<div class="panel-heading">Unidad de Gestión</div>
								<div class="panel-body">
									 <div class="widget box">
										  <div class="widget-content">
												 <?php
												  $gestion->FiltroFormulariouni( ); 
												?>
												<div class="col-md-2" style="padding-top: 8px;">
																	<button type="button"   class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>

												</div>
										   </div>
									   </div> <!-- /.col-md-6 -->
								</div>
						 </div>


					
					    <div class="col-md-3" style="padding-bottom: 10px;"> 
							   
   													<div id="ViewPOAUser">  </div>
   					   </div>

					 	<div class="col-md-9"> 
  

											  <div class="col-md-12"> 

														 <div id="ViewPOAMatrizOO" style="overflow-x: auto;"  > </div>

												 </div>	


											   <div class="col-md-12"> 
														  <div id="UnidadArticula">  </div>
											   </div>

										 
					</div> 	
					
 				</div>
			  
			 
				<div id="tab2" class="tab-pane fade">
					
		   			 <div class="col-md-12" style="padding: 40px"> 
					
								<div class="panel panel-default">
									
										<div class="panel-heading">Gestión de la unidad</div>
											<div class="panel-body">
												 <div class="widget box">
													  <div class="widget-content">
														  
 														  
												        <div class="col-md-12" > 
 																  
																  <ul class="nav nav-pills" id="my_tabs_evento" name="my_tabs_evento">
																	  
																	  <li class="active"><a data-toggle="tab" href="#menu_evento01"><b>1. INFORMACION TAREA PLANIFICADA </b></a></li>
																	  <li><a data-toggle="tab" href="#menu_evento02"><b>2. EJECUCIÓN ACTIVIDAD/TAREA</b></a></li>
																	  <li><a data-toggle="tab" href="#menu_evento03"><b>3. EVENTOS / HISTORIAL / MEDIOS DE VERIFICACION</b></a></li>
																	  
																	</ul>
																  
																  
																	  <div class="tab-content">
																	  
																					  <div id="menu_evento01" class="tab-pane fade in active">
																						  
																						  <div class="col-md-12" style="padding: 10px"> 
																							  
																						   <div class="panel panel-info">
																							  <div class="panel-heading">Información Planificacion</div>
																							  <div class="panel-body">

																									 <div id="ViewForm">  </div>
																									 <div id="VisorTarea">  </div>

																							   </div>
																							</div>
																						 </div> 
																						  
																					  </div>
																	  
																					  <div id="menu_evento02" class="tab-pane fade">
																						  
																					 	  <div class="col-md-12" style="padding: 10px"> 
																						   <div class="panel panel-info">
																							  <div class="panel-heading">Historial de Eventos</div>
																							  <div class="panel-body">

																							    <div id="ViewFormActividades">  </div>
																						     </div>
																							</div>
																						 </div>  
																						  
																					  </div>
																	  
																					  <div id="menu_evento03" class="tab-pane fade">
																						  
																						  <div class="col-md-12" style="padding: 10px"> 
																							  
																								    <div class="panel panel-info">
																									  <div class="panel-heading">Documentos de verificacion</div>
																									  <div class="panel-body">
																										  
																										   <div id="Seguimiento_tarea">  </div>
																										  
																									   </div>
																									</div>
																							  
																							  
																								  <div class="panel panel-success">
																									  
																									  <div class="panel-heading">Archivos/Medio Verificación</div>
																									  <div class="panel-body">
																										  <button type="button" class="btn btn-success btn-sm">Agregar Archivos</button>
																										  
																										   <div id="Seguimiento_tarea">  </div>
																										  
																									   </div>
																									</div>
																							  
																							  
																							</div>  
																						  
																					  </div>
																	</div>

 																  
														      </div>
														  

													   </div>
												   </div> <!-- /.col-md-6 -->
											</div>
								</div>
					
						</div>
				</div>


	 	 </div>
		
		 
 		 
</div>



  <!---------------  FORMULARIO MODAL DE COMPRAS  ----------------->	
 
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">INICIO DE PROCESO CONTRATACION</h4>
		   </div>
			 
			 
			   <form action="../model/Model_tarea_seg01.php" method="POST" id="fo22"   name="fo22" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormCompras"> var</div> 
								   
  				
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									 <div id="guardarCompras" style="padding: 15px;" align="center"></div>   

									  <button  type="submit" class="btn btn-sm btn-primary"  onclick="Confirmar(event)" >
									 <i class="icon-white icon-search"></i> Guardar y enviar proceso</button> 
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 			</form>
			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->


 
    <!---------------  FORMULARIO MODAL DE ENVIO DE INFORMACION  ----------------->	
 
 <div class="modal fade" id="myModalProceso" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">INICIO DE PROCESO</h4>
		   </div>
			 
			 
 				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							                           
							   <div class="col-md-12"> 
								   
								 <textarea class="form-control" id="seg_comentario" name="seg_comentario" placeholder="Ingrese comentario"></textarea>
								   
									 <input type="hidden" id="seg_tarea1" name="seg_tarea1">
  				  					 <input type="hidden" id="seg_tarease1" name="seg_tarease1">
								   
								   	 <div id="mensaje_envio" style="padding: 15px;" align="center"></div>   
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
 									
								     <input name="2d" type="button" id="2d" class="btn btn-sm btn-primary" value="Enviar proceso de ejecución" onClick="EnvioProcesoEjecuta()">
									 	
 									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
						    </div>
							  
							  
					     </div>
					  </div>   
						
				   </div>
 			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

  
    
 
 <!---------------  FORMULARIO MODAL DE COMPRAS  ----------------->	
 
 <div class="modal fade" id="myModalTarea" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">INICIO DE PROCESO SIN RECURSO</h4>
		   </div>
			 
			 
			   <form action="../model/Model_tarea_seg03.php" method="POST" id="fo23"   name="fo23" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormTarea"> var</div> 
								   
										   
 				
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									 <div id="guardarTarea" style="padding: 15px;" align="center"></div>   

									  <button  type="submit" class="btn btn-sm btn-primary">
									 <i class="icon-white icon-search"></i> Guardar</button> 
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 			</form>
			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->


 <div id="FormPie"></div>  
</body>
</html> 