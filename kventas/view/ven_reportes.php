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

 
	<script type="text/javascript" src="../js/ven_reportes.js"></script> 
    
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
            
</style>	
	
</head>
	
<body>

  <!-- ------------------------------------------------------ -->
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
	
	
       <!-- Content Here -->
    <div class="col-md-12"> 
       <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
					 	 
                    <ul id="mytabs" class="nav nav-tabs">   
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   				<span class="glyphicon glyphicon-th-list"></span> <b>REPORTE DETALLE POR CATEGORIA - SERVICIOS</b>  </a>
                   		</li>
			
						<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Resumen Arrendamientos</a>
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
 						 
  									 <div class="col-md-12" style="padding: 15px; background-color:#ededed;">
										 
										 	<div style="padding-top: 5px;" class="col-md-10">
 														    <div id="ViewFiltro"></div> 
  										 
															<div style="padding-top: 5px;" class="col-md-10">
																	
																
																<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																
 																<button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																	<i class="icon-white icon-download-alt"></i></button>
																
																
																<button type="button" class="btn btn-sm btn-default" id="loadprinter" title="Imprimir Reporte">  
																	<i class="icon-white icon-print"></i></button>
 																
															</div>
											 </div>	
										 
											 
  														 
									 </div>
							  
									 <div class="col-md-12">
                                                          <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
														 <thead>
															<tr>
																<th width="5%">Id</th>
																<th width="8%">Fecha</th>
																<th width="10%">Identificacion</th>
 																<th width="17%">Cliente</th>
                                                                <th width="10%">Comprobante</th>
																<th width="15%">Referencia </th> 
																<th width="30%">Detalle </th> 
																<th width="5%" bgcolor="#E0F79A">Total</th>
															</tr>
														 </thead>
														</table>
									</div>  
							  
							        <div style="padding-top: 5px;" class="col-md-6">
											  <div id="ViewFiltroResumen"></div> 
									</div>	
  								 
                        </div>  
                     </div> 
                </div>
                     
	 
					   
					    <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">

										  <div class="panel panel-default">

											   <div class="panel-body" > 
 
												   <div id="ViewFormAuxFiltro"> </div>
												   
												   <div class="col-md-3">
												   
												     <button type="button" id="GeneraArriendos"  class="btn btn-info btn-sm" >Generar Informacion</button>
												   
												   
												     <button type="button" id="GeneraImpresion"  class="btn btn-default btn-sm"  >Generar Reporte</button>

													</div>
											   </div>
											
										  </div>
							
							
											 <div class="col-md-12" style="padding-bottom:15;padding-top:15px" > 

														<div style="height: 450px; overflow-y: scroll;">

														 <div id="ViewReporteArriendos"> </div>

													   </div>   

											  </div>
							
							
						    			 
						</div>
 					   
               
        </div>
			 </div>	  
 		</div>
    </div>
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>

</html>
 