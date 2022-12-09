var oTable;
var formulario 		   =  'ac_clase';
var modulo_sistema     =  'kactivos';

/*
llama las funciones para la operacion del formulario
*/
$(function(){

    $(document).bind("contextmenu",function(e){

        return false;

    });
 	

});
/*
Inicializacion de variables y funciones
*/
$(document).ready(function(){


        oTable = $('#jsontable').dataTable(); 

		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		modulo();

	    FormView();

	    FormFiltro();


	 	$('#load').on('click',function(){
	   
	            BusquedaGrilla(oTable);

		});  

});  
/*
 boton que ejecuta los mensajes para insertar el registro
*/
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

				if (e) {

						LimpiarPantalla();

						$("#action").val("add");

						$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');

				}

			 }); 

			}

			if (tipo =="alerta"){			 

			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {

			  });

			 }		  

			return false	  

		   }
/*
Envia el registro seleccionado para edicion o eliminar datos
*/
function goToURL(accion,id) {

	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	  $.ajax({

					data:  parametros,
					url:   '../model/Model-'+ formulario+'.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando informacion');
  					},
					success:  function (data) {
							    $("#result").html(data); 
  					} 

			}); 

    }
/*
limpia la pantalla con los objetos de la base
*/
function LimpiarPantalla() {

	    $("#action").val("add");

		$("#idclasebien").val('');

		$("#clase").val("");

		$("#referencia").val("");


 }
/*
Funcion que devuelve los parametros
*/
 function accion(id,modo,estado)

{

 	$("#action").val(modo);
 	
 	$("#idclasebien").val(id);

    BusquedaGrilla(oTable);


}
/*
Fecha hoy
*/
 function fecha_hoy()
{

    var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();

    if(dd < 10){
        dd='0'+ dd
    } 

    if(mm < 10){
        mm='0'+ mm
    } 
    var today = yyyy + '-' + mm + '-' + dd;

} 
/*
Busqueda de la grilla de informacion que se desliega en la pantalla  principal
*/
  function BusquedaGrilla(oTable){        	 

   	var breferencia= $("#breferencia").val();


    var parametros = {
				'breferencia' : breferencia,  
    };


		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario +'.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			oTable.fnClearTable();

				for(var i = 0; i < s.length; i++) {

					oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
						'<button class="btn btn-xs btn-warning" title="Editar registro actual" onClick="goToURL('+"'editar'"+','+"'" +s[i][0] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs btn-danger"  title="Eliminar registro actual" onClick="goToURL('+"'del'"+',' +"'" + s[i][0] +"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
					]);										

				} // End For
 			} 
 	 	});
 

  }   
/*
funcion que permite colocar el nombre del modulo de las opciones asignadas al usuario.
*/
 function modulo()

 {
 
 
 	 var parametros = {
 			    'ViewModulo' : modulo_sistema 
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
 
 }
/*
Pone formulario de datos
*/
 function FormView()

 {
 
	 $("#ViewForm").load('../controller/Controller-' + formulario+'.php');
 
 }
/*
Pone formulario de filtro de datos
*/
 function FormFiltro()

 {

  	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');

 }
 