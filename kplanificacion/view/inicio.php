<?php
	session_start( );

  	if (empty($_SESSION['usuario']))  {
		header('Location: ../../kadmin/view/login');
  	}

	 require '../controller/Controller-FiltroAgendaMain.php';  
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
    
  
  <link href='../../app/calendario/fullcalendar.min.css' rel='stylesheet' />
 
 
<script src='../../app/calendario/lib/moment.min.js'></script>
<script src='../../app/calendario/lib/jquery.min.js'></script>
<script src='../../app/calendario/fullcalendar.min.js'></script>
    
    
  <!--  <script type="text/javascript" src="../js/calendario.js"></script> -->
   
   <style>
    #mdialTamanio{
      width: 70% !important;
    }
 
	   	  resumen {
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
		   
		 		   <div class="col-md-12" align="center" style="padding-bottom: 35px"> 
 						     
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
		   
 		   
			   <div class="col-md-12" align="center" style="padding-bottom: 35px"> 
					   
					      
  				 
					   
					    <div class="col-md-3" style="padding-bottom: 20px" >
							 
                                 		  <div style="padding: 10px;">  
                               		         <img src="../../kimages/punto.png"> <br>
                                		       <a href="mipoa">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>CREACION PAPP-POA DE LA UNIDAD</strong>  <br>
                                 		   Revise su planificación POA de la unidad, verifique sus actividades, objetivos e indicadores 
                                		 	   </span></a>
                                		 </div> 	
							 
                         </div>
		   
					   
		   				 <div class="col-md-3" style="padding-bottom: 20px">
							 
                                 		  <div style="background-image: url(../../kimages/02.png);padding: 10px;">  
                               		         <img src="../../kimages/02_.png"> <br>
                                		       <a href="POAConsulta.php">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>PAPP-POA DE LA UNIDAD</strong>  <br>
                                 		   Revise su planificación POA de la unidad, verifique sus actividades, objetivos e indicadores 
                                		 	   </span></a>
                                		 </div> 	
							 
                         </div>
		   
					     <div class="col-md-3" style="padding-bottom: 20px">
							 
                                 		  <div style="background-image: url(../../kimages/03.png);padding: 10px;">  
                               		         <img src="../../kimages/03_.png"> <br>
                                		       <a href="POASeguimiento.php">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>SEGUIMIENTO PLANIFICACION</strong>  <br>
                                 		  Realice el seguimiento POA, genere reportes de gestión, reporte la matriz POA e indicadores 
                                		 	   </span></a>
                                		 </div> 	
							 
                         </div>
		   
		 				  <div class="col-md-3" style="padding-bottom: 20px">
							  
                                 		  <div style="background-image: url(../../kimages/05.png);padding: 10px;">  
                               		         <img src="../../kimages/4p.png"> <br>
                                		       <a href="IndicadorPOA.php">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>GESTION DE INDICADORES</strong>  <br>
                                 		   Seguimiento de indicadores por unidad
                                		 	   </span></a>
                                		 </div> 
							  
                           </div>
		   
		   			   </div>
		   
		   
		           <div class="col-md-12" align="center" style="padding-bottom: 35px"> 
		   
		  				 <div class="col-md-3" style="padding-bottom: 20px">
							 
                                 		  <div style="background-image: url(../../kimages/04.png);padding: 10px;">  
                               		         <img src="../../kimages/04_.png"> <br>
                                		       <a href="POAGestion.php">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>GESTION INSTITUCIONAL</strong>  <br>
                                 		  Matriz de gestión POA, visor de cumplimiento de la planificación institucional, gráficos y reportes
                                		 	   </span></a>
                                		 </div> 	   
                         </div>
					   
					   
					    <div class="col-md-3" style="padding-bottom: 20px">
							 
                                 		  <div style="background-image: url(../../kimages/01.png);padding: 10px;">  
                               		         <img src="../../kimages/01_.png"> <br>
                                		       <a href="agendaPOA.php">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>AGENDA ACTIVIDADES</strong>  <br>
                                 		   Visualice actividades planificadas,  agregue actividades de gestión para su seguimiento
                                		 	   </span></a>
											  <?php
													$gestion->TareasMes( ); 
											  ?>
											  
                                		 </div> 	
							 
                          </div>
					   
					   
					    <div class="col-md-3" style="padding-bottom: 20px">
							 
                                 		  <div style="background-image: url(../../kimages/05.png);padding: 10px;">  
                               		         <img src="../../kimages/05_.png"> <br>
                                		       <a href="ejecutaPOA.php">
                                		       <span style="font-size: 12px;color: #727272">
                                		     <strong>EJECUCION DE POA</strong>  <br>
                                 		   Gestione tareas planificadas, ingrese la informacion, medio de verificacion, registro de datos de ejecucion de POA
                                		 	   </span></a>
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