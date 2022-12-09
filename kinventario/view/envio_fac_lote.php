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
		  
		   var cajero =  getParameterByName('cajero');
		   var fecha1 =  getParameterByName('fecha1');
		   
		      var parametros = {
 	                   'cajero' : cajero ,
				       'fecha1' : fecha1 
		      };
 
 /*
		   
		       $.ajax({
                      async:true,    
                      cache:false,   
                       type: 'POST',   
                      url:   '../controller/Controller-FacElectronicaFull.php',
                      data:  parametros,
                      success:  function(data){  
						  
                              $('#men').html(data);
							
							  $( "#men" ).fadeOut( 3600 );
							
							  $("#men").fadeIn("slow");
							
						        boton = window.opener.document.getElementById('load');
	 
	 						    boton.click();
						  
						        setTimeout("self.close();", 1000);
                      },
                      beforeSend:function(){},
                      error:function(objXMLHttpRequest){}
                    });
		   
		   */
		    
 
       </script> 
	  <h5 id='men'>ENVIANDO FACTURA</h5> 
 </div>
</body>
</html> 