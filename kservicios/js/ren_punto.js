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
     

		$("#ViewFiltroFrecuencias").load('../controller/Controller-clientes_trasporte_view.php');
 


		oTable 	= $('#jsontable').dataTable( {      
			searching: true,
			paging: true, 
			info: true,         
			lengthChange:true ,
			aoColumnDefs: [
				 { "sClass": "highlight", "aTargets": [ 1 ] }
			   ] 
		 } );


		 oTablePendiente 	= $('#jsontablePendidente').dataTable( {      
			searching: true,
			paging: true, 
			info: true,         
			lengthChange:true ,
			aoColumnDefs: [
				 { "sClass": "highlight", "aTargets": [ 1 ] }
			   ] 
		 } );


        
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     
	     $('#loadProceso').on('click',function(){
 	 		 
	          ProcesarInformacion();
	           
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
				 
				$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><span style="padding-top: 3px;font-size: 16px;font-weight:700"> AGREGAR NUEVO REGISTRO</span>');
                	
 			  		
			  		 $("#DivProductoDisponible").load('../model/Model-lista-mi-servicio.php');
			  		 
                      LimpiarPantalla();
       			 	 
                  	$("#FacturaElectronica").html(''); 
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
 
  
	var bandera = 0;

	if (accion1 == 'del'){

		alertify.confirm("<p>Desea anular el comprobante?</p>", function (e) {
			if (e) {
			   
				bandera = 0; 
 			}else {
			   
				bandera = 1; 
			}
		   }); 

	}else{

		$("#FacturaElectronica").html(''); 
		
		pagoshow(0);

	}


	
     var parametros = {
					'accion' : accion1 ,
                    'id' : id 
 	  };


		if (bandera == 0 ){

						$.ajax({
										data:  parametros,
										url:   '../model/Model-ven_factura.php',
										type:  'GET' ,
										beforeSend: function () { 
												$("#result").html('Procesando');
										},
										success:  function (data) {

												$("#result").html(data);   

												 BusquedaGrilla(oTable);
												
										} 
								}); 

								
				
							

				}
  
			
	 

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
	$("#idprov").val("9999999999999");
	$("#razon").val("CONSUMIDOR FINAL");
	$("#idproducto").val("");
	$("#articulo").val("");
 	$("#efectivo").val(0);
 	$("#action").val("add");
 	$("#estado").val("D");
	$("#ver_pago").html("A PAGAR $ ");
	$("#ver_factura").html("NRO.");
	$("#div_sucambio").html('');

	
	$("#carga").val("0");
	
	$("#detalle").val("-");
	
	$("#nombre_cooperativa").html("<b>2. SERVICIOS SELECCIONADOS</b>");
	
 	
	pagoshow(0);

	DetalleMov(0,'add');
	 
	$("#formapago").val("credito");
	
	FormaPago("credito")
	
	$("#ver_factura").html('');   
 
	$("#id_par_ciu").val('18222');
	
	$("#unidad").val('0');
 
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
 
/*
*/
function BusquedaGrilla(oTable){        
	 
	   
		var user = $(this).attr('id');
     
     var  estado	= $("#estado1").val();
     var  cajero      = $("#cajero").val();
     var  fecha1      = $("#fecha1").val();
     var  fecha2     = $("#fecha2").val();
    
     var  tipofacturaf     = $("#tipofacturaf").val();
	 
	 var suma = 0;
	 var total1=0;
  
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
							'<button title ="Anular Registro " class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button> &nbsp;' +
							'<button title ="Editar Frecuencia Hora" class="btn btn-xs btn-info" onClick="goToURLFreq('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-bed"></i></button> &nbsp;' +
							'<button title ="Imprimir Comprobante" class="btn btn-xs btn-warning" onClick="url_comprobante_simple('+"'../../reportes/view_print_terminalb?tipo=51&id="+ s[i][0]  + "'"+')">' +
							'<i class="glyphicon glyphicon-download-alt"></i></button> &nbsp;'
							 
						]);										
					 // End For

					suma  =  s[i][6] ;

					  total1 += parseFloat(suma) ;

					  $("#total_diario").html('Resumen Dario $ '+ total1.toFixed(2) );

				  }
			    }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
}  
/*
*/
function ver_cliente_ruta(idprov,nombre){        
	 
	   
 var   user      = $(this).attr('id');
 var  fecha2     = $("#fecha2").val();
 

 var parametros = {
			'idprov' : idprov , 
		    'cajero' : nombre  ,
 		    'fecha2' : fecha2,
  };

	if(user != '') 
	{ 
	$.ajax({
		 data:  parametros,  
		url: '../grilla/grilla_frec_dia.php',
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
 					]);										
				 // End For

			 

			  }
			}						
		},
		error: function(e){
		   console.log(e.responseText);	
		}
		});
	}
}  
/*
*/
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
 

	 var moduloOpcion =  'kservicios';
		 
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
   
 	 $("#ViewForm").load('../controller/Controller-ven_factura_gra.php');

 
 	 pagoshow(0);
 	
}
 
   
//-----------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_movimiento').val(id); 
	  
	DetalleMov(id,action);

	 
	
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
 			url:   '../controller/Controller-inv_FacDetGra.php',
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
/*
*/

function InsertaFrecuencia_guarda(id_fre,ruta,hora)
{

	var idprov 			=  $('#idprov').val();
	var id_movimiento   =  $('#id_movimiento').val();
 

	var unidad   =  $('#unidad').val();
 

	if ( idprov == '9999999999999'){
	}
else{
	
		var hoy = new Date();

		var hora_actual = hoy.getHours() + ':' + hoy.getMinutes() ;

		var detalle = ruta + ' - ' + hora + ' Registro: ' + hora_actual + ' Unidad: '+unidad; 

		var parametros = {
			'id' : id_movimiento,  
		   'idprov': idprov,
		   'hora' : hora,  
		   'horar' : hora_actual,
		   'id_fre': id_fre,
		   'unidad': unidad,
		   'ruta' :ruta
   };

     if ( unidad != '0') {

						$.ajax({
							url:   '../model/ajax_ren_ruta_add.php',
							data:  parametros,
						type:  'GET' ,
							beforeSend: function () { 
									$("#ver_factura").html('Procesando');
							},
						success:  function (data) {

									$("#GuardaArticulo").html(data);   
									
									$("#ver_factura").html('<b>' + detalle + '</b>');   

									$('#detalle').val(detalle);
									
									
							} 
					});
			

					$('#myModal').modal('hide');

		}else {
				alert('Registre el numero de unidad....');
		}
	}
 
	 
}
/*
*/
function goToURLFreq( accion,codigo)
{

	var parametros = {
		'id' : codigo,
		'accion' : accion 
};

 
							$.ajax({
								url:   '../controller/Controller-ven_ruta_edita.php',
								data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#VisorArticuloFrecuencia").html('Procesando');
								},
							success:  function (data) {
										$("#VisorArticuloFrecuencia").html(data);   
										
								} 
					});
  
				

					$('#myModalhora').modal('show');
	 

 
 
	 
}
/*
*/

function InsertaFrecuencia()
{

	var idprov 			=  $('#idprov').val();
	var id_movimiento   =  $('#id_movimiento').val();

	var parametros = {
		'id' : id_movimiento,  
		'idprov': idprov
};


	if ( idprov == '9999999999999'){
    }else{

 

							$.ajax({
								url:   '../controller/Controller-ven_ruta.php',
								data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#VisorArticulo").html('Procesando');
								},
							success:  function (data) {
										$("#VisorArticulo").html(data);   
										
								} 
					});
				

					$('#myModal').modal('show');
	 

    }
 
	 
}
/*
*/
function InsertaProductoItem(idproducto,costo)
{

	var id_movimiento = $('#id_movimiento').val();
	
  	var estado        = $.trim( $('#estado').val() );
  	
 	var tipo    = 'F';
 	 
		
		if (estado == 'D'){ 
		 	
			var parametros = {
					"idproducto" : idproducto ,
	                "id_movimiento" : id_movimiento ,
	                "estado" : estado,
					"costo" : costo,
	                "tipo" : tipo,
	                "accion" : 'add' 
			};
					 
				          
						  $.ajax({
								data:  parametros,
								url:   '../model/Model-addFacturaSerGra.php',
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
						 	 
 				 $('#articulo').val('');
						  
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
 
    
//--------------------------------
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
			 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,'F',id,costo);
			 	
				total_factura();
				
			  
	 
 //------------------------------------------------------------------
 	
	  }		
		
 
    
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
				url:   '../model/Model-addFacturaSerGra.php',
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
		 	 
 			 
 
	
	
	}else{
	
		alert('No se puede eliminar');

	}
}	
  
//-----------------
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,costo)
{
  
 
 
	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": 'F',
 			"id" : id  ,
 			"costo": costo
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
    var estado        = $.trim( $('#estado').val() );
	  
 
	var parametros = {
 			"idcategoriavar" : idcategoriavar  ,
			"id_movimiento" : id_movimiento,  
			"idcategoria" : idcategoria  ,
			"valor" : valor  ,
			"variable" : variable  
	};
	
	if (estado == 'digitado'){
		
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

}

/*
*/

function ActualizaDato(  ){

	 
	var id 	        = $('#id_fre_mov').val();
	var num_carro   = $('#num_carro').val();
	var hora        = $('#hora').val();


 
	   
	   var parametros = {
				   "id" : id   ,
				   "num_carro" : num_carro,
				   "hora"   : hora
		   };
		  
		  
		 if (id > 0  )  {
 
				  $.ajax({
							url:   '../model/ajax_actualiza_freq.php',
						   data:  parametros,
						  type:  'GET' ,
							  beforeSend: function () { 
									  $("#GuardaArticuloFreq").html('Procesando');
							  },
							  success:  function (data) {
  
								   $("#GuardaArticuloFreq").html(data);   
								   
							 
									
							  } 
				  });
	 	}
		  
  }

/*
*/
function aprobacion(  ){

	 
  var id 	  = $('#id_movimiento').val();
  var estado  = $.trim( $('#estado').val() );
  var total   = $('#xx').val();
	 
	 var parametros = {
	 			"id" : id   ,
	 			"accion" : 'aprobacion',
	 			"tipo"   : 'F'
 		};
		
		if (estado == 'D'){

			if ( total > 0 ){
			
				$.ajax({
			 			 url:   '../model/Model-ven_factura.php',
			 			data:  parametros,
						type:  'GET' ,
							beforeSend: function () { 
									$("#result").html('Procesando');
							},
					    	success:  function (data) {

								 $("#result").html(data);   
								 
								 url_comprobante('../../reportes/view_print_terminalb?tipo=51');
 							     
							} 
				});
		
		} else {
				alert('Seleccione rubro para recaudar....');
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
    var alto = 570;
    
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
    var alto = 460;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }


  
function url_comprobante(url){        
	

	var variable    = $('#id_movimiento').val();
 
 	var enlace = url+'&id=' + variable;
		
    
	 var posicion_x; 
	 var posicion_y; 
	 
 	 
	 var ancho = 100;
	 
	 var alto = 100;
	 
	 posicion_x=(screen.width/2)-(ancho/2); 
	 
	 posicion_y=(screen.height/2)-(alto/2); 
	 
	 window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

 
	 $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><span style="padding-top: 3px;font-size: 16px;font-weight:700"> AGREGAR NUEVO REGISTRO</span>');
  			  		
	 LimpiarPantalla();
	  
    $("#FacturaElectronica").html(''); 
 
 }
 /*
 */
 function url_comprobante_simple(enlace){        
	
 
		
    
	 var posicion_x; 
	 var posicion_y; 
	 
 	 
	 var ancho = 100;
	 
	 var alto = 100;
	 
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
