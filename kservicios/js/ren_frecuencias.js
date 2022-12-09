var oTable;
var formulario 		   =  'ren_frecuencias';
var modulo_sistema     =  'kservicios';

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


 

		oTable 	= $('#jsontable').dataTable( {      
			searching: true,
			paging: true, 
			info: true,         
			lengthChange:true ,
			aoColumnDefs: [
				 { "sClass": "highlight", "aTargets": [ 1 ] }
			   ] 
		 } );

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

		$("#id_fre").val('');

		$("#idprov").val("");

		$("#ruta_ori").val("");

		$("#ruta_des").val("");

		$("#num_carro").val("00");

		$("#num_placa").val("-");


		$("#id_ciu_ori").val("");

		$("#id_ciu_des").val("0");

		$("#chofer").val("SN");

		$("#hora").val("");

		$("#hora_min").val("05:00");


 }
/*
Funcion que devuelve los parametros
*/
 function accion(id,modo,estado)

{

 	$("#action").val(modo);

 	$("#id_fre").val(id);

    BusquedaGrilla(oTable);


}

/*
Busqueda de la grilla de informacion que se desliega en la pantalla  principal
*/
  function BusquedaGrilla(oTable){        	 

   	var ciu_bus = $("#ciu_bus").val();

 

    var parametros = {
				'ciu_bus' : ciu_bus,  

     };


		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario+'.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			oTable.fnClearTable();

				for(var i = 0; i < s.length; i++) {

					oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
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
 