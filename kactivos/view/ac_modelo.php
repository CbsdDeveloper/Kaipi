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
 
 	<script type="text/javascript" src="../js/ac_marca.js"></script> 
 	 		 
</head>
<body>

<!-- ------------------------------------------------------ -->
 
<!-- ------------------------------------------------------ -->
 <div id="main">
 <!-- ------------------------------------------------------ -->  
 	 <div class="col-md-12" style="padding-top: 5px"> 
        		 <!-- Content Here -->
	        <ul id="mytabs" class="nav nav-tabs">       
 				 
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>CATALOGO DE MARCAS</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Crear Marca Modelo</a>
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
                    <div class="col-md-12" style="padding-top: 10px">  
						    <div class="col-md-7"> 
								 <div class="panel panel-info">
									  <div class="panel-heading">Catalogo Marca</div>
									  <div class="panel-body">
									 
								  <table width="100%" class="table table-hover" id="jsontable" style="font-size: 12px">		 
									  <thead  bgcolor=#DDDDDD>
										   <tr>   
												<th width="10%"></th>
 												<th width="90%" align="center">Marca</th>
										   </tr>
										</thead>
									   
									</table>
 										  
								   </div>
									</div>
							  </div>  	
							 
			  		  	     <div class="col-md-5"> 
								 
								 <div class="panel panel-info">
									  <div class="panel-heading"> Marca -  Modelo</div>
								   <div class="panel-body">
									 
								    <div id="ViewModelo" align="center" style="background-color: beige; padding: 3px"> </div>
										  
								  <table width="100%" class="table table-hover" id="jsontableModelo" style="font-size: 12px">		 
									  <thead  bgcolor=#DDDDDD>
										   <tr>   
											   	<th width="10%"> </th>
												<th width="90%" align="center">Lista de Modelo  </th>
 											
										   </tr>
										</thead>
									   
									</table>
 										  
								 
								   </div>
									</div>
					  		 	  
                             </div>  
					 </div>    
              </div>
           
             <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
                  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
  						  		   <div id="ViewForm"> </div>
              	  </div>
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
