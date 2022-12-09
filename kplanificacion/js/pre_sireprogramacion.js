var oTableGrid;  
var oTable ;
var oTableGasto;
var oTableIngreso;

/*
llama las funciones para la operacion del formulario
*/
$(function(){

    $(document).bind("contextmenu",function(e){

        return false;

    });
 	

});
/*
Inicializacion de variables y funciones
*/
$(document).ready(function(){


        oTable = $('#jsontable').dataTable();

        //oTableGasto = $('#jsontable_gasto').dataTable(); 
        
        oTableIngreso = $('#jsontable_gasto').dataTable(); 

        oTableGrid = $('#ViewCuentas').dataTable();   

		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		modulo();

	    FormView();

	    FormFiltro();


	 	$('#load').on('click',function(){
	   
	            BusquedaGrilla(oTable);

		});  

});  
/*
 boton que ejecuta los mensajes para insertar el registro
*/
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

				if (e) {

						LimpiarPantalla();

						$("#action").val("add");

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
function goToURLDel(accion,id,reforma) {
	
 	
	var estado     = 	$("#estado").val( );
	
     if ( estado == 'digitado' ){

    	 var parametros = {
	 			       'id_sirepro_det' : id,
	 			       'accion' : accion
	     };
	   

						  $.ajax({

										data:  parametros,

										url:   '../model/Model-pre_sireprogramacion_detalle.php',

										type:  'GET' ,

										cache: false,

 										success:  function (data) {

											 $("#resul").html(data);   

											 DetalleAsiento();
											 
											 

					 					} 

								}); 

				   } 
	
}
/*
Envia el registro seleccionado para edicion o eliminar datos
*/
function goToURL(accion,id) {

	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	  $.ajax({

					data:  parametros,
					url:   '../model/Model-'+'pre_sireprogramacion'+'.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando informacion');
  					},
					success:  function (data) {
							    $("#result").html(data); 
  					} 

			}); 

    }
//-----------------------------------------------------------------
function goToURLReforma(partida,saldo) {

	$('#myModal').modal('hide');
	
	var id_sireprogra = 	$("#id_sireprogra").val( );
	
	var estado              = 	$("#estado").val( );
	

	
     if ( estado == 'digitado' ){

    	 var parametros = {
	 			       'id_sireprogra' : id_sireprogra,
	 			       'partida' : partida,
	 			       'saldo' : saldo,
	 			       
	     };
	   						  $.ajax({

										data:  parametros,

										url:   '../model/Model-pre_sireprogramacion_detalle.php',

										type:  'GET' ,

										cache: false,

 										success:  function (data) {

											 $("#guardarCosto").html(data);   

											 DetalleAsiento();
											 
											 $('#myModal').modal('hide');    
											    

					 					} 

								}); 

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
/*
limpia la pantalla con los objetos de la base
*/
function LimpiarPantalla() {

 var fecha = fecha_hoy();

	$("#id_sireprogra").val('');

	$("#fecha").val(fecha);

	$("#detalle").val("");

	$("#comprobante").val("");

	$("#estado").val("digitado");

	$("#tipo").val("");

	$("#tipo_reforma").val("");

	$("#documento").val("");

	$("#id_departamento").val("");

	$("#action").val("add");

	var parametros = {
	 			    'id_sireprogra' : 0 
	     };


	  	$.ajax({
	 			data:  parametros,
	 			url:   '../model/ajax_DetalleReprogramacion.php',
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
//------------------------------------
function anio_dato()
{

 
    var today = new Date();
  

    var yyyy = today.getFullYear();

     return  yyyy;      

} 
//------------------------------------------------------------------------- 
function BusquedaGrilla(oTable){        	 

 	  var ffecha1 = $("#bfechainicio").val();

	  var ffecha2 = $("#bfechafin").val();

	  var festado = $("#bestado").val();

	  var ftipo   = $("#btipo").val();
	 

      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  ,
				'ftipo' : ftipo  
				
      };


 		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_pre_sireprogramacion.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
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
	                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' +
	                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'
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

 
     var id_sireprogra = $('#id_sireprogra').val(); 
 	  
	  var parametros = {

 			    'id_sireprogra' : id_sireprogra 

     };

	 
  	$.ajax({

 			data:  parametros,

 			 url:   '../model/ajax_DetalleReprogramacion.php',

 			type:  'GET' ,

 			cache: false,

 			beforeSend: function () { 

 						$("#DivAsientosTareas").html('Procesando');

 				},

 			success:  function (data) {

 					 $("#DivAsientosTareas").html(data);   
 
 					  totalc();
 				} 

 	});

 $('#myModalimportar').modal('hide');
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
function FormView()
{

	 $("#ViewForm").load('../controller/Controller-pre_sireprogramacion.php');

	 //$("#ViewPago").load('../controller/Controller-asiento_pagos.php');

}
//--------------
function cerrar_pago(validaDato)
{
	 if (validaDato == 1 )  {

	    alert('No requiere Comprobante de Pago');

 	    $('#myModalPago').modal('hide');

	 }  

}
//-------------

function AbrePartida( )
{
 
 var id_reforma = $('#id_sireprogra').val(); 	

if ( id_reforma > 0 )  {

  	    $('#myModalimportar').modal('show');

}
 
}
//--------
function Exporta_reforma_formato() {
	
 var enlace = '../reportes/excelReformaGasto?id=0291X' ;
window.location.href = enlace;
 
}	
//----------------- 
function ExportarExcel() {

 var id_reforma = $('#id_reforma').val(); 	
 var enlace = '../reportes/excelReforma?id=' + id_reforma;
     
window.location.href = enlace;



}
//------------------------------
function BusquedaGrillaGasto(oTableGasto){        	 


		$.ajax({

		    url: '../grilla/grilla_reforma.php',
			dataType: 'json',
			cache: false,

			success: function(s){

			//console.log(s); 
		   oTableGasto.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {
	
					oTableGasto.fnAddData([
	
	                     s[i][0],
	                     s[i][1],
	                     s[i][2],
	                     s[i][3],
						 s[i][4],
						 s[i][5],
						 s[i][6],
						 s[i][7],
	                     '<button class="btn btn-xs" onClick="javascript:goToURLReforma('+ "'" + s[i][0] +"'," + s[i][5] +')"><i class="glyphicon glyphicon-edit"></i></button> '  
	
	                 ]);									
	
				} // End For

			   }				
 	    	},
 			error: function(e){
 			   console.log(e.responseText);	
 			}

			});

 }   
//-------------------------------
 
function FormFiltro()
{
 

	 $("#ViewFiltro").load('../controller/Controller-pre_sireprogramacion_filtro.php');
	 

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

			$("#id_sireprogra").val(id);
			
			DetalleAsiento();

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
function PonePartida( ){
    
    var pagado = $("#pago").val();     
    var estado = $("#estado").val();     
    var tipo   = $("#tipo").val();     
   
   	 BusquedaGrillaGasto(oTableIngreso);
   	 $('#myModal').modal('show');
    

}
//------------------------------------------------------------------------- 
function Saldos( ){
       
     
	  var fanio   = anio_dato();
	  var tipo    = 'G';
	   	 
	  var parametros = {
			    'fanio' : fanio ,
			    'tipo'  : tipo
			  
	  };

	  $.ajax({

			data:  parametros,
			url:   '../model/Model_saldo_ingreso.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 					 $("#result").html(data);   
  				} 

	  });
	  
	  
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
//Controller-co_asientos_costo.php
//------------------------------------------------------------------------- 
function actualiza_datoa(saldo,valor,id,reforma)
{


	  var saldo_reforma = parseFloat(saldo).toFixed(2)  ;

	  
	  var valor_reforma = parseFloat(valor).toFixed(2)  ;

	  
	  goToURLReformaDetalle('gastoa',id,valor_reforma,0 ) 
	  
	  totalc();


}
//------------------
function actualiza_datod(saldo,valor,id,reforma)
 {
	 
	 Objeto					= '#di_' + id;
	 
	 var tipo_reforma  = 	$("#tipo_reforma").val( );
	 var saldo_reforma = parseFloat(saldo).toFixed(2)  ;
	 var valor_reforma = parseFloat(valor).toFixed(2)  ;

	  goToURLReformaDetalle('gastoa',id,0,valor_reforma ) ;

	  totalc();
	  
} 
//-------------------------
function impresion(enlace,codigo_x1)

{

	 

	 var id_reforma = 	$("#id_reforma").val( );
     enlace = enlace +id_reforma;
 	 window.open(enlace,'#','width=750,height=480,left=30,top=20');

	 

}	
//---------------------
function goToURLReformaDetalle(tipo,id,monto1,monto2 ) {


		var id_reforma = 	$("#id_sireprogra").val( );
		var estado     = 	$("#estado").val( );

		
	     if ( estado == 'digitado' ){

	    	 var parametros = {
		 			       'id' : id,
		 			       'monto1' : monto1,
		 			       'monto2' : monto2,
		 			       'tipo' : tipo
		     };
		   

							  $.ajax({

											data:  parametros,

											url:   '../model/Model-pre_sireprogramacion_detalle.php',

											type:  'GET' ,

											cache: false,

	 										success:  function (data) {

												 $("#guardarCosto").html(data);   

						 					} 
									}); 
					   } 
	 
}
//----------------------------- 
function aprobacion(url){

     $("#action").val( 'aprobacion');
     var    action	      =   $("#action").val();
 	 var	id_sireprogra    =   $("#id_sireprogra").val( );

	 var parametros = {
				'action' : action ,
                'id_sireprogra' : id_reforma 
    };

     var mensaje = 'Desea aprobar la reforma ' + action;

     alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

     if (e) {

				  $.ajax({
								data:  parametros,
								url:   '../model/Model-pre_sireprogramacion.php',
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
//-------------------
function Revierte( ){

	 $("#action").val( 'revierte');
	 
     var    action	      =   $("#action").val();
 	 var	id_reforma    =   $("#id_reforma").val( );
 	 var    estado        =   $("#estado").val( ); 

	 var parametros = {
				'action' : action ,
                'id_reforma' : id_reforma 
    };

     var mensaje = 'Desea Revertir ( Cambiar de estado ... actualice saldos) la reforma ' + action;

     if ( estado == 'aprobado' ){
		     alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
		
		     if (e) {
		
						  $.ajax({
										data:  parametros,
										url:   '../model/Model-pre_sireprogramacion.php',
										type:  'POST' ,
										cache: false,
										beforeSend: function () { 
												$("#result").html('Procesando');
										},
										success:  function (data) {
												 $("#result").html(data);  
												 $("#estado").val( 'digitado' ); 
												 $("#action").val('editar');
										} 
								}); 
					  }
				 });
     }
}
//--------------
function totalc(){
	 
	 var aumento     = 0;
     var disminucion = 0;
     var total = 0;
     var lnuCampo            = '';
     var layDatosNombre      = '';
     var lstCampo  = '';
     var Objeto  = '';
     
     
	 $("#jsontableReforma td input").each(function(){
		 
		 
		 lnuCampo = $(this).attr('id') ;
		
		 layDatosNombre         = lnuCampo.split( '_' );
		 lstCampo               = layDatosNombre[0];
		 Objeto					= '#' + lnuCampo;
		 
		 if (lstCampo == 'au'){
 
			 
			 aumento =  aumento + parseFloat($(Objeto).val());;

		}
		 
		 if (lstCampo == 'di'){

			 disminucion =  disminucion + parseFloat($(Objeto).val());;

		}
		    
		});
	 
	  total = aumento.toFixed(2) - disminucion.toFixed(2);
	  
	  
	  disminucion = number_format(disminucion,2) ;
	  
	  aumento     = number_format(aumento,2) ;
	 
      $("#taumento").html(' <h4>Aumento   : '+ aumento + '</h4>');
	  $("#tdisminuye").html('<h4>Disminuye: '+ disminucion + '</h4>');
	  
	  var imprime = number_format(total,2) ;
	  
	  //total.toFixed(2) 
	  
	  $("#SaldoTotal").html(' <h3><b>'+ imprime + ' </b></h3>');
	  
	  
	 
	  
		return true;

}  

function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}