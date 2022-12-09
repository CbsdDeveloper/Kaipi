$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kcms';
		 
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
	
	$('#ParametroContable').load('../view/parametroBienes1.svg');
 
	
	
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#NavMod").load('../view/View-HeaderInicio.php');
	 
    $("#ViewGrupo").load('../model/Model-ViewGrupo.php');
    
    $("#ViewSede").load('../model/Model-ViewSede.php');
	
    
	
 	$("#FormPie").load('../view/View-pie.php');
	
 
	
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
 