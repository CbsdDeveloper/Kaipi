$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

	
	 var modulo =  'kventas';
		 
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
	
 
	  var cmes   = fecha_hoy(0);
	  
	  $('#cmes').val(cmes); 
	  
	  BusquedaGerencial( );
 	
	 $("#FormPie").load('../view/View-pie.php');
	 
 
	
 
	 
});
//------------------------------
function fecha_hoy(tipo)
{
   
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    
 
    if (tipo == 1){
    	return yyyy;
    }else{
		
		  if(mm < 10){
			  mm='0'+ mm;
		  } 
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

	  /*
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
*/
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

