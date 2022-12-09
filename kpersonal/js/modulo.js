$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kpersonal';
		 
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
	
	$("#div_gasto").load('../view/parametroPersonal.svg');
	
	
 	$("#FormPie").load('../view/View-pie.php');
	
 	
 	$("#FormPie").load('../view/View-pie.php');
	
 	  $.ajax({
			url: "../model/Model_busca_periodo.php",
			type: "GET",
			success: function(response)
			{
					$('#ganio').html(response);
				 
			}
		});
 
 	
	
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
 
function PeriodoAnio( ){
	 
	
	
	 var anio = $("#ganio").val(); 

	 var parametros = {
			    'anio' : anio 
    };

	 

	 $.ajax({
		    data:  parametros,
			url: "../model/ajax_periodo_seleccion.php",
			type: "GET",
			success: function(response)
			{
				 alert(response);
				 
			}
		});
	
	 window.location.reload();
	 

}