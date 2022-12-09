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
	       
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     
	  

 
	     
	   
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
	
    var idbandera =   $('#banderadd').val();
    
    
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		 
              		
			  		$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
			  		
			  		 AsignaBodega();
			  		 
			  		
			  		 
                      LimpiarPantalla();
                      
                      if (idbandera == '0') {
                    	  $('#banderadd').val('1') ;
                      }
                      else{   
		                    $('#demo').each(function() {
		                          $(this).collapse('hide');
		              		});
                      }
           
                     
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			
			$("#FacturaElectronica").html('');
			
			return false	  ;
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
					url:   '../model/Model-inv_factura.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
	  
	  pagoshow(0);

	  $("#FacturaElectronica").html('');
	  
	  
	  
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
		 
  	   $('#div_sucambio').html('0,00');  
     
	 }else{
  	   $('#div_sucambio').html('<b>Su Cambio es: '+ CalcularPago + '</b>'); 
     
	 }
	
	
	
}

//--- oculta tipo
function tipopagoshow(tipo) {
	 
	if (tipo == 'efectivo'){
		pagoshow(0);	
	}else{
		pagoshow(1);	
		if (tipo == 'cheque'){
			DatoBanco(1);
		}else{
			DatoBanco(0);
		}
 	}
 
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
 
	$("#estado").val("digitado");
	
	$("#ver_pago").html("$");
	
	$("#ver_factura").html("NRO.");
	 
	
	$("#div_sucambio").html('');
	
	
	pagoshow(0);
 	
	DetalleMov(0,'add');

	
	
	
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
            var  fecha2     = $("#fecha2").val();
           
 
         
            var parametros = {
					'estado' : estado , 
                    'cajero' : cajero  ,
                    'fecha1' : fecha1  ,
                    'fecha2' : fecha2
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_factura.php',
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
                                '<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-remove"></i></button> &nbsp;' +
								'<button title ="Actualizar estado Factura Electrónica" class="btn btn-xs" onClick="javascript:goToURLElectronico('+"'electronica'"+','+ s[i][9] +')">' +
								'<i class="glyphicon glyphicon-globe"></i></button>'
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
  function goToURLElectronico(accion1,id) {
	 	 
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
   
  //-----------------------
  function goToURLElectronicoTool(accion1) {
	
	  
	  var posicion_x; 
      var posicion_y; 
 
      var id 	 = $('#id_movimiento').val();
      
       
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
				 				     
				 				} 
				 	});
				      
				 	alert('Factura Emitida');
				 	
				 	var parametrosf = {
							    'id' : id 
				    };
 	  
				  	//------------------------------------------------------------
					$.ajax({
							data:  parametrosf,
							 url:   '../../facturae/autoriza_factura.php',
							type:  'GET' ,
							success:  function (data) {
								$("#FacturaElectronica").html(data); 
								     
								} 
					});
     }
 
 
}
 
  //-----------------------
  function goToURLElectronicoActualiza(accion1) {
	
	  //------------------ impresion ---------------
	  var posicion_x; 
      var posicion_y; 
      var enlace; 
      var ancho = 720; 
      var alto = 550; 
    
      var id  =   $('#id_movimiento').val();
 
      if ( id > 0 ) {
      
		      var url = '../../facturae/factura_electronica.php';
		     			
		      posicion_x=(screen.width/2)-(ancho/2); 
		      
		      posicion_y=(screen.height/2)-(alto/2); 
		      
		      enlace = url + '?id='+ id;
		      
		      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	  
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
   
 	 $("#ViewForm").load('../controller/Controller-inv_punto.php');

 
}
//-------------------------------------
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
     

	 $("#DivProductoDisponible").load('../model/Model-lista-mi-producto.php');
	 
}
//--------------------- PrecioArticulo
function PrecioArticulo(idproducto,id)
{
 
   
    var parametros = {
            'idproducto' : idproducto ,
            'id' : id
    };
    
    
	$.ajax({
 			 url:   '../model/inv_punto_precios.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticuloPrecios").html('Procesando');
				},
			 success:  function (data) {
					 $("#VisorArticuloPrecios").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//--------------actualiza_unidad
function actualiza_unidad(detalle,idproducto)
{
 
   
    var parametros = {
            'idproducto' : idproducto ,
            'detalle' : detalle
    };
    
    
	$.ajax({
 			 url:   '../model/Model-editUnidad.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticuloPrecios").html('Procesando');
				},
			 success:  function (data) {
					 $("#VisorArticuloPrecios").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//----- 
function ActualizaPrecio(id,monto,detalle,idproducto)
{
 
	
	var objetou 					 =  '#unidad_' + id;
    
	$(objetou).html(detalle);
	
	var estado = $('#estado').val();
	 
    actualiza_unidad(detalle,idproducto);
	
	var costo 					 =   monto;
	
	var objeto 					 =  '#costo_' + id;
	
	$(objeto).val(monto);
	
	if (costo   >  0) {
	
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
			
			var	IVA 			= 12/100; 
			var	DesgloseIVA 	= 1 + IVA ; 
		
			objeto =  '#tipo_' + id;
			var tipo_mov1 = $(objeto).val();
			var tipo_movimiento = $.trim(tipo_mov1);
			//---------------- egresos --------------------------------------------
		 	
			if ( (saldo * 10) >= (lcantidad *10) ) { 	   
				 
				 
				if ( tipo_movimiento  == 'I'){
					 
					baseiva     =  total / DesgloseIVA ;
		 			tarifa_cero =  0;
					monto_iva   =  total   -  baseiva ;
					 
					//----------------- ASIGNA
					objeto =  '#baseiva_' + id;
				 	$(objeto).val(baseiva);
				 	objeto =  '#tarifacero_' + id;
				 	$(objeto).val(tarifa_cero);
				 	objeto =  '#montoiva_' + id;
				 	$(objeto).val(monto_iva);
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
				
			  }else{
				  alert('Saldo No Disponible');
		 		  objeto =  '#cantidad_' + id;
				  $(objeto).val(0);
			  }
	 
 //------------------------------------------------------------------
 	
	  }		   

	 $('#myModalPrecio').modal('hide');  
}
//-----------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_movimiento').val(id); 
	  
	DetalleMov(id,action);

	BusquedaGrilla(oTable);
	
}
//-----------------
function acciona(comprobante_dat, estado)
{
 
	$('#comprobante').val(comprobante_dat); 
	
	$('#ver_factura').html('NRO. ' + comprobante_dat); 
 	
	
	$('#estado').val(estado);
 
	BusquedaGrilla(oTable);

}
//----------------------
function FormFiltro()
{
 
	
	 $("#ViewFiltro").load('../controller/Controller-inv_fac_filtro.php');
	 
 
     

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
//----------------------
function InsertaProducto()
{

	var id_movimiento = $('#id_movimiento').val();
	
 	var idproducto    = $('#idproducto').val();
	
	var estado  = $.trim( $('#estado').val() );
  	
 	var tipo    = 'F';
 	
	if (idproducto){
		
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
								url:   '../model/Model-addFactura.php',
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
	
		alert('Guarde información de la solicitud');

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
								url:   '../model/Model-addFactura.php',
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
//
//------------ INSERTA CON CODIGO DE BARRAS     
function inserta_dfacturacodigo()
	{
	 

	    var  idbarra = $('#idbarra').val();
 
		var id_movimiento = $('#id_movimiento').val();
		 
		var estado  = $.trim( $('#estado').val() );
		
		var tipo    = 'F';
		
	 
			if (estado == 'digitado'){ 
				
				
				if(idbarra){ 
	    
				
						var parametros = {
								"idbarra" : idbarra ,
				                "id_movimiento" : id_movimiento ,
				                "estado" : estado,
				                "tipo" : tipo,
				                "accion" : 'add' 
						};
								 
							          
									  $.ajax({
											data:  parametros,
											url:   '../model/Model-addFacturabarra.php',
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
	
	 $('#idbarra').val('');
	 
     $('#idbarra').focus();
	
	  
	
	
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
	
	if (costo   >  0) {
	
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
			
			var	IVA 			= 12/100; 
			var	DesgloseIVA 	= 1 + IVA ; 
		
			objeto =  '#tipo_' + id;
			var tipo_mov1 = $(objeto).val();
			var tipo_movimiento = $.trim(tipo_mov1);
			//---------------- egresos --------------------------------------------
		 	
			if ( (saldo * 10) >= (lcantidad *10) ) { 	   
				 
				 
				if ( tipo_movimiento  == 'I'){
					 
					baseiva     =  total / DesgloseIVA ;
		 			tarifa_cero =  0;
					monto_iva   =  total   -  baseiva ;
					 
					//----------------- ASIGNA
					objeto =  '#baseiva_' + id;
				 	$(objeto).val(baseiva);
				 	objeto =  '#tarifacero_' + id;
				 	$(objeto).val(tarifa_cero);
				 	objeto =  '#montoiva_' + id;
				 	$(objeto).val(monto_iva);
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
				
			  }else{
				  alert('Saldo No Disponible');
		 		  objeto =  '#cantidad_' + id;
				  $(objeto).val(0);
			  }
	 
 //------------------------------------------------------------------
 	
	  }		
 
}
 //----------------
function calcularT(id) {
    
	var estado = $('#estado').val();
 
	/// COSTO
			var objeto;
	 
			/// CANTIDAD
			objeto =  '#cantidad_' + id;
			var cantidad 			     =  $(objeto).val();
			var	lcantidad                = parseFloat (cantidad).toFixed(2);
		
			//----------------------------------------------------------------
			objeto =  '#saldo_' + id;
			var sal1 =  $(objeto).val();
			var saldo = parseFloat (sal1).toFixed(2);
			//----------------------------------------------------------------
			
		
			var	baseiva; 
			var	tarifa_cero; 
			var	monto_iva; 
			var tempBase;
			
			var	IVA 			= 12/100; 
			var	DesgloseIVA 	= 1 + IVA ; 
		
			var	IVA_dato 			= 112/100; 
			
			objeto =  '#tipo_' + id;
			var tipo_mov1 = $(objeto).val();
			var tipo_movimiento = $.trim(tipo_mov1);
			//---------------- egresos --------------------------------------------
			var	total; 
 			
			objeto =  '#total_' + id;
			total  =  $(objeto).val();
			
			var	lcosto                   = total / lcantidad;
			precio 						 = parseFloat (lcosto).toFixed(2);
			
			objeto 					 =  '#costo_' + id;
			$(objeto).val(precio);
		 	  
		 	
			if ( (saldo * 10) >= (lcantidad *10) ) { 	   
				 
				 
				if ( tipo_movimiento  == 'I'){
					 
					monto_iva = ( precio - (precio / IVA_dato) ) * lcantidad;
				    baseiva     =  total - monto_iva ;
		 			tarifa_cero =  0;
					 
					 
					//----------------- ASIGNA
					objeto =  '#baseiva_' + id;
				 	$(objeto).val(baseiva);
				 	objeto =  '#tarifacero_' + id;
				 	$(objeto).val(tarifa_cero);
				 	objeto =  '#montoiva_' + id;
				 	$(objeto).val(monto_iva);
				 	 
		 	     }else{
					baseiva     =  0 ;
					tarifa_cero =  precio * lcantidad;
					monto_iva   =  0;
					 
					//----------------- ASIGNA
					objeto =  '#baseiva_' + id;
				 	$(objeto).val(baseiva);
				 	objeto =  '#tarifacero_' + id;
				 	$(objeto).val(tarifa_cero);
				 	objeto =  '#montoiva_' + id;
				 	$(objeto).val(monto_iva);
				  
				}
			  	
			 	//--------------------------------
			 	 guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,'F',id);
			 	
				total_factura();
				
			  }else{
				  alert('Saldo No Disponible');
		 		  objeto =  '#cantidad_' + id;
				  $(objeto).val(0);
			  }
	 
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
  	   
  	    $('#ver_pago').html('$ '+ Calculartotal ); 
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
				url:   '../model/Model-addFactura.php',
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

function aprobacion(  ){

	 
  var id 	  = $('#id_movimiento').val();
  var estado  = $.trim( $('#estado').val() );
 
  var efectivo  =  $('#efectivo').val()  ;
  var idprov    =  $.trim( $('#idprov').val() );
  
  

  if (idprov) {
	  
	  if (efectivo > 0) {
	  
		  var mensaje =  confirm("¿Desea aprobar la transacción?");
		  
		  if (mensaje) {
			 
			 var parametros = {
			 			"id" : id   ,
			 			"accion" : 'aprobacion',
			 			"tipo"   : 'F'
				};
				
				if (estado == 'digitado'){
					
						$.ajax({
					 			 url:   '../model/Model-inv_factura.php',
					 			data:  parametros,
								type:  'GET' ,
									beforeSend: function () { 
											$("#result").html('Procesando');
									},
							    	success:  function (data) {
							    		
										 $("#result").html(data);  // $("#cuenta").html(response);
										 
										 url_comprobante('../../reportes/reporteInv?tipo=51');
									     
									} 
						});
				
				} 
 		 }	 
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
//-----
function tt(Calculartotal){   
	
	  var CalcularBase = parseFloat(Calculartotal.toFixed(2));  
	  
	  $('#ver_pago').html('$ '+ CalcularBase  ); 	
	  
	   $('#xx').val(CalcularBase);
	  
}


