<?php
	session_start( );

?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
   
 
	<style>
		img {
 			 z-index: 1000;
		}
</style>
 
	  <script type="text/javascript" src="../js/seg_indicadores.js"></script>	
	
</head>

<body>

	 <script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
 

 
	<!-- Header -->
	 
    
    <div class="col-md-12" style="padding-top: 10px" > 
		
		 <div class="row" > 
       <!-- Content Here -->
	 
		 <div class="col-md-12">
			  <div class="panel panel-info">
					<div class="panel-heading">INDICADORES DE CUMPLIMIENTO DE GESTION </div>
 			  </div>
		 </div>
		
		
		 <div class="col-md-12">
			  <div class="col-md-6">
 						 <div class="panel panel-default">
							 <div class="panel-heading">RECOMENDACIONES EMITIDOS POR PERIODO</div>
							  <div class="panel-body">
									  <div class="widget box">
                                           <div class="widget-content">
 											  <div id="ganio" style="min-width: 100%; height:220px; margin: 0 auto"> </div>
                                            </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>
			  </div>
			 
			  <div class="col-md-6">
 						 <div class="panel panel-default">
							 <div class="panel-heading">ESTADO DE GESTION DE RECOMENDACIONES</div>
							  <div class="panel-body">
									  <div class="widget box">
                                           <div class="widget-content">
 											   <div id="gestado_tramite" style="min-width: 100%; height:220px; margin: 0 auto"> </div> 
                                           </div>
                                      </div> <!-- /.col-md-6 -->
 							  </div>
				         </div>
			 </div>
			 
			 <div class="col-md-6">
 						 <div class="panel panel-default">
							 <div class="panel-heading">CUMPLIMIENTO DE RECOMENDACIONES</div>
							  <div class="panel-body">
									  <div class="widget box">
                                           <div class="widget-content">
 											   <div id="gcumplimiento" style="min-width: 100%; height:220px; margin: 0 auto"> </div>
                                           </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
				         </div>
			 </div>	 
			 
			 <div class="col-md-6">
 						 <div class="panel panel-default">
							 <div class="panel-heading">RECOMENDACIONES ASIGNADAS POR TIPO DE EXAMEN</div>
							  <div class="panel-body">
									  <div class="widget box">
                                           <div class="widget-content">
 											   <div id="gexamen" style="min-width: 100%; height:220px; margin: 0 auto"> </div> 
                                            </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>

			  </div>
			 
		 </div>
		
		<div class="col-md-12">
			
			 <div class="col-md-6" >
 						 <div class="panel panel-default">
							 <div class="panel-heading">GESTION DE TRAMITES POR UNIDAD</div>
							  <div class="panel-body">
									  <div class="widget box">
                                           <div class="widget-content">
 											   <div id="gunidad_tramite" style="min-width: 100%; height:300px; margin: 0 auto"> </div> 
                                            </div>
                                       </div> <!-- /.col-md-6 -->
 							  </div>
						  </div>

			  </div>
			
			
	           <div class="col-md-6">
		   			   <div class="panel panel-default">
							 <div class="panel-heading">INDICADORES DE GESTION POR UNIDAD</div>
							  <div class="panel-body">
									  <div class="widget box">
											<div class="widget-content">

											  <div id="gunidadBarras" style="min-width: 100%; height:300px; margin: 0 auto"> </div>

											</div>
                                      </div> 
		     				 </div>
						  </div>
			 </div>
 		       
		</div>
		


		   
 
		   
	  </div>
    </div>
  	 
</body>
</html>
 