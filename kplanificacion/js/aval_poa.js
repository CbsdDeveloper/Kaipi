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
	    	Gastos() ;
		});

	    $('#loadCer').on('click',function(){
	    	GastosCerti() ;
		});
 
	    
 

	    $('#loadxls').on('click',function(){
 	    	  var page   = "../reportes/excel_tramite.php?tipop=G" ;
	    	  window.location = page;  
 		});
 	    
 
	    $('#loadSaldos').on('click',function(){
	        var fanio = $("#fanio").val();
	    	SaldoPresupuesto('I') ;
 		});

	    $('#loadSaldosg').on('click',function(){
 	    	    SaldoPresupuesto('G') ;
 		});
	    
	    
	    $('#loadDetalle').on('click',function(){
	    	tramites_filtro();
		});
	    
	    $('#loadDetalleHis').on('click',function(){
	    	tramites_filtro_conta();
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
 function CargaDatos(idtramite) {


	
		   $("#tramite").val(idtramite);  

			var parametros = {
									"idtramite" : idtramite ,
								    "accion" : 'visor'
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/ajax_fecha_presupuesto.php',
									dataType: "json",
									success:  function (response) {
 
											 $("#fecha").val( response.a );  
											 
											 $("#fechac").val( response.b );  

											 $("#fechacc").val( response.c );  

											 $("#festado").val( response.d );  
											  
									} 
							});


} 	 
//------------------------------------------------------------------------- 
 function ActualizaInformacion( ) {


	var  idtramite = $("#tramite").val( );  
	var fecha = $("#fecha").val();
	var fechac = $("#fechac").val();
	var fechacc = $("#fechacc").val();
	var festado = $("#festado").val();
	  
 

	var parametros = {
			"idtramite" : idtramite ,
			"fecha" :  fecha,
			"fechac" : fechac,
			"fechacc" : fechacc,
			"festado" :festado,
			"accion" : 'edit'
		};


 alertify.confirm("Desea actualizar la informacion", function (e) {
			  if (e) {
				 
		 			$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/ajax_fecha_presupuesto.php',
									success:  function (response) {
 
										 $("#guardarProducto").html( response );  
											
											  
									} 
							});  
					 
			  }
			 }); 


 

} 	 
//-----------------------------------------------------
function modulo()

 {

 	 var modulo1 =  'kplanificacion';

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

  

	 $("#ViewFiltro").load('../controller/Controller-aval_poa.php');

 
	 
 }
  
//------------------------
 function Gastos( )
 {
  
 	  var ffecha1   = $('#ffecha1').val(); 
 	  var ffecha2   = $('#ffecha2').val(); 
 	  
 	  var fmodulo = $('#fmodulo').val(); 
       var vunidad = $('#vunidad').val(); 
  
  
 	  var parametros = {
 			    'ffecha1' : ffecha1 ,
 			    'ffecha2' : ffecha2 ,
 				'fmodulo' : fmodulo ,
 				'vunidad' : vunidad
    };

 	  

 	$.ajax({

 			data:  parametros,

 			 url:   '../model/Model_reportes_aval_poa.php',

 			type:  'GET' ,

 			cache: false,

 			beforeSend: function () { 

 						$("#ViewFormIngresos").html('Procesando');

 				},

 			success:  function (data) {

 					 $("#ViewFormIngresos").html(data);   

 				 

 				} 

 	});

  
 } 
//-----------------
 function GastosCerti( )
 {
  
 	  var ffecha1   = $('#ffecha1').val(); 
 	  var ffecha2   = $('#ffecha2').val(); 
 	  
 	  var fmodulo = $('#fmodulo').val(); 
       var vunidad = $('#vunidad').val(); 
  
  
 	  var parametros = {
 			    'ffecha1' : ffecha1 ,
 			    'ffecha2' : ffecha2 ,
 				'fmodulo' : fmodulo ,
 				'vunidad' : vunidad,
 				'tipo' : 'detalle'
    };

 	  

 	$.ajax({

 			data:  parametros,

 			 url:   '../model/Model_reportes_gestion.php',

 			type:  'GET' ,

 			cache: false,

 			beforeSend: function () { 

 						$("#ViewFormIngresos").html('Procesando');

 				},

 			success:  function (data) {

 					 $("#ViewFormIngresos").html(data);   

 				 

 				} 

 	});

  
 } 
///------------------- 
 function tramites_filtro_conta( )
 {
  
  	  var partidac   		 = $('#partidac').val(); 
  	  var ffecha1   		 = $('#ffecha1').val(); 
 	  var ffecha2   		 = $('#ffecha2').val(); 
 	  
 	  
 	  
  	  var parametros = {
 			    'ffecha1' : ffecha1 ,
 			    'ffecha2' : ffecha2 ,
 			    'partidac' : partidac  
      };


 	$.ajax({
 			 data:  parametros,
 			 url:   '../model/Model_reportes_gestion_conta.php',
 			 type:  'GET' ,
 			 cache: false,
 			 beforeSend: function () { 
 						$("#DetalleVistaInformacion").html('Procesando');
 				},
 			success:  function (data) {
 					 $("#DetalleVistaInformacion").html(data);   
 				} 

 	});
 } 
//-------------------
function tramites_filtro( )
{
 
	  var id_departamentoc   = $('#id_departamentoc').val(); 
	  var partidac   		 = $('#partidac').val(); 
	  
 	  var parametros = {
			    'id_departamentoc' : id_departamentoc ,
			    'partidac' : partidac  
     };


	$.ajax({
			 data:  parametros,
			 url:   '../model/Model_reportes_gestion_tramite.php',
			 type:  'GET' ,
			 cache: false,
			 beforeSend: function () { 
						$("#DetalleVistaInformacion").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleVistaInformacion").html(data);   
				} 

	});
} 
//-----------------------------------
   
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
   
 

 
