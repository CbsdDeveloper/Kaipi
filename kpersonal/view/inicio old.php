<?php
session_start( );
require '../controller/Controller-unidad_organo.php';  
$gestion   = 	new componente;
?>	
<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
    <script type="text/javascript" src="../js/modulo.js"></script>
    
  
   
	<style>
	
	
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
  /*  background-color: #111;*/
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
	font-size: 11px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 11px;
    color:#322E2E;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover, .offcanvas a:focus{
    color:#BFBFBF;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 11px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}


  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 11px;}
	
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	
	
	#container {
    min-width: 300px;
    max-width: 100%;
    margin: 1em auto;
    border: 1px solid silver;
		}

	#container h4 {
		text-transform: none;
		font-size: 11px;
		font-weight: normal;
	}
	#container p {
		font-size: 10px;
		line-height: 16px;
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
	
	
    <div class="col-md-12"> 
       <!-- Content Here -->
	   <div class="row">
 		 		
 				 
					
		   
		         <div class="col-md-7">
						 <div class="panel panel-default">
							 <div class="panel-heading">Gestión Talento Humano</div>
							  <div class="panel-body">
									  <div class="widget box">
                                                     <div id="div_gasto"></div>
                                        </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
				 </div>
		   
		  	    <div class="col-md-5">
						 <div class="panel panel-default">
							 <div class="panel-heading">Unidades Estrategicas</div>
							  <div class="panel-body">
									  <div class="widget box">
                                                   <?php  $gestion->GestionValor( ); ?>	  
                                        </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
				 </div>
		   
		   
		   
		         <div class="col-md-12">
						 <div class="panel panel-warning">
							 
							<script src="https://code.highcharts.com/highcharts.js"></script>
							<script src="https://code.highcharts.com/modules/sankey.js"></script>
							<script src="https://code.highcharts.com/modules/organization.js"></script>
							<script src="https://code.highcharts.com/modules/exporting.js"></script>
  
						 	<div id="container"></div>
							 
 		
							 <script>
								 	Highcharts.chart('container', {
 									  chart: {
											height: 550,
											inverted: true
										},
									 title: {
										text: 'Estructura Organica'
									},
   
									 series: [{
										type: 'organization',
										name: 'Empresa',
										keys: ['from', 'to'],
										data: [<?php    $gestion->FiltroUnidadDato( ); ?> ],
										levels: [{
											level: 0,
											color: 'silver',
											dataLabels: {
												color: 'black'
											},
											height: 25
										}, {
											level: 1,
											color: 'silver',
											dataLabels: {
												color: 'black'
											},
											height: 25
										}, {
											level: 2,
											color: '#980104'
										}, {
											level: 3,
											color: '#359154'
										}],
										nodes: [ <?php    $gestion->FiltroUnidadDatoValor( ); ?>  ],
										colorByPoint: false,
										color: '#007ad0',
										dataLabels: {
											color: 'white'
										},
										borderColor: 'white',
										nodeWidth: 60
									}],
									tooltip: {
										outside: true
									},
									exporting: {
										allowHTML: true,
										sourceWidth: 800,
										sourceHeight: 600
									}

								});
 							 </script>
 
							 <div class="tree">
								<ul>
									<li>
										<a href="#">ORGANICO FUNCIONAL DE LA INSTITUCIÓN</a>
										<ul>
										 <?php

												echo '<li>';
												//	$gestion->FiltroUnidad( );
												echo '</li>';

										?>		
										</ul>
									</li>
								</ul>
					</div>
							 
							 
						  </div>
				 </div> 
		   
		</div>
    </div>
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
 
     <!-- actividdes-->
        <div id="Notas_actividades"></div>    
      
    </div>   
</body>
</html>