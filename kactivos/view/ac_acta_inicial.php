<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ac_acta_inicial.js"></script> 
	
	
	
	 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
		}
 
		#mdialTamanio1{
      			width: 85% !important;
   			 }
		
		#mdialTamanio2{
      			width: 65% !important;
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b> INFORMACION DE CUSTODIOS</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span>  HISTORIAL ACTA ENTREGA RECEPCION</a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-dashboard"></span><b> EMITIR ACTA ENTREGA RECEPCION</b></a>
							
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

								 

										   <div class="col-md-12" style="background-color:#ededed;">

																		<h5>Filtro búsqueda</h5>
																		<div id="ViewFiltro"></div> 


																		<div style="padding-top: 10px;padding-bottom: 15px" class="col-md-9">
																				<button type="button" class="btn btn-sm btn-primary" id="load">  
																				<i class="icon-white icon-search"></i> Búsqueda filtro</button>	
																			
																			
																			<button type="button"  onClick="VisorActa()" class="btn btn-sm btn-info" id="loadA" data-toggle="modal" data-target="#myModalacta">  
																				<i class="icon-white icon-search"></i> Lista Actas Generadas</button>	
																			
																		</div>

										  </div>

										   <div class="col-md-12">
																	<h5>Transacciones por periódo</h5>

																   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="15%">Identificacion</th>
																									<th width="30%">Custodio</th>
																									<th width="20%">Unidad</th>
																									<th width="10%">Generada</th>		
																									<th width="10%">Ultima Acta</th>		
																									<th width="5%">Nro.Bienes</th>
																									<th width="10%">Acción</th>
																									</tr>
																								</thead>
																	  </table>

											  </div>  
									 

							  </div>
							 
						  </div>
                   </div>
  			   
           
                    <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px" >
						
  						  		   <div id="ViewForm"> </div>
						
              	     </div>
			   
			   
			        <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" >
					  
					    <div class="col-md-12" style="padding: 5px">
							
					         <h5><img src="../../kimages/mano.png" align="absmiddle" /> <b>HISTORIAL DOCUMENTOS EMITIDOS</b></h5>
							
							<div class="alert alert-warning">
  												<strong>Custodio</strong> <h4 id="nombre_doc">NOMBRE FUNCIONARIO</h4>
							</div>
							
							
  						  		   
							 <div class="col-md-12" style="padding: 5px">
								 
					           <table id="jsontable_doc" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="10%">Nro.Acta</th>
																						<th width="15%">Tipo</th>
																						<th width="10%">Documento</th>	
																						<th width="10%">Fecha</th>
																						<th width="30%">Detalle</th>	
																						<th width="10%">Fecha Impresion</th>
																						<th width="15%"> </th>
																						</tr>
																					</thead>
														  </table>
							 <div id="Actanegada"></div>  
								 
								 </div>
					    </div>
              	  </div>
			   
          	 </div>
		   
 		</div>
	
    

		<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   
 
    	<div id="FormPie"></div>  
	
 </div>   



		<div class="modal fade" id="myModalbienes" role="dialog">

					  <div class="modal-dialog" id="mdialTamanio1">

						<!-- Modal content-->
						 <div class="modal-content">
						 <div class="modal-header">
						  <button type="button" class="close"  data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Bienes Asignados en la Acta</h4>
						 </div>
						 <div class="modal-body">
							 <div class='row'>


									<div class="col-md-12">

										 <div class="col-md-2">
												<div class="form-group">
												  <label for="usr">Fecha:</label>
												  <input type="date" class="form-control" id="tfecha">
												</div>
										 </div>	 

										 <div class="col-md-10">
											   <div class="form-group">
												  <label for="usr">Detalle:</label>
												  <input type="text" class="form-control" id="tdetalle">
												</div>
										</div>	
									 </div>	

									<input type="hidden" id="tacta">

									<div class="col-md-12" style="padding-top: 5px;">

										  <div style="height:400px;width:100%;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">

													<div id='VisorBIenes'></div>
										 </div>	

								   </div>			

							  </div>	 
						</div>
						<div class="modal-footer">

							 <button type="button" onClick="ActualizaActa()" class="btn btn-info" data-dismiss="modal">Actualizar</button>

							 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

						</div>
					  </div>
					</div>
			  </div>




		<div class="modal fade" id="myModalacta" role="dialog">

					  <div class="modal-dialog" id="mdialTamanio1">

						<!-- Modal content-->
						 <div class="modal-content">
						 <div class="modal-header">
						  <button type="button" class="close"  data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Detalle de Actas</h4>
						 </div>
						 <div class="modal-body">
							 <div class='row'>




									<div class="col-md-12" style="padding-top: 5px;">

										  <div style="height:400px;width:100%;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">

													<div id='VisorActa'></div>
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




		<div class="modal fade" id="myModalLibres" role="dialog">

					  <div class="modal-dialog" id="mdialTamanio1">

						<!-- Modal content-->
						 <div class="modal-content">
							 
						 <div class="modal-header">
						  
							 <button type="button" class="close"  data-dismiss="modal">&times;</button>
						  
							 <h4 class="modal-title">Bienes Libres</h4>
						 
						</div>
						
						<div class="modal-body">
							
							 <div class='row'>

									<div class="col-md-12" style="padding-top: 5px;">

										
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
																					  <th width="30%">Detalle / Caracteristicas del Bien</th>
																					  <th width="10%">Marca</th>
																					  <th width="10%">Serie</th>
																					  <th width="10%">Estado</th>
																					  <th width="5%">Fecha</th>
 																					  <th width="5%">Costo</th>		
																					  <th width="20%">Custodio Asignado</th>
																					  <th width="5%">Acción</th>
																				</tr>
																		</thead>
																	 </table>

								   </div>			

							  </div>	 
						</div>
						<div class="modal-footer">

							<button type="button" id="bbienes"  name="bbienes" class="btn btn-success"  >Busqueda</button>

							 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

						</div>
					  </div>
					</div>
			  </div>




 </body>
</html>
