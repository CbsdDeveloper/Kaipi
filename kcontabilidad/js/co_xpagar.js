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
        
         oTableFactura =  $('#jsontable_factura').dataTable( {
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

	    BusquedaGrillaTramite(oTableTramite);
 
		$('#load').on('click',function(){
			BusquedaGrillaTramite(oTableTramite)
		});

	
		$('#loadt').on('click',function(){
 	 		 
			CargaDatos( );
			  
			});

 
});  

/*
Carga datos de tramites
*/ 
function CargaDatos(idtramite) {

//	var idtramite  =  $("#id_tramite").val();

	var parametros = {
            'id' : idtramite 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/ajax-fin_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewFormRuta").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormRuta").html(data);   
					     
					} 
		}); 
 
} 	
//--------------------------
function AbrirEnlace()
{

	 

	 var id_asiento = $("#id_asiento").val();
  
if (id_asiento > 0 ) {

  var enlace = 'co_validacion_asiento_ve?codigo=' +id_asiento;

   window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
 }
}

function AbrirTributacion()
{

	 

 	 var id_tramite = $("#id_tramite").val();

  
if (id_tramite > 0 ) {

  var enlace = '../view/compras_tributacion?codigo=' +id_tramite;

   window.open(enlace,'#','width=1180,height=600,left=30,top=20');
	    	  
 }
}



//----------------------
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
//--------------
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
//-------------------
function PonePartida( ){
    
	  var id_tramite = $("#id_tramite").val();
	  var festado    = $("#festado").val();

	  
	  var norma = $("#norma").val();

    var parametros = {
				'id_tramite' : id_tramite  ,
				'festado' : festado  ,
				'norma' : norma
    };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_xpagar_gasto.php',
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
					                     '<button class="btn btn-xs btn-warning" title = "SELECIONAR CUENTA DE GASTO/INVERSION" onClick="goToURLGasto('+ "'" + s[i][0] +"',"+ "'" + s[i][1] +"',"+  "'" + s[i][2] +"',"+ s[i][4] +"," + s[i][5] +')"><i class="glyphicon glyphicon-edit"></i></button> '  
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
function Busqueda(   ){        
	
	BusquedaGrillaTramite(oTableTramite);
		
	
}
//------------------------------------------------------------------------- 
function BusquedaGrillaTramite(oTableTramite){        	 


	   
	  
	  var vestado     = $("#vestado").val();
 	  var qtramite    = $("#qtramite").val();
	  

	  var parametros = {
				'vestado' : vestado   ,
 				'qtramite' : qtramite  
  	  };

	  
	  
			$.ajax({
				data:  parametros,
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
		                      s[i][6],
		                      '<button title="Tramite Generar Devengado " class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-ok"></i></button> ' 
		                  ]);									
					} // End For
				   }				
				},
				error: function(e){
				   console.log(e.responseText);	
				}
		 });

		 $("#qtramite").val("");

}   
//-----
function BusquedaGrillaFactura(oTableFactura,idtramite){        	 

	
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
					  s[i][8],
                      s[i][9],
                  ]);									
			} // End For
		   }				
		},
		error: function(e){
		   console.log(e.responseText);	
		}
 });

			var parametros = {
				'idtramite' : idtramite  
			};


			$.ajax({
				data:  parametros,
				url:   '../model/ajax_iva_datos.php',
				type:  'GET' ,
				cache: false,
				success:  function (data) {
					$("#sumair").html(data);
				} 
			}); 



}   
//-----------------------------------
function CalcularIvaTramite() {


	   var id_tramite = $("#id_tramite").val();         

		var parametros = {
	                    'id' : id_tramite 
 		  };


		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_iva_tramite.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
		 
								alert(data);
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
///-------
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

function goToURL(accion,id) {

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
						     $("#result").html(data);   
							 DetalleAsiento();
							 
					} 
 
			}); 
 
		BusquedaGrillaFactura(oTableFactura,id);
		
		CargaDatos(id);

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
//------------------- 
function goToURLGasto(partida,clasificador,cuenta,compromiso,iva) {

	
	  var id_tramite = $("#id_tramite").val();
	  var id_asiento = $("#id_asiento").val();

	  var norma = $("#norma").val();
	  
	  
 	  var parametros = {
					'accion' : 'gasto' ,
                    'id_tramite' : id_tramite,
                    'partida' : partida,
                    'clasificador' : clasificador,
                    'cuenta' : cuenta,
                    'compromiso' : compromiso,
                    'iva' : iva,
                    'id_asiento': id_asiento,
					'norma' : norma
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
	  
	  var norma = $("#norma").val();

	  
	  var parametros = {
				  'id_tramite' : id_tramite,
				  'id_asientod' : id_asientod,
                  'partida' : partida,
                  'item' : item,
                  'monto' : monto,
                  'iva' : iva,
				  'norma': norma
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
 //------
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
		 						$("#result").html('Procesando');

		 				},
		 			success:  function (data) {
		 					 $("#result").html(data);   
		 				} 
		 	});

	  }else{

		  alert('Guarde la información del asiento');

	  }


 }
//------------
 function AgregaCuenta_enlace()
{

	     var id_asiento  = $("#id_asiento").val();
	 	 var cuenta11    = $("#cuenta1").val();
		 var partidad1   = $("#partidad").val();
		 var cuenta01    = $("#cuenta0").val();

		 var xid_asientod    = $("#xid_asientod").val();
		 var tipo_copia    	 = $("#tipo_copia").val();
		 var estado    		 = $("#estado").val();
	
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
		 						$("#result").html('Procesando');

		 				},
		 			success:  function (data) {
		 					 $("#result").html(data);   
		 				} 
		 	});
		  	}else {
				  	$.ajax({
				 			data:  parametros,
				 			url:   '../model/Model-co_dasientos_enlace.php',
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
	  }else{ 
 		  alert('Guarde la información del asiento');
 	  }

   	 $('#myModalAuxIng').modal('hide');
   	 DetalleAsiento();

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

	   
	  ViewDetCostos(id_asiento);
   
   	
}
//------------------------
//---------------------------------------------------
 function VerBeneficiarios( )
 {
 	 var	id_asiento    =   $("#id_asiento").val( );
 	 
 	 var parametros = {
 			    'id_asiento' : id_asiento 
   };


 	$.ajax({
 			data:  parametros,
 			url:   '../model/Model-ver_lista_beneficiarios_cxp.php',
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
 function FormView()
{

	 $("#ViewForm").load('../controller/Controller-co_xpagar.php');

     $("#ViewFiltroCosto").load('../controller/Controller-co_asientos_costo.php');
	

} 
//------------------
 function monto_riva(tipo_retencion,monto_iva,montoriva){

	  var iva = 0;
	  var flotante = 0 ;


	  if (tipo_retencion == 0){
		  $(montoriva).val(0);
       }

	  if (tipo_retencion == 1){
		  iva = monto_iva * (30/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
		  }
	  //-------------------
	  if (tipo_retencion == 2){
		  iva = monto_iva * (70/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);

		  } 
	  //-------------------
	  if (tipo_retencion == 3){
		  iva = monto_iva * (100/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
		  }  
	//-------------------
	  if (tipo_retencion == 4){
		  iva = monto_iva * (10/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	   }  
	  //---------------------
	  if (tipo_retencion == 9){
		  iva = monto_iva * (10/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	   }  
	  //-------------------
	  if (tipo_retencion == 5){
		  iva = monto_iva * (70/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	  } 	  
	  
	//-------------------
	  if (tipo_retencion == 10){
		  iva = monto_iva * (20/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	  } 	

 }
//------------------
 function calculoFuente(tipo_retencion,monto_iva,montoriva){

	  var iva = 0;
	  var flotante = 0 ;

	  var norma = $("#base").val();

	  monto_iva =  parseFloat(norma).toFixed(2)  ;

	  if (tipo_retencion == 0){
		  $(montoriva).val(0);
       }

	  if (tipo_retencion == 1){
		  iva = monto_iva * (1/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
		  }
	  //-------------------
	  if (tipo_retencion == 2){
		  iva = monto_iva * (2/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);

		  } 
	  //-------------------
	  if (tipo_retencion == 8){
		  iva = monto_iva * (8/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
		  }  
	//-------------------
	  if (tipo_retencion == 10){
		  iva = monto_iva * (10/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	   }  
	     
	  if (tipo_retencion == 1.75){
		  iva = monto_iva * (1.75/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	   }  
	  
	  if (tipo_retencion == 2.75){
		  iva = monto_iva * (2.75/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $(montoriva).val(flotante);
	   }  

}
//------------------  
 function calculopagar(total, montoriva, montofuente,montocxp){
	 
	var norma = $("#norma").val();
	var total_base = parseFloat(total).toFixed(2)  ;

	if ( norma == 'S'){

 	 var fuente = $(montofuente).val();
	 var total_cxp = parseFloat(total_base)  -  fuente ;

	}else{

	 var iva    = $(montoriva).val();
	 var fuente = $(montofuente).val();
	 var resultado = parseFloat(iva) + parseFloat(fuente);
	 var total_cxp = parseFloat(total)  -  resultado ;

	}

	if ( norma == 'X'){
		var fuente = $(montofuente).val();
		var total_cxp = parseFloat(total_base)  -  fuente ;
   
	}

	 $(montocxp).val(total_cxp.toFixed(2));
 }
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
 
	  var norma = $("#norma").val();

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
			    'monto_iva'   :monto_iva,
				'norma' : norma
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
function ViewDetCostos(id_asiento)
{
 
 
	 var parametros = {
			    'id_asiento' : id_asiento 
   };

 
	$.ajax({
 			data:  parametros,
			url:   '../model/ajax_view_costo.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 				$("#view_detalle_costo").html(data);   

				} 
 	}); 

	} 

//--------------------------
function LimpiaCosto( )
{

	$("#codigo1").val( '');
	$("#codigo2").val( '');
	$("#codigo3").val('' );
	$("#monto_costo").val(0);

} 
//---------------------		
function GuardarCosto( )
{

    var id_asiento =   $("#id_asiento").val( );
	var codigo1      =	$("#codigo1").val( );
	var codigo2      =	$("#codigo2").val( );
	var codigo3      =	$("#codigo3").val( );
	var codigo4      =	$("#monto_costo").val( );


 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'codigo1' : codigo1 ,
						    'codigo2' : codigo2 ,
						    'codigo3' : codigo3 ,
						    'codigo4' : codigo4 
 			    };

	if ( codigo1 > 0 ) {			 
		if ( codigo4 > 0 ) {
			if ( id_asiento > 0 ) {
				
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
								 ViewDetCostos(id_asiento);
								 LimpiaCosto();
							} 
				});

             }
        }
     }
}
  