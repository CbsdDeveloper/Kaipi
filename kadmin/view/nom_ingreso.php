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
 
 	<script type="text/javascript" src="../js/nom_ingreso.js"></script> 
 	 		 
</head>
<body>

<!-- ------------------------------------------------------ -->

<div id="mySidenav" class="sidenav">
 
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 
 </div>
 <!-- ------------------------------------------------------ -->
 <div id="main">
	
	<!-- Header <> -->
	
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
 	
  <!-- ------------------------------------------------------ -->  
    <div class="col-md-12" style="padding-top: 55px"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
 							<span class="glyphicon glyphicon-th-list"></span> <b> Nòmina de Personal</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Ficha Personal Talento Humano</a>
                  		</li>
	 
					    <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-adjust"></span> Importar Informacion Personal</a>
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
	  		  	         
		  		  	         <div class="col-md-12"> 
                                
						 
 									  <div class="alert alert-info">
 									  	<div class="row">
											  <div class="col-md-2"  style="padding-top: 5px;">
												<select name="qestado"  id="qestado" class="form-control required">
															 <option value="S">Activo</option>
															 <option value="N">Desactivo</option>
												</select>
											   </div> 
											   <div class="col-md-2"  style="padding-top: 5px;"> 
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
									   			</div> 
									   		</div> 
									   	 </div> 		
  								 
 				  		     </div> 
		  		  	      
		  		  	     
			  		  	     <div class="col-md-12"> 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
											<th width="10%">Identificación</th>
										    <th width="20%">Nombre</th>
											<th width="30%">Direcciòn</th>
 											<th width="10%">Email</th>    
											<th width="10%">Ingreso</th>
											<th width="10%">Remuneración</th>
											<th width="10%">Acciones</th>
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
						    
						  		   <div id="ViewForm"> </div>
						   
               		       </div>
                	  </div>
             	 </div>
			   
			      <!-- ------------------------------------------------------ -->
             <!-- Tab 3-->
             <!-- ------------------------------------------------------ --> 
			   
			   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
								
						     <div class="col-md-12" style="padding: 20px">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="160" src="../migra/_migra_personal.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
							   </div>
						  		    
								
								  <div class="col-md-12" style="padding: 20px">
							   		<iframe width="100%" id="archivocsv1" name = "archivocsv1" height="160" src="../migra/_migra_bienes_emapa.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
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
