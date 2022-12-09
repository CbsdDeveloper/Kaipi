$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kactivos';
		 
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
	
	$.ajax({
	    type:  'GET' ,
 		url:   '../model/_estados_resumen.php',
		dataType: "json",
			success:  function (response) {
 				 $("#nvence").html( response.a );  
 				 $("#nutil").html( response.b );  
 				 $("#nmalo").html( response.c );  
				  $("#novedades_baja").html( response.d );   
				  $("#por_asignar").html( response.e );   
				  
 		} 
    });
 
	 
	 
	$('#ParametroContable').load('../view/parametroBienes.svg');
 
	
	
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
 