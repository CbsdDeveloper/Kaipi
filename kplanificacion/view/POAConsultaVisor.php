<?php
 	 session_start();
	 require '../controller/Controller-FiltroAgendaMain.php';  
     $gestion   = 	new componente;
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
      <?php  require('HeadPanel.php')  ?> 
  	 
	<link href="../../kplanificacion/view/articula.css" rel="stylesheet">
   
    <style type="text/css">
 	
		   
	
	
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

				@media screen and (max-height: 450px) {
		  .sidenav {padding-top: 15px;}
		  .sidenav a {font-size: 11px;}

			#calendar {
				max-width: 900px;
				margin: 0 auto;
			}

		}
	 
 
		.actividad {
			border-collapse: collapse;
			width: 100%;
			font-size: 11px;
		  }
 
 		.ex1 {
			  width: 1990px;
			  overflow-y: hidden;
			  overflow-x: auto;
			  }
	 
		.table1 {
  			border-collapse: collapse;
			font-size: 11px;
		}
	
		.filasupe {
 			border-bottom: 1px solid #ddd;
			border-left: 1px solid #ddd;
			border-right: 1px solid #ddd;
			border-top: 1px solid #ddd;
			padding: 4px; 
			font-size: 11px;
 		}
	
		.derecha {
 
    		 border-right: 1px solid #ddd;
	  
		 }
	
  		#mdialTamanio{
      width: 70% !important;
    }
	
 		#mdialTamanio1{
      width: 80% !important;
    }
 	
  		.bigdrop{
		
        width: 750px !important;

     }
		  
  		.bigdrop1{
		
        width: 750px !important;

     }
		  
	  
	  	.resumen {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    text-align: center;
		  }
		.resumen_td {
	padding-top: 6px;
    text-align: center;
	font-size: 10px;	
	color: #FFFFFF
		  }
		.resumen_tt {
    padding-bottom: 10px;
	padding-top: 1px;
    text-align: center;
	font-size: 22px;
	font-weight: 700;
	color: #FFFFFF
		  }  
</style>	
 	
	<script language="javascript" src="../js/POAConsultaVisor.js"></script>
    
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
		
 		  <div class="panel panel-default">
				<div class="panel-heading">Unidad de Gestión</div>
					<div class="panel-body">
						 <div class="widget box">
                              <div class="widget-content">
                                     <?php
                                      $gestion->FiltroFormulario( ); 
								    ?>
                              	    <div class="col-md-2" style="padding-top: 8px;">
														<button type="button"   class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
														 
									</div>
                               </div>
                           </div> <!-- /.col-md-6 -->
 					</div>
			 </div>
		
		
	  	  <div class="panel-group">
			<div class="panel panel-default">
			  <div class="panel-heading">PLANIFICACION POA - UNIDAD OPERATIVA</div>
			  <div class="panel-body">
				    
				  
				  <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
				     <div id="UnidadObjetivoArticula"></div>
				  </div>
				  
				   
				  
				  
				</div>
			</div>
		</div> 	
  		 
</div>
 
  	<!-- Page Footer-->
       
 
    
 
</body>
</html> 