$(document).ready(function(){
    
  	
 		var a = getParameterByName('a');
 		var id = getParameterByName('id');



		FormView(a,id);
	    
	 
	         
});  
//------------
function FormView(a,id)
{

 	 var parametros = {
			    'a' : a, 
			    'id' : id,
    };

 	$.ajax({

			data:  parametros,
			url:   '_notificacion.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
					 $("#ViewMensaje").html(data);  
				} 

	});

}
//------------
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
} 
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion1,id) {
 
 
	
     var parametros = {
					'accion' : accion1 ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_movimiento.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

 	  
    }
  
///---------------------------
function MensajeEnviar( ){    
	
	
	var tramite 			 = $('#tramite').val();
	var idprov				 = $('#responsable').val();
	var nombre_funcionario   = $('#nombre_funcionario').val();
	var modulo = $('#modulo').val();
	var tarea = $('#tarea').val();
	  
                			
 						var parametros = {
								'idprov' : idprov,
					            'tramite' : tramite ,
					            'nombre_funcionario' : nombre_funcionario,
					            'modulo' : modulo ,
					            'tarea':tarea
						};
 	
 	if ( tarea)		{ 			
						$.ajax({
								data:  parametros,
								url:   '../kadmin/model/EnvioCorreoNoti.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
											$("#EnviarMensaje").html('Procesando');
									},
								success:  function (data) {
										 $("#EnviarMensaje").html(data);  // $("#cuenta").html(response);
									     
									} 
						}); 
	
	}
	
 	
}
 