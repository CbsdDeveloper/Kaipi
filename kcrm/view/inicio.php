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
 
	
    <script language="javascript" src="../js/inicio.js"></script>
    
    <style type="text/css">  

			   tree {
 					margin-bottom:20px;
 				    background-color:#FFFFFF;
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
			  width: 85% !important;
			}
		
		 .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
			position: relative;
			min-height: 1px;
			padding-right: 10px;
			padding-left: 10px;
			font-style: normal;
			font-weight: normal;
			font-size: 13px;
			font-family: "Segoe UI", "Trebuchet MS", sans-serif;
		}	
		
				
	 .highlight {
 			 background-color: #FF9;
	   }
	   .de {
  			 background-color:#A8FD9E;
	  } 
	  .ye {
  			 background-color:#93ADFF;
	  }

	 .bloque1 {
		display: inline-block;
		font-weight: 400;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#0090e7 !important;
		padding: 10px;
		width: 100%; 
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}
		
	 .bloque00 {
		display: inline-block;
		font-weight: 600;
		color: #ffffff;
		text-align:justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#000000  !important;
		padding: 10px;
		width: 100%;
		line-height: 1;
		/*border-radius: 1.1875rem; */
		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	
	 .bloque0 {
		display: inline-block;
		font-weight: 400;
		color: #ffffff;
		text-align:justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#ffab00  !important;
		padding: 10px;
		width: 100%; 
		line-height: 1;
		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 .bloque2 {
		display: inline-block;
		font-weight: 400;
		color: #ffffff;
	    text-align:justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#00d25b  !important;
		padding: 10px;
		width: 100%; 
		line-height: 1;
		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 .bloque3 {
		display: inline-block;
		font-weight: 400;
		color: #ffffff;
	  text-align:justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#8f5fe8   !important;
		padding: 10px;
		width: 100%; 
		line-height: 1;
		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}
		
	.bloque4 {
		display: inline-block;
		font-weight: 400;
		color: #ffffff;
		 text-align:justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#fc424a !important;
		padding: 10px;
		width: 100%; 
		line-height: 1;
		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 span.blue {
		  background: #5178D0;
		  border-radius: 0.8em;
		  -moz-border-radius: 0.8em;
		  -webkit-border-radius: 0.8em;
		  color: #ffffff;
		  display: inline-block;
		  font-weight: bold;
		  line-height: 1.6em;
		  text-align: center;
		  width: 1.6em; 
		}
		
   </style>
  
		<script type="text/javascript" src="../../app/bootstrap-wysihtml5/wysihtml5.min.js"></script>
	
		<script type="text/javascript" src="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
	
	    <link href="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">
	
  	    <link href="tabi.css" rel="stylesheet" type="text/css" />
	
	
</head>
	
<body>

 

<div id="main">
	
	
	
 
	
    <div class="col-md-12" role="banner">
		
		
 	   <div id="MHeader"></div>
		
		
 	</div> 
 	
	<div id="mySidenav" class="sidenav" style="z-index: 100">
		
		<div class="panel panel-primary">
			
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
			
				<div class="panel-body">
					
					<div id="ViewModulo"></div>
					
				</div>
			
			
		</div>
		
   </div>
   
	
    <div class="col-md-12"> 
 	    
 					  <ul id="mytabs" class="nav nav-tabs">  
						  
							<li class="active"><a href="#tab1" data-toggle="tab"></span>
								<span class="glyphicon glyphicon-th-list"></span> Portafolio de  Procesos</a>
							</li>

							<li><a href="#tab2" data-toggle="tab">
							<span class="glyphicon glyphicon-inbox"> </span> Informacion Tramite</a>
							</li>
	
							<li><a href="#tab3" data-toggle="tab">
								<span class="glyphicon glyphicon-calendar"> </span> Recorrido Tramite</a>
							</li>
	
							<li><a href="#tab4" data-toggle="tab">
								<span class="glyphicon glyphicon-apple"> </span> Grafico Proceso</a>
							</li>
						 
						 
			
                      </ul>
	
	
                     <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
	
                   <div class="tab-content">
                  
						 
						 <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

			   					<div class="panel panel-default">

										      <div class="panel-body"  > 
  											
											      <div class="col-md-2">
 														 <div class="col-md-12">
													     	  <div id="ViewEstado" ></div>
														 </div>	 
													    <div class="col-md-12">
													     	 <div id="ViewFormArbol" ></div>
														 </div>	 
    
 													</div>  
											
 												   <div class="col-md-10">
 													 
																<table id="json_variable"  style="font-size: 11px"  class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" >
																	 <thead>
																		 <tr>
																			<th style="background-color: #f8f8f8" width="5%">Nro</th>
																			<th style="background-color: #f8f8f8" width="5%">Tarea</th>	
																			<th style="background-color: #f8f8f8" width="7%">Fecha</th>
																			<th style="background-color: #f8f8f8" width="18%">Solicita</th>	
																			<th style="background-color: #f8f8f8" width="20%">Tramite</th>	
																			<th style="background-color: #f8f8f8" width="20%">Asunto</th>
																			<th style="background-color: #f8f8f8" width="5%">Dias</th>
																		    <th style="background-color: #f8f8f8" width="15%">Actualización</th>	
 																			<th style="background-color: #f8f8f8" width="5%"></th>
																		 </tr>
																	</thead>
																</table>

 											   		</div>
												 
											  </div>  
 										   
											
				 				 </div>
									
 				        </div>

						 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							  <div class="panel-body" > 
								  

										<div id="ViewFormularioTarea"> </div> 

										 <div id="VisorTarea">  </div> 
								 
								  
											

							  </div>
								
						   </div>
					    </div>	 

						 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							    <div class="panel-body" > 
									  <div class="col-md-12"> 
 											<div id="ViewRecorrido"> </div> 
									   </div>
							  </div>
								
						   </div>
					    </div>	 
					   
            			 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							    <div class="panel-body" > 
 										<div id="DibujoFlujo">  </div> 
 							  </div>
								
						   </div>
					    </div>	 
					   
					     <div class="tab-pane fade in" id="tab5"  style="padding-top: 3px;">
							 
						    <div class="panel panel-default">
							  
							    <div class="panel-body" > 
 

							  </div>
								
						  </div>
					    </div>
					   
	  			   </div>
   
	</div>
	
 	<input name="bandera1" type="hidden" id="bandera1" value="N">
    <input name="bandera2" type="hidden" id="bandera2" value="N">
 	<input name="bandera3" type="hidden" id="bandera3" value="N" class="glyphicon-edit">
   
 </div>   
 <div id="FormPie"></div> 

	<div class="modal fade" id="myModalDocVisor" role="dialog">
		  <div class="modal-dialog" id="mdialTamanio">

			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Visor de Documento</h4>
				</div>
				<div class="modal-body">

					<embed src=""   width="100%"  height="450px" id="DocVisor" name ="DocVisor" />

				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>

			</div>
  </div>

 </body>
</html>
 