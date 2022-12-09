/**
 * 
 */
"use strict";

var oTableGrid;  
var oTableTramite


//-------------------------------------------------------------------------
$(document).ready(function(){


         oTableGrid = $('#ViewCuentas').dataTable();  
          
         oTableTramite =  $('#jsontable_tramite').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "highlight", "aTargets": [ 1 ] },
		      { "sClass": "highlight", "aTargets": [ 2 ] }
		    ]
		  } );
        
    	$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		modulo();

	    FormView();

	    FormFiltro();

	    BusquedaGrillaTramite();
 
 
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



//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
// ir a la opcion de editar

function LimpiarPantalla() {


	


		var fecha = fecha_hoy();


	


		$("#fecha").val(fecha);


		


		$("#id_periodo").val("0");


		


    	$("#id_asiento").val(0);


	   


		$("#comprobante").val(" "); 


		$("#documento").val(" "); 


		$("#estado").val(" ");          


		$("#tipo").val(" ");


		$("#detalle").val("");


	 


		$("#action").val("add");


	 


		$("#fechaemision").val(fecha);


		


		$("#tipocomprobante").val("01");


		   


		$("#codsustento").val("01");


	   


	 	$("#serie").val("001001");


	   


		$("#secuencial").val("");


	   


		$("#autorizacion").val("");       


		


		$("#id_compras").val("");


		


		$("#idprov").val("");


		


		$("#razon").val("");


		


		$("#txtcuenta").val("");


		


		$("#cuenta").val("");


 


		


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


	


	$("#valretserv100").val(0);


	


	$("#baseimpair").val(0);


  


	$("#codretair").val("");    


	


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
function BusquedaGrillaTramite(oTableTramite){        	 


			$.ajax({
			    url: '../grilla/grilla_co_xpagar_tramite.php',
				dataType: 'json',
				cache: false,
				success: function(s){
				oTableTramite.fnClearTable();

				if(s){

					for(var i = 0; i < s.length; i++) {
						oTableTramite.fnAddData([
		                      s[i][0],
		                      s[i][1],
		                      s[i][2],
		                      s[i][3],
		                      s[i][4],
		                      s[i][5],
		                      '<button title="Tramite Generar Devengado " class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-ok"></i></button> ' 
		                  ]);									
					} // End For
				   }				
				},
				error: function(e){
				   console.log(e.responseText);	
				}
		 });
}   
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


  	<a class="btn btn-xs" href="javascript:open_pop('../model/ajax_delAsientosd','action=del&amp;tid=1079&amp;codigo=298',30,30)"> 
  	<i class="icon-trash icon-white"></i></a> <a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalAux" onclick="ViewDetAuxiliar(1079)">
	<i class="icon-user icon-white"></i>
	</a><a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalCostos" onclick="ViewDetCostos(1079)">
	<i class="icon-asterisk icon-white"></i>
	</a>


   //--------------------------------------


	  var id_asiento  = $('#id_asiento').val(); 


	  var idprov      = $('#idprov').val(); 


	


 	  


		var parametros1 = {


				"id_asiento" : id_asiento ,


				"idprov" : idprov 


		};


		 


		$.ajax({


			    type:  'GET' ,


				data:  parametros1,


				url:   '../model/Model-cxpagar-aux.php',


				dataType: "json",


					success:  function (response) {


						


						 $("#retencion").val( response.a );  


						 


						 $("#detalle_auto").val( response.b );  


						 


						 $("#fechap").val( response.c );  


						  


				} 


		});


  	


  }


  //------------------------------------------------------------------------- 


  function DetalleAsientoIR()


  {


	  


  


	  var id_asiento = $('#id_asiento').val(); 


	  


	  var parametros = {


 			    'id_asiento' : id_asiento 


     };


	  


  	$.ajax({


 			data:  parametros,


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


    





	 $("#ViewForm").load('../controller/Controller-co_xpagar.php');


      





 }

 function importacion_visor()

 {
	 
	 var codigo1         =	$("#tipo").val( );
	 var id_asiento  	 =   $('#id_asiento').val();
 
	  var parametros = {
	              'id_asiento' : id_asiento ,
	              'accion' : 'visor' 
		};
	   
	    
	 if ( codigo1 == 'M') {
		 
		 
		  $.ajax({
				data:  parametros,
				 url:   '../model/Model-co_asientosImporta.php',
				type:  'GET' ,
				success:  function (response) {
					 
					   $("#guardarImportacion").html(response); 
					
						 $('#myModalImportacion').modal('show');
						
					} 
		  });  
	
		 
	 }
 
 }

 
//---------------------------------
 
 function GuardarImportacion()

 {
 
	    var id_asiento  	=   $('#id_asiento').val();
	    var id_importacion  =   $('#id_importacion').val();
 
	    var parametros = {
	              'id_asiento' : id_asiento ,
	              'id_importacion' : id_importacion ,
	              'accion' : 'add' 
		};
	   
	 
	   $.ajax({
			data:  parametros,
			 url:   '../model/Model-co_asientosImporta.php',
			type:  'GET' ,
			success:  function (response) {
				 
				   $("#guardarImportacion").html(response); 
				
					alert('Enviado');
					
				} 
	  });  

		
 }

//----------------------


 function FormFiltro()


 {


	 

	 $("#ViewFiltroImportacion").load('../controller/Controller-co_asientos_importacion.php');
	 
	 
	 $("#ViewFiltro").load('../controller/Controller-co_asientos_filtro.php');


	 


 }


//----------------------


 


//----------------------
function accion(id,modo,estado)
{

	
	if (id > 0){

  			 if (modo == 'aprobado'){
					$("#action").val('aprobado');
					$("#estado").val('aprobado');          
					BusquedaGrillaTramite(oTableTramite)
 			 }else{
					$("#action").val(modo);
					$("#estado").val(estado);          
		 	 }

			  $("#id_asiento").val(id);
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


			 url:   '../controller/Controller-co_asientos_aux01.php',


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


								url:   '../model/Model-co_xpagar.php',


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


 //------------------------


 function monto_iva(valor_base){

 
	  var flotante = parseFloat(valor_base)    * (12/100);
 

	  if (valor_base > 0){
 
		var valorIva = parseFloat(flotante).toFixed(2)  ;

 

		  $('#montoiva').val(valorIva);

 
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


		  $('#valretserv100').val(0);


 		  }


	 //-------------------


	  if (tipo_retencion == 1){


		  iva = monto_iva * (30/100);


		  flotante = parseFloat(iva).toFixed(2)  ;


		  $('#valorretbienes').val(flotante);


		  $('#valorretservicios').val(0);


		  $('#valretserv100').val(0);


 		  }


	//-------------------


	  if (tipo_retencion == 2){


		  iva = monto_iva * (70/100);


		  flotante = parseFloat(iva).toFixed(2)  ;


		  $('#valorretbienes').val(0);


		  $('#valorretservicios').val(flotante);


		  $('#valretserv100').val(0);


 		  } 


	//-------------------


	  if (tipo_retencion == 3){


		  iva = monto_iva * (100/100);


		  flotante = parseFloat(iva).toFixed(2)  ;


		  $('#valorretbienes').val(0);


		  $('#valorretservicios').val(0);


		  $('#valretserv100').val(flotante);


 		  }  


	//-------------------


	  if (tipo_retencion == 4){


		  iva = monto_iva * (10/100);


		  flotante = parseFloat(iva).toFixed(2)  ;


		  $('#valorretbienes').val(flotante);


		  $('#valorretservicios').val(0);


		  $('#valretserv100').val(0);


 		  }  


		//-------------------


	  if (tipo_retencion == 5){


		  iva = monto_iva * (70/100);


		  flotante = parseFloat(iva).toFixed(2)  ;


		  $('#valorretbienes').val(0);


		  $('#valorretservicios').val(flotante);


		  $('#valretserv100').val(0);


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


			 url:   '../model/ajax_FuenteCalculo.php',


			type:  'GET' ,


			cache: false,


			beforeSend: function () { 


						$("#retencion_fuente").html('Procesando');


				},


			success:  function (data) {


					 $("#retencion_fuente").html(data);  // $("#cuenta").html(response);


				     


				} 


	});





}





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
//-- actualiza el los codigos de la retencion


function ActualizarRetencion( ) {


	


	  var id_asiento  = $('#id_asiento').val(); 


 	  var idprov      = $('#idprov').val(); 


 	  var estado      = $('#estado').val(); 


  

	  var parametros = {


 			    'id_asiento' : id_asiento ,


 			    'idprov': idprov 


     };


 

	 if (estado == 'aprobado') {
		 
 		 $.ajax({
			    type:  'GET' ,
				data:  parametros,
				url:   '../model/Model-ActualizaRetencion.php',
				dataType: "json",
				success:  function (response) {

					 $("#retencion").val( response.a );  
					 
					 $("#detalle_auto").val( response.b );  
						 
					 $('#fechap').val( response.c ); 
						  
				} 
		});
 

	 }else{


		 alert('Debe estar el asiento aprobado'); 


	 }


	 


}


//--------------------


function ComprobanteActualiza( retencion,autorizacion,fechap) {


	


	 	 $('#retencion').val(retencion); 


		 $('#detalle_auto').val(autorizacion); 


		 $('#fechap').val(fechap); 


    
		

	       


}





//--------------------


function ImprimirRetencion(  ) {


 	 
    var posicion_x; 
    var posicion_y; 
    var enlace; 
    var ancho = 720; 
    var alto = 550; 
  
    var id  =   $('#id_asiento').val();

    if ( id > 0 ) {
    
		      var url = '../../facturae/comprobante_electronico.php';
		     			
		      posicion_x=(screen.width/2)-(ancho/2); 
		      
		      posicion_y=(screen.height/2)-(alto/2); 
		      
		      enlace = url + '?id='+ id;
		      
		      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

    
    }
 

}
// ------------------------------------

function EnviarRetencion(  ) {

 
  
    var id  =   $('#id_asiento').val();

    var parametros = {
              'id' : id 
	};
   
 
   $.ajax({
		data:  parametros,
		 url:   '../model/EnvioEmailComprobante.php',
		type:  'GET' ,
		success:  function (response) {
			 
			   $("#FacturaElectronica").html(response); 
			
				alert('Enviado');
				
			} 
});  

	       

}


 

//--------------------
// emite comprobate electronico........
//-------------------------------------------------------

function ComprobanteElectronico( ) {


	


	  var id_asiento  	= $('#id_asiento').val(); 
	  var secuencial  	= $('#secuencial').val(); 
	  var idprov      	= $('#idprov').val(); 
	  var autorizacion  = $("#detalle_auto").val();
	  var estado 		= $('#estado').val(); 

       var parametros = {
				 			    'id_asiento' : id_asiento ,
				 			    'secuencial': secuencial,
				 			    'idprov': idprov
				         };

       var parametrosi = {
			                     'id_asiento' : id_asiento ,
			                     'secuencial': secuencial,
			                     'idprov': idprov
	                     };


	 if (estado == 'aprobado') {
 

			  alertify.confirm("<p>Desea generar comprobante electronico<br></p>", function (e) {


				  if (e) {
				 	  
					  $.ajax({
				 			data:  parametros,
				 			url:   '../model/Model-ComprobanteElectronicoRete.php',
				 			type:  'GET' ,
				  			success:  function (data) {
				  			 
				  				$("#data").html(data); 
				 				    
 				  				 
				 			} ,
							  complete : function(){
		                          
								  $.ajax({
						                 data:  parametrosi,
						                 url:   '../../facturae/autoriza_comprobante_firma.php',
						                 type:  'GET' ,
						                 success:  function (data) {
						                     $("#data").html(data); 
							                 alert('Comprobante firmado');
						                     firma_autorizado(); 
							                 
						                  } 
				                 });
				  				 
		                   } 
				 	});
 		 		
				  }	
							
				 }); 	  
 				
 	 }else{


		 alert('Debe estar el asiento aprobado'); 


	 }


}
 
//---
function firma_electronica(  )

{
	  var id_asiento  	= $('#id_asiento').val(); 

	  var secuencial  	= $('#secuencial').val(); 

	  var idprov      	= $('#idprov').val(); 

	  var autorizacion  = $("#detalle_auto").val();

	  var estado 		= $('#estado').val(); 
	  
	  
	 var parametrosi = {
			    'id_asiento' : id_asiento ,

			    'secuencial': secuencial,

			    'idprov': idprov
	    };
	  
   $.ajax({
			data:  parametrosi,
			url:   '../../facturae/autoriza_comprobante_firma.php',
			type:  'GET' ,
			success:  function (data) {
			 
				$("#data").html(data); 
				    
				firma_autorizado(); 
			} 
	});

}
//-----------------------------------------
function firma_autorizado(  )

{
	  var id_asiento  	= $('#id_asiento').val(); 

	  var secuencial  	= $('#secuencial').val(); 

	  var idprov      	= $('#idprov').val(); 

	  var autorizacion  = $("#detalle_auto").val();

	  var estado 		= $('#estado').val(); 
	  
	  var parametrosf = {
			    'id_asiento' : id_asiento ,

			    'secuencial': secuencial,

			    'idprov': idprov
	    };
	 
	  //url:  '../../facturae/autoriza_comprobante.php',
 	  //url:   '../model/externo.php',
 
     $.ajax({
				data:  parametrosf,
				url:   '../model/externo.php',
				type:  'GET' ,
				success:  function (data) {
					
				 
					
					$("#data").html(data); 
					     
				} 
			 
		}); 

}

//-------------------


function ListaAux( vprod)


{
 


  var parametros = {


 			    'idprov': vprod


  };
 

		$.ajax({


			data:  parametros,


			url:   '../model/Model_listaAuxCxp.php',


			type:  'GET' ,


			beforeSend: function () { 


					$("#ViewFormAux").html('Procesando');


			},


		success:  function (data) {


				 $("#ViewFormAux").html(data);   


			     


			} 
 


	});	 
 


}

 
