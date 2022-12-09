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
 
 	<script type="text/javascript" src="../js/cliente.js"></script> 
 	 		 
</head>
<body>

<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
 <div id="main">
	<!-- Header -->
  <!-- ------------------------------------------------------ -->  
	   <div class="col-md-12" style="padding-top: 1px"> 
        		 <!-- Content Here -->
               <div id="ViewFormCIU"> aqui</div>       
          
 		</div>
	   
       <div class="col-md-12" style="padding-top: 1px"> 
        		 <!-- Content Here -->
               <div id="ViewForm"> </div>       
          
 		</div>
 
	 
	 <div class="col-md-12"  align="center" style="padding: 10px"> 
		<a onClick="actualiza_cliente()" class="btn btn-info" href="#">Enviar al formulario</a>
			</div> 
	 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
