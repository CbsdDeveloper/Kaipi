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
 
 	<script type="text/javascript" src="../js/nom_ingreso.js"></script> 
	
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
 							<span class="glyphicon glyphicon-th-list"></span> <b> Nòmina de Personal</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Ficha Personal Talento Humano</a>
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
												
												<div class="col-md-3"  style="padding-top: 5px;">
													<select name="qregimen"  id="qregimen" class="form-control required">
													</select>
											   </div> 
												
											  <div class="col-md-2"  style="padding-top: 5px;">
												<select name="qestado"  id="qestado" class="form-control required">
															 <option value="S">Activo</option>
															 <option value="N">Desactivo</option>
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
												<th  width="10%">Identificación</th>
												<th width="20%">Nombre</th>
												<th width="20%">Cargo</th>
												<th width="15%">Email</th>    
												<th width="10%">Ingreso</th>
												<th width="8%">Año(s)</th>
												<th width="7%">Remuneración</th>
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
           
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
					 
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						    
						  		   
								<div id="ViewForm"> </div>
						   
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
	
    <div class="modal fade" id="myModalCarga" role="dialog">
	
 			 <div class="modal-dialog" id="mdialTamanio1">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cargas Familiares y/o Retencion Judicial </h4>
        </div>
        <div class="modal-body">
         
 					<form id="forma_carga" action="../model/Model-nom_ingreso_carga.php" method="post" name="forma_carga">
					 <fieldset>
					 <label style="padding-top: 12px;text-align: right;" class="col-md-3">Identificacion</label>
					 <div   style="padding-top: 5px;" class="col-md-9">	
						  <input name="idprov_carga" id="idprov_carga" type="text" required="required" class="form-control" size="13" maxlength="13"  />
					 </div>	
						
						
					  <label style="padding-top: 12px;text-align: right;" class="col-md-3">Nombre</label>
					  <div  style="padding-top: 5px;" class="col-md-9">	
						  <input name="nombre_carga" id="nombre_carga" type="text" required="required" class="form-control" placeholder="Nombre Beneficiario" size="50" maxlength="50"/>
					 </div>	
						
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Año Nacimiento</label>	
					  <div  style="padding-top: 5px;" class="col-md-9">	
						  <input name="anio_carga" id="anio_carga" type="number" required="required" class="form-control" max="2019" min="1985" size="30" />
					 </div>	
						
					
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Retencion Judicial?</label>		
					  <div  style="padding-top: 5px;" class="col-md-9">	
						  <select name="retencion_carga"  id="retencion_carga" required="required" class="form-control">
						  <option value="N">NO</option>
						  <option value="S">SI</option>
						</select> 
					   </div>		  
						  
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Monto Retencion</label>	
					  <div   style="padding-top: 5px;" class="col-md-9">		
					<input name="monto_carga" type="number" required="required" class="form-control" id="monto_carga"  >   </div>	
						
					 	<label style="padding-top: 12px;text-align: right;" class="col-md-3"></label>	
						   <div   style="padding-top: 5px;" class="col-md-9">
								<input  class="btn btn-warning btn-sm" name="mysubmit" type="submit" value="Guardar" /> 
					       </div>	
					</fieldset>	 
				</form> 
				
				<div id="result_carga"></div>
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
	  <script language="javascript">
		  
 
	
		$(document).ready(function() {
 
			$('#forma_carga').submit(function() {
		  // Enviamos el formulario usando AJAX
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					// Mostramos un mensaje con la respuesta de PHP
					success: function(data) {
						$('#result_carga').html(data);
					}
				})        
				return false;
			});
	       
		}); 
 
		 </script>
	  
	  
    </div>
	
   </div>	
	
	
	<div class="modal fade" id="myModalContrato" role="dialog">

	  <div class="modal-dialog" id="mdialTamanio">

		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Historial</h4>
			</div>
			<div class="modal-body">
			  <p>
				 <div id="ViewFormContrato"> </div>
			  </p>
			</div>
			<div class="modal-footer">

				 <button type="button" class="btn btn-success" onClick="GenerarHistorial()" data-dismiss="modal">Procesar Informacion</button>

			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  
		  </div>

		</div>
  </div>
	


	<div class="modal fade" id="myModalTrabajo" role="dialog">

	  <div class="modal-dialog" id="mdialTamanio3">

		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Autorización Teletrabajo</h4>
			</div>
			<div class="modal-body">
			 
				
				<div class="input-group" style="padding: 5px">		
				  <span class="input-group-addon">Funcionario</span>
				  <input id="fun_tele" type="text" class="form-control" name="fun_tele" readonly>
				</div>
				
				
				<div class="input-group" style="padding: 5px">		
				  <span class="input-group-addon">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <input id="fecha_tele" type="text" class="form-control" name="fecha_tele" placeholder="Fecha">
				</div>
				
				<div class="input-group" style="padding: 5px">		
				  <span class="input-group-addon">Referencia</span>
				  <input id="refe_tele" type="text" class="form-control" name="refe_tele" placeholder="Referencia">
				</div>
				
			   <div class="input-group" style="padding: 5px">		
				   <span class="input-group-addon">Motivo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				   <textarea name="motivo_tele" id="motivo_tele" class="auto form-control" cols="45" rows="4" ></textarea>
			 
				</div>
				
				<div class="input-group" style="padding: 5px">			
				  <span class="input-group-addon">Responsable</span>
			 	  	<select name="idprov_jefe" id="idprov_jefe" class="form-control">  </select>
				</div>
				
				
				<div class="input-group" style="padding: 5px">			
				  <span class="input-group-addon">Autorizado&nbsp;&nbsp;&nbsp;&nbsp;</span>
			 	 <select name="estado_tele" required="" id="estado_tele" class="form-control">
					  <option value="NO">NO</option>
					 <option value="SI">SI</option>
 					</select>
				</div>
				
				
			
				<div id="resultado_dato">  </div>
				 
				
				
			</div>
			<div class="modal-footer">

				 <button type="button" class="btn btn-success" onClick="GenerarTele()" >Procesar Informacion</button>

			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  
		  </div>

		</div>
  </div>
	
  <!
  <!-- Page Footer-->
    <div id="FormPie"></div>  

 </div>   
 </body>
</html>
