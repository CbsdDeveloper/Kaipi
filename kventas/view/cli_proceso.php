<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
     <title>Plataforma de Gestión Empresarial</title>
     <?php  require('Head.php')  ?> 
     <script type="text/javascript" src="../js/cli_proceso.js"></script> 
    
    <style type="text/css">
        #mdialTamanio{
        width: 70% !important;
       }
 </style>
</head>
<body>

<div id="mySidenav" class="sidenav">
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 </div>

<div id="main">
	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
    <!-- Content Here -->
    <div class="col-md-12" style="padding-top: 60px"> 
       <div class="row">
 		 	     <div class="col-md-12">
					 <h5><b>DEFINICION Y GRÀFICO</b></h5>
					  <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Diagrama de Procesos</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Definir el Proceso</a>
                  		</li>
                   </ul>
                    <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                   <div class="tab-content">
                   <!-- Tab 1 -->
					   <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
						  <div class="panel panel-default">
							  <div class="panel-body" > 
									<div class="col-md-12" style="padding: 1px">
									  <iframe src="https://www.draw.io/" width="100%" height="850" frameborder="0" scrolling="yes" id="iframe"></iframe>  
									</div>
							</div>  
						 </div> 
				  	   </div>
                 	<!-- Tab 2 --> 
                 	<div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
								   <div class="col-md-12">
									    <a href="#" class="btn btn-info btn-sm" onClick="BusquedaGrilla();"  role="button">Pendientes</a>
                  					    <a href="#" class="btn btn-info btn-sm" onClick="BusquedaPublica();"  role="button">Aprobados</a>
									   
										<div id="listaproceso"> </div>
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
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
       <div class="modal-dialog" id="mdialTamanio" style="background-color: #FFFFFF">
        <!-- Modal content-->
           <div class="modal-content" style="background-color: #FFFFFF">
        		<div class="modal-header">
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
         		</div>
         		<div class="modal-body">
         			<div id="ViewForm"  style="padding: 1px; background-color:#FDFBFB"> </div>
        		</div>
        
        		<div class="modal-footer">
      		  		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      			</div>
      	   </div>
       </div>
    </div>
   	<!-- Page Footer-->
    <div id="FormPie"></div>  
  </body>
</html>
 