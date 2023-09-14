$(function(){

    $(document).bind("contextmenu",function(e){
        return false;
    });

});


var oTable;
var oTable_inversion;


//-------------------------------------------------------------------------
$(document).ready(function(){

     	 "use strict";

         oTable           = $('#jsontable').dataTable(); 
         
         oTable_inversion = $('#jsontable_inversion').dataTable(); 
         
         
		 CatalogoTraslado();  

		$("#MHeader").load('../view/View-HeaderModel.php');
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();

	    FormView();

	    FormFiltro();

	    BusquedaGrilla( oTable);

 	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);

		});

 	   $('#binicial').on('click',function(){
            AsientoApertura(1);
		});
 	   
 	   $('#binicialR').on('click',function(){
           AsientoApertura(2);
		});
 	   
 	  $('#binicialO').on('click',function(){
          AsientoApertura(4);
		});
 	  
 	  $('#binicial_ap').on('click',function(){
          AsientoApertura(7);
		});
 	  
 	  $('#binicial_di').on('click',function(){
          AsientoApertura(8);
		});
 	  
 	  
 	  
 	  
 	  
 	   
 	   
 	   $('#binicialq').on('click',function(){
            AsientoAperturaq();
		});
 	   
 	    //-----------------------------------------------------------------
 	   $('#recargar').on('click',function(){
          BusquedaGrilla(oTable);
		});

        $('#biniciala').on('click',function(){
			forma_ingresos(1);
 		});

       $('#binicialp').on('click',function(){
			forma_ingresos(2);
 		});

       
     
         

});  
//---------------------------
//----------------
function forma_ingresos(tipo) {
  	 
	var fanio = $("#anio_asiento").val();
	
	var parametros = {

			'fanio' : fanio  ,
			'accion' : tipo

     };
	

	  $.ajax({

					data:  parametros,
					url:   '../controller/Controller-co_aux_inicial.php',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
						     $("#ViewFiltroDato").html(data);   
 					} 

			}); 

}
//----------------
function goToURLDel(accion,id) {

var fanio = $("#anio_asiento").val();
	
	var parametros = {
			'fanio' : fanio  ,
			'parametro' :3,
			'id' : id,
			'accion' : 0
     };

	 $.ajax({
			url:   '../model/Model-co_periodos_apertura.php',
			type:  'GET' ,
			data:  parametros,
			cache: false,
			beforeSend: function () { 
					$("#procesados").html('Procesando');
			},
			success:  function (data) {
					 $("#procesados").html(data);  // $("#cuenta").html(response);
			} 
	}); 

}
//-----------------------------------------------------------------
function PoneEnlace(id_asientod,cuenta)
{
 
	var fanio = $("#anio_asiento").val();


	$("#id_asientodx").val(id_asientod);
		 
			 	 var parametros = {
						    'cuenta' 	 : cuenta ,
						    'id_asientod' : id_asientod,
							'fanio':fanio
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../controller/Controller-co_asiento_apertura',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 $("#ViewFiltroIngreso").html(data);   
							} 
				});
	 

}
/*
Limpiar casilleros para auxiliares
*/
function LimpiarAuxiliar( ) {

	  
	 
	$("#monto").val('0.00');
	
	$("#beneficiario").val('');
		 
	$('#idprov1').val('');
	
	 
}
/*
datos para cambiar valor auxiliar
*/
function cambio(id) {

	  
	 
	$("#xid_asientoaux").val(id);
	
	$("#monto_pone").val('0.00');
		 
	$('#myModalvalor').modal('show');
	
	$("#guardar_valor").html('');
}
/*
guarda monto auxiliar
*/
function guarda_monto_aux()
{
     var xid_asientoaux = $('#xid_asientoaux').val(); 
     
     var monto  =  $('#monto_pone').val(); 
     
	  var parametros = {
 			    'id_asientoaux' : xid_asientoaux ,
 			    'monto' : monto
     };

	  if ( monto > 0) {
		  	$.ajax({
		 			data:  parametros,
		 			url:   '../model/Model-asiento_aux_monto.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#guardar_valor").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#guardar_valor").html(data);   
		 					  
		 				} 
		 	});

			 
			 $('#myModalvalor').modal('hide');
			 $('#myModalAux').modal('hide');
	  }
}
/*
Datos principales
*/

function goToURLParametro(accion,id_asiento_aux)
{
 
	if ( accion == 'ciu')	 
	{
		cambio(id_asiento_aux) ;
    }
	else{
 
			 	 var parametros = {
					  		 'accion' : 'del',
 						     'id_asiento_aux' : id_asiento_aux
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../model/ajax_crea_aux_ini.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 alert(data);
								 $('#myModalAux').modal('hide');
							} 
				});
	  
			}
}
/*
inserta grupo de inversion

*/
function goToURLInversion(monto,grupo)
{
 
	var fanio = $("#fanio").val();

  
			 	 var parametros = {
					  		 'monto' :  monto ,
 						     'grupo' : grupo,
							  'fanio':fanio
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../model/ajax_crea_aux_inv.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 alert(data);
								 
							} 
				});
	  
			 
}



/*
agregar muevo auxiliar ()
*/
function AgregaAuxiliar()
{
 

	var monto       = $("#monto").val();
	var idprov      = $('#idprov1').val();
	var id_asientod = $("#id_asientodx").val();

			 	 var parametros = {
							'accion' 	 : 'add' ,
						    'monto' 	 : monto ,
							'idprov' : idprov,
						    'id_asientod' : id_asientod
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../model/ajax_crea_aux_ini.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 $("#guardarIngreso").html(data);   
								 alert(data);
							} 
				});

				$('#myModalAux').modal('hide');
		 

}


// completar 
function VerAuxiliarDato(accion,id_prov,col)
{
 
//	VerAuxiliarDato('seleccion','1205440710',4)

  
var valor   =  document.getElementById('tablaBasica').tBodies[0].rows[col].cells[2].innerHTML;

 
var fanio = $("#anio_asiento").val();

	var cuenta    = $("#cuenta0").val();
	var v_asiento = $("#v_asiento").val();

	if (v_asiento) {
		 
			 	 var parametros = {
						    'cuenta' 	 : cuenta ,
						    'id_prov' : id_prov,
							'fanio': fanio,
							'accion':accion,
							'col':col,
							'v_asiento':v_asiento,
							'valor':valor
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../model/ajax_crea_aux_ini.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 $("#guardarIngreso").html(data);   
							} 
				});
			}

}

/*
pone lista de auxilares
*/

function PoneEnlaceAUX(id_asientod,cuenta)
{
 

	$("#id_asientodx").val(id_asientod);
		 
			 	 var parametros = {
						    'cuenta' 	 : cuenta ,
						    'id_asientod' : id_asientod
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../controller/Controller-co_asientos_aux_ini.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 $("#ViewFiltroAux").html(data);   
							} 
				});
	 

}



//------actualiza_datoh
function actualiza_datod(valor,id)
{
	 
	  montoDetalle('D',valor,id)
	 
	  
} 

//----------------------
function actualiza_datoh(valor,id)
{
	 
	   montoDetalle('H',valor,id)
	   
	  
} 
//---------------
function montoDetalle(tipo,valor,codigo)
{

	  
  var fanio 	    = $("#anio_asiento").val();
  
  var parametros = {
			    'tipo'   : tipo,
			    'valor'  : valor,
			    'codigo' : codigo,
			    'fanio' : fanio
   };

	$.ajax({
			data:  parametros,
			 url:   '../model/Model_Apertura_DAsiento.php',
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

//---------------------------
function AgregaCuenta_enlaceaux()

{

	
	
		 var fanio 	    = $("#anio_asiento").val();
      	 var cuenta1    = $("#listaa").val();
 		 var cuenta2    = $("#listab").val();
  		 var montoi     = $("#montoi").val();
 		
 
  		var parametros = {
  				'fanio' : fanio  ,
  				'parametro' :9,
  				'cuenta1' : cuenta1,
  				'cuenta2' : cuenta2,
  				'montoi' : montoi,
  				'accion' : 0
  	     };
  		
  		if ( montoi > 0 ){

		  		 $.ajax({
		  				url:   '../model/Model-co_periodos_apertura.php',
		  				type:  'GET' ,
		  				data:  parametros,
		  				cache: false,
		  				beforeSend: function () { 
		  						$("#procesados").html('Procesando');
		  				},
		  				success:  function (data) {
		  						 $("#procesados").html(data);  // $("#cuenta").html(response);
		  				} 
		  		}); 
	  
  		}
  	 
  		$('#myModaldato').modal('hide');
  		
 
}
//-------
function AgregaCuenta_enlace()

{

 	 	 var cuenta11    = $("#cuenta1").val();
 		 var cuenta01    = $("#cuenta0").val();

		 var xid_asientod    = $("#xid_asientod").val();
 	 
 
		  var parametros = {
 	 			    'cuenta0' : cuenta01,
 	 			    'cuenta1' : cuenta11,
 					'xid_asientod' : xid_asientod 
	     };
		  
 		  		
		  		$.ajax({
		 			data:  parametros,
		 			url:   '../model/Model-co_dasientos_apertura.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#guardarIngreso").html('Procesando');

		 				},
		 			success:  function (data) {
		 					 $("#guardarIngreso").html(data);   
		 				} 
		 	});
	   			
	  

  	 $('#myModalAuxIng').modal('hide');
		 
 
}
//---------
function changeAction(tipo,action,mensaje){

			

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

				 

					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');

                	

                    LimpiarPantalla();

                    

					$("#action").val("add");

					 

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



	var parametros = {

					'accion' : accion ,

                    'id' : id 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-co_periodos.php',

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
//-------------------------------------------------------------------------
function CerrarPeriodo( ) {


	var anio = $("#anio").val("");

	var parametros = {

					'accion' : 'cierre',  
					'anio'   : anio 
 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-co_periodos.php',

					type:  'GET' ,

					cache: false,

					beforeSend: function () { 

 							$("#result").html('Procesando');

  					},

					success:  function (data) {

							 $("#result").html(data);  // $("#cuenta").html(response);

						     

  					} 

			}); 

	  BusquedaGrilla(oTable);

    }
//--------------------------------------------------------


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

   

	$("#action").val("add");

	

    	$("#id_periodo").val("");

    	$("#anio").val(" ");

	   $("#mes").val(" ");

		$("#estado").val(" "); 

		$("#sesion").val(" "); 

		$("#creacion").val(" ");          

		$("#sesionm").val(""); 

		$("#modificacion").val(" ");	   

    }

   

 

 //---------------------------

function accion(id,modo,estado)

{

  
	$("#action").val(modo);

	

	$("#id_periodo").val(id);

 
    BusquedaGrilla(oTable);

 
}

//---------------

function CrearPeriodo (){
	
	
	 "use strict";
	
	 $.ajax({

 
			url:   '../model/Model-co_periodos_anio.php',

			type:  'GET' ,

			cache: false,

			beforeSend: function () { 

					$("#result").html('Procesando');

			},

			success:  function (data) {

					 $("#result").html(data);  // $("#cuenta").html(response);

				     alert(data);

			} 

	}); 

	 
	  BusquedaGrilla(oTable);
	
}
function AsientoApertura (parametro){
	
	var fanio = $("#anio_asiento").val();
	
	var parametros = {
			'fanio' : fanio  ,
			'parametro' :parametro,
			'accion' : 0
     };
	
	var mensaje = "Desea generar el asiento de apertura " + fanio ;
	
	if ( parametro == 7 ){
		mensaje = "Desea AUTORIZAR el asiento de apertura " + fanio ;
	}
	
	if ( parametro == 8 ){
		mensaje = "Desea DIGITAR el asiento de apertura " + fanio ;
	}
	
	
	  alertify.confirm(mensaje , function (e) {
		  if (e) {
			  $.ajax({
					url:   '../model/Model-co_periodos_apertura.php',
					type:  'GET' ,
					data:  parametros,
					cache: false,
					beforeSend: function () { 
							$("#procesados").html('Procesando');
					},
					success:  function (data) {
							 $("#procesados").html(data);  // $("#cuenta").html(response);
					} 
			}); 
		  }
   }); 
 
	
}
//------------
function AsientoAperturaq (){
	
	var fanio = $("#anio_asiento").val();
	
	var parametros = {
			'fanio' : fanio , 
			'accion' : 1
     };
	
 			 
			  $.ajax({

					url:   '../model/Model-co_periodos_apertura.php',
					type:  'GET' ,
					data:  parametros,
					cache: false,
					beforeSend: function () { 
							$("#procesados").html('Procesando');
					},
					success:  function (data) {
							 $("#procesados").html(data);  // $("#cuenta").html(response);
					} 
			}); 
 
}
//---------------
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

    

    document.getElementById('fechatarea').value = today ;

    

    document.getElementById('fechafinal').value = today ;

 

            

} 
//---------------------------------
 function inversion(oTable_inversion,grupo){     
	 
	  var fanio = $("#fanio").val();
      
      var parametros = {
				'fanio' : fanio  ,
				'grupo' : grupo
      };
 
	  var suma = 0;

	  var total1 = 0;
	  
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_apertura_inv.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTable_inversion.fnClearTable();
				if (s) {
					for(var i = 0; i < s.length; i++) {
							oTable_inversion.fnAddData([
								'<b>'+ s[i][0]+'</b>',
								s[i][1],
								s[i][2],
								s[i][3] ,
								s[i][4],
 								'<button class="btn btn-xs" onClick="goToURLInversion('+s[i][4] +','+"'"+ s[i][0] + "'"+')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
					]);		
 							  suma  =  s[i][2] ;
 							  total1 += parseFloat(suma) ;
 							  
 							 $("#montoi").val( total1.toFixed(2) );

							  
			     } // End For
			   }
			} 
	  });
		
		
		  var fanio      = $("#anio_asiento").val();
		  
		  
	   	   var parametros1 = {
	   			'fanio' : fanio  ,
	   			'accion' : '1'
	        };
	   	   var parametros2 = {
	      			'fanio' : fanio  ,
	      			'accion' : '2'
	           };
	   	   
	//-----------------------------------------------------------------------
		  	 $.ajax({
				 data:  parametros1,
				 url: "../model/ajax_cuenta_acumula.php",
				 type: "GET",
		       success: function(response)
		       {
		           $('#listaa').html(response);
		       }
			 });
	//-----------------------------------------------------------------------      
		  	 $.ajax({
				 data:  parametros2,
				 url: "../model/ajax_cuenta_acumula.php",
				 type: "GET",
		       success: function(response)
		       {
		           $('#listab').html(response);
		       }
			 });
		 
		
		
 }

 
  //------------------------------------------------------------------------- 

  function BusquedaGrilla(oTable){        	 

     	var fanio = $("#fanio").val();
     	var fecha = new Date();
     	var ano = fecha.getFullYear();

     	if(fanio==null){
     		fanio = ano;
     	}
          

      var parametros = {
				'fanio' : fanio  
      };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_periodo.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
 			if (s) {
 			for(var i = 0; i < s.length; i++) {
 				 oTable.fnAddData([
 						s[i][0],
 						s[i][1],
 						s[i][2],
 						s[i][3],
 						s[i][4],
  					'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
 					'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
 				]);										
			     } // End For
			   }
			} 
	  });
}   
//------------------------------------------
function modulo()

 {

 	 var modulo =  'kcontabilidad';

 	 var parametros = {

			    'ViewModulo' : modulo 

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
//-------------
function CatalogoTraslado()

 {

 
	var parametros = {

		'accion' : 'visor' 

};

 	$.ajax({
			 data:  parametros,
			 url:   '../model/ajax_traslado.php',

			type:  'GET' ,

			cache: false,

			beforeSend: function () { 

						$("#ViewFormCatalogo").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewFormCatalogo").html(data);  // $("#cuenta").html(response);

				     

				} 

	});

 
 }
//-----------------

 function FormView()

 {

    



	 $("#ViewForm").load('../controller/Controller-co_periodos.php');

      



 }

 

//----------------------

 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-co_periodos_filtro.php');

	 


	 



 }



    

  