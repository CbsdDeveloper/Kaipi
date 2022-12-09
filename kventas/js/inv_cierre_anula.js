"use strict";

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
	
       $('#loadFaca').on('click',function(){
	 		 
       	goToURLElectronicoLoteAutoriza();
           
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


alertify.confirm("Anular Factura ( Registro " +id + ')' , function (e) {
	  if (e) {
		 
	 
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-inv_cierre.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#result").html('Procesando');
				},
				success:  function (data) {
					
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
						 BusquedaGrilla(oTable)
				} 
		}); 

	  }
	  
	  
	 }); 	  	 

	
 }
 
 
//-------------------------------
function goToURLElectronicoLotexml( id ) {
	
	 var parametros = {
			    'id' : id 
 };
	  
	  
					 	$.ajax({
					 			data:  parametros,
					 			 url:   '../model/genera_xml_factura.php',
					 			type:  'GET' ,
					  			success:  function (data) {
					  				
					  				$("#data").html(data); 
 					  				
					 			 } ,
					 				complete : function(){
	                                     
					 					firma_autoriza_electronica_lote(id);
	                   
	                            } 
					 	});
		 
 

}
//----------------------
function goToURLElectronicoLote( ) {
	 
	
 	     var  fecha1      = $("#fecha1").val();
     
		 var parametros = {
				    'fecha1' : fecha1 
	     };

		 alert('Generando Informacion para comprobantes electronicos');
		 
		 var i = 0 ;
		 
		 $('#jsontable tr').each(function() { 
			    
			 
			   var customerId = $(this).find("td").eq(0).html();  
			
			   if (  i >   0  ) { 
				   
				   goToURLElectronicoLotexml( customerId ) ;
				   
				   $("#FacturaContador").html(i); 
				   
			   }
			   i = i + 1;
			  
	     }); 
		 
	 
 
   }
//-------------------- 

function goToURLElectronicoLoteAutoriza( ) {
	 
	
     var  fecha1      = $("#fecha1").val();

	 var parametros = {
			    'fecha1' : fecha1 
    };

	 alert('Generando Informacion para comprobantes electronicos');
	 
	 var i = 0 ;
	 
	 $('#jsontable tr').each(function() { 
		    
		 
		   var customerId = $(this).find("td").eq(0).html();  
		
		   if (  i >   0  ) { 
			   
			   firma_electronica( customerId ) ;
			   
			   $("#FacturaContador").html(i); 
			   
		   }
		   i = i + 1;
		  
    }); 
	 
	 $("#FacturaFirma").html('Proceso Finalizado ... revisar la informacion ' + i); 
	 
	 $("#data").html('Proceso Finalizado ... generar por cada 10 registros'   + i); 
	 $("#FacturaElectronica").html('Proceso Finalizado espere 10 segundos para actualizar'  ); 
	 $("#FacturaContador").html('Proceso Finalizado ... presione el icono de buscar'  ); 
	 
 
      
	 

}
//--------------------------
function firma(fecha1) {
 
    //---------------- 
	 var parametrosf = {
			    'fecha1' : fecha1 
    };

    //------------------------------- xml 
	 $.ajax({
			data:  parametrosf,
			 url:   '../../facturae/lote_firma_factura.php',
			type:  'GET' ,
			success:  function (data) {
				 
				   $("#data").html(data); 
				
				 
				} 
	});
	
}
//--------------------------
function goToURLElectronicoEnvio(accion1,id) {
	 
	 var parametros = {
			    'id' : id 
   };


 $.ajax({
		data:  parametros,
		 url:   '../model/EnvioEmailFacturaId.php',
		type:  'GET' ,
		success:  function (response) {
			 
			   $("#FacturaElectronica").html(response); 
			
				alert('Enviado');
				
			} 
});


}


function goToURLElectronico(accion1,id) {
	 
 
 	 var parametros = {
 			    'id' : id 
    };
 	  
 	 
     if ( id > 0 ) {
 	 
				 	$.ajax({
				 			data:  parametros,
				 			 url:   '../model/genera_xml_factura.php',
				 			type:  'GET' ,
				  			success:  function (data) {
				  				$("#FacturaElectronica").html(data); 
				 				     
				  				firma_autoriza_electronica(id);
				  				
				 				} 
				 	});
			 	 	
 	 		 
     } 

}
//-----------------------
function firma_autoriza_electronica( id  ) {
	
	 var parametrosi = {
			    'id' : id 
 };
	 
	  $.ajax({
			data:  parametrosi,
			url:   '../../facturae/autoriza_factura_firma.php',
			type:  'GET' ,
			success:  function (data) {
			 
				$("#FacturaFirma").html(data); 
				    
				firma_electronica( id );
				 
			} 
	});
	  
}
//---------------------
//-----------------------
function firma_autoriza_electronica_lote ( id  ) {
	
	 var parametrosi = {
			    'id' : id 
 };
	 
	  $.ajax({
			data:  parametrosi,
			url:   '../../facturae/autoriza_factura_firma.php',
			type:  'GET' ,
			success:  function (data) {
			 
				$("#FacturaFirma").html(data); 
 			 
				 
			} 
	});
	  
}
//-----------------------
function firma_electronica(  id ) {
	  
 
    
    var parametrosf = {
			    'id' : id 
   };
		
   $.ajax({
				data:  parametrosf,
				url:   '../model/externo.php',
				type:  'GET' ,
				success:  function (data) {
					
					$("#FacturaFirma").html(data); 
					     
				} 
			 
		});  


}
//------------------------- 
function secuencia_anulada( ) {
	
 
	 var  fecha		       = $("#fecha").val();
     var  comprobante      = $("#comprobante").val();
     var  novedad     	   = $("#novedad").val();
     
     
     
	  var parametros = {
			 'fecha' 	   : fecha ,
             'comprobante' : comprobante ,
             'accion' 	   : 'anulaa',
             'novedad'	   : novedad
      };

		
		alertify.confirm("Anular Secuencia Factura Emitida ( Registro " +comprobante + ')' , function (e) {
		 if (e) {
			 
		
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_cierre.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
						
							 $("#result").html(data);  
						     
							 alert('Comprobante generado');
							 
							 BusquedaGrilla(oTable)
					} 
			}); 
		
		 }
		 
		 
		}); 	  	 

	
}
//-----------------------
function goToURLElectronicoCorreo(accion1,id) {
	 
	 var parametros = {
			    'id' : id 
   };


 $.ajax({
		data:  parametros,
		 url:   '../model/EnvioEmailFacturaId.php',
		type:  'GET' ,
		success:  function (response) {
			 
			   $("#FacturaElectronica").html(response); 
			
				alert('Enviado');
				
			} 
});


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
	
	
	 

	$("#result").html("<b>Revision de Documentos</b>");
	
	
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
 								'<button title ="Anular Factura" class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'
  							]);										
						} // End For
			    	}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
			
 
			$("#fecha").val(fecha1);
			
		 	$("#result").html("<b>Revision de Documentos</b>");
	
 }   
 
//-------------------------------------------------------------------------
 
//----------------------------------------------------

function open_gasto(url,ovar,ancho,alto) {
    var posicion_x; 
    var posicion_y; 
    var enlace; 
    var fecha    	  = $('#fecha1').val();
    
   			
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    enlace = url + '?fecha='+fecha;
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

}	

function modulo()
{
 

	 var moduloOpcion =  'kventas';
		 
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
   
 	 $("#ViewForm").load('../controller/Controller-inv_cierre_anu.php');

  	 
 
 	
}  
//----------------------
function FormFiltro()
{
	  	 $("#ViewFiltro").load('../controller/Controller-inv_cierre_filtro.php');
 
     

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
