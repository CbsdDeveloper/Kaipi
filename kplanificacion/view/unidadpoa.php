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
    
 	
	 <script language="javascript" src="../js/unidadpoa.js?n=1"></script>

 	
 	  <link href="articula.css" rel="stylesheet">
 	  
	  <style type="text/css">
 
		.tree {
			min-height:20px;
			padding:1px;
			margin-bottom:10px;
			background-color:#fbfbfb;
			border:1px solid #D5D5D5;
		}
		.tree li {
			list-style-type:none;
			margin:0;
			padding:10px 5px 0 5px;
			position:relative
		}
		.tree li::before, .tree li::after {
			content:'';
			left:-20px;
			position:absolute;
			right:auto
		}
		.tree li::before {
			border-left:1px solid #D5D5D5;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #D5D5D5;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			display:inline-block;
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
			  color:#000
		}
 
 
 	.tree li ul > li ul > li {
				display: none;
		}
	
    #mdialTamanio{
      width: 70% !important;
    }
		  
   #mdialTamanio2{
      width: 85% !important;
    }

		  
		  
	.bigdrop{
		
        width: 750px !important;

     }
		  
  .bigdrop1{
		
        width: 750px !important;

     }
 

		  
  #container {
  min-width: 500px;
  margin: 1em auto;
  border: 1px solid silver;
}

button {
  border: 1px solid #1da1f2;
  border-color: #0084B4;
  border-radius: 100px;
  font-size: 15px;
}

#button-bar {
  text-align: center;
}

#container{
  text-transform: none;
  font-size: 11px;
  font-weight: normal;
}

h4 {
  font-size: 8.5px !important;
}

@media (min-width: 576px) {
  h4 {
    font-size: 10px !important;
  }
}

@media (min-width: 768px) {
  h4 {
    font-size: 10.5px !important;
  }
}

@media (min-width: 992px) {
  h4 {
    font-size: 12px !important;
  }
}

@media (min-width: 1200px) {
  h4 {
    font-size: 12px !important;
 
  }
}
	</style>
  
 
	<script type="text/javascript" src="../js/select2.js"></script> 
	
    <link href="../js/select2.css" rel="stylesheet">
    
</head>
<body>

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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
 
       <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
						    	 
                    <ul id="mytabs" class="nav nav-tabs">    
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> 1.-  Objetivos Operativos </b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span><b> 2.-  Lineamientos estrategicos - Indicadores </b> </a>
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

											<div class="col-md-12"> 


													<div class="alert alert-info">

														<div class="row">

															<div id = "ViewFiltro" > </div>

															<div class="col-md-4" style="padding-top: 5px;">

																<button type="button" class="btn btn-primary btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>

																<button type="button" class="btn btn-info btn-warning" onClick="LimpiarPantalla()" data-toggle="modal" data-target="#myModal" title="Crear Objetivos">
																<i class="icon-white icon-plus"></i> 1. Objetivo Operativa
																</button>


																<button type="button" class="btn btn-info btn-info" data-toggle="modal" data-target="#myModalPlan" title="Ver Matriz Objetivos">
																<i class="icon-white icon-ambulance"></i> Objetivos Homologados
																</button>




															</div>
														</div>
													</div>

										 </div> 

											<div class="col-md-5">
												 <div id="ViewFormArbol" style="padding: 7px"> </div>
										   </div>  

											<div class="col-md-7">
												 <div id="ViewVisorArbol"> </div>

										   </div>      	

								   </div>  
								 </div> 
							</div>
					   
                  <!-- Tab 2 -->
                
				  <div class="tab-pane fade in" id="tab2"   style="padding-top: 3px" >
					
                      <div class="panel panel-default">
						  <div class="panel-body" > 
						      <div class="col-md-12">
 									 <div   style="padding: 15px" class="col-md-10">
										 
										  <button type="button" class="btn btn-sm btn-primary" onClick="busquedaArticulado()">
											<i class="icon-white icon-search"></i>  Actualizar informacion
										 </button>
										 
										 <button type="button" class="btn btn-info btn-warning" onClick="LimpiarPantallaIndicador()" data-toggle="modal" data-target="#myModalIndicador" title="Indicadores">
											<i class="icon-white icon-bolt"></i>  Definir indicadores
										 </button>
										 
										 <button type="button" class="btn btn-info btn-info" data-toggle="modal" data-target="#myModalPlani" title="Ver Matriz Indicadores">
													<i class="icon-white icon-ambulance"></i> Matriz Indicadores Recomendados
											  		</button>

			  							</div>
                      		   </div>  
                      		   
 							 <script src="https://code.highcharts.com/highcharts.js"></script>
							 <script src="https://code.highcharts.com/modules/sankey.js"></script>
							 <script src="https://code.highcharts.com/modules/organization.js"></script>
							 <script src="https://code.highcharts.com/modules/exporting.js"></script> 
							  
                      		    <div class="col-md-12">
  									 <div id="UnidadArticula" > </div>
                      		   </div>  
							   
               		     	   
                      		   
                		  </div>
                	  </div>
             </div>
                     
        </div>		
				<input type="hidden" name="depa" id="depa">
            
	         </div>	  
 		</div>
    </div>
     
    
     <!-- Modal --> 

<div class="container"> 
	  
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		  
		<div class="modal-content">
			
		  <div class="modal-header">
			  
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Objetivo Operativo</h3>
			  
		  </div>
			
				  <div class="modal-body">
				    
			          <div class="panel panel-default">

							 <div class="panel-body">

								 <div id="ViewForm"> </div>

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
	 
   <div id="myModalIndicador" class="modal fade" tabindex="-1" role="dialog">
	   
       <div class="modal-dialog" id="mdialTamanio">
       <!-- Modal content-->
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Indicadores Objetivo Operativo</h4>
			</div>
		    <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 1px">
			          <div class="panel panel-default">

							 <div class="panel-body">

								 <div id="ViewFormIndicador"> </div>

							 </div>
					     </div>   
  					 </div>
				  </div>
		   
 			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 
			 
			</div>
      </div>
     </div>
   </div>
 </div>
 	


 <div class="container">
	 
   <div id="myModalPlan" class="modal fade" tabindex="-1" role="dialog">
	   
       <div class="modal-dialog" id="mdialTamanio2">
       <!-- Modal content-->
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Matriz de Objetivos Operativos</h4>
			</div>
		    <div class="modal-body">
 			          <div class="panel panel-default">

							 <div class="panel-body">

								 <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
											 <thead  bgcolor=#F5F5F5>
											   <tr>   
													<th width="20%">Unidad Recomendada</th>
													<th width="75%">Objetivo Matriz</th>
												    <th width="5%"></th>
 											   </tr>
											</thead>
									 </table>

							 </div>
					     </div>   
 				  </div>
		   
 			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 
			 
			</div>
      </div>
     </div>
   </div>
 </div>
 	

<div class="container">
	 
   <div id="myModalPlani" class="modal fade" tabindex="-1" role="dialog">
	   
       <div class="modal-dialog" id="mdialTamanio2">
       <!-- Modal content-->
       <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Matriz de Indicadores Recomendados</h4>
			</div>
		    <div class="modal-body">
 			          <div class="panel panel-default">

							 <div class="panel-body">

								 <table id="jsontablei" class="display table-condensed" cellspacing="0" width="100%">
											 <thead  bgcolor=#F5F5F5>
											   <tr>   
													<th width="40%">Nombre indicador</th>
													<th width="45%">Detalle</th>
												    <th width="5%"></th>
 											   </tr>
											</thead>
									 </table>

							 </div>
					     </div>   
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
 