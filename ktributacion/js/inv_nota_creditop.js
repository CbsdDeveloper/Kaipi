var oTable;
 
var oTableArticulo;
   
var oTableNota;
 

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	 
		
	$("#MHeader").load('../view/View-HeaderModel.php');
	
	$("#FormPie").load('../view/View-pie.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
      
         
        oTableNota = $('#jsontableNota').dataTable(); 
        
 
        $('#loadNota').on('click',function(){
	 		 
            BusquedaGrillaNota(oTableNota);
            
  		});
         
		  anio_actual();
		 
         
      
       
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
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
							 $("#secuencial1").val(data);   
							 
							 $("#ViewFactura").html('DATOS GENERADOS CON EXITO');   
							 
						     
					} 
			  }); 
			  
				 
		  }
		 }); 
 
 

   }
//------------------------- NOTA DE CREDITO
function goToURLNotaCredito( ) {
	
	  
 
    var id 	 = $('#id_movimiento1').val();
    
     
	 var parametros = {
			    'id' : id 
     };
	 
	 	  
	 
   if ( id > 0 ) {
 	   			      alert('Genera comprobante');
 
					   $.get("../../facturae/crearClaveAccesoN.php?id="+id+"&tipo=2"); 
					   
					   $.get("../../facturae/crearXMLnotac.php?id="+id); 
 					   
					   $.ajax({
				 			data:  parametros,
				 			url:   '../../facturae/autoriza_notac.php',
				 			type:  'GET' ,
							 beforeSend: function () { 
 
								$("#FacturaElectronicaNc").html('<img src="ajax-loader.gif"/>');
 		
						  },
				  			success:  function (data) {
 
				  				$("#resultadoNota").html(data); 

								  $("#FacturaElectronicaNc").html('generado!');	  
				  				
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
	
	 
	  DetalleMov(id,accion1);
	  
	 $('#mytabs a[href="#tab3"]').tab('show');
    
    
  }
//---------------
function goToURLNotaAnula( ) {
	
	
	var id 				 = $('#id_movimiento1').val();
	var secuencial1 	 = $('#secuencial1').val();
	var comprobante1	 = $('#comprobante1').val();
 	
 	
	if (id){
		 alertify.confirm("Desea Anular la nota de credito", function (e) {
			  if (e) {
				 
				  var parametros = {
	 		                'id' : id ,
	 		                'secuencial1' :secuencial1,
							'comprobante1':comprobante1,
							 'accion' : 'anula'
				  };
				  
				  $.ajax({
							data:  parametros,
							url:   '../model/Model-inv_cierre_nota.php',
							type:  'GET' ,
							beforeSend: function () { 
									$("#resultadoNota").html('Procesando');
							},
							success:  function (data) {
									 $("#resultadoNota").html(data);   
									 alert("Comprobante Anulado... actualice su pantalla");
								     
							} 
					}); 
	
					 
			  }
			 }); 
	  }
  
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
 
//----------------
function DetalleOriginal( ) {
	
	var id_movimiento = $('#id_movimiento1').val();

	var parametros = {
			   'id' : id_movimiento 
 };
	 
	 
		$.ajax({
								data:  parametros,
								url:   '../model/ajax_factura_original.php',
								type:  'GET' ,
								 success:  function (data) {
										  $("#VisorArticuloOriginal").html(data); 
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

 
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
	var fecha = fecha_hoy();
	
	$("#id_movimiento1").val( '' );  
											 
	$("#fecha_factura").val( '' );  
	
	$("#comprobante1").val( '' );  
	 
	$("#ViewFactura").html( '');  
	
	 $("#estab1").val( '');  
	 $("#ptoemi1").val( '');  
	 $("#coddocmodificado").val( '');  
	 $("#fechaemisiondocsustento").val( '');  
	 $("#coddocmodificado").val( '');  
	 $("#numdocmodificado").val( '');  
	 $("#secuencial1").val('');  
	  $("#cab_autorizacion").val( '');  
	  $("#idcliente").val(  '' );  
	  $("#id_diario").val( '' );  
	 
	  DetalleMov(0,'nota');
	 

	$("#result").html("<b>Agregar Nueva Solicitud</b>");
	
	
    }
   /*
   */
	function anio_actual()
	{
	   
		var today = new Date();
 	
		var yyyy = today.getFullYear();
		
		$("#nc_anio").val(yyyy);

 
	 
				
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



function Contabilizar()
{
 
		  var fecha1     = $("#fecha1").val();
		 var fecha2      = $("#fecha1").val();
		 var idbancos     = $("#idbancos").val();
		
	   var tipofacturaf = $("#tipofacturaf").val();
	   
	   
	   var parametros = {
					 'fecha1' : fecha1,  
				   'fecha2' : fecha2,  
				   'idbancos': idbancos,
				   'tipofacturaf': tipofacturaf
		};
		   
		   $.ajax({
				   url:  '../model/Model-ContaVentas.php' ,
					data:  parametros,
				   type:  'GET' ,
					   beforeSend: function () { 
							   $("#ContabilizadoVentas").html('Procesando');
					   },
				   success:  function (data) {
							$("#ContabilizadoVentas").html(data);  // $("#cuenta").html(response);
							
					   } 
		   });
	

} 
 
  //------------------------------------------------------------------------- 
     
 //---------------- BusquedaGrillaNota(oTableNota);
  function BusquedaGrillaNota(oTableNota){        
	  
	var nc_anio = $("#nc_anio").val();
 
	var parametros = {
		'nc_anio' : nc_anio 
};


		$.ajax({
			data:  parametros,  
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
                          s[i][6],
                          s[i][7],
						 '<button title ="Nota de Credito" class="btn btn-xs btn-warning" onClick="goToURLNotaImpresion('+s[i][8] +')"><i class="glyphicon glyphicon-print"></i></button>' + 
						 '&nbsp;<button title ="Nota de Credito" class="btn btn-xs btn-info" onClick="goToURLNota('+"'nota'"+','+ s[i][8] +')"><i class="glyphicon glyphicon-edit"></i></button>'
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

 

 
 function modulo()
 {
 	 var modulo =  'ktributacion';
 	 
 	 var parametros = {
			    'ViewModulo' : modulo 
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
 			url:   '../controller/Controller-inv_FacDet_nota.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewNotaDetalle").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewNotaDetalle").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
///---------------------- 
function calcular(id, tipo) {
    

	var objeto 					 =  '#costo_' + id;
	var costo 					 =   $(objeto).val();

	objeto =  '#cantidad_' + id;
	var cantidad 			     =  $(objeto).val();

	objeto =  '#monto_iva_' + id;
	var monto_iva 			     =  $(objeto).val();

	objeto =  '#baseiva_' + id;
	var baseiva 			     =  $(objeto).val();
	 
	objeto =  '#tarifa_cero_' + id;
	var tarifa_cero 			 =  $(objeto).val();
	 
	objeto =  '#total_' + id;
	var total 			 =  $(objeto).val();
	
 
	 guarda_detalle(baseiva,monto_iva,tarifa_cero,cantidad,total,estado,'F',id,costo,tipo);
 
 
 
} 
//-----------
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,lcosto,tipo)
{
  
 
	var id_movimiento = $('#id_movimiento1').val();

	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": 'F',
 			"id" : id  ,
 			"lcosto": lcosto,
			"tipo" : tipo 
	};
	
 
		
			$.ajax({
		 			 url:   '../model/Model-editproducto_nota.php',
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#DivProducto").html('Procesando');
						},
					success:  function (data) {
							 $("#DivProducto").html(data);   
						     
						} 
			});
 
			DetalleMov(id_movimiento,'nota');

}
//-----------
function busca_factura()
{
	
	var   comprobante = $('#comprobante1').val();
	
	
 
		var parametros = {
									"comprobante" : comprobante 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/ajax_busqueda_fac.php',
									dataType: "json",
									success:  function (response) {

										
											 $("#id_movimiento1").val( response.a );  
											 
											 $("#fecha_factura").val( response.b );  
											 
											 $("#comprobante1").val( response.c );  
											  
											 $("#ViewFactura").html( response.d);  
											 
											  $("#estab1").val( response.e);  
											  $("#ptoemi1").val( response.f);  
											  $("#coddocmodificado").val( response.g);  
											  $("#fechaemisiondocsustento").val( response.h);  
											  $("#coddocmodificado").val( response.i);  
											  $("#numdocmodificado").val( response.j);  
											  $("#secuencial1").val( response.k);  
											   $("#cab_autorizacion").val( response.l);  
											   $("#idcliente").val( response.m);  
											   $("#id_diario").val( response.n);  
											  
											   DetalleMov(response.a,'nota');
									} 
							});

	 
	
 }
//------------------------- 
function ActualizaFac(tipo)
{
	
	var id_movimiento = $('#movi').val();
	
	var comprobante = $('#comprobantee').val();
	var fecha       = $('#fechae').val();
	var fechaa      = $('#fechaa').val();
	
    var parametros = {
            'id'   : id_movimiento,
    	    'tipo' : tipo,
    	    'comprobante' : comprobante,
    	    'fecha' : fecha,
    	    'fechaa' : fechaa
     };
 	 
	 
     alertify.confirm("Desea realizar actualizacion de la informacion?", function (e) {
		  if (e) {
			 
			    
				$.ajax({
			 			url:   '../model/inv_cierre_datos.php',
			 			data:  parametros,
						type:  'GET' ,
							beforeSend: function () { 
									$("#VisorArticuloWebDato").html('Procesando');
							},
						success:  function (data) {
								 $("#VisorArticuloWebDato").html(data);  // $("#cuenta").html(response);
							     
							} 
				}); 

				 
		  }
		 }); 
     
 
}
/*
*/
 
//------------------------- 
function goToURLve(id_movimiento)
{
	
	
	
	
	$('#movi').val(id_movimiento);
 
    var parametros = {
            'id' : id_movimiento
     };
    
	$.ajax({
 			url:   '../controller/Controller-inv_cierre_fac.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticuloWeb").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticuloWeb").html(data);  // $("#cuenta").html(response);
				     
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
