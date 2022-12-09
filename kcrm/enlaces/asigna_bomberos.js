 

$(document).ready(function(){
       
	 
	var tramite = getParameterByName('task');
 

	$("#proceso").val(tramite);
 

	lista_nomina();

	visor_vehiculos();
 
});  
 
/*
coge variable	
*/
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}	

/*
cerrar pantalla
*/
function cerrar() {

	window.close();

}	
/*
lista nomina
*/
function lista_nomina() {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'visor_personal' ,
		'id' : idcaso
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_lista.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#Vehiculo_view").html('Procesando');
			},
			success:  function (data) {
 					$("#Vehiculo_view").html(data);   
 			} 
		}); 

}	
/*
agrega carro
*/
function agregar_personal(idprov,codigo) {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'add' ,
		'id' : idcaso,
		'idprov' : idprov
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_lista',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#Vehiculo_asigna").html('Procesando');
			},
			success:  function (data) {
 					$("#Vehiculo_asigna").html(data);   
 			} 
		}); 

}	
/*
eliminar
*/
function eliminar_personal(idcodigo,idcaso) {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'eliminar' ,
		'id' : idcaso,
		'idcodigo' : idcodigo
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_lista.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#Vehiculo_asigna").html('Procesando');
			},
			success:  function (data) {
 					$("#Vehiculo_asigna").html(data);   
 			} 
		}); 

}	
/*
*/
function visor_vehiculos() {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'asignar' ,
		'id' : idcaso
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_lista.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#Vehiculo_asigna").html('Procesando');
			},
			success:  function (data) {
 					$("#Vehiculo_asigna").html(data);   
 			} 
		}); 

}	