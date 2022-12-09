$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	
	
	indicadoresProceso();
	
	 var modulo =  'kcrm';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
    };
	  
	 
		$("#lista_enviados").load('../flujo/TramiteRegistroCertificadoPropiedad.svg');
	  
	$.ajax({
			data:  parametros,
			url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
			cache: false,
		   beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 
	
	
	//----------------- 

	
	//---
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#NavMod").load('../view/View-HeaderInicio.php');
	
	
	$("#FormPie").load('../view/View-pie.php');
	 
	
	 
	 
});


//------------------
function variableEmpresa(){

	 var ruc = $("#ruc_registro").val(); 
 
	 var parametros = {
			    'ruc' : ruc 
    };
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/moduloCliente.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#RucRegistro").html('Procesando');
				},
			success:  function (data) {
					 $("#RucRegistro").html(data);  // $("#cuenta").html(response);
				     
				} 
	});  
 
}; 
//------------------
function indicadoresProceso(){

	 /*
	$.ajax({
 			 url:   '../model/listaIndicadores.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#div_indicador").html('Procesando');
				},
			success:  function (data) {
					 $("#div_indicador").html(data);  // $("#cuenta").html(response);
				     
				} 
	});  
	*/
 
}; 



//------------------
function llamarsolicitud(url){

	 
	document.location = url;

 
}; 

