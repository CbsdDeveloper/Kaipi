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
    
 <script type="text/javascript" src="../js/cli_reasignar.js"></script> 
    
 <style type="text/css">  
   
   tree {
   /* min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)*/
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative;
	white-space :normal
}
	 
 
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
   border-top:1px solid #999; 
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
   /*  -moz-border-radius:5px;
    -webkit-border-radius:5px;
   border:1px solid #999;
    border-radius:5px;*/
  /*  display:inline-block;*/
    padding:3px 8px;
    text-decoration:none
}
.tree li.parent_li>span {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
    background:#eee;
  /*  border:1px solid #94a0b4; */
    color:#000
}
	    
 .tree li ul > li  ul > li{
				display: none;
		}
	
 #mdialTamanio{
  width: 60% !important;
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
					  <ul id="mytabs" class="nav nav-tabs">                    
                   	 
						<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Detalle de tramite de procesos</a>
                   		</li>
			
			
							<li><a href="#tab2" data-toggle="tab">
								<span class="glyphicon glyphicon-calendar"> </span> Recorrido Tramite</a>
							</li>
			
				     		<li><a href="#tab3" data-toggle="tab">
							<span class="glyphicon glyphicon-inbox"> </span> Flujo de proceso</a>
							</li>
                  		 
							
			
                  		 
                   </ul>
                     <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                   <div class="tab-content">
                   <!-- Tab 1 -->
                   <input name="codigoproceso" type="hidden" id="codigoproceso" value='0'>
                     
                       <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
					  		
						  		<div class="col-md-12">
									
 								  <div class="col-md-3" style="padding: 5px">
									  
     					    			<div id="ViewFormArbol"></div>
									  
    							  </div>  
									
   								 <div class="col-md-9" style="padding: 5px">
									 
									 <div class="col-md-12">
									 	<div class="col-md-6" align="center" style="padding: 10px; background-color: #3de844;color: #ffffff;border-radius:50px; -moz-border-radius:50px; -webkit-border-radius:50px;">
            								<b><div id="nombre_proceso_se">Seleccione proceso para tramite</div> </b>
										 </div>
									  </div>
   								 	 
									  <div class="col-md-12">
									 		<table id="json_variable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																	 <thead>
																			<tr>
																			<th style="background-color: #f8f8f8" width="10%">Tramite</th>
																			<th style="background-color: #f8f8f8" width="20%">Unidad</th>	
																			<th style="background-color: #f8f8f8" width="20%">Solicita</th>
																			<th style="background-color: #f8f8f8" width="20%">Caso</th>	
																			<th style="background-color: #f8f8f8" width="20%">Atiende</th>	
																			<th style="background-color: #f8f8f8" width="5%">Dias</th>
																			<th style="background-color: #f8f8f8" width="5%"></th>
																			</tr>
																	</thead>
											 </table>
										 </div>  
 							    </div>
									
                             </div>
                        </div>  
                     </div> 
                </div>
                       <!-- ------------------------------------------------------ -->
                       <!-- Tab 2 -->
					   
					    <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							    <div class="panel-body" > 
									
									  <div class="col-md-12"> 
 											<div id="ViewRecorrido"> </div> 
									   </div>
									
									  <div class="col-md-12"> 
 											<div id="ViewForm"> </div> 
									   </div>
									
							  </div>
								
						   </div>
					    </div>	
					   
					   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							  <div class="panel-body" > 
     								 		 <div id="DibujoFlujo" style="padding: 1px"></div>
   
							  </div>
								
						   </div>
					    </div>	 
					   
					   
					   
					   
  		
          	 </div>
		  </div>	  
 		</div>
    </div>
 	<input name="bandera1" type="hidden" id="bandera1" value="N">
    <input name="bandera2" type="hidden" id="bandera2" value="N">
 	<input name="bandera3" type="hidden" id="bandera3" value="N">
 
	  <!-- /.variables --> 
    
    <!-- /. crear formularios  --> 
    
 	 
   
   
     <!-- /. PROCESO FORMULARIO DE INFORMACIÓN  formularios  --> 
    
 	  <div class="container"> 
	  <div class="modal fade" id="VentanaProceso" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">FORMULARIO VISOR</h4>
		  </div>
			 
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
 				            <div class="panel-body">
  					  		    <div id="ViewFormularioTarea">  </div> 
								  <div id="VisorTarea">  </div> 
 					        </div>
 				     </div>   
 				     <div class="modal-footer" style="padding: 1px">
  					     <button type="button" class="btn btn-sm btn-danger" id='salirtarea' data-dismiss="modal">Salir</button>
  					 </div>
  					 </div>
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
 