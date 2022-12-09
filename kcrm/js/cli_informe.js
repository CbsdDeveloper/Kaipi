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
 
});  
//-----------------------------------------------------------------
function FormArbolCuentas()
{

   $("#ViewFormArbol").load('../controller/Controller-proceso_visor' );

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
						     
							 goToURLTarea(idproceso);
							 
							 goToURLTiempo(idproceso) ;
  					} 
			}); 
	   
 
	  
 	 
    }
 //-------------------------
function goToURLTarea(idproceso) {
 
	var parametros = {
                     'id' : idproceso
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../controller/Controller-auto_04.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormTareaUs").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewFormTareaUs").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 
 	 
    }
//-------------------------
function goToURLTiempo(idproceso) {
 
	var parametros = {
                     'id' : idproceso
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../controller/Controller-auto_05.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormTiempo").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewFormTiempo").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 
 	 
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
					url:   '../controller/Controller-auto_03.php',
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
 