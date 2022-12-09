$(function(){
 
    $(document).bind("contextmenu",function(e){
        return false;
    });
 	
});

//-------------------------------------------------------------------------


$(document).ready(function(){
         
	     
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
    	FormArbolCuentas(); 
    	
    	 $('#baprobacion').on('click',function(){
    		   
    		  publicacion_proceso();
    			
  		});
    	 
    	 $('#brevertir').on('click',function(){
  		   
   		  revertir_proceso();
   			
 		}); 
  
    	 $('#guardaproce').on('click',function(){
    		   
      		  procedimiento_proceso();
      			
    		}); 
    	  
    	 
 		
    	  $("a[rel='pop-up']").click(function () {
    		  
    			var id = $("#codigoproceso").val();
    			
    	      	var caracteristicas = "height=500,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
    	      	
    	      	nueva=window.open(this.href + '?id='+id, 'Popup', caracteristicas);
    	      	
    	      	return false;
    	  });      	
 
});  
//-----------------------------------------------------------------
function FormArbolCuentas()
{

   $("#ViewFormArbol").load('../controller/Controller-proceso_parametro_publica' );

}
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(idproceso) {
	
	
	$("#codigoproceso").val(idproceso);
	 
	$("#idproceso").val(idproceso);
 	
  	
	var parametros = {
                     'id' : idproceso
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../controller/Controller-auto_01.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#DibujoFlujo").html('Procesando');
  					},
					success:  function (data) {
							 $("#DibujoFlujo").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
	   
	  
	  
	  $("#observa").val('');
	  
 	 tareaproceso();
	  
 	 procedimiento_ver(idproceso);
 	
 	 nombreproceso();
 
    }
//-----------------------
function nombreproceso()
{
	 
		var id = $("#codigoproceso").val( );
	 

		var parametros = {
	                     'id' : id 
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-auto_proceso01.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#Nombreproceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#Nombreproceso").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
 
} 

function goToURL1(accion,idproceso) {
	
	  
	var parametros = {
			'accion' : accion ,
            'id' : idproceso
	};
	
	$("#action").val(accion);
	
	$("#idproceso_var").val(idproceso);
	
	
$.ajax({
			data:  parametros,
			url:   '../model/Model-variables.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#guardarAux").html('Procesando');
				},
			success:  function (data) {
					 $("#guardarAux").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 

 	$('#myModalAux').modal({show: true});
 
    }

//---------------------------------------------
//--------------- crea formulario................................................
function wktarea(idtarea,idproceso) {
 	
	
	   var bandera = $("#bandera3").val();
	  
	 
	   
		var parametrosp = {
	             'id' : idtarea ,
	             'idproceso': idproceso
		};
	 
	   $.ajax({
				data:  parametrosp,
				url:   '../controller/Controller-wtarea.php',
				type:  'GET' ,
				async: true,
				cache: false,
				beforeSend: function () { 
							$("#ViewTarea").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewTarea").html(data);  // $("#cuenta").html(response);
					     
					} 
		}); 
		
	if (bandera == 'S'){
 
 			VerDocumentoTarea( idproceso, idtarea  );
			
			VerRequisitoTarea( idproceso, idtarea  );
		
			VerResponsableTarea( idproceso, idtarea );
			
		 	$('#myModaltarea').modal({show: true});
		 
			$("#bandera3").val('S');
	}

	if (bandera == 'N'){
		$("#bandera3").val('S');
	}


 }
//-------------------------------------------------------------------------  
 function modulo()
 {
 	 var modulo1 =  'kcrm';
 	 var parametros = {
			    'ViewModulo' : modulo1 
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
 // datos
 function tareaproceso()
 {
	 
		var idproceso = $("#codigoproceso").val( );
  
		var parametros = {
	                     'id' : idproceso
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-procesotarea.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#listaTareas").html('Procesando');
	  					},
						success:  function (data) {
								 $("#listaTareas").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
		
			

 } 
 //----------------------------------------------
 function informacionproceso()
 {
	 
		var id = $("#codigoproceso").val( );
	 
 
		var parametros = {
	                     'id' : id 
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-procesoinformacion.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#InformaProceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#InformaProceso").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
 
 } 
//-----------------
 function FormView()
 {
    	 $("#ViewForm").load('../controller/Controller-cli_proceso.php');
 
 }
 //-----------------
 function  Visor( idtarea)
 {
    
	   var bandera   = $("#bandera2").val();
 	   var idproceso = 	$("#codigoproceso").val();
		
		var parametros = {
		           'id' : idtarea ,
		           'idproceso': idproceso
			};
			
 
		$.ajax({
					data:  parametros,
					url:   '../controller/Controller-auto_02.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormularioTarea").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewFormularioTarea").html(data);  // $("#cuenta").html(response);
						     
						} 
			}); 
           //--------------------------------
		if (bandera == 'S'){
			 
			$('#VentanaProceso').modal({show: true});
		 
			$("#bandera2").val('S');
	     }

		 if (bandera == 'N'){
				$("#bandera2").val('S');
		 }
			
 
 }
//--------------------
//----------------- Visor de tarea proceso respomsable
function VerResponsableTarea( idproceso, idtarea  ){    
	 
	 
	 var parametrost = {
            'idtarea' : idtarea ,
            'idproceso': idproceso ,
            'tipo': 'V' 
	};
	 
   $.ajax({
			data:  parametrost,
			url:   '../model/Model-visortarea_user.php',
			type:  'GET' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#DetalleUnidadTarea").html('Procesando');
				},
			success:  function (data) {
					    $("#DetalleUnidadTarea").html(data);   
 				} 
	}); 

}
//------------
function VerDocumentoTarea( idproceso, idtarea  ){    
	 
	 
	 var parametrosd = {
        'idtarea' : idtarea ,
        'idproceso': idproceso ,
        'tipo': 'V' 
	};
	 
$.ajax({
			data:  parametrosd,
			url:   '../model/Model-visortarea_docu.php',
			type:  'GET' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#DetalleDocumentos").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleDocumentos").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 

}
///-----------------------------------
//----------------- Visor de tarea proceso requisito
function VerRequisitoTarea( idproceso, idtarea  ){    
	 
	 
	 var parametrosr = {
         'idtarea' : idtarea ,
         'idproceso': idproceso ,
         'tipo': 'V' 
	};
	 
$.ajax({
			data:  parametrosr,
			url:   '../model/Model-visortarea_requi.php',
			type:  'GET' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#DetalleRequisitos").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleRequisitos").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 

}
//--------------
function procedimiento_ver( id  ){  
	
 
     
    var parametros = {
		       'idproceso': id ,
 		       'accion' : 2
			};
    
    $.ajax({
			data:  parametros,
			url:   '../model/Model-procedimiento.php',
			type:  'POST' ,
			async: true,
			cache: false,
 			success:  function (data) {
					    $("#procedimiento").val(data);  
				     
				} 
	}); 
    
}
//----------------- 
function procedimiento_proceso(   ){  
	
	 var id 			=   $("#codigoproceso").val( );
     var procedimiento  =  $("#procedimiento").val();
     
     var parametros = {
		       'idproceso': id ,
		       'procedimiento' : procedimiento,
		       'accion' : 1
			};
     
     $.ajax({
			data:  parametros,
			url:   '../model/Model-procedimiento.php',
			type:  'POST' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#GuardaProcedimiento").html('Procesando');
				},
			success:  function (data) {
					    $("#GuardaProcedimiento").html(data);  
				     
				} 
	}); 
     
}
//----------------- Visor de tarea proceso requisito
function publicacion_proceso(   ){    
	 
	     var id =   $("#codigoproceso").val( );
	        
	     var observa =  $("#observa").val();
	    
		 var parametros = {
 		       'idproceso': id ,
 		       'observa' : observa,
 		      'accion' : 1
  			};
		
		  
		  alertify.confirm("<p>Desea publicar proceso!!!..." +id+ " <br><br></p>", function (e) {
				  if (e) {
 				  	 
					  	 	$.ajax({
								data:  parametros,
								url:   '../model/Model-publicacion.php',
								type:  'GET' ,
								async: true,
								cache: false,
								beforeSend: function () { 
											$("#publicadoProceso").html('Procesando');
									},
								success:  function (data) {
										 $("#publicadoProceso").html(data);  
									     
									} 
						}); 
	                  
	                
				  }
				 }); 
 
}
///-----------------
function revertir_proceso(   ){    
	 
    var id =   $("#codigoproceso").val( );
       
    var observa =  $("#observa").val();
   
	 var parametros = {
	       'idproceso': id ,
	       'observa' : observa,
	       'accion' : 2
			};
	
	  
	  alertify.confirm("<p>Desea revertir proceso!!!..." +id+ " <br><br></p>", function (e) {
			  if (e) {
			  	 
				  	 	$.ajax({
							data:  parametros,
							url:   '../model/Model-publicacion.php',
							type:  'GET' ,
							async: true,
							cache: false,
							beforeSend: function () { 
										$("#publicadoProceso").html('Procesando');
								},
							success:  function (data) {
									 $("#publicadoProceso").html(data);  
								     
								} 
					}); 
                 
               
			  }
			 }); 

}
//-----------------
function activar(tipo_publica)
{
	 
	if (tipo_publica == 'N'){
		
		  $('#observa').prop('disabled', false);
		  $('#baprobacion').prop('disabled', false);
	
	}else{
		 
	 	  $('#observa').prop('disabled', 'disabled');
		  $('#baprobacion').prop('disabled', 'disabled');
	
	 }

}
//-------------- guarda responsable por tarea del proceso / requisitos
function GuardaDocumento( tipo, idproceso, idtarea,idproceso_docu ,objeto ){    

	 
	 
 	  
	 var che1 =  '#doperador'     + idproceso_docu ;
	 var che2 =  '#dobservador'   + idproceso_docu;
 
	 var perfil_documento  		=  '';
	 var accionAdd			    = 'add';
	 
	 if ( tipo == 1){
		 if (objeto.checked == true){
			    perfil_documento ='operador';
			    $(che1).prop('checked', true);
			    $(che2).prop('checked', false);
 	 	    } else {
	 	    	requisito_perfil ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
	 }else{
		
		 if (objeto.checked == true){
			    perfil_documento ='observador';
			    $(che1).prop('checked', false);
			    $(che2).prop('checked', true);
	 	    } else {
	 	    	 perfil_documento ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
	 }
	 
 
	 var parametros = {
         'idtarea'  : idtarea ,
         'idproceso': idproceso,
         'idproceso_docu' : idproceso_docu,
         'perfil_documento' : perfil_documento ,
         'accion': accionAdd
	};
	 
	 $.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_doc.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleDocumentos").html('Procesando');
				},
			success:  function (data) {
					
					 $("#DetalleDocumentos").html(data);  
				    
 					 
				} 
	}); 
 
}

//-------------- guarda responsable por tarea del proceso / requisitos
function GuardaRequisitos( tipo, idproceso, idtarea,idproceso_requi ,objeto ){    

 
 	 
	 var accionAdd			    = 'add';
	  
	 var che1 =  '#operador'     + idproceso_requi ;
	 var che2 =  '#observador'   + idproceso_requi;
	 
 
	 
	 if ( tipo == 1){
 		 if (objeto.checked == true){
 			   requisito_perfil ='operador';
 			    $(che1).prop('checked', true);
 			    $(che2).prop('checked', false);
  	 	    } else {
	 	    	requisito_perfil ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
 	 }else{
		
		 if (objeto.checked == true){
			    requisito_perfil ='observador';
			    $(che1).prop('checked', false);
			    $(che2).prop('checked', true);
	 	    } else {
	 	    	requisito_perfil ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
	 }
		 
	 
 	 
				 var parametros = {
			           'idtarea'  : idtarea ,
			           'idproceso': idproceso,
			           'idproceso_requi' : idproceso_requi,
			           'requisito_perfil' : requisito_perfil ,
			           'accion': accionAdd
				};
			 
			  $.ajax({
						data:  parametros,
						url:   '../model/Model-addtarea_requisito.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
							
									$("#DetalleRequisitos").html('Procesando');
							},
						success:  function (data) {
							
								 $("#DetalleRequisitos").html(data);  // $("#cuenta").html(response);
								  
							 
			 	  
							} 
				}); 
				 
 
}
function GuardaResponsable( idproceso, idtarea  ){    
	 
	 var ambito_proceso = $('#ambito_proceso').val();
	 var unidad  		= $('#unidad').val();
	 var reasignar  	= $('#reasignar').val();
	 var perfil  		= $('#perfil').val();
	 var accionAdd		= 'add';
	  
	 var parametros = {
            'idtarea' : idtarea ,
            'idproceso': idproceso,
            'ambito_proceso' : ambito_proceso,
            'unidad' : unidad,
            'reasignar' : reasignar,
            'perfil' : perfil,
            'accion': accionAdd
	};
	 
   $.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_user.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleUnidadTarea").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleUnidadTarea").html(data);  // $("#cuenta").html(response);
				     
					  alert('Dato actualizado correctamete...');
					    
					  VerResponsableTarea( idproceso, idtarea  );
				} 
	}); 
}
