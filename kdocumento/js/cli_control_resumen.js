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

	    $('#loadproceso').on('click',function(){
	    	DatosResumenTramites() ;
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
//------------------------------------------------------------------------- 
 function CargaDatos(idtramite) {


	
 

			var parametros = {
		            'id' : idtramite 
		    };

			$.ajax({
						data:  parametros,
						url:   '../model/Model-proceso_recorrido.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
								$("#ViewRecorrido").html('Procesando');
							},
						success:  function (data) {
								 $("#ViewRecorrido").html(data);  // $("#cuenta").html(response);
							     
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

	 var moduloOpcion =  'kdocumento';

 	 var parametros = {

			    'ViewModulo' : moduloOpcion 

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
function Ver_doc_user(idcaso) {

			var parametros = {
				'accion' : 'visor',
				'idcaso' : idcaso  
		};

		$.ajax({
				data:  parametros,
				url:   '../model/Model-caso__doc_tra.php',
				type:  'GET' ,
				success:  function (data) {
						$("#ViewFormfileDoc").html(data);   

				} 

		}); 
			
}
//-----------
function  ProcesoDoc( id)
{

	 

		var codigo    = $('#cod_doc').val(); 
		var documento = $('#doc').val(); 
		var secuencia = $('#sec').val(); 

		var cod_doc_ca  = $('#cod_doc_ca').val(); 

		var parametros = {
			'accion' : id  ,
			'codigo': codigo,
			'documento' : documento,
			'secuencia': secuencia,
			'cod_doc_ca':cod_doc_ca,
	    };

		alertify.confirm("<p>Desea generar este proceso?</p>", function (e) {
			if (e) {
			   
							$.ajax({
								data:  parametros,
								url:   '../model/Valida_secuencia_unidad.php',
								type:  'GET' ,
								success:  function (data) {
										$("#datos_actualiza").html(data);   
				
										Gastos( );
								} 
				
						}); 
				}
		   }); 

		

	 
}	
//------------

function  goToURLDocdel(codigo,id)
{

		alert('Opcion no permitida...');
}	
//----------------
function  Pone_doc_user(codigo,secuenci,documento,actual,cod_doc_ca)
{

	$('#cod_doc').val(codigo); 
	$('#doc').val(documento); 
	$('#sec').val(secuenci); 
 
	$('#sec_actual').val(actual); 

	$('#cod_doc_ca').val(cod_doc_ca); 
	
 
}	
//----------------------
function PoneDoc(file)
{
 
 
 var url = '../../userfiles/files/' + file;
 
 
	 var parent = $('#DocVisor').parent(); 
	 $('#DocVisor').remove(); 
	 
	 var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
	 parent.append(newElement); 
	 

	 
	 var myStr = file;
	   
    var strArray = myStr.split(".");
     
    if ( strArray[1] == 'pdf' ){
   	 
    	 
   	    $('#DocVisor').attr('src',url); 
   	    
   	 
 
    }else{
   	 
   	 $('#DocVisor').attr('src',url); 
    	 
 
    }  
 

	
  	
}
//-----------------------
 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-Proceso_doc_filtro.php');

 
	 
 }
  
//------------------------
function  formato_doc_visor( idcaso,idproceso_docu  )
{

	   var 	posicion_x; 
	   var 	posicion_y; 
	   var   	enlace = '../reportes/documento_matriz.php?caso='+idcaso+'&doc='+idproceso_docu;
	   var 	ancho = 1000;
	   var 	alto = 520;
	   
	   posicion_x=(screen.width/2)-(ancho/2); 
	   posicion_y=(screen.height/2)-(alto/2); 
	   
	   window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	   
 }
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

			 url:   '../model/Model-doc_reporteu.php',

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
function DatosResumenTramites( )
{
 
	  var canio   = $('#canio').val(); 
 
 
	  var parametros = {
			    'canio' : canio ,
			     
   };

	  

	$.ajax({

			data:  parametros,
 			url:   '../model/resumen_panel.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
 						$("#view_dato").html('Procesando');
 				},
 			success:  function (data) {
 					 $("#view_dato").html(data);   
 				} 

	   });
 
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
   
 

 
