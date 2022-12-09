$(function(){

    $(document).bind("contextmenu",function(e){

        return false;

    });

    window.addEventListener("keypress", function(event){

        if (event.keyCode == 13){

            event.preventDefault();

        }

    }, false);

});

//-------------------------------------------------------------------------
$(document).ready(function(){
		 

		$("#MHeader").load('../view/View-HeaderModel.php');

		modulo();

		FormView()

		$("#FormPie").load('../view/View-pie.php');

		$('#load').on('click',function(){

	 				goToURL( );

	    });

 
		 var j = jQuery.noConflict();

			j("#loadPrint").click(function(){
					var mode = 'iframe'; //popup

					var close = mode == "popup";

					var options = { mode : mode, popClose : close};

					j("#ViewResumenRol").printArea( options );

			});


			
});  

//-----------------------------------------------------------------
//-------------------------------------------------------------------------

// ir a la opcion de editar

function PonerDatos( ) {

     var periodo = 	$('#q_periodo').val();

     var parametros = {

                     'periodo' : periodo

 	  };

	  $.ajax({

					data:  parametros,
					url:   '../model/Model-nom_horas_view.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewProceso").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewProceso").html(data);  // $("#cuenta").html(response);

  					} 

			}); 
}
//------------------------------------------------------------------------- 

  function goToURL( ){   

	  
	     var id_rol1 			= 	$('#id_rol1').val();
	     var id_config1     	= 	$('#id_config1').val();
	     var id_departamento1   = 	$('#unidad').val();
	     var regimen    		= 	$('#regimen').val();
	     var programa  			= 	$('#programa').val();

	     var parametros = {
	                     'id_rol' 		  : id_rol1, 
	                     'id_config' 	  : id_config1, 
	                     'id_departamento': id_departamento1,
	                     'regimen' 		  : regimen, 
	                     'programa'   	  : programa,
	                     'accion'		  : 'add'
	      };


	     
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_rol_grilla.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewProceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewProceso").html(data);  
								 
								 goToURLResumen( );
								 
	  					} 

				}); 
		  
 
}   
//--------------------------------------------
  function BuscaPrograma( codigo,tipo) {
	   
		
		if ( tipo == 1 ) {
			
			var regimen   = $("#regimen").val();
			var programa  = codigo;
		}
	 
		if ( tipo == 0 ) {
			
			var programa = '';
			var regimen  = codigo
		}

		
		 var parametros = {
					 'regimen'  : regimen ,
					 'programa' : programa,
					 'tipo' :tipo
		  };
			 
			
		   $.ajax({
				 data:  parametros,
				 url: "../model/ajax_busca_prog.php",
				 type: "GET",
		       success: function(response)
		       {
	 
		    	   if ( tipo == 0 ) {
		    		   $('#programa').html(response);
		    	   }else{
		    		   $('#unidad').html(response);
		    	   }
	 	 	        
 		       }
			 });
	 
			 
		}
//----------------
 function goToURLResumen( ){   

 
	     var id_rol1 			= 	$('#id_rol1').val();
	     var id_departamento1   = 	$('#unidad').val();
	     var regimen    		= 	$('#regimen').val();
	     var programa  			= 	$('#programa').val();

	     var parametros = {
	                     'id_rol' 		  : id_rol1, 
	                     'id_departamento': id_departamento1,
	                     'regimen' 		  : regimen, 
	                     'accion'		  : 'visor'
	      };


		  $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_roles_resumen.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewResumen").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewResumen").html(data); 

	  					} 

				}); 

} 
//-------------
function actualiza_dato(tipo, monto,id_rol1 ){   
	
	 var parametros = {
		                     'id_rol' 			  : id_rol1,
		                     'tipo' 			  : tipo,
							 'monto'			  : monto
	 	      };

			  $.ajax({
							data:  parametros,
							url:   '../model/ajax_actualiza_rol_personal.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#ViewMensaje").html('Procesando');
		  					},
							success:  function (data) {
									 $("#ViewMensaje").html(data);  // $("#cuenta").html(response);

		  					} 

					}); 
			
		 
} 
//---------------ver_parametro_rol
function ver_parametro_rol(id_rol1,id ){   
	
	 var parametros = {
		                     'id_rol' 			  : id_rol1,
		                     'idprov' 			  : id
	 	      };

			  $.ajax({
							data:  parametros,
							url:   '../model/Model-nom_fichar_actualiza.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#ViewFormRoldatos").html('Procesando');
		  					},
							success:  function (data) {
									 $("#ViewFormRoldatos").html(data);  // $("#cuenta").html(response);

		  					} 

					}); 
					
} 	
//---------
function go_actualiza1(id ){   

	 var id_rol1 			= 	$('#id_rol1').val();

	 

		     var parametros = {
		                     'id_rol' 			  : id_rol1,
		                     'idprov' 			  : id
	 	      };

			  $.ajax({
							data:  parametros,
							url:   '../model/Model-nom_fichar_rol.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#ViewFormRolPersona").html('Procesando');
		  					},
							success:  function (data) {
									 $("#ViewFormRolPersona").html(data);  // $("#cuenta").html(response);

		  					} 

					}); 

		 

}	
//--------------
function go_actualiza(accion,id ){   

	 var id_rol1 			= 	$('#id_rol1').val();

	if (accion == 'visor') { 

		     var parametros = {
		                     'id_rol' 			  : id_rol1,
		                     'idprov' 			  : id
	 	      };

			  $.ajax({
							data:  parametros,
							url:   '../model/Model-nom_fichar_rol.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#ViewFormRolPersona").html('Procesando');
		  					},
							success:  function (data) {
									 $("#ViewFormRolPersona").html(data);  // $("#cuenta").html(response);

		  					} 

					}); 

		 $('#myModal').modal('show');  

}	

 
	if (accion == 'pdf') { 

		  var url = '../../reportes/view_rol_nomina.php'

	       var posicion_x; 
	       var posicion_y; 
	       var enlace = url + '?codigo='+id +'&id_rol=' + id_rol1;

	       var ancho = 1000;

	       var alto = 520;

	       posicion_x=(screen.width/2)-(ancho/2); 
	       posicion_y=(screen.height/2)-(alto/2); 

	       window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

	}

	//--------------------
	if (accion == 'eliminar') { 
		
		 alertify.confirm("Desea Eliminar el registro de la nomina? " + id, function (e) {

			  if (e) {
 				 
				  var parametros1 = {
		                     'id_rol' 			  : id_rol1,
		                     'idprov' 			  : id
	 	      };

			  $.ajax({
							data:  parametros1,
							url:   '../model/Model_nom_rol_del.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#ViewSave").html('Procesando');
		  					},
							success:  function (data) {
									 $("#ViewSave").html(data);   
									 
									 goToURL();

		  					} 

					}); 

			  }

			 }); 
		  
		}
	

}

//--------------

function goToURLEmailLote() {   

	 alert('Notificar por medio electronica');
		 
		 var i = 0 ;
		 
		 $('#jsontable tr').each(function() { 
			    
			 
			   var customerId = $(this).find("td").eq(1).html();  
			
			   if (  i >   0  ) { 
				   
				 envia_correo(customerId);
				        

			
				   
			   }
			   
			   i = i + 1;
			  
	     }); 

}
//---------

function envia_correo(id){   

	  var id_rol1 			= 	$('#id_rol1').val();
	

	   var parametros = {
                  'id' 	  : id, 
                 'id_rol1'   : id_rol1 
 	   	};
 

	   $.ajax({

				data:  parametros,

				url:   '../model/EnvioPersonalCorreo.php',

				type:  'GET' ,

				success:  function (data) {

						 $("#ViewSave").html(data);  // $("#cuenta").html(response);

					     

				} 

		}); 

	

}
//-------
function go_actualiza_dato(id,valor ){   

	  

	var accion = 'edit';

	

	   var parametros = {

                'id' 	  : id, 

                'valor'   : valor,

                'accion'  : accion

	   	};



	   $.ajax({

				data:  parametros,

				url:   '../model/Model_nom_descuento_save.php',

				type:  'GET' ,

				success:  function (data) {

						 $("#ViewSave").html(data);  // $("#cuenta").html(response);

					     

				} 

		}); 

	

}

///---------------- 
function AnulaCertificacion(  ) {
	
    var id_rol1 			= 	$('#id_rol1').val();
    var regimen    			= 	$('#regimen').val();
    var certificado    			= 	$('#certificado').val();
    
  
 
    var parametros = {
                    'id_rol' 		  : id_rol1, 
                    'regimen' 		  : regimen, 
                    'certificado'   : certificado,
                    'accion'          : 'anula'
     };

    
    if ( certificado  > 0 ) {
   
    	
	 	  alertify.confirm("Desea anular certificacion presupuestaria " + id_rol1, function (e) {
	
			  if (e) {
				  
					 
					$.ajax({
						    type:  'GET' ,
							data:  parametros,
							url:   '../model/ajax_busca_tramite.php',
							dataType: "json",
							success:  function (response) {

				 					 $("#certificado").val( response.a );  
									 
				 					 alert(response.b);
							} 
					});

				   
	
				  }
	
			 }); 
 	  
    }
}
//------------------------------------------------------------------------- 
function EmiteCertificacion(  ) {
	
    var id_rol1 			= 	$('#id_rol1').val();
    var regimen    			= 	$('#regimen').val();
    var programa  			= 	$('#programa').val();
    
    var sesion_asigna  			= 	$('#sesion_asigna').val();

    
    
    var parametros = {
                    'id_rol' 		  : id_rol1, 
                    'regimen' 		  : regimen, 
                    'programa'   	  : programa,
                    'accion'		  : 'certificacion',
                    'sesion_asigna'   : sesion_asigna
     };

    
    if (sesion_asigna == '-') {
    	
    	alert('Seleccione el usuario para el envio de la solicitud');
    	
    }
    else 	 {
    	
	 	  alertify.confirm("Desea generar certificacion presupuestaria " + id_rol1, function (e) {
	
			  if (e) {
				  
				  $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_enlace_pres.php',
						type:  'GET' ,
						beforeSend: function () { 
								$("#VisorEnlacePresupuesto").html('Procesando');
						},
						success:  function (data) {
								 $("#VisorEnlacePresupuesto").html(data);  
								 codigo_certificado(id_rol1,regimen);
						} 
	
				}); 
			  		 
	
				  }
	
			 }); 
 	  
    }
}
//---------------------
function codigo_certificado( id_rol1,regimen ){   


    var parametros = {
                    'id_rol' 		  : id_rol1, 
                    'regimen' 		  : regimen, 
                    'accion'          : 'visor'
     };

 	 
	$.ajax({
		    type:  'GET' ,
			data:  parametros,
			url:   '../model/ajax_busca_tramite.php',
			dataType: "json",
			success:  function (response) {

 					 $("#certificado").val( response.a );  
					 
 					 alert(response.b);
 					  
			} 
	});

} 

//---------------------------
function ImprimirActa( id_certifica ) {

	
	 
	 
	 
	if ( id_certifica > 0 )    {
		
		var url = '../../kpresupuesto/reportes/certificacion_nomina'
		
	}else  {
		
		var url = '../../kpresupuesto/reportes/certificacion_nomina'
			
		id_certifica = $("#certificado").val( );  
	}	

		
 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+id_certifica    ;
		    
		    var ancho = 1000;
		    
		    var alto = 520;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	
	
	
	}
//-----------------
function irCompromiso( id_certifica ) {

	if ( id_certifica > 0 )   {
		
	   var url = '../../kpresupuesto/view/compromiso_rol'
 
				  
			 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url   ;
		    
		    var ancho = 1224;
		    
		    var alto = 560;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	
	   }
	}
//-----------------
function ResumenRolFinal(  )
 {

	var id_rol1 			= 	$('#id_rol1').val();
	var regimen 			= 	$('#regimen').val();
	var programa 			= 	$('#programa').val();
	var depa 				= 	$('#depa').val();
	var url_dato 			=   '';
 	
	if (depa== '-') {
		url_dato =  '../model/Model-nom_rol_lista.php';
	}else {
		url_dato =  '../model/Model-nom_rol_lista_ambito.php';
	}
	
   var parametros = {
                     'id_rol' 			  : id_rol1, 
                     'regimen'			  :regimen,
	                 'programa'   : programa,
	                 'depa' : depa
      };

	  $.ajax({
					data:  parametros,
					url:   url_dato,
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewResumenRol").html('Procesando');
  					},
					success:  function (data) {
						     $("#ViewResumenRol").html(data);  // $("#cuenta").html(response);
  					} 
			}); 
} 
//-----------------
function ResumenRolFinalPago(  )
 {

	var id_rol1 			= 	$('#id_rol1').val();
	var regimen 			= 	$('#regimen').val();
  
    var parametros = {
                     'id_rol' 			  : id_rol1, 
                     'regimen'			  :regimen
      };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_rol_lista_pago.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewResumenRol").html('Procesando');
  					},
					success:  function (data) {
						     $("#ViewResumenRol").html(data);  // $("#cuenta").html(response);
  					} 
			}); 
} 
//----------------------------------
function ResumenRolFinalBancos(  )
 {

	var id_rol1 			= 	$('#id_rol1').val();
	var regimen 			= 	$('#regimen').val();
  
    var parametros = {
                     'id_rol' 			  : id_rol1, 
                     'regimen'			  :regimen
      };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_rol_lista_banco.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewResumenRol").html('Procesando');
  					},
					success:  function (data) {
						     $("#ViewResumenRol").html(data);  // $("#cuenta").html(response);
  					} 
			}); 
} 
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

	 $("#ViewFiltro").load('../controller/Controller-nom_rol_filtro.php');

	 

}