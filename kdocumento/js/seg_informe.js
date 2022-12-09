$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	 
	    FormView();
	    	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
		
		
		 $('#bcodigo').on('click',function(){
			  
			 BuscarArchivos_datos( );
	  			
		 });
		
  
		
 
 
});  

function modulo()
{
	 var modulo1 =  'kdocumento';
	 
	 var parametros = {
			    'ViewModulo' : modulo1 
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
  function BuscarArchivos( departamento ){        	 

	  
	  
	 var anio =  $("#panio").val( );         
	 var pmes =  $("#pmes").val( );   
	  
	  var parametros = {
			    'departamento' : departamento ,
			    'anio':anio,
			    'pmes' : pmes,
			    'accion' : 0
      };
	  
	  
	  $.ajax({
 			url:   '../controller/Controller-DocArchivo.php',
 			data:  parametros,
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#unidad_file").html('Procesando');
			},
			success:  function (data) {
					 $("#unidad_file").html(data);  // $("#cuenta").html(response);
				     
			} 
	}); 
 }   
 //---------
   function DetalleArchivo( idcaso ){        	 

 
	  var parametros = {
			    'idcaso' : idcaso 
      };
	  
	  
	  $.ajax({
 			url:   '../model/Model-caso__doc_arc.php',
 			data:  parametros,
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#visor_doc").html('Procesando');
			},
			success:  function (data) {
					 $("#visor_doc").html(data);  // $("#cuenta").html(response);
				     
			} 
	}); 
 }   
 //---------
  function fileExists(url) {
    if(url){
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status==200;
    } else {
        return false;
    }
}
 //---------
 function  formato_doc_visor(  enlace  )
 {
	
 
	    var 	posicion_x; 
	    var 	posicion_y; 
 	    var 	ancho = 1000;
	    var 	alto = 520;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
     if (fileExists(enlace)) {
 
			window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
    }

 
        
  }
//-----
  function BuscarArchivos_datos(   ){        	 

	  
	  
		 var anio   =  $("#panio").val( );     
		 var ccodigo =  $("#ccodigo").val( );         
		 
		 var casunto =  $("#ccedula").val( );  
		 
		 
		  
		  var parametros = {
				    'ccodigo' : ccodigo ,
				    'anio':anio,
				    'casunto' : casunto,
				    'accion' : 1
	      };
		  
		  
		  $.ajax({
	 			url:   '../controller/Controller-DocArchivo.php',
	 			data:  parametros,
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#unidad_file").html('Procesando');
				},
				success:  function (data) {
						 $("#unidad_file").html(data);   
						 
						 $("#ccodigo").val('' );    
						 $("#ccedula").val( '');     
					     
				} 
		}); 
	 }   
//------------------------------------------------------------------------- 
  function Visor( codigo,archivo ){        	 

	  
	  var url = '../../userfiles/files/' + archivo;
	  
      window.open(url, 'Download');

  
  } 
 
//-----------------
 function FormView()
 {
    
	 
	 $("#filtroVisor").load('../controller/Controller-seg_informe_filtro.php');
      

 }
 
 
    
  