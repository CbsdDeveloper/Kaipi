$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){


 	$.ajax({
   		url: "../model/Model_busca_periodo.php",
   		type: "GET",
   		success: function(response)
   		{
   				$('#ganio').html(response);
   			 
   		}
   	  });


	   $("#perfilUser").load('../controller/Controller-perfil_usuarios.php');
	 
       $("#kaipiMain").load('../view/View-moduloPanel.php');
        
       $("#perfilUserWeb").load('../controller/Controller-perfil_usuariosWeb.php');
       

	   $.ajax({
				type:  'GET' ,
				url:   '../model/Model_VisorPerfil.php',
				dataType: "json",
				success:  function (response) {

 
						if ( response.a == '2' )	{
						
							$("#idMod").load('../view/perfil_fin.html');
			
						}else {
							if ( response.a == '9' )	{

								$("#idMod").load('../view/perfil_caja.html');

							}else 	{

								if ( response.a == '3' )	{
									$("#idMod").load('../view/perfil_usuario.html');
								}	else {
									$("#idMod").load('../view/yuraMatriz.svg');
								}
 
							}
						}

					} 
      });

 
 
});
 
//-------------

function MiPerfil( ){

	$("#idMod").load('../view/perfil_usuario.html');

}

function AccesoFinanciero( ){

	$("#idMod").load('../view/perfil_fin.html');

}



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
	 
function imagenfoto(urlimagen)
{
  
	 $("#ImagenUsuario").attr("src",urlimagen);
 

}
 
//---------------
function GuardaEmail( )
{
  
    var smtp1   = $("#smtp1").val();
 	var puerto1 = $("#puerto1").val();
 	var acceso1 = $("#acceso1").val();
 	var email1  = $("#email1").val();
    
 	alert('Dato Actualizado ' + email1);
 	
	var parametros = {
					'smtp1' : smtp1 ,
                    'puerto1' : puerto1 ,
                    'acceso1': acceso1,
                    'email1': email1
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/EnvioUserEmail.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 						    	$("#ResultadoUserWeb").html('Procesando');
  					},
					success:  function (data) {
 
							    $("#ResultadoUserWeb").html(data);
 							
  					} 
			}); 
 

}
 
//---------------
//---------------
function SeleccionEmpresa( identificacion)
{
 
 	
 
	var parametros = {
					'identificacion' : identificacion 
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-modulo_panel.php',
					type:  'GET' ,
					cache: false,
				 
					success:  function (data) {
 
						alert('Dato Actualizado ' + data); 
 							
  					} 
			}); 
 
	  location.reload();
}
 
function openFile(url,ancho,alto) {
    
	var posicion_x; 
  var posicion_y; 
  var enlace; 
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
 
  
  enlace = url  ;

  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}	
