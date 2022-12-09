//-------------------------------------------------------------------------
$(document).ready(function(){
    
	 
  
    setInterval(function(){ 
	        $.get('../model/EnvioEmailFactura.php', function(response){
	        	$("#FacturaElectronica").html(response); 
	        	 
	        }); 
	    }, 600000)
	   
	    //--------- 180.000  3 min
	    //--------- 300.000  5 min
	    //--------- 600.000  10 min
	    //--------- 350.000
 
  
});  