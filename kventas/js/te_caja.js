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



var oTableGrid;  
var oTable ;

//-------------------------------------------------------------------------
$(document).ready(function(){
    
        oTable = $('#jsontable').dataTable(); 
       
       oTableGrid = $('#ViewCuentas').dataTable();  
       
       
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
   		    
	    BusquedaGrilla( oTable);
	    
	    ViewDetAuxiliar();
 		
	   $('#load').on('click',function(){
 		   
            BusquedaGrilla(oTable);
  			
		});
 
 
 //-----------------------------------------------------------------

});  
//-----------------------------------------------------------------
 
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	 
                	
                    LimpiarPantalla();
                    
                    accion(0,'');
 
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {

	 $("#txtcuenta").val('');	  	 $("#cuenta").val('');
 	 var estado = 	$("#festado").val( );	 	  if ( estado == '2') { 		  var parametros = {							'accion' : accion ,		                    'id' : id 		 	  };		
			  $.ajax({							data:  parametros,							url:   '../model/Model-co_asientos.php',							type:  'GET' ,							cache: false,							beforeSend: function () { 		 							$("#result").html('Procesando');		  					},							success:  function (data) {									 $("#result").html(data);  // $("#cuenta").html(response);		
		  					} 		
					});            }
     }
//-----------------------------------------------------------------
function CopiarAsiento(id_asiento ) {
/*
 	$MATRIZ = array(      	    '1'    => 'Por Depositar',      	    '2'    => 'Cierre Caja Bancos'       	);       	 */	 var estado = 	$("#festado").val( ); 	  if ( estado == '1') {
	alertify.confirm("Va a realizar el proceso de deposito? " + id_asiento, function (e) {
		  if (e) {
		   var parametros = {				    	                   'id_asiento' : id_asiento 	                   		  };
						  $.ajax({										data:  parametros,										url:   '../model/Model-co_asientos_ccaja.php',										type:  'GET' ,										cache: false,										success:  function (data) {																						 $("#result").html(data);   											 											 BusquedaGrilla(oTable);											 											 alert('Transaccion generada ' + id_asiento);		
					 					} 
								});  				   }   		 }); 
  }  
	 
}
//-------------------------------------------------------------------------
 //-------------------------------------------------------------------------
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {

	
	    var fecha = fecha_hoy();
	    
    	$("#id_periodo").val("0");
    	$("#id_asiento").val(0);
	    $("#fecha").val(fecha);
		$("#comprobante").val(" "); 
		$("#documento").val(" "); 
		$("#estado").val(" ");          
		$("#tipo").val(" ");
		$("#detalle").val("");
		$("#action").val("");
		
		$("#action").val("add");
		
		
		 var parametros = {
	 			    'id_asiento' : 0 
	     };
		  
	  	$.ajax({
	 			data:  parametros,
	 			 url:   '../model/ajax_DetAsiento.php',
	 			type:  'GET' ,
	 			cache: false,
	 			beforeSend: function () { 
	 						$("#DivAsientosTareas").html('Procesando');
	 				},
	 			success:  function (data) {
	 					 $("#DivAsientosTareas").html(data);   
	 				     
	 				} 
	 	});
 
 }
//----------------------------------
function montoDetalle(tipo,valor,codigo)
{
	  

  var estado 		= $('#estado').val(); 
  var id_asiento 	= $('#id_asiento').val(); 
	  
  var parametros = {
			    'estado' : estado ,
			    'tipo'   : tipo,
			    'valor'  : valor,
			    'codigo' : codigo,
			    'id_asiento' : id_asiento
   };
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model_montoAsiento.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#montoDetalleAsiento").html('Procesando');
				},
			success:  function (data) {
					 $("#montoDetalleAsiento").html(data);   
				     
				} 
	});

}  
    
//-------------------------------------------------------------------------
//ir a la opcion de editar
function validaPantalla() {

	var valida = 1;
 
	if (  $("#idprov").val()  ) { valida = 0 ; } else { valida = 1 ; }
	 
	 return valida;

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
 
     return  today;      
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
		var user = $(this).attr('id');
    
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var festado = $("#festado").val();
	  
 
      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  
      };

 
		
		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_asientos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
			if(s){
			for(var i = 0; i < s.length; i++) {
				  oTable.fnAddData([
                      s[i][0],
                      s[i][1],
                      s[i][2],
                      s[i][3],
                      s[i][4],                      s[i][5],
                      '<button class="btn btn-xs" title="TRANSACCION - GENERAR DEPOSITO DE CAJA" onClick="javascript:CopiarAsiento('+ s[i][0] +')"><i class="glyphicon glyphicon-usd"></i></button>&nbsp;&nbsp;' +
                      '<button class="btn btn-xs" title="TRANSACCION ASIENTO CIERRE DE CAJA - DIARIO" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>'
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
//--------------
 //------------------------------------------------------------------------- 
  function DetalleAsiento()
  {
  	 
     var id_asiento = $('#id_asiento').val(); 
	  
	  var parametros = {
 			    'id_asiento' : id_asiento 
     };
	  
  	$.ajax({
 			data:  parametros,
 			 url:   '../model/ajax_DetAsiento.php',
 			type:  'GET' ,
 			cache: false,
 			beforeSend: function () { 
 						$("#DivAsientosTareas").html('Procesando');
 				},
 			success:  function (data) {
 					 $("#DivAsientosTareas").html(data);   
 				  	 $('#txtcuenta').val('');
 				  	 $('#cuenta').val('');
 				} 
 	});
 
  	
  }
  //------------------------------------------------------------------------- 
  function AgregaCuenta()
  {
  	 
	  var id_asiento = $('#id_asiento').val(); 
	  
	  var cuenta = $('#cuenta').val(); 
	  
	  var estado = $('#estado').val(); 
	  
	  if (id_asiento > 0){
 	  
			 var parametros = {
		 			    'id_asiento' : id_asiento ,
		 			   'cuenta' : cuenta,
		 			  'estado' : estado
		     };
			  
		  	$.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-co_dasientos.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#DivAsientosTareas").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#DivAsientosTareas").html(data);   
		 				     
		 				} 
		 	});
	  }else{
		  alert('Guarde la información del asiento');
	  }

  }
//------------------------------------------------------------------------- 
 function modulo()
 {
 	 var modulo1 =  'kventas';
 	 var parametros = {
			    'ViewModulo' : modulo1 
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
    

	 $("#ViewForm").load('../controller/Controller-co_asientos.php');
      
	 $("#ViewPago").load('../controller/Controller-asiento_pagos.php');
	 

 }
//--------------
 function cerrar_pago(validaDato)
 {
	 
 
	 if (validaDato == 1 )  {
		 
	    alert('No requiere Comprobante de Pago');
	    
 	    $('#myModalPago').modal('hide');
 	    
	 }  
 
 }
 
//-----------------function PagoAsiento() {
    /*	var id = $('#id_asiento').val();  
	 var parametros = {
			 'accionpago' : accion ,
             'id' : id 
     };
	 
     $.ajax({
				data:  parametros,
				url:   '../model/Model-co_asiento_pagos.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#result_pago").html('Procesando');
				},
				success:  function (data) {
						 $("#result_pago").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
*/
     
}
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-co_asientos_filtro.php');
	 
 }
//----------------------
 function accion(id,modo,estado)
 {
  
	if (id > 0){
		 
  			 if (modo == 'aprobado'){
					$("#action").val('aprobado');
					$("#estado").val('aprobado');          
					$("#comprobante").val(estado);       
			 }else{
					$("#action").val(modo);
					$("#estado").val(estado);          
		 	 }
			 		
					     $("#id_asiento").val(id);
		 				 $("#txtcuenta").val('');
		 				 $("#cuenta").val('');
			 
		 				 BusquedaGrilla(oTable);
	 
	}

 }
 
//-------------------
 function accion_pago(id,modo,comprobante)
 {
    
	  if (modo == 'procesado'){
			$("#action_pago").val('aprobado');
 			$("#pago").val('S');     
 			$("#comprobantePago").val(comprobante);     
	 }else{
			$("#action_pago").val(modo);
			         
 	 }
	  
 
 }
//------------------------------------------------------------------------- 
//------------------------------------------------------------------------- 
 function aprobacion_pago( ){
      

 	 
     var pagado = $("#pago").val();     
     
     
     var estado = $("#estado").val();     
     
    
     if (estado == 'aprobado'){
    	 
    	 	$("#action_pago").val( 'aprobacion');
     
		     if (pagado == 'N'){
		    
		 			var	id_asiento    =   $("#id_asiento").val( );
		 			
		  			 
		 			var el = document.getElementById('form');
		 			
		 			var mensaje = 'Desea generar el comprobante de pago:  ' + id_asiento;
		 		
		 			el.addEventListener('submit', function(){
		 				
		 			    return  confirm(mensaje);
		 			
		 			}, false);
		     }
     }else{
    	 $("#action_pago").val( 'no');
    	 alert('No se puede generar comprobante de pago');
     }
     }
//----------------------
 function ViewDetAuxiliar(codigoAux)
 {
 	 
 
 	 var parametros = {
			    'codigoAux' : codigoAux 
    };
 	 
 	$.ajax({
			data:  parametros,
			 url:   '../controller/Controller-co_asientos_aux.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFiltroAux").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltroAux").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
 
 }
//------------------------------------------------------------------------- 
 function ViewDetCostos(codigoAux)
 {
 	 
 
 	 var parametros = {
			    'codigoAux' : codigoAux 
    };
 	 
 	$.ajax({
			data:  parametros,
			 url:   '../controller/Controller-co_asientos_costo.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFiltroCosto").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltroCosto").html(data);  
					 
 				 	$("#guardarCosto").html(' ');
				} 
	});
 
 }
 //Controller-co_asientos_costo.php
//------------------------------------------------------------------------- 
 function GuardarAuxiliar()
 {
 	 
    var valida = validaPantalla();
	 
	var	id_asiento     =  $("#id_asiento").val( );
	var codigodet      =	$("#codigodet").val( );
	var idprov         =	$("#idprov").val( );
 	 
	 if (valida ==0 ){
		 
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'codigodet' : codigodet ,
						    'idprov' : idprov 
 			    };
			 	 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosaux.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarAux").html('Procesando');
							},
						success:  function (data) {
								 $("#guardarAux").html(data);   
							     
							} 
				});
 	 }else{
		 alert('Ingrese la informacion del beneficiario');
	 }

 }
 //---------------------
 function GuardarCosto( )
 {
 	 
	 
	var	idasientodetCosto     =  $("#idasientodetCosto").val( );
	
	 
	var codigo1      =	$("#codigo1").val( );
	var codigo2      =	$("#codigo2").val( );
	var codigo3      =	$("#codigo3").val( );
	var codigo4      =	$("#codigo4").val( );
 	 	 
 		 
 			 	 var parametros = {
						    'idasientodetCosto' : idasientodetCosto ,
						    'codigo1' : codigo1 ,
						    'codigo2' : codigo2 ,
						    'codigo3' : codigo3 ,
						    'codigo4' : codigo4 
 			    };
			 	 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosCosto.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarCosto").html('Procesando');
							},
						success:  function (data) {
								 $("#guardarCosto").html(data);   
							     
							} 
				});
 	  
 
 }
 
//----------------------------- 
 
 function aprobacion(url){
     
     $("#action").val( 'aprobacion');
     
     var action			  =   $("#action").val();
 	 var	id_asiento    =   $("#id_asiento").val( );
 	 
	 var parametros = {
				'action' : action ,
                'id_asiento' : id_asiento 
    };
     
     var mensaje = 'Desea aprobar el asiento contable ' + action;
     
     alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
		
     if (e) {
			    
				  $.ajax({
								data:  parametros,
								url:   '../model/Model-co_asientos.php',
								type:  'POST' ,
								cache: false,
								beforeSend: function () { 
										$("#result").html('Procesando');
								},
								success:  function (data) {
										 $("#result").html(data);  // $("#cuenta").html(response);
									     
								} 
						}); 
			  }
		 });

	}
 //--------------
 function totalc(formulario,codigo){
	 
		var layFormulario            = formulario.elements;
		var lnuElementos             = layFormulario.length;
		var nsaldos             	 = 0;
		var gnuCalcularTotal              = 0;
		var gnuCalcularTotal1             = 0;
		
	 
			
		for( var xE = 0; xE < lnuElementos; xE++ ){		 
			var lobCampo            = layFormulario[ xE ];
			var lstNombre           = lobCampo.name;
			var lnuCampo            = lobCampo.value;
			
			var layDatosNombre         = lstNombre.split( '_' );
			var lstCampo               = layDatosNombre[0];
			lnuCampo                   = parseFloat (lnuCampo); 
				
			if (lstCampo == 'debe'){
				 gnuCalcularTotal =  gnuCalcularTotal + lnuCampo;
			}
			if (lstCampo == 'haber'){
				 gnuCalcularTotal1 =  gnuCalcularTotal1 + lnuCampo;
			}
		
		}
		
		formulario.total_debe.value  = gnuCalcularTotal;
		
		formulario.total_haber.value = gnuCalcularTotal1;
		
		var gnuCalcularTotal2 = gnuCalcularTotal - gnuCalcularTotal1;
		
		var nsaldos = parseFloat(gnuCalcularTotal2.toFixed(2));
 
		  $("#SaldoTotal").html(' <h4>'+ nsaldos + ' </h4>'); 
		
		return true;
}  