<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
	
 <style type="text/css">
  	#mdialTamanio{
  					width: 75% !important;
		}
	 
	#mdialTamanio4{
  					width: 65% !important;
		}
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#EDECF0;
	  }
	  .sa {
  			 background-color:#FFACAD;
	  }
	 
	.form-control_asiento {  
		  display: block;
		  width: 85%;
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
			padding: 5px;
			line-height: 1.42857143;
			vertical-align: top;
			border-top: 1px solid #ddd;
     }
	 
	 
  </style>
	
 <script type="text/javascript" src="../js/co_validacion_grupo.js"></script> 
    
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
 								<!-- Nav tabs     -->     
		
								<ul id="mytabs" class="nav nav-tabs">
									
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>1. RESUMEN GESTION POR GRUPOS</b>  </a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> 2. Detalle de Informacion</a>
										</li>
										
										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> 3. Detalle de Asientos</a>
										</li>
									 
								</ul>
	
								<!-- ------------------------------------------------------ -->
								<!-- Tab panes -->
								<!-- ------------------------------------------------------ -->
								<div class="tab-content">
								   <!-- Tab 1 -->
									
								   <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
									  <div class="panel panel-default">
										  <div class="panel-body" > 
 										   <div class="col-md-12" style="padding: 1px">
 										   
  												  	    <div class="col-md-12" style="background-color:#ededed;padding-bottom: 10px">
													    
														   
														    <div id="ViewFiltro"></div> 
														   
														 
															<div style="padding-top: 5px;" class="col-md-2">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
															</div>
														 
													 </div>
												
														<div class="col-md-12">
	          <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 14px">
																					<thead>
																						<tr>
																						<th width="7%" align="center">Tipo</th>	
																					    <th width="10%" align="center">Grupo Presupuestario</th>
																						<th width="8%" align="center">Devengado (A)</th>
																					    <th width="5%"> </th>
																						<th width="10%" align="center">Grupo Contable</th>
																						<th width="9%" align="center">Debe (B)</th>
																						<th width="9%" align="center">Haber (C) </th>
																						<th width="7%" align="center">Saldo (B-C)</th>
																						<th width="5%"> </th>	
																						<th width="10%" align="center">Pagado/Recaudado</th>
																						<th width="10%" align="center">(-) Presupuesto</th>
																						<th width="10%" align="center">(-) Contabilidad</th>	
																					 
																					  </tr>
																					</thead>
														  </table>
	
	 													  <div class="col-md-12"> 
															  <div class="col-md-4" style="font-size: 12px;font-weight: 600"> 
																   <h5>GASTO</h5>
 																   Devengado (A) = Haber (C)<br>
																   Pagado (Pagado/Recaudado)   = Debe (B)
																  
															  </div>  	
															  
															    <div class="col-md-4" style="font-size: 12px;font-weight: 600"> 
																   <h5>INGRESO</h5>
 																   Devengado (A) = DEBE (B)<br>
																   Recaudado (Pagado/Recaudado)   = Haber (C)
																  
															  </div>  	
															  
															  
													      </div>  		  
		 
												  </div>  
  											</div>
											  
									   </div>  
									 </div> 
								  </div>
								
								   <!-- Tab 2 -->
								   <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body"> 
										   
											     <div id="ViewForm"> </div>
 											   
											  <div class="col-md-12"  style="padding: 10px">
												   <div class="col-md-3">
													  		 <select name="tipo_cta" id="tipo_cta" class="form-control">
													  		   <option value="1">Agrupado por Cuenta</option>
													  		   <option value="2">Agrupado por Grupo</option>
													  		 </select>
													</div>   
											 </div>
											   
											   <div class="col-md-12">
														  <div class="col-md-6">
																	<table id="jsontable_grupo_dev" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 13px">
																								<thead>
																									<tr>
																									<th width="30%" align="center">Grupo Presupuestario</th>
																									<th width="30%" align="center">Grupo Contable</th>
																									<th width="40%" align="center">Devengado (A)</th>
																								  </tr>
																								</thead>
																	  </table>
																	 <div class="col-md-12" align="right" style="padding-bottom: 15px; font-size: 13px;font-weight: bolder;padding: 10px">
																		<div id="devengo1">SUMA</div>
																	 </div>

															  </div>
											   
															  <div class="col-md-6">
																 <table id="jsontable_grupo_conta" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 13px">
																								<thead>
																									<tr>
																									<th width="30%" align="center">Grupo Presupuestario</th>
																									<th width="30%" align="center">Grupo Contable</th>
																									<th width="15%" align="center">Debe (A)</th>
																									<th width="15%" align="center">Haber (B)</th>
																									<th width="10%" align="center">Saldo</th>	
																								  </tr>
																								</thead>
																	  </table>

																	 <div class="col-md-12" align="right" style="padding-bottom: 15px;">
																		  <div class="col-md-6" style="font-size: 13px;font-weight: bolder;"> </div>
																			 
																		  <div class="col-md-2">
																			  <div id="devengo2" style="font-size: 13px;font-weight: bolder;">SUMA</div>
																		  </div>
																		  <div class="col-md-2" style="font-size: 13px;font-weight: bolder;">
																			  <div id="devengo3">SUMA</div>
																		  </div> 
																		 <div class="col-md-2"> </div>
																		 
																		 
																	 </div>
															  </div>
											  </div>	  
											   
										   </div>
									  </div>
								 </div>

									
							 <!-- Tab 3 -->
									
								 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body"> 
 											   
											      <div class="col-md-5" style="padding: 10px; background-color: #FDDCDD">
 														<table id="jsontable_asiento_dev" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 10px">
																					<thead>
																						<tr>
																					    <th width="10%" align="center">Asiento</th>
																						<th width="20%" align="center">Cuenta</th>
																						<th width="30%" align="center">Partida</th>
																					    <th width="20%" align="center">Item</th>
																					    <th width="10%" align="center">Debe</th>
																						<th width="10%" align="center">Haber</th>
																					  </tr>
																					</thead>
														  </table>
													  
													     <div class="col-md-12" align="right" >
															 <div class="col-md-6"></div>
														    <div class="col-md-3"><div style="font-size: 12px;font-weight: bolder;padding: 10px" id="devengo45"> </div></div>
 														    <div class="col-md-3"><div style="font-size: 12px;font-weight: bolder;padding: 10px" id="devengo46"> </div></div>
													     </div>
													  
                       							  </div>
											   
											      <div class="col-md-7">
													 <table id="jsontable_asiento_conta" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%" style="font-size: 10px">
																					<thead>
																						<tr>
																					   <th width="5%" align="center">Asiento</th>
																						<th width="7%" align="center">Fecha</th>
																						<th width="10%" align="center">Cuenta</th>
																						<th width="47%" align="center">Detalle</th>
																						<th width="10%" align="center">Partida</th>
 																					    <th width="7%" align="center">Debe</th>
																						<th width="7%" align="center">Haber</th>
																						<th width="7%" align="center">Saldo</th>	
																					  </tr>
																					</thead>
														  </table>
													  
													   <div class="col-md-12" align="right" >
														    <div class="col-md-10"><div style="font-size: 14px;font-weight: bolder;padding: 10px" id="devengo4"> </div></div>
 														    <div class="col-md-2"><div style="font-size: 14px;font-weight: bolder;padding: 10px" id="devengo5"> </div></div>
													     </div>
													  
                       							  </div>
											  	  
											   
										   </div>
									  </div>
								 </div>
  
							</div>
	 </div>	  
  

  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
  	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Selección de Auxilar (Beneficiario)</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroAux"> var</div> 
							  <p>&nbsp; 	     </p>   
 					  		 <div align="center" id="guardarAux"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAuxiliar()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	  
   </div>  

	 

  <div class="container"> 
 	  <div class="modal fade" id="myModalCostos" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h5 class="modal-title">Selección de Costos</h5>
				  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			            <div class="panel panel-default">
 								 <div class="panel-body">
									 <div id="ViewFiltroCosto"> var</div> 
									 <div id="guardarCosto"></div> 
								 </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
		    <button type="button" class="btn btn-sm btn-primary"  onClick="GuardarCosto()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div>
 	   <!-- /.modal-content --> 
	  </div>
	  <!-- /.modal-dialog -->
 	</div>
	<!-- /.modal -->
   </div> 
	

  <!-- /. pagos  -->  
  <div class="container"> 
	  <div class="modal fade" id="myModalPago" tabindex="-1" role="dialog">
  	     <div class="modal-dialog" id="mdialTamanio">
			<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 class="modal-title">Comprobante de pago</h3>
				  </div>
				  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewPago" >xxxx</div> 
 					  	 
					     </div>
					     </div>   
  					 </div>
				  </div>
 				  <div class="modal-footer">
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
	  <div class="modal fade" id="myModalAsistente1" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio1">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Asistente de asientos</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewAsientoGasto"> var</div> 
 					  		 <div id="guardarGasto"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				  <div class="modal-footer">
 					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div>
	    <!-- /.modal-content --> 
	  </div>
		<!-- /.modal-dialog -->
	</div>
	  <!-- /.modal -->
   </div> 
	

	  <!-- /. costos  -->  
  <div class="container"> 
	  <div class="modal fade" id="myModalAuxIng" tabindex="-1" role="dialog">
  		  <div class="modal-dialog" id="mdialTamanio4">
		  
		<div class="modal-content">
			
				   <div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h5 class="modal-title">Asistente de asientos</h5>

				  </div>
			
				   <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 5px">
					   
			            <div class="panel panel-default">
  				  		       <div class="panel-body">
 					  		 <div id="ViewFiltroIngreso"> var</div> 
 					  		 <div id="guardarIngreso"></div> 
					     </div>
					     </div> 
					   
  					 </div>
					  
				  </div>
				
			       <div class="modal-footer">
		    <button type="button" class="btn btn-sm btn-primary"  onClick="AgregaCuenta_enlace()">
		    <i class="icon-white icon-search"></i> Guardar</button> 
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
			
		</div>
		  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	  </div>
	  
    </div> 


  <div class="container"> 
	  <div class="modal fade" id="myModalAsistente" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Enlace contable presupuestario</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
						 <div class="panel-body">
 					  		  <table id="jsontable_gasto" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th width="20%">Partida</th>
														<th width="10%">Clasificador</th>
														<th width="10%">Cuenta</th>	
														<th width="50%">Detalle</th>
														<th width="10%">Disponible</th>
 													</tr>
												</thead>
									</table>
 					  		 <div id="guardarGasto"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog myModalAsistente
	</div><!-- /.modal -->
   </div> 
  </div> 	



<div class="container"> 
	  <div class="modal fade" id="myModalprov" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Auxilar (Beneficiario)</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroProv"> var</div> 
 					  		 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer" >
		   
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  


<div class="container"> 
	
	  <div class="modal fade" id="myModalfactura" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Comprobantes electronicos emitidos por tramite </h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
							 <div class="panel-body">
								<div class="col-md-12">
												   
													<div class="alert al1ert-info fade in">
  														  
														 <table id="jsontable_factura" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																<thead>
																	<tr>
																							    <th width="10%">Fecha</th>
																								<th width="10%">Identificacion</th>
																								<th width="30%">Beneficiario</th>
																							    <th width="10%">Factura</th>	
																								<th width="10%">Tarifa 0%</th>	
																								<th width="10%">Base Imponible</th>
																								<th  width="10%">Monto Iva</th>
																								<th width="10%">Retencion</th>
																	</tr>
															     </thead>
																  </table>
															 
													 </div>
												   
                     						  </div>

							 </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer" >
		   
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  


 
										   
											   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  

 

 </body>

</html>
 