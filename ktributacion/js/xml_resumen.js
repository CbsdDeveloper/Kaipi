//-------------------------------------------------------------------------
$(document).ready(function(){
    
       var oTable = $('#jsontable').dataTable(); 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 		
        fecha_hoy();
	   
});  
//-----------------------------------------------------------------
function BusquedaVisor(){        
	  
	"use strict";
	  
    var mes =  $("#mesc").val();
    var anio = $("#anioc").val();
			
 		
    var parametros = {
					'mes' : mes ,
                    'anio' : anio 
 	 };
	  $.ajax({
					data:  parametros,
					url:   '../model/xml_resumen.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ResumenDatos").html('Procesando');
  					},
					success:  function (data) {
							 $("#ResumenDatos").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 	
 } 
//-------------------------------------------------------------
function genera_xml()
{

   var MES = document.getElementById("mesc").value; 
  
  var ANIO  = document.getElementById("anioc").value;
	
  alert('Generar XML' + MES + ' - ' + ANIO );

  enlace = '../model/xml_mes.php?MES=' + MES + '&ANIO=' + ANIO ;
										   
  var win = window.open(enlace, '_blank');
  
  win.focus();

 	 
}  
//-------------------
function  imprimir_comprobanteM(url){       
	  
    var posicion_x; 
    var posicion_y; 
    
    var ancho = 900;
    var alto = 520;
    
 
      var MES = document.getElementById("mesc").value; 
	  
	  var ANIO  = document.getElementById("anioc").value;
  
	  enlace = url + '?mes=' + MES + '&anio=' + ANIO ;
      
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
    
 }
//---- agrega retencion
function genera_devolucion()
	{
   
 	   var mes = document.getElementById("mesc").value; 
	  
	   var anio  = document.getElementById("anioc").value;
  
	  enlace = '../reportes/devolucion_compras.php?mes=' + mes+ '&anio=' + anio ;
  
      window.open(enlace,'#','width=950,height=520,left=30,top=20');
 	 
}
//-----------------
function genera_resumen_compras()
	{
   
 	   var mes = document.getElementById("mesc").value; 
	  
	   var anio  = document.getElementById("anioc").value;
  
	   enlace = '../reportes/detalle_compras_iva.php?mes=' + mes+ '&anio=' + anio ;
  
       window.open(enlace,'#','width=950,height=520,left=30,top=20');
 	 
}
//-------------- 
function generaExcel(url)
{

   var mes = document.getElementById("mesc").value; 
  
   var anio  = document.getElementById("anioc").value;

   enlace = url +'?mes=' + mes+ '&anio=' + anio ;

   var win = window.open(enlace, '_blank');
	
   win.focus();
	 
}

 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function genera_resumen()
{

  var MES   = document.getElementById("mesc").value; 
  var ANIO  = document.getElementById("anioc").value;

  enlace = '../controller/xml_talon.php?MES=' + MES + '&ANIO=' + ANIO ;


  window.open(enlace,'#','width=950,height=520,left=30,top=20');
	 
} 
 //---------------------------
 function fecha_hoy()
{
   
    var today = new Date();
    var mm = today.getMonth() + 1;  
    var yyyy = today.getFullYear();
     
    if(mm < 10){

        mm='0'+ mm;

    } 
 
    $("#anioc").val(yyyy);
    $("#mesc").val(mm);
  
  
            
} 
 
/*

*/
function modulo()
 {
 	 var modulo_menu =  'ktributacion';

 	 var parametros = {
			    'ViewModulo' : modulo_menu 
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
					 $("#ViewModulo").html(data);  
				     
				} 
	});
      

 }