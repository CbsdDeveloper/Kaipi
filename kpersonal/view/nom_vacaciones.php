<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	 <script type="text/javascript" src="../js/nom_vacaciones.js"></script> 
	
 

 
 	 		 
</head>
<body>
 <!-- ------------------------------------------------------ -->
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
 							<span class="glyphicon glyphicon-th-list"></span> <b> Resumen Personal - Vacaciones</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle Mensual de Permisos y Vacaciones</a>
                  		</li>
	 
	 					<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-bed"></span> Formulario Permiso y Vacaciones</a>
                  		</li>
     
                         <li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Cronograma Planificacion de Vacaciones</a>
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
													<select name="qoperativo"  id="qoperativo" class="form-control required">
													     <option value="-">-- Unidades de Gestión</option>
														 <option value="ADMIN">Personal Administrativo</option>
														 <option value="AGREGADORA DE VALOR">Personal Operativo</option>
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
											<th width="16%">Unidad</th>
										    <th width="20%">Nombre</th>
											<th width="15%">Cargo</th>
 											<th width="7%">Ingreso</th>    
											<th width="7%">Nro.Dias</th>
										    <th width="7%">Acumulados Anterior</th>
											<th width="7%">Dias Tomados</th>
										    <th width="7%">Horas Tomados</th>
										    <th width="7%">Dias Pendientes</th>
											<th width="7%">Acciones</th>
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
  								
								
								 <div class="col-md-12"> 
								
									 <div class="btn-group">
										  <button type="button" onClick="Ver_consulta(1)" class="btn btn-warning">SOLICITADOS</button>
										  <button type="button" onClick="Ver_consulta(4)" class="btn btn-primary">ENVIADOS</button>
										  <button type="button" onClick="Ver_consulta(2)" class="btn btn-info">AUTORIZADOS</button>
										  <button type="button" onClick="Ver_consulta(3)" class="btn btn-danger">ANULADOS</button>
										</div>
 								 </div>
								
								
								 <div class="col-md-12"> 
								
										<h4>Detalle de permisos por funcionario</h4>
										<div id="detalle_datos"> </div>
 								 </div>
								 
               		       </div>
                	  </div>
             	 </div>
			   
			   <input type="hidden" name="prove" id="prove">
			   
			    
               
                 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
                                  <div class="panel panel-default">
                                     <div class="panel-body"> 
                                       <div id="ViewForm"> </div>
                                    </div>
                                  </div>
						  		  
						   
               		       </div>
                	  </div>
             	 </div>          
			   
			   
			   <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
                                  <div class="panel panel-default">
                                     <div class="panel-body"> 
										 
                                        <div class="col-md-8"> 
		
		    <link href='calendario/fullcalendar.min.css' rel='stylesheet' />
			<link href='calendario/fullcalendar.print.min.css' rel='stylesheet' media='print' />
			<script src='calendario/lib/moment.min.js'></script>
 			
			<script src='calendario/fullcalendar.min.js'></script>
			<script src='calendario/locale-all.js'></script>

		   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

			 <!-- ---eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee---------------------------
			<script type="text/javascript" src="../js/calendario_seg.js"></script> 	
------------------------ -->
			<script>
			  
				 $(document).ready(function() {
 
					    var today = new Date();
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!

						var yyyy = today.getFullYear();

						if(dd < 10){
							dd='0'+ dd
						} 
						if(mm < 10){
							mm='0'+ mm
						} 

						var fecha = yyyy + '-' + mm + '-' + dd;

						 var cadena = '';


						 var initialLocaleCode = 'es';

									$('#calendar').fullCalendar({
										header: {
											left: 'prev,next today',
											center: 'title',
											right: 'month,agendaWeek,agendaDay,listMonth'
										},
										defaultDate: fecha,
										 locale: initialLocaleCode,
										  navLinks: true, // can click day/week names to navigate views
										  businessHours: true, // display business hours
										  editable: false,
										  defaultView: 'month',
										  weekNumbers: true,
 										  eventLimit: true, // allow "more" link when too many events
										events: {
											url: '../model/calendario_recordatorio.php',
											error: function() {
												$('#warning_c').show();
											}
										},
										   eventClick: function(event) {

											   cadena =  '<h5><b>' + event.title +'</b><br><br>' + 
														'Evento: ' + event.evento + '<br>' + 
														'Producto: ' + event.producto + '<br>' + 
														'Fecha: ' + event.start.format("DD-MM-YYYY hh:mm")
														+ '</h5>';

												
											    $('#correo_detalle').val(event.title);   
											   
											    $('#correo_fecha').val(event.start.format("DD-MM-YYYY hh:mm"));  
											   
											    $('#e_actividad').html(cadena);    
 
												$('#myModalEmail').modal('show');

											return false;
										  } 
									});


  				});
			 
			</script>
			 
			 <input type="hidden" id="correo_detalle" name="correo_detalle">	
			 <input type="hidden" id="correo_fecha" name="correo_fecha">		
			 
	        <div class="row">
 		 	
 		        		 <div id='calendar'> </div>
 					     <div id='warning_c'> </div> 
		    </div>
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
 
	
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
