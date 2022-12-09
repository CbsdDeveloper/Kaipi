<?php
session_start( );
require '../controller/Controller-unidad_organo.php';  
$gestion   = 	new componente;
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_distributivo.js"></script> 
	
	
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
 
        
	/*	.tree li ul > li ul > li {
				display: none;
		}
	 */
 
		
.div_p {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:15%;
	float: left;
	border:solid 1px cadetblue;
    box-shadow: 0px 20px 15px -15px #818181;
	margin: 3px;
 	}		
 
.div_q {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:16%;
	float: left;
	border:solid 1px chocolate;
    box-shadow: 0px 20px 15px -15px #818181;
margin: 3px;
	}	
 
	.div_r {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:19%;
	float: left;
	border:solid 1px crimson;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
	
	.div_s {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:21%;
	float: left;
	border:solid 1px darkgoldenrod;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}		
		
	.div_t {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:23%;
	float: left;
	border:solid 1px yellow;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
		
  .div_u {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:26%;
	float: left;
	border:solid 1px greenyellow;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
		
  .div_v {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:28%;
	float: left;
	border:solid 1px lime;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}		

	</style>
	
    
</head>
<body>

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
						
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"> 
                   			<span class="glyphicon glyphicon-th-list"></span> <b>Unidades Administrativas</b></a>
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
							  
							      <div class="col-md-5">
								  
 										 <div id="ViewFormArbol" style="padding: 7px"> </div>
							  
								   </div>    
							  
							  
					
							  
							       <div class="col-md-7">
								  
									   <div class="panel panel-default">
												 <div class="panel-heading">Gestión Unidades</div>
												  <div class="panel-body">
														  <div class="widget box">
															  
															  <div style="height: 650px; overflow-y: scroll;width: 100%">
																  
															  		 <div id="ViewUnidades" style="padding: 7px">
																		 
															 			 <?php  $gestion->Gestion_tthh( ); ?>	  
 
																    </div>
																  
															   </div>  
																  
												        	</div> <!-- /.col-md-6 -->
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
 
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
  
	
	
	<div class="modal fade" id="myModal" role="dialog">
		
		  <div class="modal-dialog" id="mdialTamanio">

			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Informacion Personal</h4>
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
	
 
 	
 </body>
</html>