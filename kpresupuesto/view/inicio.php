<?php
	session_start( );

    if (empty($_SESSION['usuario']))  {
	
	    header('Location: ../../kadmin/view/login');
 	
	}

     require '../model/resumen_panel.php';    

     $gestion   = 	new proceso;
 
?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
    <script  type="text/javascript" language="javascript" src="../js/modulo.js?n=1"></script>
 
 
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
		   
		  <div class="col-md-12">
		   	    
		   	 <script src="https://code.highcharts.com/highcharts.js"></script>
			 <script src="https://code.highcharts.com/modules/exporting.js"></script>
			 <script src="https://code.highcharts.com/modules/export-data.js"></script>
   
			 <script type="text/javascript" src="../js/gestion_grafico.js"></script> 
			  
			  
			    <div class="col-md-4"> 
 					 <div class="panel panel-warning">
							 	  <div class="panel-heading">Tramites de gestion presupuestaria</div>
								  <div class="panel-body">
											   <?php    $gestion->tramites_gastos(); ?> 
								  </div>	
 				     </div> 
 				</div>	
			  
			   <!-- GASTO Recursos del Estado  -->
			    <div class="col-md-4">
						     <div class="panel panel-info">
							     <div class="panel-heading">Resumen Presupuestario GASTO - Recursos del Estado</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_2"  style="height: 250px"> </div>

								  </div>
							  </div>
			    </div>
 			    <div class="col-md-4">
						 <div class="panel panel-success">
							 <div class="panel-heading">Resumen GASTO EJECUCION - Recursos del Estado</div>
							  <div class="panel-body">
									 <div id="div_grafico_gasto_1"  style="height: 250px"> </div>
									  
							  </div>
							  </div>
				 </div>
			     <div class="col-md-4"> 
 					 <div class="panel panel-warning">
							 	  <div class="panel-heading">Resumen general por fuente de financiamiento</div>
								  <div class="panel-body">
											   <?php    $gestion->anual_ejecucion(); ?> 
								  </div>	
 				     </div> 
 				</div>	
			  
			  
			  <!-- GASTO AUTOGESTION  -->
		 	   <div class="col-md-4"> 
						 <div class="panel panel-success">
							 <div class="panel-heading">Resumen Presupuestario GASTO - AUTOGESTION</div>
							  <div class="panel-body">
									 <div id="div_grafico_gasto_3"  style="height: 250px"> </div>
									  
							  </div>
							  </div>
				 </div>
			  
			    <div class="col-md-4">
						     <div class="panel panel-info">
							     <div class="panel-heading">Resumen Presupuestario GASTO - AUTOGESTION</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_4"  style="height: 250px"> </div>

								  </div>
							  </div>
			    </div>
			  
			    <!-- GASTO AUTOGESTION  -->
			    <!-- 
			    <div class="col-md-4">
						 <div class="panel panel-info">
							 <div class="panel-heading">Resumen Presupuestario Ingreso - Autogestion</div>
							  <div class="panel-body">
								 <div id="div_grafico_gasto_4"  style="height: 250px"> </div>
									  
							  </div>
							  </div>
				 </div>
			  
			      -->
			   		 	<!--
			      <div class="col-md-6">
						 <div class="panel panel-warning">
							 <div class="panel-heading">Cartelera Mensajes</div>
							  <div class="panel-body">
									<iframe width="100%" height="350" src="View-panelchat" frameborder="0" allowfullscreen></iframe>
							  </div>
						  </div>
				 </div> 
		       </div> 
		       -->
		   
		    </div>
		   
		   
		     <div class="col-md-12">
				 
 		 	<!--	<div class="col-md-6">
						 <div class="panel panel-default">
							 <div class="panel-heading">Gestión Financiera</div>
							  <div class="panel-body">
									  <div class="widget box">
                                         <div class="widget-content">
                                            <script type="text/javascript" src="../js/gestion.js"></script>
                                            
											 <div id="div_gasto" style="width:100%; height:350px;"> </div>    
											 
 											 
                                         </div>
                                      </div>  /.col-md-6
 							  </div>
						  </div>
				 </div>
		    -->
 
		</div>
    </div>
	
	 <div class="col-md-12" style="padding: 8px">
		   <div class="col-md-3">
				<select id='ganio' name='ganio' class='form-control'>  </select>
			</div>	
								   
		   <div class="col-md-3" style="padding-top: 4px">	
			    <button type="button" onClick="PeriodoAnio()" class="btn btn-info btn-sm">Seleccionar Periodo</button>
		   </div>							   
	</div>
	
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
    </div>   
</body>
</html>
 