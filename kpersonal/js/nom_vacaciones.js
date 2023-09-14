var oTable;

"use strict"; 

//-------------------------------------------------------------------------
$(document).ready(function(){
	

	   window.addEventListener("keypress", function(event){
	        if (event.keyCode == 13){
	            event.preventDefault();
	        }
	    }, false);

       oTable 	= $('#jsontable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
           aoColumnDefs: [
  		      { "sClass": "highlight", "aTargets": [ 0 ] },
 			   { "sClass": "de", "aTargets": [ 4 ] } ,
			   { "sClass": "di", "aTargets": [ 8 ] } 
 		    ] 
      } );
       
       

		$("#FormPie").load('../view/View-pie.php');
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();

	    FormView();
	    
	    
	    
	    $.ajax({
 			 url: "../model/ajax_unidad_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qunidad').html(response);
	       }
		 });
	    
	  
	    

 	   $('#load').on('click',function(){
 		   			BusquedaGrilla(oTable);
		});

     
 
 
		$('#excelload').on('click',function(){

	  		   

			exportar_excel('../../reportes/excel_personal_permiso.php');

  			

		});
 
 
 

});  

 
//----------
function imagenfoto(urlimagen)
{
  
	 $("#ImagenUsuario").attr("src",urlimagen);
 

}
///---------------
function openFile(url) {
    
	  var id 	= $('#id_vacacion').val();
	  var tipo  = $('#tipo').val();
	   

	  
	  var ancho= 650;
	  var alto = 550;

 	  var posicion_x; 
	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id +'&tipoo=' +tipo;
	 
	  if ( id) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}

function exportar_excel(url)

{

 
	 window.open(url,'_blank');

	 


}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){


	if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 
					$("#action").val("add");
 
					var resultado =  `<div class="alert alert-success"><img src="../../kimages/if_error_36026.png" align="absmiddle" />&nbsp;<strong>AGREGAR NUEVO REGISTRO DE TRANSACCION</strong>   COMPLETE LA INFORMACION PARA GUARDAR LA INFORMACION </div>`;
 				
					$("#result").html(resultado);

		            LimpiarPantalla();

			  }

			 }); 

			}

			if (tipo =="alerta"){			 

			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {

			  });

			 }		  

			return false	  

		   }

//-------------------------------------------------------------------------

// ir a la opcion de editar

function goToURL(id) {

 	 Ver_doc_prov(id) ;
	  
     $('#mytabs a[href="#tab2"]').tab('show');
		   
 
 }
 
//-------------------------------------------------------------------------
function goToURLParametro(accion,id) {

 
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_vacaciones.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
							 

  					} 

			}); 
 
  }


// ir a la opcion de editar

function LimpiarPantalla() {


	var fecha = fecha_hoy();

    $("#idprov").val("");
	$("#id_vacacion").val("");
	$("#tipo").val("");
	$("#motivo").val("");
	$("#cargoa").val("");
	$("#novedad").val("");
 	$("#fecha_in").val(fecha);
	$("#fecha_out").val(fecha);
	
	$("#dia_derecho").val("");
	$("#dia_acumula").val("");

	$("#dia_tomados").val("0");
	$("#hora_tomados").val("");
	$("#dia_pendientes").val("");
	$("#fecha").val(fecha);
 
	$("#observacion").val("Solicitud");

	


	$("#razon").val("");

	

}
//---------------------------
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

 

  //------------------------------------------------------------------------- 

  function BusquedaGrilla(oTable){        	 

  

		var user = $(this).attr('id');
       

      	var qunidad = $("#qunidad").val();
		var qambito = $("#qoperativo").val();
		  
     
       var parametros = {
  				'qunidad' : qunidad,
				'qambito' : qambito
 
      };

 
		if(user != '')  { 

		$.ajax({
 		 	data:  parametros,
		    url: '../grilla/grilla_nom_vacaciones.php',
			dataType: 'json',
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			if (s){ 
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
							s[i][8],
                           	'<button class="btn btn-xs btn-warning" onClick="goToURL('+ "'"+ s[i][9]+"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' 
 						]);										
 					}  
 			    }						
 			},
 			error: function(e){
 			   console.log(e.responseText);	
 			}
 			});
 		}

  }   
//------------------------------------------------------------------------- 
//-----------------
  function accion(id, action,idprov){

 
	    $('#action').val(action);
	  
	  	$('#id_vacacion').val(id);

		$('#idprov').val(idprov);  
 
		Ver_doc_prov(idprov);
 

  } 

  //--------------------------------------
 
 

 function modulo()
{
 	 
	 
	 var modulo1 =  'kpersonal';

		 

	 var parametros = {

			    'ViewModulo' : modulo1

    };

 
	$.ajax({

			data:  parametros,

			url:   '../model/Model-moduloOpcion.php',

			type:  'GET' ,

			success:  function (data) {

					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);

				     

				} 

	});
 
}
//-----------------

 function FormView()

 {

   
	 $("#ViewForm").load('../controller/Controller-nom_vacaciones.php');

	  
 
	 
	 
 }
 
 //---------------------------------------------------------

 function ValidaTipo(tipo) {

  	
		var fecha = fecha_hoy();
		
		$("#fecha_out").val(fecha);
		$("#fecha_in").val(fecha);
	
 	
				if ( tipo == 'vacaciones') {
					$("#hora_out").val('08:00');
					$("#hora_in").val('08:00');
					$('#hora_out').attr("readonly", true) ;
					$('#hora_in').attr("readonly", true) ;

					$('#fecha_out').attr("readonly", false) ;
					$('#fecha_in').attr("readonly", false) ;
	
				} 
	
				if ( tipo == 'permiso_dia') {
			
					$("#hora_out").val('08:00');
					$("#hora_in").val('08:00');
					
					$('#hora_out').attr("readonly", true) ;
					$('#hora_in').attr("readonly", true) ;

					$('#fecha_out').attr("readonly", false) ;
					$('#fecha_in').attr("readonly", false) ;

					
				}
	
				if ( tipo == 'permiso_hora') {

					$('#hora_out').attr("readonly", false) ;
					$('#hora_in').attr("readonly", false) ;

					$('#fecha_out').attr("readonly", false) ;
					$('#fecha_in').attr("readonly", true) ;
				}
		 

    }

 //--------------------------------------
 function ValidaFecha(fechaSalida) {

	var tipo = 	$('#tipo').val();

	var fecha_entrada = addDaysToDate(fechaSalida, 1);



	if ( tipo == 'permiso_hora') {

		$("#fecha_in").val(fechaSalida);

	}

	if ( tipo == 'permiso_dia') {
			
		$("#hora_out").val('08:00');
		$("#hora_in").val('08:00');
		$("#fecha_in").val(fecha_entrada);
		
	}
	if ( tipo == 'vacaciones') {
			
		$("#hora_out").val('08:00');
		$("#hora_in").val('08:00');
		$("#fecha_in").val(fecha_entrada);
		
	}


 }
 /*
 suma dias
 */
 function addDaysToDate(date, days){

    var res = new Date(date);
    res.setDate(res.getDate() + days);


	var myDate = new Date(res).toISOString();

	const myArray = myDate.split("T");

	str_fecha = myArray[0]; 

 

    return str_fecha;
} 
 
/*
APRUEBA LA TRANSACCION DE LAS VACACIONES
*/
function notificar_permiso() {


var id_vacacion = 	$('#id_vacacion').val();

alertify.confirm("<p>DESEA AUTORIZAR LA SOLICITUD DE LOS PERMISOS<br></p>", function (e) {

				if (e) {

					var parametros = {
						'accion' : 'aprobar' ,
						'id'     : id_vacacion
		 		   };
	
					$.ajax({
									data:  parametros,
									url:   '../model/Model-nom_vacaciones.php',
									type:  'GET' ,
									beforeSend: function () { 
											$("#result").html('Procesando');
									},
									success:  function (data) {
											$("#result").html(data);  
 									} 
							}); 
				 }

			}); 
}

function saldos_permiso() {


var id_vacacion = 	$('#id_vacacion').val();

 
		 

					var parametros = {
						'accion' : 'saldos' ,
						'id'     : id_vacacion
		 		   };
	
					$.ajax({
									data:  parametros,
									url:   '../model/Model-nom_vacaciones.php',
									type:  'GET' ,
									beforeSend: function () { 
											$("#result").html('Procesando');
									},
									success:  function (data) {
											$("#result").html(data);  
 									} 
							}); 
				 
}


/*
APRUEBA LA TRANSACCION DE LAS VACACIONES
*/
function anular_permiso( tipo) {


	var id_vacacion = 	$('#id_vacacion').val();
	
	alertify.confirm("<p>DESEA ANULAR LA SOLICITUD DE LOS PERMISOS<br></p>", function (e) {
	
					if (e) {
	
						var parametros = {
							'accion' : 'anular' ,
							'tipo' : tipo,
							'id'     : id_vacacion
						};
		
						$.ajax({
										data:  parametros,
										url:   '../model/Model-nom_vacaciones.php',
										type:  'GET' ,
										beforeSend: function () { 
												$("#result").html('Procesando');
										},
										success:  function (data) {
												$("#result").html(data);  
										 } 
								}); 
					 }
	
				}); 
	}

//---------------------
function Ver_doc_prov(idprov) {


 	$('#prove').val(idprov);
	
	 
     var parametros = {

					'idprov' : idprov  ,
					'estado': 4
  
 	  };

	 $.ajax({
	
						data:  parametros,
						url:   '../model/Model-nom_vacacion_historial.php',
						type:  'GET' ,
						beforeSend: function () { 
								$("#detalle_datos").html('Procesando');
	 					},
						success:  function (data) {
								 $("#detalle_datos").html(data);  
	
	 					} 
	
				}); 
 

    }
//---------------
function ValidaPermisos(tipo_dias,accion) {


   var idprov =  $("#idprov").val();  
	
	var parametros = {

				   'tipo' : tipo_dias,
				   'idprov':idprov
 
	  };

	 $.ajax({
				data:  parametros,
				url:   '../model/ajax_valida_dia.php',
				type:  'GET' ,
				dataType: "json",
				success:  function (response) {
						$("#dia_toca").val( response.a );   
						$("#dia_max").val( response.b );  
						$("#hora_max").val( response.c );  
							
				} 
		});

		if ( accion == 0){
			ValidaTipo(tipo_dias) ;
		}
		

   }	
/*
*/
function Ver_consulta(estado) {


	idprov =	$('#prove').val();
   
	
	var parametros = {

				   'idprov' : idprov  ,
				   'estado': estado
 
	  };

	$.ajax({
   
					   data:  parametros,
					   url:   '../model/Model-nom_vacacion_historial.php',
					   type:  'GET' ,
					   beforeSend: function () { 
							   $("#detalle_datos").html('Procesando');
						},
					   success:  function (data) {
								$("#detalle_datos").html(data);  
   
						} 
   
			   }); 


   }	
//-----------------------  
function goToURLDocdel(idcodigo,idprov) {

	 
    var parametros = {

					'idcodigo' : idcodigo  ,
					'prov'   : idprov  
 
	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-nom_rol_doc.php',

					type:  'GET' ,
 
					success:  function (data) {

							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);

 
 					} 

			}); 


   }
  
