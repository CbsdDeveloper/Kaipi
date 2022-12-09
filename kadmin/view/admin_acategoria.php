<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/admin_acategoria.js"></script> 
 	 		 
</head>

<body>

  <!-- ------- BARRA SUPERIOR ---------------------- -->  
	
   <div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
 
 <!-- ------- MENU LATERAL ---------------------- -->  
 	
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
      
       		 <!-- TAB FORMULARIOS Content Here -->
		
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
 		  					<span class="glyphicon glyphicon-th-list"></span> <b>Catalogo Categoria</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Ingresa categoria</a>
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
							  
							   <!-- filtro de datos  -->
							  
							  <div class="col-md-12" style="padding-bottom:15px"> 
								  
							  		  <div id="ViewFiltro"></div> 
								  
							  </div>
							  
							   <!-- botones buscar  -->
							  
 			  		  	      <div class="col-md-12"> 
								  
									   <a href="admin_catalogo" class="btn btn-primary btn-warning">
										   <span class="glyphicon glyphicon-arrow-left"></span> 
									   </a>

									  <a href="#" onClick="Busqueda()" class="btn btn-primary btn-primary">
										  <span class="glyphicon glyphicon-search"></span> 
									  </a>
								  
 			  		  	      </div>
							  
							   <!-- tabla de informacion -->
							  
 			  		  	      <div class="col-md-12"> 
								 
								  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
										 <thead  bgcolor=#F5F5F5>
										   <tr>   
														<th width="10%">Codigo</th>
														<th width="30%">Nombre</th>
														<th width="40%">Referencia</th>
														<th width="10%">Variable</th>
														<th width="10%">Acciones</th>
										   </tr>
										</thead>
								 </table>
 
                             </div>  
							  
                          </div>  
						  
                       </div> 
            		 </div>
			   
					 <!-- ------------------------------------------------------ -->
					 <!-- Tab 2  FORMULARIO DE DATOS -->
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

  <!-- contenedor para variables -->
	
  <div class="modal fade" id="myModalAux" role="dialog">
				<div class="modal-dialog">
 				  <!-- Modal content-->
				  <div class="modal-content">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
								  <h4 class="modal-title">Variables Adicionales</h4>
								</div>
								<div class="modal-body">
									 <div class="row">
											<div id="VisorVariable"> </div>
										 <p>&nbsp;  </p>
											<div align="center" id="GuardaVariable"> </div>
									 </div>
								</div>
								<div class="modal-footer">
 									 <button type="button" class="btn btn-warning"  onClick="GuardarVariable();">Guardar</button>

									 <button type="button" class="btn btn-danger"  onClick="EliminarVariable();" >Eliminar</button>

									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
				  </div>
 				</div>
   </div>
	
 </div>   
 </body>
</html>
