 var oTable;
 var oTableArticulo;
 var oTablePendiente;
   
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
    
		window.addEventListener("keypress", function(event){
		    if (event.keyCode == 13){
		        event.preventDefault();
		    }
		}, false);
		  
	 
		
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
	 
	 	 
        oTable 				= $('#jsontable').dataTable(); 
	       
        oTablePendiente		= $('#jsontablePendidente').dataTable(); 
        
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     
	     $('#loadProceso').on('click',function(){
 	 		 
	          ProcesarInformacion();
	           
	 		});
	     
	     
	     
	     
	     $('#loadPendiente').on('click',function(){
 	 		 
	    	 BusquedaGrillaPendiente(oTablePendiente);
	           
	 		}); 
	     
	     
	     $.ajax({
 				url: "../model/ajax_fac_pendiente.php",
				type: "GET",
				success: function(response)
				{
				$('#userpendiente').html(response);
				}
			});
	
	     
	     $("a[rel='pop-up']").click(function () {
	       	var caracteristicas = "height=390,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
	       	nueva=window.open(this.href, 'Popup', caracteristicas);
	       	return false;
	    });
	         
	     
	 	
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
                	
			  		 AsignaBodega();
			  		
			  		 $("#DivProductoDisponible").load('../model/Model-lista-mi-servicio.php');
			  		 
                      LimpiarPantalla();
       				 
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
// ir a la opcion de editar
function goToURL(accion1,id) {
 
 


	
     var parametros = {
					'accion' : accion1 ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_factura.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
	  
	  pagoshow(0);

    }
//---------------------
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToURLDel(accion1,id) {

	
	  var parametros = {
					 'accion' : accion1 ,
	                 'id' : id 
		  };
	  
 
	  alertify.confirm("Eliminar Registro " +id , function (e) {
		  if (e) {
			 
   		 
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_factura.php',
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
//---------------------------------------
function GeneraDetalleImp( ) {

	
	
	alertify.confirm("Genera Informacion parametrizada", function (e) {
		  if (e) {
			 
		  	 
			    var idcategoria   = $('#idcategoria').val();
				var id_movimiento = $('#id_movimiento').val();
 
			 
				var parametros = {
			 			"id_movimiento" : id_movimiento,  
						"idcategoria" : idcategoria  
				};
				
	 
					
					if ( id_movimiento > 0 ) {
							
								$.ajax({
							 			 url:   '../model/Model-addFacturaFormula.php',
							 			data:  parametros,
										type:  'GET' ,
											beforeSend: function () { 
													$("#GuardaArticulo").html('Procesando');
											},
										success:  function (data) {
												 $("#GuardaArticulo").html(data);  // $("#cuenta").html(response);
											     
											} 
								});
					}
					else {
						alert('Debe guardar la informacion para agregar la informacion de las variables');
					}
			  
 				 
		  }
  }); 
}
//-------------------------------------------------------------------------
//ir a la opcion de editar
function ActualizaCliente( ) {


	var idprov   = $('#idprov').val();
	var razon   = $('#razon').val();
	var correo   = $('#correo').val();
	
 
 
  var parametros = {
					'idprov' : idprov ,
                    'razon' : razon, 
                    'correo' : correo 
	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-clientes_actualiza.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#okCliente").html('Procesando');
					},
					success:  function (data) {
							 $("#okCliente").html(data);  // $("#cuenta").html(response);
						     
					} 
			}); 
	  
	  pagoshow(0); 
 
 }
//--------------
function LimpiarCliente( ) {


  $('#idprov').val('');
  $('#razon').val('');
  $('#correo').val('');
	
  pagoshow(0); 
	  
 
 }


//--- oculta
function pagoshow(tipo) {
	 
	if (tipo == 0){
		 $("#cuentaBanco").hide();
		 
		 $("#idbanco").hide();
		 
		 $("#lcuentaBanco").hide();
		 
		 $("#lidbanco").hide();		
		 
		 
	}else{
		 $("#cuentaBanco").show();
		 
		 $("#idbanco").show();
		 
		 $("#lcuentaBanco").show();
		 
		 $("#lidbanco").show();				
		
	 
	}
 
}

//-----
function cambio_dato(monto_pagado) {
	
	var tt1   = $('#xx').val();
	
	
	 
	 var total = monto_pagado - parseFloat (tt1).toFixed(2);
	    

	 var CalcularPago = parseFloat(total.toFixed(2));  
	 
	 
	   
	 if (isNaN(CalcularPago)){
		 
  	   $('#div_sucambio').html('<h3><b>0.00</b></h3>');  
     
	 }else{
  	   $('#div_sucambio').html('<h3><b>Su Cambio es: '+ CalcularPago+'</b></h3>'); 
     
	 }
	
	
	
}

//--- oculta tipo
function tipopagoshow(tipo) {
	 
	if (tipo == 'efectivo'){
		pagoshow(0);	
	}else{
		pagoshow(1);	
		if (tipo == 'deposito'){
			DatoBanco(1);
		}else{
			DatoBanco(0);
		}
 	}
 
}
//-----------------
function BuscarClienteDato( )
{
 
	var idprov = $("#idprov").val();
	var razon = $("#razon").val();

	$('#myModalProv').modal('show');


	
	$("#DetProveedores").html('<h4>' + idprov + ' ' + razon + '</h4>');

	var parametros = {
		'idprov' : idprov 
    };


  
	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_historial_ciu.php',
			 type:  'GET' ,
				beforeSend: function () { 
						$("#VisorProveedores").html('Procesando');
				},
		  	success:  function (data) {
					 $("#VisorProveedores").html(data);   
				     
				} 
	});
  
}
//-------------
function DatoBanco(codigo)
{
 
  


	 var parametros = {
				    'codigo' : codigo 
	   };
		  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-idbanco.php',
			 type:  'GET' ,
				beforeSend: function () { 
						$("#idbanco").html('Procesando');
				},
			success:  function (data) {
					 $("#idbanco").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     
 
}
//-----------------------
function FormaPago(tipo) {
	
	
	var tt1   = $('#xx').val();
	
    var total = parseFloat (tt1).toFixed(2);
		
		
	if( tipo=='credito'){
 
		
		$("#tipopago").attr("disabled", "disabled");
		$("#efectivo").attr("disabled", "disabled");
		
		
		$("#efectivo").val(total);
		
		pagoshow(0);
		
	}else{
	
		$("#tipopago").attr("disabled", false);
		$("#efectivo").attr("disabled", false);

		
		$("#efectivo").val('');
		
		
		
		

	}
	
}
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
 	
	$("#ver_pago").html("A PAGAR $ ");
	$("#ver_factura").html("NRO.");
	$("#div_sucambio").html('');
	
	
	$("#detalle").html('Servicio de ');
	
	
	$("#carga").val("0");
	
	

	DetalleMov(0,'add');
	 
	$("#formapago").val("contado");
	
	FormaPago("contado")
	
	pagoshow(0);
	
	
	$("#estado").val("digitado");
	
	
	$("#detalle").html('Servicio de ');
	
	
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
     
     var  estado	= $("#estado1").val();
     var  cajero      = $("#cajero").val();
     var  fecha1      = $("#fecha1").val();
     var  fecha2     = $("#fecha2").val();
    
     var  tipofacturaf     = $("#tipofacturaf").val();
     
  
     var parametros = {
				'estado' : estado , 
             'cajero' : cajero  ,
             'fecha1' : fecha1  ,
             'fecha2' : fecha2,
             'tipofacturaf' : tipofacturaf
     };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,  
		    url: '../grilla/grilla_ven_factura.php',
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
                            '<button title ="Editar Registro " class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button title ="Eliminar Registro (Digitado) " class="btn btn-xs" onClick="javascript:goToURLDel('+"'del'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-remove"></i></button> &nbsp;' +
							'<button title ="Enviar Factura Electronica" class="btn btn-xs" onClick="javascript:goToURLElectronico('+"'electronica'"+','+ s[i][9] +')">' +
							'<i class="glyphicon glyphicon-envelope"></i></button> &nbsp;' +
							'<button title ="Descargar xml Factura" class="btn btn-xs" onClick="javascript:goToURLXml('+"'electronica'"+','+ s[i][9] +')">' +
							'<i class="glyphicon glyphicon-download-alt"></i></button> &nbsp;' +
							'<button title ="Generar cuenta por cobrar" class="btn btn-xs" onClick="javascript:goToURCuentas('+"'electronica'"+','+ s[i][9] +')">' +
							'<i class="glyphicon glyphicon-inbox"></i></button>'
						]);										
					} // End For
			    }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
}  
 //-----------------------
 
 function BusquedaGrillaPendiente(oTablePendiente){        
	 
	 
	 
     var  idprov      = $("#userpendiente").val();

	 

  var parametros = {
				'estado' : 1 , 
				'idprov' : idprov
 
  };

 
		$.ajax({
		 	data:  parametros,  
		    url: '../grilla/grilla_ven_factura_pendiente.php',
			dataType: 'json',
			success: function(s){
			        //console.log(s); 
				oTablePendiente.fnClearTable();
					
					if(s ){ 
						for(var i = 0; i < s.length; i++) {
							oTablePendiente.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
	                        s[i][3],
	                        s[i][4],
	                        s[i][5],
	                    	'<input type="checkbox" id="myCheck'+ s[i][0] +'"   onclick="myFunction('+ s[i][0] +',this)" '+ s[i][6]  + '>'
						]);										
					} // End For
			    }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		 
}  
 
 //-----------------------
 function goToURLElectronico(accion1,id) {
 	 
	   var parametros = {
				'accion' : accion1 ,
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
 //-------------------------
 
 //------------------ impresion ---------------
 // DESCARGA EL XML DE LA FACTURA
 function goToURLXml(accion1,id) {
	 
 var posicion_x; 
var posicion_y; 
 var ancho = 720; 
var alto = 550; 
var url = '../../facturae/factura_electronica_xml.php';
var enlace = url + '?id='+ id;
 

		if ( id > 0 ) {
		
			location.href = enlace;
	 
		}
 }
 //---------------------
 
 function goToURLGenera(accion1,id) {
 	 
	   var parametros = {
				'accion' : accion1 ,
                'id' : id 
		};
	   
	 
	   $.ajax({
			data:  parametros,
			 url:   '../model/Model-inte_clientes_pendiente.php',
			type:  'GET' ,
			success:  function (response) {
				 
				   $("#ViewPendiente").html(response); 
				
					alert('Enviado');
					
				} 
	});  

}
 //-----------------------
 function goToURCuentas(accion1,id) {
	 
 
	 
	  var fecha  = $("#fecha2").val();
	 
     var parametros = {
				'fecha' : fecha ,
                'id' : id 
		};
     
		$.ajax({
						data:  parametros,
						url:   '../model/Model_ContaVentas.php',
						type:  'GET' ,
						beforeSend: function () { 
								$("#ViewCuenta").html('Procesando');
						},
						success:  function (data) {
								 $("#ViewCuenta").html(data);  // $("#cuenta").html(response);
							     
						} 
				}); 
 
 
  }
 
//--------------------------
// EMITE COMPROBANTE DE RETENCION PRIMERA VEZ 
 function goToURLElectronicoTool(accion1) {
		
  
     var id 	 = $('#id_movimiento').val();
     
      
	 var parametros = {
			    'id' : id 
     };
	  
    var tipofactura  =  $('#carga').val()  ;
	  
	  
    if ( tipofactura == '0' ) {
    	
     if ( id > 0 ) {
    	 
 	 
				  alert('Genera Comprobante Eletronico');
		    	 		  
				  $.ajax({
			 			data:  parametros,
			 			 url:   '../../facturae/crearXMLFactura.php',
			 			type:  'GET' ,
			  			success:  function ( data ) {
			  				
			  			          	$("#FacturaElectronica").html(data); 
			  			         	
			  			            $("#ver_factura").html('<img src="loader.gif"/>');

			 				}
                        , complete : function(){
                               
                      	  	firma_auto( id );
             
                      }  
			 	});
	  
				      
 
        }
    }else {
    	alert('No se genera este documento');
    }


}
//---------------
 function firma_auto( id ) {
 
 	 
	 
	   var parametrosf = {
			    'id' : id 
      };
    
	 
	var url =  '../../facturae/autoriza_factura.php';
		
	//var url =  '../model/externo.php';	
		
	   $.ajax({
			data:  parametrosf,
			url:   url,
			type:  'GET' ,
			beforeSend: function () { 
				
				$("#FacturaElectronica").html('Procesando' );
				$("#ver_factura").html('<img src="loader.gif"/>');
		},
		
			success:  function (data) {
			
				$("#FacturaElectronica").html(data);  
				
				$("#ver_factura").html('');
				     
				} 
	});
 
   }
 //--------------- 
 function ProcesarInformacion (   ) {
	  
	 var userpendiente =  $("#userpendiente").val(); 
     
	  var parametros = {
			    'idprov' : userpendiente 
   };
	 
	  alertify.confirm("Desea generar prefactura ?", function (e) {
		  if (e) {
 
				  $.ajax({
						data:  parametros,
						url:   '../model/Model-inte_clientes_prefactura_pre.php',
						type:  'GET' ,
						success:  function (data) {
						 
							$("#ViewPendiente").html(data); 
							    
			 				 
						} 
				});
		  
				 //----------
				  $.ajax({
		 				url: "../model/ajax_fac_pendiente.php",
						type: "GET",
						success: function(response)
						{
						$('#userpendiente').html(response);
						}
					});
				  
				  BusquedaGrillaPendiente(oTablePendiente);
	   }
    }); 
	  
  }
//---------------------------------------------------------  
function firma_electronica(  ) {
	  
     var id 	 = $('#id_movimiento').val();
     
   var parametrosf = {
			    'id' : id 
    };
		
    $.ajax({
				data:  parametrosf,
				url:   '../model/externo.php',
				type:  'GET' ,
				success:  function (data) {
					
					$("#FacturaElectronica").html(data); 
					     
					  alert('Generando Autorizacion');
				} 
			 
		});  

    
  
	  
 }
 //----------------------------------------
 //---------------------------------------------
 //-- IMPRIME LA RETENCION RIDE DE LA FACTURA
 function goToURLElectronicoActualiza(accion1) {
		
	  
	  //------------------ impresion ---------------
	  var posicion_x; 
     var posicion_y; 
     var enlace; 
     var ancho = 720; 
     var alto = 550; 
   
     var id  =   $('#id_movimiento').val();
     
     var tipofactura  =  $('#carga').val()  ;
	  
	  
			     if ( tipofactura == '0') {
			
						     if ( id > 0 ) {
						     
								      var url = '../../facturae/factura_electronica.php';
								     			
								      posicion_x=(screen.width/2)-(ancho/2); 
								      
								      posicion_y=(screen.height/2)-(alto/2); 
								      
								      enlace = url + '?id='+ id;
								      
								      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
							  
						     }	      
				}else {
					alert('No se genera este documento');
				}

	   }
  //----------------------- 
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
   
 	 $("#ViewForm").load('../controller/Controller-ven_factura.php');

 
 	 pagoshow(0);
 	
}
//-------------------- 
function AgregaVariables()
{
  
	  var  id_movimiento     = $("#id_movimiento").val();
     
	    var parametros = {
	            'id_movimiento' : id_movimiento 
	    };
	    
	    
		$.ajax({
	 			 url:   '../controller/Controller-ven_factura_var.php',
	 			 data:  parametros,
				 type:  'GET'  ,
				 success:  function (data) {
						 $("#VisorVariables").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
		
	 
 
}
//---------------AsignaVariables
function AsignaVariables(idcategoria)
{
  
	    var  id_movimiento     = $("#id_movimiento").val();
 	    
	    
	    var parametros = {
	            'id_movimiento' : id_movimiento ,
	            'idcategoria' : idcategoria
	    };
	    
	    
		$.ajax({
	 			 url:   '../controller/Controller-ven_factura_dato.php',
	 			 data:  parametros,
				 type:  'GET'  ,
				 success:  function (data) {
						 $("#variable_seleccion").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
		
		 
		 
		
 
}
//------------------------------
function AsignaBodega()
{
    var  idbodega     = $("#idbodega").val();
     
    var parametros = {
            'idbodega' : idbodega 
    };
    
    
	$.ajax({
 			 url:   '../model/ajax_bodega.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#SaldoBodega").html('Procesando');
				},
			 success:  function (data) {
					 $("#SaldoBodega").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-----------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_movimiento').val(id); 
	  
	DetalleMov(id,action);

	//BusquedaGrilla(oTable);
	
}
//-----------------
function acciona(comprobante_dat, estado)
{
  
	$('#comprobante').val(comprobante_dat); 
	
	$('#ver_factura').html('NRO. ' + comprobante_dat); 
 	
	
	$('#estado').val(estado);
  

}
//----------------------
function FormFiltro()
{
 
	
	 $("#ViewFiltro").load('../controller/Controller-ven_factura_filtro.php');
	 
 

}
//-------------------------------------------------------------
function DetalleMov(id_movimiento,accion1)
{
 
    var parametros = {
            'id' : id_movimiento,  
            'accion': accion1
    };
    
	$.ajax({
 			url:   '../controller/Controller-inv_FacDetSer.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#DivMovimiento").html('Procesando');
				},
			success:  function (data) {
					 $("#DivMovimiento").html(data);   
				     
				} 
	});
     

}
//-------------------------
//----------------------
function InsertaProducto()
{

	var id_movimiento = $('#id_movimiento').val();
	
 	var idproducto    = $('#idproducto').val();
	
	var estado  = $.trim( $('#estado').val() );
  	
 	var tipo    = 'F';
 	
 
 	if ( id_movimiento > 0 ) { 
		
		if (estado == 'digitado'){ 
		 	
			var parametros = {
					"idproducto" : idproducto ,
	                "id_movimiento" : id_movimiento ,
	                "estado" : estado,
	                "tipo" : tipo,
	                "accion" : 'add' 
			};
					 
				          
						  $.ajax({
								data:  parametros,
								url:   '../model/Model-addFacturaSer.php',
								type:  'GET' ,
								beforeSend: function () { 
										$("#DivProducto").html('Procesando');
								},
								success:  function (data) {
										 $("#DivProducto").html(data);  // $("#cuenta").html(response);
										 
										 DetalleMov(id_movimiento,'edit');
								} 
						}); 
				//-----------------
						 
							
				  $('#idproducto').val('');
						 	 
				  $('#CodBarra').val('');
							 
				 $('#articulo').val('');
						  
			}		
 	}else{
 		alert('Guarde Informacion del Comprobante');
 	}
	 
	 
 
}
//----------------------
function InsertaProductoImagen(idproducto)
{

	var id_movimiento = $('#id_movimiento').val();
 
	var estado  = $.trim( $('#estado').val() );
	
	var tipo    = 'F';
	
 
		if (estado == 'digitado'){ 
			
 
			var parametros = {
					"idproducto" : idproducto ,
	                "id_movimiento" : id_movimiento ,
	                "estado" : estado,
	                "tipo" : tipo,
	                "accion" : 'add' 
			};
					 
				          
						  $.ajax({
								data:  parametros,
								url:   '../model/Model-addFacturaSer.php',
								type:  'GET' ,
								beforeSend: function () { 
										$("#DivProducto").html('Procesando');
								},
								success:  function (data) {
										 $("#DivProducto").html(data);  // $("#cuenta").html(response);
										 
										 DetalleMov(id_movimiento,'edit');
								} 
						}); 
	 
						 
							
			 
			}				  
	 

}
 
//--------------------------------------------------------------------	   
function openFile(url,ancho,alto) {
      
	  var posicion_x; 
      var posicion_y; 
      var enlace; 
      
      posicion_x=(screen.width/2)-(ancho/2); 
      posicion_y=(screen.height/2)-(alto/2); 
      
     
      
      enlace = url  ;

      window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}
//--------------------------------------------------------
function calcular(id) {
    
	var estado = $('#estado').val();
 
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 =   $(objeto).val();
	/// CANTIDAD
	objeto =  '#cantidad_' + id;
	var cantidad 			     =  $(objeto).val();
	var	lcantidad                = parseFloat (cantidad).toFixed(2);
	var	lcosto                   = parseFloat (costo).toFixed(2);
	//----------------------------------------------------------------
	objeto =  '#saldo_' + id;
	var sal1 =  $(objeto).val();
	var saldo = parseFloat (sal1).toFixed(2);
	//----------------------------------------------------------------
	var	total; 
	total = lcantidad * lcosto;

	var	baseiva; 
	var	tarifa_cero; 
	var	monto_iva; 
	var tempBase;
	
	var	IVA			= 12/100; 
//	var	DesgloseIVA 	= 1 + IVA ; 

	objeto =  '#tipo_' + id;
	var tipo_mov1 = $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	//---------------- egresos --------------------------------------------
 	
	 
		 
		 
		if ( tipo_movimiento  == 'I'){
			 
			baseiva     =  total   ;
 			tarifa_cero =  0;
			monto_iva   =  baseiva  *  IVA ;
			 
			//----------------- ASIGNA
			objeto =  '#baseiva_' + id;
		 	$(objeto).val(baseiva);
		 	objeto =  '#tarifacero_' + id;
		 	$(objeto).val(tarifa_cero);
		 	objeto =  '#montoiva_' + id;
		 	$(objeto).val(monto_iva);
		 	
		 	total =  monto_iva + baseiva;
 	     }else{
			baseiva     =  0 ;
			tarifa_cero =  costo;
			monto_iva   =  0;
			 
			//----------------- ASIGNA
			objeto =  '#baseiva_' + id;
		 	$(objeto).val(baseiva);
		 	objeto =  '#tarifacero_' + id;
		 	$(objeto).val(tarifa_cero);
		 	objeto =  '#montoiva_' + id;
		 	$(objeto).val(monto_iva);
		}
		
		objeto =  '#total_' + id;
	 	
		total = parseFloat (total).toFixed(2);
		
	 	$(objeto).val(total);
	 	
	 	//--------------------------------
	 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,'F',id);
	 	
		total_factura();
		
	 
	 
 //------------------------------------------------------------------
 	
		
 	
 
    
}
  
function total_factura(){
	
    var formulario = document.getElementById("fo3");
	var layFormulario            = formulario.elements;
	var lnuElementos             = layFormulario.length;
			
    var CalcularIva             	 = 0;
    var Calculartotal             	 = 0;
    var CalcularBIva             	 = 0;
    var CalcularBase            	 = 0;
                
//	var TIPO_MOVIMIENTO = $('#tipo').val();
	
    
	//if (TIPO_MOVIMIENTO == 'I') {
		
		 	
        for( var xE = 0; xE < lnuElementos; xE++ ){		 
        					var lobCampo            = layFormulario[ xE ];
        					var lstNombre           = lobCampo.name;
                    		var lnuCampo            = lobCampo.value;
        					
        					var layDatosNombre         = lstNombre.split( '_' );
        					var lstCampo               = layDatosNombre[0];
        					    lnuCampo               = parseFloat (lnuCampo); 
        						
        					if (lstCampo == 'total'){
        						Calculartotal =  Calculartotal + lnuCampo;
                             }
               				if (lstCampo == 'baseiva'){
               					CalcularBIva =  CalcularBIva + lnuCampo;
                             }
                            if (lstCampo == 'tarifacero'){
                            	CalcularBase =  CalcularBase + lnuCampo;
                             } 
                            if (lstCampo == 'montoiva'){
                            	CalcularIva =  CalcularIva + lnuCampo;
                              } 
       } 
         
       // total
        Calculartotal = parseFloat(Calculartotal.toFixed(2));  
        
  	   $('#TotalF').html('<b>'+ Calculartotal + '</b>'); 
  	   
  	    $('#ver_pago').html('<b>A PAGAR $ '+ Calculartotal + '</b>'); 
       // iva
  	   CalcularIva = parseFloat(CalcularIva.toFixed(2));  
       $('#Iva').html(CalcularIva); 
       // ----
       CalcularBIva = parseFloat(CalcularBIva.toFixed(2));  
       $('#baseI').html(CalcularBIva); 
       // ----
       CalcularBase = parseFloat(CalcularBase.toFixed(2));  
      
       $('#total_pago').val(Calculartotal);  
      
       tt(Calculartotal);
       
       if (isNaN(CalcularBase)){
    	   $('#Cero').html('0,00');  
        }else{
    	   $('#Cero').html(CalcularBase); 
        }
     
       
  //  } 
 
  return true;
}
function EliminarDet(id) {
	 
	
	var estado    	  = $('#estado').val();
	
	var id_movimiento = $('#id_movimiento').val();
	
	if (id){
		
		var parametros = {
				"id" : id ,
                "accion" : 'eliminar' ,
                "id_movimiento": id_movimiento,
                "estado": estado
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-addFacturaSer.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivProducto").html('Procesando');
				},
				success:  function (data) {
						 $("#DivProducto").html(data);  // $("#cuenta").html(response);
						 
						 DetalleMov(id_movimiento,'edit');
					     
				} 
		}); 
			
		 
			
		 	 $('#idproducto').val('');
		 	 
			 $('#CodBarra').val('');
			 
			 $('#articulo').val('');

	
	
	}else{
	
		alert('No se puede eliminar');

	}
}	

//-----------------
function PictureArticulo(id)
{
 
	var objeto 					 =  '#tipourl_' + id;
	var tipourl 				  = $(objeto).val();
	
	objeto 					 =  '#url_' + id;
	var url 				  = $(objeto).val();	
	
 
	
	var parametros = {
			"tipourl" : tipourl ,
            "url" : url ,
            "id" : 'id' 
	};
	
	$.ajax({
 			 url:   '../controller/Controller-picture_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticulo").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-----------------
function Refarticulo(nombre)
{
 
 
 
 
	var parametros = {
			"nombre" : nombre  
	};
	
	$.ajax({
 			 url:   '../controller/Controller-categoria_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticulo").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});

}
//-----------------
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id)
{
  
 
 
	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": 'F',
 			"id" : id  
	};
	
	if (estado == 'digitado'){
		
			$.ajax({
		 			 url:   '../model/Model-editproducto.php',
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#DivProducto").html('Procesando');
						},
					success:  function (data) {
							 $("#DivProducto").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	
	}

}


//------------------ aprobacion
function GuardaVariable(idcategoriavar,idcategoria,valor,variable)
{
  
 
	var id_movimiento = $('#id_movimiento').val();
 
 
	var parametros = {
 			"idcategoriavar" : idcategoriavar  ,
			"id_movimiento" : id_movimiento,  
			"idcategoria" : idcategoria  ,
			"valor" : valor  ,
			"variable" : variable  
	};
	
 
		
		if ( id_movimiento > 0 ) {
				
					$.ajax({
				 			 url:   '../model/Model-editfactura_var.php',
				 			data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#GuardaArticulo").html('Procesando');
								},
							success:  function (data) {
									 $("#GuardaArticulo").html(data);  // $("#cuenta").html(response);
								     
								} 
					});
		 
	}

}
//------------
function aprobacion(  ){

	 
  var id 	 		= $('#id_movimiento').val();
  
  var estado  		=  $('#estado').val()  ;
 
  var tipofactura   =  $('#carga').val()  ;
  
  var mensaje =  confirm("¿Desea aprobar la transacción?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"id" : id   ,
	 			"accion" : 'aprobacion',
	 			"tipo"   : 'F',
	 			"tipofactura" : tipofactura
		};
		
		if (estado == 'digitado'){
			
			if ( id > 0 ) {
				
				$.ajax({
			 			 url:   '../model/Model-ven_factura.php',
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
			else {
				alert('Guarde la informacion de la transaccion');
			}
		} else {
			alert('Guarde la informacion de la transaccion');
		}
	 
	 
  }
 
 
}
//-------------------
function impresion(url){        
	
	var variable    = $('#id_movimiento').val();
   
    var posicion_x; 
    var posicion_y; 
    var enlace = url + variable
    var ancho = 1000;
    var alto = 560;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------
function openView(url){        
	
 
   
    var posicion_x; 
    var posicion_y; 
    var enlace = url  
    var ancho = 1000;
    var alto = 420;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }


//---  $formulario_impresion = '../../reportes/reporteInv?a='  url_comprobante('../../reportes/reporteInv?a=');
 
function url_comprobante(url){        
	
 
	  var estado  =  $('#estado').val()  ;
	 
 
			if (estado == 'aprobado'){
	
	
					var variable    = $('#id_movimiento').val();
				   
				    var posicion_x; 
				    var posicion_y; 
				    
				    var enlace = url + '&codigo='+variable  ;
				    
				    var ancho = 1000;
				    
				    var alto = 520;
				   
				    if ( variable > 0 ) {
				    	
				    posicion_x=(screen.width/2)-(ancho/2); 
				    
				    posicion_y=(screen.height/2)-(alto/2); 
				    
				    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
    
				    }
			 }
 
 }
//-----
function tt(Calculartotal){   
	
	  var CalcularBase = parseFloat(Calculartotal.toFixed(2));  
	  
	  $('#ver_pago').html('<b>A PAGAR $ '+ CalcularBase + '</b>'); 	
	  
	   $('#xx').val(CalcularBase);
	  
}

//-----------------------------------------

function myFunction(codigo,objeto)

{
 
	   var accion = 'check';

	   var estado = '';
 	   
 	    if (objeto.checked == true){
 	    	estado = 'S'
 	    } else {
 	    	estado = 'N'
 	    }

 	    var parametros = {
 				'accion' : accion ,
                'id' : codigo ,
                'estado':estado
 	     };

 
        $.ajax({

				data:  parametros,
 				url:   '../model/ajax_factura_bandera.php',
 				type:  'GET' ,
 				cache: false,
 				beforeSend: function () { 
 							$("#ViewPendiente").html('Procesando');

					},
 				success:  function (data) {
 						 $("#ViewPendiente").html(data);   
 
					} 

		}); 
 

}
