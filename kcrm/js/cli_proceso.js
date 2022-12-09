$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		modulo();
 		
	    FormView();
	    	
 	    BusquedaGrilla();
 
 		$("#FormPie").load('../view/View-pie.php');
 
 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	     LimpiarPantalla();
                    
			  		$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
			  	   
					$("#action").val("add");
					 
			  }
			 }); 
			}
			
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			
			return false;
			
  }

//-------------------------------------------------------------------------
// ir a la opcion de editar -----------------------------------------------
//----------------------------------
function goToURL(id) {

	var accion = 'editar';
	
	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-cli_proceso.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 
    }
 
 
//-------------------------------------------------------------------------
// Limpia variables
//-----------------------------------------------------------------------
function LimpiarPantalla() {
	
	$("#fecha").val(fecha_hoy());
	
	$("#idproceso").val(0);
	$("#nombre").val("");
	$("#objetivo").val("");
	$("#estado").val("");
 	$("#archivo").val("NO");
	$("#tipo").val("");
	$("#responsable").val("");
	$("#alcance").val("");
	$("#entrada").val("");
	$("#salida").val("");
	$("#indicador").val("");
        			   
    }
   
//-------------------------------------------------------------------------
// Mensaje para agregar registro
function AgregarProceso() {
	
	LimpiarPantalla() ;
	
 
	
	$("#action").val("add");
 
 } 
//----------------------------
function limpiaGrafico(){
	
	 var idproceso = $("#idproceso").val();
	 
	 var parametros = {
			    'idproceso' : idproceso 
     };
	 
	 
	 if (idproceso > 0 ){
		 
		 alert('Actualizar Grafico del proceso Nro. ' + idproceso);
		 
		  $.ajax({
				data:  parametros,
	 			url:   '../model/Model-limpiaGraf.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#result").html('Procesando');
				},
				success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
				} 
	 	}); 
	 }
	 
}
//----
function AnulaGrafico(){
	
	 var idproceso = $("#idproceso").val();
	 var observa   = 'Proceso se revierte para revision de informacion';
 
	 
	 if (idproceso > 0 ){
		 
		  var observa =  $("#observa").val();
		   
			 var parametros = {
			       'idproceso': idproceso ,
			       'observa' : observa,
			       'accion' : 2
					};
			
			  
			  alertify.confirm("<p>Desea revertir proceso!!!..." +idproceso+ " <br><br></p>", function (e) {
					  if (e) {
					  	 
						  	 	$.ajax({
									data:  parametros,
									url:   '../model/Model-publicacion.php',
									type:  'GET' ,
									async: true,
									cache: false,
									beforeSend: function () { 
												$("#result").html('Procesando');
										},
									success:  function (data) {
											 $("#result").html(data);  
										     
										} 
							}); 
		                 
		               
					  }
					 }); 
		  
		  
	 }
	 
}
 //---------------------------
 function fecha_hoy()
{
   
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    
    if(dd < 10){
        dd='0'+ dd
    } 
    if(mm < 10){
        mm='0'+ mm
    } 
  
    
    var today = yyyy + '-' + mm + '-' + dd;
    
return today;
            
} 
 
//----------------------
 function accion(id,modo)
 {
   
			$("#action").val(modo);
			
			$("#idproceso").val(id);          
 
			BusquedaGrilla( );

 }
  //------------------------------------------------------------------------- 
  function BusquedaGrilla( ){        	 

	var ambito =  $("#ctipo").val();     
	  
	  var parametros = {
			    'ambito' : ambito 
  };
	  
	  $.ajax({
 			url:   '../controller/Controller-proceso01.php',
 			data:  parametros,
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
					$("#listaproceso").html('Procesando');
			},
			success:  function (data) {
					 $("#listaproceso").html(data);  // $("#cuenta").html(response);
				     
			} 
	}); 
 }   
//------------------------------------------------------------------------- 
   function BusquedaPublica( ){        	 

		var ambito =  $("#ctipo").val();     
		  
		  var parametros = {
				    'ambito' : ambito 
	  };
		  
		  
	  $.ajax({
 			url:   '../controller/Controller-proceso02.php',
 			data:  parametros,
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
					$("#listaproceso").html('Procesando');
			},
			success:  function (data) {
					 $("#listaproceso").html(data);  // $("#cuenta").html(response);
				     
			} 
	}); 
 }  
 
 
 function modulo()
 {
 	 var moduloOpcion =  'kcrm';
 	 
 	 var parametros = {
			    'ViewModulo' : moduloOpcion 
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
      

 }
 
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-cli_proceso.php');
      

 }
 
    
  