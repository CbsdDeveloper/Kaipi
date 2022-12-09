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
	
       <!-- Content Here -->
 
		   <div class="col-md-12">
		      <div class="col-md-6">
						   <div class="panel panel-default">
							 <div class="panel-heading">Gestión BLD</div>
							  <div class="panel-body">
									 <div id="ParametroContable"></div>	 
						      
							  </div>
						 </div>	 
				  
				         <div id="novedades_baja"></div>	 
				  
				   		 <div id="por_asignar"></div>	 
				 </div>
		   
 		 		<div class="col-md-6">
						 <div class="panel panel-default">
							 <div class="panel-heading">Bienes de Larga Duración -  Grupo</div>
							  <div class="panel-body">
								  			<div class="widget-content">
                                                
 												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="resumen">
												  <tbody>
													<tr>
													  <td width="25%" align="right" valign="middle" bgcolor="#51A2C5" class="resumen_td">BIENES POR VENCER</td>
													  <td width="25%" bgcolor="#3886A7" class="resumen_td">CUMPLIDOS VIDA UTIL</td>
													  <td width="25%" align="right" valign="middle" bgcolor="#00D3C2" class="resumen_td">ESTADO MALO</td>
													</tr>
													<tr>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#51A2C5"><div id="nvence"></div></td>
													  <td bgcolor="#3886A7" class="resumen_tt"><div id="nutil"></div></td>
													  <td align="right" valign="middle" class="resumen_tt" bgcolor="#00D3C2"><div id="nmalo"></div></td>
 													</tr>
													
													 
													 
													</tbody>
												</table>
												
                                                          
                                                </div>
								  
									  <div class="widget box">
                                                <div class="widget-content">
                                                
                                               		 <div id="ViewGrupo"></div>
                                                         
                                                </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
				 </div>
		  	  </div>    
		   
		    <div class="col-md-12">
						   	 <script src="https://code.highcharts.com/highcharts.js"></script>
							 <script src="https://code.highcharts.com/modules/exporting.js"></script>
							 <script src="https://code.highcharts.com/modules/export-data.js"></script>

							 <script type="text/javascript" src="../js/gestion_grafico.js"></script> 

				
					  <div class="col-md-6">
						 <div class="panel panel-success">
							 <div class="panel-heading">Unidades Bienes de Larga Duración -  Unidades</div>
							  <div class="panel-body">
 									 
												 
 											<div id="ViewUnidad" style="height: 350px"> </div>
 												 
									   
  										 		
  								</div><!--/.row-->
 							</div>
						</div>
				
				
				<div class="col-md-6">
						 <div class="panel panel-default">
							 <div class="panel-heading">Bienes de Larga Duración -  Ubicacion</div>
							  <div class="panel-body">
									  <div class="widget box">
                                                <div class="widget-content">
                                                
                                               	 <div id="ViewSede"></div>
                                                         
                                                </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
				 </div>
			 		 
 		  </div>    
      
    </div>   
	<!-- Page Footer-->
	
	    <div id="FormPie"></div>    
</body>
</html>