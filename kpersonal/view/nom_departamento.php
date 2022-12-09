<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_departamento.js"></script> 
	
	
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
						
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Actualización de Información</a>
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
 							 <div id="ViewFormArbol" style="padding: 7px"> </div>
                       </div>  
                     </div> 
                </div>
					   
					   <!-- Tab 2 -->
					   
                	 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px"  >
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							   <div id="ViewForm"> </div>
                		  </div>
                	  </div>
             	 </div>
                     
      		 	 </div>		
							
			 </div>	  
			
 		</div>
    </div>
    
     <!-- Modal -->
 
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>