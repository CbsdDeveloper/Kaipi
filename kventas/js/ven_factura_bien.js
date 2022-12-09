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
     
	 
	 	 
        oTable = $('#jsontable').dataTable(); 
	       
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
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
			return false	  
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


  $('#idprov').val('9999999999999');
  $('#razon').val('CONSUMIDOR FINAL');
  $('#correo').val('info@info.com');
	
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
  	   $('#div_sucambio').html('Su Cambio es: '+ CalcularPago); 
     
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
 
	$("#idproducto").val("");
	$("#idbarra").val("");
	$("#articulo").val("");
 	$("#efectivo").val(0);
 	
 	$("#detalle").val("Facturacion");
 	
 	  $('#idprov').val('9999999999999');
 	  $('#razon').val('CONSUMIDOR FINAL');
 	  $('#correo').val('info@info.com');
 		
 	  
 	
 	$("#action").val("add");
 	$("#estado").val("digitado");
	$("#ver_pago").html("A PAGAR $ ");
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
                         '<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-remove"></i></button> &nbsp;' +
							'<button title ="Actualizar estado Factura Electrónica" class="btn btn-xs" onClick="javascript:goToURLElectronico('+"'electronica'"+','+ s[i][9] +')">' +
							'<i class="glyphicon glyphicon-globe"></i></button> &nbsp;' +
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
 function goToURLElectronico(accion1,id) {
 	 
	 
	  var posicion_x; 
     var posicion_y; 

     
     posicion_x=(screen.width/2)-(230/2); 
     posicion_y=(screen.height/2)-(100/2); 
     
       
     var enlace = '../view/envio_fac?id='+ id;  

     window.open(enlace, '#','width='+230+',height='+100+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
	  

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
 
//-----------------------
 function goToURLElectronicoTool(accion1) {
	
	  
	  var posicion_x; 
     var posicion_y; 

     var id 	 = $('#id_movimiento').val();
     
     posicion_x=(screen.width/2)-(230/2); 
     posicion_y=(screen.height/2)-(100/2); 
     
       
     var enlace = '../view/envio_fac_tool?id='+ id;  

     window.open(enlace, '#','width='+230+',height='+100+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
     
     


	   }
 
 function goToURLElectronicoActualiza(accion1) {
		
	  
	  var posicion_x; 
     var posicion_y; 

     var id 	 = $('#id_movimiento').val();
     
     posicion_x=(screen.width/2)-(450/2); 
     posicion_y=(screen.height/2)-(200/2); 
     
       
     var enlace = '../view/envio_fac_actual?id='+ id;  

     window.open(enlace, '#','width='+450+',height='+200+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');


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
   
 	 $("#ViewForm").load('../controller/Controller-ven_factura_bien.php');

 
 	 
}
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
	
	var	IVA 			= 12/100; 
	var	DesgloseIVA 	= 1 + IVA ; 

	objeto =  '#tipo_' + id;
	var tipo_mov1 = $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	//---------------- egresos --------------------------------------------
 	
	 
		 
		 
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

function aprobacion(  ){

	 
  var id 	 = $('#id_movimiento').val();
  var estado  = $.trim( $('#estado').val() );
 
 
  
  var mensaje =  confirm("¿Desea aprobar la transacción?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"id" : id   ,
	 			"accion" : 'aprobacion',
	 			"tipo"   : 'F'
		};
		
		if (estado == 'digitado'){
			
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
	  
	  $('#ver_pago').html('<b>A PAGAR $ '+ CalcularBase + '</b>'); 	
	  
	   $('#xx').val(CalcularBase);
	  
}


