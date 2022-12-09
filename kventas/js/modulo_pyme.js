$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kventas';
		 
 
	
	//---
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#NavMod").load('../view/View-HeaderInicioPymes.php');
	
	
	
	$("#ParametroVentas").load('../view/pyme_venta.svg');
 
	
	$("#FormPie").load('../view/View-pie.php');
	 
	ultimaActualizacion();
	
 
	 
});


//------------------
function variableEmpresa(){

	 var ruc = $("#ruc_registro").val(); 
 
	 var parametros = {
			    'ruc' : ruc 
    };
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/SeleccionEmpresa.php',
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
function ultimaActualizacion(){

 
	  
	$.ajax({
 			 url:   '../model/Model-ultimaActual.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ActividadUltima1").html('Procesando');
				},
			success:  function (data) {
					 $("#ActividadUltima1").html(data);  
				     
				} 
	});  
 
	
	$.ajax({
		 url:   '../model/Model-ultimaActividad.php',
		type:  'GET' ,
		cache: false,
		beforeSend: function () { 
					$("#ActividadUltima2").html('Procesando');
			},
		success:  function (data) {
				 $("#ActividadUltima2").html(data);   
			     
			} 
});  
	
	
	
	
}; 
//------------------
function llamarsolicitud(url){
 	 
	document.location = url;

 
}; 

