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
 </head>
</head>
<body>
  <div class="well">  
  
	    
	   <script>  
		   
		   
		   function getParameterByName(name) {
			   
				name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
				results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		   	}
		  
		   var id =  getParameterByName('id');
		   
 
	  	    var parametros = {
 	                   'id' : id 
		  };
 
	    
		  $.ajax({
						data:  parametros,
						url:   '../controller/Controller-FacElectronica.php',
						type:  'GET' ,
					 
						success:  function (data) {
							
						      $('#men').html(data);
							
							  $( "#men" ).fadeOut( 3600 );
							
							  $("#men").fadeIn("slow");
							
						         window.close();
							     
	 					} 
				}); 
	 
 
       </script> 
	  <h5 id='men'>ENVIANDO FACTURA</h5> 
 </div>
</body>
</html> 