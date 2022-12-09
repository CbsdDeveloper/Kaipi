<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
     <script type="text/javascript" src="../js/co_periodos.js"></script> 
    
	
 	<style type="text/css">
 
	 
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
    padding: 4px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
	 
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#c3e1fb;
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
                   			<span class="glyphicon glyphicon-th-list"></span> Períodos Contables</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Períodos</a>
                  		</li>
			
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Asiento Apertura</a>
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
							  
						 	  				<div class="col-md-12" style="padding: 1px">
								  
  												   <div class="col-md-3" style="background-color:#EFEFEF">
														    <h5>Filtro búsqueda</h5>
														    <div id="ViewFiltro"></div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
															<div style="padding-top: 5px;" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
													</div>
												
													 <div class="col-md-9">
														 
												        <h5>Transacciones por periódo</h5>
														 
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					     <th width="10%">Id</th>
																						<th  width="20%">Año</th>
																						<th width="20%">Mes</th>
																						<th width="10%">Estado</th>
																						<th width="30%">Ultima modificación</th>
																						<th width="10%">Acción</th>
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
								  </div>
								  
							  </div>
					 
                </div>
					  
					   
						   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
					  
									  <div class="panel panel-default">

										  <div class="panel-body" > 

												 <h4>Creacion de asiento de apertura</h4>

													<div class="col-md-12" style="padding: 10px">

													   <div class="col-md-2">
														   Periodo que desea generar
													   </div>	

													   <div class="col-md-2">
															<select id="anio_asiento" class="form-control">
															    <option value="2022">2022</option>	
																<option value="2023">2023</option>
																<option value="2023">2024</option>
															    <option value="2020">2020</option>
															    <option value="2021">2021</option>
															 	<option value="2019">2019</option>
															</select>
													   </div>	

													  <div class="col-md-8">  </div>	

													</div>	  

													<div class="col-md-12" style="padding: 10px">

													   <div class="col-md-12">
														   
														    <button type="button" id= "binicialq" class="btn btn-info">Consultar asiento</button>

															 <button type="button" id= "binicial" class="btn btn-success">Generar asiento</button>


															<button type="button" id= "binicialR" class="btn btn-warning">Generar Resultados</button>

														   <button type="button" id= "binicialO" class="btn btn-primary">Generar Ctas.Orden</button>


															 

															 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModaldato">Acumulacion/Liquidacion</button>

															

															 <button type="button" id= "binicial_ap" class="btn btn-danger">Aprobar asiento</button>

															 <button type="button" id= "binicial_di" class="btn btn-default">Digitado</button>


													   </div>	

												  </div>

												   <div class="col-md-12" style="padding: 10px">
													 <div id="procesados">   </div>

														<div id="montoDetalleAsiento">   </div>

												   </div>


										  </div>
									  </div>
                </div>
					   
                     
     	         </div>
      </div>	  
 </div>
</div>
    

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
										<i class="icon-white icon-search"></i> TRASLADAR CUENTA</button> 
										<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
										
									</div>

				</div>
			  
		  <!-- /.modal-content --> 
	  	  
		  </div>
		  
		  <!-- /.modal-dialog -->
	  </div>
	  
  </div> 




  <div class="container"> 
	  
	  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
		  
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
																 <div id="ViewFiltroAux"> var</div> 
																 <div id="guardarIngreso"></div> 
													   </div>

												 </div> 

											 </div>

								  </div>
					
					<input type="hidden" name="id_asientodx" id="id_asientodx">

									<div class="modal-footer">
										
											<button type="button" class="btn btn-sm btn-default"  onClick="LimpiarAuxiliar()">
										<i class="icon-white icon-archive"></i>  Agregar Nuevo Auxiliar</button> 
										
										
										<button type="button" class="btn btn-sm btn-success"  onClick="AgregaAuxiliar()">
										<i class="icon-white icon-save"></i>  Guardar Nuevo Auxiliar</button> 
										
										
										<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
										
									</div>

				</div>
			  
		  <!-- /.modal-content --> 
	  	  
		  </div>
		  
		  <!-- /.modal-dialog -->
	  </div>
	  
  </div> 
 


<div class="modal fade" id="myModalvalor" tabindex="-1" role="dialog">
	
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
							 
							 <input type="hidden" id='xid_asientoaux' name='xid_asientoaux'>
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


 <div class="container"> 
	  
	  <div class="modal fade" id="myModaldato" tabindex="-1" role="dialog">
		  
  		  <div class="modal-dialog" id="mdialTamanio5">
		  
				<div class="modal-content">

								    <div class="modal-header">

										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h5 class="modal-title">Asistente de asientos</h5>

								     </div>

									<div class="modal-body">

										   <div class="form-group" style="padding-bottom: 5px">

												<div class="panel panel-default">

													   <div class="panel-body">
														   
																  
														   <table id="jsontable_inversion" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					     <th width="10%">Cuenta</th>
																						<th  width="20%">Detalle</th>
																						<th width="10%">Debe</th>
																						<th width="10%">Haber</th>	
  																						<th width="10%">Saldo</th>	
																						<th width="10%"></th>	
 																						</tr>
																					</thead>
															   
 														  </table>
														   
														   
														   
														     <div class="col-md-12">
																    <div align="right" class="col-md-9" style="padding-top:15px">
																			 <b>Saldo Cuenta </b>
																	   </div>
																 	 <div align="right" class="col-md-3" style="padding: 10px">
																 			<input type="text" align="right" id="montoi" name="montoi" class="form-control" value="0.00">
																     </div>
 								  						      </div>
														   
														   
													   </div>

												 </div> 

											 </div>

								  </div>

									<div class="modal-footer">
										
									<button type="button" class="btn btn-sm btn-info"  onClick="inversion(oTable_inversion,'151')">Grupo 151. </button> 
												
									<button type="button" class="btn btn-sm btn-warning"  onClick="inversion(oTable_inversion,'152')">Grupo 152.  </button> 
														
									 
									<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
										
									</div>

				</div>
			  
		  <!-- /.modal-content --> 
	  	  
		  </div>
		  
		  <!-- /.modal-dialog -->
	  </div>
	  
  </div> 


  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 