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
 
 	<script type="text/javascript" src="../js/ven_interes.js"></script> 
 
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
 </style>
	
	<script type="text/javascript" src="../js/campana.js"></script>
	
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
 	       
		
		<div class="row">
		
        <div class="col-md-3">
            <a href="#" class="btn btn-danger btn-sm btn-block" onClick="goToURL();"  role="button" data-toggle="modal" data-target="#myModal">
				<i class="glyphicon glyphicon-edit"></i> Tarea </a>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"> Nro Tramites </a>
                </li>
				<li><a href="#" onClick="javascript:BusquedaGrilla('','3');"><b>Potenciales Clientes</b></a></li>
                <li><a href="#" onClick="javascript:BusquedaGrilla('','4');">Interesado En espera</a></li>
                <li><a href="#" onClick="javascript:BusquedaGrilla('','5');">Interesado sin confirmar</a></li>
				 <li><a href="#" onClick="javascript:BusquedaGrilla('','0');">No esta interesado</a></li>
               </li>
             </ul>
        </div>
		
			 
		
      <div class="col-md-9">
			
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Bandeja de Entrada</a></li>
                
                <li><a href="#messages" data-toggle="tab"><span class="glyphicon glyphicon-tags"></span>
                    Historial</a></li>
               
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
	
	
	
    <div id="FormPie"></div>  
 </div>   
	
 </body>
</html>
