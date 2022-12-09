"use strict";

var oTableGrid;  
var oTableTramite;
var oTableFactura;


//-------------------------------------------------------------------------
$(document).ready(function(){


          
         oTableGrid =  $('#jsontable_gasto').dataTable( {
 		    "aoColumnDefs": [
 		      { "sClass": "de", "aTargets": [ 1 ] },
 		      { "sClass": "highlight", "aTargets": [ 2 ] },
 		      { "sClass": "ye", "aTargets": [ 4 ] }
 		    ]
 		  } );
          
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

	    BusquedaGrillaTramite(oTableTramite,'5');
	    
	    
	    
	    $('#bguardaPago').on('click',function(){

	 		   

          PagoNomina();

  			

		});
	    
	    
 
 
});  
//-------------------
function PonePartida( ){
    
	  var id_tramite = $("#id_tramite").val();
	  var festado    = $("#festado").val();


    var parametros = {
				'id_tramite' : id_tramite  ,
				'festado' : festado  
    };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_xpagar_gasto_nomina.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			oTableGrid.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
								oTableGrid.fnAddData([
										s[i][0],
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][4],
 					                     '<button class="btn btn-xs" onClick="javascript:goToURLGasto('+ "'" + s[i][0] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button> '  
		                 ]);									
						} // End For
					}				
			},
			error: function(e){
			   console.log(e.responseText);	
			}
		});

 
}
//----------------------
function accion(id,modo,estado)
{

	
	if (id > 0){

  			 if (modo == 'aprobado'){
					$("#action").val('aprobado');
					$("#estado").val('aprobado');          
  			 }else{
					$("#action").val(modo);
					$("#estado").val(estado);          
		 	 }

			  $("#id_asiento").val(id);
	}

}
//------------------------------------------------------------------------- 
function BusquedaGrillaTramite(oTableTramite,tipo){        	 


	 var parametros = {
 				'tipo' : tipo
   };
	 
			$.ajax({
				data:  parametros,
			    url: '../grilla/grilla_co_xpagar_nomina.php',
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

//-----------------------------------
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
//-------------------
function goToURL(accion,id) {

	  var parametros = {
					'accion' : accion ,
                    'id' : id 
	  };

	  
	  $.ajax({

					data:  parametros,
					url:   '../model/Model-co_xpagar_nomina.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
						     $("#result").html(data);   
						     DetalleAsiento();
					} 
 
			}); 
 
		 
		

}
function goToURLDel(accion,id) {

	  var id_asiento = $("#id_asiento").val();
	 
	  var parametros = {
					'accion' : accion ,
                    'id' : id ,
                    'id_asiento' : id_asiento
	  };

	  $.ajax({

					data:  parametros,
					url:   '../model/ajax_delAsientosDetalle.php',
					type:  'GET' ,
					cache: false,
 					success:  function (data) {
						     $("#result").html(data);   
						     DetalleAsiento();
					} 

			}); 

}
function goToURLAuxMain( id) {
 

	   var id_asiento = $("#id_asiento").val();
	 
	   var id_tramite = $("#id_tramite").val();

		var parametros = {
	                    'id' : id ,
	                    'id_asiento' : id_asiento,
	                    'id_tramite' : id_tramite
		  };


		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_Asientos_aux_visor_pone.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
						    	$("#result").html(data);
								alert(data);
	 					} 
				}); 
		  
		  $('#myModalprov').modal('hide');
	}	
//------------------- 
function goToURLGasto(programa) {

	
	  var id_tramite = $("#id_tramite").val();
	  var id_asiento = $("#id_asiento").val();
	  
	  
 	  var parametros = {
					 'accion' : 'gasto' ,
                     'id_tramite' : id_tramite,
                     'programa' : programa,
                     'id_asiento': id_asiento
	  };

 	  
	  $.ajax({

					data:  parametros,
					url:   '../model/Model-co_xpagar_nomina.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
						     $("#result").html(data);   
						     $('#myModalGasto').modal('hide');
						     DetalleAsiento();
					} 


			}); 

}
//---------------
function goToURLAsiento( id_asientod,monto,iva,item,partida) {

 
	  var id_tramite = $("#id_tramite").val();
	  var id_asiento = $("#id_asiento").val();
	  
	  
	  var parametros = {
				  'id_tramite' : id_tramite,
				  'id_asientod' : id_asientod,
                  'partida' : partida,
                  'item' : item,
                  'monto' : monto,
                  'iva' : iva
	  };
  
	  $.ajax({

					data:  parametros,
					url:   '../controller/Controller-co_xpagar_gasto.php',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
						     $("#ViewAsientoGasto").html(data);   
						    
						   
					} 


			}); 

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
//-------------------------------------
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
//------------------------------------
 function DetalleAsiento()
 {
      var id_asiento = $('#id_asiento').val(); 
      
 	  var parametros = {
  			    'id_asiento' : id_asiento 
      };

   	$.ajax({
  			data:  parametros,
  			url:   '../model/ajax_AsientosGastos.php',
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
 
}
//-----------------------
function GuardarAsientoBas()
 {
      var partidabas = $('#partidabas').val(); 
      
       var idasientobas = $('#idasientobas').val(); 
      
 	  var parametros = {
  			    'partidabas':partidabas,
  			    'idasientobas':idasientobas
      };


   
 
   	$.ajax({
  			data:  parametros,
  			url:   '../model/_aux_enlace_nom.php',
  			type:  'GET' ,
  			cache: false,
  			beforeSend: function () { 
  						$("#guardarBas").html('Procesando');
  				},
  			success:  function (data) {
  					 $("#guardarBas").html(data);   
  					 
  				} 
  	}); 
  	
  	
  	DetalleAsiento();
  	 
 
}
//--------------
 function EnlaceGasto(idasientod)
 {
      var id_asiento = $('#id_asiento').val(); 
      
       var id_tramite = $('#id_tramite').val(); 
      
 	  var parametros = {
  			    'id_asiento' : id_asiento ,
  			    'id_tramite':id_tramite,
  			    'idasientod':idasientod
      };

 
   	$.ajax({
  			data:  parametros,
  			url:   '../controller/Controller-co_asientos_nomp.php',
  			type:  'GET' ,
  			cache: false,
  			beforeSend: function () { 
  						$("#ViewAsientoBas").html('Procesando');
  				},
  			success:  function (data) {
  					 $("#ViewAsientoBas").html(data);   
  					 
  				} 
  	}); 
  	
  	$('#myModalbas').modal('show');
 
}
 //--
 function goToURLAnticipo(monto,id_asientod)
 {
      var id_asiento = $('#id_asiento').val(); 
      
      $('#id_asientoda').val(id_asientod); 
      
      
 	  var parametros = {
  			    'id_asiento' : id_asiento ,
  			    'monto' : monto
      };

   	$.ajax({
  			data:  parametros,
  			url:   '../controller/Controller-co_asientos_aux03.php',
  			type:  'GET' ,
  			cache: false,
  			beforeSend: function () { 
  						$("#ViewAsientoAnticipo").html('Procesando');
  				},
  			success:  function (data) {
  					 $("#ViewAsientoAnticipo").html(data);   
  					  
  				} 
  	});
 
}
 //------------------------------------
 function GuardarAsientoAnticipo( )
 {
	 
	 
      var id_asiento = $('#id_asiento').val(); 
      var cuentaa    = $('#cuentaa').val(); 
      var partidaa   = $('#partidaa').val(); 
      var id_asientod= $('#id_asientoda').val(); 
      var montoa   = $('#montoa').val(); 
      
      
 
      
 	  var parametros = {
  			    'id_asiento' : id_asiento ,
  			    'cuentaa' : cuentaa,
  			    'partidaa' : partidaa,
  			    'monto' : montoa,
  			    'id_asientod' : id_asientod
      };

 	  
 	  
		   	$.ajax({
		  			data:  parametros,
		  			url:   '../model/Model-co_dasientos_anticipo.php',
		  			type:  'GET' ,
		  			cache: false,
		  			beforeSend: function () { 
		  						$("#guardarAnticipo").html('Procesando');
		  				},
		  			success:  function (data) {
		  					 $("#guardarAnticipo").html(data);   
		  					  
		  					DetalleAsiento();
		  				} 
		  	});
 
}
//-----------------------
function AgregaCuenta_enlace()

  {

	     var id_asiento = $("#id_asiento").val();
	 	 var cuenta11    = $("#cuenta1").val();
		 var partidad1   = $("#partidad").val();
		 var cuenta01    = $("#cuenta0").val();

		 var xid_asientod    = $("#xid_asientod").val();

	 
		 
		 var tipo_copia    = $("#tipo_copia").val();
		 
		 
		 
		 var estado    = $("#estado").val();
	 
 
	  if (id_asiento > 0){

 
		  
		  var parametros = {
	 			    'id_asiento' : id_asiento ,
	 			    'cuenta0' : cuenta01,
	 			    'estado' : estado,
	 			    'cuenta1' : cuenta11,
	 			    'partidad'   : partidad1, 
					'tipo_copia' : tipo_copia,
					'xid_asientod' : xid_asientod 
	     };
		  
		  	if ( tipo_copia == 'H'){
		  		
		  		$.ajax({
		 			data:  parametros,
		 			url:   '../model/Model-co_dasientos_enlace.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#DivAsientosTareas").html('Procesando');

		 				},
		 			success:  function (data) {
		 					 $("#DivAsientosTareas").html(data);   
		 				} 
		 	});
		  	}else {
				  	$.ajax({
				 			data:  parametros,
				 			url:   '../model/Model-co_dasientos_enlace.php',
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
	  }else{

		  alert('Guarde la información del asiento');

	  }

    	 $('#myModalAuxIng').modal('hide');
		 
	     DetalleAsiento();

  }
//------------------------
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
//--------------
 function totalc(){
 	 
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
 	  
 	 
 }  
//----------------------
 function modalVentana(url){        
		
	    
	    var posicion_x; 
	    var posicion_y; 
	    var idprov  =   $('#idprov').val();
	    
	    if (idprov){   
	    	  var enlace = url  + '?id=' + idprov + '&accion=editar';
	    }else{   
	    	  var enlace = url ;
	    }
	    
	  
	    
	    
	    var ancho = 1000;
	    
	    var alto = 475;
	    
	   
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
	 } 
//-----------------
 function AbrirEnlace()
 {

 	 
  var id_asiento = $("#id_asiento").val();
   
 if (id_asiento > 0 ) {

   var enlace = 'co_validacion_asiento_ve?codigo=' +id_asiento;

    window.open(enlace,'#','width=750,height=480,left=30,top=20');
 	    	  
 }

 	 
  
 }
//------------------- 
 function FormView()
{

	 $("#ViewForm").load('../controller/Controller-co_xpagar.php');

	 $("#view_pago").load('../controller/Controller-te_pagos_nomina.php');
	 
	 
} 
//------------------
 function BusquedaGrillapago( ctipo ){
    

	  var id_tramite = $("#id_tramite").val();
	  var id_asiento = $("#id_asiento").val();
	  
	  
	  var detalle = 'PAGO GENERADO ' + $("#detalle").val();
	  var fecha   = $("#fecha").val();
	  
	  var parametros = {
				  'id_tramite' : id_tramite,
				  'id_asiento' : id_asiento,
				  'ctipo' : ctipo
 	  };
	  
	  
	  $("#detalle_pago").val(detalle);
	  
	  $("#fecha_pago").val(fecha);
	  
	  
	  
	  
  
	  $.ajax({

					data:  parametros,
					url:   '../controller/Controller-te_pagos_detalle.php',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
						     $("#view_pago_detalle").html(data);   
						    
						   
					} 


			}); 
	  
 }
//------------------
   
//------------- 
 function Contracuenta(cuenta){
	 
	    var parametros = {
	    		'cuenta' : cuenta  
	    		}; 

	    		$.ajax({
	    			data: parametros,
	    			url: "../model/ajax_contracuenta_iva.php",
	    			type: "GET",
	    			success: function(response)
	    			{
	    			$('#ivac').html(response);
	    			}
	    		});
	     
 }
//-------------- 
 function ContraPartida(cuenta){
	 
	    var parametros = {
	    		'cuenta' : cuenta  
	    		}; 

	    		$.ajax({
	    			data: parametros,
	    			url: "../model/ajax_contracuenta_partida.php",
	    			type: "GET",
	    			success: function(response)
	    			{
	    			$('#ivap').html(response);
	    			}
	    		});
	     
}
 //------------------GuardarAsientoDetalle()
 function GuardarAsientoDetalle( ){

	  var id_tramite = $("#id_tramite").val();
	  var id_asiento = $("#id_asiento").val();
	  
	  var iva 		= $("#iva").val();
	  var ivac 		= $("#ivac").val();
	  var ivap 		= $("#ivap").val();
	  var riva 		= $("#riva").val();
	  var montoriva = $("#montoriva").val();
	  var rfuente 	= $("#rfuente").val();
	  var montofuente = $("#montofuente").val();
	  var cxp 		  = $("#cxp").val();
	  var montocxp 	  = $("#montocxp").val();
	  var partida     = $("#partida").val();
	  var grupo 	  = $("#grupo").val();
	  var monto_iva 	  = $("#monto_iva").val();
 
       
	  var parametros = {
				'accion' : 'cxp' ,
                'id_asiento' : id_asiento ,
                'id_tramite': id_tramite,
          	    'iva' 		: iva,
		  	    'ivac' 		: ivac,
			    'ivap' 		: ivap,
			    'riva' 		: riva,
			    'montoriva' : montoriva,
			    'rfuente' 	: rfuente,
			    'montofuente': montofuente,
			    'cxp' 		  : cxp,
			    'montocxp' 	  : montocxp,
			    'partida'     : partida,
			    'grupo' 	  : grupo,
			    'monto_iva'   :monto_iva
      };
	  
	  
     alertify.confirm("Agregar cuentas informacion", function (e) {
			 if (e) {
 
			  $.ajax({

							data:  parametros,
							url:   '../model/Model-co_xpagar.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
									$("#result").html('Procesando');
							},
							success:  function (data) {
								     $("#result").html(data);   
								     $('#myModalAsistente').modal('hide');
								     DetalleAsiento();
							} 


					}); 
				
			 }
	  }); 
	 	 
 
 }
//-----
 function PagoNomina( ){

	  var id_tramite = $("#id_tramite").val();
	  var id_asiento = $("#id_asiento").val();
	  
	  var fecha_pago 		= $("#fecha_pago").val();
	  var detalle_pago 		= $("#detalle_pago").val();
	  var idbancos 			= $("#idbancos").val();
	  var tipo 				= $("#tipo_pago").val();
	  var cheque 			= $("#cheque").val();
	  var comprobante 		= $("#comprobante").val();
	  
	  
	  var tipo_prov 		= $("#tipo_prov").val();

	 
	  var parametros = {
				'accion' : 'pago' ,
                'id_asiento' : id_asiento ,
                'id_tramite': id_tramite,
         	    'fecha_pago' 		: fecha_pago,
		  	    'detalle_pago' 		: detalle_pago,
			    'idbancos' 		: idbancos,
			    'tipo' 		: tipo,
			    'cheque' : cheque,
			    'tipo_prov' : tipo_prov,
			    'comprobante' 	: comprobante
	 };
	  
	  
	  
	  if ( idbancos ) {
	  
		  if ( tipo_pago )  {
			  
			  if ( cheque ) {
			  
			    alertify.confirm("Desea generar el pago informacion", function (e) {
						 if (e) {
			
						  $.ajax({
			
										data:  parametros,
										url:   '../model/Model-te_pagos_nomina.php',
										type:  'GET' ,
										cache: false,
										beforeSend: function () { 
												$("#informacion_pago").html('Procesando');
										},
										success:  function (data) {
											     $("#informacion_pago").html(data);   
											      
										} 
			
			
								}); 
							
						 }
				  }); 
			  }
	        }	 
	  }
} 
//------------------ 
 function GuardarAuxiliar()
 {

    var valida = validaPantalla();
	var	id_asiento     =  $("#id_asiento").val( );
	var codigodet      =	$("#codigodet").val( );
	var idprov         =	$("#idprov1").val( );

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
//-----
 function validaPantalla() {

	   var valida = 1;

	 

		if (  $("#idprov1").val()  ) { valida = 0 ; } else { valida = 1 ; }

		

	/*	if (  $("#comprobante").val()  ) { valida = 0 ; } else { valida = 1 ; }	
		if (  $("#documento").val()  ) { valida = 0 ; } else { valida = 1 ; }
		if (  $("#estado").val()  ) { valida = 0 ; } else { valida = 1 ; }	
		if (  $("#tipo").val()  ) { valida = 0 ; } else { valida = 1 ; }
		if (  $("#detalle").val()  ) { valida = 0 ; } else { valida = 1 ; }	
	 d*/

		 	

		 return valida;



	}
//----------------------
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
 //------------------------
 function ViewDetAuxiliar(codigoAux)
 {

  	 var parametros = {
 			    'codigoAux' : codigoAux 
     };

  	$.ajax({
 			 data:  parametros,
 			 url:   '../controller/Controller-co_asientos_aux1.php',
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
//--------
function aprobacion(){

     $("#action").val( 'aprobacion');
     
     var action		=   $("#action").val();
 	 var id_asiento =   $("#id_asiento").val( );
	 var id_tramite = $("#id_tramite").val();

	 var parametros = {
				'action' : action ,
                'id_asiento' : id_asiento ,
                'id_tramite': id_tramite
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
//--------------------
 