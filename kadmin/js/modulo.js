

$(document).ready(function(){

	
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#idMod").load('../view/parametro.svg');
	
	
	
	$("#NavMod").load('../view/View-HeaderInicio.php');
	
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
	
 
	
	
	
});


function variableEmpresa(){

	 var ruc = $("#ruc_registro").val(); 
	 
	 
 
	 var parametros = {
			    'ruc' : ruc 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/moduloCliente.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#RucRegistro").html('Procesando');
				},
			success:  function (data) {
					 $("#RucRegistro").html(data);  // $("#cuenta").html(response);
				     
				} 
	});  
	 

 
}; 
