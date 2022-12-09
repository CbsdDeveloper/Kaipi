var oTableGrid;  
var oTable ;
 

//-------------------------------------------------------------------------
$(document).ready(function(){

	 oTable 	= $('#jsontable').dataTable( {      
         searching: true,
         paging: true, 
         info: true,         
         lengthChange:true ,
         aoColumnDefs: [
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "de", "aTargets": [ 3 ] }
		    ] 
      } );
	 
	 
 

	    $("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		
		 oTableFactura =  $('#jsontable_factura').dataTable( {
	 		    "aoColumnDefs": [
	 		      { "sClass": "highlight", "aTargets": [ 0 ] },
	 		      { "sClass": "highlight", "aTargets": [ 1 ] },
	 		      { "sClass": "highlight", "aTargets": [ 2 ] }
	 		    ]
	 		  } );
		 
		 
		modulo();
	    FormView();
	    FormFiltro();
	    BusquedaGrilla( oTable);
	    ViewDetAuxiliar();

	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
		});

//-----------------------------------------------------------------
});  
///----------
function accion(id,modo,estado)
{

	 var id_tramite = $("#id_tramite").val();
	
	 Recorrido( id_tramite );
 
}
function AbrirEnlace()
{

	 

	 var id_asiento = $("#id_asiento").val();
  
if (id_asiento > 0 ) {

  var enlace = 'co_validacion_asiento_ve?codigo=' +id_asiento;

   window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
}

	 
 
}	
//-------------------
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
//--------------------
function impresion_pago(enlace,codigo_x1)

{

	 

 var id_asiento  = document.getElementById(codigo_x1).value;  
  

  enlace = enlace +id_asiento;

  alertify.confirm("Desea generar la orden de pago?", function (e) {

	    if (e) {

	    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
	     }

	 }); 
  
 
}	
//----- 
 
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

				alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			    if (e) {

                    LimpiarPantalla();
                    accion(0,'');
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
///----------------
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {

 

	 var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-control_archivo.php',
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
//--------
//---------------------------------------------------
function VerBeneficiarios( )
{
	 var	id_asiento    =   $("#id_asiento").val( );
	 
	 var parametros = {
			    'id_asiento' : id_asiento 
  };


	$.ajax({
			data:  parametros,
			url:   '../model/Model-ver_lista_beneficiarios.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFiltroProv").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltroProv").html(data);   
				} 
	});
}
//-----
function goToURLAuxMain( id) {


	   var id_asiento = $("#id_asiento").val();
	 

		var parametros = {
	                    'id' : id ,
	                    'id_asiento' : id_asiento
		  };


		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_Asientos_aux_visor_pone.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
		 
								alert(data);
	 					} 
				}); 
		  
		  $('#myModalprov').modal('hide');
	}	
//---
function BusquedaGrillaFactura(oTableFactura){        	 

	
	var idtramite = 	 $("#id_tramite").val();

	
	
	 var parametros = {
				'idtramite' : idtramite  
     };

	$.ajax({
		data:  parametros,
	    url: '../grilla/grilla_co_xpagar_factura.php',
		dataType: 'json',
		cache: false,
		success: function(s){
			oTableFactura.fnClearTable();

		if(s){

			for(var i = 0; i < s.length; i++) {
				oTableFactura.fnAddData([
                      s[i][0],
                      s[i][1],
                      s[i][2],
                      s[i][3],
                      s[i][4],
                      s[i][5],
                      s[i][6],
                      s[i][7],
                  ]);									
			} // End For
		   }				
		},
		error: function(e){
		   console.log(e.responseText);	
		}
 });
	
}   
//-----------------------------------------------------------------
function Recorrido( id_tramite ) {
 
 
 
	var parametros = {
 	                   'id_tramite' : id_tramite

	 };
 					   
 						  $.ajax({
 										data:  parametros,
 										url:   '../model/Model-controlArchivo.php',
 										type:  'GET' ,
 										cache: false,
 										success:  function (data) {
 											 $("#ViewRecorrido").html(data);   
  					 					} 

								}); 
 
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

//-------------------------------------------------------------------------

// ir a la opcion de editar

function LimpiarPantalla() {

	    var fecha = fecha_hoy();

	    

    	$("#id_periodo").val("0");
    	$("#id_asiento").val(0);
	    $("#fecha").val(fecha);
		$("#comprobante").val(" "); 
		$("#documento").val(" "); 
		$("#estado").val(" ");          
		$("#tipo").val(" ");
		$("#detalle").val("");
		$("#action").val("add");

		
		$("#proveedor").val("");
		
		
		 

}
//----------------------------------
//---------------------------
function BusquedaGrilla(oTable){        	 


	  var user = $(this).attr('id');

	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var festado = $("#festado").val();
	  
	  var fmodulo = $("#fmodulo").val();
	  

	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  ,
				'fmodulo' : fmodulo
      };

	  
	  if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_control.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
				  oTable.fnAddData([
                      s[i][0],
                      s[i][1],
                      s[i][2],
                      s[i][3],
					  s[i][4],
					  s[i][5] + '&nbsp;&nbsp; &nbsp;<button class="btn btn-xs" title="Visualizar informacion" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-search"></i></button> ' 
					  
                  ]);									
			  } // End For
 			}				
  	  },

			error: function(e){

			   console.log(e.responseText);	

			}

			});

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
 

	 $("#ViewForm").load('../controller/Controller-co_archivo.php');

      

	 $("#ViewPago").load('../controller/Controller-asiento_pagos.php');
 


 }

  
//----------------------
function FormFiltro()
{

	 $("#ViewFiltro").load('../controller/Controller-controlArchivo_filtro.php');

}

 
 function  guarda_archivo( ){

    
     
     var id_asiento   = $("#id_asiento").val();
     var comprobante  =$("#comprobante").val(); 
   	 var fecha_archivo          =	$("#fecha_archivo").val( );
 	 var ubicacion_archivo      =	$("#ubicacion_archivo").val( );
 
  			 	 var parametros = {
  			 			    'accion' : 'archivo' ,
 						    'id_asiento' : id_asiento ,
 						    'comprobante' : comprobante ,
 						    'fecha_archivo' : fecha_archivo ,
 						    'ubicacion_archivo' : ubicacion_archivo 
  			    };

 			 	$.ajax({

 						data:  parametros,
 						url:   '../model/Model-control_archivo.php',
 						type:  'GET' ,
 						cache: false,
 						beforeSend: function () { 
 									$("#result").html('Procesando');
 							},
  						success:  function (data) {
  								 $("#result").html(data);   
 							} 

 				});
      

 }
  
 