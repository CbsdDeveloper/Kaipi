$(document).ready(function(){


		modulo();

 	    FormFiltro();

 	    FormFiltroLibro();
 
 	    //-----------------------------------------------------------------Viewlibro
 	    $('#load').on('click',function(){
 		   	calculaSaldos();
		});
	    //-----------------------------------------------------------------financiero2

		$('#financiero1').on('click',function(){
 		  ResumenFinanciero();
		});   
	    //-----------------------------------------------------------------

		$('#financiero44').on('click',function(){
 		 	 EnlaceContablePresupuesatario(2);
 	   });      
 	   

 	   $('#financiero3').on('click',function(){
  		 	 ResumenBalance();
 		});      


		 $('#financiero39').on('click',function(){
  			  ResumenBalanceNiveles();
 		}); 

		 $('#financiero_grupo').on('click',function(){
  			  Libro_grupo();
  		});   


		  $('#financiero_flujo').on('click',function(){
	  		  Libro_grupo_flujo();
 		});   

		 $('#financiero_flujo1').on('click',function(){
			Libro_grupo_flujo1();
	 	});   



		  $('#financiero_mayor').on('click',function(){
			  Libro_grupo_mayor();
 		  });   
		  
 
 	   //---- cedula presupuestaria
        $('#financiero4').on('click',function(){
 		  CedulaPresupuestaria();
		});         

 	  
 	   $('#financiero5').on('click',function(){
		  ResumenBalanceR();
		});  

 	   $('#financiero6').on('click',function(){
		  EnlaceContablePresupuesatario(1);
	  });  

 	   $('#financiero66').on('click',function(){
			 ResumenEjecucion();

 		});  
 	  
 	   $('#financiero2').on('click',function(){
			  ResumenLibro();
		});      

 	   
 	   $('#financiero22').on('click',function(){
   		  BusquedaGrupo();
 		});  
 	   
 	   
 	   $('#financiero23').on('click',function(){
    		  BusquedaGrupoItem();
  		});  
 	
		  $('#financiero_inicial').on('click',function(){
			BusquedaInicial();
		});  
   

		$('#presupuesto_inicio').on('click',function(){
			PresupuestoInicial();
		}); 
		
   
 	   
 	   //---- exporta balance de comprobacion

  	  $("#excelButtonBalance").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewBalance').html()));

	        e.preventDefault();

	    });


	 $("#excelButtonLibro").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#Viewlibro').html()));

	        e.preventDefault();

	    });

 	    

	    var j = jQuery.noConflict();
	    
	    //-- imprime balance de comprobancion

		j("#printButtonBalance").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#ViewBalance").printArea( options );

		});

		
		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');
		
		
});  

/*
*/
function BusquedaInicial()
{

	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();

 
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();

	  var tipo =     $("#tipo").val();
	  var nivel =     $("#nivel").val();

 	 var parametros = {
			    'ffecha1' : ffecha1, 
			    'ffecha2' : ffecha2,
			    'tipo' : tipo ,
			    'nivel': nivel ,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta,
			    'valida'     : 'S'
    };

 

 	$.ajax({

			 data:  parametros,
			 url:   '../model/Model-Balance_Esigef_inicial.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewBalance").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewBalance").html(data); 
				   
				} 

	});

      

 }

//------------------------------------------------------------------------- 
 function modulo()
 {

 	 var modulo =  'kcontabilidad';

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
 //---
 function Libro_grupo_mayor()

 {

   
	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var id_asiento =     $("#id_asiento").val();

	  var cuentat    =     $("#cuentat").val();

	  var cuenta     =     $("#cuenta").val();

	  var auxiliares =     $("#auxiliares").val();

	  
 

 	 var parametros = {

			    'ffecha1' : ffecha1, 

			    'ffecha2' : ffecha2,

			    'id_asiento' : id_asiento ,

			    'cuentat'    : cuentat,

			    'auxiliares' : auxiliares,

			    'cuenta'     : cuenta

    };

 	 

 	 

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-libro_mayor.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#Viewlibro").html('Procesando');

				},

			success:  function (data) {

					 $("#Viewlibro").html(data); 

				     

				} 

	});

      

 }
 //-------------
 function Libro_grupo_mayor_p(tipo)
 {

   
	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var id_asiento =     $("#id_asiento").val();

	  var cuentat    =     $("#cuentat").val();

	  var cuenta     =     $("#cuenta").val();

	  var auxiliares =     $("#auxiliares").val();

	  
 

 	 var parametros = {

			    'ffecha1' : ffecha1, 

			    'ffecha2' : ffecha2,

			    'id_asiento' : id_asiento ,

			    'cuentat'    : cuentat,

			    'auxiliares' : auxiliares,

			    'cuenta'     : cuenta,

				'grupo' :    tipo

    };

 	 

 	 

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-libro_mayor_grupo.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#Viewlibro").html('Procesando');

				},

			success:  function (data) {

					 $("#Viewlibro").html(data); 

				     

				} 

	});

      

 }
 //----------
 function Libro_grupo_flujo()

 {

   
	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var id_asiento =     $("#id_asiento").val();

	  var cuentat    =     $("#cuentat").val();

	  var cuenta     =     $("#cuenta").val();

	  var auxiliares =     $("#auxiliares").val();

	  
 

 	 var parametros = {

			    'ffecha1' : ffecha1, 

			    'ffecha2' : ffecha2,

			    'id_asiento' : id_asiento ,

			    'cuentat'    : cuentat,

			    'auxiliares' : auxiliares,

			    'cuenta'     : cuenta

    };

 	 

 	 

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-libro_flujo.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#Viewlibro").html('Procesando');

				},

			success:  function (data) {

					 $("#Viewlibro").html(data); 

				     

				} 

	});

      

 }
 //----------------------------
 function Libro_grupo_flujo1()

 {

   
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var id_asiento =     $("#id_asiento").val();
	  var cuentat    =     $("#cuentat").val();
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();
	  
 

 	 var parametros = {
			    'brfecha1' : ffecha1, 
			    'brfecha2' : ffecha2,
			    'id_asiento' : id_asiento ,
			    'cuentat'    : cuentat,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta
    };

 	 

 	 

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-FlujoEsigef.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#Viewlibro").html('Procesando');

				},

			success:  function (data) {

					 $("#Viewlibro").html(data); 

				     

				} 

	});

      

 }
 //----------
 function Libro_grupo()
 {

   
	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var id_asiento =     $("#id_asiento").val();

	  var cuentat    =     $("#cuentat").val();

	  var cuenta     =     $("#cuenta").val();

	  var auxiliares =     $("#auxiliares").val();

	  
 

 	 var parametros = {

			    'ffecha1' : ffecha1, 

			    'ffecha2' : ffecha2,

			    'id_asiento' : id_asiento ,

			    'cuentat'    : cuentat,

			    'auxiliares' : auxiliares,

			    'cuenta'     : cuenta

    };

 	 

 	 

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-libro_grupo.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#Viewlibro").html('Procesando');

				},

			success:  function (data) {

					 $("#Viewlibro").html(data); 

				     

				} 

	});

      

 }
//-------------

 function ResumenLibro()

 {
 	 

	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var id_asiento =     $("#id_asiento").val();
	  var cuentat    =     $("#cuentat").val();
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();

	   
 	 var parametros = {
			    'ffecha1' : ffecha1, 
			    'ffecha2' : ffecha2,
			    'id_asiento' : id_asiento ,
			    'cuentat'    : cuentat,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta
    };
 

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-libro.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
 						$("#Viewlibro").html('Procesando');
 				},
 			success:  function (data) {
					 $("#Viewlibro").html(data); 
				} 

	});

}
//------------------------------------------------------------------------- 
function ResumenLibroDigitado()

 {

  

	 // ffecha1,ffecha2,id_asiento,cuentat,cuenta

	 

	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var id_asiento =     $("#id_asiento").val();

	  

	  var cuentat =     $("#cuentat").val();

	  var cuenta =     $("#cuenta").val();

	 

 	 var parametros = {

			    'ffecha1' : ffecha1, 

			    'ffecha2' : ffecha2,

			    'id_asiento' : id_asiento ,

			    'cuentat': cuentat,

			    'cuenta': cuenta

    };

 	$.ajax({

			data:  parametros,

			 url:   '../model/Model-libroD.php',

			type:  'POST' ,

			cache: false,

			beforeSend: function () { 

						$("#Viewlibro").html('Procesando');

				},

			success:  function (data) {

					 $("#Viewlibro").html(data); 

				     

				} 

	});

      

 }

//----------------------
 function FormFiltro()
{

	 $("#ViewFiltro").load('../controller/Controller-co_analisis_filtro.php');

	 
}

//----------------------
 function FormFiltroLibro()
 {

	 $("#Filtrolibro").load('../controller/Controller-co_analisis_libro.php');


}

//----------------------

 function FormFiltroBalance()

 {
 
	 $("#FiltroBalance").load('../controller/Controller-co_analisis_balance.php');
 
 }
 
//----------------------

 function FormFiltroBalanceG()

 {
 
	 $("#FiltroBalanceg").load('../controller/Controller-co_analisis_balanceg.php');
 

 }
 
//----------------------
 function FormFiltroBalanceR()

 {
 
	 $("#FiltroBalanceR").load('../controller/Controller-co_analisis_balancer.php');
 

 }
 
 //------------------------------------------------------------------------- 

 function calculaSaldos()
{

  

 	 var fanio =     $("#fanio").val();
	 

 	 var parametros = {
 			    'fanio' : fanio 
     };

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-saldos.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#resultadoFin").html('Procesando');

				},

			success:  function (data) {

					 $("#resultadoFin").html(data); 

				     

				} 

	});

}

 //------------------------------------------------------------------------- 

 function ResumenFinanciero()
{

	var fanio =     $("#fanio").val();

 	 var parametros = {
		    'fanio' : fanio 

    };

			$.ajax({
					data:  parametros,
					url:   '../model/Model-resumen.php',
					type:  'POST' ,
					cache: false,
					success:  function (data) {
						$("#ViewResumen").html(data); 
						} 
			});
 }
 /*
 resumen 
 */
function Reciprocas( tipo)
{


	var fanio     =     $("#fanio").val();
	var ffecha2   =     $("#ffecha2").val();
	var url = '';

 	 var parametros = {
		    'fanio' : fanio ,
			'ffecha2': ffecha2

    };

	if ( tipo == 0) {
		url = '../model/Model-reciprocas.php';
	}else{
		url =  '../model/Model-reciprocas_q.php';
	}
 
			$.ajax({
 				data:  parametros,
				url:   url,
			    type:  'POST' ,
			    cache: false,
				beforeSend: function () { 

					$("#ViewBalance").html('Procesando');

			  },
				success:  function (data) {
						$("#ViewBalance").html(data); 
					
				} 
 			});
 

 }
 /*
 
 */
 function Reciprocas_val( )
 {
 
 
	 var fanio     =     $("#fanio").val();
	 var ffecha2   =     $("#ffecha2").val();
 
	 var url = '../model/ajax_valida_reciprocas.php?anio='+fanio+'&fecha=' + ffecha2;
			  
	 window.open(url ,'#','width=750,height=480,left=30,top=20');
  
 
  }
 //--Archivo_balance
 function Archivo_balance(tipo)
 {
	 
	 var ffecha2    = $("#ffecha2").val();
	 var codigoc    = $("#codigoc").val();
	 var unidade    = $("#unidade").val();
     	
   	 var parametros = {
 			    'codigoc' : codigoc,
			    'unidade' : unidade
	 };
	
	 $.ajax({
		 data:  parametros,
			url: "../model/ajax_CodigoUE.php",
			type: "GET",
			success: function(response)
			{
					$('#result').html(response);
			}
			});
	 
    	
	   	
		if ( ffecha2){
 			
			  var url = '../model/archivo_finanzas?id='+tipo+'&periodo=' + ffecha2;
			  
		 	  window.open(url ,'#','width=750,height=480,left=30,top=20');
		 	  
		}
	 		
		
 }
 //--------------
 function SeleccionaGrupo(tipo)
 {
	 
	 var parametros = {

			    'tipo' : tipo
	 };
	
	 $.ajax({
		 data:  parametros,
			url: "../model/Model_busca_cuenta_valida.php",
			type: "GET",
			success: function(response)
			{
					$('#ngrupo').html(response);
			}
			});
	 
		
 }
 /*
 
 */
 function AnalisisReciproco( tipo )
 {

 
  
	 
	 var parametros = {
 		'tipo':tipo ,

	 };
	

	 alertify.confirm("<p> Desea Analizar informacion registro<br></p>", function (e) {

		if (e) {

			$.ajax({
				data:  parametros,
				   url: "../model/ajax_reciprocas_actualizar.php",
				   type: "POST",
				   success: function(response)
				   {
						   $('#DatosReciprocas').html(response);
	   
				   }
				   });
 	   
				   Reciprocas(1);
		 }

	 }); 

 
 }
 //
 function CopiarReciproco( )
 {

 
    var	id_reciproco=	$("#id_reciproco").val();
 
	 
	 var parametros = {
 		'id_reciproco':id_reciproco 
	 };
	

	 alertify.confirm("<p> Desea Copiar registro<br></p>", function (e) {

		if (e) {

			$.ajax({
				data:  parametros,
				   url: "../model/ajax_reciprocas_copiar.php",
				   type: "POST",
				   success: function(response)
				   {
						   $('#DatosReciprocas').html(response);
	   
				   }
				   });
 	   
				   Reciprocas(1);
		 }

	 }); 

 
 }
 /*
 elimina fila del archivo
 */
 function EliminarReciproco( )
 {

 
    var	id_reciproco=	$("#id_reciproco").val();
 
	 
	 var parametros = {
 		'id_reciproco':id_reciproco 
	 };
	

	 alertify.confirm("<p> Desea eliminar registro<br></p>", function (e) {

		if (e) {

			$.ajax({
				data:  parametros,
				   url: "../model/ajax_reciprocas_del.php",
				   type: "POST",
				   success: function(response)
				   {
						   $('#DatosReciprocas').html(response);
	   
				   }
				   });
 	   
				   Reciprocas(1);
		 }

	 }); 

 
 }
 /*
 */
 function ValidaReciproco( )
 {

var	cuenta_1=	$("#cuenta_1").val();
var	nivel_11=	$("#nivel_11").val();
var	nivel_12=	$("#nivel_12").val();
var	deudor_1=	$("#deudor_1").val();
var	acreedor_1=	$("#acreedor_1").val();
var	ruc1=	$("#ruc1").val();
var	nombre=	$("#nombre").val();
var	grupo=	$("#grupo").val();
var	subgrupo=	$("#subgrupo").val();
var	item=	$("#item").val();
var	cuenta_2=	$("#cuenta_2").val();
var	nivel_21=	$("#nivel_21").val();
var	nivel_22=	$("#nivel_22").val();
var	deudor_2=	$("#deudor_2").val();
var	acreedor_2=	$("#acreedor_2").val();
var	asiento=	$("#asiento").val();
var	fecha=	$("#fecha").val();
var	fecha_pago=	$("#fecha_pago").val();
var	id_reciproco=	$("#id_reciproco").val();
var	id_asiento_ref=	$("#id_asiento_ref").val();

	 
	 var parametros = {
		'cuenta_1':cuenta_1,
		'nivel_11':nivel_11,
		'nivel_12':nivel_12,
		'deudor_1':deudor_1,
		'acreedor_1':acreedor_1,
		'ruc1':ruc1,
		'nombre':nombre,
		'grupo':grupo,
		'subgrupo':subgrupo,
		'item':item,
		'cuenta_2':cuenta_2,
		'nivel_21':nivel_21,
		'nivel_22':nivel_22,
		'deudor_2':deudor_2,
		'acreedor_2':acreedor_2,
		'asiento':asiento,
		'fecha':fecha,
		'fecha_pago':fecha_pago,
		'id_reciproco':id_reciproco,
		'id_asiento_ref':id_asiento_ref 
	 };
	
	 $.ajax({
		 data:  parametros,
			url: "../model/ajax_reciprocas_update.php",
			type: "POST",
			success: function(response)
			{
					$('#DatosReciprocas').html(response);

			}
			});


			Reciprocas(1);
		 
	 
		
 }

 //---------------------
 function VerReciprocas(codigo)
 {
	 
	 var parametros = {

			    'codigo' : codigo
	 };
	
	 $.ajax({
		 data:  parametros,
			url: "../controller/Controller-co_reciprocas.php",
			type: "GET",
			success: function(response)
			{
					$('#FiltroReciprocas').html(response);
			}
			});

			$('#myModalReci').modal('show');
	 
		
 }
 //--------------
 function SeleccionaSubGrupo(tipo)
 {
	 
	 var parametros = {

			    'tipo' : tipo
	 };
	
	 $.ajax({
		 data:  parametros,
			url: "../model/Model_busca_scuenta_valida.php",
			type: "GET",
			success: function(response)
			{
					$('#nsubgrupo').html(response);
			}
			});
	 
		
 }
 //-----------------------
 function SeleccionaSubItem(tipo)
 {
	 
	 //	ngrupo	nsubgrupo	  nitem
	 
	 var parametros = {

			    'tipo' : tipo
	 };
	
	 $.ajax({
		 data:  parametros,
			url: "../model/Model_busca_icuenta_valida.php",
			type: "GET",
			success: function(response)
			{
					$('#nitem').html(response);
			}
			});
	 
		
 }
//---------------------------------------------------------
 function Cedula_Resumen(tipo)

 {

	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
 
 	 var parametros = {

			    'ffecha1' : ffecha1, 
 			    'ffecha2' : ffecha2,
 			    'tipo' : tipo
 			    

    };

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-CedulaResumen_Esigef.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#ViewCedulaPresupuestaria").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewCedulaPresupuestaria").html(data); 
 
				} 

	});

      

 }
//--------------- 
function ValidaEsigef( )
{

	$.ajax({
 	   url:   '../model/ajax_view_valida.php',
	   type:  'GET' ,
	   cache: false,
	   beforeSend: function () { 
		$("#Filtrovalidacion").html('Procesando');
		},
		success:  function (data) {
			$("#Filtrovalidacion").html(data); 
		
		} 

   });

}	
//-----------
function myFunction(codigo,objeto)

 {
 	   var accion = 'impresion';
  	   var estado = '0';

	    if (objeto.checked == true){
 	    	estado = '1';
 	    } else {
 	    	estado = '0';
 	    }

 
	    var parametros = {
 				 'accion' : accion ,
                 'id'     : codigo ,
                 'estado' : estado

	  };

	 
      
 $.ajax({
 				data:  parametros,
 				url:   '../model/Model-co_plan_ctas.php',
 				type:  'GET' ,
 				cache: false,
 				beforeSend: function () { 
 						$("#result").html('Procesando');
 					},
 				success:  function (data) {
 						 $("#result").html(data);  // $("#cuenta").html(response);
 					} 
 		}); 
 
 }
//-------------------
function ValidaCuenta( )
{

	$.ajax({
 	   url:   '../model/ajax_view_valida_matriz.php',
	   type:  'GET' ,
	   cache: false,
	   beforeSend: function () { 
		$("#Filtrovalidacion").html('Procesando');
		},
		success:  function (data) {
			$("#Filtrovalidacion").html(data); 
		
		} 

   });

}	
//-------------------------------------------------------------------------
function irAsientoPago(idasiento){        
 	
     
	var posicion_x; 
	var posicion_y; 
  
	var enlace = '../view/co_validacion_asiento_pago?codigo=' + idasiento  ;
  
  
	
	
	var ancho = 1000;
	
	var alto = 475;
	
   
	
	posicion_x=(screen.width/2)-(ancho/2); 
	posicion_y=(screen.height/2)-(alto/2); 
	
	 window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//------------------------------------------------------------------------- 
function revisa_flujo(celda, codigo)
{


	$('#myModalAsientos').modal('show');

 

	var ffecha1 = $("#ffecha1").val();
	var ffecha2 = $("#ffecha2").val();

	var parametros = {
		'ffecha1' : ffecha1, 
		'ffecha2' : ffecha2,
 		 'codigo' : codigo,
		 'accion':1
};
 	
		$.ajax({
 			data:  parametros,
			url:   '../model/Model-FlujoEsigef_valida.php',
		    type:  'POST' ,
		  cache: false,
		success:  function (data) {
			$("#FiltroPresupuesto").html(data); 
		 
			} 

		});
 



}	
//--------------
function verifica_datos(item, tipo)
{

	var ffecha1 = $("#ffecha1").val();
	var ffecha2 = $("#ffecha2").val();


	var parametros = {
		'ffecha1' : ffecha1, 
		'ffecha2' : ffecha2,
		'tipo' : tipo ,
		'item': item 
};

$.ajax({

	data:  parametros,
	url:   '../model/ajax_mov_items.php',
   type:  'GET' ,
   cache: false,
   beforeSend: function () { 
			   $("#FiltroPresupuesto").html('Procesando');
	   },
   success:  function (data) {
			$("#FiltroPresupuesto").html(data); 
		  
	   } 

});




}

// 1. balance de comprobacion 
//------------------------------------------------------------------------- 
function ResumenBalance()
{

	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();

 
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();

	  var tipo =     $("#tipo").val();
	  var nivel =     $("#nivel").val();

 	 var parametros = {
			    'ffecha1' : ffecha1, 
			    'ffecha2' : ffecha2,
			    'tipo' : tipo ,
			    'nivel': nivel ,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta,
			    'valida'     : 'S'
    };

 

 	$.ajax({

			 data:  parametros,
			 url:   '../model/Model-Balance_Esigef.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewBalance").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewBalance").html(data); 
				   
				} 

	});

      

 }
 //---------------------------------------------------------------------------
 function ResumenBalanceNiveles()
{

	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();

	  // var id_asiento =     $("#id_asiento").val();
	  // var cuentat    =     $("#cuentat").val();
 	  
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();

	  var tipo =     $("#tipo").val();
	  var nivel =     $("#nivel").val();

 	 var parametros = {
			    'ffecha1' : ffecha1, 
			    'ffecha2' : ffecha2,
			    'tipo' : tipo ,
			    'nivel': nivel ,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta,
			    'valida'     : 'S'
    };

 

 	$.ajax({

			 data:  parametros,
			 url:   '../model/Model-Balance_Esigef_nivel.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewBalance").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewBalance").html(data); 
				   
				} 

	});

      

 }
//------------------------------------------------------------------------- 
function ResumenBalance_Resumen()
{

	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();

	  var id_asiento =     $("#id_asiento").val();
 	  var cuentat    =     $("#cuentat").val();
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();

	  var tipo =     $("#tipo").val();
	  var nivel =     $("#nivel").val();

 	 var parametros = {
			    'ffecha1' : ffecha1, 
			    'ffecha2' : ffecha2,
			    'tipo' : tipo ,
			    'nivel': nivel ,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta,
			    'valida'     : 'S'
    };

 

 	$.ajax({

			data:  parametros,

			 url:   '../model/Model-Balance_Esigef_archivo.php',

			type:  'POST' ,

			cache: false,

			beforeSend: function () { 

						$("#ViewBalance").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewBalance").html(data); 

				     

				} 

	});

      

 }
//-------------ngrupo
function BusquedaGrupo()
{


	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
 

	  var ngrupo =     $("#ngrupo").val();
	  var nsubgrupo =     $("#nsubgrupo").val();
	  var nitem =     $("#nitem").val();
	  
 
	  

 	 var parametros = {
			    'bgfecha1' : ffecha1, 
			    'bgfecha2' : ffecha2,
			    'ngrupo' : ngrupo,
			    'nsubgrupo': nsubgrupo,
			    'nitem' : nitem,
			    'tipo' : 0
     };

 
 	$.ajax({
			data:  parametros,
			 url:   '../model/Model-Situacion_valida.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFlujo").html('Procesando');

				},
			success:  function (data) {

					 $("#ViewFlujo").html(data); 

				} 

	});

 } //
//------------------------------------------------------------------------- 
function BusquedaGrupoItem()
{


	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
 

	  var ngrupo =     $("#ngrupo").val();
	  var nsubgrupo =     $("#nsubgrupo").val();
	  var nitem =     $("#nitem").val();
	  
 
	  

 	 var parametros = {
			    'bgfecha1' : ffecha1, 
			    'bgfecha2' : ffecha2,
			    'ngrupo' : ngrupo,
			    'nsubgrupo': nsubgrupo,
			    'nitem' : nitem,
			    'tipo' : 1
     };

 
 	$.ajax({
			data:  parametros,
			 url:   '../model/Model-Situacion_valida.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFlujo").html('Procesando');

				},
			success:  function (data) {

					 $("#ViewFlujo").html(data); 

				} 

	});

 } 
 //-------------
 function PresupuestoInicial()
 {
 
 
	   var ffecha1 = $("#ffecha1").val();
	   var ffecha2 = $("#ffecha2").val();
  
 
	   var tipo =     $("#tipo").val();
	   var nivel =     $("#nivel").val();
 
	   var parametros = {
				 'bgfecha1' : ffecha1, 
				 'bgfecha2' : ffecha2,
	  };
 
  
	  $.ajax({
			 data:  parametros,
			  url:   '../model/Model-CedulaInicial_Esigef.php',
			 type:  'POST' ,
			 cache: false,
			 beforeSend: function () { 
						 $("#ViewCedulaPresupuestaria").html('Procesando');
 
				 },
			 success:  function (data) {
 
					  $("#ViewCedulaPresupuestaria").html(data); 
 
				 } 
 
	 });
 
  }
//---------
 function CedulaPresupuestaria()
{


	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
 

	  var tipo =     $("#tipo").val();
	  var nivel =     $("#nivel").val();

 	 var parametros = {
			    'bgfecha1' : ffecha1, 
			    'bgfecha2' : ffecha2,
     };

 
 	$.ajax({
			data:  parametros,
			 url:   '../model/Model-CedulaSituacion_Esigef.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewCedulaPresupuestaria").html('Procesando');

				},
			success:  function (data) {

					 $("#ViewCedulaPresupuestaria").html(data); 

				} 

	});

 }

//------------------------------------------------------------------------- 

 function EnlaceContablePresupuesatario(tipo)
{

	  var ffecha1 = $("#ffecha1").val();
 	  var ffecha2 = $("#ffecha2").val();
   

	  var tipo =     $("#tipo").val();

	  var nivel =     $("#nivel").val();

	 

	 var parametros = {
 			    'brfecha1' : ffecha1, 
 			    'brfecha2' : ffecha2,
 			    'tipo' : tipo ,
 			    'nivelr': nivel ,
 
   };

	  

 	$.ajax({

			data:  parametros,

			 url:   '../model/Model-FlujoEsigef.php',

			type:  'POST' ,

			cache: false,

			beforeSend: function () { 

						$("#ViewFlujo").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewFlujo").html(data); 

				     

				} 

	});

      

 }

//------------------------------------------- 

 function imprimir(nombreDiv) {

		

	    var contenido= document.getElementById(nombreDiv).innerHTML;

	    

	     var contenidoOriginal= document.body.innerHTML;



	     document.body.innerHTML = contenido;



	     window.print();



	     document.body.innerHTML = contenidoOriginal;
 
	      

	}
 
 //------
 function ResumenEjecucion()
{

  	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
 

 	 var parametros = {
 			    'ffecha1' : ffecha1, 
 			    'ffecha2' : ffecha2
      };

 	$.ajax({
			 data:  parametros,
			 url:   '../model/Model-Eejecucion.php',
			 type:  'POST' ,
			 cache: false,
			 beforeSend: function () { 
						$("#ViewEjecucion").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewEjecucion").html(data); 
				} 

	});

      

 }