$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kinventario';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
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
	
	//---
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#NavMod").load('../view/View-HeaderInicio.php');
	
	$("#div_gasto").load('../view/parametroInventario.svg');
	
  	$("#FormPie").load('../view/View-pie.php');
	
 	
	$.ajax({
 		 url:   '../model/ajax_tramitePresupuesto.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#div_presupuesto").html('Procesando');
			},
		success:  function (data) {
				     $("#div_presupuesto").html(data);  // $("#cuenta").html(response);
			     
			} 
	}); 
 	
	$.ajax({
		 url:   '../model/ajax_tramite_egreso.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#div_egresos").html('Procesando');
			},
		success:  function (data) {
				     $("#div_egresos").html(data);  // $("#cuenta").html(response);
			     
			} 
	}); 
	
	$.ajax({
		 url:   '../model/ajax_tramite_ingreso.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#div_ingresos").html('Procesando');
			},
		success:  function (data) {
				     $("#div_ingresos").html(data);  // $("#cuenta").html(response);
			     
			} 
	}); 
	
	$.ajax({
		url:   '../model/ajax_articulos_egreso.php',
	   type:  'GET' ,
		   beforeSend: function () { 
				   $("#div_articulos").html('Procesando');
		   },
	   success:  function (data) {
					$("#div_articulos").html(data);  // $("#cuenta").html(response);
				
		   } 
   }); 
   
	 
	
 //	$("#Notas_actividades").load('../view/View-notaActividad.php');
 	
 //	$("#listaActividad").load('../model/Model-lista-mi-actividad.php');
 	
	
	 
 	
	
});

//----------------------
function variableEmpresa(){

	 var ruc = $("#ruc_registro").val(); 
 
	 var parametros = {
			    'ruc' : ruc 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/moduloCliente.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#RucRegistro").html('Procesando');
				},
			success:  function (data) {
					 $("#RucRegistro").html(data);  // $("#cuenta").html(response);
				     
				} 
	});  
 
}; 
 
//----------------------
function agregar_dato(){

 $("#action_modal_nota").val('si'); 
 
 $("#actividad").val("");
 
 
 $("#ambito").val("");
 $("#detalle").val("");
 $("#adjunto").val("");
  	 
 
}; 
 