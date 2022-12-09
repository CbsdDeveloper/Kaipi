var oTable;
var formulario 		   =  'co_secuencias';
var modulo_sistema     =  'kcontabilidad';

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

			return false	  ;

		   }
/*
Copiar parametros años nuevo
*/

function GenerarPeriodo() {


	var anio = $("#banio").val(); 

	alert('Generando periodo ' + anio);


	var parametros = {
					'accion' : 'apertura' ,

                    'id' : anio 

 	  };

	  $.ajax({

					data:  parametros,
					url:   '../model/Model-'+ formulario+'.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);
  					} 

			}); 



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
 							$("#result").html('Procesando');
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

	   $("#idsecuencias").val('');

	   $("#detalle").val("");

	   $("#secuencia").val(" ");

	   $("#estado").val(" ");

	   $("#anio").val("");

	   $("#tipo").val(" ");

	 

    }

/*
Funcion que devuelve los parametros
*/
function accion(id,modo,estado)

{

	$("#action").val(modo);

	$("#idsecuencias").val(id);///asignación de id de secuencia

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

   	var banio = $("#banio").val();  //variable de busqueda
    
    var parametros = {
				'banio' : banio
				
				
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
							s[i][4],
						'<button class="btn btn-xs btn-warning" title="Editar registro actual" onClick="goToURL('+"'editar'"+','+"'" +s[i][0] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
					 
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

					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);

				     

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
Pone formulario de filtro
*/

 function FormFiltro()

 {

	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');

 }



  