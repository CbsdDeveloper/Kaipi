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
 
<script  type="text/javascript" language="javascript" src="../js/co_xpagar_nomina_enlace.js?n=1"></script>
	
 
	
	
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
  					width: 90% !important;
		}
	 
	 	 #mdialTamanio_aux{
  					width: 85% !important;
		}
	 
	  #mdialTamanio_a{
  					width: 65% !important;
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

	
</head>
<body>

	<!-- ------------------------------------------------------ -->  
	<div class="col-md-12" role="banner">

		<div id="MHeader"></div>
 
	</div> 
 	
	<div id="mySidenav" class="sidenav" >
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
   </div>
	
	
     <div class="col-md-12"> 
       
 
				<ul id="mytabs" class="nav nav-tabs">  
					 
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>TRAMITES  NOMINA</b></a>
										</li>
			
			 
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-forward"></span> Asiento Cuentas por Pagar</a>
										</li>
			
										 
  			
				 </ul>
		 
                <!-- ------------------------------------------------------ -->
				<!-- Tab panes -->
				<!-- ------------------------------------------------------ -->
		 
				<div class="tab-content">
					
 					 <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
									  <div class="panel panel-default">
										   <div class="panel-body" > 
											   <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px">												   
												       <div class="col-md-3">
														  <b> SELECCIONE PROCESOS ROLES DE PAGO </b>
															<select  onChange=" BusquedaGrillaTramite(oTableTramite,this.value)" class="form-control" id="estado_tipo" name="estado_tipo">
															  <option value="5">En Tramite</option>
															  <option value="6">Generadas</option>
															</select>
														</div>  
														
											   </div>   
											   
											    <div class="col-md-12">
										   
											  <div class="table-responsive" id="mployee_table1">  
													<table id="jsontable_tramite" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																							<thead>
																								<tr>
																								<th width="5%">Tramite</th>
																								<th width="8%">Fecha</th>
																							    <th width="21%">Beneficiario</th>	
																								<th width="8%">Comprobante</th>	
																								<th width="15%">Unidad</th>
																								<th  width="36%">Detalle</th>
																								<th width="7%">Acción</th>
																								</tr>
																							</thead>
													</table>
												</div>    
													
										       </div>    
										   </div>
									  </div>
					 </div>
	 								
					<!-- Tab 2 -->
					
					<div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
										   
											   <div id="ViewForm"> </div>
										   
											   <div class="col-md-12">
												   
													<div class="alert al1ert-info fade in">
														
															<div class="col-md-12">
																
																<div class="col-md-6">
																	
																	 <div class="col-md-12">
																				<div id="DivAsientosTareas"></div>
																	</div>	  
																	
																	   <div class="col-md-12">
																		     <div class="col-md-6"> 
																		   
																		   <button type="button" class="btn btn-sm btn-default"  onClick="Suma()">
																				<i class="icon-white icon-asterisk"></i> Total Parcial
																			</button> 
																				 
																		     </div>
																			 <div class="col-md-3" style="font-size: 12px;font-weight: 600"><div id="taumento" align="right"></div></div>
																			 <div class="col-md-3" style="font-size: 12px;font-weight: 600"><div id="tdisminuye" align="right"></div></div>
																		</div>	 
																	
																 </div>		
																
																<div class="col-md-6">
																	
																	<div class="alert alert-success">
 																			<div id="DivNomina"></div>
																	 </div>	
																 </div>		
																
															</div>	
																
														    

													 </div>
												   
                     						  </div>
											   
											   
											 
				 
											   
										   </div>
									  </div>
					 </div>
					
					<!-- Tab 3  -->
					
					 
					
				 
  									
	 			</div>
       
	 </div>	  

 


  <input type="hidden" id='id_asientoda' name="id_asientoda" value="0">

  <input type="hidden" value="0" id="xid_asientod" name="xid_asientod">

<input type="hidden" value="0" id="xid_asientoaux" name="xid_asientoaux">

  <input type="hidden" value="0" id="xtipo" name="xtipo">


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

     <!-- /.auxiliar -->  
   
   <div class="container"> 
	  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
  	 <div class="modal-dialog" id="mdialTamanio_aux">
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
 					  		 <div id="guardarAux"></div> 
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
	  <div class="modal fade" id="myModalGasto" tabindex="-1" role="dialog">
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
														<th width="10%">Programa</th>
														<th width="30%">Detalle</th>
														<th width="30%">Concepto</th>
														<th width="10%">Clasificador</th>
														<th width="10%">Monto</th>	
 														<th width="10%">Acción</th>
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
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div> 

   
  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAsistente" tabindex="-1" role="dialog">
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
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAsientoDetalle()">
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



	<!-- Actualizar monto aux -->



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

				</div>
		  
		  <!-- /.modal-content --> 
		  
	  </div>
		  
		  <!-- /.modal-dialog -->
		  
	   </div>
	
	<!-- /.modal -->
	
   </div>  

 
<input type="hidden" id='id_asientoda' name="id_asientoda" value="0">

<div class="modal fade" id="myModalAnticipo" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio_a">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Asistente de Cierre Anticipos</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewAsientoAnticipo"> var</div> 
 					  		 <div id="guardarAnticipo"></div> 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAsientoAnticipo()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>



<div class="modal fade" id="myModalbas" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Asistente presupuesto</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewAsientoBas"> var</div> 
 					  		 <div id="guardarBas"></div> 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarAsientoBas()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>




<div class="modal fade" id="myModalvalor" tabindex="-14" role="dialog">
  	 	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Actualizar valor auxiliar</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		   <div class="col-md-4">
							   	Actualizar Monto Auxiliar
							   </div>
							   <div class="col-md-8">
								   <input type="text" id="monto_pone" name="monto_pone" class="form-control">
							   </div>
							 
							 <hr> 
 					  		 <div align="center" id="guardar_valor"></div> 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="guarda_monto_aux()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>
  
<!-- Page Footer-->
  <div id="FormPie"></div>  
    
    

 </body>

</html>
 