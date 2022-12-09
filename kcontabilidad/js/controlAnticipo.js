var oTableGrid;  
var oTable ;
var oTableGasto ;

var oTableFactura;

var oTableIngreso;

var oTableGastoDev;

 
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
	 
	 
       oTableGrid     = $('#ViewCuentas').dataTable();  
       
	   oTableGasto    = $('#jsontable_gasto').dataTable();  

       oTableIngreso  = $('#jsontableIngreso').dataTable();  

       oTableGastoDev = $('#jsontableGastoDev').dataTable();  
       
      
	   modulo();
	   FormView();
	   FormFiltro();
	   BusquedaGrilla( oTable);
	   ViewDetAuxiliar();
       

	    $("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		
		 oTableFactura =  $('#jsontable_factura').dataTable( {
	 		    "aoColumnDefs": [
	 		      { "sClass": "highlight", "aTargets": [ 0 ] },
	 		      { "sClass": "highlight", "aTargets": [ 1 ] },
	 		      { "sClass": "highlight", "aTargets": [ 2 ] }
	 		    ]
	 		  } );
		 
		 
	

		$('#loadt').on('click',function(){
 	 		 
			CargaDatos();
			  
			});

	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
		});

//-----------------------------------------------------------------
		$.ajax({
 			url: "../model/ajax_item_tipo.php",
			type: "GET",
			success: function(response)
			{
					$('#ingreso_lista').html(response);
			}
	    });


});  
/*
Carga datos de tramites
*/ 
function CargaDatos() {

	var idtramite  =  $("#id_tramite").val();

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
/*
*/
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

//----------------------------------------------------------------- 
function AbrirEnlace()
{

	 var id_asiento = $("#id_asiento").val();
  
	 if (id_asiento > 0 ) {

		 	var enlace = 'co_validacion_asiento_ve?codigo=' +id_asiento;

		   window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
	 }
 
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

//----------------
function BuscaPartida(cuenta){
	 
	
	 var id_asiento = $("#id_asiento").val();
	 
    var parametros = {
    		'cuenta' : cuenta  ,
    		'id_asiento' : id_asiento
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
	 
	 var id_asiento = $("#id_asiento").val();
	 
	    var parametros = {
	    		'cuenta' : cuenta  ,
	    		'id_asiento' : id_asiento
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
					url:   '../model/Model-controlAnticipo.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
 							 DetalleAsiento();
 							 totalc();
  					} 
 			}); 
 	  
}

//--------
function cambio(accion,id) {

	  
	 
	  $("#xid_asientoaux").val(id);
	  
	  $("#monto_pone").val('0.00');
  		 
	  $('#myModalvalor').modal('show');
	  
	  $("#guardar_valor").html('');
}

//-----------------------------------------------------
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
	  }
}

//---------------------------------------------------
function VerBeneficiarios( )
{
	 var	id_asiento    =   $("#id_asiento").val( );
	 var parametros 	  = {
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

//--------------------------------------
function goToURLAuxMain( id) {

 	   var id_asiento  = $("#id_asiento").val();
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


//---VerIngresos -----------------------------------------------------------------
function VerIngresos(oTableIngreso,tipo){    
	
	var parametros = {
 		'tipo' : tipo
   };

	$.ajax({
 	    url: '../grilla/grilla_co_enlacei.php',
		 data:  parametros,
		dataType: 'json',
		cache: false,
		success: function(s){
			oTableIngreso.fnClearTable();

		if(s){

			for(var i = 0; i < s.length; i++) {
				oTableIngreso.fnAddData([
                      s[i][0],
                      s[i][1],
                      s[i][2],
                      s[i][3],
                      s[i][4],
                      '<button class="btn btn-xs" onClick="AgregaCuentaI('+"'"+s[i][0]+"'"+','+"'"+ s[i][3] +"'"+ ')"><i class="glyphicon glyphicon-edit"></i></button> ' 
                    ]);									
			} // End For
		   }				
		},
		error: function(e){
		   console.log(e.responseText);	
		}
 });
}


//------------------
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

//---------------------------------------------(oTableGastoDev)
function BusquedaTramiteId(oTableGastoDev){     
	
    var tramite_e = $('#tramite_e').val(); 
    
	var parametros = {
			'idtramite' : tramite_e  
	};

	$.ajax({
		data:  parametros,
	    url: '../grilla/grilla_co_asiento_tramite.php',
		dataType: 'json',
		cache: false,
		success: function(s){
			oTableGastoDev.fnClearTable();
	
		if(s){
			
			 
			
			for(var i = 0; i < s.length; i++) {
				oTableGastoDev.fnAddData([
	                  s[i][0],
	                  s[i][1],
	                  s[i][2],
	                  s[i][3],
	                  s[i][4],
	                  s[i][5],
	                  '<button class="btn btn-xs" onClick="javascript:goToURLAsientoGasto('+s[i][0]+","+s[i][5]+','+ "'"+ s[i][1] +"'"+','+ "'"+ s[i][3] +"'"+','+ "'" +s[i][4] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' 
	              ]);									
			} // End For
		   }				
		},
		error: function(e){
		   console.log(e.responseText);	
		}
	});

}

///-----------------BusquedaTramiteId
function BusquedaTramite(oTableGastoDev,idtramite){     
	
			var parametros = {
					'idtramite' : idtramite  
			};

			$.ajax({
				data:  parametros,
			    url: '../grilla/grilla_co_asiento_tramite.php',
				dataType: 'json',
				cache: false,
				success: function(s){
					oTableGastoDev.fnClearTable();
			
				if(s){
 					
					for(var i = 0; i < s.length; i++) {
						oTableGastoDev.fnAddData([
			                  s[i][0],
			                  s[i][1],
			                  s[i][2],
			                  s[i][3],
			                  s[i][4],
			                  s[i][5],
			                  '<button class="btn btn-xs" onClick="javascript:goToURLAsientoGasto('+s[i][0]+","+s[i][5]+','+ "'"+ s[i][1] +"'"+','+ "'"+ s[i][3] +"'"+','+ "'" +s[i][4] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' 
			              ]);									
					} // End For
				   }				
				},
				error: function(e){
				   console.log(e.responseText);	
				}
			});

}

//--------------------------------------------
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
	var estado 	   = 	$("#estado").val( );
 

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

//---------------------------
function fecha_hoy()
{

    var today = new Date();
    var dd    = today.getDate();
    var mm    = today.getMonth()+1; //January is 0!
    var yyyy  = today.getFullYear();

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
 
 	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var festado = $("#festado").val();
	 
	  
	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  
       };

 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_controlAnticipos.php',
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
 
		   $("#qid_asiento").val('');

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
 			 url:   '../model/ajax_DetAsientoPrincipal.php',
 			type:  'GET' ,
 			cache: false,
 			beforeSend: function () { 
 						$("#DivAsientosTareas").html('Procesando');
 				},
  			success:  function (data) {
 					 $("#DivAsientosTareas").html(data);   
 				  	 $('#txtcuenta').val('');
 				  	 $('#cuenta').val('');
 				     totalc();
 				} 
  	});
 
  }

//-------------
function GuardarAsientoAnticipo( )
{
     var id_asiento = $('#id_asiento').val(); 
     var cuentaa    = $('#cuentaa').val(); 
     var partidaa   = $('#partidaa').val(); 
     var id_asientod= $('#id_asientoda').val(); 
     var montoa     = $('#montoa').val(); 
 
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
  //------------------------------------------------------------------------- 
function GuardarAsientoOtro( )
{
	 
	 
     var id_asiento      = $('#id_asiento').val(); 
     var id_asientod     = $('#xid_asientod').val(); 
     var partidaa        = $('#partida_enlace').val(); 
     var xtipo		     = $('#xtipo').val(); 
 
     var id_tramite      = $('#id_tramite').val(); 

     
	  var parametros = {
 			    'id_asiento' : id_asiento ,
 			    'partidaa' : partidaa,
 			    'id_asientod' : id_asientod,
 			    'xtipo' : xtipo,
 			    'id_tramite' : id_tramite
     };

	  
	  
		   	$.ajax({
		  			data:  parametros,
		  			url:   '../model/Model-co_asientosOtros.php',
		  			type:  'GET' ,
		  			cache: false,
		  			beforeSend: function () { 
		  						$("#guardarpartidas").html('Procesando');
		  				},
		  			success:  function (data) {
		  					 $("#guardarpartidas").html(data);   
		  					  
		  					DetalleAsiento();
		  				} 
		  	});

}

//-------------------
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
 
//---------------------
function ExportarExcel() {

	    
	// url,ancho,alto
		
 
		
	  var id_asiento = $('#id_asiento').val(); 
		
 

	var enlace = '../reportes/excelAsiento.php?id=' + id_asiento;

 
	window.location.href = enlace;


	}

//------------------
function AgregaCuentaI(partida,cuenta)
  {

	  var id_asiento = $('#id_asiento').val(); 
	 
	  var estado = $('#estado').val(); 

	  if (id_asiento > 0){

			 var parametros = {
 		 			    'id_asiento' : id_asiento ,
 		 			    'cuenta' : cuenta,
 		 			    'partida' : partida,
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

		  	$('#myModalIngresos').modal('hide')

	  }else{

		  alert('Guarde la información del asiento');

	  }
 

  }

//--------------------------   
function CopiaEnlace(cuenta, partida)
{

	  var id_asiento = $('#id_asiento').val(); 

	  var estado     = $('#estado').val(); 

	  if (id_asiento > 0){

			 var parametros = {
 		 			    'id_asiento' : id_asiento ,
 		 			    'cuenta' : cuenta,
 		 			    'partida' : partida,
 		 			    'estado' : estado
 		     };

			  
		  	$.ajax({
		 			data:  parametros,
		 			url:   '../model/Model-co_dasientos_copia.php',
		 			type:  'GET' ,
		 			cache: false,
 		 			success:  function (data) {
		 					 $("#DivAsientosTareas").html(data);   

							  DetalleAsiento();
		 				} 
		 	});

	  }else{

		  alert('Guarde la información del asiento');

	  }

	


  }  

//---------------
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

	 $("#ViewForm").load('../controller/Controller-controlAnticipo.php');
	 $("#ViewPago").load('../controller/Controller-asiento_pagos.php');

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
	 
	 $('#enlace_pago').val('G'); 
	 
	 var parametros = {
			 'accionpago' : 'gasto' ,
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
//------------------------------
 function IngresoAsiento()
 {

	 var id = $('#id_asiento').val(); 

	 $('#enlace_pago').val('I'); 
	 
	 var parametros = {
			 'accionpago' : 'ingreso' ,
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
 
 //-------------------
 function buscatramite()
 {
 
	 var id         = $('#id_asiento').val(); 
	 var id_tramite = $('#id_tramite').val(); 
	 var estado     = $('#estado').val(); 

	 var bandera    = 1; 
	 
	 if (id_tramite > 0) {
		 bandera = 0;
	 }
	 
	 if ( id > 0) {
		 bandera = 1;
	 }
	 
	 if (estado == 'aprobado') {
		 bandera = 0;
	 }
	
	 if ( bandera > 0) {
 		
			$.ajax({
    			url: "../model/ajax_gasto_tramite.php",
    			type: "GET",
    			success: function(response)
    			{
    					$('#tramite_dato').html(response);
    			}
    		});
			
		    
	 } 
} 

 //----------------------
function FormFiltro()
{
	 $("#ViewFiltro").load('../controller/Controller-co_anticipo_filtro.php');
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


    var parametros = {
        'id_asiento' : id
        };


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
function aprobacion_pago( ){

      
     var pagado = $("#pago").val();     
     var estado = $("#estado").val();     
 
     if (estado == 'aprobado'){
    	 	$("#action_pago").val( 'aprobacion');
		    
    	 	if (pagado == 'N'){
 		 			var	id_asiento    =   $("#id_asiento").val( );
		 			 $("#asiento").val(id_asiento );
		 			alert('Generacion de Comprobante');
		     }
     }else{
    	 $("#action_pago").val( 'no');
    	 alert('No se puede generar comprobante de pago');
     }
 
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
	 
	var fcopiar         =	$("#fcopiar").val( );
	
	if (  $("#fcopiar").val()  ) { 
		$("#idprov").val(fcopiar ); 
	}  

    var valida 		   = validaPantalla();
	var	id_asiento     =   $("#id_asiento").val( );
	var codigodet      =	$("#codigodet").val( );
	var idprov         =	$("#idprov").val( );
	
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


	var	id_tramite     =  $("#id_tramite").val( );
 	var parametros     = {
						    'id_asiento' : id_asiento ,
						    'cuenta' 	 : cuenta ,
						    'grupo' 	 : grupo ,
						    'id_tramite' : id_tramite
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

 //-------------------- 
 function goToURver(tipo,idasientod, cuenta )
 {
	 
		var	id_asiento     =  $("#id_asiento").val( );
		var	id_tramite     =  $("#id_tramite").val( );
		
		
		$("#xid_asientod").val( idasientod );
 
		
		if (tipo == 0) {
			$("#xtipo").val( 'I' );
		}else {
			$("#xtipo").val( 'G' );
		}
			
 	    var parametros = {
						    'id_asiento' : id_asiento ,
						    'id_tramite' : id_tramite ,
						    'tipo' : tipo ,
						    'idasientod' : idasientod ,
						    'cuenta' : cuenta 
 			    };

			 	$.ajax({

						data:  parametros,
						url:   '../controller/Controller-co_asientos_aux04.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#Viewpartidas").html('Procesando');
							},
 						success:  function (data) {
 								 $("#Viewpartidas").html(data);   
							} 

				});
 
}

 //----------------------------- 
 function aprobacion(url){

     $("#action").val( 'aprobacion');

     var action			  =   $("#action").val();
 	 var	id_asiento    =   $("#id_asiento").val( );

	 var parametros = {
				'action' : 'aprobacion' ,
                'id_asiento' : id_asiento 

    };

     var mensaje = 'Desea aprobar el asiento contable ' + action;

     alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

    	 if (e) {

				  $.ajax({
								data:  parametros,
								url:   '../model/Model-controlAnticipo.php',
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

 //--------------------------------------------------
 function goToURLAsientoGasto( id_tramite,monto,partida,item,cuenta) {

	 
	  var id_asiento = $('#id_asiento').val(); 
	  var estado 	 =  $('#estado').val(); 
 
	  if (id_asiento > 0){
 
			 var parametros = {
 		 			    'id_asiento' : id_asiento,
 		 			    'cuenta'     : cuenta,
 		 			    'id_tramite' : id_tramite,
 		 			    'estado'  : estado,
 		 			    'partida' : partida,
 		 			    'item'    : item,
 		 			    'monto'   : monto
 		     };

			 $.ajax({
 					data:  parametros,
					url:   '../model/Model-co_dasientos_gasto.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#result").html('Procesando');
						},
					success:  function (data) {
							 $("#result").html(data);   
						} 
 			});
			 
 
		  	 $('#id_tramite').val(id_tramite); 
  		  	 $('#myModalGastoDev').modal('hide');

	  }else{

		  alert('Guarde la información del asiento');

	  }
 
	 
}

 //--------------
 function goToURLAsiento( id_asientod,monto,iva,item, partida) {

	 
	  var id_tramite = $("#id_tramite").val();
	  var festado    = $("#estado").val();

 
	  
    var parametros = {
				'id_tramite' : id_tramite  ,
				'festado' : festado  ,
				'id_asientod': id_asientod,
				'monto' : monto,
				'iva' : iva,
				'item' : item,
				'partida' :partida
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

 ///--------------------------------------------
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