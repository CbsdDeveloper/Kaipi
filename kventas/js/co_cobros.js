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

 
		$('#loadDoc').on('click',function(){
            openFile('../view/nom_pago_anulado',900,280);
		});
		
		
		$('#loadDocBuscar').on('click',function(){
    		   actualiza_anula();
		});

	  $('#load').on('click',function(){
    		  BusquedaGrilla(oTable);
		});
 

		$('#GuardaCiu').on('click',function(){
 	 		 
			Actualizaciu();
			
	 });

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
								 url:   '../model/ajax_spi_ciu.php',
								type:  'GET' ,
								success:  function (data) {
										 $("#guardarciu").html(data);   
										 
 
										 
		 							} 
						});
 
 
}

//-----------------------------------------------------------------
function openFile(url,ancho,alto) {
    
	  var idprov = $('#idbancos').val();
		 
	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+idprov  ;
	 
	  if ( idprov) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
 
//-----------------------------------------
function changeAction(tipo,action,mensaje){

			

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

				 

                 	

                    LimpiarPantalla();

                    

                    accion(0,'');

                    

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

// ir a la opcion de editar goToURLSpi


function AbrirCiu(){



	var idprov         	   =	$("#idprov").val( );
 
	 
		 		 		 
						 var parametros = {
								    'idprov': idprov 
					   };
						  
						  
						$.ajax({
								data:  parametros,
								 url:   '../controller/Controller-te_spi_ciu.php',
								type:  'GET' ,
								success:  function (data) {
										 $("#ViewFiltroProv").html(data);   
		 							} 
						});
		 
						$('#myModalciu').modal('show');
 
 

}	

function goToURL(accion,id,proveedor) {
 

	var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-co_cobros.php',
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
function goToURLSpi(id,spi,idprov) {
 
	

	fcuenta = $("#idbancos").val();

	var parametros = {
 					 'spi' : spi ,
					 'id' : id ,
					 'fcuenta':fcuenta,
					 'idprov': idprov
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../controller/Controller-te_spi_visor.php',
 					type:  'GET' ,
 					cache: false,
 					success:  function (data) {
							  $("#ViewFiltroAux").html(data);   
							  $("#guardarAux").html('');
   					} 

			}); 
 

     }
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

//ir a la opcion de editar

function validaPantalla() {



	var valida = 1;

	 

	if ( ! $("#tipo").val()  ) { valida = 0 ; }  

	

	if ( ! $("#retencion").val()  ) { valida = 0 ; }  

	  

	if ( ! $("#cheque").val()  ) { valida = 0 ; }   

 

 

	 return valida;



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

 

            

} 

 

  //------------------------------------------------------------------------- 

  function BusquedaGrilla(oTable){        	 
 
 
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var festado = $("#festado").val();
	  var fidbancos = $("#idbancos").val();

      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  ,
				'idbancos' : fidbancos  
      };

 

		$.ajax({
 			 data:  parametros,
			 url: '../grilla/grilla_co_cobros.php',
			dataType: 'json',
			cache: false,
			success: function(s){

			oTable.fnClearTable();
				if (s){

						for(var i = 0; i < s.length; i++) {

							oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
								s[i][3],
								s[i][4],
								s[i][5],
								s[i][6],
								'<button class="btn btn-xs btn-warning" title="Impresión comprobante de pago" onClick="goToURL('+"'editar'"+','+ s[i][7] +')"><i class="	glyphicon glyphicon-ok"></i></button> '  +
								'<button class="btn btn-xs btn-success" title="Actualización comprobante de pago" data-toggle="modal" data-target="#myModalAux" ' + 
								' onClick="goToURLSpi('+ s[i][0] +','+ "'" + s[i][8] +"'," + "'" + s[i][9] + "'" + ')"><i class="glyphicon glyphicon-usd"></i></button>' 
							]);									

						} // End For
				}
 			},
 			error: function(e){
 			   console.log(e.responseText);	
 			}
 		 });

	 
		actualiza_anula();

  }   

///-------------------------------------------------------------------------- 

 

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

    



	 $("#ViewForm").load('../controller/Controller-co_cobros.php');

      



 }

 //--------------------------------

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

//------------------------------------------------------------------------- 
 function PoneDoc(codigo)
	{
	 
   
	  enlace = '../reportes/ficheroanula?id=' +codigo;
											   
  	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
	 
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

//----------------------

 function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-co_pagos_filtro.php');

	 

 }

 //------------------------------------------------------------------------- 

 function GuardarAuxiliar()
{

 	
	var	id_asiento_aux     =    $("#id_asiento_aux_spi").val( );
	var comprobante        =	$("#comprobante_spi").val( );
	var spi_dato           =	$("#spi_dato").val( );
	var tipo         	   =	$("#tipo_spi").val( );
 	var fecha  			   =	$("#fecha_o").val( );

	 if (id_asiento_aux > 0 ){
  
 			 	 var parametros = {
 						    'id_asiento_aux' : id_asiento_aux ,
 						    'comprobante' : comprobante ,
 						    'spi_dato' : spi_dato ,
							'tipo' : tipo ,
							'fecha':fecha
 			    };

 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_pago_spi.php',
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

//----------------------

 function accion(id,modo,comprobante)

 {
   

	  if (modo == 'procesado'){

			$("#action").val('aprobado');

			$("#comprobante").val(comprobante);       

			$("#pago").val('S');     

	 }else{

			$("#action").val(modo);

			         

 	 }

 
	 BusquedaGrilla(oTable);



 }
//------------
 function actualiza_anula() {
	 
		
		var cuenta =	$("#idbancos").val();
 		 var parametros = {
				    'cuenta' : cuenta  ,
	                'action' : 'visor_grid'
	  };

 
	$.ajax({
	             data:  parametros,
	              url:   '../model/Model-pago_anulado.php',
	             type:  'POST' ,
	             cache: false,
	             success:  function (data) {
 	                       $("#ViewFormfile").html(data);  
 	                 
	                 } 
	     });
	    

 
	   }
//------------------------------------------------------------------------- 

function aprobacion( ){

     
	var	id_asiento    =   $("#id_asiento").val();
	
    var mensaje       = 'Desea generar el comprobante del asiento:  ' + id_asiento;

    var pagado 		  = $("#pago").val();     


 
		if (pagado == 'N'){
 
			$("#action").val( 'aprobacion');
 
		}else{

			mensaje       = 'Proceso Ya generado.... ' + id_asiento;	

			$("#action").val( 'novalido');
 	  }

	   alert(mensaje);

	}
 