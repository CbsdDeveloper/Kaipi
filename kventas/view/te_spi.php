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
	
 	<script type="text/javascript" src="../js/te_spi.js"></script> 
 	 		 
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
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b> INFORMACION TRASFERENCIAS GENERADAS</b>  </a>
                   		</li>
	
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> LISTA DE TRASFERENCIAS DE SPI</a>
                  		</li>
	
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-file"></span> GENERACION DE SPI</a>
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
		  		  	     
		  		  	       <div class="col-md-12" style="background-color:#ededed">
  									 
   										        <div id = "ViewFiltro" > </div>
   											 
												
							   					<div class="col-md-10" style="padding-top: 10px;padding-bottom: 10px">
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
												</div>
  										 
   								     
 				  		     </div> 
							 
					 	  	     
 			  		  	     <div class="col-md-12"> 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
													<th width="10%">Transaccion</th>
												    <th width="10%">Referencia</th>
												    <th width="10%">Fecha</th>
												    <th width="30%">Detalle</th>
										   		    <th width="10%">Beneficiario</th>
													<th width="10%">Elaborado</th>
										            <th width="10%">Monto</th>
  													<th width="10%">Accion</th>
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
								
								     <div class="col-md-12" style="padding-left: 250px;padding-top: 10px;padding-bottom: 10px"> 
										 <a href="#" class="btn btn-info btn-sm" data-toggle="modal" onClick="BusquedaGrillaSpi(oTableAux)" data-target="#myModalprov" role="button">Agregar beneficiarios</a>
										 
										 
										  <a href="#" class="btn btn-default btn-sm"   onClick="AgrupaPago()" >Agrupa beneficiario pago</a>
										 
									  </div>
								
								   <div id="ViewFormDetalle"> </div>
						   
               		       </div>
                	  </div>
             	 </div>
			   
		
			 <!-- ------------------------------------------------------ -->
             <!-- Tab 3 -->
             <!-- ------------------------------------------------------ -->
           
                 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
					 
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						    
 								
								     <div class="col-md-12" style="padding-left: 130px;padding-top: 10px;padding-bottom: 10px; height:600px"> 
										  
										 
 										  <h4>Generacion de archivos y reporte</h4>
  										  <button type="button" onClick="GeneraArchivoSpi()" class="btn btn-sm btn-default">Generar Archivo SPI</button>
										 
										 
										  <button type="button" onClick="GeneraArchivoProveedor()" class="btn btn-sm btn-success">Generar Archivo Proveedores</button>
										 
										 
										  <div class="btn-group">
											<button type="button" class="btn btn-sm btn-warning">Descargar archivos SPI</button>
											<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
											  <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
											  <li><a  href="../../spi/spi-sp.txt" download="spi-sp.txt">Descargar TXT</a></li>
											  <li><a  href="../../spi/spi-sp.md5" download="spi-sp.md5">Descargar MD5</a></li>
											  <li><a href="../../spi/spi-sp.zip" download="spi-sp.zip">Descargar ZIP</a></li>
											  <li><a href="../../spi/proveedor.txt" download="proveedor.txt">Descargar Proveedor</a></li>	
											</ul>
									      </div>
										 
										 
										  <div class="btn-group">
											<button type="button" class="btn btn-sm btn-info">Reporte Trasferencias</button>
											<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
											  <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
											  <li><a onClick="impresion_spi('InformeSpi')" href="#">Resumen SPI</a></li>
											  <li><a onClick="impresion_spi('InformeProveedor')"  href="#">Resumen Proveedores</a></li>
  											</ul>
									      </div>
										 
 										 
								 
										
 										  <div id="GeneraArchivotxt"> </div>
										 
										  <div id="ViewFormProceso"> </div>
										 
									  </div>
								
								   
						   
               		       </div>
                	  </div>
             	 </div>
			   
			   
			   
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   


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
													<select name="nmes1" id="nmes1"  class="form-control">
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
									<h3  class="modal-title">Parametros SPI</h3>
								  </div>

								  <div class="modal-body">
											 <div class="form-group" style="padding-bottom: 10px">
													 <div class="panel panel-default">

														 <div class="panel-body">

															 <div id="ViewFiltroSpi"> var</div> 
															 
															 
															 <div id="MensajeParametro"> </div> 

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


 </body>
</html>
