 

$(document).ready(function(){
       
	 
	var tramite = getParameterByName('task');
 

	$("#proceso").val(tramite);
 

	lista_vehiculos();

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
*/

function Guardakm(objeto, id_emer_vehiculo,valor) {


	var idcaso = $("#proceso").val();

	var objeto1 = "#" + objeto + id_emer_vehiculo;
	var objeto2 = "#km2_"  + id_emer_vehiculo;

	var valor_01 = $(objeto1).val();

	var flotante1 = parseFloat(valor_01)   ;
	var flotante2 = parseFloat(valor)   ;

	if (flotante2 > flotante1)  {

		var parametros = {
			'accion' : 'kmvalor' ,
			'id' : idcaso,
			'id_emer_vehiculo' : id_emer_vehiculo,
			'valor1': flotante1,
			'valor2': flotante2
		};
	
			$.ajax({
				data:  parametros,
				url:   '_vehiculos_lista.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewVariablesDato").html('Procesando');
				},
				success:  function (data) {
						 $("#ViewVariablesDato").html(data);   
				 } 
			}); 


	}else  {
		$(objeto2).val('0');
	}

 


	 

}

/*
lista vehiculos disponibles Vehiculo_view
*/
function lista_vehiculos() {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'visor_vehiculo' ,
		'id' : idcaso
	};

		$.ajax({
			data:  parametros,
			url:   '_vehiculos_lista.php',
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
function agregar_carro(idbien) {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'add' ,
		'id' : idcaso,
		'idbien' : idbien
	};

		$.ajax({
			data:  parametros,
			url:   '_vehiculos_lista.php',
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
function eliminar_carro(idcodigo,idcaso) {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'eliminar' ,
		'id' : idcaso,
		'idcodigo' : idcodigo
	};

		$.ajax({
			data:  parametros,
			url:   '_vehiculos_lista.php',
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
			url:   '_vehiculos_lista.php',
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