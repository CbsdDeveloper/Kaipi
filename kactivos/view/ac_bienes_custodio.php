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
 
 	 <script type="text/javascript" src="../js/ac_bienes_custodio.js"></script> 
 	 
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js"></script>   
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js"></script>
	
	 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
		}
	 
	 
 
		#mdialTamanio1{
      			width: 85% !important;
   			 }
		
		#mdialTamanio2{
      			width: 65% !important;
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
	 .di {
  			 background-color:#F5C0C1;
	  }
</style>	
	
</head>
<body>

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
 				 
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>CONTROL DE CUSTODIOS</b></a>
                   		</li>
                  	  
						<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> LISTA DE BIENES ASIGNADOS</a>
                  		</li>
	
           </ul>
                    
            <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content">
            
           <!-- ------------------------------------------------------ -->
           <!-- Tab 1 -->
           <!-- ------------------------------------------------------ -->
 
			   
           		 <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
					 
 						  <div class="panel panel-default">
							  
								<div class="panel-body" > 
											  
										  <div class="col-md-12">

																				<div id="ViewFiltro"></div> 
										  </div>	  
														   
										  <div class="col-md-12" style="padding: 20px">
																						<button type="button" class="btn btn-sm btn-primary" id="load">  
																						<i class="icon-white icon-search"></i> Buscar</button>	
 
										 </div>
  							  
							   			  <div class="col-md-12" id="view_cus" >
									
								 </div> 	
								  
					  			        	<div class="col-md-12" >
						  
 											   <h5>Custodios Asignados </h5>
 								 
									
													   <table id="jsontable_main" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="10%">Identificacion</th>
																						<th width="20%">Unidad</th>
																						<th width="25%">Custodio</th>
																						<th width="20%">Email</th>
																						<th width="10%">Nro.Bienes</th>		
																						<th width="10%">Costo($)</th>		
 																						<th width="5%"> </th>
																						</tr>
																					</thead>
					   								 </table>
 						  
					  		   </div>  
										
							  </div>
 					
				 	      </div>
			 	  </div>
			   
			   
			 		   <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" >
  						  		
						   	  <div class="col-md-12" style="padding: 20px">
								 	<button type="button" onClick="impresion_custodio()" class="btn btn-sm btn-primary" id="load3">  
																						<i class="icon-white icon-print"></i> Impresion</button>	

								   <button type="button" class="btn btn-sm btn-info" onClick="Exportar_datos()">  
																						<i class="icon-white icon-download-alt"></i> Descargar Bienes</button>	
								  
								   <button type="button" class="btn btn-sm btn-default" id="saveAsExcel">  
																						<i class="icon-white icon-download-alt"></i> Descargar xls</button>	
								  
								   
								  <button type="button" onClick="impresion_acta()" class="btn btn-sm btn-danger" id="load33">  
																						<i class="icon-white icon-print"></i> Impresion Acta Resumen</button>	


							   </div>
						   
						    <div class="col-md-12" id="jsontable_div" >
								
								<div class="alert alert-success">
 								
						   		  <div id="ViewForm" style="font-size: 18px;font-weight: 600"> </div>
									
							    </div>		
 					
								   <h5>Bienes Asignados </h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="5%">Activo</th>
																						<th width="15%">Unidad</th>
																						<th width="10%">Clase</th>
																						<th width="30%">Detalle</th>
																						<th width="10%">Marca</th>		
																						<th width="10%">Serie</th>		
																						<th width="5%">Fecha</th>
																						<th width="5%">Tiempo</th>
 																						<th width="5%">Costo</th>
																						<th width="5%">Tipo</th>
																						</tr>
																					</thead>
					   								 </table>
						   	</div>
			      </div>
             </div>
   			   
			   
			   
   	  </div>

		   
 
		<input type="hidden" id="idprov" name="idprov">

   		<div id="FormPie"></div>  
	
 
 

 
  </body>
 
</html>
