var oTableGrid;  
var oTable ;

//-------------------------------------------------------------------------
$(document).ready(function(){

        oTable     = $('#jsontable').dataTable(); 
 

		oTableGrid 	= $('#jsontable_aux').dataTable( {      
			searching: true,
			paging: true, 
			info: true,         
			lengthChange:true ,
			aoColumnDefs: [
				 { "sClass": "highlight", "aTargets": [ 0 ] },
				 { "sClass": "de", "aTargets": [5 ] }
			   ] 
		 } );



		$("#MHeader").load('../view/View-HeaderModel.php');
		$("#FormPie").load('../view/View-pie.php');
		

		modulo();
	    FormView();
	    FormFiltro();
	 
 
	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
		});

	   $('#loadAux').on('click',function(){
		   BusquedaGrilla_aux(oTableGrid)
		}); 
	   
	   $('#buno').on('click',function(){
		   VerAsientosDiferencia();
		}); 
	   
	   $('#bdos').on('click',function(){
		   CambioTramite();
		});
	   
	     $('#loadAuxD').on('click',function(){
		   Actualiza_lista_Aux();
		});
	   
	   
	   
	   
		$('#loadAuxPago').on('click',function(){
			BusquedaGrilla_aux_pago(oTableGrid)
		 }); 

		


});  
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
			return false;	  
}
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
					url:   '../model/Model-co_asientos_rev.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
							 alert('Estado Modificado');
  					} 

			}); 
			
 	  BusquedaGrilla(oTable);
}
//--------------------
function goToURL1(accion,id) {


	var parametros = {
					'accion' : accion ,
                    'id' : id 
	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-co_asientos_pag.php',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
							 alert(data);
 					} 
			}); 
    }
//------------------------------------------ 
function goToURLDel(accion,id) {

	var parametros = {

					'accion' : accion,

                   'id' : id 

	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-co_asientos_rev.php',

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

		$("#action").val("");

		

		$("#action").val("add");

		

		

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

 

 }

//----------------------------------

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

//ir a la opcion de editar

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
//---------
 function Actualiza_lista_Aux()
{
	
	 	 var i = 0 ;
	 	 
	     var dato_ruc = $("#dato_ruc").val();
		 
		 if ( dato_ruc ){
			
					 $('#jsontable_aux tr').each(function() { 
						    
						 
						   var customerId = $(this).find("td").eq(0).html();  
						   var cuenta     = $(this).find("td").eq(2).html();  
						
						   if (  i >   0  ) { 
							   
							  
							     GuardarAuxiliar_lista(customerId,cuenta,dato_ruc )
						
							   
						   }
						   
						   i = i + 1;
						  
				     }); 
				     
				     alert('Datos Procesados...');
				     BusquedaGrilla_aux(oTableGrid);
			}else{
			
			 alert('Ingrese la cedula del auxiliar ...');
			}
			
}	

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
	  var qid_asiento = $("#qid_asiento").val();


      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  ,
				'qid_asiento': qid_asiento
      };

 		

		if(user != '') 

		{ 

		$.ajax({

		 	data:  parametros,
		    url: '../grilla/grilla_co_asientos_rev.php',
			dataType: 'json',
			cache: false,
			success: function(s){
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

					  s[i][6],
					  
					  s[i][7],

 
                      '<button class="btn btn-xs btn-warning" title="Poner en digitado" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-repeat"></i></button>  &nbsp; &nbsp;' +
                      
                      '<button class="btn btn-xs btn-danger" title="Poner en Aprobado" onClick="goToURL('+"'aprobar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-ok"></i></button>  &nbsp; &nbsp;' +

                      '<button class="btn btn-xs btn-info" title="Marcar Tramite de pagado" onClick="goToURL1('+"'ok'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-alert"></i></button> ' +

                      '<button class="btn btn-xs btn-success" title="Activar Tramite de pago" onClick="goToURL1('+"'no'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-erase"></i></button>  &nbsp; &nbsp;' +

                      '<button class="btn btn-xs btn-default" title="Activar proceso devengar" onClick="goToURLDel('+"'compromiso'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-resize-small"></i></button>'

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

//--------------	    ( );
  function BusquedaGrilla_aux(oTableGrid){        	 


		$.ajax({
		    url: '../grilla/grilla_co_asientos_aux_error.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTableGrid.fnClearTable();
			if(s){
 			for(var i = 0; i < s.length; i++) {
 				oTableGrid.fnAddData([
	                      s[i][0]  ,
	                      '<b><a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalAux" onclick="ViewDetAuxiliar('+"'"+ s[i][2] +"'" +','+ s[i][0]+')">' + 
	                      s[i][1] + '</a></b>',
	                      s[i][2],
	                      s[i][3],
						  s[i][4],
						  s[i][5],
						  s[i][6],
						  s[i][7]
 	                  ]);									
	 				} // End For
 				}				
			 
			},
 			error: function(e){
 			   console.log(e.responseText);	
 			}

			});
 		 
}   
//-------
function BusquedaGrilla_aux_pago(oTableGrid){        	 


	var nombre = $('#dato_nombre').val(); 

	var dato_mes = $('#dato_mes').val(); 

	var parametros = {
		'nombre': nombre,
		'mes': dato_mes
};



	$.ajax({
		data:  parametros,
		url: '../grilla/grilla_co_asientos_pago_error.php',
		dataType: 'json',
		cache: false,
		success: function(s){
			oTableGrid.fnClearTable();
		if(s){
		 for(var i = 0; i < s.length; i++) {
			 oTableGrid.fnAddData([
					 '<b><a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalAuxPago" onclick="ViewDetAuxiliarPago('+"'"+ s[i][5] +"'" +','+ s[i][0]+')">' + 
					  s[i][0] + '</a></b>',
					  s[i][1],
					  s[i][2],
					  s[i][3],
					  s[i][4],
					  s[i][5],
					  s[i][6],
					  s[i][7]
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

 				  	 $('#txtcuenta').val('');

 				  	 $('#cuenta').val('');

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

    



	 $("#ViewForm").load('../controller/Controller-co_asientos_rev.php');

      

 
	 



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

						 $("#result_pago").html(data);  // $("#cuenta").html(response);

					     

				} 

		}); 

	 



      

     

 }

 

 

 

//----------------------

 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-co_asiento_rev_filtro.php');

	 

 }

//----------------------

 

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

//------------------------------------------------------------------------- 

 function CambioTramite( ){

      
     var cod_tramite = $("#cod_tramite").val();     
     var estado      = $("#cod_estado").val();     
 

      

			 var parametros = {

					    'accion' : 'tramite',
					    'cod_tramite' : cod_tramite,
					    'estado' : estado
		    };

			if ( cod_tramite > 0 ){
			 	 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientos_rev.php',
						type:  'GET' ,
						cache: false,
	 					success:  function (data) {
	 						alert(data);
	
	 						  $("#cod_tramite").val('');     

	 					      $("#cod_estado").val('');   
	 					     
							} 
	
				});
	     
		 

     }

     

     
 }

  //----------------------

  
  function ViewDetAuxiliarPago(estado, id_asiento_aux)
  {

	$("#pagado").val(estado );
	$("#id_auxd").val(id_asiento_aux );
 
	

 }
 /*
 */
 function ViewDetAuxiliar(codigoAux, id_asiento)

 {

   $("#id_asiento").val(id_asiento );
   $("#codigodet").val(codigoAux );
	
     var parametros = {
		    'codigoAux' : codigoAux ,
			'id_asiento': id_asiento 
    };

 	 

 	$.ajax({

			data:  parametros,

			 url:   '../controller/Controller-co_asientos_aux_a.php',

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

//------------------------------------------------------------------------- 

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

 //Controller-co_asientos_costo.php
function GuardarAuxiliar_lista(id_asiento,cuenta_aux,idprov )

 {
  
 
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'cuenta_aux' : cuenta_aux ,
						    'idprov' : idprov 
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosaux_a.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarAux").html('Procesando');
							},
						success:  function (data) {

								 $("#guardarAux").html(data);   
 							} 

				});
			 	
 

 }
//------------------------------------------------------------------------- 

 function GuardarAuxiliar()

 {
  

	var	id_asiento     =    $("#id_asiento").val( );
 	var cuenta_aux      =	$("#cuenta_aux").val( );
 	var idprov         =	$("#fcopiar").val( );

 
 
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'cuenta_aux' : cuenta_aux ,
						    'idprov' : idprov 
 			    };

			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosaux_a.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarAux").html('Procesando');
							},
						success:  function (data) {

								 $("#guardarAux").html(data);   
 							} 

				});
			 	
			 	BusquedaGrilla_aux(oTableGrid);
 	 



 }

 //---------------------

 function VerAsientosDiferencia( )

 {
 
 		 

 			 var parametros = {

						    'accion' : 'Diferencia'  
 			    };

			 	 
 			 	$.ajax({
 						data:  parametros,
 						url:   '../model/Model-co_asientos_rev.php',
 						type:  'GET' ,
 						cache: false,
 						beforeSend: function () { 
 									$("#ver_dato").html('Procesando');
 							},
 						success:  function (data) {
 								 $("#ver_dato").html(data);   
 
							} 

				});
 
 }

 
 
//----------------------------- 

function CambioEstado( ){

 
	var     pagado		  =   $("#pagado").val();
	 var	id_auxd       =   $("#id_auxd").val();

	var parametros = {
			   'pagado' : pagado ,
			   'id_asiento_aux' : id_auxd 
   };

	var mensaje = 'Desea cambiar estado del auxiliar ' + id_auxd ;

	alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

	if (e) {

			 	 $.ajax({
							   data:  parametros,
								url:   '../model/_aux_ciu_estado_pago.php',
								type:  'GET' ,
							   cache: false,
							   success:  function (data) {
										$("#result_dato").html(data);   

							   } 

					   }); 

			 }

		});

}
//------------------------------
function aprobacion(url){
     

     $("#action").val( 'aprobacion');

     var    action		  =   $("#action").val();
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
										 $("#result").html(data);   

								} 

						}); 

			  }

		 });



	}

 //--------------
 function CargaDatos() {


	
var idtramite= 	$("#cod_tramite").val();  

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

									  $("#fechacd").val( response.e );  
									   
									  $("#idasiento").val( response.f );  

									  $("#estado_p").val( response.d );  
									  
							 } 
					 });


} 	 
function ActualizaInformacion( ) {


	var  idtramite = $("#tramite").val( );  
	var fecha = $("#fecha").val();
	var fechac = $("#fechac").val();
	var fechacc = $("#fechacc").val();
	var festado = $("#estado_p").val();
	  
    var fechacd = 	$("#fechacd").val();  
	var idasiento = $("#idasiento").val();  
 

	var parametros = {
			"idtramite" : idtramite ,
			"fecha" :  fecha,
			"fechac" : fechac,
			"fechacc" : fechacc,
			"festado" :festado,
			"accion" : 'edit',
			'fechacd':fechacd,
			'idasiento' : idasiento
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