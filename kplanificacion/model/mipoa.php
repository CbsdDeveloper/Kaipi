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
    
 	<script type="text/javascript" src="../js/mipoa.js"></script> 
 	
 	   <link href="articula.css" rel="stylesheet">
 	   
 
<style type="text/css">
 
.actividad {
    border-collapse: collapse;
    width: 100%;
}

.fila {
    padding: 2px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
	

.filaa  {
    padding: 2px;
    border-right: 1px solid #ddd;
}
	
	
.filaderecha {
    padding: 2px;
     border-right: 1px solid #ddd;
}	
	
.filabajo {
    padding: 3px;
 	border-bottom: 1px solid #ddd;
	border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
}
	
 .filasupe {
    padding: 3px;
 	border-bottom: 1px solid #ddd;
	border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
	border-top: 1px solid #ddd;
}
	
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
    
    <div class="col-md-12" style="padding-top: 60px"> 
       <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Matriz POA</a>
                   		</li>
                  	 
                   </ul>
                     <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                   <div class="tab-content">
                   <!-- Tab 1 -->
                   <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
                       <div class="panel panel-default">
						  <div class="panel-body" > 
					       
					         <div class="panel-group" id="accordion_panel">
					         
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h5 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion_panel" href="#collapse11" style="font-size: 13px;font-weight: 200">Selección de Unidad</a>
									</h5>
								  </div>
								  <div id="collapse11" class="panel-collapse collapse in">
									<div class="panel-body">
											<div class="alert alert-info">
											<div class="row">
													<div id = "ViewFiltro" > </div>
													<div class="col-md-2"  style="padding-top: 5px;">&nbsp;</div> 
														<div class="col-md-10" style="padding-top: 5px;">
														<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
														</div>
											</div>
											</div>
 								  		</div>
								  </div>
								</div>
								
								
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h5 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion_panel" href="#collapse21" style="font-size: 13px;font-weight: 200">Objetivos Indicadores</a>
									</h5>
								  </div>
								  <div id="collapse21" class="panel-collapse collapse">
									<div class="panel-body">
										 <div id="ViewPOAMatriz" style="padding: 7px"> </div>
										
									</div>
								  </div>
								</div>
								
								
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h5 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion_panel" href="#collapse31" style="font-size: 13px;font-weight: 200">Matriz POA</a>
									</h5>
								  </div>
								  <div id="collapse31" class="panel-collapse collapse">
									<div class="panel-body">
										<div id="ViewPOAMatrizOO" style="padding: 7px"> </div>
										
									</div>
								  </div>
								</div>
							  </div> 
                       			    	
                       </div>  
                    </div> 
                </div>
                 <!-- Tab 2 -->
                
                     
        </div>		
		
          
	         </div>	  
 		</div>
    </div>
     
    
     <!-- Modal -->
   
  <div class="container">
   <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
       <div class="modal-dialog" id="mdialTamanio">
       <!-- Modal content-->
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Actividades POA</h4>
			</div>
			<div class="modal-body">
			   <div id="ViewForm"> </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
      </div>
     </div>
   </div>
 </div>
 
 <div class="container">
   <div id="myModalIndicador" class="modal fade" tabindex="-1" role="dialog">
       <div class="modal-dialog" id="mdialTamanio">
       <!-- Modal content-->
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Indicadores Objetivo Operativo</h4>
			</div>
			<div class="modal-body">
			   <div id="ViewFormIndicador"> </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 
			 
			</div>
      </div>
     </div>
   </div>
 </div>
 	
 	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 