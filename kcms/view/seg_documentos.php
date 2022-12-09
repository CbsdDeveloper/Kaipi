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
 
	  <script type="text/javascript" src="../js/seg_documentos.js"></script>	
	
</head>

<body>
 	<!-- Header -->

	<div class="col-md-12" style="padding-top: 10px;" > 
		 <div class="row" > 
         <!-- Content Here -->
		 <div class="col-md-12">
			  <div class="panel panel-info">
					<div class="panel-heading"><b>GESTOR DE DOCUMENTOS INTERNOS</b></div>
 			  </div>
		 </div>
		<!-- 		 
		 <div class="col-md-12">
		   <img src="../../kimages/archivo.png"/> 
		 </div> -->
		  
		<div class="col-md-12">
					<div class="panel panel-info">
										 <div class="panel-heading">UNIDADES DE INFORMACION</div>
										  <div class="panel-body">
												  <div class="widget box">
													   <div class="widget-content">
														  <div id="folder_unidad"> </div>
													</div>
											</div> <!-- /.col-md-6 -->
										  </div>
					 </div>
		 </div>
			 
		  <div class="col-md-12"> 
 				<div class="col-md-6">
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
			  <script src="pdfobject.min.js"></script>	 
			   <div class="col-md-6">
						<div class="container" style="padding:10px;width:100%">
							<div id="pdf_view"></div>
						</div>
			   </div> 
			  
		  </div>
  		   
	  </div>
    </div>
  	 
</body>
</html>
 