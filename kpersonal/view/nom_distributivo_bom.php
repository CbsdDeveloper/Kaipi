<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_distributivo_bom.js"></script> 
 	 		 
</head>
	
<body>

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
	 
	       <ul id="mytabs" class="nav nav-tabs"  >          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> LISTA DE CAMBIO Y DISTRIBUCION DE ESTACIONES</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> DETALLE DE PERSONAL Y DISTRIBUCION DE PERSONAL</a>
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
										   	<div class="col-md-3"> 
												<select class="form-control" id="vestado" name="vestado">
												  <option value="digitado">Digitado/Elaborado</option>
												  <option value="aprobado">Aprobado</option>
												  <option value="autorizado">Autorizado TTHH</option>	
												  <option value="anulado">Anulado</option>
												</select>
											 </div>  	
										   
										   	<div class="col-md-3"> 
										  		  <button type="button" name="load" id="load" class="btn btn-primary btn-sm">Busqueda</button>
									 	  	</div>  
									  
									   </div>  
									  
										   
									 <div class="col-md-12"> 
									  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
											 <thead  bgcolor=#F5F5F5>
											   <tr>   
													<th width="10%">Id</th>
													<th width="10%">Fecha</th>
													<th width="15%">Documento</th>
													<th width="30%">Comentario</th>
													<th width="15%">Responsable</th>
												    <th width="15%">Elaborado</th>
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
   <input type="hidden" id="unidad" name="unidad">
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
	
 </div>   

	<div class="modal fade" id="myModal" role="dialog">
		
		<div class="modal-dialog" id="mdialTamanio4"  >

		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Lista de Personal</h4>
			</div>
			<div class="modal-body">
				<div class="row"> 
						   <div class="col-md-12"> 
						 	
 							 <div id="cambiof"> </div>
							   
							   <input type="hidden" id="id_asigna_bom" name="id_asigna_bom">
							   
							   
								
				 			</div>
			 		 </div>
			</div>
			<div class="modal-footer">
				
				  <button type="button" class="btn btn-danger" onClick="Cambiar_persona()" data-dismiss="modal">Cambiar a</button>
				
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>

		</div>
	  </div>

 </body>
</html>
