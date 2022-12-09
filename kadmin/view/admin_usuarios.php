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
 
 	<script type="text/javascript" src="../js/admin_usuarios.js"></script> 
 	 	
	<style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
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
	 .di {
  			 background-color:#F5C0C1;
	  }
</style>	
	
</head>
	
<body>

  <!--NAVEGADOR ------------ -->  
	
	<div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
	
	
	 <!--MENU LATERAL ------------ -->  
	
 	
	<div id="mySidenav" class="sidenav">
		
		<div class="panel panel-primary">
			
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
			
				<div class="panel-body">
					
					<div id="ViewModulo"></div>
					
				</div>
		</div>
		
   </div>
	
  <!-- FORMULARIO DE CONTENIDOS -->
	
    <div class="col-md-12"> 
      
       		 <!-- VIÑETA DE LISTA DE BUSQUEDAS Y FORMULARIOS -->
		
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
 							<span class="glyphicon glyphicon-th-list"></span> <b>Usuarios del Sistema</b></a>
                   		</li>
	
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Información Usuario</a>
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
														<th width="10%">Id</th>
														<th width="10%">Usuario</th>
														<th width="20%">Nombre</th>
														<th width="20%">Apellido</th>
														<th width="15%">Email</th>    
														<th width="5%">Estado</th>
														<th width="10%">Rol</th>
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
			   
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  

    
 </body>
</html>
