$(function() {
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
 
});

//-------------------------------------------------------------------------
$(document).ready(function(){
     
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		$("#FormPie").load('../view/View-Pie.php');
		
		modulo();
 		
		FormView();
		 
 
		$('#load').on('click',function(){
			 
			busqueda_Objetivos_tarea();
			
		 
			 
		 });
		
 
 
});  
 
  
//-------------------------------------------------------------------------
function poa_resumen ( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
 
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
    };
	 
	  
	 $.ajax({
		    type:  'GET' ,
			data:  parametros,
			 url:   '../model/ajax_resumen_poa.php',
			dataType: "json",
			success:  function (response) {

				     $("#techo").html( response.a );  
					 $("#inicial").html( response.b );  
 					 $("#ejecutado").html( response.c );  
 					 $("#ejecutadop").html( response.d );  
					 
				     $("#nobjetivos").html( response.e );  
					 $("#nindicadores").html( response.f );  
 					 $("#ntareas").html( response.g );  
 					 $("#ntareasp").html( response.h );  
			} 
	});
 
	
} 
//-------------------------------------------------------------------------
//-----------------
function FormView()
{
   
	 
	 $("#ViewFiltro").load('../controller/Controller-poa_filtro.php');
	 
	 
	 $("#ViewForm").load('../controller/Controller-actividad.php');
	 
 
 	
 	 
}

 
//-------------------
//---------------------
function modulo ( )
 {
	
	var modulo_sistema =  'kplanificacion';
	 
	 var parametros = {
			    'ViewModulo' : modulo_sistema 
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
	
 }

//---------------------
function busqueda_Objetivos_tarea ( )
{
 
    var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
    var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
 };
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_MATRIZ_lista.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#UnidadObjetivoArticula").html('Procesando');
			},
		success:  function (data) {
				 $("#UnidadObjetivoArticula").html(data);   
			     
			} 
    });

	
}
//-------------------
 