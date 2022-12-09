$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	 
	listaCartelera();
 
	$("#FormEmpresa").load('../model/Model-modulo.php');
 	
	$("#NavMod").load('../view/View-HeaderInicioAgenda.php');
	
 	$("#FormPie").load('../view/View-pie.php');
	
	
});


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

}
//----------------------------------------
function EnviarCorreo(){

	 var detalle = $("#correo_detalle").val(); 
	 var fecha   = $("#correo_fecha").val();  
	 
 
	 var parametros = {
			    'detalle' : detalle ,
			    'fecha': fecha
   };
	  
 
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/EnvioEmailAgenda.php',
			type:  'POST' ,
				beforeSend: function () { 
						$("#enviado").html('Procesando');
				},
			success:  function (data) {
					 $("#enviado").html(data);  // $("#cuenta").html(response);
				     
				} 
	});  
 
}
//-----------------------------
function listaEmail(tipo){
	
	var parametros = {
			 'tipo'  : tipo  
    };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-agenda_user.php",
		 type: "GET",
      success: function(response)
      {
          $('#usuarioc').html(response);
      }
	 });
}
//-------------------
function EliminaChat(idchat){
	
	var parametros = {
			 'idchat'  : idchat  
    };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-cartelera_empresa.php",
		 type: "GET",
      success: function(response)
      {
          $('#Cartelera').html(response);
          
          
      }
	 });
}


//--------------------------------------
//-----------------------------
function listaCartelera( ){
	
 
	 $.ajax({
 		 url: "../model/Model-cartelera_empresa.php",
		 type: "GET",
      success: function(response)
      {
          $('#Cartelera').html(response);
      }
	 });
}

//----------------------------------------

function _fecha( ){
	

var yyyy = today.getFullYear();

						if(dd < 10){
							dd='0'+ dd
						} 
						if(mm < 10){
							mm='0'+ mm
						} 

						var fecha = yyyy + '-' + mm + '-' + dd;
	
	return fecha;

	}