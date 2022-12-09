var oTable;
var formulario 		   =  'adm_pac';
var modulo_sistema     =  'kgarantia';
 
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

//----------

function SiguientePaso( idtarea1 ,idtarea_seg,idtarea_segcom)
{
	
// filtro para poner los objetivos de la unidad	

$("#idtarea1").val( idtarea1 );
$("#idtarea_seg").val( idtarea_seg );
$("#idtarea_segcom").val( idtarea_segcom );
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom
    };
 
	$.ajax({
				data:  parametros,
				 url:   '../../kplanificacion/controller/Controller_ver_tarea_paso.php',
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormComentario").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormComentario").html(data); 
					     
					} 
		});
 
	 
}

//-------------
function VerTarea( idtarea )
{
	
// filtro para poner los objetivos de la unidad	
	 
	 
	var parametros = {
				 'idtarea'  : idtarea 
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../../kplanificacion/controller/Controller_ver_tarea.php",
		 type: "GET",
       success: function(response)
       {
           $('#ViewFormTarea').html(response);
       }
	 });
	 
}
//------------

function SiguienteProceso( )
{
	
// filtro para poner los objetivos de la unidad	
var idtarea1 			= $("#idtarea1").val(  );
var idtarea_seg 		= $("#idtarea_seg").val(  );
var idtarea_segcom 		= $("#idtarea_segcom").val(  );

var secuencia_next			= $("#secuencia_next").val(  );
var idtarea_segcom_next		= $("#idtarea_segcom_next").val(  );
var comentario_dato         = $("#comentario_dato").val(  );


var proceso = $("#proceso_nombre").val();
 
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom,
			    'secuencia_next':secuencia_next,
			    'idtarea_segcom_next':idtarea_segcom_next,
			    'comentario_dato':comentario_dato
    };
 
 
 if(confirm("Desea guardar y enviar el proceso seleccionado?"))
	{
	              	$.ajax({
										data:  parametros,
										 url:   '../../kplanificacion/model/ajax_tarea_ejecuta.php',
										type:  'POST' ,
											beforeSend: function () { 
													$("#guardarDatosCom").html('Procesando');
											},
										success:  function (data) {
												    $("#guardarDatosCom").html(data); 
												    
												    busqueda_proceso (proceso );
						 					} 
								});
	}
	else
	{
	   return false;
	}
 
}


//------ enlace con plabificacion
function busqueda_proceso (proceso )
{
 
     var Q_IDPERIODO =  $("#anio").val();
 
 $("#proceso_nombre").val(proceso);
 
 
	 var parametros1 = {
			    'proceso'  : proceso ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
 };
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../../kplanificacion/model/Model_seg_proceso.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#PendientesVisor").html('Procesando');
			},
		success:  function (data) {
				 $("#PendientesVisor").html(data);   
			     
			} 
    });

	
}
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

	$("#referencia").val("");

	$("#partida").val("");

	$("#cpc").val("");

	$("#tipo").val("");

	$("#regimen").val("");

	$("#bid").val("");

	$("#tipo_proyecto").val("");

	$("#tipo_producto").val("");

	$("#catalogo_e").val("");

	$("#procedimiento").val("");

	$("#detalle").val("");

	$("#cantidad").val("");

	$("#medida").val("");

	$("#costo").val("");

	$("#total").val("");

	$("#periodo").val("");

	$("#estado").val("");

	$("#id_pac").val('');


 }
/*
Funcion que devuelve los parametros
*/
 function accion(id,modo,estado)

{

 	$("#action").val(modo);

 	$("#id_pac").val(id);

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

   	var banio            = $("#banio").val();

   	var btipo            = $("#btipo").val();

   	var bregimen         = $("#bregimen").val();

   	var btipo_proyecto   = $("#btipo_proyecto").val();

   	var btipo_producto   = $("#btipo_producto").val();
   	
   	var bprocedimiento   = $("#bprocedimiento").val();


    var parametros = {
				
				'banio'         : banio,
				'btipo'         : btipo,
				'bregimen'      : bregimen,
				'btipo_proyecto': btipo_proyecto,
				'btipo_producto': btipo_producto,
				'bprocedimiento': bprocedimiento
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
							s[i][5],
							s[i][6],
							s[i][7],
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
 