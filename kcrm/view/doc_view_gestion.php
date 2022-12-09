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
	
	
    <div class="col-md-12"> 
		
          <div class="row">
			 
 		 
		
			  
		     <div class="col-md-4">
			
					<div class="panel panel-info">
										 <div class="panel-heading">FILTRO DE INFORMACION </div>
						
										  <div class="panel-body">
											  
												  <div class="widget box">
													  
													   <div class="widget-content">
														   
														  <div id="filtroVisor">  </div>
															  
   											             </div> <!-- /.col-md-6 -->
												    </div>
										  </div>
					 </div>
				 
		     </div>
			 
		     <div class="col-md-8"> 
			  
			   <div class="panel panel-info">
				  
					  <div class="panel-heading">ARCHIVOS DIGITALES</div>
				  
								  <div class="panel-body">
										  <div class="widget box">
											   <div class="widget-content">
											     <div class="col-md-12" style="padding: 5px"> 
														 	  <div class="col-md-5"> 
																  <input type="text" id="ccedula" name="ccedula" class="form-control" placeholder="Busqueda Nro.Identificacion">
															  </div>
															  <div class="col-md-7"> 
																  <input type="text" id="ccodigo" name="ccodigo" class="form-control" placeholder="Busqueda de tramite">
															  </div>
													 
														      <div class="col-md-4" style="padding-top: 5px;padding-bottom: 5px"> 
																  <button type="button" id="bcodigo" name="bcodigo" class="btn btn-success">Busqueda</button>

												    		  </div>
												     </div>
												   
													<div class="col-md-12" style="padding: 5px"> 
				   										  <div   style="width:100%; height:550px;">
												 	 			 <div id="unidad_file" > </div>
														  </div>	  
											     </div>
												   
												  
										    </div>
											</div> <!-- /.col-md-6 -->
								  </div>
				 </div>
			  
		  </div>
  	
	</div>

</div>
	
	  <div id="FormPie"></div>  
  
</body>
</html>
 