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
 	
		  
		.tree {
			min-height:20px;
			padding:1px;
			margin-bottom:10px;
			background-color:#fbfbfb;
			border:1px solid #D5D5D5;
		}
		.tree li {
			list-style-type:none;
			margin:0;
			padding:10px 5px 0 5px;
			position:relative
		}
		.tree li::before, .tree li::after {
			content:'';
			left:-20px;
			position:absolute;
			right:auto
		}
		.tree li::before {
			border-left:1px solid #D5D5D5;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #D5D5D5;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			display:inline-block;
			padding:3px 8px;
			text-decoration:none
		}
		.tree li.parent_li>span {
			cursor:pointer
		}
		.tree>ul>li::before, .tree>ul>li::after {
			border:0
		}
		.tree li:last-child::before {
			height:30px
		}
		.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
			  color:#000
		}
  		.tree li ul > li ul > li {
				display: none;
		}
	
	
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
		}
	
		.filasupe {
 			border-bottom: 1px solid #ddd;
			border-left: 1px solid #ddd;
			border-right: 1px solid #ddd;
			border-top: 1px solid #ddd;
			padding-bottom: 6px; 
			padding-top: 6px;
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
		
	
		  
  #container {
  min-width: 500px;
  margin: 1em auto;
  border: 1px solid silver;
}

button {
  border: 1px solid #1da1f2;
  border-color: #0084B4;
  border-radius: 100px;
  font-size: 15px;
}

#button-bar {
  text-align: center;
}

#container{
  text-transform: none;
  font-size: 11px;
  font-weight: normal;
}

h4 {
  font-size: 8.5px !important;
}

@media (min-width: 576px) {
  h4 {
    font-size: 10px !important;
  }
}

@media (min-width: 768px) {
  h4 {
    font-size: 10.5px !important;
  }
}

@media (min-width: 992px) {
  h4 {
    font-size: 12px !important;
  }
}

@media (min-width: 1200px) {
  h4 {
    font-size: 12px !important;
  }
}	
</style>	
 	
	<script language="javascript" src="../js/POAConsulta.js?n=1"></script>
    
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
			  <div class="panel-heading">ARTICULACION OBJETIVOS OPERATIVOS - ESTRATEGICOS</div>
			  <div class="panel-body">
				    <div class="col-md-12" style="padding-bottom: 10px;padding-top: 15px"> 
 	  
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="resumen">
												  <tbody>
													<tr>
													  <td width="25%" align="right" valign="middle" bgcolor="#51A2C5" class="resumen_td">TECHO PRESUPUESTARIO</td>
													  <td width="25%" bgcolor="#3886A7" class="resumen_td" >MONTO PLANIFICADO</td>
													  <td width="25%" align="right" valign="middle" bgcolor="#00D3C2" class="resumen_td">MONTO EJECUTADO</td>
													  <td width="25%" bgcolor="#6C7076" class="resumen_td" >% EJECUCION FINANCIERA</td>
													</tr>
													<tr>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#51A2C5"><div id="techo"></div></td>
													  <td bgcolor="#3886A7" class="resumen_tt" ><div id="inicial"></div></td>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#00D3C2" ><div id="ejecutado"></div></td>
													  <td bgcolor="#6C7076" class="resumen_tt" ><div id="ejecutadop"></div></td>
													</tr>
													 
													<tr>
													  <td align="right" valign="middle" bgcolor="#FC292D" class="resumen_td">NRO.OBJETIVOS OPERATIVOS</td>
													  <td bgcolor="#FB3ADC" class="resumen_td" >NRO. TAREAS PLANIFICADAS</td>
													  <td align="right" valign="middle" bgcolor="#FF8B0A" class="resumen_td">NRO. INDICADORES</td>
													  <td bgcolor="#FFCE00" class="resumen_td" >% EJECUCION PLANIFICACION</td>
													</tr>
													<tr>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#FC292D" ><div id="nobjetivos"></div></td>
													  <td bgcolor="#FB3ADC" class="resumen_tt"  ><div id="ntareas"></div></td>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#FF8B0A"><div id="nindicadores"></div></td>
													  <td bgcolor="#FFCE00" class="resumen_tt" ><div id="ntareasp"></div></td>
													</tr>
													</tbody>
												</table>
  				   </div>
				  
				  
				   <script src="https://code.highcharts.com/highcharts.js"></script>
							 <script src="https://code.highcharts.com/modules/sankey.js"></script>
							 <script src="https://code.highcharts.com/modules/organization.js"></script>
							 <script src="https://code.highcharts.com/modules/exporting.js"></script> 
				  
				  <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
				     <div id="UnidadObjetivoArticula"></div>
				  </div>
				  
				  <div class="col-md-12" style="padding-bottom: 10px;padding-top: 15px"> 
				     <div id="UnidadObjetivoIndicador"></div>
				  </div>
				  
				  <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
 					 <div id="ViewPOAMatrizOO" style="overflow-x: auto;"> </div>
 				  </div>	
				  
				</div>
			</div>
		</div> 	
  		 
</div>
 
  	<!-- Page Footer-->
      <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>Kaipi &copy; 2017-2019</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Design by <a href="#">JASAPAS</a></p>
                  <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
 </footer>
 
    
 
</body>
</html> 