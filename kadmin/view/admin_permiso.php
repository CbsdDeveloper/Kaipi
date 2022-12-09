<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
   
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/admin_permiso.js"></script> 
 
 
	
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
   
   					        <div class="panel-group" id="accordion_grupo">
									
								  <div class="panel panel-default">
									  <div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse_grupo1"><h5><b>Opciones del Sistema</b></h5></a>
										</h4>
									  </div>
									  <div id="collapse_grupo1" class="panel-collapse collapse in">
										 <div class="panel-body">
											 <div id="ViewForm"> </div>
										</div>
									  </div>
									</div>
									
									
									<div class="panel panel-default">
									  <div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" data-parent="#accordion" href="#collapse_grupo2"><h5><b>Tablero de Actividades</b></h5></a>
										</h4>
									  </div>
									  <div id="collapse_grupo2" class="panel-collapse collapse">
										 <div class="panel-body">
											  <div class="col-md-6">
											  	  <div class="list-group">
													<a href="#" onClick="asignaa('ESTRATEGICA','add');" class="list-group-item">ESTRATEGICA </a>
													<a href="#" onClick="asignaa('ADMINISTRATIVA','add');" class="list-group-item">ADMINISTRATIVA</a>
													<a href="#" onClick="asignaa('FINANCIERA','add');" class="list-group-item">FINANCIERA</a>
													<a href="#" onClick="asignaa('TECNOLOGICA','add');" class="list-group-item">TECNOLOGICA</a>
													<a href="#" onClick="asignaa('COMERCIAL','add');" class="list-group-item">COMERCIAL</a>
													<a href="#" onClick="asignaa('CLIENTE','add');" class="list-group-item">ATENCION AL CLIENTE</a>
												  </div>
											  </div>
                     						  <div class="col-md-6" >
                     						  	  <div class="list-group">
												 		<div id="tableroasignado"></div>
												  </div>
                     						  	
                     						  </div>
 										</div>
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
