<?php
	session_start( );

     require '../model/compra_panel.php';    

     $gestion   = 	new proceso;
 
     $asexo = $gestion->genero();

	$finanzas = $gestion->presuesto();



?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/visor-gerencial.js"></script> 
 	 		 
	
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
	   
	   
.actividad {
    border-collapse: collapse;
    width: 100%;
	font-size: 12px;
   }
 
 .ex1 {
  width: 1950px;
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
	padding-bottom: 4px; 
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

<!-- ------------------------------------------------------ -->
 
 
	
	
 <div id="main">
	
 
	  <div class="col-md-12" role="banner"> 
		  
		  <div id="MHeader"></div>
		  
	 </div>
	 
 
  <!-- ------------------------------------------------------ -->  
	 
	 
		<div class="col-md-12"> 
			<h3>RESUMEN DE INDICADORES DE PROCESOS</h3>
	   </div>	
	 
 		<div class="col-md-12" align="center" style="padding-bottom: 35px"> 
 						     
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="resumen">
												  <tbody>
													<tr>
													  <td width="25%" align="right" valign="middle" bgcolor="#51A2C5" class="resumen_td">TALENTO HUMANO</td>
													  <td width="25%" bgcolor="#3886A7" class="resumen_td" >PRESUPUESTO INSTITUCIONAL</td>
													  <td width="25%" align="right" valign="middle" bgcolor="#00D3C2" class="resumen_td">MONTO EJECUTADO</td>
													  <td width="25%" bgcolor="#6C7076" class="resumen_td" >% EJECUCION FINANCIERA</td>
													</tr>
													<tr>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#51A2C5"><?php  echo $asexo['hombre'] ?><img src="../../kimages/tthh.png"  align="absmiddle"/><?php  echo $asexo['mujer'] ?></td>
													  <td bgcolor="#3886A7" class="resumen_tt" ><?php  echo $finanzas['codificado'] ?></td>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#00D3C2" ><?php  echo $finanzas['devengado'] ?></td>
													  <td bgcolor="#6C7076" class="resumen_tt" ><?php  echo $finanzas['ejecutado'] ?></td>
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
		  <script src="https://code.highcharts.com/modules/exporting.js"></script>
		  <script src="https://code.highcharts.com/modules/export-data.js"></script>
		  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

 	  	  <script type="text/javascript" src="../js/grafico_gerencial.js"></script> 
	 
	     <div class="col-md-12"> 
			     <div class="col-md-4">
						     <div class="panel panel-success">
							     <div class="panel-heading">INGRESOS</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_1"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-4">
						     <div class="panel panel-info">
							     <div class="panel-heading">GASTO</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_2"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-4">
						     <div class="panel panel-info">
							     <div class="panel-heading">GASTO INVERSION</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_3"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
		  </div>	 
		
	 		
		 <div class="col-md-12"> 
			   <div class="col-md-6">
						     <div class="panel panel-success">
							     <div class="panel-heading">EJECUCION INGRESOS</div>
								  <div class="panel-body">
										<?php    $gestion->_ingreso(); ?> 

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-6">
						     <div class="panel panel-success">
							     <div class="panel-heading">EJECUCION GASTOS</div>
								  <div class="panel-body">
										<?php    $gestion->_gastos(); ?> 

								  </div>
							  </div>
			    </div>
			 
			 
			   
		 </div>	 
		 
	 
       	 <div class="col-md-12"> 
  			 
			   <div class="panel panel-success">
									  <div class="panel-heading">CARGA LABORAL INSTITUCIONAL</div>
									  <div class="panel-body">
									 	   
										   <div id="div_grafico"  style="height: 300px"> </div>
									  </div>
   				</div>
		 </div>	 
		
	     <div class="col-md-12"> 
			     <div class="col-md-3">
						     <div class="panel panel-success">
							     <div class="panel-heading">GENERO</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_4"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-3">
						     <div class="panel panel-info">
							     <div class="panel-heading">PROFESIONALIZACION</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_5"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-3">
						     <div class="panel panel-info">
							     <div class="panel-heading">PROCEDENCIA</div>
								  <div class="panel-body">
										<div id="div_grafico_gasto_6"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-3">
						     <div class="panel panel-info">
							     <div class="panel-heading">CAPACIDADES ESPECIALES</div>

								  <div class="panel-body">
										<div id="div_grafico_gasto_7"  style="height: 300px"> </div>

								  </div>
							  </div>
			    </div>
			 
		  </div>	 

	      
	 	 <div class="col-md-12"> 
			   <div class="col-md-6">
						     <div class="panel panel-success">
							     <div class="panel-heading">RESUMEN REGIMEN LABORAL</div>
								  <div class="panel-body">
										<?php    $gestion->_regimen(); ?> 

								  </div>
							  </div>
			    </div>
			 
			  <div class="col-md-6">
						     <div class="panel panel-success">
							     <div class="panel-heading">RESUMEN DE EJECUCION POR PROGRAMAS</div>
								  <div class="panel-body">
										<?php     $gestion->_programas(); ?> 

								  </div>
							  </div>
			    </div>
			 
			 
			   
		 </div>	 
         
          
 
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
