

$(document).ready(function(){

 
	
	
	$("#NavMod").load('../view/View-HeaderMain.php');
	
 	$("#FormPie").load('../view/View-pie.php');

	 
	 var modulo =  'kadmin';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 
	


            var parametros1 = {
                'accion' : 'BLD' 
            };

            $.ajax({
                data:  parametros1,
                url:   '../controller/Controller-misBienes.php',
                type:  'GET' ,
                    beforeSend: function () { 
                            $("#viewform").html('Procesando');
                    },
                success:  function (data) {
                        $("#viewform").html(data);  // $("#cuenta").html(response);
                        
                    } 
        }); 

     
            var parametros1 = {
                'accion' : 'BCA' 
            };

            $.ajax({
                data:  parametros1,
                url:   '../controller/Controller-misBienes.php',
                type:  'GET' ,
                    beforeSend: function () { 
                            $("#viewforme").html('Procesando');
                    },
                success:  function (data) {
                        $("#viewforme").html(data);  // $("#cuenta").html(response);
                        
                    } 
            }); 

 





    
	
	
});
 