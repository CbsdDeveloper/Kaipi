$(document).ready(function(){

	var modulo =  'kpresupuesto';

	 var parametros = {
			    'ViewModulo' : modulo 
    };

	$.ajax({
			data:  parametros,
			url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
			cache: false,
		    beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);   
				} 

	}); 
 
 
 	$("#NavMod").load('../view/View-HeaderInicio.php');
 

	$("#FormPie").load('../view/View-pie.php');
 
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
			cache: false,
			beforeSend: function () { 
						$("#RucRegistro").html('Procesando');
				},
			success:  function (data) {
					 $("#RucRegistro").html(data);  
			} 

	});  
}; 
//------------------

//----------------------------
function llamarsolicitud(url){
	 
	document.location = url;

}