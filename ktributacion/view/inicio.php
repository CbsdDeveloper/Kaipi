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
	
	
    <div class="col-md-12"> 
       <!-- Content Here -->
	   <div class="row">
 		
		   	 <script src="https://code.highcharts.com/highcharts.js"></script>
			 <script src="https://code.highcharts.com/modules/exporting.js"></script>
		   
		    <div class="col-md-12">
					 <div class="col-md-5">
							 <div class="panel panel-danger">
								 <div class="panel-heading">Identificación Empresa</div>
								  <div class="panel-body">
										 <div id="FormEmpresa"></div>	 
 								  </div>
								  </div>
					 </div>
  					 <div class="col-md-7">     
								 <div class="panel panel-success">
									  <div class="panel-heading">Gestión Mensual de Ventas</div>
									  <div class="panel-body">
									 	  <script type="text/javascript" src="../js/gestionv.js"></script>
										   <div id="div_grafico"  style="height: 200px;width:100%"> </div>
									  </div>
   								 </div>
                 	  </div>
		 		 </div>	  
		   
		        <div class="col-md-12">
					<div class="col-md-5">
							 <div class="panel panel-info">
								 <div class="panel-heading">Formatos</div>
								  <div class="panel-body">
							        <div class="media">
											<div class="media-left"> <a href="../../archivos/FormatoVentas.xls" target="_blank"><img src="../../kimages/excel_anexos.png" class="media-object" style="width:32px"></a>
									   </div>
											<div class="media-body">
											  <h5 class="media-heading">Formato Ventas</h5>
											  <p>Modelo formato excel para importar la informacion mensual de ventas.</p>
											</div>
								    </div>	  
  								  </div>
								  </div>
					 </div>
		   			 <div class="col-md-7">     
								 <div class="panel panel-default">
									  <div class="panel-heading">Gestión Mensual de Compras</div>
									  <div class="panel-body">
									 	  <script type="text/javascript" src="../js/gestionc.js"></script>
										   <div id="div_compras" style="height: 200px;width:100%"> </div>
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
 