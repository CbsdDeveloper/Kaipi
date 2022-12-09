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
 
 	<script type="text/javascript" src="../js/ac_bajas.js"></script> 
	
	 <style type="text/css">
  		#mdialTamanio{
  					width: 95% !important;
		}
 	 
       </style>		 
		 
</head>
	
<body>

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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>DETALLE DE TRAMITES DE BAJA DE EQUIPOS</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> GENERAR ACTA DE BAJA DE EQUIPOS</a>
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

									<div class="col-md-12" style="padding: 1px">
										   <div class="col-md-3" style="background-color:#ededed;">

																		<h5>Filtro búsqueda</h5>
																		<div id="ViewFiltro"></div> 

																		<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
																		<div style="padding-top: 5px;" class="col-md-9">
																				<button type="button" class="btn btn-sm btn-primary" id="load">  
																				<i class="icon-white icon-search"></i> Buscar</button>	
																		</div>
																		<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
								   </div>

										   <div class="col-md-9">
																	<h5>Transacciones por periódo</h5>


																   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="10%">Transacción</th>
																									<th width="10%">Documento</th>
																									<th width="10%">Fecha</th>
																									<th width="30%">Detalle</th>						
																									<th width="20%">Resolucion</th>
																									<th width="10%">Nro.Bienes</th>	
																									<th width="10%">Acción</th>
																									</tr>
																								</thead>
																	  </table>

											  </div>  
									</div>

							  </div>
							  </div>
                 </div>
           
 
			   
			        <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" >
					  
							<div class="col-md-12" style="padding: 5px">

								<div id="ViewForm"> </div>
 								
								<button type="button"  class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Buscar Bienes</button>
								
								<button type="button"  onClick="depre_acta()" class="btn btn-info btn-sm" >Deprecias Bienes</button>

							</div>
						
						    <div class="col-md-12" style="padding: 1px">
								
								

								
   								  <div id="DetalleActivosNoAsignado">Para visualizar los bienes pendientes de asignar debe agregar para crear el acta</div>
								
								  <div id="GuardaDato"></div>
								
     					    </div>
 						
              	  </div>
			   
          	 </div>
		   
 		</div>
	
    

<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   
 
    <div id="FormPie"></div>  
	
 </div>   



<div class="container">
 
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bienes Disponibles</h4>
        </div>
        <div class="modal-body">
     		    <div class="form-group" style="padding-bottom: 10px">
										<div class="panel panel-default">
												 <div class="panel-body">

																<div class="col-md-4" style="padding: 5px">
																  <input name="ccactivo" type="text" id="ccactivo" placeholder="Busqueda de Bienes" class=form-control>
																 </div>

																<div class="col-md-4" style="padding: 5px">
																  <input name="ccustodio" type="text" id="ccustodio" placeholder="Busqueda de Custodio" class=form-control>
																 </div>


																  <table id="jsontableBienes" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																		<thead>
																				<tr>
																					  <th width="5%">Activo</th>
																					  <th width="30%">Detalle/Caracteristicas del Bien</th>
																					  <th width="10%">Marca</th>
																					  <th width="10%">Serie</th>
																					  <th width="10%">Estado</th>
																					  <th width="5%">Fecha</th>
																					  <th width="5%">Tiempo</th>		
																					  <th width="5%">Costo</th>		
																					  <th width="15%">Custodio</th>
																					  <th width="5%">Acción</th>
																				</tr>
																		</thead>
																	 </table>
						   
												</div>
			</div>
			</div>
        </div>
        <div class="modal-footer">
			
			
			<button type="button" id="bbienes"  name="bbienes" class="btn btn-success"  >Busqueda</button>
			
			<button type="button" id="bbienesr"  name="bbienesr" class="btn btn-info"  >Bienes Reposición</button>
			
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

 </body>
</html>
