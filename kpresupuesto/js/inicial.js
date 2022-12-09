var oTableGrid;  

var oTable ;

"use strict"; 

 

//-------------------------------------------------------------------------

$(document).ready(function(){

        oTable = $('#jsontable').dataTable(); 

        oTableGrid = $('#ViewCuentas').dataTable();  

		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');
 

		modulo();

	    FormFiltro();
 	    

	    $('#load').on('click',function(){
	    	Ingresos() ;
		});

	
	    $('#loadg').on('click',function(){
	    	Gastos() ;
		});

		$('#loadSri').on('click',function(){
			//    openFile('../../upload/uploadxml?file=1',650,300)
		});

		$('#loadAuxView').on('click',function(){
            BusquedaGrilla( );
		});
 	 
 		
	 		
	    $('#loadxls').on('click',function(){
	    	  var fanio = $("#fanio").val();
	    	  var page   = "../reportes/excel.php?tipo=I&fanio="+fanio ;
	    	  window.location = page;  
		});

	    $('#loadxlsg').on('click',function(){
	    	  var fanio = $("#fanio").val();
	    	  var page   = "../reportes/excel.php?tipo=G&fanio="+fanio ;
	    	  window.location = page;  
 		});
 	    
 
	    $('#loadSaldos').on('click',function(){
	        var fanio = $("#fanio").val();
	    	SaldoPresupuesto('I') ;
 		});

	    $('#loadSaldosg').on('click',function(){
 	    	    SaldoPresupuesto('G') ;
 		});
	    
	    
	    var j = jQuery.noConflict();

		j("#loadprintg").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#ViewFormGastos").printArea( options );

		});
	 
		
		j("#loadprint").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};

		  j("#ViewFormIngresos").printArea( options );

	});
	 

});  

//-----------------------------------------------------------------

 

function changeAction(tipo,action,mensaje){

	

 	

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

				 

			  		//$('#mytabs a[href="#tab2"]').tab('show');

                	

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

					url:   '../model/Model-co_xpagar.php',

					type:  'GET' ,

					cache: false,

					beforeSend: function () { 

 							$("#result").html('Procesando');

  					},

					success:  function (data) {

						

						

							 $("#result").html(data);  // $("#cuenta").html(response);

						     

						 	 var idprov =  $("#idprov").val();

							 

					 		 ListaAux(idprov);

  					} 

			}); 

	  

     }

//-------------------------------------------------------------------------
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
//------------------------------------------------------------------------- 
  function Ingresos()

  {
  

	  var fanio   = $('#fanio').val(); 
	  var vfuente = $('#vfuente').val(); 
	  var vgrupo = $('#vgrupo').val(); 
	 
	 
	  
	  if ( 	$("#bi").val() == '0' ) {
		    $("#bi").val('1');
	  }
	  
	  var parametros = {

 			    'fanio' : fanio ,
 			    'vfuente' : vfuente , 
 			    'tipo' : 'I',
 			    'vgrupo' : vgrupo
     };

	  

  	$.ajax({

 			data:  parametros,

 			 url:   '../model/Model_inicial_ingreso.php',

 			type:  'GET' ,

 			cache: false,

 			beforeSend: function () { 

 						$("#ViewFormIngresos").html('Procesando');

 				},

 			success:  function (data) {

 					 $("#ViewFormIngresos").html(data);   

 				  	Total_Presupuesto();
 				   

 				} 

 	});

  	

  	

  }

  //------------------------------------------------------------------------- 
 
//------------------------------------------------------------------------- 

 function modulo()

 {

 	 var modulo1 =  'kpresupuesto';

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

//----------------------

 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-inicial_filtro.php');

	 
	 $("#ViewFiltrog").load('../controller/Controller-inicialg_filtro.php');
	 
 }
  
//------------------------
//-------------------
function Gastos( )

{


	  var fanio   = $('#fanio').val(); 
	  var vfuente = $('#vfuentegg').val(); 
	  
	  var vgrupo = $('#vgrupog').val(); 
	  var vactividad = $('#vactividad').val(); 
	  
	  var vprograma = $('#vprograma').val(); 
	  
	  
	  
	  if ( 	$("#bg").val() == '0' ) {
		  $("#bg").val('1');
	  }
	  
	  var parametros = {

			    'fanio' : fanio ,
			    'vfuente' : vfuente , 
			    'tipo' : 'G',
			    'vgrupo': vgrupo,
			    'vactividad' : vactividad,
			    'vprograma' : vprograma
   };

	  

	$.ajax({

			data:  parametros,

			 url:   '../model/Model_inicial_ingreso.php',

			type:  'GET' ,

			cache: false,

			beforeSend: function () { 

						$("#ViewFormGastos").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewFormGastos").html(data);   

					 Total_Presupuesto();

				} 

	});

	


} 
//-----------------------------------
function Detallepartidas( partida, tipo,i  )
{
	  var fanio = $("#fanio").val();
	  
 
	 var parametros = {
			    'fanio' : fanio ,
			    'partida': partida,
			    'tipo'	: tipo,
				'cmes' : '-'
 			  
	  };

 
	 
	  $.ajax({

			data:  parametros,
			url:   '../model/Model_detalle_presupuesto.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 					 $("#ViewDetallePartida").html(data);   
  				} 

	  });
	 
 
} 
//-----SaldoIngreso  
function Total_Presupuesto(){

	  var fanio = $("#fanio").val();
 
	  var parametros = {
			    'fanio' : fanio  
 			  
	  };

	  $.ajax({

			data:  parametros,
			url:   '../model/ajax_saldo_presupuesto.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 					 $("#presupuesto_total").html(data);   
  				} 

	  });
 
} 
//--------------------------------------

function SaldoPresupuesto(tipo )

{


	  var fanio   = $('#fanio').val(); 
   	 
	  var parametros = {
			    'fanio' : fanio ,
			    'tipo' : tipo
			  
	  };

	  $.ajax({

			data:  parametros,
			url:   '../model/Model_saldo_ingreso.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 					 $("#SaldoIngreso").html(data);   
  				} 

	  });
	  
	  if ( tipo == 'I' ){
		  Ingresos() ;
	  }else{
		  Gastos();
	  }
	
	  Total_Presupuesto();

} 
//------------------------------------
function openFile(url,ancho,alto) {

    

	  var posicion_x; 

  var posicion_y; 

  var enlace; 

  

  posicion_x=(screen.width/2)-(ancho/2); 

  posicion_y=(screen.height/2)-(alto/2); 

 

  enlace = url  ;



  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

}
 

//--------------------
   
 

 
