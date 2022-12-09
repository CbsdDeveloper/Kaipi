<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/estrategia.js"></script> 
 
	 
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
	 
 		 	   
						     	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Estrategias Institucionales</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Objetivo Estrategico</a>
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
						       <div class="col-md-12" >
 									 <div id="ViewFormArbol" style="padding: 7px"> </div>
                      		   </div>  
                     		  <div class="col-md-12" style="padding:25px">
 									 <div id="ViewVisorArbol"> Detalle de Objetivos Estrategicos</div>
                      		   </div>      	
                      			    	
                       </div>  
						  
                     </div> 
					   
 					
                </div>
                 <!-- Tab 2 -->
					   
                 <div class="tab-pane fade in" id="tab2" >
 					   
					   <div class="col-md-12" style="padding: 15px">
					 
							 <div class="panel panel-info">
								 
							  <div class="panel-heading"><b>Panel Principal</b></div>
								 
									  <div class="panel-body"> 
										   <div id="ViewForm"> </div>
										 </div>
							</div>
						  
						 </div>
					 
                     
					 
					 
					 
					 
             </div>
                     
        </div>		
							
		   
 	 
    </div>
    
     <!-- Modal -->
 
  	<!-- Page Footer-->
    <div id="FormPie"></div>  

  </body>
</html>
 