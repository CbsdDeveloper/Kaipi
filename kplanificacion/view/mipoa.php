<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	
	 <script language="javascript" src="../js/mipoa.js"></script>
	
 	 <link href="articula.css" rel="stylesheet">
 	   
 
 <style type="text/css">
 
.actividad {
    border-collapse: collapse;
    width: 100%;
	font-size: 11px;
	font-weight:bold;
	table-layout: fixed;
 }
 
 div.ex1 {
  width: 100%;
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

	 
</style>
  
     
	<script type="text/javascript" src="../js/select2.js"></script> 
	
    <link href="../js/select2.css" rel="stylesheet">
	
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
							
                   			<span class="glyphicon glyphicon-th-list"></span> Matriz POA</a>
                   			 
                   		</li>
                  	 
                   </ul>
		
                     <!-- ------------------------------------------------------ -->
                     <!-- Tab panes -->
                     <!-- ------------------------------------------------------ -->
		
                    <div class="tab-content">
					   
                  		  <!-- Tab 1 -->
					   
                  		 <div class="tab-pane fade in active" id="tab1" style="padding-top: 5px;">
					   
								   <div class="panel panel-default">

												  <div class="panel-body" > 


  
													     		<div class="col-md-12"> 

																			<div class="alert alert-info">

																				<div class="row">

																					<div id = "ViewFiltro" > </div>

																					<div class="col-md-3" style="padding-top: 5px;">

																					<button type="button" class="btn btn-primary btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>

																					</div>

																				</div>
																			</div>

																			<div id="UnidadSeleccionada" style="padding: 1px"> </div>

																 </div> 

 

														   	     <div class="panel-group" id="accordion_panel">
																	 
																	 
																			  <div class="panel panel-default">

																			  <div class="panel-heading">
																				<h5 class="panel-title">
																				  <a data-toggle="collapse" data-parent="#accordion_panel" href="#collapse31" style="font-size: 13px;font-weight: 200"><b>PASO 1. OBJETIVOS DE UNIDAD</b></a>
																				</h5>
																			  </div>
 																			  <div id="collapse31" class="panel-collapse collapse">

																				<div class="panel-body">
																					
																					
																					<div class="col-md-12"> 
																						   <div class="col-md-4"> 
																									<div class="alert alert-danger">
																									  <strong>OBJETIVO</strong> estado deseado a alcanzar. Es un enunciado breve que define los resultados esperados de la institución y establece las bases para la medición de los logros obtenidos.

																									</div>
																							</div>	   
																						   <div class="col-md-4"> 
																									<div class="alert alert-warning">
																									  <strong>Caracteristicas</strong> ser específicos,ser medibles,ser agresivos pero alcanzables, estar orientados a resultados; y estar sujetos a un marco de tiempo.
																									</div>
																							</div>	

																						    

																						 </div>			   

																						<div class="col-md-12"> 
																							
																								  <div class="col-md-7"> 

																										<div id="ViewPOAObjetivo"> </div>
																									  
																								  </div>	
 
																					   </div>	
																					

																						 
																					</div>
																			  </div>
  																       </div>
																	 
																	 
																			  <div class="panel panel-default">

																			  <div class="panel-heading">
																				  
																				<h5 class="panel-title">
																				  <a data-toggle="collapse" data-parent="#accordion_panel" href="#collapse11" style="font-size: 13px;font-weight: 200"><b>PASO 2. INDICADORES DE UNIDAD</b></a>
																				</h5>
																			  </div>
 																			  <div id="collapse11" class="panel-collapse collapse">

																				<div class="panel-body">

																						 <div class="col-md-12"> 
																						   <div class="col-md-4"> 
																									<div class="alert alert-danger">
																									  <strong>EFICACIA</strong> miden el grado del cumplimiento del objetivo establecido, es decir, dan evidencia sobre el grado en que se están alcanzando los objetivos descritos. 


																									</div>
																							</div>	   
																						   <div class="col-md-4"> 
																									<div class="alert alert-warning">
																									  <strong>EFICIENCIA</strong> Los indicadores de eficiencia miden la relación entre el logro del objetivo y los recursos utilizados para su cumplimiento.

																									</div>
																							</div>	
																							<div class="col-md-4"> 
																									<div class="alert alert-info">
																									  <strong>PROCESO</strong> Los indicadores de proceso son herramientas de gestión utilizadas para evaluar la calidad de un proceso y el rendimiento de las tareas.

																									</div>
																							</div>	
																						    

																						 </div>			   

																						<div class="col-md-12"> 
																							
																								  <div class="col-md-12"> 

																										<div id="UnidadArticula"> </div>
																									  
																								  </div>	
 
																					   </div>	
																					</div>
																			  </div>
  																       </div>
																	 

																			<div class="panel panel-default">

																			  <div class="panel-heading">

																				<h5 class="panel-title">
																				  <a data-toggle="collapse" data-parent="#accordion_panel" href="#collapse21" style="font-size: 13px;font-weight: 200"> <b>PASO 3. MATRIZ PAPP POA - UNIDAD </b> </a>
																				</h5>

																			  </div>

																			  <div id="collapse21" class="panel-collapse collapse in">

																				<div class="panel-body">

																					   <div class="col-md-12"> 
																						   <div class="col-md-4"> 
																									<div class="alert alert-danger">
																									  <strong>ACTIVIDADES</strong> conjunto de tareas o acciones realizadas por una unidad con el fin de cumplir objetivos y metas institucionales.
																									</div>
																							</div>	   
																						   <div class="col-md-4"> 
																									<div class="alert alert-warning">
																									  <strong>TAREA</strong> unidad de trabajo específico o acción a ejecutar, estas pueden ser de gestión o con recursos financieros.
																									</div>
																							</div>	

																						   <div class="col-md-4"> 
																									<div class="alert alert-info">
																									  <strong>ITEM/CLASIFICADOR</strong> Código asignado por el MINFIN que clasifica y ordena el Gasto en el Sector Público.
																									</div>
																							</div>	

																						 </div>			   

																						<div class="col-md-12"> 

																							<div id="ViewPOAMatrizOO"> </div>
 
																					   </div>	
																					
																				</div>

																			  </div>

																			</div>
 														 

																			


														


													  </div> 

													  
												 </div> 


								</div>
							 
                		</div>
					   
               
                     
        			</div>		
		 
          
	       
    </div>
     
    
     <!-- Modal -->
   
  <div class="container">
	  
	  
	   <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
		   
		   <div class="modal-dialog" id="mdialTamanio">
			   
		   <!-- Modal content-->
			   
		   <div class="modal-content">
			   
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Actividades POA</h4>
				</div>

				   <div class="modal-body">
					   
					   <div class="form-group" style="padding-bottom: 1px">
						  <div class="panel panel-default">

								 <div class="panel-body">

									 <div id="ViewForm"> </div>

								 </div>
							 </div>   
						 </div>
					   
					  </div>

				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			   
		  </div>
			   
		 </div>
		   
	   </div>
	  
 </div>
 

 <div class="container">
	 
	 
   <div id="myModalTarea" class="modal fade" tabindex="-1" role="dialog">
	   
       <div class="modal-dialog" id="mdialTamanio1">
		   
       <!-- Modal content-->
		   
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Tareas de gestión</h4>
			</div>
		   
		   <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 1px">
			          <div class="panel panel-default">

							 <div class="panel-body">

							   <div id="ViewFormTareas"> </div>

							 </div>
					     </div>   
  					 </div>
				  </div>
 
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 
			 
			</div>
      </div>
     </div>
   </div>
 </div>
 

    
     <!-- Modal OO --> 

<div class="container"> 
	  
	  <div class="modal fade" id="myModaloo" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		  
		<div class="modal-content">
			
		  <div class="modal-header">
			  
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Objetivo Operativo</h3>
			  
		  </div>
			
				  <div class="modal-body">
				    
			          <div class="panel panel-default">

							 <div class="panel-body">

								 <div id="ViewFormOO"> </div>

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
	 
   <div id="myModalIndicador" class="modal fade" tabindex="-1" role="dialog">
	   
       <div class="modal-dialog" id="mdialTamanio">
       <!-- Modal content-->
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Indicadores Objetivo Operativo</h4>
			</div>
		    <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 1px">
			          <div class="panel panel-default">

							 <div class="panel-body">

								 <div id="ViewFormIndicador"> </div>

							 </div>
					     </div>   
  					 </div>
				  </div>
		   
 			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 
			 
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
 