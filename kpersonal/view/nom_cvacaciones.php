<?php
	session_start( );

  

     require '../model/resumen_panel.php';    

     $gestion   = 	new proceso;
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
	
 	<script type="text/javascript" src="../js/nom_cvacaciones.js"></script> 
	
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
                  			<span class="glyphicon glyphicon-link"></span> INFORMACION RESUMEN</a>
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
													<th width="18%">Unidad</th>
													<th width="20%">Nombre</th>
													<th width="15%">Cargo</th>
													<th width="8%">Ingreso</th>    
													<th width="8%">Saldo Anterior</th>
												    <th width="8%">Nro.Vacaciones Anual</th>
													<th width="8%">Dias Tomados</th>
													<th width="8%">Dias Pendientes</th>
													<th width="7%">Acciones</th>
											   </tr>
											</thead>
									 </table>
                             </div>  
							  
							  
							
                         </div>  
                     </div> 
             </div>
           
            
               
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
					 
					 
                          <div class="panel-body" > 

							  
<div class="col-md-12" style="padding: 10px">
   
			    <button type="button" class="btn btn-sm btn-default" id="loadprintg" title="Imprimir Presupuesto de Gasto">  
			<i class="icon-white icon-print"></i></button>	
																 
																 
																 
																  <div id="ViewForm"> </div>	

						    </div>	
 														

														     <div class="col-md-12" style="padding: 1px">
 

														 <div class="col-md-12" id="ViewFormGastos" style="padding-bottom:8;padding-top:8px"> 
  
															     <div class="col-md-12">
																 	<div class="col-md-4"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Resumen de Permisos generadas</div>
																						  <div class="panel-body">
																									   <?php     $gestion->tramites(); ?> 
																						  </div>	
																			 </div> 
																   </div>	
																	 
																	
																	 <div class="col-md-4" > 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Permisos generados por motivo</div>
																						  <div class="panel-body">
																									   <?php     $gestion->tramites_motivo(); ?> 
																						  </div>	
																			 </div> 
																   </div>	
																	  
																	 
																	 
																	 <div class="col-md-4" > 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Permisos generados por unidad</div>
																						  <div class="panel-body">
																									   <?php     $gestion->tramites_unidad(); ?> 
																						  </div>	
																			 </div> 
																   </div>	
																	  
															     </div>	
																  
																  
															 	  <div class="col-md-12">
																  
																	   <div class="col-md-4"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Resumen por mes</div>
																						  <div class="panel-body">
																							    <div   style="width:100%; height:180px;">
																									   <?php    // $gestion->tramites_certificaciones_mes(); ?> 
																						    </div>	
																						  </div>	
																			 </div> 
																	</div>	
																	  
																	   <div class="col-md-4"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Tramites de Gestion por Unidades</div>
																						  <div class="panel-body">
																							  <div  style="width:100%; height:250px;">
																										 <?php  //  $gestion->tramites_unidades(); ?> 
																											  
																						    </div>   
																							  
																									  
																						  </div>	
																			 </div> 
																	</div>	
																		
																	   <div class="col-md-4"> 
																			 <div class="panel panel-info">
																						  <div class="panel-heading">Tramites de Gestion por Funcionario</div>
																						  <div class="panel-body">
																							   <div   style="width:100%; height:250px;">
																									   <?php  //  $gestion->tramites_programa(); ?> 
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
		   
</div>
  
	
<div class="modal fade" id="myModalCarga" role="dialog">
	
	
  <div class="modal-dialog" id="mdialTamanio1">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Inicio   Saldos </h4>
        </div>
        <div class="modal-body">
         
 					<form id="forma_carga" action="../model/ajax_saldo_nomina.php" method="post" name="forma_carga">
					 
						<input type="hidden" id="idprov_funcionario" name="idprov_funcionario">
				 		
					
					
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Saldo Acumulado</label>		
					  <div  style="padding-top: 5px;" class="col-md-9">	
						   <input type="number" id='saldo_anterior' value="0.00" name='saldo_anterior'  required="required" class="form-control" placeholder="Monto" size="50" maxlength="50">
					   </div>		  
						  
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Derecho Vacaciones Actuales</label>	
					  <div   style="padding-top: 5px;" class="col-md-9">		
					<input name="dias_derecho" type="number" required="required" class="form-control" id="dias_derecho" value ="30"  >   </div>	
						
						
						<label style="padding-top: 12px;text-align: right;color: #D20003" class="col-md-3">(-) Ajuste dias Tomados</label>	
					  <div   style="padding-top: 5px;" class="col-md-9">		
					<input name="ajuste" type="number" required="required" class="form-control" id="ajuste" value ="0.00"  >   </div>	
						
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
						
						BusquedaGrilla(oTable);
					}
				})        
				return false;
			});
	       
		}); 
 
		 </script>
	  
	  
    </div>
  </div>	
	
 
  <!-- Page Footer-->
    <div id="FormPie"></div>  

 </div>   

 </body>

</html>
