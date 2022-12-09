$(document).ready(function(){
  
    setInterval(function(){ 
	        $.get('../model/EnvioEmailFactura.php', function(response){
	        	$("#FacturaElectronica").html(response); 
	        	 
	        }); 
	    }, 500000);
	   
  
});  