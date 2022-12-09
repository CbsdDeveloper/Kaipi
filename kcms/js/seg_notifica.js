var oTable;

var formulario = 'Controller-seg_notifica.php';
  
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
	    FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
   		
		BusquedaGrilla('','E');
 
	 
 		
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                
                    
					$("#action").val("add");
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO DOCUMENTO</b>');
					
				    LimpiarPantalla();
					 
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
function goToURL(accion,id) {
 
	
 
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-seg_notifica.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 
	$('#myModal').modal({
        show: 'true'
    }); 
	
	
	
    }
//-------------------------------------------------------------------------
function myelemento(nombre,codigo) {
    var x = document.getElementById("idusuario_asignado");
    var option = document.createElement("option");
    option.text = nombre;
    option.value = codigo;
    x.add(option, x[0]);
}
// ir a la opcion de editar
function LimpiarPantalla() {
  

	var fecha = fecha_hoy();
	
	﻿$("#id_seg_proceso").val("");
	$("#anio_perido").val("");
	
	$("#fecha_apertura").val(fecha);
 	$("#tipo_examen").val("");
	$("#id_departamento").val("");
	$("#nro_informe").val("");
	$("#tema_recomendacion").val("");
	$("#cumplimiento").val("");
	$("#estado").val("");
	$("#marco_legal").val("");
	$("#observacion").val("");
	
	$("#idusuario_asignado").val("");
	$("#documento_respaldo").val("");
	$("#documento_digital").val("");
	
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
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(cumplimiento,estado){        	 
 
	  
	    var parametros = {
				 'cumplimiento'  : cumplimiento,
				 'estado' : estado,
				 'pagina': 0
	   };
	    
	    $("#estado1").val(estado);
	    $("#cumplimiento1").val(cumplimiento);
	    
	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-seg_BandejaDoc.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
		 
		 $("#pag").val(0);
		 
 	
  }   
  //------------------------------------------------------------------------- 
  function PaginaGrilla(signo){        	 
 	  
	  
	   var estado       = $("#estado1").val();
	   var cumplimiento = $("#cumplimiento1").val();
	   
	   var acumula		= $("#pag").val();
	   
	   var pagina 		= parseInt(acumula) ;
	   
	   if (signo  > 0 ){  
		   pagina = pagina + 6 ;
	   }else { 
		   pagina = pagina - 6 ;
	   }
	   
	   var acumula		=parseInt(pagina) ;
	   
	   //------------------------------------------	   
	   $("#pag").val(acumula );
	   
	   if ( pagina < 0 ) { 
		   $("#pag").val(0);
	   }
	   //------------------------------------------ 
	    
	    var parametros = {
				 'cumplimiento'  : cumplimiento,
				 'estado' : estado,
				 'pagina': pagina
	   };
	    
	 
	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-seg_BandejaDoc.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
 	
  }    
//-----------------------------------------
 function accion(id,modo)
 {
   
 			$("#action").val(modo);
 			
 			$("#id_seg_proceso").val(id);          

 			//BusquedaGrilla(oTable );

 }
//-----------------------------------------
 function FiltraPersonal(valor)
 {
   
	 var parametros = {
			 'id_departamento'  : valor 
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-seg_listaUnidad.php",
		 type: "GET",
        success: function(response)
        {
            $('#idusuario_asignado').html(response);
        }
	 });

 } 
 
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/'+ formulario);
      

 }
//-----------------
 function urlOpcion(enlace)
 {
    
	 window.open( enlace  , '_blank');
 
      

 }
//-------------------------------
 function VerHistorial( id )
 {
   
	 var parametros = {
			 'id'  : id 
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-seg_historial.php",
		 type: "GET",
        success: function(response)
        {
            $('#BandejaHistorial').html(response);
        }
	 });

 } 
 
 
  