var oTableGrid;  

var oTable ;

"use strict"; 

 

 
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
 	 
		$('#loadg1').on('click',function(){
            BusquedaGerencial( );
		});
		
		$('#loadg2').on('click',function(){
            BusquedaGerencial2( 'G' );
		});
		
		$('#loadg3').on('click',function(){
            BusquedaGerencial2( 'I' );
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
	 
		j("#loadg122").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};

		  j("#ViewFormResumen").printArea( options );

	});
		
		
 
		
		
		
		

});  

//-----------------------------------------------------------------

function copiarAlPortapapeles(id_elemento) {
	  var aux = document.createElement("input");
	  aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
	  document.body.appendChild(aux);
	  aux.select();
	  document.execCommand("copy");
	  document.body.removeChild(aux);
	  alert("Contenido Copiado... vaya excel!!!");
	}

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
	 
	  var cmes  = $('#cmes').val(); 
	  var cmesi = $('#cmesi').val(); 
	  
	  
	    var clasificador = $('#clasificadori').val(); 
	  
	  if ( 	$("#bi").val() == '0' ) {
		    $("#bi").val('1');
	  }
  
	  var parametros = {

 			    'fanio' : fanio ,
 			    'vfuente' : vfuente , 
 			    'tipo' : 'I',
 			    'vgrupo' : vgrupo,
 			    'cmes': cmes,
 			    'cmesi' : cmesi,
				'clasificador' : clasificador
     };

	  

  	$.ajax({

 			data:  parametros,

 			 url:   '../model/Model_reportes_presupuesto.php',

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

  

	 $("#ViewFiltro").load('../controller/Controller-inicial_filtro_rep.php');

	 
	 $("#ViewFiltrog").load('../controller/Controller-inicialg_filtro_rep.php');
	 
 }
  
//------------------------
 function Gastos( )

 {


 	  var fanio   = $('#fanio').val(); 
 	  var vfuente = $('#vfuentegg').val(); 
 	  
 	  var vgrupo = $('#vgrupog').val(); 
 	  var vactividad = $('#vactividad').val(); 
 	  
 	  var vprograma = $('#vprograma').val(); 
 	  
 	  var cmes = $('#cmes').val(); 
 	  
 	  var cmesi = $('#cmesi').val(); 

     var clasificador = $('#clasificador').val(); 
 	  
 	  if ( 	$("#bg").val() == '0' ) {
 		  $("#bg").val('1');
 	  }
 	  
 	  var parametros = {
 			    'cmes' : cmes ,
 			    'fanio' : fanio ,
 			    'vfuente' : vfuente , 
 			    'tipo' : 'G',
 			    'vgrupo': vgrupo,
 			    'vactividad' : vactividad,
 			    'vprograma' : vprograma,
 			    'cmesi' : cmesi,
				'clasificador' : clasificador
    };

 	  

 	$.ajax({

 			data:  parametros,

 			 url:   '../model/Model_reportes_presupuesto.php',

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
//--------------------	 
function BusquedaGerencial2(tipo )
{

	  var fanio   = $('#fanio').val(); 
	  var cmes = $('#cmes').val(); 
	  
	  var parametros = {
			    'cmes' : cmes ,
			    'fanio' : fanio ,
			    'tipo' : tipo,
      } ;

	  
	$.ajax({
			data:  parametros,
			url:   '../model/Model_reportes_grupo_ag.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFormResumen").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormResumen").html(data);   
				} 
	});

} 
//-------------------
function BusquedaGerencial( )
{

	  var fanio   = $('#fanio').val(); 
	  var cmes = $('#cmes').val(); 
	  
	  var parametros = {
			    'cmes' : cmes ,
			    'fanio' : fanio ,
			    'tipo' : 'G',
      } ;

	  
	$.ajax({
			data:  parametros,
			url:   '../model/Model_reportes_grupo.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFormResumen").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormResumen").html(data);   
				} 
	});

} 
//-----------------------------------
function Detallepartidas( partida, tipo,i  )
{
	  var fanio = $("#fanio").val();
	   var cmes = $("#cmes").val();


 
	 var parametros = {
			    'fanio' : fanio ,
			    'partida': partida,
			    'tipo'	: tipo,
				'cmes':cmes
 			  
	  };

 
	 
	  $.ajax({

			data:  parametros,
			url:   '../model/Model_detalle_presupuesto.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 					 $("#ViewFiltroAux").html(data);   
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
   
 

function filterTable() {
	// Obtener el valor de búsqueda
	const input = document.getElementById("searchInput");
	const filter = input.value.toUpperCase();
	const table = document.getElementById("jtabla_gasto");
	const tr = table.getElementsByTagName("tr");

	// Iterar sobre las filas de la tabla y ocultar las que no coincidan
	for (let i = 1; i < tr.length; i++) { // Empezar en 1 para saltar el encabezado
		const td = tr[i].getElementsByTagName("td");
		console.log(td)
		let match = false;

		// Verificar cada celda de la fila
		for (let j = 0; j < td.length; j++) {
			if (td[j] && td[j].innerText.toUpperCase().indexOf(filter) > -1) {
				match = true;
				break;
			}
		}

		// Mostrar u ocultar la fila
		tr[i].style.display = match ? "" : "none";
	}
}
