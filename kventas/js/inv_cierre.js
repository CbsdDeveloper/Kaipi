 var oTable;
 
 var oTableArticulo;
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
    
    window.addEventListener("keypress", function(event){
        if (event.keyCode == 13){
            event.preventDefault();
        }
    }, false);
    
    
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	 
		
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        oTable = $('#jsontable').dataTable(); 
        
        
		BusquedaGrilla(oTable);
		
        $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
       $('#loadFac').on('click',function(){
	 		 
        	goToURLElectronicoLote();
            
  		}); 
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
  
					 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
//-----------------
function accion(id, action)
{

	$('#action').val(action);
	
	$('#id_movimiento').val(id); 
	  
	  

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion1,id) {
 
 
	
     var parametros = {
					'accion' : accion1 ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_cierre.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 
    }
 //---------------
function goToURLElectronico(accion1,id) {
	 
	 
	 var posicion_x; 
     var posicion_y; 

     
     posicion_x=(screen.width/2)-(230/2); 
     posicion_y=(screen.height/2)-(150/2); 
     
       
     var enlace = '../view/envio_fac?id='+ id;  

     window.open(enlace, '#','width='+230+',height='+150+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
     
     
   }
//----------------------------------------
function goToURLElectronicoLote( ) {
	 
	
	 var posicion_x; 
     var posicion_y; 

     
     posicion_x=(screen.width/2)-(230/2); 
     posicion_y=(screen.height/2)-(150/2); 
     

   ///----------------
     var  cajero      = $("#cajero").val();
     var  fecha1      = $("#fecha1").val();
     
     
     var enlace = '../view/envio_fac_lote?cajero='+ cajero + '&fecha1=' + fecha1;  

     window.open(enlace, '#','width='+230+',height='+150+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
     
  
	///----------------
 
   }

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
	var fecha = fecha_hoy();
	
	$("#id_movimiento").val("");
	
	$("#fecha").val(fecha);
 	$("#comprobante").val("");
	$("#idprov").val("");
	$("#razon").val("");
	$("#idproducto").val("");
	$("#idbarra").val("");
	$("#articulo").val("");
 
	$("#efectivo").val(0);
 
	$("#action").val("add");
 
	$("#estado").val("digitado");
	
	
	 

	$("#result").html("<b>Agregar Nueva Solicitud</b>");
	
	
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
  function BusquedaGrilla(oTable){        
 
   
			var user = $(this).attr('id');
            
            var  estado		= $("#estado1").val();
            var  cajero      = $("#cajero").val();
            var  fecha1      = $("#fecha1").val();
            var  cierre     = $("#cierre1").val();
   
         
            var parametros = {
					'estado' : estado , 
                    'cajero' : cajero  ,
                    'fecha1' : fecha1  ,
                    'cierre' : cierre
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_cierre.php',
				dataType: 'json',
				success: function(s){
				//console.log(s); 
				        	oTable.fnClearTable();
				    	if(s ){  		
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
                                s[i][4],
                                s[i][5],
                                s[i][6],
                                s[i][7],
                                s[i][8],
                                s[i][9],
 								'<button title ="Anular Factura" class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][10] +')"><i class="glyphicon glyphicon-remove"></i></button>'  +
 								'&nbsp;<button title ="Enviar Factura Electrónica" class="btn btn-xs" onClick="javascript:goToURLElectronico('+"'electronica'"+','+ s[i][10] +')"><i class="glyphicon glyphicon-globe"></i></button>'
							]);										
						} // End For
			    	}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
			
			VentasResumen();
			
			VentasResumenDet(); 
			
			VentaPagoFacturacion();
			
			$("#fecha").val(fecha1);
			
		   
	
 }   
 
 function imagenfoto(urlimagen)
{
  
	 
    var path_imagen =  '../'+ urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
         var id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  

//----------------------------------------------------

function open_gasto(url,ovar,ancho,alto) {
    var posicion_x; 
    var posicion_y; 
    var enlace; 
 

   			
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    enlace = url;
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

}	

function modulo()
{
 

	 var moduloOpcion =  'kinventario';
		 
	 var parametros = {
			    'ViewModulo' : moduloOpcion 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
			type:  'GET' ,
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
   
 	 $("#ViewForm").load('../controller/Controller-inv_cierre.php');

 	 
}  
//----------------------
function FormFiltro()
{
	  	 $("#ViewFiltro").load('../controller/Controller-inv_cierre_filtro.php');
 
     

}
//-------------------------------------------------------------
function DetalleMov(id_movimiento,accion1)
{
 
    var parametros = {
            'id' : id_movimiento,  
            'accion': accion1
    };
    
	$.ajax({
 			url:   '../controller/Controller-inv_FacDet.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#DivMovimiento").html('Procesando');
				},
			success:  function (data) {
					 $("#DivMovimiento").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-------------------------
//-------------------------------------------------------- 
function VentasResumenDet(){
	
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
	
	 
		var parametros = {
                 "fecha": fecha,
                "cajero": cajero
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-resumenventasDet.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivDetalleMovimiento").html('Procesando');
				},
				success:  function (data) {
						 $("#DivDetalleMovimiento").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
 
  return true;
}
function VentasResumen( ) {
	 
	
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
	
	 
		var parametros = {
                 "fecha": fecha,
                "cajero": cajero
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-resumenventas.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivMovimiento").html('Procesando');
				},
				success:  function (data) {
						 $("#DivMovimiento").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
			
		 
}	
//-----------------
function VentaPagoFacturacion( )
{
	
 
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
	
	 
		var parametros = {
                 "fecha": fecha,
                "cajero": cajero
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-resumenpago.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivDetallePago").html('Procesando');
				},
				success:  function (data) {
						 $("#DivDetallePago").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 

}
//------------------ aprobacion
function aprobacion(  ){

	 
  var id 	  = $('#id_movimiento').val();
  var novedad = $('#novedad').val();	
  var fecha   = $('#fecha').val();	
 
 
  
  var mensaje =  confirm("¿Desea aprobar la transacción?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"id" : id   ,
	 			"novedad" : novedad,
	 			"fecha"   : fecha,
	 			"accion" : 'aprobacion'
		};
		
	 
			
				$.ajax({
			 			 url:   '../model/Model-inv_cierre.php',
			 			data:  parametros,
						type:  'GET' ,
							beforeSend: function () { 
									$("#result").html('Procesando');
							},
						success:  function (data) {
								 $("#result").html(data);  // $("#cuenta").html(response);
							     
							} 
				});
 
	 
  }
 
 
}
//-------------------
function impresion(url){        
	
	var variable    = $('#id_movimiento').val();
   
    var posicion_x; 
    var posicion_y; 
    var enlace = url + variable
    var ancho = 1000;
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------------
function url_comprobante(url){        
	
	var variable    = $('#id_movimiento').val();
	
	
 	
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '&codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------------
function url_cierre(url){        
	
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
 	
 
  var posicion_x; 
  var posicion_y; 
  
  var enlace = url +   'tipo=52&fecha='+fecha+ '&cajero='+ cajero;
  
  var ancho = 1000;
  
  var alto = 520;
  
  posicion_x=(screen.width/2)-(ancho/2); 
  
  posicion_y=(screen.height/2)-(alto/2); 
  
  window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

}
