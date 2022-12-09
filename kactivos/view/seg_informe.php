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
		
		.pdfobject-container { height: 450px; width: 100%;}
		.pdfobject { border: 1px solid #666; }
 	
   </style>
 
	  <script type="text/javascript" src="../js/seg_informe.js"></script>	
	
</head>

<body>
 	<!-- Header -->

	<div class="col-md-12" style="padding-top: 10px;" > 
		 <div class="row" > 
         <!-- Content Here -->
		 <div class="col-md-12">
			  <div class="panel panel-info">
					<div class="panel-heading"><b>INFORMES DE GESTION DE DOCUMENTOS INTERNOS</b></div>
 			  </div>
		 </div>
		<!-- 		 
		 <div class="col-md-12">
		   <img src="../../kimages/archivo.png"/> 
		 </div> -->
		  
		<div class="col-md-12">
					<div class="panel panel-info">
										 <div class="panel-heading">FILTRO DE INFORMACION DE RECOMENDACIONES</div>
										  <div class="panel-body">
												  <div class="widget box">
													   <div class="widget-content">
														  <div id="filtroVisor">  </div>
															  
														  
														   <div class="col-md-1">	 &nbsp; 
														   </div>   
														   <div class="col-md-4" style="padding:10px">   
														    <input name="botonPlantilla" type="button" onClick="CargaPlantilla();" class="btn btn-sm btn-default" id='botonCarga' value="Buscar">
															 </div>    
  											             </div> <!-- /.col-md-6 -->
												    </div>
										  </div>
					 </div>
		 </div>
			 
		  <div class="col-md-12"> 
			  <div class="panel panel-info">
								 <div class="panel-heading">ARCHIVOS DIGITALES</div>
								  <div class="panel-body">
										  <div class="widget box">
											   <div class="widget-content">
												  <div id="unidad_file" > </div>
											</div>
									</div> <!-- /.col-md-6 -->
								  </div>
					    	</div>
			  
		  </div>
  		   
	  </div>
    </div>
  	 
</body>
</html>
 