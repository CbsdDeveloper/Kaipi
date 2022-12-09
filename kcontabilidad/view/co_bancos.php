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
  		#mdialTamanio{
  					width: 75% !important;
		}
	 
	   #mdialTamanioCheque{
  					width: 65% !important;
		}
	 
	   #mdialTamanioNota{
  					width: 55% !important;
		}
	 
	 
  </style>

    <script type="text/javascript" src="../js/co_bancos.js"></script> 
    
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
 								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
								<ul id="mytabs" class="nav nav-tabs">                    
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>CONCILIACION BANCARIA</b>  </a>
										</li>
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-link"></span> REGISTRO DE CONCILIACION BANCARIA
											</a>
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
 										   
											   
										 
											   
  													<div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);
box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
													    
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
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					    <th width="10%">Id</th>
																						<th width="10%">Fecha</th>
																						<th width="5%">Anio</th>
																						<th width="5%">Mes</th>
																						<th width="30%">Detalle</th>
																						<th width="10%">estado</th>
																					    <th width="10%">Saldo Banco</th>
																						<th width="10%">Saldo Estado</th>
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
								
										   <div class="panel-body"> 
										   
											   <div id="ViewForm"> </div>
										   
										   </div>
									  </div>
								 </div>
								 
							</div>
			 </div>	  
 	 
     <!-- /.auxiliar -->  
  <div class="container" > 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	    	<div class="modal-dialog" id="mdialTamanioCheque">
				<div class="modal-content">
				 		  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3  class="modal-title">CHEQUES GIRADOS Y NO COBRADOS</h3>
				  </div>
						  <div class="modal-body">
						   <div class="form-group" style="padding-bottom: 10px">
							  <div class="panel panel-default">

								 <div class="panel-body">
									 <div id="ViewFiltroCheque"> var</div> 
									  <p>&nbsp; 	     </p>   
								 </div>
								 </div>   
							 </div>
						  </div>
 		 		  		  <div class="modal-footer">
			  					<button type="button" onClick="myFunctionCheque()" class="btn btn-sm btn-success" data-dismiss="modal">Generar informacion</button>
			  
 								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  		 		  </div>
				</div><!-- /.modal-content --> 
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  

	  <!-- /. costos  -->  
  <div class="container"> 
	  <div class="modal fade" id="myModalDeposito" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">DEPOSITOS O TRASFERENCIA PENDIENTES</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
  				         <div class="panel-body">
 					  			 <div id="ViewFiltroDeposito"> var</div> 
							  <p>&nbsp; 	     </p>   
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
	
		  <!-- /. pagos  -->  
  <div class="container"> 
	  <div class="modal fade" id="myModalEstado" tabindex="-1" role="dialog">
  	     <div class="modal-dialog" id="mdialTamanioNota">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Movimiento Estados de Cuenta - Nota Credito/Debito</h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewNota" >xxxx</div> 
 					  	 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
		 
			  <button type="button" class="btn btn-sm btn-info" data-dismiss="modal" onClick="myFunctionNota()">Guardar</button>
			  
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
 