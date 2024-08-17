/* Funciones JavaScript
   Version 1.1
   Autor: jasapas
   Tema: Formulario para recaudacion de cajas
*/
var oTable;
var moduloOpcion =  'kservicios';

 
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
// Asignacion e inicializacion de datos
$(document).ready(function(){
 		
		var prodId 	= getParameterByName('id');
		
		 oTable 	= $('#jsontable').dataTable(); 

		 

		 oTable_externo 	= $('#jsontable_externo').dataTable(); 
		 oTableCapacitaciones_externo 	= $('#jsontablecapacitaciones_externo').dataTable(); 
 		
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		$("#FormPie").load('../view/View-pie.php');
  		
		$("#ViewFiltro").load('../controller/Controller-ren_caja_filtro.php');
		
		
		modulo();
		
		FormView(prodId);
	    
			 
     
         
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
  
	 	
});  
//--------------------------------------------------------------------------------
function BusquedaGrilla(oTable){        
	 
	   
	var user         = $(this).attr('id');
    var  estado	     = $("#estado1").val();
    var  cajero      = $("#cajero").val();
    var  fecha1      = $("#fecha1").val();
    var  fecha2      = $("#fecha2").val();
 
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
	    url: '../grilla/grilla_ren_caja.php',
		dataType: 'json',
		success: function(s){
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
						'<button title ="REVERSAR TITULO EMITIDO DE PAGO"    class="btn btn-xs btn-danger" onClick="goToURLDel('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button> &nbsp;' +
 						'<button title ="DESCARGAR IMPRIMIR TITULO DE PAGO"  class="btn btn-xs btn-info" onClick="goToURreporte('+s[i][7]+','+ s[i][0] +')">' +
						'<i class="glyphicon glyphicon-download-alt"></i></button> &nbsp;'  +
						'<button title ="EMITIR COMPROBANTES ELECTRONICOS"  data-toggle="modal" data-target="#myModalFac_view" class="btn btn-xs btn-success" onClick="goToLista('+ s[i][0] +')">' +
						'<i class="icon-globe icon-white"></i></button> &nbsp;'
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
//------------------------------------------------------------------
function loadCiu( ){
	
	 var prodId = 	$("#id_par_ciu").val();
	 
	 DetalleMov(prodId);
	 
}
//------------------------------------------------------------------
function anular() {

   var id_par_ciu = $("#id_par_ciu").val();  
    
   var id_renpago = $("#id_renpago").val(); 
  
   $('#estado').val('anular')  ;
 
   var parametros = {
					 'accion' : 'anular' ,
	                 'id' : id_renpago  
   };
	  
   alertify.confirm("Anular Registro " +id_renpago , function (e) {
				  if (e) {
		   		 
					  $.ajax({
							data:  parametros,
							url:   '../model/Model-ren_cajas.php',
							type:  'GET' ,
							beforeSend: function () { 
									$("#ViewCuenta").html('Procesando');
							},
							success:  function (data) {
								
									 $("#ViewCuenta").html(data);   

									  DetalleMov(id_par_ciu );
							} 
					}); 
  			  }
 		 }); 	  	 
	  } 
//------------------------------------------------------------------ 
function goToURLDel(accion1,id) {

	  var id_par_ciu = $("#id_par_ciu").val();  
	  var cierre = 	$("#estado1").val();

	  var parametros = {
					 'accion' : accion1 ,
	                 'id' : id 
		  };
	  
	  
	  if ( cierre == 'N'){
		
			  alertify.confirm("Reversar Registro " +id , function (e) {
				  if (e) {
  					  $.ajax({
							data:  parametros,
							url:   '../model/Model-ren_cajas.php',
							type:  'GET' ,
							beforeSend: function () { 
									$("#ViewCuenta").html('Procesando');
							},
							success:  function (data) {
 									 $("#ViewCuenta").html(data);  
 									  DetalleMov(id_par_ciu);
							} 
					}); 
  			  }
 		 }); 	  	 
	  }else{
				  alert('No se puede Reversar este pago...');
	  }
 
 }
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
          	
            LimpiarPantalla();
			DetalleMov(0);
 			$("#action").val("add");
 			$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
 	  }
	 }); 
	}
	if (tipo =="alerta"){			 
	  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
	  });
	 }		  
	return false	  
   }
//-----------------------------------------------------------------
function LimpiarPantalla() {
	   
	var fecha = fecha_hoy();
	
	$("#action").val("add");
 	$("#id_par_ciu").val("");
	$("#idprov").val("");
	$("#razon").val("");
	$("#direccion").val("");
	$("#correo").val("");
	$("#id_renpago").val("");
	$("#efectivo").val("0.00");
	$("#pagado").val("0.00");
	$("#fecha_pago").val(fecha);


 
}
/*
*/
function myFunctionIVA(emision_iva) {
	$("#emision_iva").val(emision_iva);
}
//-----------------------------------------------------------------   
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
//-----------------------------------------------------------------
function modulo()
{
 
	
		 
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
//-----------------------------------------------------------------
function DetalleMov(id_movimiento)
{
 
    var parametros = {
            'id' : id_movimiento,  
    };
    
	$.ajax({
 			url:   '../controller/Controller-ren_caja_detalle.php',
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
//-----------------------------------------------------------------
function myFunction(codigo,objeto)
{
	   var accion 		= 'resumen';
	   var estado 		= '';
	   var id_par_ciu 	= $("#id_par_ciu").val();  

	    if (objeto.checked == true){
	    	estado = '1';
	    } else {
	    	estado = '0';
	    }

 	    var parametros = {
 	    		'id_par_ciu' : id_par_ciu,
				'accion' : accion ,
                'id' : codigo ,
                'estado':estado

	  };
 	    
 	 
 	  $.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/ajax_ren_emision_seleccion.php',
									dataType: "json",
									success:  function (response) {
											 $("#pagado").val( response.a );  
									} 
							});
   
}
//-----------------------------------------------------------------
function cambio_dato(monto_pagado) {
	
	 var tt1    		= $('#pagado').val();
	 var total 			= monto_pagado - parseFloat (tt1).toFixed(2);
	 var CalcularPago 	= parseFloat(total.toFixed(2));  
 	 
	if ( tt1 > 0 )   {
		
		 if (isNaN(CalcularPago)){
	  	   $('#div_sucambio').html('<h3><b>0.00</b></h3>');  
		 }else{
	  	   $('#div_sucambio').html('<h3><b>Su Cambio es: '+ CalcularPago+'</b></h3>'); 
		 }
	}	 
    else{
    	  $('#div_sucambio').html('<h4>Seleccione a pagar !!!</h4>');  
    }
	
}
//-----------------------------------------------------------------
function fecha_hoy()
{
  
   var today 	= new Date();
   var dd 		= today.getDate();
   var mm 		= today.getMonth()+1; //January is 0!
   var yyyy 	= today.getFullYear();
   
   if(dd < 10){
       dd='0'+ dd
   } 
   if(mm < 10){
       mm='0'+ mm
   } 
   var today = yyyy + '-' + mm + '-' + dd;
   
return today;
           
} 
//-----------------------------------------------------------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_renpago').val(id); 
	  
  
}
//----------- 
function goToLista(idpago)
{
 
	var estado1 =  $('#estado1').val();

  	var parametros = {
			"idpago" : idpago  
	};
 

		$.ajax({
				url:   '../model/ajax_ren_visor_factura.php',
				data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#lista_datos").html('Procesando');
					},
				success:  function (data) {
						$("#lista_datos").html(data);   
						
					} 
		});
	 
}
//-----------------------------
function Refarticulo(id_emision)
{
 
  	var parametros = {
			"id_emision" : id_emision  
	};
	
	$.ajax({
 			 url:   '../controller/Controller-ren_detalle_dato.php',
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
///------------------------------------
function goToURreporte(id_par_ciu,variable){        
	
	 
 
	 //  var url ='../../reportes/titulo_credito_cobro.php?tipo=51';


	 var url ='../../reportes/reporte_caja?tipo=51';
		   
	    var posicion_x; 
	    var posicion_y; 
	    
	       var enlace = url + '&codigo='+variable + '&id='+id_par_ciu  ;
	    
	    var ancho = 1000;
	    
	    var alto = 520;
	   
	    	
	    posicion_x=(screen.width/2)-(ancho/2); 
	    
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');


}
//------------
/// me conecto con el otro sistema....
function BuscaExterno(  ){

	    
	$.ajax({
 	   url: '../model/ajax_bomberos_tramites.php',
	   dataType: 'json',
	   success: function(s){
		oTable_externo.fnClearTable();
			   if(s ){ 
				   for(var i = 0; i < s.length; i++) {
					oTable_externo.fnAddData([
					   s[i][0],
					   s[i][1],
						s[i][2],
						s[i][3],
					 s[i][4],
					s[i][5],
						'<button title ="SELECCIONAR REGISTRO A PAGAR"  class="btn btn-xs btn-info" onClick="AsignaExterno('+s[i][0]+','+ "'"+ s[i][2] +"'," +"'"+ s[i][3] +"'," + "'" +s[i][6] +"',"+ "'"+ s[i][7]+"'"+')">' +
 					   '<i class="icon-globe icon-white"></i></button> &nbsp;'
				   ]);										
			   } // End For
		   }						
	   },
	   error: function(e){
		  console.log(e.responseText);	
	   }
	   });
 
   
  }

  function BuscaCapacitacionesExterno(  ){

	    
	$.ajax({
 	   url: '../model/ajax_bomberos_capacitaciones.php',
	   dataType: 'json',
		success: function(s){
			oTableCapacitaciones_externo.fnClearTable();
			if(s ){ 
				for(var i = 0; i < s.length; i++) {
					oTableCapacitaciones_externo.fnAddData([
					s[i][0],
					s[i][1],
					s[i][2],
					s[i][3],
					s[i][4],
					s[i][5],
					'<button title ="SELECCIONAR REGISTRO A PAGAR"  class="btn btn-xs btn-info" onClick="AsignaExterno('+s[i][0]+','+ "'"+ s[i][2] +"'," +"'"+ s[i][3] +"'," + "'" +s[i][6] +"',"+ "'"+ s[i][7]+"'"+')">' +
					'<i class="icon-globe icon-white"></i></button> &nbsp;'
					]);										
				} // End For
			}						
		},
	   error: function(e){
		  console.log(e.responseText);	
	   }
	   });
 
   
  }

  function GuardarRecaudacionManual(){
	// obteniendo campos requeridos
	var idprov = $('#persona_cedula').val();
	var capacitacion_codigo = $('#capacitacion_codigo').val();
	var persona_apellidos = $('#persona_apellidos').val();
	var persona_nombres = $('#persona_nombres').val();
	var persona_direccion = $('#persona_direccion').val();
	var persona_razon = $('#persona_razon').val();
	var capacitacion_motivo = $('#capacitacion_motivo').val();
	var orden_monto = +$('#orden_monto').val();

	// validar campos
	if (capacitacion_codigo.length == 0 ) { alert("Ingrese un código de trámite por favor, normalmente se encuentra en la orden de cobro!!!"); return; }
	if (idprov.length != 10 && idprov.length != 13 ) { alert("Número de idenficación debe tener 10 o 13 dígitos, por favor corregir e intentar nuevamente!!!"); return; }
	if (isNaN(idprov) ) { alert("Número de idenficación debe tener solo números, normalmente se encuentra en la orden de cobro!!!"); return; }
	if (persona_razon.length == 0 ) { alert("Ingrese la razón social del solicitante, normalmente se encuentra en la orden de cobro!!!"); return; }
	// if (persona_apellidos.length == 0 ) { alert("Ingrese los apellidos del solicitante, normalmente se encuentra en la orden de cobro!!!"); return; }
	// if (persona_nombres.length == 0 ) { alert("Ingrese los nombres del solicitante, normalmente se encuentra en la orden de cobro!!!"); return; }
	if (persona_direccion.length == 0 ) { alert("Ingrese una dirección del solicitante!!!"); return; }
	if (capacitacion_motivo.length == 0 ) { alert("Ingrese el motivo de la orden de cobro, normalmente se encuentra en la orden de cobro!!!"); return; }
	if (typeof orden_monto === 'number') {
		orden_monto = orden_monto.toFixed(2);
	} 
	if (orden_monto <= 0) {
		alert("Ingrese un valor de monto válido y mayor a $ 0.00, normalmente se encuentra en la orden de cobro!!!"); return;
	}

	// envio de datos para creacion de registro
	var parametros = {
		'idprov': idprov,
		'orden_id': 0,
		'orden_codigo': capacitacion_codigo,
		'orden_cliente_apellidos': persona_apellidos,
		'orden_cliente_nombres': persona_nombres,
		'orden_direccion': persona_direccion,
		'orden_cliente_nombre': persona_razon,
		'orden_concepto': capacitacion_motivo,
		'orden_monto': orden_monto
	};

	$.ajax({
		type:  'GET' ,
		data:  parametros,
		url:   '../model/ajax_ren_emision_manual.php',
		dataType: "json",
		success:  function (response) {
			$("#id_par_ciu").val( response.a);  
			$('#idprov').val(response.idprov);
			$('#razon').val(response.razon);
			$('#direccion').val(response.direccion);
			$('#correo').val(response.correo);
			DetalleMov(response.a);
			$("#myModalTramiteNuevo").modal('hide');
		} 
	});

  }

//---------------------  
// AsignaExterno(12,'0500825534','MENA MENA JOSE','josmen1954@hotmail.com','SAN JACINTO DEL BUA, CALLE 16 DE AGOSTO Y CALLE JUAN BENIGNO VELA')
function AsignaExterno(codigo,ruc,nombre,correo,direccion){        
	
	 
	$('#idprov').val(ruc);
	$('#razon').val(nombre);
	$('#direccion').val(direccion);
	$('#correo').val(correo);
	 

	var parametros = {
	   'accion' : 'agregar' ,
	   'id' : codigo ,
	   'idprov' : ruc
};
 
		$.ajax({
			type:  'GET' ,
			data:  parametros,
			url:   '../model/ajax_ren_emision_externo_b.php',
			dataType: "json",
			success:  function (response) {
				
					$("#id_par_ciu").val( response.a );  
					
					DetalleMov(response.a  );
					
			} 
		});

 

 
	$("#myModalExterno").modal('hide');
	
 
}
//----------------------------------------
function url_comprobante(url){        
	
	 
 
	               var id_par_ciu = $("#id_par_ciu").val();  
	
					var variable    = $('#id_renpago').val();
				   
				    var posicion_x; 
				    var posicion_y; 
				    
				    var enlace = url + '&codigo='+variable + '&id='+id_par_ciu  ;
				    
				    var ancho = 1000;
				    
				    var alto = 520;
				   
 				    	
				    posicion_x=(screen.width/2)-(ancho/2); 
				    
				    posicion_y=(screen.height/2)-(alto/2); 
				    
				    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  

                    DetalleMov(id_par_ciu );
		 
}
//--------------

function url_e(url){        
	
	 
	window.open(url, '_self')
	
 
}
//------------
function aprobacion(  ){

	 
  var id_par_ciu = $("#id_par_ciu").val();  
  var pagado       = $("#pagado").val();
  var efectivo     = $("#efectivo").val();

  var bandera     =  0;

  var v1 = parseFloat(pagado).toFixed(2)  ;
  var v2 = parseFloat(efectivo).toFixed(2)  ;

  var id_renpago = $("#id_renpago").val(); 
  
  $('#estado').val('aprobacion')  ;

  if ( pagado > 0 ) {
	  bandera = 1;
  }

  if ( v2 >= v1 ) {
	bandera = 1;
}

 
   
  var mensaje =  confirm("¿Desea aprobar la transacción?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"id_par_ciu" : id_par_ciu   ,
	 			"action" : 'aprobacion',
			    "id_renpago": id_renpago
		};
		
	 
	 if ( id_renpago > 0 ) {
		
		 			if ( bandera > 0 ) {
		 						$.ajax({
							 			 url:   '../model/Model-ren_cajas.php',
							 			data:  parametros,
										type:  'POST' ,
											beforeSend: function () { 
													$("#result").html('Procesando');
											},
									    	success:  function (data) {
												 $("#result").html(data); 
												 $('#estado').val('fin')  ;
												 alert("Datos Procesados Correctamente... ");
												 
									        } 
								});
			 		} else {
						alert('Guarde la informacion de la transaccion');
					}
	  } else {
			alert('Guarde la informacion de la transaccion');
		}	
 
 }	 
 
 
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

///----------------------------
function FormaPago(tipo)
{
	
	/*  '-'    => ' [ Seleccione Forma de Pago ] ',
                    'efectivo'    => 'Efectivo',
                    'deposito'    => 'Deposito',
                    'trasferencia'    => 'Trasferencia',
                    'cheque'    => 'Cheque'*/
	
	var fecha  = fecha_hoy();
	var pagado = $("#pagado").val();
	
	if( tipo=='efectivo'){
		
		$("#efectivo").attr("readonly", false);
 		$("#fechadeposito").attr("readonly", true);
 		$("#cuentaBanco").attr("readonly", true);
 		
		$("#idbanco").attr("disabled", true);
		$("#cuentaBanco").val('');
		$("#efectivo").val(pagado);
		$('#div_sucambio').html('');  
 	}

	if( tipo=='deposito'){
		$("#efectivo").attr("readonly", true);
 		$("#fechadeposito").attr("readonly", false);
 		$("#cuentabanco").attr("readonly", false);
 		
		$("#idbanco").attr("disabled", false);
		$("#fechadeposito").val(fecha);
 		$("#efectivo").val(pagado);
 		$('#div_sucambio').html('');  
  	}
 
	if( tipo=='trasferencia'){
		$("#efectivo").attr("readonly", true);
 		$("#fechadeposito").attr("readonly", false);
 		$("#cuentabanco").attr("readonly", false);
 		
		$("#idbanco").attr("disabled", false);
		$("#fechadeposito").val(fecha);
 		$("#efectivo").val(pagado);
 		$('#div_sucambio').html('');  
  	}
       
	if( tipo=='Cheque'){
		$("#efectivo").attr("readonly", true);
 		$("#fechadeposito").attr("readonly", false);
 		$("#cuentabanco").attr("readonly", false);
 		
 		
		$("#idbanco").attr("disabled", false);
		$("#fechadeposito").val(fecha);
 		$("#efectivo").val(pagado);
 		$('#div_sucambio').html('');  
  	}
}
//----------------------------------------------------------------------------------------------
function BuscarDocumento()
{
   
	var doc_busqueda =  $("#doc_busqueda").val();

	var doc_nombre =  $("#doc_nombre").val();
 

	var parametros = {
			    'id' : doc_busqueda  ,
				'doc_nombre' : doc_nombre
    };
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_busca_clave_tramite.php',
			type:  'GET' ,
			success:  function (data) {
				
				  	  $("#Visor_Busqueda").html(data);  
				      
				} 
	});
	
}
function FormView(prodId)
{
   
	var caja = 0;
	
	if (prodId){
 		caja = 1;
		
	}else{
 		prodId = 0;
 	}
 
 
	
	 var parametros = {
			    'id' : prodId ,
			    'caja':caja
  };
	  
		
	  
	$.ajax({
			data:  parametros,
			 url:   '../controller/Controller-ven_caja.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ViewForm").html(data);  
				     
						if (prodId){
							loadCiu();
 						}
					 
				} 
	});
 
  	
}
// limpiar datos de  busqueda
function LimpiarDocumento()
{

	 
	 $("#doc_busqueda").val('');

	 $("#doc_nombre").val('');

	 BuscarDocumento();
}
// asignar variable de busqueda 
function asignar(accion,id_par_ciu)
{

	$("#id_par_ciu").val(id_par_ciu);
 
	var parametros = {
		"id_par_ciu" : id_par_ciu 
};
 
	$.ajax({
			type:  'GET' ,
			data:  parametros,
			url:   '../model/AutoCompleteIDMultipleCiu.php',
			dataType: "json",
			success:  function (response) {

				
					$("#razon").val( response.a );  
					
					$("#correo").val( response.b );  

					$("#idprov").val( response.c ); 

					$("#direccion").val( response.d ); 
			} 
	});
	 
	DetalleMov(id_par_ciu);

	$("#myModalDocumento").modal('hide');
	
	 
}
// asignar variable de busqueda 
function ActualizaCiu()
{
	
	var idprov    =    $("#idprov").val();
	var direccion =    $("#direccion").val();
	var razon     =    $("#razon").val();
	var correo    =    $("#correo").val();

 
	 var parametros = {
 			    'idprov'    : idprov,
 			    'direccion' : direccion,
				'razon'     : razon,
				'correo'    : correo
	 };
	  
    if ( idprov){
	  if ( razon){
 	 	$.ajax({
				data:  parametros,
				url:   '../model/ajax_actualiza_ciu.php',
				type:  'GET' ,
	 			success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	   }	
    }
	
}
