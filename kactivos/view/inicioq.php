<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Plataforma de Gestión Empresarial</title>
	<!--=== CSS ===
      <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" />  
    -->
 <?php  require('Head.php')  ?> 
    
  <script type="text/javascript" src="../js/modulo.js"></script>
   
  
</head>
<body>

 
<div class="well">
  <div class="modal" style="position: relative; top: auto; left: auto; margin: 0 auto; z-index: 1; width: 100%; box-sizing: border-box; display: inline;">
     <div class="modal-dialog" style="left: 0; width: 100%; padding-top: 0; padding-bottom: 10px; margin: 0; color: rgba(0,0,0,1);">
 
	   <div class="modal-content">
		  <div id="NavMod"></div>  
          <div class="modal-body">
            <div class="widget box">
             <div class="widget-content">
               <div class="row">
				 <div class="col-md-3">
						 <div class="panel panel-primary">
							 <div class="panel-heading">Opciones Módulo</div>
							  <div class="panel-body">
									   <div id="ViewModulo"></div>
 							  </div>
						  </div>
				 </div>
				<div class="col-md-4">
						 <div class="panel panel-success">
							 <div class="panel-heading">Identificación Empresa</div>
							  <div class="panel-body">
									 <div id="FormEmpresa"></div>	  
									 
									 
									<div class="btn-group-vertical" role="group" style="padding: 3px">
 										<button type="button" id="solpa" class="btn btn-success" style="font-size: 12px">Solicitud de pago</button>
 										<br>
										<button type="button" id="solvi" class="btn btn-success" style="font-size: 12px">Solicitud de viatico</button>
									</div>

							  </div>
						  </div>
				 </div>
				 <div class="col-md-5">
						 <div class="panel panel-warning">
							 <div class="panel-heading">Cartelera Mensajes</div>
							  <div class="panel-body">
									<iframe width="100%" height="400" src="View-panelchat" frameborder="0" allowfullscreen></iframe>
							  </div>
						  </div>
					</div> 	  
				 </div>         
 			</div> 
          </div>
		 </div>											
	  </div><!-- /.modal-content -->

	 	</div> 
  </div> 
</div>  
 
</body>
</html>
 