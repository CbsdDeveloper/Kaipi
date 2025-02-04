"use strict";

var oTable;
 
var oTableArticulo;
   
var oTableNota;

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
        
        oTableNota = $('#jsontableNota').dataTable(); 
        
        
		BusquedaGrilla(oTable);
		
        $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
        
        $('#loadNota').on('click',function(){
	 		 
            BusquedaGrillaNota(oTableNota);
            
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
//-------------------------

function genera_nota_credito( ) {
	 
	 
	var id_movimiento1  = $("#id_movimiento1").val();
	var comprobante1    = $("#comprobante1").val();
	var fecha_factura   = $("#fecha_factura").val();
	var secuencial1     = $("#secuencial1").val();
	var estab1   		= $("#estab1").val();
	var ptoemi1  	    = $("#ptoemi1").val();
	var fechaemisiondocsustento = $("#fechaemisiondocsustento").val();
	var coddocmodificado 		= $("#coddocmodificado").val();
	var numdocmodificado 	    = $("#numdocmodificado").val();
    var idcliente  = $("#idcliente").val();
    var id_diario  = $("#id_diario").val();
    
 
    var parametros = {
					'accion' : 'add' ,
                    'id'     : id_movimiento1,
                    'comprobante1'     : comprobante1,
                    'fecha_factura'     : fecha_factura,
                    'secuencial1'     : secuencial1,
                    'estab1'     : estab1,
                    'ptoemi1'     : ptoemi1,
                    'fechaemisiondocsustento'     : fechaemisiondocsustento,
                    'coddocmodificado'     : coddocmodificado,
                    'numdocmodificado'     : numdocmodificado,
                    'idcliente' : idcliente,
                    'id_diario' : id_diario
	  };
    

		
		  alertify.confirm("<p>Desea Generar la Nota de Credito " + id_movimiento1 + "<br></p>", function (e) {
		  if (e) {
		     
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-nota_credito.php',
					type:  'POST' ,
					success:  function (data) {
							 $("#secuencial1").val(data);  // $("#cuenta").html(response);
						     
					} 
			  }); 
			  
				 
		  }
		 }); 
 
 

   }
//------------------------- NOTA DE CREDITO
function goToURLNotaCredito( ) {
	
	  
	var posicion_x; 
    var posicion_y; 

    var id 	 = $('#id_movimiento1').val();
    
     
	 var parametros = {
			    'id' : id 
     };
	 
	 	  
	 
   if ( id > 0 ) {
	 
				 	$.ajax({
				 			data:  parametros,
				 			 url:   '../model/genera_xml_notac.php',
				 			type:  'GET' ,
				  			success:  function (data) {
				  				
 				  			    	$("#FacturaElectronicaNc").html(data); 
 				  				
 				  					firma_nota(id) 
				 				} 
				 	});
				      
 				 
			 	 
   }


}

//----------------------
function goToURLNota(accion1,id) {
	 
	  var parametros = {
				'accion' : accion1 ,
                'id' : id 
	  };
	  
	  $.ajax({
				data:  parametros,
				url:   '../model/Model-inv_cierre_nota.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#resultadoNota").html('Procesando');
				},
				success:  function (data) {
						 $("#resultadoNota").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
	
	 
	 $('#mytabs a[href="#tab3"]').tab('show');
    
    
  }
//---------------------------------------- 
function goToURLNotaConta( ) {
	
	
	var id 				 = $('#id_movimiento1').val();
	var secuencial1 	 = $('#secuencial1').val();
	var cab_autorizacion = $('#cab_autorizacion').val();
	
	var fechac = $('#fechaemisiondocsustento').val();
	
	if (cab_autorizacion){
		 alertify.confirm("Desea Contabilizar la nota de credito", function (e) {
			  if (e) {
				 
				  var parametros = {
	 		                'id' : id ,
	 		                'fechac' : fechac,
	 		                'secuencial1' :secuencial1
				  };
				  
				  $.ajax({
							data:  parametros,
							url:   '../model/Model-inv_nota_conta.php',
							type:  'GET' ,
							beforeSend: function () { 
									$("#resultadoNota").html('Procesando');
							},
							success:  function (data) {
									 $("#resultadoNota").html(data);  // $("#cuenta").html(response);
								     
							} 
					}); 
	
					 
			  }
			 }); 
	  }
  
}
//-----------------------
function goToURLNotaCreditoRide( ) {
	
	  //------------------ impresion ---------------jsontableNota
    var posicion_x; 
    var posicion_y; 
    var enlace; 
    var ancho = 720; 
    var alto = 550; 
  

    var id 	 = $('#id_movimiento1').val();

    if ( id > 0 ) {
    
		      var url = '../../facturae/notac_electronica.php';
		     			
		      posicion_x=(screen.width/2)-(ancho/2); 
		      
		      posicion_y=(screen.height/2)-(alto/2); 
		      
		      enlace = url + '?id='+ id;
		      
		      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	  
    }
}
//------------
function goToURLNotaImpresion( id ) {
	
	  //------------------ impresion ---------------jsontableNota
  var posicion_x; 
  var posicion_y; 
  var enlace; 
  var ancho = 720; 
  var alto = 550; 


 
  if ( id > 0 ) {
  
		      var url = '../../facturae/notac_electronica.php';
		     			
		      posicion_x=(screen.width/2)-(ancho/2); 
		      
		      posicion_y=(screen.height/2)-(alto/2); 
		      
		      enlace = url + '?id='+ id;
		      
		      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	  
  }
}
// lote factura electronica
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
//-------------------------------
//crea xml 
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
 					 			 } 
			 });
		 

		  /*,complete : function(){
				firma_autoriza_electronica_lote(id);
           } */

}
//-------------------
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
//-------------
function firma_nota(id) {
	 
    //---------------- 
	 var parametrosf = {
			    'id' : id 
    };
	var parametrosi = {
			    'id' : id 
    };
	 
  	//	
	
	$.ajax({
		data:  parametrosi,
		url:   '../../facturae/autoriza_notac.php',
		type:  'GET' ,
		success:  function (data) {
			 
			      $("#FacturaElectronicaNc").html(data); 
			      alert('Factura Emitida');
			 
			} 
 });
	
	
	/*$.ajax({
			data:  parametrosi,
			 url:   '../../facturae/autoriza_firma_nota.php',
			type:  'GET' ,
			success:  function (data) {
				 
				      $("#data").html(data); 
				   
					   $.ajax({
							data:  parametrosf,
					    	url:   '../model/externo_notac.php',
							type:  'GET' ,
							success:  function (data) {
								
								$("#FacturaElectronicaNc").html(data); 
								
										alert('Factura Emitida');
								} 
					}); 
				 
				} 
	});
	*/
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
			 	 	
 	 			    
  				  	//------------------------------------------------------------
			/*	 	
 	           var parametrosf = {
						    'id' : id 
			    };
					
			 	$.ajax({
							data:  parametrosf,
							 url:   '../../facturae/autoriza_factura.php',
							type:  'GET' ,
							success:  function (data) {
								$("#FacturaElectronica").html(data); 
								     
								} 
					});
					
						$("#FacturaElectronica").html(data); 
						$("#FacturaFirma").html(data); 
					
 */
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
function firma_electronica(  id ) {
	  
 
    
    var parametrosf = {
			    'id' : id 
   };
		
   $.ajax({
				data:  parametrosf,
				//url:   '../model/externo.php',
				url:   '../../facturae/autoriza_factura.php',
				type:  'GET' ,
				success:  function (data) {
					
					$("#FacturaFirma").html(data); 
					     
				} 
			 
		});  


}
//-------------------------

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
            var  tipofacturaf     = $("#tipofacturaf").val();
         
            var parametros = {
					'estado' : estado , 
                    'cajero' : cajero  ,
                    'fecha1' : fecha1  ,
                    'cierre' : cierre,
                    'tipofacturaf' : tipofacturaf
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
 								'<button title ="Anular Factura" class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'  +
 								'&nbsp;<button title ="Enviar Factura Electrónica" class="btn btn-xs" onClick="javascript:goToURLElectronico('+"'electronica'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-globe"></i></button>'  +
 								'&nbsp;<button title ="Nota de Credito" class="btn btn-xs" onClick="javascript:goToURLNota('+"'nota'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-alert"></i></button>'
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
 //---------------- BusquedaGrillaNota(oTableNota);
  function BusquedaGrillaNota(oTableNota){        
	  
 
		$.ajax({
 		    url: '../grilla/grilla_cierre_nota.php',
			dataType: 'json',
			success: function(s){
			//console.log(s); 
				oTableNota.fnClearTable();
			    	if(s ){  		
						for(var i = 0; i < s.length; i++) {
							oTableNota.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
 	                        s[i][3],
                          s[i][4],
                          s[i][5],
						 '<button title ="Nota de Credito" class="btn btn-xs" onClick="javascript:goToURLNotaImpresion('+s[i][6] +')"><i class="glyphicon glyphicon-print"></i></button>'

 						]);										
					} // End For
		    	}						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
	 
	   

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
    var fecha    	  = $('#fecha1').val();
    
   			
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    enlace = url + '?fecha='+fecha;
    
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

 	 $("#ViewForm1").load('../controller/Controller-inv_cierre_nc.php');
 	 
 
 	
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
