<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/cli_proceso_parametro.js"></script> 
    
 <style type="text/css">  
   
   tree {
   /* min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)*/
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative;
	white-space :normal
}
	 
 
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
   border-top:1px solid #999; 
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
   /*  -moz-border-radius:5px;
    -webkit-border-radius:5px;
   border:1px solid #999;
    border-radius:5px;*/
  /*  display:inline-block;*/
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
    background:#eee;
  /*  border:1px solid #94a0b4; */
    color:#000
}
	    
 .tree li ul > li  ul > li{
				display: none;
		}
	 
    #mdialTamanio{
      width: 70% !important;
		  
	 }
	 
	 	 
    #mdialTamanio2{
      width: 80% !important;
		  
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
 		
			  <div class="col-md-12">
 			  
				  <ul id="mytabs" class="nav nav-tabs">                    
              
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Diagrama de Procesos</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Flujo  Proceso</a>
                  		</li>
					
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Parametrizar  Proceso</a>
                  		</li>
		
		
                   
                  </ul>
                    
                   <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                  
                    <div class="tab-content">

					   <!-- ------------------------------------------------------ -->
					   <!-- Tab 1 -->
					   <!-- ------------------------------------------------------ -->

					   <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

						  <div class="panel panel-default">

							  <div class="panel-body" > 

									<div class="col-md-12" style="padding: 1px">
									  <div class="col-md-5" style="padding: 1px">
											<div id="ViewFormArbol" style="padding: 1px"></div>
									  </div>  
									  <div class="col-md-7" style="padding: 1px">
											  <div id="ViewProceso"  style="padding: 1px; background-color:#FDFBFB"> </div>
									  </div>
									</div>

							</div>  

						 </div> 

					   </div>

					   <!-- ------------------------------------------------------ -->
					   <!-- Tab 2 -->
					   <!-- ------------------------------------------------------ -->

					   <div class="tab-pane fade in" id="tab2" style="padding-top: 3px">

						  <div class="panel panel-default">

							  <div class="panel-body"> 

									<div class="col-md-12" style="padding: 1px">

											 <div id="DibujoFlujo" style="padding: 1px"></div>

									</div>

							</div>  

						 </div> 

					   </div>
                      
					   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
					 
     						   <div class="panel panel-default">
						  
						 			 <div class="panel-body" > 
						  
						        <input name="codigoproceso" type="hidden" id="codigoproceso" value='0'>
							  
							    <input name="codigotarea" type="hidden" id="codigotarea" value='0'>
  							       
 									<div class="col-md-12" >	
									  
										   <div class="col-md-7">
 										  
												   <div  id="formVentana">  </div>  

												   <div class="bs-example">

														<div class="panel-group" id="accordion">

																	<!--  VARIABLES   --> 

																	<div class="panel panel-default">

																		 <div class="panel-heading">

																			<h4 class="panel-title">
																				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style="font-size:11px" id="variablequery">Creación de VARIABLES  </a>
																			</h4>

																		 </div>


																		 <div id="collapseTwo" class="panel-collapse collapse">

																			<div class="panel-body">

																				  <table id="json_variable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																										<thead>
																											<tr>
																											<th width="10%">Orden</th>
																											<th width="55%">Variable</th>
																											<th width="15%">Tipo</th>
																											<th width="10%">Activo</th>
																											<th width="10%">Acción</th>
																											</tr>
																										</thead>
																				  </table>

																					<button type="button" class="btn btn-info btn-sm" id="loadvariables" name= "loadvariables">
																						 <span class="glyphicon glyphicon-search"></span>  Buscar
																					</button>
																				
																				   <button type="button" class="btn btn-info btn-sm" onClick="javascript:agregaVariable();" data-toggle="modal" data-target="#myModalAux">
																						 <span class="glyphicon glyphicon-plus"></span>  Agregar
																					</button>

																			</div>

																		 </div>

																	</div>

																	<!--  REQUISITOS --> 

																	<div class="panel panel-default">

																		<div class="panel-heading">
																			
																			<h4 class="panel-title">
																				<a data-toggle="collapse" data-parent="#accordion"  id="requisitosquery" href="#collapseThree" style="font-size:11px" >Definición de REQUISITOS  </a>
																			</h4>
																			
																		</div>

																		<div id="collapseThree" class="panel-collapse collapse">

																			<div class="panel-body">
																				  <table id="json_requisito" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																										<thead>
																											<tr>
																											<th width="65%">Requisito</th>
																											<th width="15%">Tipo</th>
																											<th width="10%">Activo</th>
																											<th width="10%">Acción</th>
																											</tr>
																										</thead>
																				  </table>

																			  <button type="button" class="btn btn-warning btn-sm" id="loadrequisito" name= "loadrequisito">
																					 <span class="glyphicon glyphicon-search"></span>  Buscar
																				</button>
																			  <button type="button" class="btn btn-warning btn-sm" onClick="javascript:agregaRequisito();" data-toggle="modal" data-target="#myModalRequisito">
																					 <span class="glyphicon glyphicon-plus"></span>  Agregar
																				</button>

																			</div>

																		</div>

																	</div>


																	<!--   DOCUMENTOS  --> 

																	<div class="panel panel-default">

																		<div class="panel-heading">
																			
																			<h4 class="panel-title">
																				<a data-toggle="collapse" data-parent="#accordion" href="#collapsefour" id="documentoquery" style="font-size:11px" >Creación de DOCUMENTOS  </a>
																			</h4>
																			
																		</div>

																		<div id="collapsefour" class="panel-collapse collapse">

																			<div class="panel-body">

																				  <table id="json_documento" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																										<thead>
																											<tr>
																											<th width="65%">Documento</th>
																											<th width="15%">Tipo</th>
																											<th width="10%">Activo</th>
																											<th width="10%">Acción</th>
																											</tr>
																										</thead>
																				  </table>
																			  <button type="button" class="btn btn-success btn-sm" id="loaddocumento" name= "loaddocumento">
																					<span class="glyphicon glyphicon-search"></span>  Buscar
																				</button>
																			  <button type="button" class="btn btn-success btn-sm" onClick="javascript:agregaDocumento();" data-toggle="modal" data-target="#myModaldocumento">
																					 <span class="glyphicon glyphicon-plus"></span>  Agregar
																				</button>

																			</div>

																		</div>

																	</div>

																	<!--  FIN ACORDEON   --> 	
															
															     	<!--  PUBLICACION DE PROCESO  --> 	
															
															       <div class="panel panel-default">

																	   
																		<div class="panel-heading">
																			
																			<h4 class="panel-title">
																				<a data-toggle="collapse" data-parent="#accordion" href="#collapsefive" id="publicacion" style="font-size:11px" >Publicacion del PROCESO </a>
																			</h4>
																			
																		</div>

																		<div id="collapsefive" class="panel-collapse collapse">

																			<div class="panel-body">

																			 <div class="alert alert-success">
												   
												 
																					 <div class="form-group">
																					   <label for="comment"><b>Ingrese novedad u observación para la implementación del proceso:</b></label>
																						 <textarea name="observa" cols="3" rows="3" required="required" class="form-control" id="observa"></textarea>
																					 </div>
											     	 
																					  <div class="form-group">        
 
 																						<button type="button" class="btn btn-success" id="baprobacion">Publicar proceso</button>  

																						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#VentanaProcedimiento">Cargar Procedimiento</button>  


																						<a href="../reportes/FichaProceso" class="btn btn-default" rel="pop-up">Ficha Proceso</a>
 

																						<button type="button" class="btn btn-danger" id="brevertir">Revertir proceso</button>  

																					  </div>
																				 
												   									  <div id='publicadoProceso'>Novedad</div>
   											           
													
										    								 </div>  

																			</div>

																		</div>
																	   

																	</div>

														</div>

														<p><strong>Nota:</strong> Antes de publicar (aprobar) el proceso revise todos los parámetros</p>

												   </div>
											
										  </div>
							    
										  <!--    tareas  --> 
										
										   <div class="col-md-5">

											   <div id="listaTareas"> </div>

										   </div>
										
							   	     </div>
 							   
              		       	 <!--    FIN TAB  --> 
							  
               		       </div>
						  
                		</div>
					 
                	</div>
						
             	 </div>
						
          	 </div>
	
	</div>	  

    <!-- ------------------------------------------------------ -->
    
 	<input name="bandera1" type="hidden" id="bandera1" value="N">
    <input name="bandera2" type="hidden" id="bandera2" value="N">
 	<input name="bandera3" type="hidden" id="bandera3" value="N">
 
	  <!-- /.variables ------------------------------------------------------> 
 		  
	  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
		  
  			  <div class="modal-dialog" id="mdialTamanio">
		  
				<div class="modal-content">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">VARIABLES DE PROCESO</h4>
			  </div>
			
			  <form action="../model/Model-variables.php" method="POST" id="fat"   name="fat" enctype="multipart/form-data" accept-charset="UTF-8"> 
				  
				  <div class="modal-body">
					  
 				   <div class="form-group" style="padding-bottom: 5px">
			          <div class="panel panel-default">
 				
				         <div class="panel-body">
							 <div class="col-md-12">
							 	<div id="guardarAux" style="padding: 5px;background:#428bca;color: #FFFFFF" align="center"></div> 
 					  		 	<div id="ViewVariables"> var</div> 
							  </div>
							 
 							  <div class="col-md-12" style="padding: 8px" align="right">
								<button  type="submit" class="btn btn-sm btn-primary" > <i class="icon-white icon-search"></i> Guardar</button> 
								<button type="button" class="btn btn-sm btn-danger" id='saliraux' data-dismiss="modal">Salir</button>
					  		  </div>
							 
					     </div>
				     </div>   
				    </div>
					  
 				  </div>
				  
  		     </form>
			
		</div>
		  
		  		  <!-- /.modal-content --> 
		  
	  </div>
		  
	  			 <!-- /.modal-dialog -->
		  
	   </div>
	   
    	  <!-- /.requisitos --> 
  
	  <div class="modal fade" id="myModalRequisito" tabindex="-1" role="dialog">
		  
  	   <div class="modal-dialog" id="mdialTamanio">
		   
		<div class="modal-content">
			
		 	  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">REQUISITOS DE PROCESO</h4>
		  </div>
			
			  <form action="../model/Model-requisito.php" method="POST" id="form"   name="form" enctype="multipart/form-data" accept-charset="UTF-8"> 
				  <div class="modal-body">
				 
			             <div class="panel panel-default">
 				
								 <div class="panel-body">

										  <div class="col-md-12">
											<div id="guardarRequisito" style="padding: 5px;background:#428bca;color: #FFFFFF" align="center"></div> 
											<div id="ViewRequisitos"> var</div> 
										  </div>
										  <div class="col-md-12" style="padding: 8px" align="right">
												<button  type="submit" class="btn btn-sm btn-primary">
												<i class="icon-white icon-search"></i> Guardar</button> 
												<button type="button" class="btn btn-sm btn-danger" id='saliraux1' data-dismiss="modal">Salir</button>
										 </div>

								 </div>
						  
						  
					     </div>   
  				 
				  </div>
				
 		     </form>
			
		</div>
		   <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>

    
      <!-- /.documentos --> 

 	  <div class="modal fade" id="myModaldocumento" tabindex="-1" role="dialog">
  	   <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">DOCUMENTOS DE PROCESO</h4>
		  </div>
			  <form action="../model/Model-documento.php" method="POST" id="fo2"   name="fo2" enctype="multipart/form-data" accept-charset="UTF-8"> 
				  <div class="modal-body">
				  
			          <div class="panel panel-default">
 				
				         <div class="panel-body">
							 
							  <div class="col-md-12">
											<div id="guardarDocumento" style="padding: 5px;background:#428bca;color: #FFFFFF" align="center"></div> 
											<div id="ViewDocumento"> var</div> 
							  </div>
							 
							   <div class="col-md-12" style="padding: 8px" align="right">
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
  
   
    <!-- /. crear formularios  --> 
 
	  <div class="modal fade" id="myModaltarea" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">FORMULARIO DE PROCESO</h4>
		  </div>
			  <form action="../model/Model-formulario01.php" method="POST" id="fo21"   name="fo21" enctype="multipart/form-data" accept-charset="UTF-8"> 
				  <div class="modal-body">
				  
			          <div class="panel panel-default">
 				
				         <div class="panel-body">
							 
							  <div class="col-md-12">
											<div id="guardarTarea" style="padding: 5px;background:#428bca;color: #FFFFFF" align="center"></div> 
											<div id="ViewTarea"> var</div> 
							  </div>
						 
							   <div class="col-md-12" style="padding: 8px" align="right">
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
	</div>

<!-- /.modal PROCEDIMIENTO-->
  
   
 		 <div class="container"> 
		  
		  		<div class="modal fade" id="VentanaProcedimiento" tabindex="-1" role="dialog">
			  
						<div class="modal-dialog" id="mdialTamanio2">

								<div class="modal-content">

								   <div class="modal-header">

									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">PROCEDIMIENTO</h4>

									</div>

								  <div class="modal-body">
								   <div class="form-group" style="padding-bottom: 10px">
									  <div class="panel panel-default">
											<div class="panel-body">

												 <textarea cols="4" rows="20" id="procedimiento" name="procedimiento" class="form-control">Procedimiento</textarea>

												  <div id="GuardaProcedimiento">  </div> 
												  
											      <hr> 
												  
												 <textarea cols="4" rows="3" readonly class="form-control">Tip 1: Para colocar salto linea agregar el comando  <br>, Tip 2: para agregar negrita colocar dentro del titulo <b>TITULO</b>
												 </textarea>
												   
										</div>
									 </div>   
									 <div class="modal-footer" style="padding: 1px">
										 
										 <button type="button" class="btn btn-sm btn-success" id='guardaproce'>Guardar</button>
										 
										 <button type="button" class="btn btn-sm btn-danger" id='salirtarea' data-dismiss="modal">Salir</button>
									 </div>
									 </div>
								  </div>
							  </div>

							 <!-- /.modal-content --> 
					  </div>
		 		 <!-- /.modal-dialog -->
	  		</div><!-- /.modal -->
   	  </div>   


  <!-- Page Footer-->
    <div id="FormPie"></div>  

 </div>   
 </body>
</html>
 