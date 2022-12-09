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
												<select name="q_periodo"   id="q_periodo" class="form-control required">
															 
												</select>
													
													</div> 
													
											    <div class="col-md-3"  style="padding-top: 5px;">
													<select name="qunidad"  id="qunidad" class="form-control required">
													</select>
											   </div> 
												
												<div class="col-md-3"  style="padding-top: 5px;">
													<select name="qregimen"  id="qregimen" class="form-control required">
													</select>
											   </div> 
											
											  
											   
											
											    <div class="col-md-3"  style="padding-top: 5px;">
											  
											  			<button type="button" onClick="PonerDatos()" class="btn btn-primary">Buscar Informacion</button>
													
													<button type="button" onClick="ActualizarDatos()" class="btn btn-danger">Generar en el Rol</button>

											  </div> 
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
							  
							  	<input type="hidden" id="codigo_iden" name="codigo_iden" value = '-'>   
							  
                         </div>  
                     </div> 
             </div>
            
             <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
			     
			 
			   
          
              	    <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
						
						<div id="ViewHorasForm"> </div>
						
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
								
								<div class="col-md-6" style="padding-top: 15px;padding-bottom: 15px">
							   		<iframe width="100%" id="archivocsv1" name = "archivocsv1" height="250" src="../model/ajax_importar_codigo.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
							   </div>
								
						    
						  		<div class="col-md-6" style="background-color:#E3E3E3">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="250" src="../model/ajax_importar_marcacion01.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
							   </div>
						   
               		       </div>
						  
						  
						  <div class="panel-body" > 
								
								<div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px">
									 <button type="button" onClick="VisualizarDatos()" class="btn btn-primary">Visualizar Datos</button>
									
									<button type="button" onClick="GenerarAlimentacion()"  class="btn btn-success">Procesar Alimentacion</button>
									
							   </div>
								
						    
						  		<div class="col-md-12" style="background-color:#E3E3E3">
 
									
									 <div id="ViewProcesoResultados"> </div>
									
							   </div>
						   
               		       </div>
						  
						  
                	  </div>
             	 </div>
			 
			   
          	 </div>
		   
 		</div>
 
	
	
	<div class="modal fade" id="myModal" role="dialog">
	  
			 <div class="modal-dialog" id="mdialTamanio">

				  <!-- Modal content-->

				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Control de Horas</h4>
					</div>
					<div class="modal-body">
 								  <div class="col-md-12" style="padding: 10px"> 
 										 <div class="panel panel-default">
											 
											  <div class="panel-body"> 
			 
														  <div class="col-md-12"> 
												  
																<div  style="width:100%; height:450px;">

																 <div id="ViewHoras"> </div>	 

															  </div>
															 
													 </div>		  
												  
 											    </div>
											 
										</div>
 								  </div>
 									 

							

 					</div>
					<div class="modal-footer">
						
  						
					       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
  </div>
	
	
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
