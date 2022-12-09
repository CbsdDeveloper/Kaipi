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
		
		
.div_p {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:15%;
	float: left;
	border:solid 1px cadetblue;
    box-shadow: 0px 20px 15px -15px #818181;
	margin: 3px;
 	}		
 
.div_q {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:16%;
	float: left;
	border:solid 1px chocolate;
    box-shadow: 0px 20px 15px -15px #818181;
margin: 3px;
	}	
 
	.div_r {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:19%;
	float: left;
	border:solid 1px crimson;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
	
	.div_s {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:21%;
	float: left;
	border:solid 1px darkgoldenrod;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}		
		
	.div_t {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:23%;
	float: left;
	border:solid 1px yellow;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
		
  .div_u {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:26%;
	float: left;
	border:solid 1px greenyellow;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
		
  .div_v {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:28%;
	float: left;
	border:solid 1px lime;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
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
 		         <div class="col-md-8">
					  <div class="col-md-12">
							<div class="panel panel-default">
									 <div class="panel-heading">Gestión Talento Humano</div>
									  <div class="panel-body">
											  <div class="widget box">
															 <div id="div_gasto"></div>


												  <div class="col-md-12">

										 <a href="cartelera" title="CARTELERA INFORMATIVO DIGITAL">
														<img src="../../kimages/n_cartelera.png" width="58" height="58" title="CARTELERA INFORMATIVO DIGITAL"/> &nbsp;&nbsp;
													  </a>
													  <a href="https://sut.trabajo.gob.ec/mrl/loginMenuSut.xhtml" title="INGRESO AL SISTEMA SUT (Sistema Unico Trabajo)" target="_blank">
													   <img src="../../kimages/n_salario.png" width="58" height="58" title="INGRESO AL SISTEMA SUT (Sistema Unico Trabajo)"/> 
													  </a>
													 </div>

												</div> <!-- /.col-md-6 -->
									  </div>
							  </div>
					 </div>
						<div class="col-md-12">
									 <div class="panel panel-default">
										 <div class="panel-heading">Gestión Interna</div>
										  <div class="panel-body">
												  <div class="widget box">
													  <?php  $gestion->Gestion_tthh( ); ?>	  
											</div> <!-- /.col-md-6 -->
										  </div>
								  </div>
						</div>
				 </div>
		   
		  	     <div class="col-md-4">
						  <div class="panel panel-default">
							 <div class="panel-heading">Gestión de Acciones de Personal</div>
							  <div class="panel-body">
							    <div class="widget box">
                                                   <?php  $gestion->GestionAccion( ); ?>	  
                                 </div> <!-- /.col-md-6 -->
								   
							  </div>
						  </div>
					 
						  <div class="panel panel-default">
							 <div class="panel-heading">Gestión de Permisos/Vacaciones de Personal</div>
							  <div class="panel-body">
							    <div class="widget box">
                                                   <?php  $gestion->GestionPermisos( ); ?>	  
                                 </div> <!-- /.col-md-6 -->
								   
							  </div>
						  </div>
					      <div class="panel panel-default">
							 <div class="panel-heading">Aniversarios del Mes</div>
							  <div class="panel-body">
									  <div class="widget box">
										  <?php  $gestion->Gestion_cumple( ); ?>	  
						        </div> <!-- /.col-md-6 -->
 							  </div>
			 			 </div>
 			 
					 
				 </div>
		        
 
					 
		    
			    		
						  
		 </div> 
		   
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
  

     <!-- actividdes-->
        <div id="Notas_actividades"></div>    
      
    </div>   
</body>
</html>