<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
   	
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

  	
	<script type="text/javascript" src="../js/inv_mov.js"></script> 
    
	
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
  					width: 65% !important;
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
						  
					 
                    <ul id="mytabs" class="nav nav-tabs">        
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   		 <span class="glyphicon glyphicon-th-list"></span> <b>MOVIMIENTO DE INVENTARIOS</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Reportes</a>
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

														   <div class="col-md-12" style="background-color:#EFEFEF">

																	<div id="ViewFiltro"></div> 

																	 <label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>

																	<div style="padding-top: 5px;" class="col-md-10">
																					<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																	</div>


															</div>


															 <div class="col-md-12">
																 
															   <table id="jsontable" class="display table table-striped table-bordered" cellspacing="0" width="100%"  >
																							<thead>
																								<tr>
																								<th width="5%">Transaccion</th>
																								<th width="10%">Fecha</th>
																								<th width="10%">Comprobante</th>
																								<th width="20%">Detalle</th>
																								<th width="15%">Identificacion</th>
																								<th width="20%">Razon Social</th>	
																								<th width="5%" bgcolor=#C0AFCC>Monto IVA</th>
																								<th width="5%" bgcolor=#FD999B>Base Imponible</th>
																								<th width="5%" bgcolor="#E0F79A">Tarifa 0%</th>
																								<th width="5%" bgcolor=" #FC1E21">Total</th> 
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

								  <div class="panel-body" > 
  
										  		 <div class="col-md-12" style="padding-top: 10px;padding-bottom: 5px">
											     	<div class="col-md-4" > </div>
											   	<div class="col-md-4" align="right" >
													 <select id="cbodega" name ="cbodega" class="form-control"></select> 
											    </div>
											   <div class="col-md-4" align="right" >
													 <select id="ccuentas" name ="ccuentas" class="form-control"></select> 
											    </div>
											</div>
										  
 									  
										  
										     <div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">
										  
											    <ul class="nav nav-tabs">
													<li class="active"><a data-toggle="tab" href="#home1">Movimiento de Comprobantes</a></li>
													<li><a data-toggle="tab" href="#menu1">Movimiento Articulos Periodo</a></li>
													<li><a data-toggle="tab" href="#menu2">Resumen Proveedor/Unidad</a></li>
													<li><a data-toggle="tab" href="#menu3">Resumen Anual Movimientos</a></li>
													<li><a data-toggle="tab" href="#menu4"><b>Resumen Periodo Contable</b></a></li>
													<li><a data-toggle="tab" href="#menu5"><b>Resumen Saldos Periodo</b></a></li>
  												</ul>

												  <div class="tab-content">
													   
													     	<div id="home1" class="tab-pane fade in active">
														
															  <div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">

																  <button type="button"  onClick="goToURL(1,'ViewForm1')" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
																  <button  id="printButton" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>
																  <button  id="ExcelButton" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-download-alt"></span></button>

															  </div>
														
															  <div class="col-md-12">

																		<div id="ViewForm1"> </div>

															  </div>	
 														 
 													       </div>
													  
													  
															<div id="menu1" class="tab-pane fade">

																  <div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">

																  <button type="button"  onClick="goToURL(8,'ViewForm2')" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
																  <button  id="printButton2" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>
																  <button  id="ExcelButton2" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-download-alt"></span></button>

															      </div>
																

																 <div class="col-md-12">

																	<div id="ViewForm2"> </div>

																  </div>	


															</div>


															<div id="menu2" class="tab-pane fade">
																
																<div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">

																     <div class="col-md-4">
																	 
																		  <button type="button" title="RESUMEN GENERAL POR UNIDADES"  onClick="goToURL(2,'ViewForm3')" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>

																		  <button type="button" title="RESUMEN DETALLE CONSUMO POR UNIDADES"   onClick="goToURL(201,'ViewForm3')" class="btn btn-info"> <span class="glyphicon glyphicon-th-list"></span></button>

																		 <button type="button" title="RESUMEN GENERAL POR UNIDADES - FINANCIERO"   onClick="goToURL(202,'ViewForm3')" class="btn btn-warning"> <span class="glyphicon glyphicon-usd"></span></button>

 																		 <button type="button" title="RESUMEN GENERAL POR PRODUCTOS"   onClick="goToURL(205,'ViewForm3')" class="btn btn-success"> <span class="glyphicon glyphicon-th-list"></span></button>
																		 
																		  <button  id="printButton3" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>
																		  <button  id="ExcelButton3" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-download-alt"></span></button>
																	
																	  <hr>
																	
																			<input type="text" placeholder="Digite producto/articulo" id='producto_busca' class="form-control" name="producto_busca" >	
																		  
																	    </div>	  
																	
																	 

															      </div>
																

																 <div class="col-md-12">

																	<div id="ViewForm3"> </div>

																  </div>	
															  
																
															</div>


															<div id="menu3" class="tab-pane fade">
																
																<div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">

																  <button type="button"  onClick="goToURL(3,'ViewForm4')" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
																	
																 <button type="button" title="RESUMEN ROTACION DE PRODUCTOS"  onClick="goToURL(301,'ViewForm4')" class="btn btn-info"> <span class="glyphicon glyphicon-alert"></span></button>
																	
																	
																  <button  id="printButton4" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>
																	
																  <button  id="ExcelButton4" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-download-alt"></span></button>

															      </div>
																

																 <div class="col-md-12">

																	<div id="ViewForm4"> </div>

																  </div>	
																
																
																
															 
															</div>
													  
													  
													       <div id="menu4" class="tab-pane fade">
														  
															   <div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">

																  <button type="button"  onClick="goToURL(5,'ViewForm5')" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
																  <button  id="printButton5" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>
																  <button  id="ExcelButton5" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-download-alt"></span></button>

															      </div>
																

																 <div class="col-md-12">

																	<div id="ViewForm5"> </div>
																	 
																	 <div id="view_conta"> </div>
 																	 
																	 
																  </div>	
															   
 														 
															</div>
													  
													  
													       <div id="menu5" class="tab-pane fade">
														  
															 <div class="col-md-12"  style="padding-top: 10px;padding-bottom: 5px">
																 
																 <button type="button" title="Procesar informacion del periodo"  onClick="goToProceso()" class="btn btn-danger"> <span class="glyphicon glyphicon-cog"></span></button>

																  <button type="button" title="Detalle informacion del periodo"  onClick="goToURL(6,'ViewForm6')" class="btn btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
																 
																 
																 <button type="button" title="Detalle informacion del periodo con saldos (+)"  onClick="goToURL(62,'ViewForm6')" class="btn btn-info"> <span class="glyphicon glyphicon-th-list"></span></button>
																 
																    <button type="button" title="Detalle de items General" onClick="goToURL(64,'ViewForm6')" class="btn btn-warning"> <span class="glyphicon glyphicon-transfer"></span></button>
																 
																 
																   <button type="button" title="Resumen informacion del periodo" onClick="goToURL(61,'ViewForm6')" class="btn btn-success"> <span class="glyphicon glyphicon-usd"></span></button>
																 
																 
																  <button type="button" title="Resumen informacion del periodo" onClick="goToURL(63,'ViewForm6')" class="btn btn-default"> <span class="glyphicon glyphicon-usd"></span></button>
																 
																 
																  <button  id="printButton6" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-print"></span> </button>
																  <button  id="ExcelButton6" type="button" class="btn btn-default"> <span class="glyphicon glyphicon-download-alt"></span></button>

															      </div>
																

																 <div class="col-md-12">

																	<div id="ViewForm6"> </div>
																	 
																	 <div id="ViewForm61"> </div>

																  </div>	
															   
 
															  
															</div>
													  
												  </div>
										  
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


  <!-- Modal -->
	
  <div class="modal fade" id="myModalActualiza" role="dialog">
	  
      <div class="modal-dialog" id="mdialTamanio2">
    
<!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Articulo</h4>
        </div>
        <div class="modal-body">
         <div id='VisorArticuloActualiza'></div>
		 <p id="GuardaDatoA">&nbsp;   </p>	
        </div>
        <div class="modal-footer">
			<button type="button" onClick="ActualizaCuenta();" class="btn btn-warning" >Actualizar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
 </body>

</html>