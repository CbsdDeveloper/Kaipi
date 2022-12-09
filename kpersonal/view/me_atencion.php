<?php
session_start();
require '../controller/perfil_pantalla.php';
$usuario = ver_perfil($_SESSION['usuario'],45);
	if ($usuario== 0)  {
		header('Location: inicio');
    } 
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/me_atencion.js"></script> 
	
</head>

<body>
	
 <div id="main">
	
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
 	
  <!-- ------------------------------------------------------ -->  
 <div class="col-md-12"> 
      
       		 <!-- Content Here -->
	 
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
 							<span class="glyphicon glyphicon-th-list"></span> <b> ATENCION MEDICA</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Ficha Medica del Personal </a>
                  		</li>
     
                         <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Documentos Complementarios</a>
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
	  		  	         
		  		  	         <div class="col-md-12"> 
                                
  									  <div class="alert alert-info">
										   
 									    	<div class="row">
												
												<div class="col-md-3"  style="padding-top: 5px;">
													<select name="qunidad"  id="qunidad" class="form-control required">
													</select>
											   </div> 
												
										 
												
											  <div class="col-md-2"  style="padding-top: 5px;">
												<select name="qestado"  id="qestado" class="form-control required">
															 <option value="solicitado">Solicitado</option>
															 <option value="atendido">Atendido</option>
												</select>
											   </div> 
											   <div class="col-md-2"  style="padding-top: 5px;"> 
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
												   
												   <button type="button" class="btn btn-sm btn-info" id="excelload"><i class="glyphicon glyphicon-download-alt"></i>  </button>
												   
									   			</div> 
									   		</div> 
									   	 </div> 		
  								 
 				  		     </div> 
		  		  	      
		  		  	     
			  		  	     <div class="col-md-12"> 
								 
 								 
								  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
										 <thead  bgcolor=#F5F5F5>
										   <tr>   
											   <th  width="5%">Nro.</th>
											   <th  width="10%">Fecha</th>
											   <th  width="5%">Hora</th>
												<th width="20%">Paciente</th>
											    <th width="5%">Edad</th>
												<th width="5%">T.Sangre</th>    
												<th width="20%">Motivo</th>
												<th width="10%">Presion</th>
												<th width="10%">Acciones</th>
										   </tr>
										</thead>
								 </table>
								 
                             </div>  
							  
							  
							
                         </div>  
                     </div> 
             </div>
           
                 <!-- ------------------------------------------------------ -->
                 <!-- Tab 2 -->
                 <!-- ------------------------------------------------------ -->
           
                <div class="tab-pane fade in" id="tab2">
								 
								<div class="panel panel-default" style="padding: 1px">
									
										<div class="panel-body" style="padding: 1px"> 
											
											 <!-- FORMULARIO DE INFORMACION DE INGRESO -->
											
											
											<div class="alert alert-success">
														  <strong>TIPS!</strong></br> 1. Para crear un registros presione el icono + NUEVO, complete la informacion base.	</br>
									2. Guarde la informacion con el icono guardar (color naranja)</br> 3. Ingrese las novedades y el detalle medico.</div>

											 <div id="ViewForm"> </div>

											 <div class="col-md-12" style="padding: 20px;padding-left: 50;padding-right: 50px">
												
												 
												  <!-- FORMULARIO DE DETALLE INFORMACION DE INGRESO -->
												 
												   <ul class="nav nav-pills">
													  
														<li class="active"><a data-toggle="tab" href="#home"><b>1. SIGNOS VITALES</b></a></li>
													   
														<li><a data-toggle="tab" href="#menu1"><b>2. ANTECEDENTES PERSONALES</b></a></li>
													   
														<li><a data-toggle="tab" href="#menu2">3. ANTECEDENTES FAMILIARES</a></li>
													   
														<li><a data-toggle="tab" href="#menu3">4. EXAMEN FISICO</a></li>
													   
													   <li><a data-toggle="tab" href="#menu4">5. MEDICAMENTOS RECETADOS</a></li>
 													   
													   <li><a data-toggle="tab" href="#menu5">7. INFORMACION ADICIONAL</a></li>
													  
													   
													  </ul>

												 
											
												 
													  <div class="tab-content">
														  
														<div id="home" class="tab-pane fade in active">
 															  
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewSignos"> </div>

																	</div>	 
															
																 
															
														</div>
														  
														  
														<div id="menu1" class="tab-pane fade">
														  
																  <div class="col-md-12" style="padding: 20px">
																	 <button type="button" class="btn btn-info btn-sm" onclick="LimpiaAntecedentes()"><span class="glyphicon glyphicon-user"> Agregar</span></button>
																  </div>	 
															
																 	 <div class="col-md-7" style="padding: 20px">

																		<div id="ViewGrillaActividades"> </div>

																	</div>	 
															
																     <div class="col-md-5" style="padding: 20px">
																		 
																		   <H4>Habitos Paciente</H4>
																		 
 																		  <label><input type="checkbox" id="myCheck1" onclick="myFunction(1,this)" > Consume Licor Frecuentemente</label><br>

 																		  <label><input type="checkbox" id="myCheck2" onclick="myFunction(2,this)" > Fuma Frecuentemente</label><br> 	 
																		
																		  <label><input type="checkbox" id="myCheck3" onclick="myFunction(3,this)" > Realiza Actividad Física</label><br> 	 
																		
																		  <label><input type="checkbox" id="myCheck4" onclick="myFunction(4,this)" > Toma medicina frecuentemente</label> <br>	 
																		 
																		
																		  <label><input type="checkbox" id="myCheck5" onclick="myFunction(5,this)" > Duerme al menos ocho horas al día</label> <br>	
																		
																	</div>	 
															
														</div>
														  
														  
													    	<div id="menu2" class="tab-pane fade">
														
																 <div class="col-md-12" style="padding: 20px">
																		  <button type="button" class="btn btn-info btn-sm" onclick="LimpiaFamilia()"><span class="glyphicon glyphicon-sunglasses"> Agregar</span></button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewGrillaFamilia"> </div>

																	</div>	 
															
														</div>
														  
												  		    <div id="menu3" class="tab-pane fade">
  															
																	<div class="col-md-12" style="padding: 20px">

																		 <div class="panel-body">
																			 <label style="padding-top: 5px;text-align: right;" class="col-md-2">EXAMEN FISICO</label>
																			 <div style="padding-top: 5px;" class="col-md-10">
																				 <textarea name="examen_fisico" class="auto form-control" cols="550" rows="4" maxlength="550" required="required" id="examen_fisico" placeholder="EXAMEN FISICO"></textarea>
																			 </div>
																			 
																			 <label style="padding-top: 5px;text-align: right;" class="col-md-2">REVISION ACTUAL DE ORGANOS Y SISTEMAS</label>
																			 <div style="padding-top: 5px;" class="col-md-10">
																				 <textarea name="revision_organos" class="auto form-control" cols="550" rows="4" maxlength="550" required="required" id="revision_organos" placeholder="REVISION ACTUAL DE ORGANOS Y SISTEMAS">
																				 </textarea>
																			 </div>
																			  
																		</div>

																	</div>	 
														</div>
														  
														  	  
												 	    	<div id="menu4" class="tab-pane fade">
														  
																 <div class="col-md-12" style="padding: 20px">
																		 	  <button type="button" class="btn btn-info btn-sm" onclick="LimpiarReceta()"><span class="glyphicon glyphicon-tags"> Agregar</span></button>
																  </div>	 
															
																	<div class="col-md-12" style="padding: 20px">

																		<div id="ViewGrillaReceta"> </div>

																	</div>	 
															
														</div>
														  
 														  
														    <div id="menu5" class="tab-pane fade">
  															
																	<div class="col-md-12" style="padding: 20px">

																		 <div class="panel-body">
																			 <label style="padding-top: 5px;text-align: right;" class="col-md-2">INFORMACION</label>
																			 <div style="padding-top: 5px;" class="col-md-10">
																				 <textarea name="comentario" class="auto form-control" cols="550" rows="4" maxlength="550" required="required" id="comentario" placeholder="COMENTARIO/ADICIONAL"></textarea>
																			 </div>
																			 
																			  
																			  
																		</div>

																	</div>	 
														</div>
														  
														  
													  </div>

												 
												
											 
												
											 </div>

									   </div>
								  </div>

							 </div>
			   
               
              			   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
					 
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
								
								
								 <div class="col-md-9"> 
								
												<div class="panel panel-info">
												  <div class="panel-heading">Documentos complementarios</div>
													<div class="panel-body"> 
														<button type="button" class="btn btn-sm btn-info" id="loadDoc" >  
														  Agregar Documentos funcionario</button>	

														 <button type="button" class="btn btn-sm btn-warning" id="loadContrato"   >  
														  Historial de Contratos</button>	
														
														
														 <button type="button" class="btn btn-sm btn-success" id="loadTeletrabajo"   >  
														  Autorizar Teletrabajo</button>	

													</div>
												  </div>
                                
												 <div class="panel panel-info">
												  <div class="panel-heading">Detalle de Documentos</div>
													<div class="panel-body"> 
														<div id="ViewFormfile"> </div>
													</div>
												  </div>
						  		  
												 <div class="panel panel-default">
													  <div class="panel-heading">Historial Laboral</div>
														<div class="panel-body"> 
															<div id="ListaFormContrato"> </div>
														</div>
												 </div>
									 
									 			<div class="panel panel-default">
													  <div class="panel-heading">Historial TeleTrabajo</div>
														<div class="panel-body"> 
															<div id="ListaFormtele"> </div>
														</div>
												 </div>
									  </div>
						   
               		       </div>
                	  </div>
             	 </div>          
               
               
          	 </div>
		   
</div>
 
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
	
    

	<div class="modal fade" id="myModalAntecedentes" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ANTECEDENTES PERSONALES</h4>
		   </div>
			   <form action="../model/Model_me_atencion02.php" method="POST" id="fo33"   name="fo33" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewAntecedente"> var</div> 


											   <div id="guardarAntecedente" style="padding: 5px;" align="center"></div>   
										
										
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



	<div class="modal fade" id="myModalFamilia" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ANTECEDENTES FAMILIARES</h4>
		   </div>
			   <form action="../model/Model_me_atencion03.php" method="POST" id="fo44"   name="fo44" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFamilia"> var</div> 


											   <div id="guardarFamilia" style="padding: 5px;" align="center"></div>   
										
										
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



<div class="modal fade" id="myModalReceta" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">MEDICAMENTO RECETADO</h4>
		   </div>
			   <form action="../model/Model_me_atencion04.php" method="POST" id="fo45"   name="fo45" enctype="multipart/form-data" accept-charset="UTF-8"> 
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   			  	   <div id="ViewReceta"> var</div> 
  				
							   </div>
							  
							    <div class="col-md-12">
									  <div id="ViewUso" style="padding: 5px;" align="center"></div>   
								 </div>	
									
							     <div class="col-md-12">
								    <div id="guardarReceta" style="padding: 5px;" align="center"></div>   
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


  <!-- Page Footer-->
    <div id="FormPie"></div>  

 </div>   
 </body>
</html>
