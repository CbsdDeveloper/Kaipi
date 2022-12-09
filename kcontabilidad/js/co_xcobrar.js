var oTableGrid;  

var oTable ;



$(function(){

      

    $(document).bind("contextmenu",function(e){

        return false;

    });

	

 

});

 

//-------------------------------------------------------------------------

$(document).ready(function(){

    
	"use strict";

        oTable = $('#jsontable').dataTable(); 

       

        oTableGrid = $('#ViewCuentas').dataTable();  

       

       

		$("#MHeader").load('../view/View-HeaderModel.php');

	

		$("#FormPie").load('../view/View-pie.php');

		

		

		modulo();

 		

	    FormView();

	    

	    FormFiltro();

   		    

	  	

	   $('#load').on('click',function(){

 		   

            BusquedaGrilla(oTable);

  			

		});

	

	 $('#loadAuxView').on('click',function(){

 		   

            BusquedaGrilla(oTable);

  			

		});

	 
	  $('#loadxls').on('click',function(){

	  	  var ffecha1 = $("#ffecha1").val();

		  var ffecha2 = $("#ffecha2").val();

		  var festado = $("#festado").val();

		  

		  var cadena = 'festado='+festado+'&ffecha1='+ffecha1+'&ffecha2='+ffecha2;

		  var page = "../reportes/excelCXC.php?"+cadena;  

	      

		  window.location = page;  

  			

		});

	

 

 

 //-----------------------------------------------------------------



});  

//-----------------------------------------------------------------

 

function changeAction(tipo,action,mensaje){

	

 	

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

				 

                 	

				  	LimpiarDatos();

				  

                    LimpiarPantalla();

 

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



	 $("#txtcuenta").val('');

	 $("#cuenta").val('');

	 

	var parametros = {

					'accion' : accion ,

                    'id' : id 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-co_xcobrar.php',

					type:  'GET' ,

					cache: false,

					beforeSend: function () { 

 							$("#result").html('Procesando');

  					},

					success:  function (data) {

							 $("#result").html(data);  // $("#cuenta").html(response);

							 

							 var idprov =  $("#idprov").val();

 
							 ListaAux(id,idprov);

							 ListaAuxMov(id,idprov); 

  					} 

			}); 

	  

	 

     }

//-------------------------------------------------------------------------

  

//-------------------------------------------------------------------------

// ir a la opcion de editar

function LimpiarPantalla() {

	

		var fecha = fecha_hoy();

	

		$("#fecha").val(fecha);

		

		$("#id_periodo").val("0");

		

    	$("#id_asiento").val(0);

	   

		$("#comprobante").val(" "); 

	 

		$("#estado").val("digitado");

		

 

		

		$("#detalle").val("");

	 

		$("#action").val("add");

	 

		$("#fechaemision").val(fecha);

		

		$("#tipocomprobante").val("18");

		   

 	   

	 	$("#codestab").val("001");

	   

		$("#secuencial").val("");

	   

		$("#autorizacion").val("");       

		

		$("#id_ventas").val("");

		

		$("#idprov").val("");

		

		$("#razon").val("");

		

		$("#txtcuenta").val("");

		

		$("#cuenta").val("");

 /*

		

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

 

	 //----- LIMPIA 

	 var parametro = {

 			    'id_asiento' : 0 

     };

	  

  	$.ajax({

 			data:  parametro,

 			 url:   '../model/ajax_DetAsientoIR.php',

 			type:  'GET' ,

 			cache: false,

 			beforeSend: function () { 

 						$("#retencion_fuente").html('Procesando');

 				},

 			success:  function (data) {

 					 $("#retencion_fuente").html(data);   

 				     

 				} 

 	});

  	*/

  	

 }

//ir a la opcion de editar

function LimpiarDatos() {  

	

	$("#baseimponible").val(0);

	

	$("#baseimpgrav").val(0);

	

	$("#montoiva").val(0);

	

	$("#basenograiva").val(0);

	

	$("#montoice").val(0);

	

	$("#descuento").val(0);

	

	$("#porcentaje_iva").val(0);

	

	$("#valorretbienes").val(0);

	

	$("#valorretservicios").val(0);

	

	$("#valorretrenta").val(0);

	

	$("#baseimpair").val(0);

  

	$("#codretair").val("-");    

	

}

//-------------------------------------------------------------------------

 



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



	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

		var user = $(this).attr('id');

    

	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var festado = $("#festado").val();

	  var fpagado = $("#fpagado").val();

	  

	  var suma = 0;

	  var total1 = 0;

	  

 

      var parametros = {

				'ffecha1' : ffecha1  ,

				'ffecha2' : ffecha2  ,

				'festado' : festado  ,

				'fpago': fpagado

      };



 

		

		if(user != '') 

		{ 

		$.ajax({

		 	data:  parametros,

		    url: '../grilla/grilla_co_xcobrar.php',

			dataType: 'json',

			cache: false,

			success: function(s){

		//	console.log(s); 

			oTable.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTable.fnAddData([

	                      s[i][0],

	                      s[i][1],

	                      s[i][2],

	                      s[i][3],

	                      s[i][4],

	                      s[i][5],

	                      s[i][6],

	                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' +

	                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'

	                  ]);	

					  suma  =  s[i][6] ;

					  total1 += parseFloat(suma) ;

					  $("#totalPago").html('$ ' + total1.toFixed(2) );

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

 				     

 				} 

 	});

 

  	

  }

//------------------------------------------------------------------------- 

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

 	 var modulo1 =  'kcontabilidad';

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

    



	 $("#ViewForm").load('../controller/Controller-co_xcobrar.php');

      



 }

 

 

 

//----------------------

 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-co_xcobrar_filtro.php');

	 

 }

//----------------------

 

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

			
  			 var idprov =  $("#idprov").val();

  			 
			 ListaAux(id,idprov);

			 ListaAuxMov(id,idprov); 

			  $("#id_asiento").val(id);

		 			 
 

		 		//		 BusquedaGrilla(oTable);

	 

	}



 }

 



//------------------------------------------------------------------------- 

 function ViewDetAuxiliar(codigoAux)

 {

 	 

 

 	 var parametros = {

			    'codigoAux' : codigoAux 

    };

 	 

 	$.ajax({

			data:  parametros,

			 url:   '../controller/Controller-co_asientos_aux02.php',

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

//----------------------------------------------

 function GuardarAuxiliar()

 {

 	 

    var valida = validaPantalla();

	 

	var	id_asiento     =    $("#id_asiento").val( );

	var codigodet      =	$("#codigodet").val( );

	var idprov         =	$("#idprov01").val( );

 	 

 

		 

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

 

 }

 function validaPantalla() {



		var valida = 1;

	 

		if (  $("#idprov").val()  ) { valida = 0 ; } else { valida = 1 ; }

		

	/*	if (  $("#comprobante").val()  ) { valida = 0 ; } else { valida = 1 ; }	

		  

		if (  $("#documento").val()  ) { valida = 0 ; } else { valida = 1 ; }

		

		if (  $("#estado").val()  ) { valida = 0 ; } else { valida = 1 ; }	



		if (  $("#tipo").val()  ) { valida = 0 ; } else { valida = 1 ; }

		

		if (  $("#detalle").val()  ) { valida = 0 ; } else { valida = 1 ; }	



		 */

		 	

		 return valida;



	}

 //--------------

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

 

 

 function aprobacion(url){

     
	 

     $("#action").val( 'aprobacion');

     

     var action			  =   $("#action").val();

 	 var id_asiento    =   $("#id_asiento").val( );

 	 

 	 var idprov =  $("#idprov").val();

 	 

 	 

	 var parametros = {

				'action' : action ,

                'id_asiento' : id_asiento 

    };

     

     var mensaje = 'Desea aprobar el asiento contable ' + action;

     

     alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

		

     if (e) {

			    

				  $.ajax({

								data:  parametros,

								url:   '../model/Model-co_xpagar.php',

								type:  'POST' ,

								cache: false,

								beforeSend: function () { 

										$("#result").html('Procesando');

								},

								success:  function (data) {

										 $("#result").html(data);  // $("#cuenta").html(response);

									     

										 ListaAux(id_asiento,idprov);

										 ListaAuxMov(id_asiento,idprov);

								} 

						}); 

			  }

		 });



	}

 //------------------------
function aprobacion_retencion( ){

 
	"use strict";
	
  	 var id_asiento    =   $("#id_asiento").val( );
  	 var idprov        =  $("#idprov").val();
 
 	$("#action").val('retencion' );

    alert('Guarde la informacion para actualizar la informacion')
				 
 
}

 
 //----------------
 function monto_iva(valor_base){

	 

 

	  var flotante = parseFloat(valor_base)    * (12/100);

	  

	  if (valor_base > 0){

		  

		  flotante = parseFloat(flotante).toFixed(2)  ;

		  

		  $('#montoiva').val(flotante);

 	  

	  }else{

 		

		  $('#montoiva').val(0); 

 	  

	  }

	

	  var base12  	=  valor_base  ; 

	  var base0		=  $('baseimponible').val()  ; 

	  var baseNo	=  $('basenograiva').val() ; 

	 

	  var totalBase 	= parseFloat(base12).toFixed(2)  + parseFloat(base0).toFixed(2)  + parseFloat(baseNo).toFixed(2);

	  

	  

	  flotante = parseFloat(totalBase).toFixed(2)  ;

	  

	  $('#baseimpair').val(flotante);

 

}

//------.

 function base_ir(valor,tipo ){

	 

	   

	  var base12  	=  NaN2Zero ( $('#baseimpgrav').val() ) ; 

	  var base0		=  NaN2Zero ( $('#baseimponible').val() ) ; 

	  var baseNo	=  NaN2Zero ( $('#basenograiva').val() ) ; 

	  

	  if (tipo == 1){

		    base0		= valor ; 

  	  }

	  if (tipo == 2){

		  baseNo		= valor ; 

 	  }

	  

	  var totalBase 	= parseFloat(base12)  + 

	  					  parseFloat(base0)   + 

	  					  parseFloat(baseNo)  ;

	  

	  var flotante = parseFloat(totalBase).toFixed(2)  ;

	  

	  $('#baseimpair').val(flotante)



}

//---------------

 function NaN2Zero(n){

	    return isNaN( n ) ? 0 : n; 

	}

//---------------

 function monto_riva(tipo_retencion){

	

	  var monto_iva =  $('#montoiva').val(); 

	  var base12  	=  NaN2Zero ( $('#baseimpgrav').val() ) ;   

	  var iva = 0;

	  var flotante = 0 ;

	 

	  if (tipo_retencion == 0){

		  $('#valorretbienes').val(0);

		  $('#valorretservicios').val(0);

  		  }

	 //-------------------

	  if (tipo_retencion == 1){

		  iva = monto_iva * (30/100);

		  flotante = parseFloat(iva).toFixed(2)  ;

		  $('#valorretbienes').val(flotante);

		  $('#valorretservicios').val(0);

  		  }

	//-------------------

	  if (tipo_retencion == 2){

		  iva = monto_iva * (70/100);

		  flotante = parseFloat(iva).toFixed(2)  ;

		  $('#valorretbienes').val(0);

		  $('#valorretservicios').val(flotante);

  		  } 

	//-------------------

	  if (tipo_retencion == 3){

		  iva = monto_iva * (100/100);

		  flotante = parseFloat(iva).toFixed(2)  ;

		  $('#valorretbienes').val(0);

		  $('#valorretservicios').val(flotante);

  		  }  

	//-------------------

	  if (tipo_retencion == 4){

		  iva = monto_iva * (10/100);

		  flotante = parseFloat(iva).toFixed(2)  ;

		  $('#valorretbienes').val(flotante);

		  $('#valorretservicios').val(0);

  		  }  

		//-------------------

	  if (tipo_retencion == 5){

		  iva = monto_iva * (70/100);

		  flotante = parseFloat(iva).toFixed(2)  ;

		  $('#valorretbienes').val(0);

		  $('#valorretservicios').val(flotante);

  		  } 	  

}

//-------------------

//---------------

function factura_codigo(n){

	

	 

	 var secuencial =  parseFloat( $('#secuencial').val()  )

	

	var h =('00000000' + secuencial).slice (-9);

	 

	 $('#secuencial').val(h);

	 

	 

	 

	}



//------------------------------------------------------------------------- .

//-------------------

function calculoFuente(codigoAux)

{

	 

	var baseimpair =  $('#baseimpair').val();

	 



	 var parametros = {

			    'codigoAux' : codigoAux ,

			    'baseimpair': baseimpair

  };

	 

	 

		$.ajax({

			data:  parametros,

			url:   '../model/ajax_FuenteCalculoIR.php',

			type:  'GET' ,

			beforeSend: function () {

				$("#valorretrenta").val('...');

			},

			success:  function (response) {

				$("#valorretrenta").val(response);  // $("#cuenta").html(response);

					  

			} 

	});	 

 



}

//-------------------

function ListaAux(vasiento,vprod)

{

	  

  var parametros = {

			    'idasiento' : vasiento ,

			    'idprov': vprod

  };

	 

	 

		$.ajax({

			data:  parametros,

			url:   '../model/Model_listaCxC.php',

			type:  'GET' ,

			beforeSend: function () { 

					$("#ViewFormCxc").html('Procesando');

			},

		success:  function (data) {

				 $("#ViewFormCxc").html(data);   

			     

			} 

 			

		 

	});	 

 



}

function ListaAuxMov(vasiento,vprod)

{

	  

  var parametros = {

			    'idasiento' : vasiento ,

			    'idprov': vprod

  };

	 

	 

		$.ajax({

			data:  parametros,

			url:   '../model/Model_listaCxC_Mov.php',

			type:  'GET' ,

			beforeSend: function () { 

					$("#ListaViewFormCxc").html('Procesando');

			},

		success:  function (data) {

				 $("#ListaViewFormCxc").html(data);   

			     

			} 

 			

		 

	});	 

 



}

//--------------------------

function abrirReporte(vasiento,vprod)

{

	  

	 var enlace  = '../reportes/ficheropago?a=';  

     

	  enlace = enlace +vasiento;

											   

    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');



}



//--------------------

function GuardarAuxiliarCxC( )

{

	

	 var    mensaje = 'Desea generar el cobro?';		

	 var	id_asiento    =   $("#id_asiento").val( );

	 var	idprov   	  =   $("#idprov").val( );

	 

	 var cuenta_cobro  =   $("#cuenta_cobro").val( );

	 var cobro_total  =   $("#cobro_total").val( );

	 var cobro_pago  =   $("#cobro_pago").val( );

	 var retencion_pago  =   $("#retencion_pago").val( );

	 var cheque_pago  =   $("#cheque_pago").val( );

	 var tipo_pago  =   $("#tipo_pago").val( );

	 var fecha_pago  =   $("#fecha_pago").val( );

	 var idbancos  =   $("#idbancos").val( );

	 

	 var secuencial  =   $("#secuencial").val( );

	 

	 

	 var parametros = {

			    'id_asiento' : id_asiento ,

			    'idprov': idprov,

				'cuenta_cobro': cuenta_cobro,

				'cobro_total': cobro_total,

				'cobro_pago': cobro_pago,

				'retencion_pago': retencion_pago,

				'cheque_pago': cheque_pago,

				'tipo_pago': tipo_pago,

				'fecha_pago': fecha_pago,

				'idbancos':idbancos,

				'secuencial':secuencial

     };

	 

		

	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

		  

	  if (e) {

 		 

			$.ajax({

				data:  parametros,

				url:   '../model/Model_PagoCxC.php',

				type:  'GET' ,

				beforeSend: function () { 

						$("#result_cxcpago").html('Procesando');

				},

			success:  function (data) {

					 $("#result_cxcpago").html(data);   

				     

				      ListaAuxMov(id_asiento,idprov);

				} 

	 			

 		});	 

 

		  }

	 }); 

	

}





//-----------------------------------------

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

 
