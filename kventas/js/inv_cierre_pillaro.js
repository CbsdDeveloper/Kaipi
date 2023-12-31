"use strict";

var oTable;
 
var oTableArticulo;


var oTableAgua;
   
var oTableNota;

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
    
   
    
    
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	 
		
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
		   
        oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 2 ] },
  		      { "sClass": "di", "aTargets": [ 6 ] },
  		    ] 
       } );
        
        
        oTableAgua = $('#jsontableDato').dataTable(); 
        
        oTableNota = $('#jsontableNota').dataTable(); 
        
        
		BusquedaGrilla(oTable);
		
        $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
        
        $('#loadNota').on('click',function(){
	 		 
            BusquedaGrillaNota(oTableNota);
            
  		});
         
        $('#loadFacInicio').on('click',function(){
	 		 
            CargarBase();
            
  		});
        
        
         
       $('#loadFac').on('click',function(){
	 		 
        	goToURLElectronicoLote();
            
  		}); 
	
       $('#loadFaca').on('click',function(){
	 		 
       	goToURLElectronicoLoteAutoriza();
           
 		}); 
       
       
       $('#loadno1').on('click',function(){
 
       	BusquedaNovedad(oTable,1);
           
 		}); 
       
       
       $('#loadno2').on('click',function(){
	 	 
    	   BusquedaNovedad(oTable,2);
           
 		}); 
       
       $('#loadno3').on('click',function(){
  	 	 
    	   Limpiar_datos();
           
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
/*
*/	
function goto_detalle(id) {
 

	$('#mov_sq').val(id); 
 
	
	
		var parametros = {
					   'id' : id 
		  };

		 $.ajax({
					   data:  parametros,
					   url:   '../model/ajax_detalle_pillaro_fac.php',
					   type:  'GET' ,
						beforeSend: function () { 
								$("#VisorArticuloDetalle").html('Procesando');
						 },
					   success:  function (data) {
								$("#VisorArticuloDetalle").html(data);   
								
						 } 
			   }); 

			   $('#myModalDetalle').modal('show');

	
	   }

/*
 ir a la opcion de editar
*/

function CambiarSecuencia() {
 
 var id = 	$('#mov_sq').val(); 
	
	var parametros = {
				   'accion' : 'seq' ,
				   'id' : id 
	  };
	 $.ajax({
				   data:  parametros,
				   url:   '../model/Model-inv_cierre.php',
				   type:  'GET' ,
				 
				   success:  function (data) {
							alert(data);
							
					 } 
		   }); 

   }

  /**/  
  function EliminarSecuencia() {
 
	var id = 	$('#mov_sq').val(); 
	   
	   var parametros = {
					  'accion' : 'duplicado' ,
					  'id' : id 
		 };
		$.ajax({
					  data:  parametros,
					  url:   '../model/Model-inv_cierre.php',
					  type:  'GET' ,
					
					  success:  function (data) {
							   alert(data);
							   
						} 
			  }); 
   
	  }
/*
*/
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
	 
	 var parametrosf = {
			    'id' : id 
     };
	  
	 
   if ( id > 0 ) {
	 
				 	$.ajax({
				 			data:  parametros,
				 			 url:   '../model/genera_xml_notac.php',
				 			type:  'GET' ,
				  			success:  function (data) {
				  				
				  				$("#FacturaElectronica").html(data); 
				 				     
				 				} 
				 	});
				      
				 	alert('Factura Emitida');
 				  	//------------------------------------------------------------
			 	    $.ajax({
							data:  parametrosf,
							 url:   '../../facturae/autoriza_notac.php',
							type:  'GET' ,
							success:  function (data) {
								$("#FacturaElectronica").html(data); 
								     
								} 
					}); 
   }


}
//-------------------------------
function goToURLElectronicoLotexml( id,i ) {
	
	 var parametros = {
			    'id' : id 
	 };
	  
//		firma_autoriza_electronica_lote(id);
	  
					 	$.ajax({
					 			data:  parametros,
					 			 url:   '../model/genera_xml_factura.php',
					 			type:  'GET' ,
					 			beforeSend: function () { 
					 				
					 			   $("#FacturaFirma").html('<img src="loader_all.gif"/> ' +  i);
					 			   
							    },
					  			success:  function (data) {
					  				
					  				$("#data").html(data); 
					  				
					  			    $("#FacturaFirma").html('<img src="loader_all.gif"/> ' +  i);
 					  			 
 					  				
					 			 } ,
					 			complete : function(){
  					 				    
					 				 $("#FacturaFirma").html('Proceso Finalizado ... revisar la informacion ' + i); 
	                            } 
					 	});
		 
					 

}
//----------------------
function goToURLNota(accion1,id) {
	 
	  var parametros = {
				'accion' : accion1 ,
                'id' : id 
	  };
	  
	  var url ;
	  
	  if ( accion1 == 'limpiar'){
		  
		  url = '../model/Model-inv_cierre_limpia.php';
	  
	  }else {
		  
		  $('#mytabs a[href="#tab3"]').tab('show');
		  
		  url = '../model/Model-inv_cierre_nota.php';
		  
	  }
		  
	 
	  
	  
	  $.ajax({
				data:  parametros,
				url:   url,
				type:  'GET' ,
				beforeSend: function () { 
					$("#FacturaFirma").html('Proceso Finalizado ... revisar la informacion '); 
				},
				success:  function (data) {
					$("#FacturaFirma").html(data); 
					     
				} 
		}); 
	
	 
	
    
    
  }
//----------------------------------------
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
//---------------------
function Limpiar_datos( ) {
	 
	
     var  fecha1      = $("#fecha1").val();


	 alert('Limpiar Informacion para comprobantes electronicos no validos');
	 
	 var i = 0 ;
	 
	 $('#jsontable tr').each(function() { 
		    
		 
		   var customerId = $(this).find("td").eq(0).html();  
		
		   if (  i >   0  ) { 
			   
 			   
			   goToURLNota('limpiar',customerId)
		
			   
		   }
		   
		   i = i + 1;
		  
    }); 
	 
	   $("#data").html(i); 

	

}
//-------
function goToURLElectronicoLote( ) {
	 
	
 	     var  fecha1      = $("#fecha1").val();
     
 
		 alert('Generando Informacion para comprobantes electronicos');
		 
		 var i = 0 ;
		 
		 $('#jsontable tr').each(function() { 
			    
			 
			   var customerId = $(this).find("td").eq(0).html();  
			
			   if (  i >   0  ) { 
				   
				   goToURLElectronicoLotexml( customerId,i ) ;
				   
			
				   
			   }
			   
			   i = i + 1;
			  
	     }); 
		 
		   $("#data").html(i); 
 
		
 
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
			   
			   firma_electronica( customerId,i ) ;
 			
		   }
		   
		   i = i + 1;
		  
    }); 
	
	//  $("#FacturaFirma").html('<img src="loader_all.gif"/> ' +  i);
	 
	// $("#FacturaFirma").html('Proceso Finalizado ... revisar la informacion ' + i); 
	 
	// $("#data").html('Proceso Finalizado ...'   + i); 
	// $("#FacturaElectronica").html('Proceso Finalizado espere 10 segundos para actualizar'  ); 
	// $("#FacturaContador").html('Proceso Finalizado ... presione el icono de buscar'  ); 
 

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
//-----
function CargarBase( ) {
	 
	
	 var periodo1 	 = $('#periodo1').val();
	 var novedad1 	 = $('#novedad1').val();
	 var fecha1 	 = $('#fecha1').val();
	 
	    
	  
	 var parametros = {
			    'periodo1' : periodo1 ,
			    'novedad1' : novedad1,
			    'fecha1': fecha1
  };


$.ajax({
		data:  parametros,
		 url:   '../migra/_enlace_pillaro.php',
		type:  'GET' ,
		success:  function (response) {
			 
			   $("#FacturaElectronica").html(response); 
			
 				
			} 
});


}
//--------------
function goToURLElectronicoPersonal(id) {
	
	 var parametros = {
			    'id' : id  
    };
	 
	$.ajax({
		data:  parametros,
		 url:   '../migra/_enlace_pillaro_temp.php',
		type:  'GET' ,
		success:  function (response) {
			 
			   $("#FacturaElectronica").html(response); 
			
			 //  goToURLElectronicoLotexml( id,1 ) ;
 				
			   alert('Generando Comprobante...');
			   
			//   firma_electronica( id,1 ) ;
			} 
});
	
}
//------
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
function firma_autoriza_electronica_lote ( id  ) {
	
	 var parametrosi = {
			    'id' : id 
 };
	 
	  $.ajax({
			data:  parametrosi,
			url:   '../../facturae/autoriza_factura_firma.php',
			type:  'GET' ,
			success:  function (data) {
			 
				$("#data").html(data); 
 			 
				 
			} 
	});
	  
}
//-----------------------
function firma_electronica(  id,i ) {
	  
      
	//	url:   '../model/externo.php',
	
    var parametrosf = {
			    'id' : id 
   };
		
   $.ajax({
				data:  parametrosf,
				url:   '../../facturae/autoriza_factura.php',
				type:  'GET' ,
				beforeSend: function () { 
	 				
		 			   $("#FacturaFirma").html('<img src="loader_all.gif"/> ' +  i);
		 			   
				    },
		  			success:  function (data) {
		  				
		  				$("#data").html(data); 
		  				
		  			    $("#FacturaFirma").html('<img src="loader_all.gif"/> ' +  i);
		  			 
		  				
		 			 } ,
		 			complete : function(){
		 				    
		 				 $("#FacturaFirma").html( i +'. Proceso Finalizado ... revisar la informacion [ ' + id + ' ]'); 
                 } 
			 
		});  

   
   //   $("#FacturaFirma").html('<img src="loader_all.gif"/>');
   //   $("#data").html(i); 
   //   $("#FacturaFirma").html('Proceso  ... ' + i); 
			   

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
            var  cierre     = 'S';
   
            var  idprov1      = $("#idprov1").val();
            var  razon1      = $("#razon1").val();
            
        	 var novedad1 	 = $('#novedad1').val();
         
            var parametros = {
					'estado' : estado , 
                    'cajero' : cajero  ,
                    'fecha1' : fecha1  ,
                    'cierre' : cierre,
                    'idprov1':idprov1,
                    'razon1' : razon1,
                    'modulo' : novedad1
 	       };
      
            
            
            
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_cierre_tempo.php',
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
 								'<button title ="Nota de Credito" class="btn btn-xs btn-warning" onClick="goToURLNota('+"'nota'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-alert"></i></button>&nbsp;&nbsp;' +
 								'<button title ="Limpiar Comprobante electronico" class="btn btn-xs btn-info" onClick="goToURLNota('+"'limpiar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-erase"></i></button>&nbsp;&nbsp;'+
 								'<button title ="Detalle Factura" class="btn btn-xs btn-success" onClick="goto_detalle('+ s[i][0] +')"><i class="glyphicon glyphicon-download-alt"></i></button>&nbsp;' +
								 '<button title ="Impresion Factura" class="btn btn-xs btn-default" onClick="goToURLElectronicoActualiza('+ s[i][0] +')"><i class="glyphicon glyphicon-print"></i></button>&nbsp;' 
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
  //---
function goToURLElectronicoActualiza(id) {
		
	  
	  //------------------ impresion ---------------
	  var posicion_x; 
     var posicion_y; 
     var enlace; 
     var ancho = 720; 
     var alto = 550; 
   
      
 						      var url = '../../facturae/factura_electronica.php';
								     			
								      posicion_x=(screen.width/2)-(ancho/2); 
								      
								      posicion_y=(screen.height/2)-(alto/2); 
								      
								      enlace = url + '?id='+ id;
								      
								      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
							  
     
			 

	   }
 //-------------------------------
  function BusquedaNovedad(oTable,tipo){        
	  
	   
	  var user = $(this).attr('id');
 
      var  fecha1      = $("#fecha1").val();
 
      var  cajero      = $("#cajero").val();
      
      
      var parametros = {
               'tipo' : tipo,
              'fecha1' : fecha1 ,
              'cajero' : cajero
      };


      
		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,  
		    url: '../grilla/grilla_cierre_novedades.php',
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
							'<button title ="Nota de Credito" class="btn btn-xs btn-warning" onClick="goToURLNota('+"'nota'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-alert"></i></button>&nbsp;&nbsp;' +
							'<button title ="Limpiar Comprobante electronico" class="btn btn-xs btn-info" onClick="goToURLNota('+"'limpiar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-erase"></i></button>&nbsp;' +
							'<button title ="Detalle Factura" class="btn btn-xs btn-success" onClick="goto_detalle('+ s[i][0] +')"><i class="glyphicon glyphicon-download-alt"></i></button>'

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
                          s[i][5]
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
//------------

function BuscarNombreAgua()
{
 
 
	 var nombre_agua =   $('#nombre_agua').val();
		 
	 var parametros = {
			    'nombre_agua' : nombre_agua 
   };
	  
 
   $.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_cierre_pillaro.php',
				dataType: 'json',
				success: function(s){
				//console.log(s); 
				     oTableAgua.fnClearTable();
				    	if(s ){  		
							for(var i = 0; i < s.length; i++) {
							 oTableAgua.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
                                s[i][4],
                                s[i][5],
 								'<button title ="Comprobante electronico" class="btn btn-xs" onClick="javascript:goToURLElectronicoPersonal('+ s[i][0] +')"><i class="glyphicon glyphicon-download-alt"></i></button>'

 							]);										
						} // End For
			    	}						
				},
				error: function(e){
				   console.log(e.responseText);	
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
	  	 $("#ViewFiltro").load('../controller/Controller-inv_pillaro_filtro.php');
 
     

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
				url:   '../model/Model-resumenventasDet_pillaro.php',
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
				url:   '../model/Model-resumenventas_pillaro.php',
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
				url:   '../model/Model-resumenpago_pillaro.php',
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
