

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
	
    $("#viewform").load('../controller/Controller-mispersonal.php');
	


    var parametros1 = {
        'codigo' : 3 
    };
    
	$.ajax({
        data:  parametros1,
         url:   '../model/ajax_plantilla.php',
        type:  'GET' ,
            beforeSend: function () { 
                    $("#resolucion_lista").html('Procesando');
            },
        success:  function (data) {
                 $("#resolucion_lista").html(data);  // $("#cuenta").html(response);
                 
            } 
    }); 

    
	
	
});


function ActualizarDatos(){

	 var idprov = $("#idprov").val(); 

     var vivienda     = $("#vivienda").val(); 
     var salud        = $("#salud").val(); 
     var alimentacion = $("#alimentacion").val(); 
     var vestimenta   = $("#vestimenta").val(); 
     var educacion    = $("#educacion").val(); 
     var turismo    = $("#turismo").val(); 
     var razon    = $("#razon").val(); 
 	 
 
 
	 var parametros = {
			    'accion' : 'gastos' ,
                'idprov' : idprov,
                'vivienda' : vivienda,
                'salud' : salud,
                'alimentacion' : alimentacion,
                'vestimenta' : vestimenta,
                'educacion' : educacion,
                'turismo' : turismo,
                'razon' :razon
    };
	  

    alertify.confirm("<p>VA A REALIZAR LA ACTUALIZACION DE DATOS... </p>", function (e) {

        if (e) {
            
                $.ajax({
                        data:  parametros,
                        url:   '../model/ajax_actualiza_nomina.php',
                        type:  'POST' ,
                            beforeSend: function () { 
                                    $("#resultado").html('Procesando');
                            },
                        success:  function (data) {
                                $("#resultado").html(data);  // $("#cuenta").html(response);
                                
                            } 
                });  
            }

       }); 
	  
	
	 

 
}; 
