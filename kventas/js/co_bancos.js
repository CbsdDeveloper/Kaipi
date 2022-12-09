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
 

var oTableGrid;  

var oTable ;



//-------------------------------------------------------------------------

$(document).ready(function(){

       oTable = $('#jsontable').dataTable(); 

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

//-----------------------------------------------------------------


function changeAction(tipo,action,mensaje){

			

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

				 

			  	  	

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

// ir a la opcion de editar abrirAux
function abrirDato(id) {
	
	var parametros = {

					'accion' : 'editar' ,

                    'id' : id 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-co_bancos.php',

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

function goToURL(accion,id) {

  
	 

	var parametros = {

					'accion' : accion ,

                    'id' : id 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-co_bancos.php',

					type:  'GET' ,

					cache: false,

					beforeSend: function () { 

 							$("#result").html('Procesando');

  					},

					success:  function (data) {

							

							$("#result").html(data);  // $("#cuenta").html(response);

				


							DetalleConciliacion();

							

							DetalleConciliacion_Deposito();

							

							DetalleConciliacion_Nota();

							

							total_saldos(  );

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

	    

	    ﻿$("#id_concilia").val("");



	    $("#detalle").val("");

	    $("#estado").val("digitado");

	    $("#cuenta").val("");

	    

	    $("#saldobanco").val("0");

	    $("#notacredito").val("0");

	    $("#notadebito").val("0");

	    $("#saldoestado").val("0");

	    $("#cheques").val("");

	    $("#depositos").val("");

 	    

	    $("#fecha").val(fecha);

  

		$("#action").val("add");

		

		

	/*	 var parametros = {

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

	 	});*/

 

 }

 //-------------------------------------------------------------------------

function LimpiarNota(){



	

	var tipo =  $("#transaccion").val();

	

	if (tipo == 'credito'){

		 $("#detalle_nota").val('NC - ');

	}else{

		 $("#detalle_nota").val('ND - ');

	}

	

	 $("#monto").val(0 );

	 $("#doc_nota").val( '');

	 

           	

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

  

    

    var date = new Date();

	

	var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);

	 

   var dia = ultimoDia.getDate();

	 

   var today = yyyy + '-' + mm + '-' + dia; 

	  

	  

     return  today;      

} 

 

  //------------------------------------------------------------------------- 

  function BusquedaGrilla(oTable){        	 



	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

		var user = $(this).attr('id');

    

	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var festado = $("#festado").val();

	  var idbancos = $("#idbancos").val();

	  

	 

		

 

      var parametros = {

				'ffecha1' : ffecha1  ,

				'ffecha2' : ffecha2  ,

				'festado' : festado  ,

				'idbancos': idbancos

      };



 

		

		if(user != '') 

		{ 

		$.ajax({

		 	data:  parametros,

		    url: '../grilla/grilla_co_bancos.php',

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

					  s[i][6], 

					  s[i][7],

                      '<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' +

                      '<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'

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

//-------------

//------------------------------------------------------------------------- 

 function modulo()

 {

 	 var modulo1 =  'kventas';

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
 
	 $("#ViewForm").load('../controller/Controller-co_bancos.php');

      

	 $("#ViewNota").load('../controller/Controller-co_bancos_nota.php');

 
 }

//--------------

 function SaldoBancos( )
{

var	id_concilia     =  $("#id_concilia").val( );
var fecha =  $("#fecha").val( );

var saldo_total = 0;



	 if (id_concilia ){

		 	var parametros = {
						    'id_concilia' : id_concilia ,
						    'fecha': fecha
 			    };

 			 $.ajax({
						data:  parametros,
						url:   '../model/Model-co_bancos_saldo.php',
						type:  'GET' ,
						cache: false,
   						success:  function (data) {
 							$("#saldobanco").val(parseFloat(data));
							} 
				}) ; 

 	 }else{
		 alert('Ingrese la informacion');
 	 }


}
//------------------------------------------------------
function reporte_impresion(enlace)

	{

	 

	 var	id_concilia     =  $("#id_concilia").val( );

  

	  enlace = enlace +'?id=' +id_concilia ;

											   

  	  window.open(enlace,'#','width=750,height=480,left=30,top=20');

	 

	}	

 //-------------

//---------------

 function NaN2Zero(n){

	    return isNaN( n ) ? 0 : n; 

	}

 //-------------------------------------------- 
 function total_saldos_datos(  ){

	  
	 var	id_concilia     =    $("#id_concilia").val();     
	 
	   
	 abrirDato(id_concilia) ;

	  var saldoestado  	=  NaN2Zero ( $('#saldoestado').val() ) ; 

	  var cheques		=  NaN2Zero ( $('#cheques').val() ) ; 

	  var depositos	    =  NaN2Zero ( $('#depositos').val() ) ; 

	 
	  var totalBase 	= parseFloat(saldoestado)  -   parseFloat(depositos)  -    parseFloat(cheques)  ;

	  

	  var flotante = parseFloat(totalBase).toFixed(2)  ;

	  

	  $('#saldo2').val(flotante)



	 //--------------

	  var saldobanco  	=  NaN2Zero ( $('#saldobanco').val() ) ; 

	  var notacredito	=  NaN2Zero ( $('#notacredito').val() ) ; 

	  var notadebito	=  NaN2Zero ( $('#notadebito').val() ) ; 

	  

	 

	  var totalBase 	= parseFloat(saldobanco)  + 

	  					  parseFloat(notacredito)  - 

	  					  parseFloat(notadebito)  ;

	  

	  var flotante1 = parseFloat(totalBase).toFixed(2)  ;

	  

	  $('#saldo1').val(flotante1)

 

	  totalBase = flotante - flotante1;

	  

	  var total = parseFloat(totalBase).toFixed(2)  ;

	  

	  if (total == 0 ){

		  $('#resumen').html('<b>Saldo Conciliado</b>'); 

		  return 1;

	  }else{

		  $('#resumen').html('<b>Saldo No Conciliado ' + total + '</b>'); 

		  return 0; 

	  }


	  

}
//-----------------------------------
 function total_saldos(  ){

	  
	   

	  var saldoestado  	=  NaN2Zero ( $('#saldoestado').val() ) ; 

	  var cheques		=  NaN2Zero ( $('#cheques').val() ) ; 

	  var depositos	    =  NaN2Zero ( $('#depositos').val() ) ; 

	 
	  var totalBase 	= parseFloat(saldoestado)  -   parseFloat(depositos)  -   parseFloat(cheques)  ;

	  

	  var flotante = parseFloat(totalBase).toFixed(2)  ;

	  

	  $('#saldo2').val(flotante)



	 //--------------

	  var saldobanco  	=  NaN2Zero ( $('#saldobanco').val() ) ; 

	  var notacredito	=  NaN2Zero ( $('#notacredito').val() ) ; 

	  var notadebito	=  NaN2Zero ( $('#notadebito').val() ) ; 

	  

	 

	  var totalBase 	= parseFloat(saldobanco)  + 

	  					  parseFloat(notacredito)  - 

	  					  parseFloat(notadebito)  ;

	  

	  var flotante1 = parseFloat(totalBase).toFixed(2)  ;

	  

	  $('#saldo1').val(flotante1)

 

	  

	  totalBase = flotante - flotante1;

	  

	  var total = parseFloat(totalBase).toFixed(2)  ;

	  

	  if (total == 0 ){

		  $('#resumen').html('<b>Saldo Conciliado</b>'); 

		  return 1;

	  }else{

		  $('#resumen').html('<b>Saldo No Conciliado ' + total + '</b>'); 

		  return 0; 

	  }

 
	  

}

//----------------------

 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-co_bancos_filtro.php');

	 

 }

//----------------------

 

//----------------------

 function accion(id,accion)

 {

  

   $("#action").val(accion);

   

  $("#id_concilia").val(id);      
		 



 }

//Controller-co_asientos_costo.php

//------------------------------------------------------------------------- 

 function ChequeLista()

 {

	   var	id_concilia     =    $("#id_concilia").val();      

	 
	 if (id_concilia ){
 
		      var parametros = {

						    'id_concilia' : id_concilia 

 			    };

			 	 

			 	$.ajax({

						data:  parametros,

						url:   '../model/Model-co_bancos_cheque.php',

						type:  'GET' ,

						cache: false,

						beforeSend: function () { 

									$("#ViewFiltroCheque").html('Procesando');

							},

						success:  function (data) {

								 $("#ViewFiltroCheque").html(data);   

							     

							} 

				});

			 	

 	 }else{

 		 

		 alert('Ingrese la informacion');

	

 	 }



 }

 ///-----------------------------------
/// trasferencias....... 
 function DepositoLista()
{

 	 

	 var	id_concilia     =  $("#id_concilia").val( );

	 if (id_concilia ){

		 var parametros = {
						    'id_concilia' : id_concilia 
 			    };

			 	 

			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_bancos_deposito.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#ViewFiltroDeposito").html('Procesando');
							},
						success:  function (data) {
								 $("#ViewFiltroDeposito").html(data);   

							} 

				});

			 	

 	 }else{

 		 

		 alert('Ingrese la informacion');

	

 	 }



 }

 //---- DepositoLista / ViewFiltroDeposito
function SumarSeleccion( ) {
	 
	
	
	  $i = 1;
	  
	 	var debe = 0;  
	 	var debe2 = 0;  
	  	var total_debe = 0; 
	  	var total_ver = 0; 
	  	var customerId1;
	  	  
	  	  var total_debe2 = 0; 
	  	var total_ver2 = 0; 
	  	var customerId2;
 	  
		 $('#table_deposito tr').each(function() { 
 			 
			   if ( $i > 1){ 
				
			       customerId1 = $(this).find("td").eq(6).html();  
			       customerId2 = $(this).find("td").eq(5).html();  
			       
			       
			       tipoo = $(this).find("td").eq(8).html();  
			           
			       
			
		
					debe =  parseFloat(customerId1).toFixed(2)  ;
				 	total_debe = parseFloat(debe) + total_debe;
			   		total_ver = parseFloat(total_debe).toFixed(2)  ;
			   
			  		debe2 =  parseFloat(customerId2).toFixed(2)  ;
				 	total_debe2 = parseFloat(debe2) + total_debe2;
			   		total_ver2 = parseFloat(total_debe2).toFixed(2)  
			   
			   
			  		 $("#Sumadebe").html('Parcial Ingreso: <b>'+ total_ver2 + '&nbsp;&nbsp;Egreso:' + total_ver + '</b>');     
			  
  			 }
  			  $i = $i + 1;
	     }); 
 
   }
   
 //-------  
 function MarcarSeleccion( tipo) {
	 
	
	
	  $i = 1;
	  
 
 	  
		 $('#table_deposito tr').each(function() { 
 			 
			   if ( $i > 1){ 
				
			       customerId1 = $(this).find("td").eq(9).html();  
			       
			       myFunctionDepositoSelec(customerId1,tipo);
			       
			  
  			 }
  			  $i = $i + 1;
	     }); 
 
   }
 //---

 function myFunction(codigo,objeto)

 {

	 var	id_concilia     =    $("#id_concilia").val();     
  
	   
	   var  accion 		    =  'check';
	   var  estado 		    =  '';
	   var	estado_tramite  = $("#estado").val( );

	    if (objeto.checked == true){
	    	estado = 'S'
	    } else {
	    	estado = 'N'
	    }
	    
	     
		   

	    var parametros = {
				'id_concilia' : id_concilia ,
                'idaux' : codigo ,
                'estado':estado ,
                'bandera': 'S'

	  };


	    if (id_concilia) {
	    	
	    	if (estado_tramite == 'digitado') {
		      $.ajax({
						data:  parametros,
						url:   '../model/Model-co_lista_cheque.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#Mov_cheque").html('Procesando');
							},
						success:  function (data) {
 								 $("#Mov_cheque").html(data);   
 							} 

				}); 
 
	    }

	  }   	

 }
//-------------
 function myFunctionCheque( )

 {

	   var	id_concilia     =  $("#id_concilia").val( );
	   var	estado_tramite  = $("#estado").val( );
 	   

	    var parametros = {
 				'id_concilia' : id_concilia ,
                'estado':estado_tramite 
 	  };

	    

	    if (id_concilia) {
 
	    	if (estado_tramite == 'digitado') {
 
		      $.ajax({
 						data:  parametros,
 						url:   '../model/Model-co_lista_cheque_data.php',
 						type:  'GET' ,
 						cache: false,
 						beforeSend: function () { 
 									$("#Mov_cheque").html('Procesando');
 							},
 						success:  function (data) {
 								 $("#Mov_cheque").html(data);   
 
							} 

				}); 

		  

		      total_saldos(  );

		      

	    }

	  }   	

 }
 

 //-------------------------
 function myFunctionDeposito_genera( )

 {

	   var	id_concilia     =  $("#id_concilia").val( );
	   var	estado_tramite  = $("#estado").val( );
 	   

	    var parametros = {
 				'id_concilia' : id_concilia ,
                'estado':estado_tramite 
 	  };

	    

	    if (id_concilia) {
 
	    	if (estado_tramite == 'digitado') {
 
		      $.ajax({
 						data:  parametros,
 						url:   '../model/Model-co_lista_dep_data.php',
 						type:  'GET' ,
 						cache: false,
 						beforeSend: function () { 
 									$("#Mov_Desposito").html('Procesando');
 							},
 						success:  function (data) {
 								 $("#Mov_Desposito").html(data);   
 
							} 

				}); 

		  

		      total_saldos(  );

		      

	    }

	  }   	

 }
//--
 
 function myFunctionDeposito(codigo,objeto)

 {
 
	   var	id_concilia     =  $("#id_concilia").val( );

  	   var estado = '';
 	   var	estado_tramite = $("#estado").val( );
 	   

	    if (objeto.checked == true){
 	    	estado = 'S'
   
	    } else {
 	    	estado = 'N'
 	    }

	    

	    var parametros = {
 				'id_concilia' : id_concilia ,
                 'idaux' : codigo ,
                 'estado':estado ,
                 'bandera': 'S'
 	    };

	    

	    if (id_concilia) {
 
	    	if (estado_tramite == 'digitado')	 {
 
			      $.ajax({
 							data:  parametros,
 							url:   '../model/Model-co_lista_deposito.php',
 							type:  'GET' ,
 							cache: false,
 							beforeSend: function () { 
 										$("#Mov_Desposito").html('Procesando');
 								},
 							success:  function (data) {
 									 $("#Mov_Desposito").html(data);   
 								} 

					}); 

 			  
 			  
 			  

	    	}     
	    	
	    	
	    	 var parametros1 = {
						    'id_concilia' : id_concilia 
 			    };

			 	 

			 	$.ajax({
						data:  parametros1,
						url:   '../model/Model-co_bancos_deposito_total.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#Marcado").html('Procesando');
							},
						success:  function (data) {
								 $("#Marcado").html(data);   

							} 

				});

	    	

	    }      	
	    
	    

 }
//-------- 
 function SumarMarcados( )
 {
	
	  var	id_concilia     =  $("#id_concilia").val( );
	  
	 var parametros1 = {
						    'id_concilia' : id_concilia 
 			    };

			 	 

			 	$.ajax({
						data:  parametros1,
						url:   '../model/Model-co_bancos_deposito_total.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#Marcado").html('Procesando');
							},
						success:  function (data) {
								 $("#Marcado").html(data);   

							} 

				});
	
	 }
//-------------------------
 function myFunctionDepositoSelec(codigo,objeto)

 {
 
	   var	id_concilia     =  $("#id_concilia").val( );

  	   var estado = '';
 	   var	estado_tramite = $("#estado").val( );
 	   
		var nameis = '#che_' + codigo;
	
	    if (objeto == 1){
 	    	estado = 'S'
 	    	
 	    	 $(nameis).prop('checked', true);
   
	    } else {
 	    	estado = 'N'
 	    	 $(nameis).prop('checked', false);
 	    }

	    

	    var parametros = {
 				'id_concilia' : id_concilia ,
                 'idaux' : codigo ,
                 'estado':estado ,
                 'bandera': 'S'
 	    };

	    

	    if (id_concilia) {
 
	    	if (estado_tramite == 'digitado')	 {
 
			      $.ajax({
 							data:  parametros,
 							url:   '../model/Model-co_lista_deposito.php',
 							type:  'GET' ,
 							cache: false,
 							beforeSend: function () { 
 										$("#Mov_Desposito").html('Procesando');
 								},
 							success:  function (data) {
 									 $("#Mov_Desposito").html(data);   
 								} 

					}); 

 
	    	}     

	    }      	

 }

//----------

 function abrir_grid(accion,codigo)

 {

	 

       var	id_concilia    =  $("#id_concilia").val( );

   
	    var parametros = {

				'id_concilia' : id_concilia ,

				'accion' : accion,

				'codigo' : codigo,

 				'bandera': 'X'

	  };

 	    

      $.ajax({

				data:  parametros,

				url:   '../model/Model-co_lista_nota.php',

				type:  'POST' ,

				cache: false,

				beforeSend: function () { 

							$("#Mov_credito").html('Procesando');

					},

				success:  function (data) {

						 $("#Mov_credito").html(data);   

					     

					} 

		}); 

      

        total_saldos(  );

        

 }
//----------------
 function abrirReporte( codigo)

 {
 
       var	id_concilia    =  $("#id_concilia").val( );

   
	    var parametros = {
				'id_concilia' : id_concilia ,
				'accion' : 'eliminar',
				'codigo' : codigo,
 				'bandera': 'X'
	  };

 	    

      $.ajax({
				data:  parametros,
				url:   '../model/Model-co_lista_chequee.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
							$("#Mov_cheque").html('Procesando');
					},
				success:  function (data) {
						 $("#Mov_cheque").html(data);   
					} 

		}); 

		DetalleConciliacion_Deposito();
 

	    DetalleConciliacion();

        total_saldos(  );
 
 }
 

//-------------------------

 function myFunctionNota()

 {

  

	   var	id_concilia    =  $("#id_concilia").val( );

	   

	   var	transaccion    =  $("#transaccion").val( );

	   var	fecha_nota     =  $("#fecha_nota").val( );

	   var	detalle        =  $("#detalle_nota").val( );

	   var	monto     	   =  $("#monto").val( );

	   var	doc_nota       =  $("#doc_nota").val( );

	   

	   var	estado_tramite = $("#estado").val( );

	    

	    var parametros = {

				'id_concilia' : id_concilia ,

				'transaccion' : transaccion,

				'fecha_nota' : fecha_nota,

				'detalle' : detalle,

				'monto': monto,

				'doc_nota': doc_nota,

				'bandera': 'S'

	  };

 	    

	    if (id_concilia) {

	    	

	    	if (estado_tramite == 'digitado') {

 	

	    		$.ajax({

						data:  parametros,

						url:   '../model/Model-co_lista_nota.php',

						type:  'POST' ,

						cache: false,

						beforeSend: function () { 

									$("#Mov_credito").html('Procesando');

							},

						success:  function (data) {

								 $("#Mov_credito").html(data);   

							     

							} 

				}); 

	    	//	myFunctionCheque( );

		        total_saldos(  );

		        

	    	}

	    	

	    }



 }

 //--- detalle conciliacion ------------------------------

 function DetalleConciliacion()

 {

   

 	   var estado = 'X';

 

 	   var	id_concilia     =  $("#id_concilia").val( );

 	  

	    var parametros = {

				'id_concilia' : id_concilia ,

                'estado':estado ,

                'bandera': 'N'

	  };

	    

      $.ajax({

				data:  parametros,

				url:   '../model/Model-co_lista_cheque_data.php',

				type:  'GET' ,

				cache: false,

				beforeSend: function () { 

							$("#Mov_cheque").html('Procesando');

					},

				success:  function (data) {

						 $("#Mov_cheque").html(data);   

					     

					} 

		}); 

  



 }

//--------------Mov_Desposito  

 function DetalleConciliacion_Deposito()

 {

   

 	   var estado = 'X';

 

 	   var	id_concilia     =  $("#id_concilia").val( );

 	  

	    var parametros = {

				'id_concilia' : id_concilia ,

                'estado':estado ,

                'bandera': 'N'

	  };

	    

      $.ajax({

				data:  parametros,

				url:   '../model/Model-co_lista_deposito.php',

				type:  'GET' ,

				cache: false,

				beforeSend: function () { 

							$("#Mov_Desposito").html('Procesando');

					},

				success:  function (data) {

						 $("#Mov_Desposito").html(data);   

					     

					} 

		}); 

  



 }

//--------------Mov_Desposito  

 function DetalleConciliacion_Nota()

 {

   

	 var	id_concilia    =  $("#id_concilia").val( );

 

	    

	    var parametros = {

				'id_concilia' : id_concilia ,

 				'bandera': 'N'

	  };

	    

       $.ajax({

				data:  parametros,

				url:   '../model/Model-co_lista_nota.php',

				type:  'POST' ,

				cache: false,

				beforeSend: function () { 

							$("#Mov_credito").html('Procesando');

					},

				success:  function (data) {

						 $("#Mov_credito").html(data);   

					     

					} 

		}); 

  



 }

//----------------------------- 

 

 function aprobacion(url){

     

     $("#action").val( 'aprobacion');

      

     

     var    action			   =   $("#action").val();

 	 var	id_concilia        =   $("#id_concilia").val( );

 	 var	estado       	   =   $("#estado").val( );

 	 

	 var parametros = {

				'action' : action ,

                'id_concilia' : id_concilia 

    };

     

     var mensaje = 'Desea aprobar la conciliacion bancaria ' + action;

     

     var valida = total_saldos(  );

     

     

     if (total_saldos() == 1)  {

        

    	 if (estado == 'digitado') {

    		 

		     alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

				

				     if (e) {

							    

								  $.ajax({

												data:  parametros,

												url:   '../model/Model-co_bancos.php',

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

     }else {

    	 alert('Banco NO conciliado');

     }

    	 



	}

 //--------------

