var oTable;
var formulario 		   =  'ad_pac';
var modulo_sistema     =  'kplanificacion';
 
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
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		       { "sClass": "ye", "aTargets": [ 4 ] },
		      { "sClass": "de", "aTargets": [ 3 ] }
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

//------
function VerPac()
{

var tarea 			= $("#idtarea1").val(  );
var segtarea 		= $("#idtarea_seg").val(  );
 
		
		 var enlace = '../../reportes/aval_pac?id='+tarea+'&seg='+segtarea ;
		  
		 window.open(enlace,'#','width=750,height=480,left=30,top=20');
 

}
//--------------------------------------
function VerPac1()
{

var tarea 			= $("#idtarea1").val(  );
var segtarea 		= $("#idtarea_seg").val(  );
 
		
		 var enlace = '../../reportes/aval_pac1?id='+tarea+'&seg='+segtarea ;
		  
		 window.open(enlace,'#','width=750,height=480,left=30,top=20');
 

}
//--------
function NoProceso( )
{
	
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
 
 
 if(confirm("Desea enviar el proceso a la unidad requirente?"))
	{
	              	$.ajax({
										data:  parametros,
											 url:   '../../kplanificacion/model/ajax_tarea_noejecuta.php',
										type:  'POST' ,
											beforeSend: function () { 
													$("#guardarDatosCom").html('Procesando');
											},
										success:  function (data) {
												    $("#guardarDatosCom").html(data); 
												    
												   
						 					} 
								});
								 busqueda_proceso (proceso );
	}
	else
	{
	   return false;
	}
 
}


//----------Controller_ver_tarea_paso

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
				 url:   '../../kplanificacion/controller/Controller_ver_tarea_cur.php',
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormComentario").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormComentario").html(data); 
					     
					} 
		});
 
	 
}

 //------------------------
 function VerAvance ( seg_tarea1 ,seg_tarease1    )
{
 
 
 	$("#tareaf").val(seg_tarea1);
	
	$("#idtarea_segf").val(seg_tarease1);
	
 
		 var parametros1 = {
					'idtarea'  : seg_tarea1  ,
					'seg_tarease1': seg_tarease1
				}
		 
		$.ajax({
			data:  parametros1,
			 url:   '../../kplanificacion/model/ajax_tarea_avance_p.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormRecorrido").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormRecorrido").html(data);   
					 
				} 
	  });
 
   
	  


}
 

//---------------------
function AdjuntarDoc ()
{
	
	var ancho = 650 ;
	var alto = 360;
 
 var tarea		 =	$("#tareaf").val();
 var idtarea_seg =	$("#idtarea_segf").val();
	
  	   
	var posicion_x; 

	var posicion_y; 

	var enlace = '../../upload/uploadDoc_pla_seg?id='+ tarea + '&seg=' + idtarea_seg; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
 
	if ( tarea > 0 ) {

			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }

} 
//--------------------------------
function AbrirDocInicio (tarea, idtarea_seg)
{
	
	$("#tareaf").val(tarea);
	
	$("#idtarea_segf").val(idtarea_seg);
	
	
	var parametros = {
								'idcodigo' : tarea  ,
								'idcaso'   : idtarea_seg  ,
								'accion' : 'archivos',
								'visor' : '2'
				   };
			
				  $.ajax({
								 data:  parametros,
								 url:   '../../kplanificacion/model/Model_nov__doc_tra01.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#Seguimiento_archivo").html(data);   
			  
								 } 
			
						}); 
 
	
 }	
 //-----
 function goToURL_actividad(accion,id_pac_seg)
{

	var id_pac = $("#id_pac").val();

	$("#action_02").val(accion);
	
	$("#id_pac1").val(id_pac);


	var parametros = {
			   'id' : id_pac_seg ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../../kgarantia/model/Model_seg_pac02.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarActividad").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarActividad").html(data);  
					
			   } 
   });
	
   $("#myModalActividad").modal('show'); // abre el formulario modal

}
//-------
function LimpiaActividades() {
  

  var fecha = fecha_hoy();
 
	 var id_pac = $("#id_pac").val();
	 
	  $("#id_pac1").val(id_pac);
	 
 
	
				if ( id_pac > 0 ){
					
					$("#idtarea").val("0");
					$("#idtramite").val("0");
					$("#instancia").val("");
					$("#pac_comentario").val("");
					$("#cumplio").val("N");
					$("#fecha").val(fecha);
					$("#fecha_alerta").val(fecha);
					$("#action_02").val("add");

			
			  
					$("#myModalActividad").modal('show'); // abre el formulario modal
			 
			 
   }	 
} 
//----- 
function busqueda_pac(  )
{
	
// filtro para poner los objetivos de la unidad	
	 
	 
	 var id_pac = $("#id_pac").val();
	 
	var parametros = {
				 'id_pac'  : id_pac 
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../../kgarantia/model/ajax_seg_pac.php",
		 type: "GET",
       success: function(response)
       {
           $('#PendientesVisor').html(response);
       }
	 });
	 
	   $('#guardarPac').html('');
	 
	 
	 
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
		 url: "../../kplanificacion/controller/Controller_ver_tarea_pac.php",
		 type: "GET",
       success: function(response)
       {
           $('#ViewFormTarea').html(response);
       }
	 });
	 
	   $('#guardarPac').html('');
	 
	 
	 
}
//---------
function ActualizarPAC(   )
{
	
// filtro para poner los objetivos de la unidad	
	 
	 var idpac_matriz 			= $("#idpac_matriz").val();
     var idtarea_matriz 		= $("#idtarea_matriz").val();
	  
          
          
	var parametros = {
				 'idtarea'     : idtarea_matriz ,
				 'idpac_matriz':idpac_matriz
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../../kplanificacion/model/ajax_tarea_seg04.php",
		 type: "GET",
       success: function(response)
       {
           $('#guardarPac').html(response);
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

var fecha_cer         = $("#fecha_cer").val(  );
var cur_cer         = $("#cur_dev").val(  );
  
          

  
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom,
			    'secuencia_next':secuencia_next,
			    'idtarea_segcom_next':idtarea_segcom_next,
			    'comentario_dato':comentario_dato,
			    'fecha_cer':fecha_cer,
			    'cur_cer':cur_cer 
    };
 
 
 if(confirm("Desea guardar y enviar el proceso seleccionado?"))
	{
	              	$.ajax({
										data:  parametros,
										 url:   '../../kplanificacion/model/ajax_tarea_ejecuta_cur.php',
										type:  'POST' ,
											beforeSend: function () { 
													$("#guardarDatosCom").html('Procesando');
											},
										success:  function (data) {
												    $("#guardarDatosCom").html(data); 
												    
												     BusquedaPlanificacion();
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
 	
 	var nombre = $("#detalle").val();
 	
 	$("#npac").html(nombre);
 	

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
    
    return today;

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
 		    url: '../../kgarantia/grilla/grilla_ad_pac.php',
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
 					 $("#ViewModulo").html(data);  
 				} 

	});
 
 }
/*
Pone formulario de datos
*/
 function FormView()

 {
 
	 $("#ViewForm").load('../../kgarantia/controller/Controller-' + formulario+'.php');
	 
	 
	  $("#ViewActividad").load('../../kgarantia/controller/Controller_pac_seg_01.php'); // actividad
 
 }
/*
Pone formulario de filtro de datos
*/
 function FormFiltro()

 {

  	 $("#ViewFiltro").load('../../kgarantia/controller/Controller-'+formulario+'_filtro.php');

 }
 