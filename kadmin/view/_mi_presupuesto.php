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
	
    <?php   require('Head.php')  ?> 
    

	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
    <script type="text/javascript" src="../js/mi_presupuesto.js"></script>
    

  
 
</head>
<body>

<div id="main">
	
	<div class="col-md-12" role="banner">
 	   <div id="NavMod"></div>
 	</div> 
	
 
	
 
	 
	
    <div class="col-md-12"> 
		
       <!-- Content Here -->
		
	   <div class="row">
 		 	 
				 <div class="col-md-12">
						 <div class="panel panel-success">
							 <div class="panel-heading">PRESUPUESTO DE LA UNIDAD </div>
							<div class="panel-body"  >
 
									 
								   
								
								    <div class="col-md-12">
										 
 										  <div id="viewform"></div>
  
 									 </div>
								
								 
								
									 <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px">
										 
 										  <div id="viewformResultado"></div>
  
 									 </div>
								
  								
								
								<!--/.row-->
								   
								
								   <div style="padding: 15px" align="center" id="resultado"></div>
 							</div>
						</div>
				 </div>
				  	
		</div>
		
    </div>
 
	   <input type="hidden">    
 
 
	
  <div id="FormPie"></div>    
	
    </div>   
</body>
</html>