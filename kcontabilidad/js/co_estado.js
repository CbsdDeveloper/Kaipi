$(document).ready(function(){


		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		modulo();

 	    FormFiltro();

 	    FormFiltroLibro();
 	    
 	    ResumenNotas();
 
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

 		  ResumenResultados();

 	   });      
 	   

		$('#financiero3').on('click',function(){

  		  ResumenBalance();
 			

 		});      


		 $('#financiero39').on('click',function(){

  		  ResumenBalanceNiveles();
 			

 		}); 

 	   

 	  $('#financiero4').on('click',function(){

		  ResumenBalanceG();

		});         

 	  
 	  $('#financiero5').on('click',function(){

		  ResumenBalanceR();
			

		});  

 	   $('#financiero6').on('click',function(){

 		  ResumenFlujo();

		});  

 	   $('#financiero66').on('click',function(){

 		  ResumenEjecucion();

 		});  
 	  

  	  $("#excelButtonBalance").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewBalance').html()));

	        e.preventDefault();

	    });

		$("#excelButtonEstado").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewBalanceSituacion').html()));

	        e.preventDefault();

	    });

	$("#excelButtonResultado").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewResultadosEsigef').html()));

	        e.preventDefault();

	    });

	$("#excelButtonFlujo").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewFlujo').html()));

	        e.preventDefault();

	    });

	$("#excelButtonEjecucion").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewEjecucion').html()));

	        e.preventDefault();

	    });








	 $("#excelButtonLibro").click(function(e) {

	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#Viewlibro').html()));

	        e.preventDefault();

	    });

 	    

	    var j = jQuery.noConflict();

		j("#printButtonBalance").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#ViewBalance").printArea( options );

		});

});  
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
//----------------------
 function FormFiltro()
{

	 $("#ViewFiltro").load('../controller/Controller-co_analisis_filtro.php');

	 
	 $("#ViewNotas").load('../controller/Controller-co_analisis_notas.php');
	 
	 
	 
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

 

 //----------

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

			beforeSend: function () { 

						$("#ViewResumen").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewResumen").html(data); 

				     

				} 

	});

      

 }
 
 //--Archivo_balance

//------------------------------------------------------------------------- 
 function Archivo_balance(tipo)
 {
	 
	  var ffecha2 = $("#ffecha2").val();
	   	
		if ( ffecha2){
 			
			  var url = '../model/archivo_finanzas?id='+tipo+'&periodo=' + ffecha2;
			  
		 	  window.open(url ,'#','width=750,height=480,left=30,top=20');
		 	  
		}
	 		
		
 }
 
//---------------------------------------------------------
 function ResumenResultados()

 {

  	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var com1 = $("#com2").val();
 
 	 var parametros = {

			    'ffecha1' : ffecha1, 
 			    'ffecha2' : ffecha2,
 			    'com1' : com1
     };

 	$.ajax({
			data:  parametros,
			url:   '../model/Model-ResultadosEsigef.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 

						$("#ViewResultadosEsigef").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewResultadosEsigef").html(data); 
 
				} 

	});

      

 }

//------------------------------------------------------------------------- 
 
 //------------------------------------------------------------------------- 
function ResumenBalance()
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
			    'cuenta'     : cuenta
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
			    'cuenta'     : cuenta
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
//------------------------------------------------------------------------- 

 function ResumenBalanceG()
{


	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();

 
 	  var com1    =     $("#com1").val();
	  var cuenta     =     $("#cuenta").val();
	  var auxiliares =     $("#auxiliares").val();

	  var tipo =     $("#tipo").val();
	  var nivel =     $("#nivel").val();

 	 var parametros = {
			    'bgfecha1' : ffecha1, 
			    'bgfecha2' : ffecha2,
			    'tipo' : tipo ,
			    'nivelg': nivel ,
			    'auxiliares' : auxiliares,
			    'cuenta'     : cuenta,
			    'com1' : com1
    };

 
 	$.ajax({
			data:  parametros,
			 url:   '../model/Model-BalanceSituacion_Esigef.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewBalanceSituacion").html('Procesando');

				},
			success:  function (data) {

					 $("#ViewBalanceSituacion").html(data); 

				} 

	});

 }
//-----------
 function ResumenNotas()
 {

	 
  	  var ffecha2 = $("#ffecha2").val();
 
	 var parametros = {
 			    'accion' : 'visor' ,
 			    'brfecha2' : ffecha2
};
	 
  
  	$.ajax({
  			 data:  parametros,
  			 url:   '../model/ajax_nota_estados.php',
 			type:  'POST' ,
 			cache: false,
 			beforeSend: function () { 
 						$("#ViewNotasDetalle").html('Procesando');

 				},
 			success:  function (data) {

 					 $("#ViewNotasDetalle").html(data); 

 				} 

 	});

  }
//------------------------------------------------------------------------- 

 function ResumenFlujo()
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