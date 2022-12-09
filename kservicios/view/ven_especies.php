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
 
		
    <style type="text/css">
		 
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
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
	 
	 #mdialTamanio{
  					width: 90% !important;
		}
	 #mdialTamanio1{
  					width: 60% !important;
		}
		
  #mdialTamanio2{
  					width: 85% !important;
		}
	 
	 .form-control_asiento {  
		  display: block;
		  width: 100%;
		  height: 28px;
		  padding: 3px 3px;
		  font-size: 12px;
		  line-height: 1.428571429;
		  color: #555555;
		  vertical-align:baseline;
		  text-align: right;
		  background-color: #ffffff;
		  background-image: none;
		  border: 1px solid #cccccc;
		  border-radius: 4px;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
				  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
				  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
   }
 
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 4px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
	 
</style>	
	
 	<script type="text/javascript" src="../js/ven_especie.js"></script> 
 	 		 
</head>
<body>

	 <div id="main"  >
	
 	
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
											<span class="glyphicon glyphicon-th-list"></span> <b> ESPECIES DISPONIBLES</b>  </a>
										</li>

										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> FORMULARIO DE COBRO</a>
										</li>

										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-file"></span> CONFIGURACION / REPORTE DIARIO </a>
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

												<div class="col-md-3">

													  <div id = "ViewRubro" > </div>

												 </div> 	

													 <div class="col-md-9"> 

														<h4><b> <div id = "NombreSeleccion"> </div></b></h4>

														<div class="col-md-12" style="background-color:#ededed;padding: 15px">

															   <div id = "ViewFiltro" > </div>
															   <div class="col-md-10" style="padding-top: 5px;padding-bottom: 5px">
																	<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
																</div>


														</div> 

														 <div class="col-md-12"> 



																  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
																		 <thead  bgcolor=#F5F5F5>
																		   <tr>   
																						<th width="10%">Transaccion</th>
																						<th width="10%">Fecha</th>
																			   			<th width="10%">Identificacion</th>
																						<th width="40%">Contribuyente</th>
																						<th width="10%">Nro.Especie</th>
 																						<th width="10%">Costo</th>
																						<th width="10%">Accion</th>
																		   </tr>
																		</thead>
																 </table>
														 </div>  
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
												   <div id="ViewFormVar"> </div>

														<div style="padding: 10px">
															
																<button type="button" onClick="LimpiaPermiso()" class="btn btn-primary">Buscar AutoPermiso</button>
																<button type="button" onClick="BuscarHistorial()" class="btn btn-success">Buscar Historial</button>
															
														  	   <button type="button" onClick="VeDatos()" class="btn btn-default">Secuencia</button>
															
															
 												 		  </div>


										   </div>
									  </div>
								 </div>

							   
						   	  <!-- ------------------------------------------------------ -->
							 <!-- Tab 3 -->
							 <!-- ------------------------------------------------------ -->

								 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">

									  <div class="panel panel-default">

											<div class="panel-body" > 

  
														 <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px"> 
															 
															 	<button type="button" class="btn btn-info btn-lg" onClick="LimpiarEspecie()" data-toggle="modal" data-target="#myModalpa">Registrar Asignacion Especies</button>
															 
															   <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalxx">Novedades</button>
															 
															 
															 	<button type="button" class="btn btn-warning" onClick="ReporteDiario()">Reporte del Dia</button>
															 
															 
															    <button type="button" class="btn btn-success" onClick="ResumenDiario()">Resumen del Dia</button>

														</div>	
												
														  <div class="col-md-9"> 

  
																		   <div id="ViewFormEspecie" style="padding-top: 5px;padding-bottom: 10px"> </div>

														</div>	

		 
										   </div>
									  </div>


						   </div>


			   
          				 </div>
 
 
	
 </div>   
	
	
		 <!-- Page Footer-->
     <div id="FormPie"></div>  


<div class="container"> 
	
	   <div class="modal fade" id="myModalprov" tabindex="-1" role="dialog">
		  
  	  		<div class="modal-dialog" id="mdialTamanio">
		  
				<div class="modal-content">

						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3  class="modal-title">Lista de Beneficiarios</h3>
						  </div>

						  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
							  <div class="panel panel-default">

								 <div class="panel-body">
									   <div class="col-md-12" style="padding-top: 10px;padding-bottom: 15px"> 
												<div class="col-md-2"> 
													<select name="nanio" id="nanio" class="form-control">
													</select>
												 </div>

										  	   <div class="col-md-2"> 
													<select name="nmes" id="nmes"  class="form-control">
													  <option value="1">Enero</option>
													  <option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
													</select>
												 </div>
										    
										        <div class="col-md-2"> 
													<select name="ntipo" id="ntipo"  class="form-control">
													  <option value="P">Proveedor</option>
													  <option value="N">Nomina</option> 
													  <option value="C">Varios</option> 
													</select>
												 </div>
										   
										         <div class="col-md-3" style="padding: 5px"> 
													   <button type="button" id='ejecuta_q' name='ejecuta_q' class="btn btn-info btn-sm">Busqueda</button>
													 
													    <button type="button" id='ejecuta_all' name='ejecuta_all' class="btn btn-default btn-sm">Seleccionar todo</button>
													 
												 </div>
  									   </div>	 
									 
									 
									 <table id="jsontableAux" class="display table-condensed" cellspacing="0" width="100%">
										 <thead  bgcolor=#F5F5F5>
										   <tr>   
														<th width="4%">Referencia</th>
											 		    <th width="5%">Comprobante</th>
														<th width="6%">Fecha</th>
														<th width="5%">Identificacion</th>
														<th width="30%">Beneficiario</th>
 														<th width="40%">Detalle</th>
														<th width="5%">Monto</th>
														<th width="5%">Accion</th>
										   </tr>
										</thead>
							 		</table>
									 
								 
									 
									 
								 </div>
								 </div>   
							 </div>
						  </div>

						  <div class="modal-footer" >

							<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>

						  </div>

				</div>
		  
		  <!-- /.modal-content --> 
		  
	  </div>
		  
		  <!-- /.modal-dialog -->
		  
	   </div>
	
	<!-- /.modal -->
	
   </div>  


<div class="container"> 
	
	  <div class="modal fade" id="myModalciu" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio1">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Auxilar (Beneficiario)</h3>
								  </div>

								  <div class="modal-body">
											 <div class="form-group" style="padding-bottom: 10px">
													 <div class="panel panel-default">

														 <div class="panel-body">

															 <div id="ViewFiltroProv"> </div> 
															 
															

														 </div>

													 </div>   
											 </div>
								  </div>

								  <div class="modal-footer" >

									   <div id="guardarciu">  </div> 
									  
									 <button type="button" id="GuardaCiu" class="btn btn-info btn-sm">Actualizar Informacion</button>
									  
									<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
								  </div>

					</div>
			  <!-- /.modal-content --> 
		  </div>
		  <!-- /.modal-dialog -->
	 </div>
	
	<!-- /.modal -->
	
   </div>  


<div class="container"> 
	
	  <div class="modal fade" id="myModalpa" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio1">

					<div class="modal-content">

								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3  class="modal-title">Asignacion de Control de especies</h3>
								  </div>

						
								  <div class="modal-body">
											 <div class="form-group" style="padding-bottom: 10px">
												 
													 <div class="panel panel-default">

														 <div class="panel-body">

															 <div id="ViewFiltroEspecie"> var</div> 
															 
															 
															 <div align="center" id="MensajeParametro"> </div> 

														 </div>

													 </div>   
											 </div>
								  </div>

								  <div class="modal-footer" >

									 <button type="button" id="GuardaPara" class="btn btn-info btn-sm">Actualizar Informacion</button>
									  
									<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
								  </div>

					</div>
			  <!-- /.modal-content --> 
		  </div>
		  <!-- /.modal-dialog -->
	 </div>
	
	<!-- /.modal -->
	
   </div>  

<div class="modal fade" id="myModalxx" role="dialog">
		
  <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Novedades </h4>
        </div>
        <div class="modal-body">
         
			<embed src="" width="100%" height="450" id="DocVisor">
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	
	
		<div class="modal fade" id="myModalExterno" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio2">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Permisos AutoInspección</h4>
											</div>
											<div class="modal-body">
												 
 													 <div class="row">
													
														 	<div class="col-md-12"> 
 																					 <div class="col-md-6" style="padding:5px"> 
																						<input type="text" class="form-control" id="codigo_ex" placeholder="NRO AUTOINSPECCION">
 																					  </div>
 
 																					 
																					 <div class="col-md-6" style="padding:5px"> 
																						<input type="text" class="form-control" id="ruc_ex"  placeholder="NRO IDENTIFICACION/RUC">
 																					  </div>
   
 																					 <div class="col-md-6" style="padding:5px"> 
																							<input type="text" class="form-control" id="nombre_ex"  placeholder="NOMBRE SOLICITA">
 																						  </div>
 
																</div>	
														
																<div class="col-md-12"> 
															
																		 <div align="center" id="Resultado_facturae_id"> </div>	

 												 				</div>
 												 </div>		 
											   </div>			 
											</div>
											<div class="modal-footer">
  												
												 <button type="button" class="btn btn-info" onClick="Enlace_Bomb_permiso()"  >Buscar</button>
												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
         </div>
	
	
		<div class="modal fade" id="myModalExternoBusqueda" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio2">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Permisos AutoInspección</h4>
											</div>
											<div class="modal-body">
												 
 													 <div class="row">
 														
																<div class="col-md-12"> 
															
																		 <div align="center" id="Resultado_facturae_his"> </div>	

 												 				</div>
 												 </div>		 
											   </div>			 
											</div>
											<div class="modal-footer">
  												
 												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
         </div>
	
	
	
<div class="modal fade" id="myModalSecuencia" role="dialog">
		
  <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Novedades </h4>
        </div>
        <div class="modal-body">
            <div class="row"> 
		 			<div class="col-md-12"> 
															
						 <div align="center" id="view_cambio"> </div>	

 					 </div>
		  </div>
        </div>
        <div class="modal-footer">
			
			 <button type="button" onClick="ActualizaEspecie(1)" class="btn btn-success">Actualiza Transaccion</button>
			
			 <button type="button" onClick="ActualizaEspecie(2)" class="btn btn-danger">Actualiza Secuencia</button>
			
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	
     </div>



 </body>
</html>
