$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kbombero';
		 
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
 		} 
    });
 
	 
	 
	$('#ParametroContable').load('../model/Model-ViewEmergencia.php');
 	
 
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#NavMod").load('../view/View-HeaderInicio.php');
	 

    $("#ViewGrupo").load('../model/Model-ViewGrupo.php');
    
    $("#ViewSede").load('../model/Model-ViewSede.php');

	$("#ViewSedeHAS").load('../model/Model-ViewSedeHAS.php');
	
    
	
 	$("#FormPie").load('../view/View-pie.php');
	
 
	
});

//----------------------
function variableEmpresa(){

	 var ruc = $("#ruc_registro").val(); 
 
	 var parametros = {
			    'ruc' : ruc 
    };
	  
	  /*
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
 */
}; 

//----------------------
function ListaEmergencias(lista){

 
	var parametros = {
			   'lista' : lista 
   };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_detalle_emergencia.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#detallef").html('Procesando');
			   },
		   success:  function (data) {
					$("#detallef").html(data);  // $("#cuenta").html(response);
					
			   } 
   });  

}; 

 
 