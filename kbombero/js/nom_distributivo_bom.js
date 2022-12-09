var oTable;

$(document).ready(function(){

	   

		$("#MHeader").load('../view/View-HeaderModel.php');
		modulo();
	    FormView();
		$("#FormPie").load('../view/View-pie.php');
	    
		oTable = $('#jsontable').dataTable(); 

	    BusquedaGrilla( oTable);

 
		$('#load').on('click',function(){
 
			BusquedaGrilla(oTable);

		});
     

});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

			  		$('#mytabs a[href="#tab2"]').tab('show');
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

//-------------------------------------------------------------------------

// ir a la opcion de editar

function goToURL(accion,id) {

  
     var parametros = {
					'accion' : accion ,
                    'id' : id 

 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_distributivo_bom.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);   
 							 VisorUnidad(id);
   					} 

			}); 
 
    }
/*
*/
function Autorizardistribucion( ) {

  
	var id_asigna_dis   = 	$('#id_asigna_dis').val();
	var estado   = 	$('#estado').val();


	var parametros = {
				   'accion' : 'aprobar' ,
				   'estado': estado,
				   'id' : id_asigna_dis 

	  };


	  alertify.confirm("<p>DESEA AUTORIZAR PROCESO DE DISTRIBUCION</p>", function (e) {

		if (e) {

					$.ajax({
						data:  parametros,
						url:   '../model/Model-nom_distributivo_bom.php',
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

	
//-------------------------------------------------------------------------

// ir a la opcion de editar

function LimpiarPantalla() {

 
    var fecha = fecha_hoy();

    $("#id_asigna_dis").val("");
    $("#fecha_solicitud").val(fecha);
    $("#doccumento").val("");
    $("#estado").val("digitado");
    $("#detalle").val("");
    $("#autoriza").val("");
    $("#operaciones").val("");

	
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
	

	var vestado   = 	$('#vestado').val();

      var parametros = {
			'vestado' :  vestado
      };
 

		$.ajax({
				data:  parametros,
				url: '../grilla/grilla_nom_distributivo_bom.php',
				dataType: 'json',
				success: function(s){
				console.log(s); 
				oTable.fnClearTable();
				if (s) {

					for(var i = 0; i < s.length; i++) {

							oTable.fnAddData([
									s[i][0],
									s[i][1],
									s[i][2],
									s[i][3],
									s[i][4],
									s[i][5],
									'<button title="EDITAR REGISTRO SELECCIONADO..." class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+"'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
									'<button title="ANULAR TRANSACCION SELECCIONADO.."class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ "'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
								]);										
							}  
					}						
				},
				error: function(e){
				console.log(e.responseText);	
				}
			});

  }   

//--------------

 

  function accion(id, action)

  {

   

  	$('#action').val(action);

  	

	$('#id_asigna_dis').val(id);
 
    BusquedaGrilla( oTable);

  	

  } 

  /*
  */


  function VerUnidadBuscar()

 {
 
	var id_asigna_dis   = 	$('#id_asigna_dis').val();

	 var parametros = {
		 		'accion':  'lista',
			    'id_asigna_dis' : id_asigna_dis
    };
	  
	var estado   = 	 $('#estado').val();


	if ( estado == 'autorizado') {
	}
	else 	 {
 
				if (id_asigna_dis)   {

						$.ajax({
								data:  parametros,
								url:   '../model/ajax_bom_lista.php',
								type:  'GET' ,
									beforeSend: function () { 
											$("#listafun").html('Procesando');
									},
								success:  function (data) {
										$("#listafun").html(data);  // $("#cuenta").html(response);

									} 

						});
					}
	 }
 }

 /*
 */

 function VerUnidad()

 {
 
	var id_asigna_dis   = 	$('#id_asigna_dis').val();

	 var parametros = {
		 		'accion':  'unidades',
			    'id_asigna_dis' : id_asigna_dis
    };
	  
	var estado   = 	 $('#estado').val();


	if ( estado == 'autorizado') {
	}
	else 	 {
 
				if (id_asigna_dis)   {

						$.ajax({
								data:  parametros,
								url:   '../model/ajax_bom_lista.php',
								type:  'GET' ,
									beforeSend: function () { 
											$("#listafun").html('Procesando');
									},
								success:  function (data) {
										$("#listafun").html(data);  // $("#cuenta").html(response);

									} 

						});
					}
	 }
 }
 

  
/*
*/
 function modulo()

 {
 
	 var modulo1 =  'kbombero';

	 var parametros = {
			    'ViewModulo' : modulo1
    };
	  

	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);

				} 

	});
 }

//-----------------

 function FormView()

 {

    



	 $("#ViewForm").load('../controller/Controller-nom_distributivo_bom.php');

	 $("#cambiof").load('../controller/Controller-nom_cambio_bom.php');  

	 

 }

   /*
   visor
   */ 
 function VisorUnidad(id_asigna_dis)

 {
 
 
	 var parametros = {
		 		'accion':  'visor',
			    'id_asigna_dis' : id_asigna_dis
    };
	  
	if (id_asigna_dis)   {

			$.ajax({
					data:  parametros,
					url:   '../model/ajax_bom_lista.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#listafun").html('Procesando');
						},
					success:  function (data) {
							$("#listafun").html(data);  // $("#cuenta").html(response);

						} 

			});
		}

 }
 /*
 lista de bomberos 
 */ 
 function asigna(aacion,unidad)

 {
 
	var id_asigna_dis = $('#id_asigna_dis').val();
 

	$('#unidad').val(unidad);


	 var parametros = {
		 		'accion':  aacion,
			    'id_asigna_dis' : id_asigna_dis,
				'unidad' : unidad
    };
	  
	if (id_asigna_dis)   {

			$.ajax({
					data:  parametros,
					url:   '../model/ajax_bom_lista.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#listafuncionarios").html('Procesando');
						},
					success:  function (data) {
							$("#listafuncionarios").html(data);  // $("#cuenta").html(response);

						} 

			});
		}

 }

/*
*/
function verifica(aacion,id_asigna_bom,fila)

 {
 

	var estado   = 	 $('#estado').val();

	var unidad  = $('#unidad').val();


	if ( estado == 'autorizado') {
	}
	else 	 {


		if (aacion == 'del'){

			var parametros = {
				'accion':  aacion,
			   'id_asigna_bom' : id_asigna_bom 
   			};

			alertify.confirm("<p>Eliminar Distribuir personal...</p>", function (e) {

				if (e) {

								$.ajax({
									data:  parametros,
									url:   '../model/ajax_bom_lista.php',
									type:  'GET' ,
									success:  function (data) {
										$("#result").html(data);   
 										  
										asigna('seleccion',unidad);

										VerUnidadBuscar();

										} 

							});

				}

			}); 

		}
		else {
			 		
					$('#myModal').modal('show');
					$('#id_asigna_bom').val(id_asigna_bom);
					$('#responsable_a').val('N');
					$('#cambiar_a').val(unidad);
					$('#grupo_a').val('');

					var parametros = {
						'accion':  'actualiza',
					   'id_asigna_bom' : id_asigna_bom 
					   };

					   $.ajax({
						data:  parametros,
						url:   '../model/ajax_bom_lista.php',
						type:  'GET' ,
						success:  function (data) {
							$("#result").html(data);   
  
							} 

				});


		}
	
		}

 }
 /*
 */
 function  Cambiar_persona( ){

 
 
	 var id_asigna_dis   = 	 $('#id_asigna_dis').val();
     var id_asigna_bom   = 	 $('#id_asigna_bom').val();

	 var cambiar_a       = 	 $('#cambiar_a').val();
	 var responsable_a   = 	 $('#responsable_a').val();
	 var unidad          = 	 $('#unidad').val();
	 var grupo_a         = 	 $('#grupo_a').val();
	 var funcion_a       = 	 $('#funcion_a').val();
	 var estado   		 = 	 $('#estado').val();

	 var unidad_apoyo   = 	 $('#unidad_apoyo').val();
	 


	 var parametros = {
		 		'accion':  'cambio',
			    'id_asigna_dis' : id_asigna_dis,
				'id_asigna_bom' : id_asigna_bom,
				'cambiar_a'     : cambiar_a,
				'responsable_a' : responsable_a,
				'grupo_a':grupo_a,
				'funcion_a' : funcion_a,
				'unidad_apoyo': unidad_apoyo
    };

	
	if ( estado == 'autorizado') {
	}
	else 	 {

				if ( grupo_a ) {

					if ( funcion_a ) {

						alertify.confirm("<p>Distribuir personal...</p>", function (e) {

							if (e) {

											$.ajax({
												data:  parametros,
												url:   '../model/ajax_bom_lista.php',
												type:  'GET' ,
												success:  function (data) {
													$("#result").html(data);   
 													VerUnidad();
													asigna('seleccion',unidad);
													} 

										});

							}

						}); 
					}	
				}
			}
}
/*
imprimir
*/



function imprimir_informe(url) {
    
	var id_asigna_dis   = 	$('#id_asigna_dis').val();
	
	var ancho= 650;
	var alto = 550;

	 var posicion_x; 
	var posicion_y; 

	var enlace; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
   
	enlace = url+'?id='+id_asigna_dis  ;
   
	if ( id_asigna_dis) {
			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }
}