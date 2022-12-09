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

  	
	<script type="text/javascript" src="../js/ren_frecuencias_query.js"></script> 
    
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
		
	    <div class="row">
			
 		 	     <div class="col-md-12">
						   <!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      
					 
                    <ul id="mytabs" class="nav nav-tabs">  
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   		 <span class="glyphicon glyphicon-th-list"></span> <b>DETALLE DIARIO  DE FRECUENCIAS</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> RESUMEN FRECUENCIAS</a>
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

												       <div class="col-md-12" style="background-color:#EFEFEF;padding: 10px" >

																	<div id="ViewFiltro"></div> 

																<div style="padding-top: 5px;" class="col-md-3">
																				<button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
																</div>


															</div>

									   

													 <div class="col-md-12">
														 
														 
										 
																
														 
 																 <table id="jsontable" class="display table table-striped table-bordered" cellspacing="0" width="100%">
																							<thead>
																								<tr>
 																								<th width="10%">Hora</th>
                                                                                 <th width="50%">Ruta</th>
                                                                                 <th width="10%">Nro.Unidad</th>
                                                                                 <th width="10%">Hora</th>
                                                                                 <th width="20%">Usuario</th>
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

									  <div class="panel-body"> 

												 

												<div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px">

														<div class="btn-group btn-group-sm">

															<button type="button"  onClick="goToURL(1)" class="btn btn-primary">Detalle Periodo</button>
															
															<button type="button" onClick="goToURL(4)"  class="btn btn-success">Por Frecuencia</button>
															
															
															<button type="button" onClick="goToURL(3)"  class="btn btn-danger">Por Frecuencia Total</button>
															
 
															<button type="button" onClick="goToURL(2)"  class="btn btn-info">Por Usuario</button>
 															
 															
															
 															
															<button  id="printButton" type="button" class="btn btn-default">Impresion</button>

															<button  id="ExcelButton" type="button" class="btn btn-default">Excel</button>

													   </div>
											   </div>

											 
										<div class="col-md-10" style="padding-bottom: 10px;padding-top: 10px">

											 <div style="overflow-y:scroll; overflow-x:hidden; height:650px; padding: 5px"> 
 												  
												 
												  <div id="ViewForm"> </div>

 												 
											  </div>
										  
										   </div> 
									  </div>

								  </div>
            		   </div>
		 
					   
					   <!-- Tab 3 -->
              
			   </div>	  
		
 				</div>
      </div>
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
	
	
 </div>   
 	 
 
	
 </body>

</html>
 