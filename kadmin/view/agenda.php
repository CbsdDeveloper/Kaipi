<?php 
session_start( );  
	 
	require 'SesionInicio.php';   /*Incluimos el fichero de la clase Db*/
 
 
   $ruc_registro= $_SESSION['ruc_registro'];
 	
   if (isset($_POST["asunto"])) 
	{

			 $mensaje      = @$_POST["asunto"];
			 $fecha_asunto = @$_POST["fecha_asunto"];
			 $hora_asunto  = @$_POST["hora_asunto"];
			 $tipo_asunto  = @$_POST["tipo_asunto"];
	   	     $usuarioc     = @$_POST["usuarioc"];

			 $mensaje   = (trim($mensaje));


			 if (!empty($mensaje)){

					  $sesion 	 = $_SESSION['login'];


				// $timestamp = date('Y-m-d G:i:s');

				  $Avalida = $bd->query_array('web_chat_directo',
							'count(*) ya',
							'sesion='.$bd->sqlvalue_inyeccion( $sesion ,true). ' and 
							 registro='.$bd->sqlvalue_inyeccion( $ruc_registro ,true). ' and 
							 mensaje='.$bd->sqlvalue_inyeccion($mensaje,true)
							);

						$carpeta = $Avalida['ya'];

					   if ( $carpeta == 0) {

							 $cadena = "to_date('".$fecha_asunto."','yyyy/mm/dd')";

						  $sql = "INSERT INTO web_chat_directo( sesion, modulo,mensaje ,tipo,hora, para,registro,estado,fecha) values (".
									  $bd->sqlvalue_inyeccion($sesion, true).",".
									   $bd->sqlvalue_inyeccion('agenda', true).",".
									   $bd->sqlvalue_inyeccion($mensaje, true).",".
									   $bd->sqlvalue_inyeccion(trim($tipo_asunto), true).",".
							           $bd->sqlvalue_inyeccion($hora_asunto, true).",".
							   		  $bd->sqlvalue_inyeccion($usuarioc, true).",".
							          $bd->sqlvalue_inyeccion($ruc_registro, true).",".
									  $bd->sqlvalue_inyeccion('A', true).",".$cadena.")";   

						  $bd->ejecutar($sql);



						 }

			  }
	     }
	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
    <script type="text/javascript" src="../js/agenda.js"></script>
    
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
 
</head>

<body>

 <div id="main">
	
	<div class="col-md-12" role="banner">
 	   <div id="NavMod"></div>
 	</div> 
	
  
   <div class="col-md-12"> 
		
       <!-- Content Here -->
		 <div class="col-md-4">
			 
			  <div class="col-md-12" style="background-color:#e0ea46;">
				  
					 <div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i> Crear Recordatorio</h4>
							</div>
							<div class="widget-content">
								 <div class="col-md-12" style="padding: 25px">
									 
								<form class="form-horizontal row-border" id="validate-1" action="agenda" method="post">
									
									
 										<label class="col-md-3 control-label">Asunto</label>
										<div class="col-md-9" style="padding: 3px">
											<textarea rows="2" cols="5" required name="asunto" id="asunto" class="form-control"></textarea>
										</div>
 
 										<label class="col-md-3 control-label">Fecha/Hora</label>
										<div class="col-md-9"  style="padding: 2px">
											<div class="col-md-7" style="padding:1px">
												<input type="date" name="fecha_asunto" id="fecha_asunto" required min="<?php  echo date("Y-m-d");?>"  class="form-control" value="<?php echo date("Y-m-d");?>" >
											</div>
											<div class="col-md-5" style="padding:1px">
												<input type="time" name="hora_asunto" id="hora_asunto"   required class="form-control" >
											</div>	
										</div>
 									
									
 										<label class="col-md-3 control-label">Tipo <span class="required">*</span></label>
										<div class="col-md-9"  style="padding: 3px">
											<select name="tipo_asunto"  onChange="listaEmail(this.value)" class="form-control required">
												<option value=""></option>
												<option value="privado">privado</option>
												<option value="publico">publico</option>
 											</select>
										</div>
									
									  <label class="col-md-3 control-label">Usuario</label>
										<div class="col-md-9"  style="padding: 3px">
											<select name="usuarioc" id="usuarioc" class="form-control">
   											</select>
										</div>
									
									 <label class="col-md-3 control-label">  <span class="required"></span></label>
 									    <div class="col-md-9"  style="padding: 3px">
										 
										</div>
									
							 		<div class="form-actions" style="padding: 5px">
										<input type="submit" value="Crear" class="btn btn-primary  btn-sm pull-right">
									</div>
								</form>
								 </div>
							</div>
						</div>
				  
			  </div>
			 
		 </div>
		
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
										
										 <div id="enviado"></div> 
 
									 </div>   
							  </div>
							  <div class="modal-footer">
								 
								<button type="button" onClick="EnviarCorreo()" class="btn btn-sm btn-info" data-dismiss="modal">Recordar</button>  
								  
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							  </div>
					 </div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </div>  

	
	
	
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
    </div>   
</body>
</html>