<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
   	
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript"></script>
  
	<script type="text/javascript" src="../js/inv_saldos.js"></script> 
    
	<style type="text/css">
		
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
		#mdialTamanio{
  					width: 75% !important;
        }   
     
       #mdialNovedad{
  					width: 55% !important;
        }  
	 
		.highlight {
  					background-color: #FF9;
		}
		.ye {
  					background-color:#93ADFF;
		}
            
	 
	   .ya {
  					background-color:#FDA9AB;
		}
 	
    .table1 {
      border-collapse: collapse;
 	  font-size: 12px;
    }
    	
     .filasupe {
     
     	border-bottom: 1px solid #ddd;
    	border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
    	border-top: 1px solid #ddd;
    	padding-bottom: 4px; 
    }
    	
    .derecha {
     
         border-right: 1px solid #ddd;
    	  
     }
</style>	

</head>
	
<body>
    
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
	
	
       <!-- Content Here -->
       
    <div class="col-md-12"> 
    
       <!-- Content Here -->
       
	    <div class="row">
			
 		 	     <div class="col-md-12">
 						   	 
                    <ul id="mytabs" class="nav nav-tabs">   
						
                   		<li class="active"><a href="#tab1" data-toggle="tab">
                   				<span class="glyphicon glyphicon-th-list"></span> <b>SALDOS POR BODEGA</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle de Movimientos</a>
                  		</li>
			
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-barcode"></span> kardex por producto</a>
                  		</li>
 			
                   </ul>
					 
                    
                   <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                   
                   <div class="tab-content">
					   
						   <!-- Tab 1 -->
					   
						   <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px;">
							   
							  <div class="panel panel-default">
								  
								  <div class="panel-body" > 
									  
									<div class="col-md-12" style="padding: 1px">

											 <div class="col-md-12" style="padding: 15px; background-color:#ededed;">

																	<div id="ViewFiltro"></div> 

																	<label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
																	<div style="padding-top: 5px;" class="col-md-10">


																		<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																		
																		<button type="button" class="btn btn-sm btn-danger" id="loadposi">  <i class="icon-white icon-search"></i> Buscar (+) </button>	
																		


																		 <button type="button" class="btn btn-sm btn-default" id="loadSaldo" title="Saldos de bodega">  
																			<i class="icon-white icon-ambulance"></i></button>


																		<button type="button" class="btn btn-sm btn-success" id="loadxls" title="Descargar archivo en excel">  
																			<i class="icon-white icon-download-alt"></i></button>

																		
																		<button type="button" class="btn btn-sm btn-info" id="loadxls1" title="Descargar archivo en excel Con saldos">  
																			<i class="icon-white icon-download-alt"></i></button>
																		
																			<button type="button" class="btn btn-sm btn-default" id="saldos_costos" title="Calcular costos">  
																			<i class="icon-white icon-dollar"></i></button>



																		<button type="button" class="btn btn-sm btn-default" id="loadxls_cero" title="Descargar archivo en saldo Cero">  
																			<i class="icon-white icon-bell"></i></button>

																	</div>
 
											 </div>
										
											 <div class="col-md-12">

														<table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																 <thead>
																	<tr>
																		<th width="5%">Cod</th>
																		<th width="25%">Producto</th>
																		<th width="10%">Cuenta</th>
																		<th width="10%">Referencia</th>
																		<th width="15%">Categoria</th>
																		<th width="10%">Costo</th>
																		<th width="5%" bgcolor=#C0AFCC>Ingreso</th>
																		<th width="5%" bgcolor=#FD999B> Egreso</th>
																		<th width="10%" bgcolor="#E0F79A">Saldo</th>
																		<th width="5%"> </th>
																	</tr>
																 </thead>
																</table>
												 </div>  
										
												<div class="col-md-12">
															<div id="SaldoBodega"></div>
												 </div>
										 </div>
									  
								</div>  
								  
							 </div> 
							   
						</div>
           
						   <!-- Tab 2 -->

						   <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
							  <div class="panel panel-default">
								  <div class="panel-body" > 
										 <a href="javascript:void(0);" class="btn-success" id="printButton">&nbsp;Impresión&nbsp;</a> 
									   <div id="ViewForm"> </div>
									  <div id="ViewFormres"> </div>
								  </div>
							  </div>
						   </div>
					   
							<!-- Tab 3 -->
                    
 							 <div class="tab-pane fade in" id="tab3">
 					 
						<div class="panel panel-default" style="padding: 1px">
								<div class="panel-body" style="padding: 1px"> 
									
									<div class="col-md-3" style="padding: 15px">
 											  <input type="date" class="form-control" id="fecha1" >
 									</div>
										
									<div class="col-md-3" style="padding: 15px">
 											  <input type="date" class="form-control" id="fecha2">
 									</div>
									<div class="col-md-6" style="padding: 15px">
  											  <button type="button" class="btn btn-sm btn-primary" id="loadKardex">  <i class="icon-white icon-search"></i> Buscar</button>
   									</div>
									 
									
								   <input type="hidden" id="itemkardex">	 
									
									<div class="col-md-12" style="padding: 5px">						 
											<div id="ViewKardex"> </div>
									</div>		
 							   </div>
						  </div>

					 </div>   
               
        		 </div>
					 
			 </div>	  
 		</div>
		
    </div>
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
	
	<div class="container">

		 <div class="modal fade" id="myModal" role="dialog">
	 
		    <div class="modal-dialog">

				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Ver Datos</h4>
					</div>
							<div class="modal-body">
									<div class="row">
										<div class="col-md-12" style="padding: 25px">
											
												  <div class="col-md-3" style="padding: 4px">
													  Movimiento
												  </div>	  
												  <div class="col-md-9" style="padding: 2px">
														<input type="number" class="form-control" name="mov" readonly id="mov">
												   </div>	 
												    <div class="col-md-3" style="padding: 4px">
													  Cantidad
												  </div>
												   <div class="col-md-9" style="padding: 2px">
														<input type="number" class="form-control" name="cantidad" readonly id="cantidad">
												   </div>

											       <div class="col-md-3" style="padding: 4px">
													  Costo
												  </div>	  
												  <div class="col-md-9" style="padding: 2px">
														<input type="number" class="form-control" name="costo" id="costo">
												   </div>
											
											    <input type="hidden" name="prod" id="prod"> 
										</div>
									 </div>
							</div>
					  
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" onClick="Actualizar_monto()" >Actualizar</button>
								
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
				  </div>

    		</div>
			 
 		 </div>
	
	</div>  
	 
	
  </body>

</html>
 