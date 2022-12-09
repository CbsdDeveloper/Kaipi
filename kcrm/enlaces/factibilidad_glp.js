 

$(document).ready(function(){
       
	 
	var tramite = getParameterByName('task');
 

 
   $("#view_formulario").load('../controller/Controller_factibilidad_glp.php?idcaso='+tramite);
   
 

 
 
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
    var idprov = $("#idprov").val();
    var nombres = $("#nombres").val();
    var edad = $("#edad").val();
    var tipo = $("#tipo").val();


	var parametros = {
		'accion' : 'visor_personal' ,
        'id' :  idcaso,
		'idprov' : idprov,
        'nombres' : nombres,
        'edad' : edad,
        'tipo' : tipo
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_paciente.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#paciente_view").html('Procesando');
			},
			success:  function (data) {
 					$("#paciente_view").html(data);   
 			} 
		}); 

}	
/*
agrega carro
*/
function agregar_personal( ) {



	var idcaso = $("#proceso").val();
    var idprov = $("#idprov").val();
    var nombres = $("#nombres").val();
    var edad = $("#edad").val();
    var tipo = $("#tipo").val();


	var parametros = {
		'accion' : 'add' ,
        'id' :  idcaso,
		'idprov' : idprov,
        'nombres' : nombres,
        'edad' : edad,
        'tipo' : tipo
	};

 

		$.ajax({
			data:  parametros,
			url:   '_personal_paciente',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#ViewVariables").html('Procesando');
			},
			success:  function (data) {
 					$("#ViewVariables").html(data);   
 			} 
		}); 


		visor_paciente(idcaso);
}	
/*
eliminar
*/
function deltramite(accion,idcasodet) {


	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : accion ,
		'id' : idcaso,
		'idcodigo' : idcasodet
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_paciente.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function (data) { 
				$("#ViewVariables").html(data);   
			},
			success:  function (data) {
				$("#ViewVariables").html(data);   
 			} 
		}); 


		visor_paciente(idcaso);

}	
/*
*/
function visor_paciente() {

 
	var idcaso = $("#proceso").val();


	var parametros = {
		'accion' : 'visor' ,
		'id' : idcaso
	};

		$.ajax({
			data:  parametros,
			url:   '_personal_paciente.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#ViewVariables").html('Procesando');
			},
			success:  function (data) {
 					$("#ViewVariables").html(data);   
 			} 
		}); 

       
}	