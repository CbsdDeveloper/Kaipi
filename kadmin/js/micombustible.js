

$(document).ready(function(){

  	$("#NavMod").load('../view/View-HeaderMain.php');
	
 	$("#FormPie").load('../view/View-pie.php');

	 
	 var modulo =  'kadmin';
		 
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
					 $("#ViewModulo").html(data);   
				     
				} 
	}); 
	
	
      $("#viewform").load('../controller/Controller_micombustible.php');
	
	
	  $("#viewformComb").load('../controller/Controller_micombustible01.php');
	
	
	Busqueda('enviado');
 
 
});
//--------------
function Busqueda( estado){
	
		 $("#vestado").val( estado );  
	
	
	
						var parametros = {
											"estado" : estado 
									};
									 
    									$.ajax({
    										    type:  'GET' ,
    											data:  parametros,
    											url:   '../controller/Controller_micombustible00.php',
     											success:  function (response) {
      	 											
    													 $("#viewformResultado").html( response );  
     												 
     													 
    													 
    											} 
    									});
	 
 
} 
//------------
function goToURLdetalle( codigo){
	
	
	var parametros = {
											"codigo" : codigo 
									};
									 
    									$.ajax({
    										    type:  'GET' ,
    											data:  parametros,
    											url:   '../model/ajax_llama_combu.php',
    											dataType: "json",
     											success:  function (response) {
      	 											
    													 $("#id_combus").val( response.a );  
     													 $("#estado").val( response.b );  
     													 $("#ubicacion_salida").val( response.c ); 
     													 $("#u_km_inicio").val( response.d ); 
     													 $("#tipo_comb").val( response.e ); 
     													 $("#costo").val( response.f ); 
     													 $("#cantidad").val( response.g ); 
     													 $("#total_consumo").val( response.h ); 
     													 $("#medida").val( response.i ); 
     													 $("#iva").val( response.j ); 
     													 $("#total_iva").val( response.k ); 
     													  $("#cantidad_ca").val( response.l ); 
    											} 
    									});
	 
 
} 
//---------------
function habilita_campo(texto){
	
 

	if ( texto == 'GALON'){
		$("#cantidad_ca").val('0');
		
		$('#cantidad_ca' ).prop('readonly', true);

		 
 	}else{
		$("#cantidad_ca").val('1');
		
		$('#cantidad_ca'  ).prop('readonly', false);

    }
	
}
//----------------------------
function ActualizarDatos(){

 
 
 var id_combus 			=  $("#id_combus").val();  
 var ubicacion_salida 	=  $("#ubicacion_salida").val( ); 
 var u_km_inicio 	    =  $("#u_km_inicio").val( ); 
 var tipo_comb 			=  $("#tipo_comb").val( ); 
 var costo 				=  $("#costo").val( ); 
 var cantidad 		    =  $("#cantidad").val( ); 
  var cantidad_ca 		    =  $("#cantidad_ca").val( ); 
 
  var medida 		    =  $("#medida").val( ); 
    
 var estado =  $("#vestado").val(  );  
  
  
  var parametros = {
				 'id_combus'  : id_combus  ,
				 'ubicacion_salida' : ubicacion_salida,
				 'u_km_inicio' : u_km_inicio,
				 'tipo_comb' : tipo_comb,
				 'costo' : costo,
				 'cantidad' : cantidad,
				 'medida':medida,
				 'cantidad_ca':cantidad_ca
	  };
	  
	  if (  estado == 'enviado' ){
		
	   	     alertify.confirm("<p>AUTORIZAR LA ORDEN DE COMBUSTIBLE</p>", function (e) {
			  if (e) {
				 
	 
							 $.ajax({
										 data:  parametros,
										 url: "../model/ajax_actualiza_combu.php",
										 type: "POST",
								       success: function(response)
								       {
								          alert(response);
								          
								             var costo         = $("#costo").val();
											 var cantidad      = $("#cantidad").val();
 											 var total         =  parseFloat(costo).toFixed(4) *   parseFloat(cantidad).toFixed(2)
											 var total_consumo = parseFloat(total).toFixed(4) 
											 
											  $("#total_consumo").val(total);
											 
											 var iva =  (12/ 100);
											 
											 var monto_iva = total_consumo * iva;
											 
											 $("#iva").val(monto_iva);
											   
											 suma=parseFloat(monto_iva)+parseFloat(total_consumo);  
												      
											  var total_uni =  parseFloat(suma).toFixed(4) 
												  
											  $("#total_iva").val(total_uni);
											  
								       }
									 });
 			 						
 			 						
 			 							


 			 					 
			 	   } 
 					 
 			 }); 
	}	else	{
		alert('Nose puede actualizar en este estado autorizado...');
	} 
 
 
}

//-----------
function monto_combustible(tipo) {
	   
	 var parametros = {
				 'tipo'  : tipo  
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../../kgarantia/model/Model_monto_combustible.php",
			 type: "GET",
			 dataType: 'json',  
	       success: function(response)
	       {
	           $('#costo').val(response.a);
	       }
		 });
	 
		 
	}
//-----------
function actualiza() {
	   
	 
	 						 $.ajax({
 									   url: "../controller/Controller_micombustible01.php",
 								       success: function(data)
								       {
								          
								           $("#viewformComb").html(data);   
								       }
							 });
		 
	}	