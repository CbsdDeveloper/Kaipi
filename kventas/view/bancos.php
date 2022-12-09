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
    
	<script type="text/javascript" src="../js/bancos.js"></script> 

   <style>
			@media print {
    			.dataTables_filter {
        		display:none
    		  }
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
    
	
   <div class="col-md-12">
					 
        <ul id="mytabs" class="nav nav-tabs">                
			
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> LIBRO BANCOS</b></a>
                   		</li>
                  		
        </ul>
	
        <!-- ------------------------------------------------------ -->
        <!-- Tab panes -->
        <!-- ------------------------------------------------------ -->
        
		<div class="tab-content">
			
            <!-- Tab 1 -->
            
			<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
				
                      <div class="panel panel-default" >
						  
						  <div class="panel-body" > 
						 
							  <div class="col-md-3" style="background-color:#ededed">
							 
							 	  <h5>Filtro búsqueda</h5>
							 	  
									 <div id="ViewFiltro"></div> 
  										
										<label style="padding-top: 5px;text-align: right;" class="col-md-2"> &nbsp; </label>
										
								 		<div style="padding-top: 5px;" class="col-md-10">
											
											<button type="button" class="btn btn-sm btn-success" id="load">  <i class="icon-white icon-search"></i>  </button>
											
											 <button type="button" class="btn btn-sm btn-primary" id="bimpresion" > <i class="icon-white icon-print"></i></button>
										 	<button type="button" class="btn btn-sm btn-default" id="btnExport" > <i class="icon-white icon-file"></i></button>
										 	<button type="button" class="btn btn-sm btn-warning" id="cmd" > <i class="icon-white icon-download-alt"></i></button>  
										</div>
										
										<label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label> 
 									 
							 
							 </div>  
							  
							  
							  <div class="col-md-9">
								  
							  		<div id="imprime">
							  
							   		<div id="cbanco">Seleccione el periodo</div>
							   
										   <table id="jsontable" class="display table table-condensed table-hover datatable" style="font-size:10px">
																		<thead>
																			<tr>
																			<th width="8%">Fecha</th>
																			<th width="8%">Asiento</th>
																			<th width="8%">Comprobante</th>
																			<th width="8%">Referencia</th>
																			<th width="20%">Beneficiario</th>
																			<th width="24%">Detalle</th>
																			<th width="8%">Ingreso</th>
																			<th width="8%">Egreso</th>
																			<th width="8%">Saldo</th>	
																			</tr>
																		</thead>
											  </table>
										
											<label style="padding-top: 2px;" class="col-md-1">Ingresos</label> 
									     	<label style="padding-top: 2px;" class="col-md-11" id="singreso">0.00</label> 
										    <label style="padding-top: 2px;" class="col-md-1">Egresos</label> 
										    <label style="padding-top: 2px;" class="col-md-11" id="segreso">0.00</label> 
										
							  		</div>
								  
                    		  </div>  
                     
                   		  </div> 
						  
               		  </div>
                  
                     
       		 </div> 
			
			
		</div>	  
	
 </div>
  
 <!-- Page Footer-->
 <div id="FormPie"></div>  
    
 </body>
</html>
 