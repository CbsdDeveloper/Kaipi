<?php  
session_start( );  
?>
<!DOCTYPE html>
<html lang="en">
	
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ven_tasa.js"></script> 
	
 		
 
 	 
	<style>
		
    	#mdialTamanio{
      			width: 55% !important;
   			 }
		iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
  
	</style>
	
	 
	
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

                                <li class="active"><a href="#tab2" data-toggle="tab">
                                    <span class="glyphicon glyphicon-link"></span>Emisión Tasas/Otros</a>
                                </li>

                                <li ><a href="#tab1" data-toggle="tab"></span>
                                <span class="glyphicon glyphicon-th-list"></span> <b>Detalle de Cobros Diaria</b>  </a>
                                </li>

                    </ul>

                   <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
	
                   <div class="tab-content" >

									 <!-- ------------------------------------------------------ -->
									 <!-- Tab 2 -->
									 <!-- ------------------------------------------------------ -->

									 <div class="tab-pane fade in active" id="tab2"  style="padding-top: 3px">

											  <div class="panel panel-default" style="padding: 1px">

												<div class="panel-body" style="padding: 1px"> 

															<div id="ViewForm"> </div>
												</div>

											  </div>

									  </div>
					   
								   <!-- ------------------------------------------------------ -->
								   <!-- Tab 1 -->
								   <!-- ------------------------------------------------------ -->
					   

									<div class="tab-pane fade in" id="tab1" style="padding-top: 3px">
										
											  <div class="panel panel-default">
												  
												  <div class="panel-body" > 

														<div class="col-md-12"> 

															<div class="alert alert-info">

																		<div class="row">

																				<div id = "ViewFiltro" > </div>

																				<div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 

																				<div class="col-md-4" style="padding-top: 5px;">
																					<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
																				</div>
																		 </div>
															</div>

														 </div> 

														<div class="col-md-12"> 
															
																<table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
																				 <thead  bgcolor=#F5F5F5>
																					   <tr>   
																							 <th width="10%">Fecha</th>
																							 <th width="5%">Factura</th>
																							 <th width="30%">Cliente</th>
																							 <th width="10%">Base Imponible</th>
																							 <th width="5%">IVA</th>
																							 <th width="5%">Tarifa 0</th>
																							 <th width="5%">Total</th>
																							 <th width="5%">Enviado</th>
																							 <th width="5%">Asiento</th>
																							<th width="20%">Accion</th>
																					   </tr> 
																				</thead>
																 </table>


													 </div>  

														<div class="col-md-12" style="padding: 10px;">

														  <a href="admin_cuenta" title = "Actualice la cuenta de servicio y/o producto de la factura" class="btn btn-sm btn-primary" rel="pop-up"> 
															  <i class="icon-white icon-ambulance"></i></a>


													  </div>

													   <div id="ViewCuenta"> Para contabilizar seleccione la factura</div>

												  </div>  
											 </div> 
									 </div>


                       		 

                    </div>

         </div>

 
	
	
    <!-- Modal -->
	
    <div class="modal fade" id="myModal" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">

                                <!-- Modal content-->
                                 <div class="modal-content" >
                            <div class="modal-header">
                              <button type="button" class="close"  data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Articulo</h4>
                            </div>
                            <div class="modal-body">
                                    <div id='VisorArticulo'></div>
								    <div id='GuardaArticulo'></div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>

                            </div>
     </div>
	
	<!-- Modal -->
	
    <div class="modal fade" id="myModalvar" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Definir variables</h4>
											</div>
											<div class="modal-body">
												 
													<div class="row">
														<div class="col-md-12"> 
															<div id='VisorVariables'></div>
														</div>	
													</div>	
												 
											</div>
											<div class="modal-footer">
												
												 <button id="botonn" onClick="GeneraDetalleImp()" type="button" class="btn btn-success"  >Generar Detalle</button>
												
												
 											     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
									   </div>
                             </div>
     </div>
	
             <!-- Page Footer-->
	
    <div id="FormPie"></div>  
    
</div>

</body>
</html>
