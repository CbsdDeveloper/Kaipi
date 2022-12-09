<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_horas.js"></script> 
 	 		 
</head>
<body>

<!-- ------------------------------------------------------ -->
 <div id="main">
	
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
 	
  <!-- ------------------------------------------------------ -->  
 <div class="col-md-12"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Revision de Informacion</a>
                   		</li>
                   		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Importar Marcaciones </a>
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
											
											    <div class="col-md-3"  style="padding-top: 5px;">
													<select name="qunidad"  id="qunidad" class="form-control required">
													</select>
											   </div> 
												
												<div class="col-md-3"  style="padding-top: 5px;">
													<select name="qregimen"  id="qregimen" class="form-control required">
													</select>
											   </div> 
											
											    <div class="col-md-3"  style="padding-top: 5px;">
												<select name="q_periodo" onChange="PonerDatos()"   id="q_periodo" class="form-control required">
															 
												</select>
											   </div> 
											
											    <div class="col-md-2"  style="padding-top: 5px;">  </div> 
									   		</div> 
									   	 </div> 		
  								 
 				  		     </div> 
 			  		  	   	  <div class="col-md-12"> 
					  				   <div id="ViewProceso"> </div>
                             </div>  
                                  <div id="ViewHora"> </div>
							  <input type="hidden" id="id_rol" name="id_rol">
							  <input type="hidden" id="id_periodo" name="id_periodo">
							  <input type="hidden" id="anio" name="anio">
							  <input type="hidden" id="mes" name="mes">
                         </div>  
                     </div> 
             </div>
            
             <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
          
              	    <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						    
						  		<div class="col-md-12" style="background-color:#E3E3E3">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="200" src="../model/ajax_importar_marcacion01.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
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
