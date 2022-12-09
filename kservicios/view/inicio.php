<?php
	session_start( );
  

     require '../model/compra_panel.php';    

     $gestion   = 	new proceso;
?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
    <script type="text/javascript" src="../js/modulo.js"></script>
 	
  <style type="text/css">
	 
  		#mdialTamanio{
  					width: 75% !important;
		}
	 
	  </style>
</head>

<body>

<div id="main">
	
	<div class="col-md-12" role="banner">
 	   <div id="NavMod"></div>
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
		 
			<div class="col-md-4"> 
					<div class="row"> 
													   <div class="alert alert-warning">
															<h4>Tramites pendiente por unidad </h4> 
															<?php    $gestion->producto_unidad(); ?> 
													   </div>		
					  </div>	  

					 <div class="row"> 
													   <div class="alert alert-info">
															<h4>Servicios </h4> 
															<?php    $gestion->productov(); ?> 
													   </div>		
					 </div>	

					  <div class="row"> 
													   <div class="alert alert-warning">
															<h4>Gestion Emision-Recaudacion por rubro </h4> 
															<?php    $gestion->producto_rubro(); ?> 
													   </div>		
					  </div>

			</div>

			<div class="col-md-8"> 
				
															 <div class="col-md-12"> 
																 <h4>Estado de Cuenta</h4> 
																	<div id="ViewUser"></div>	
																	 <div class="col-md-4" style="padding-top: 5px;">
																		 
																		 <button type="button" class="btn btn-sm btn-danger" id="load">Por Cobrar</button>

																		 <button type="button" class="btn btn-sm btn-primary" id="load1">Pagados </button>
																		 
																		 
																		 <button type="button" class="btn btn-sm btn-default" id="load2">Limpiar </button>

																	 </div>
															 </div>		

														   <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"><div id="ViewFormDetalle"> </div></div>
				
														 <div class="col-md-12"> 
																	 <div class="col-md-6" style="padding: 10px"> 
																	 

																												<?php    $gestion->producto_rubro_diario(); ?> 
 																	 </div>	 

																	 <div class="col-md-6" style="padding: 10px"> 
																	 
																												<?php    $gestion->producto_mensual(); ?> 
																				 
																	 </div>	 

																</div>

			</div>

 			 
	  </div>
    
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
   
	
	    <!-- Modal -->
	
    <div class="modal fade" id="myModal" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">

                                <!-- Modal content-->
                                 <div class="modal-content" >
                            <div class="modal-header">
                              <button type="button" class="close"  data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Detalle de Emision</h4>
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
	
</body>
</html>
 