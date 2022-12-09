<?php
	session_start( );
	
	if (empty($_SESSION['usuario']))  {
	
	    header('Location: login');
 
	
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
 		 	 
				 <div class="col-md-6">
						 <div class="panel panel-success">
							 <div class="panel-heading">Accesos Parámetros</div>
							<div class="panel-body" >
									  
									 <div class="col-md-12" align="center">
										 
										 
										  <div id="idMod"></div>
								  		 
									</div>		 
										  <div class="col-md-12" align="right">
										 <a href="cartelera_noti"> 
								  				  <img   src="../../kimages/c_mailing.png" width="64" height="64" title="ENVIAR NOTIFICACIONES"/> 
							              </a>
							    				</div>
 							</div>
						</div>
				 </div>
				 <div class="col-md-6">
						 <div class="panel panel-warning">
							 <div class="panel-heading">Cartelera Mensajes</div>
							  <div class="panel-body">
									<iframe width="100%" height="400" src="View-panelchat" frameborder="0" allowfullscreen></iframe>
							  </div>
						  </div>
				 </div> 	
		</div>
    </div>
 
  <div id="FormPie"></div>    
    </div>   
</body>
</html>