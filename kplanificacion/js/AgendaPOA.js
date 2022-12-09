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
 
 
});  
 
//--------------------------------------------------------------------------
 
//-------------------------------------------------------------------------
function Detalle_Tarea (idtarea )
{
	
 	 
	 var parametros = {
			    'id' : idtarea  
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-DetalleTareaVisor.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#tarea_detalle").html('Procesando');
				},
			success:  function (data) {
					 $("#tarea_detalle").html(data);  
				     
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

 
 