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
 
 	<script type="text/javascript" src="../js/periodo.js"></script> 
 	 		 
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
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Periodo Planificación</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle Periodo</a>
                  		</li>
           </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content">
            
           <!-- ------------------------------------------------------ -->
           <!-- Tab 1 -->
           <!-- ------------------------------------------------------ -->
                  
            <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
		  		  	     <!-- ------------------------------------------------------ -->
           					<!-- filtro -->
           					<!-- ------------------------------------------------------ -->
		  		  	        <div class="col-md-12"> 
                               	  
								  		<div class="alert alert-info">
								  		<div class="row">
   											<div class="col-md-3" style="padding-top: 5px;">
											<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar Periodo</button>
											</div>
								  		</div>
 								  		</div>
  								  
 				  		     </div> 
			  		  	     
                           
							<div class="col-md-10"> 
	  		 				  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
													<th width="10%">PERIODO</th>
													<th width="20%">PROCESO POA</th>
													<th width="20%">DETALLE</th>
													<th width="10%">ESTADO PRESUPUESTO</th>
													<th width="10%">FECHA INICIAL</th>
													<th width="10%">FECHA FINAL</th>
													<th width="10%">ACCIONES</th>
									   </tr>
									</thead>
							 </table>
                             </div>  
                          </div>  
                     </div> 
             </div>
           
             <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
           
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						    
								<div class="col-md-9" align="center"> 
						  		   <div id="ViewForm"> </div>
						  		  </div>
						   
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
