$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
      
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 		
	    FormView();
	    	
 	    BusquedaGrilla();
 
 
 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	     LimpiarPantalla();
                    
			  	   $('#result').html('<b>AGREGAR NUEVO REGISTRO</b>');
			  	   
					$("#action").val("add");
					 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
//-------------------------------------------------------------------------
// ir a la opcion de editar
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
// ir a la opcion de editar
function LimpiarPantalla() {
	
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
//ir a la opcion de editar
function AgregarProceso() {
	
	LimpiarPantalla() ;
	
	$("#action").val("add");
 
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
    
    document.getElementById('fechatarea').value = today ;
    
    document.getElementById('fechafinal').value = today ;
    
    $("#tarea").val("");
	
    $("#tareaproducto").val("");
            
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

	  $.ajax({
 			url:   '../controller/Controller-proceso01.php',
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

	  $.ajax({
 			url:   '../controller/Controller-proceso02.php',
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
 
//----------------------
 function FormFiltro()
 {
  
//	 $("#ViewFiltro").load('../controller/Controller-co_parametros_filtro.php');
	 

 }

    
  