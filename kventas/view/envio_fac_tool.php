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
                      async:true,    
                      cache:false,   
                      type: 'POST',   
                      url:   '../controller/Controller-FacElectronica.php',
                      data:  parametros,
                      success:  function(data){  
						  
 							
							 $("#men").fadeIn("slow");
							
						     $( "#men" ).slideUp( 300 ).delay( 800 ).fadeIn( 400 );
 						  
						     $('#men').html(data);
						  
						     boton = window.opener.document.getElementById('load');
	 
	 						 boton.click();
						  
						      var mensaje = data.trim();
						  
						    // alert(mensaje);
						  
 						    window.close();
						    
                      },
                      beforeSend:function(){},
                      error:function(objXMLHttpRequest){}
                    });
     				
		   		    
       </script> 
	  <h5 id='men' align="center">ENVIANDO FACTURA</h5> 
 
		
</body>
</html> 