<?php  
session_start( );  
?>
<!DOCTYPE html>
<html lang="en">
	
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
	<meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
	
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 
	<script type="text/javascript" src="../js/ven_facturaId.js"></script> 
 		
  	 
	<script> 
		
		$(document).ready(function(){
		
			 var id = <?php  echo $_GET['id']  ?> ;
 			 var accion = 'editar'; 			 
 			
		     $("#ViewForm").load('../controller/Controller-ven_facturaId.php?id='+id+'&accion='+accion);
 
		 
	 
});  
 		 
  	</script> 
	
	<style>
		
    	#mdialTamanio{
      			width: 55% !important;
   			 }
		iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
		}
  
	</style>
	
	 
	
</head>
<body>
 
 
<div id="main">
	
 	
 
	
    <!-- Content Here -->
	
    <div class="col-md-12" > 
  			<div id="ViewForm"> </div>
	</div>

 

 
    
</div>

</body>
</html>
