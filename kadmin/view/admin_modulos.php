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
 
 	<script type="text/javascript" src="../js/admin_modulos.js"></script> 
 	 		 
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
	
	<!-- Header -->
	
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
 	
  <!-- ------------------------------------------------------ -->  
    <div class="col-md-12" style="padding-top: 35px"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Opciones del sistema</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Opciones</a>
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
  			  		  	       <select name="modulos" id="modulos" class="form-control" onChange="BusquedaGrilla(this.value)">
  			  		  	         <option value="0">Seleccionar Módulo</option>
								 <option value="1">Administración</option>
								  <option value="2">Estructura Organizacional</option>
								  <option value="4">Gestión documental </option>
								   <option value="7">Gestión de personal </option>
								   <option value="8">CRM Pyme  </option>  
								                                            
								  <option value="11">Inventarios</option>
								  <option value="13">Contabilidad</option>
								   <option value="15">Tributación</option>
								    <option value="16">CMS WEB Kaipi   </option>
								    <option value="17">Gestión de procesos  </option>
								     
  			  		  	       </select>
 		 							  
 			  		  	      </div>
 			  		  	     <div class="col-md-12"> 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
										    <th width="10%">Id_par_modulo</th>
											<th width="20%">Modulo</th>
											<th width="20%">Estado</th>
											<th width="20%">Vinculo</th>
											<th width="10%">Tipo</th>
										    <th width="10%">Orden</th>
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
 </div>   
 </body>
</html>
