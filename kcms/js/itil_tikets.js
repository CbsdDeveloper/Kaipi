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

 

	    $('#loadxls').on('click',function(){
 	    	  var page   = "../reportes/excel_tramite.php?tipop=G" ;
	    	  window.location = page;  
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
//---- 
 function CambioEstado() {
	 
	 
	var idtiket =  $("#idtiki").val();
	 
	  alertify.confirm("Desea cerrar el tiket " + idtiket, function (e) {
		  if (e) {
			 
             	
		   var parametros = {
			            'idtiket' : idtiket  
			};

					$.ajax({
								data:  parametros,
								url:   '../model/Model-SoporteTecnicoCierre.php' ,
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
											$("#BandejaDa").html('Procesando');
										},
									success:  function (data) {
											 $("#BandejaDa").html(data);  
										     
										} 
							}); 
                 
				 
		  }
		 }); 
	  
 }
//------------------------------------------------------------------------- 
 function CargaDatos(idtiket) {
 
	 
 
	 
	 $("#idtiki").val(idtiket);

		var parametros = {
	            'idtiket' : idtiket  
	};

			$.ajax({
						data:  parametros,
						url:   '../model/Model-SoporteTecnicoAvance.php' ,
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#BandejaDatosSeg").html('Procesando');
								},
							success:  function (data) {
									 $("#BandejaDatosSeg").html(data);  
								     
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

	 var modulo1 =  'kcms';

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

  

	 $("#ViewFiltro").load('../controller/Controller-itil_reporte.php');

 
	 
 }
  
//------------------------
//-------------------
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

			 url:   '../model/Model-itil_reporte.php',

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
   
 

 
