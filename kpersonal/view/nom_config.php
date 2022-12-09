<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/nom_config.js"></script> 
	
	
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
 <div class="col-md-12" > 
      
       		 <!-- Content Here -->
	 
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Configuración de Rubros</a>
                   		</li>
	 
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Definición Conceptos</a>
                  		</li>
	 
						 <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Regimen laboral</a>
                  		</li>
	 
	 					 <li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Presupuesto Talento Humano</a>
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
												<select name="q_tipo"  id="q_tipo" class="form-control required">
															 <option value="I">Ingreso</option>
															 <option value="E">Descuento</option>
															 <option value="X">Otros</option>
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
											<th width="30%">Concepto</th>
											<th width="10%">Activo</th>
											<th width="10%">Estructura</th>
											<th width="10%">Formula</th>
											<th width="5%">Valor</th>
											<th width="15%">Variable</th>
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
								
								 <div class="col-md-10" style="padding-bottom: 10px;padding-top: 15px">  
									
									
									 
								     <button type="button" id="LimpiarParametro" class="btn btn-default btn-sm">Nuevo Parametros</button>
									 
									  <button type="button" id="GuardaParametro" class="btn btn-info btn-sm">Guardar Parametros</button> 
								
							     </div>	 
								
 							 		 
 								
								 <div id="detalle_datos"> 
								
								 
								</div>
						   
               		       </div>
                	  </div>
             	 </div>
			   
			   <input type="hidden" id='accion_parametro' name='accion_parametro'>
			   <input type="hidden" id='id_config_reg' name='id_config_reg'>
			   
			   
			   
			       <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
					   
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
 
									 <div class="col-md-9" style="padding-bottom: 10px;padding-top: 15px">  
								
								 			<div id="detalle_datos_regimen"> </div>
										 
						    		 </div>
               		       </div>
                	  </div>
             	 </div>
			   
			   	   <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
					   
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
 
								   
								  <table id="jsontable_pre" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="20%">Programa</th>
																									<th width="20%">Partida</th>
																									<th width="40%">Detalle</th>				
																									<th width="15%">Clasificador</th>
																									<th width="15%">Saldo Disponible</th>	
 																									</tr>
																								</thead>
																	  </table>
						   
               		       </div>
                	  </div>
             	 </div>
			   
			   
 
             	 </div>
	
	
          	 </div>
		   
 		</div>
 
	
  <!-- Modal -->
	
 
	
	
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   

	<div class="modal fade" id="myModalPrograma" role="dialog">

	  <div class="modal-dialog" id="mdialTamanio">

		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Historial</h4>
			</div>
			<div class="modal-body">
			  
				
				<div class="panel panel-info">
												  <div class="panel-heading">SELECCION DE PROGRAMA A REALIZAR EL PAGO DE NOMINA</div>
													<div class="panel-body"> 
															 <div id="ViewFormPrograma"> </div>
													</div>
												  </div>
				
			
				
			  
			</div>
			<div class="modal-footer">

				 <button type="button" class="btn btn-success" onClick="GenerarPrograma()" data-dismiss="modal">Procesar Informacion</button>

			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  
		  </div>

		</div>
  </div>

 </body>
</html>
