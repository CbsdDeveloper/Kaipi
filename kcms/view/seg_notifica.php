<?php
	session_start( );

    require('../model/Model-seg_permiso.php');

	$gestion   = 	new proceso($_SESSION['email']);

    if ( $gestion->_get('solicitud') == 'N'){
		  echo '<meta HTTP-EQUIV="REFRESH" content="0; url=inicio">';
	 }
	
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
<title>Plataforma de Gestión Empresarial</title>
	
<?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/seg_notifica.js"></script> 
    
 <style type="text/css">  
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
	
 #mdialTamanio{
  width: 80% !important;
}
  	 
   </style>

</head>
<body>
 

<div id="main">
	<!-- Header -->
	 <div class="container">
      <div class="row">
			
		<div class="col-sm-3 col-md-2">
				<!--	<div class="btn-group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							Acciones <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Recordatorio</a></li>
							<li><a href="#">Tarea</a></li>
						</ul>
					</div> -->
	    </div>
	    
		 <div class="col-sm-9 col-md-10">
        
			<!-- Split button -->
            <div class="btn-group">
                
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">All</a></li>
					<li><a href="#" onClick="javascript:BusquedaGrilla('Cumplimiento en proceso','');">Cumplimiento en proceso</a></li>
                    <li><a href="#" onClick="javascript:BusquedaGrilla('Cumplimiento Parcial','');">Cumplimiento Parcial</a></li>
                    <li><a href="#" onClick="javascript:BusquedaGrilla('Cumplimiento Total','');">Cumplimiento Total</a></li>
                    <li><a href="#" onClick="javascript:BusquedaGrilla('No cumplimiento','');">No cumplimiento</a></li>
					<li><a href="#" onClick="javascript:BusquedaGrilla('No aplica','');">No aplica</a></li>
                 </ul>
            </div>
			
			
            <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh" onClick="location.reload()">
                &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;</button>
       		
            <div class="pull-right">
                <span class="text-muted"><b>1</b>–<b>10</b>   <b> </b></span>
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
		
        <div class="col-sm-3 col-md-2">
             <h5><b>Notificar tramite</b></h5>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"><span class="badge pull-right">0</span> Nro Tramites </a>
                </li>
				 <li><a href="#" onClick="javascript:BusquedaGrilla('','D');">Digitado por enviar</a></li>
                 <li><a href="#" onClick="javascript:BusquedaGrilla('','E');"><b>Enviar documento</b></a></li>
                <li><a href="#" onClick="javascript:BusquedaGrilla('','P');">Proceso en ejecucion</a></li>
                <li><a href="#" onClick="javascript:BusquedaGrilla('','F');"><span class="badge pull-right">0</span>Finalizado</a></li>
				 <li><a href="#" onClick="javascript:BusquedaGrilla('','A');">Anulado</a></li>
            </ul>
        </div>
		
		   
		
      <div class="col-sm-9 col-md-10">
			
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
						<div id = "BandejaHistorial">  </div>	
                </div>
                
         
          <input name="pag" type="hidden" id="pag" value="0">
		  <input name="estado1" type="hidden" id="estado1">
		  <input name="cumplimiento1" type="hidden" id="cumplimiento1">
           
        </div>
    </div>
</div>
  
 </div>   
	
 <!-- Page Footer-->
  <div class="row-md-12">
       <div class="well"> 
                     <div id="FormPie"></div>  
       </div>
  </div>	
	
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h5 class="modal-title">Crear Documento</h5>
				</div>
		  
					<div class="modal-body" >
						 <div class="row" style="padding: 1px">		
						  	<div id="ViewForm"></div> 
					     </div>
					</div>
		  
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
      </div>
      
    </div>
  </div>	
	
 </body>
</html>
 