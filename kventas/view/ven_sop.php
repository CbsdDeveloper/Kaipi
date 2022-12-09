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
 
 	<script type="text/javascript" src="../js/ven_pedido.js"></script> 
 
    <style type="text/css">
     #mdialTamanio{
        width: 70% !important;
       }
	#mdialTamanioCliente{
        width: 65% !important;
       }
		
		#mdialTamanioAgenda{
        width: 35% !important;
       }
		
		#mdialProducto{
        width: 75% !important;
       }
		
		
	
		body{ margin-top:50px;}
.nav-tabs .glyphicon:not(.no-margin) { margin-right:10px; }
.tab-pane .list-group-item:first-child {border-top-right-radius: 0px;border-top-left-radius: 0px;}
.tab-pane .list-group-item:last-child {border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;}
.tab-pane .list-group .checkbox { display: inline-block;margin: 0px; }
.tab-pane .list-group input[type="checkbox"]{ margin-top: 2px; }
.tab-pane .list-group .glyphicon { margin-right:5px; }
.tab-pane .list-group .glyphicon:hover { color:#FFBC00; }
a.list-group-item.read { color: #222;background-color: #F3F3F3; }
hr { margin-top: 5px;margin-bottom: 10px; }
.nav-pills>li>a {padding: 5px 10px;}

.ad { padding: 5px;background: #F5F5F5;color: #222;font-size: 80%;border: 1px solid #E5E5E5; }
.ad a.title {color: #15C;text-decoration: none;font-weight: bold;font-size: 110%;}
.ad a.url {color: #093;text-decoration: none;}
		
	#global {
	height: 390px;
	width: 100%;
	padding: 2px;
	overflow-y: scroll;
	}
		
 	#calendar {
    max-width: 900px;
    margin: 0 auto;
  }

 </style>
	
  <script>// <![CDATA[
 
  // a=jQuery.noConflict();
	 	
	$(document).ready(function() {
  		
		   // InjQueryerceptamos el evento submit
			$('#form_email').submit(function() {
				// Enviamos el formulario usando AJAX
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					// Mostramos un mensaje con la respuesta de PHP
					success: function(data) {

							$('#mensaje_enviado').html(data);

					}
				})        
				return false;
			}); 
	//-----------------------
 }); 
</script>	
	
	

	
</head>
<body>

<!-- ------------------------------------------------------ -->

<div id="mySidenav" class="sidenav">
 
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 
 </div>
 
<!-- ------------------------------------------------------ -->
<div id="main">
	
  <!-- Header -->
      <header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
 	
  <!-- ------------------------------------------------------ -->  
    <div class="col-md-12" style="padding-top: 55px"> 
		
		<div class="row">

			<div class="col-sm-3 col-md-2">
						<div class="btn-group">
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								Acciones <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" data-toggle="modal" data-target="#myModalAgenda">Recordatorio</a></li>
 							</ul>
						</div> 
			</div>

			 <div class="col-md-9">

				<!-- Split button -->
				<div class="btn-group">

					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
				<!--		<li><a href="#">All</a></li>
						<li><a href="#" onClick="javascript:BusquedaGrilla('Cumplimiento en proceso','');">Cumplimiento en proceso</a></li>
						<li><a href="#" onClick="javascript:BusquedaGrilla('Cumplimiento Parcial','');">Cumplimiento Parcial</a></li>
						<li><a href="#" onClick="javascript:BusquedaGrilla('Cumplimiento Total','');">Cumplimiento Total</a></li>
						<li><a href="#" onClick="javascript:BusquedaGrilla('No cumplimiento','');">No cumplimiento</a></li>-->
						<li><a href="#" data-toggle="modal" data-target="#myModalCiu" onClick="goToURLCIU();">Actualizacion Clientes</a></li>
						<li><a href="#" onClick="javascript:BusquedaGrilla('No aplica','');">No aplica</a></li>
					 </ul>
				</div>


				<button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh" onClick="location.reload()">
					&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;
				 </button>
				

				<div class="pull-right">
					<span class="text-muted" id="nombre_actual"><b>[ Seleccionar cliente ] </b></span>
					<div class="btn-group btn-group-sm">
						<button type="button" class="btn btn-default" onClick="javascript:PaginaGrilla(-1)">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</button>
						<button type="button" class="btn btn-default" onClick="javascript:PaginaGrilla(1)">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</button>
					</div>
				</div>  

			</div>
		</div>
		<hr>
 	       
			<!--   -->
			<!-- estado de bandeja de entrada -->
			<!--   -->
		<div class="row">
		
        <div class="col-md-3">
            <a href="#" class="btn btn-danger btn-sm btn-block" onClick="goToURL();"  role="button" data-toggle="modal" data-target="#myModal">
				<i class="glyphicon glyphicon-edit"></i> Tarea </a>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"> Nro Tramites </a>
                </li>
				<li><a href="#" onClick="javascript:BusquedaGrilla('','8');"><b>Solicitud Pendiente</b></a></li>
                <li><a href="#" onClick="javascript:BusquedaGrilla('','9');">Solicitud Ejecucion</a></li>
				<li><a href="#" onClick="javascript:BusquedaGrilla('','9');">Solicitud Finalizados</a></li>
 			    <li><a href="#" onClick="javascript:BusquedaGrilla('','0');">Anulados</a></li>
               </li>
             </ul>
        </div>
	 
		<!--   -->
			<!-- taba de informacion-->
			<!--   -->	 
		
      <div class="col-md-9">
			
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="mytabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Bandeja de Entrada</a></li>
                
                <li><a href="#messages" data-toggle="tab"><span class="glyphicon glyphicon-tags">
				</span>  Historial </a></li>
				
				 <li><a href="#femail" data-toggle="tab"><span class="glyphicon glyphicon-earphone">
				</span>  Notificaciones via electronica</a></li>
				
				 <li><a href="#fagenda" data-toggle="tab"><span class="glyphicon glyphicon-alert">
				</span>  Mi Agenda</a></li>
				
				<li><a href="#fproductos" data-toggle="tab"><span class="glyphicon glyphicon-apple">
				</span>  Generar Pedido</a></li>
				
				<li><a href="#fdoc" data-toggle="tab"><span class="glyphicon glyphicon-file">
				</span>  Documentos</a></li>
               
            </ul>
			
			
            <!-- Tab panes -->
        <div class="tab-content">
 				
                <div class="tab-pane fade in active" id="home">
					
                   <div class="list-group" id = "BandejaDatos">  </div>
					
                </div>
				
                <div class="tab-pane fade in" id="messages">
						<div class="col-md-12"> 
								<div class="col-md-7"> 
										<div id = "BandejaHistorial">  </div>	
								</div> 
					
							  <div class="col-md-5"> 
							  <h5>Avance </h5>
											 <div class="row">
												<div class="progress">
															  <div id="ViewAvance"> </div>
												</div>	 

											  </div> 

								</div> 
 						</div> 
                </div>
			<!--   -->
			<!-- correo  -->
			<!--   -->
			 <div class="tab-pane fade in" id="femail">
				 
				  <div class="col-md-12"> 
				 
				        <div class="col-md-8"> 
					   	  
							   <form action="../model/EnvioEmail.php" method="post" enctype="application/x-www-form-urlencoded" id="form_email" accept-charset="UTF-8">

									  <div class="col-md-10" style="padding: 7px">  
										<div class="form-group">
										   <input name="bnuevo" type="button" onClick="limpiaEmail()" class="btn btn-default btn-sm" id="bnuevo" value="Nuevo"> &nbsp; 
										   <input type="submit" class="btn btn-default btn-sm">
										</div>		
									 </div>

									 <div class="col-md-10">  
												 <div class="form-group">
													  <input name="temail" type="email" readonly class="form-control" id="temail" placeholder="Email">
												   </div>
													<div class="form-group">
													  <input name="tasunto" type="text" required="required" class="form-control" id="tasunto" placeholder="Asunto">
													</div>
									 </div>  

										   <div class="col-md-12">
												 <div id="mensaje_enviado"></div> 
										   </div>   


									 <div class="col-md-12">
												 <textarea cols="80" id="editor1" name="editor1" rows="5" > </textarea>
									  </div> 
									 <script src="../../keditor/ckeditor/ckeditor.js"></script>
									 <script>
															CKEDITOR.replace( 'editor1', {
																height: 250,
																width: '90%',
															} );
												 </script>

										<input name="idtransaccion" type="hidden" id="idtransaccion" value="0">	
									    <input name="para_email" type="hidden" id="para_email" value="">	

								  </form>
                 		     </div> 	
				 
				  			 <div class="col-md-4"> 
								  <div class="col-md-12" style="padding: 10px">  
									    <h5>Envio WhatsApp</h5>
												  <div class="form-group">
													  <input name="tfono" type="text"   class="form-control" id="tfono" placeholder="593"><br>
													  <input name="bnuevow" type="button" onClick="EnviarWhatsapp()" style="font-size:12px;padding:5px 12px;border-radius:5px;background-color:#189D0E;color:white;text-shadow:none;"id="bnuevow" value=">> Enviar"> 
												   </div>
 									 </div>  
								 	  <div class="col-md-12">  
  										  <h5>Bandeja de Enviados</h5>
											 <div class="row">
												 <div id="lista_enviados">  </div> 
											  </div> 
									 </div> 	  
                  			 </div> 
			    </div> 	 
			 </div>
			
			
			
			
			
			<link href='calendario/fullcalendar.min.css' rel='stylesheet' />
			<link href='calendario/fullcalendar.print.min.css' rel='stylesheet' media='print' />
			<script src='calendario/lib/moment.min.js'></script>
 			
			<script src='calendario/fullcalendar.min.js'></script>
			<script src='calendario/locale-all.js'></script>

			 <!-- ------------------------------
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
										  defaultView: 'listMonth',
										  weekNumbers: true,
 										  eventLimit: true, // allow "more" link when too many events
										events: {
											url: '../model/calendario_seg.php',
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

												$('#e_actividad').html(cadena);    
 
												$('#myModalEmail').modal('show');

											return false;
										  } 
									});


  				});

 
			</script>
			<div class="tab-pane fade in" id="fagenda">
				
				  <div class="panel panel-default">
 				<div class="panel-body" > 
					 <h4>Calendario Personal</h4>
 					  
				   <div class="col-md-10"> 
 					     <div id='calendar'> </div>
 					     <div id='warning_c'> </div>
                   </div> 		
			      
               </div>
           </div>
				
			 </div>
			
			  <!-- mensaje -->
			
			<div class="tab-pane fade in" id="fproductos">
				
				<div class="panel panel-default">
 				<div class="panel-body" > 
  					       <h4>Detalle de productos ofertados</h4>
 					       <div class="col-md-10">  
						    <div class="form-group">
								<button type="button" 
										 class="btn btn-info" onClick="limpiaProducto();"
										 title="Ingresar producto ofertar"
										  data-toggle="modal" data-target="#myModalProducto"> 
										 <span class="glyphicon glyphicon-edit"></span>  
								   </button>
 						      
					        </div>		
				         </div>
					
					     <div class="col-md-10"> 
					      <table id="jsontable_producto" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
											<th width="10%">Fecha</th>
											<th width="10%">Codigo</th>
											<th width="20%">Producto</th>
										    <th width="35%">Detalle</th>
											<th width="15%">Responsable</th>    
 											<th width="10%">Acciones</th>
									   </tr>
									</thead>  
							 </table>
                        </div> 		
			      
               </div>
           </div>
				
			 </div>
			
			  <!-- DOCUMENTOS -->
			
			<div class="tab-pane fade in" id="fdoc">
				
				<div class="panel panel-default">
 				<div class="panel-body" > 
  					       <h4>Detalle de documentos</h4>
 					       <div class="col-md-10">  
						     <div class="form-group">
						    
							<button type="button"   onClick="llamadoc()" class="btn btn-info btn-sm" id="bnuevo" >  <span class="glyphicon glyphicon-edit"></span>  
						       </button>
								 
							<button type="button"   onClick="Grilladoc()" class="btn btn-default btn-sm" id="bprunter" >  <span class="glyphicon glyphicon-refresh"></span>  
						       </button>	 
								 
					        </div>		
				         </div>
					
					     <div class="col-md-10"> 
					      <table id="jsontable_doc" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
										 	<th width="10%">Codigo</th>
										    <th width="10%">Fecha</th>
											<th width="50%">Documento</th>
										  	<th width="20%">Responsable</th>    
 											<th width="10%">Acciones</th>
									   </tr>
									</thead>  
							 </table>
                        </div> 		
			      
               </div>
           </div>
				
			 </div>
			
			  
                
          <input name="idcliente" type="hidden" id="idcliente" >
		  <input name="nombre" type="hidden" id="nombre" >
		  
         
			
			
		  <input name="pag" type="hidden" id="pag" value="0">
		  <input name="estado1" type="hidden" id="estado1">
		   
        </div>
    </div>
</div>
    
	</div>  
	
	
	<div class="container"> 
	  <div class="modal fade" id="myModalCiu" tabindex="-1" role="dialog">
  	     <div class="modal-dialog" id="mdialTamanioCliente">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Actualizacion Clientes</h5>
		  </div>
				  <div class="modal-body">
 			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
							    <div class="row">
 					  				 <div id="ViewFormProv"> var</div> 
 				  		     		  <div id="guardarCliente" ></div> 
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
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	    <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Actividades</h5>
		  </div>
				  <div class="modal-body">
 			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFormCliente"> var</div> 
 				  		  
 				  		  
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
	
	<!-- /.modal --><!-- /.modal -->
	<!-- /.modal -->
<div class="container"> 
	  <div class="modal fade" id="myModalAgenda" tabindex="-1" role="dialog">
  	    <div class="modal-dialog" id="mdialTamanioAgenda">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Agregar Recordatorio</h5>
		  </div>
				  <div class="modal-body">
 			          <div class="panel panel-default">
 							 <div class="panel-body">
								 
								  			<div class="form-group" >
 												<div class="col-md-12"   style="padding: 2px"><textarea rows="2" cols="5" name="textarea" class="auto form-control"> </textarea></div>
											</div>
								 
 										   <div class="form-group" >
 												<div class="col-md-12"  style="padding: 2px">
													<div class="input-group">
														<input type="date" class="form-control" placeholder="Fecha Evento">
														<span class="input-group-addon"><i class="icon-time"></i></span>
													</div>
												</div>
											</div>
											<div class="form-group" >
 												<div class="col-md-12"  style="padding: 2px">
													<div class="input-group">
														<input type="time" class="form-control"  >
														<span class="input-group-addon"><i class="icon-ticket"></i></span>
													</div>
												</div>
											</div>
								 
								        <div class="form-group">
 											<div class="col-md-12"  style="padding: 2px">
											<label class="checkbox">
												<input type="checkbox" class="uniform" value=""> Envio por correo
											</label>
											 
										</div>
									</div>
									<div class="modal-footer">
				  
					 					 <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Crear Recordatorio</button>
					  
											<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				 				   </div>
								 
 							 </div>
   					 </div>
				  </div>
				  
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
  </div> 	
	
 
	<div class="container"> 
	 	 <div class="modal fade" id="myModalEmail" tabindex="-1" role="dialog">
				<div class="modal-dialog" id="mdialEmail">
						<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Actividad</h5>
							  </div>
							  <div class="modal-body">
									<div class="panel panel-default">
										
 										  <div style="padding: 10px" id="e_actividad"></div> 
 
									 </div>   
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							  </div>
					 </div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </div>  

	<!-- /.PRODUCTOS -->
	
	<div class="container"> 
	  <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
  	 	<div class="modal-dialog" id="mdialProducto">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Productos ofertados</h5>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFormProducto"> var</div> 
 				  		     <div id="guardarProducto" ></div> 
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

	
    <div id="FormPie"></div>  
 </div>   
	
 </body>
</html>
