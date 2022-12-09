<?php
	session_start( );

    if (empty($_SESSION['usuario']))  {
	
	    header('Location: ../../kadmin/view/login');
 	
	}
?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
    <script type="text/javascript" src="../js/modulo.js"></script>
 	
  
	<script type="text/javascript" src="../js/factura_envio.js"></script> 
	
	
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
       <!-- Content Here -->
	   <div class="row">	
		   
			    <div class="col-md-12">
		 							  
				</div>

		        <div class="col-md-12">
					
				 
							 <div class="panel panel-success">
								 <div class="panel-heading">Resumen Pagos</div>
								  <div class="panel-body">
									  <div class="col-md-12" style="padding: 10px">
										  
 											 <div class="col-md-6">						
																		<select id="cmes" name="cmes" class="form-control" onChange="BusquedaGerencial()">
																		  <option value="01">Enero</option>
																		  <option value="02">Febrero</option>
																		  <option value="03">Marzo</option>
																		  <option value="04">Abril</option>
																		  <option value="05">Mayo</option>
																		  <option value="06">Junio</option>
																		  <option value="07">Julio</option>
																		  <option value="08">Agosto</option>
																		  <option value="09">Septiembre</option>
																		  <option value="10">Octubre</option>
																		  <option value="11">Noviembre</option>	
																		  <option value="12">Diciembre</option>	
																		</select>
											 </div>	
										  
								    </div>	
									  
										 <div id="FormMensual"></div>	 
 								  </div>
								  </div>
 
					 
				
				 </div>
		   
		   <div class="col-md-12">
			   <div class="col-md-6">
						
			 <script src="https://code.highcharts.com/highcharts.js"></script>
			 <script src="https://code.highcharts.com/modules/exporting.js"></script>
			 <script src="https://code.highcharts.com/modules/export-data.js"></script>
					
						 <div class="panel panel-default">
							 <div class="panel-heading">Gestion Financiera</div>
							  <div class="panel-body">
									  <div class="widget box">
                                         <div class="widget-content">
                                            <script type="text/javascript" src="../js/gestion.js"></script>
                                            
											 <div id="div_gasto" style="width:100%; height:350px;"> </div>    
											 
 											 
                                         </div>
                                      </div>  
 							  </div>
						  </div>
					
				 </div>
					
			   
		  		  <div class="col-md-6">
							 <div class="panel panel-danger">
								 <div class="panel-heading">Identificación Empresa</div>
								  <div class="panel-body">
										 <div id="FormEmpresa"></div>	 
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
 