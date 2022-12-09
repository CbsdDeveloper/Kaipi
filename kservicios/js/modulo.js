$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kservicios';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
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
	
	
	//---
	$("#FormEmpresa").load('../model/Model-modulo.php');
	
	$("#NavMod").load('../view/View-HeaderInicio.php');
	
	
	
	$("#ViewUser").load('../controller/Controller-ren_estado_user.php');
	
	
	$("#FormPie").load('../view/View-pie.php');
	 
 
			$('#load').on('click',function(){
			
				DetalleMov(1)
			
			});
	
			$('#load1').on('click',function(){
			
				DetalleMov(2)
			
			});

	    	$('#load2').on('click',function(){
		 
				$("#ViewFormDetalle").html('');
			
			});


	
	
	 
});
//------------------------
function Refarticulo(id_emision)
{
 
 
 
 
	var parametros = {
			"id_emision" : id_emision  
	};
	
	$.ajax({
 			 url:   '../controller/Controller-ren_detalle_dato.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticulo").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});

}
//------------------------------
function DetalleMov(tipo)
{
 
 
	  var id_par_ciu =    $('#id_par_ciu').val(); 
	
	  if ( id_par_ciu ){
		  
	    var parametros = {
	            'id' : id_par_ciu,  
	            'tipo' : tipo
	    };
	    
		$.ajax({
	 			url:   '../controller/Controller-ren_caja_estado.php',
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormDetalle").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormDetalle").html(data);   
					     
					} 
		});
	     
	  }
}
function fecha_hoy(tipo)
{
   
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    
 
    if (tipo == 1){
    	return yyyy;
    }else{
    	return mm;
    }
    
    
    

            
} 
//---------------------------
function BusquedaGerencial( )
{

	  var fanio   = fecha_hoy(1);
	  
	  var cmes =    $('#cmes').val(); 
	  
	  var parametros = {
			    'cmes' : cmes ,
			    'fanio' : fanio ,
			    'tipo' : 'G',
      } ;

	  
	$.ajax({
			data:  parametros,
			url:   '../model/Model_reportes_grupo.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#FormMensual").html('Procesando');
				},
			success:  function (data) {
					 $("#FormMensual").html(data);   
				} 
	});

} 

//------------------
function variableEmpresa(){

	 var ruc = $("#ruc_registro").val(); 
 
	 var parametros = {
			    'ruc' : ruc 
    };
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/SeleccionEmpresa.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#RucRegistro").html('Procesando');
				},
			success:  function (data) {
					 $("#RucRegistro").html(data);  // $("#cuenta").html(response);
				     
				} 
	});  
 
}; 
//------------------
 
//------------------
function llamarsolicitud(url){
 	 
	document.location = url;

 
}; 

