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

///----------------cedula
 
 function validarCiu() {

     
	 var action = $('#action').val();
	 
 	 var cad = document.getElementById("idprov").value.trim();
 	 var tpidprov = document.getElementById("tpidprov").value.trim();

	 var total = 0;
     var longitud = cad.length;
     var longcheck = longitud - 1;

    
    if ( action == 'add'){
 			     if (tpidprov == '02'){
			 
						     if (cad != "" && longitud == 10){   
			
						       for(i = 0; i < longcheck; i++){
			
						         if (i%2 === 0) {
			
						           var aux = cad.charAt(i) * 2;
			
						           if (aux > 9) aux -= 9;
			
						           total += aux;
			
						         } else {
			
						           total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
			
						         }
			
						       }
			
						       total = total % 10 ? 10 - total % 10 : 0;
			
						       if (cad.charAt(longitud-1) != total) {
			
			 			    	   document.getElementById("idprov").value = '';
			
						       }else{
			
						    	   valida_identificacionExiste(cad,tpidprov);
			
						       }
			
					          }else{
			
					        	  document.getElementById("idprov").value = '';
			
					           }
			              }
					      //-----------------------------------
					      if (tpidprov == '01'){
					
					    	 validarRUC();
					
					     }
    		}
     

   }

 //---------------------------------------------------------

 function valida_identificacionExiste(cedula,tipo) {

	 
     var parametros = {

					'cedula' : cedula ,

                    'tipo' : tipo 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-cedula.php',

					type:  'GET' ,

 					 

					success:  function (data) {

							 $("#idprov").val(data);  // $("#cuenta").html(response);

						     

  					} 

			}); 
 

    }

 //--------------------------------------

 function validarRUC(){

	 

	  var number = document.getElementById('idprov').value;

	  var dto = number.length;

	  var valor;

	  var acu=0;

	 

 

	   for (var i=0; i<dto; i++){

	   valor = number.substring(i,i+1);

		   if(valor==0||valor==1||valor==2||valor==3||valor==4||valor==5||valor==6||valor==7||valor==8||valor==9){

		    acu = acu+1;

		   }

	   }

	   if(acu==dto){

	    while(number.substring(10,13)!=001){

	    	//    alert('Los tres últimos dígitos no tienen el código del RUC 001.');

	     document.getElementById("idprov").value = 'NO_VALIDO';

	     return;

	    }

	    while(number.substring(0,2)>24){    

	     //alert('Los dos primeros dígitos no pueden ser mayores a 24.');

	     document.getElementById("idprov").value = 'NO_VALIDO';

	     return;

	    }

  

	    var porcion1 = number.substring(2,3);

	  /*  if(porcion1<6){

	     alert('El tercer dígito es menor a 6, por lo \ntanto el usuario es una persona natural.\n');

	    }

	    else{

	     if(porcion1==6){

	      alert('El tercer dígito es igual a 6, por lo \ntanto el usuario es una entidad pública.\n');

	     }

	     else{

	      if(porcion1==9){

	       alert('El tercer dígito es igual a 9, por lo \ntanto el usuario es una sociedad privada.\n');

	      }

	     }

	    }*/

	   }

	   else{

		   document.getElementById("idprov").value = 'NO_VALIDO';

	   }
 
 
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
  
