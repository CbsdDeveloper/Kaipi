
$(document).ready(function(){
	 var modulo =  'kcontabilidad';
	 var parametros = {			    'ViewModulo' : modulo     };
	  	$.ajax({			data:  parametros,			url:   '../model/Model-moduloOpcion.php',			type:  'GET' ,			cache: false,		    beforeSend: function () { 						$("#ViewModulo").html('Procesando');				},			success:  function (data) {					 $("#ViewModulo").html(data);   				} 
	}); 
	 	$("#FormEmpresa").load('../model/Model-modulo.php');
	$("#NavMod").load('../view/View-HeaderInicio.php');
	$("#ParametroContable").load('../view/parametroConta.svg');
	$("#FormPie").load('../view/View-pie.php'); 
	 	
});
//------------------
function variableEmpresa(){
	 var ruc = $("#ruc_registro").val(); 
	 
	 var anio= $("#anio_periodo").val(); 
	 var parametros = {			    'ruc' : ruc ,
			    'anio' : anio    };
	$.ajax({			data:  parametros,			 url:   '../model/moduloCliente.php',			type:  'GET' ,			cache: false,			beforeSend: function () { 						$("#RucRegistro").html('Procesando');				},			success:  function (data) {					 $("#RucRegistro").html(data);  // $("#cuenta").html(response);				} 	});  }; 
//------------------function llamarsolicitud(url){
	document.location = url;
}