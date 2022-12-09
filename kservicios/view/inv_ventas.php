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
   	
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

  	
	<script type="text/javascript" src="../js/inv_ventas.js"></script> 
    
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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
		
       <!-- Content Here -->
		
	    <div class="row">
			
 		 	     <div class="col-md-12">
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      
					 
                    <ul id="mytabs" class="nav nav-tabs">  
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   		 <span class="glyphicon glyphicon-th-list"></span> <b>DETALLE DE CONTABILIZACION</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> INFORME DE CONTABILIZACION</a>
                  		</li>
					 
                   </ul>
		
                     <!-- ------------------------------------------------------ -->
                     <!-- Tab panes -->
                     <!-- ------------------------------------------------------ -->
		
                   <div class="tab-content">
                   <!-- Tab 1 -->
					   
                   		<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
							
							  <div class="panel panel-default">

								  <div class="panel-body" > 

												       <div class="col-md-12" style="background-color:#EFEFEF;padding: 10px" >

																	<div id="ViewFiltro"></div> 

																<div style="padding-top: 5px;" class="col-md-3">
																				<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																</div>


															</div>


													 <div class="col-md-12">
 																 <table id="jsontable" class="display table table-striped table-bordered" cellspacing="0" width="100%">
																							<thead>
																								<tr>
 																								<th width="5%">Parte</th>	
																								<th width="10%">Fecha</th>
																								<th width="10%">Sesion</th>
																								<th width="15%">Contabilizado</th>
																								<th width="5%" bgcolor=#C0AFCC>Debe</th>
																								<th width="5%" bgcolor="#FC1E21">Haber</th> 
																								 <th width="5%"> </th>	
																								</tr>
																							</thead>
																  </table>
													  </div>  

								</div>  

							 </div> 
							
                		</div>
                 
					    <!-- Tab 2 -->
                 
					   <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
						   
								  <div class="panel panel-default">

									  <div class="panel-body"> 

												<div class="col-md-12" style="background-color:#EFEFEF;padding: 10px" >

														   <div class="col-md-12">

																<div style="padding-top: 5px;" class="col-md-3">
																		<select class="form-control" name="tipo_tran" id="tipo_tran">
																		  <option value="manual">Enlace Manual</option>
																		</select>					 
																</div>

															</div>

														   <div class="col-md-12">

																<div style="padding-top: 5px;" class="col-md-3">
																		 <input type="text" class="form-control" name="parte_caja" id="parte_caja" placeholder="Nro.Parte Caja">				 
																</div>

															</div>

															<div class="col-md-12">

															   <div style="padding-top: 5px;" class="col-md-3">
																		 <input type="date" class="form-control" name="fecha_caja" id="fecha_caja" placeholder="Fecha Caja">				 
																</div>

															</div>

												</div>

												<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">

														<div class="btn-group btn-group-sm">

															<button type="button"  onClick="goToURL(1)" class="btn btn-primary">Consultar Informacion</button>

															<button type="button" data-toggle="modal" data-target="#myModalEspecie"  class="btn btn-success">Especies</button>
															
															<button type="button" data-toggle="modal" data-target="#myModalTramite"  class="btn btn-warning">Enlace Tramite</button>
															


															<button type="button" onClick="goToURL(5)"  class="btn btn-info">Contabilizar</button>
															
															<button  id="printButton" type="button" class="btn btn-default">Resumen de Caja</button>

															<button  id="ExcelButton" type="button" class="btn btn-default">Resumen Registro</button>

													   </div>
											   </div>

												<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">

												<div id="ViewFormControl"> </div>

													<button type="button"  onClick="Agregar_datos()" class="btn btn-danger btn-sm">Agregar</button>

												</div>


											 <div style="overflow-y:scroll; overflow-x:hidden; height:650px; padding: 5px"> 

												 <div id="ContabilizadoVentas"> </div>
												 
												  <div id="ViewForm"> </div>
 												 
											  </div>
									  </div>

								  </div>
            		   </div>
		 
					   
					   <!-- Tab 3 -->
              
			   </div>	  
		
 				</div>
      </div>
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
	
	
 </div>   
 	
	 <!-- Modal -->
  <div class="modal fade" id="myModalEspecie" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Especies</h4>
        </div>
		  
        
		  <div class="modal-body">
											 <div class="form-group" style="padding-bottom: 5px">
													 <div class="panel panel-default">

														 <div class="panel-body">

															 <div id="ViewFormEspecie"> var</div> 
															 
															 
															 <div id="MensajeParametro"> </div> 

														 </div>

													 </div>   
											 </div>
								  </div>
		  
		  
        <div class="modal-footer">

			<button type="button" class="btn btn-danger" onClick="AgregarEspecie();" data-dismiss="modal">Guardar Informacion</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
			
        </div>
      </div>
      
    </div>
  </div>
	
	
	
	 <!-- Modal -->
  <div class="modal fade" id="myModalTramite" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enlace Tramites</h4>
        </div>
		  
        
		  <div class="modal-body">
											 <div class="form-group" style="padding-bottom: 5px">
													 <div class="panel panel-default">

														 <div class="panel-body">
																<label style="padding-top: 15px;text-align: right;" class="col-md-2">
																		Nro.Tramite
															 	</label>
															 
															 <div style="padding-top: 5px;" class="col-md-6">
																 <input type="number" name="id_tramite" id="id_tramite" autocomplete="off" class="form-control" style="background-color:#c6dcff" placeholder="Ingrese Tramite Descuento" value="0">
															 </div>
															 
															 
															 <div id="MensajeParametro1"> </div> 

														 </div>

													 </div>   
											 </div>
								  </div>
		  
		  
        <div class="modal-footer">

			<button type="button" class="btn btn-danger" onClick="AgregarTramite();" data-dismiss="modal">Guardar Informacion</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
			
        </div>
      </div>
      
    </div>
  </div>
	
 </body>

</html>
 