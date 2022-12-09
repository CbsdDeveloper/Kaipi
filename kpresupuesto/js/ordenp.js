var oTableGrid;  
var oTable ;
var oTableGasto ;

var oTableFactura;


$(function(){

    $(document).bind("contextmenu",function(e){

        return false;

    });

	window.addEventListener("keypress", function(event){

        if (event.keyCode == 13){

            event.preventDefault();

        }

    }, false);

    
});

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
	 
	 
       oTableGrid = $('#ViewCuentas').dataTable();  
       oTableGasto= $('#jsontable_gasto').dataTable();  

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
 
	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
		});

		$('#GuardaCiu').on('click',function(){
 	 		 
			Actualizaciu();
			
	 });


//-----------------------------------------------------------------
});  

//-------------------
function Actualizaciu( )
{
 
 
var estado = 	$("#estado").val();
var idprov =    $("#idprov").val();
var id_spi =    $('#id_spi').val(); 


var id_banco   =    $('#id_banco').val(); 
var tipo_cta   =    $('#tipo_cta').val(); 
var cta_banco  =    $('#cta_banco').val(); 


	 
			
		 		 		 
						 var parametros = {
								    'idprov': idprov ,
								    'id_spi':id_spi,
								    'id_banco':id_banco,
								    'tipo_cta':tipo_cta,
								    'cta_banco':cta_banco 
 					   };
						  
						  
						$.ajax({
								data:  parametros,
								 url:   '../../kventas/model/ajax_spi_ciu.php',
								type:  'GET' ,
								success:  function (data) {
										 $("#guardarciu").html(data);   
										 
 
										 
		 							} 
						});
 
 
}
//----------------------------
function impresion_pago()
 {

	var	id_asiento     =   $("#id_asiento").val( );
	 
	FechaOrden( id_asiento );

	
  
	var enlace = '../../kcontabilidad/reportes/ficheropagoorden?a=';	

  	enlace = enlace +id_asiento;
  
  if (id_asiento){

		  alertify.confirm("Desea generar la orden de pago?", function (e) {
		
			    if (e) {
		
			    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
			    	  
			     }
		
			 }); 
  }	
  
 
}	
//---------------
//---------------------------------------------------
function FechaOrden(id_asiento )
{
	 var	forden    =   $("#forden").val( );
	 
	 var	apagar    =   $("#apagar").val( );
	 
	 
	 var parametros = {
			    'id_asiento' : id_asiento,
			    'apagar' : apagar,
			    'forden' : forden
  };


	$.ajax({
			data:  parametros,
			url:   '../model/Model-pone_fechaop.php',
			type:  'GET' ,
			cache: false,
 			success:  function (data) {
					 $("#ViewFiltroProv").html(data);   
				} 
	});
}
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
function BuscaPartida(cuenta){
	 
    var parametros = {
    		'cuenta' : cuenta  
    		}; 

    		$.ajax({
    			data: parametros,
    			url: "../model/ajax_contracuenta_partida.php",
    			type: "GET",
    			success: function(response)
    			{
    			$('#partidad').html(response);
    			}
    		});
     
}
//---------------
function BuscaContra(cuenta){
	 
    var parametros = {
    		'cuenta' : cuenta  
    		}; 

    		$.ajax({
    			data: parametros,
    			url: "../model/ajax_contracuenta_grupo.php",
    			type: "GET",
    			success: function(response)
    			{
    			$('#cuenta1').html(response);
    			}
    		});
     
}
///---------------
function modalVentana(url){        
	
    
    var posicion_x; 
    var posicion_y; 
  
    var enlace = url ;
  
  
    
    
    var ancho = 1000;
    
    var alto = 475;
    
   
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 } 
//---------------
 
function AbrirCiu(){



	var idprov         	   =	$("#idprov").val( );
 
	 
		 		 		 
						 var parametros = {
								    'idprov': idprov 
					   };
						  
						  
						$.ajax({
								data:  parametros,
								 url:   '../../kventas/controller/Controller-te_spi_ciu.php',
								type:  'GET' ,
								success:  function (data) {
										 $("#ViewFiltroProv").html(data);   
		 							} 
						});
		 
						$('#myModalciu').modal('show');
 
 

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
					url:   '../model/Model-co_asientos.php',
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
function CopiarAsiento( ) {

	var id_asiento = 	$("#id_asiento").val( );
	var estado = 	$("#estado").val( );



	alertify.confirm("Va a copiar este asiento " + id_asiento, function (e) {

		  if (e) {
			  var parametros = {
 	                   'id_asiento' : id_asiento

		      };

				   if ( estado == 'aprobado' ){

					   

						  $.ajax({

										data:  parametros,

										url:   '../model/Model-co_asientos_copia.php',

										type:  'GET' ,

										cache: false,

										 

										success:  function (data) {

											 $("#result").html(data);  // $("#cuenta").html(response);

											     

					 					} 

								}); 

				   } 

				 

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

		
		 var parametros = {
	 			    'id_asiento' : 0 
	     };

	  	$.ajax({
	 			data:  parametros,
	 			url:   '../model/ajax_DetAsientoPrincipal.php',
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

 

     return  today;      

} 

 

  //------------------------------------------------------------------------- 

  function BusquedaGrilla(oTable){        	 


	  var user = $(this).attr('id');

	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var festado = $("#festado").val();
	  
	  var fmodulo = $("#fmodulo").val();

	  var fid_tramite = $("#fid_tramite").val();
	  var fid_asiento = $("#fid_asiento").val();
	  

	



	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  ,
				'fmodulo' : fmodulo,
				'fid_asiento': fid_asiento,
				'fid_tramite':fid_tramite
      };

	  
	  if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_ordenp.php',
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
					  s[i][5],
                      '<button title="GENERAR ORDEN DE PAGO BENEFICIARIO" class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-folder-open"></i></button> '  
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

//--------------
 

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

    



	 $("#ViewForm").load('../controller/Controller-ordenp.php');

      
 

	 



 }

//--------------

 function cerrar_pago(validaDato)

 {

	 

 

	 if (validaDato == 1 )  {

		 

	    alert('No requiere Comprobante de Pago');

	    

 	    $('#myModalPago').modal('hide');

 	    

	 }  

 

 }

 

//-----------------

 function PagoAsiento()
 {


	var id = $('#id_asiento').val(); 


	 var parametros = {
			 'accionpago' : accion ,
             'id' : id 
     };


     $.ajax({
				data:  parametros,
				url:   '../model/Model-co_asiento_pagos.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#result_pago").html('Procesando');
				},
				success:  function (data) {
						 $("#result_pago").html(data);   
				} 

		}); 

}
//----------------------
function FormFiltro()
{

	 $("#ViewFiltro").load('../controller/Controller-ordenp_filtro.php');

}

//----------------------
 function actualiza_datod(valor,id)
 {
	 
	   montoDetalle('D',valor,id)
 
	  totalc();
	  
} 
//----------------------
 function actualiza_datoh(valor,id)
 {
	 
	   montoDetalle('H',valor,id)
	
 	  totalc();
	  
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
					     $("#id_asiento").val(id);
		 				 $("#txtcuenta").val('');
		 				 $("#cuenta").val('');
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
//Controller-co_asientos_costo.php 
 function goToURLAuxVisor( id) {


	  var estado = $("#estado").val();         

		var parametros = {
	                    'id' : id ,
	                    'estado' : estado
		  };


		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_delAsientos_aux_visor.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
		 
								alert(data);
	 					} 
				}); 
		  
		  $('#myModalprov').modal('hide');
	}
//------------------------------------------------------------------------- 
 function GuardarAuxiliar()
 {

    var valida = validaPantalla();
    
	var	id_asiento     =   $("#id_asiento").val( );
	var codigodet      =	$("#codigodet").val( );
	var idprov         =	$("#idprov").val( );
	var fcopiar         =	$("#fcopiar").val( );
	
	
	 if (valida ==0 ){
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'codigodet' : codigodet ,
						    'idprov' : idprov ,
						    'fcopiar' : fcopiar
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
//------------------------------------------------------------------------- 
 function PoneEnlace(id_asientod,cuenta,grupo)
 {

  

	var	id_asiento     =  $("#id_asiento").val( );
 
	$("#xid_asientod").val( id_asientod );


 
		 
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'cuenta' 	 : cuenta ,
						    'grupo' 	 : grupo 
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../controller/Controller-co_asiento_enlace.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 $("#ViewFiltroIngreso").html(data);   
							} 
				});
 	 
 
}
 //---------------------
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
//----------------------------- 
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
								url:   '../model/Model-co_asientos.php',
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
//--------------
 function goToURLAsiento( id_asientod,monto,iva,item,partida) {

	 
	  var id_tramite = $("#id_tramite").val();
	  var festado    = $("#estado").val();

 
	  
    var parametros = {
				'id_tramite' : id_tramite  ,
				'festado' : festado  
    };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_xpagar_dev.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTableGasto.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
							oTableGasto.fnAddData([
										s[i][0],
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][4]
 		                 ]);									
						} // End For
					}				
			},
			error: function(e){
			   console.log(e.responseText);	
			}
		});

		 
}
 ///-----
 function totalc( ){

	 var aumento     = 0;
     var disminucion = 0;
     var total = 0;
     var lnuCampo            = '';
     var layDatosNombre      = '';
     var lstCampo  = '';
     var Objeto  = '';
     
     
	 $("#jsontableDetalle td input").each(function(){
		 
		 
		 lnuCampo = $(this).attr('id') ;
		
		 layDatosNombre         = lnuCampo.split( '_' );
		 lstCampo               = layDatosNombre[0];
		 Objeto					= '#' + lnuCampo;
		 
		 if (lstCampo == 'debe'){

			 aumento =  aumento + parseFloat($(Objeto).val());;

		}
		 
		 if (lstCampo == 'haber'){

			 disminucion =  disminucion + parseFloat($(Objeto).val());;

		}
		    
		});
	 
 	 
	 total = aumento.toFixed(2) - disminucion.toFixed(2);
	 
      $("#taumento").html(' <h4>Debe '+ aumento.toFixed(2) + '</h4>');
	  $("#tdisminuye").html('<h4>Haber: '+ disminucion.toFixed(2) + '</h4>');
	  
	  $("#SaldoTotal").html(' <h4><b>'+ total.toFixed(2) + ' </b></h4>');
	  
	  
	 
	  
		return true;

}  