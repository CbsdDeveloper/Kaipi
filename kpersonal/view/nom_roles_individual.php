<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_roles_individual.js"></script> 
 	 		 
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
	
	<script src="../js/tableToExcel.js"></script>
	
	 
	
</head>
	
<body>

<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->

<!-- ------------------------------------------------------ -->
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
                   			<span class="glyphicon glyphicon-th-list"></span> LISTA DE RESUMEN DEL ROL POR PERIODO</a>
                   		</li>
                    	<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> CUADRO RESUMEN DEL ROL</a>
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
											
											  <div class="col-md-12"  style="padding-top: 5px;">
												   <div id="ViewFiltro"> </div>
											   </div> 
											
											   <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px; padding-left: 25px"> 
 													   <button type="button" class="btn btn-sm btn-primary" id="load">
														<i class="icon-white icon-search"></i> Búsqueda</button>
														
														 
														 
 									   			</div> 
											   
									   		</div> 
									   	 </div> 		
  								 
 				  		     </div> 
		  		  	      
		  		  	     
			  		  	   	  <div class="col-md-12"> 
					  				   <div id="ViewProceso"> </div>
                             </div>  
                              
							  <div id="ViewSave"> </div>
							  
							  
							   <div class="col-md-12" style="padding-top: 15px;padding-top: 15px"> 
 								
								  <button type="button" onclick="window.open('nom_horas', '_self')" class="btn btn-success btn-sm">Horas E/S</button>
								  <button type="button" onclick="window.open('nom_extra', '_self')" class="btn btn-info btn-sm">Ingreso</button>
								  <button type="button" onclick="window.open('nom_descuento', '_self')" class="btn btn-warning btn-sm">Descuentos</button>
								  <button type="button" onclick="window.open('nom_roles', '_self')" class="btn btn-danger btn-sm">Resumen Rol</button>
								
						 	      <button type="button" onclick="goToURLEmailLote()" title="Notificar via electronica" class="btn btn-default btn-sm">
								   <i class="icon-white icon-magic"></i></button>
								   </button>
							 </div>  
							  
							  
							  <input type="hidden" id="id_rol" name="id_rol" >
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
								
								 <div id="ViewResumen"> </div>
					 	   
               		       </div>
                	  </div>
             	 </div>
			 
			    <!-- ------------------------------------------------------ -->
             <!-- Tab 3 -->
             <!-- ------------------------------------------------------ -->
           
              	    <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
 								
								<div class="col-md-12"> 
								    
										<div class="panel panel-default">
											
											  <div class="panel-heading">Resumen Por Gestion de Unidades</div>
											
											  <div class="panel-body">
				 				  
												  
												   <div class="col-md-9"  style="padding-top: 5px;">
													   
										 
													   <button type="button" onClick="ResumenRolFinal()" class="btn btn-sm btn-default" id="lax">
														<i class="icon-white icon-ok-sign"></i> Generar Informacion</button>
													 
													   
													   <button type="button" onClick="ResumenRolFinalPago()" class="btn btn-sm btn-warning" id="lapago">
														<i class="icon-white icon-dashboard"></i> Generar Lista a Pagar</button>
													   
													   
													   <button type="button" onClick="ResumenRolFinalBancos()" class="btn btn-sm btn-info" id="lapago1">
														<i class="icon-white icon-dollar"></i> Generar Lista a Bancos</button>
													   
													   
													   
													    <button type="button" class="btn btn-sm btn-primary" id="loadPrint">
														<i class="icon-white icon-print"></i> Impresion</button>	 
													</div> 
													   
												   <div class="col-md-2"  style="padding-top: 5px;">
													   
													   <select name='depa' id='depa' class="form-control">
													       <option value="-">- AMBITO - </option>
														   <option value="PROYECTOS">PROYECTOS</option>
														   <option value="GOBERNANENTE">GOBERNANENTE</option>
														   <option value="ASESORIA">ASESORIA</option>
														   <option value="APOYO">APOYO</option>
														   <option value="AGREGADORA DE VALOR">AGREGADORA DE VALOR</option>
													   </select>
 
												   </div>    
													   
												    <div class="col-md-1"  style="padding-top: 5px;">
														
													   <button type="button" onClick="tableToExcel('rolp','Hola')" class="btn btn-sm btn-default" id="loadExcel">
														<i class="icon-white icon-download"></i> Excel</button>
 
												  </div> 
												  
												  
												   <div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 
											  
															<div style="height: 500px; overflow-y: scroll;">

															  <div id="ViewResumenRol"> </div>

														   </div>   
										 
									 	 		 </div>
												  
												    
												  
											  </div>
											
										</div>
 						  	   </div>  
 						   
               		       </div>
                	  </div>
             	 </div>
			   
          	 </div>
		   
 		</div>
 
	
	
	 
	 <div class="container"> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 class="modal-title"> <b>ROL DE PERSONAL</b></h5>
		  </div>
				  <div class="modal-body">
 			          <div class="panel panel-default">
  				         <div class="panel-body">
							   <div class="row">
								 <div id="ViewFormRolPersona"> var</div> 
 							   </div>	   
					     </div>
   					 </div>
				  </div>
 				  <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 
   
     <div class="container"> 
	  <div class="modal fade" id="myModalCambio" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio2">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 class="modal-title"> <b>ROL DE PERSONAL</b></h5>
		  </div>
				  <div class="modal-body">
 			          <div class="panel panel-default">
  				         <div class="panel-body">
							   <div class="row">
								     <div class="col-md-10" style="padding-bottom:5;padding-top:5px"> 
										 <div id="ViewFormRoldatos"> var</div> 
										  <div id="ViewMensaje"> Edite el monto que requiera, el dato se guarda automaticamente...</div> 
									  </div>	 	 
 							   </div>	   
					     </div>
   					 </div>
				  </div>
 				  <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 

  <!-- Page Footer-->
    <div id="FormPie"></div>  

 </div>   
 </body>
</html>
