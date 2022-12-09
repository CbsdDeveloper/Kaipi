var oTablea;  
var oTablec;  
var oTable ;

$(document).ready(function(){
     
      
        
        oTable =  $('#jsontable').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 1] },
		      { "sClass": "ye", "aTargets": [ 3 ] },
 		      
		    ] ,
		    "language":  [ {
	            "decimal": ",",
	            "thousands": "."
	           }
		    ] 
          } 
        );
        
        oTablea =  $('#jsontablea').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 1] },
		      { "sClass": "ya", "aTargets": [ 3 ] },
 		      
		    ] ,
		    "language":  [ {
	            "decimal": ",",
	            "thousands": "."
	           }
		    ] 
          } 
        );
   
        
        oTablec =  $('#jsontablec').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 1] },
		      { "sClass": "highlight", "aTargets": [ 3 ] },
 		      
		    ] ,
		    "language":  [ {
	            "decimal": ",",
	            "thousands": "."
	           }
		    ] 
          } 
        );
        
        
        modulo(); 

		$("#MHeader").load('../view/View-HeaderModel.php');

	    $("#FormPie").load('../view/View-pie.php');
  		
	    $("#ViewFormAux").load('../controller/Controller-co_aux.php');
	    
	   
	    $('#load').on('click',function(){
 
            BusquedaGrilla();
 
		});

	    $('#loada').on('click',function(){
	    	 
            BusquedaGrillaa();
 
		});
	    
	    
	    $('#loadc').on('click',function(){
	    	 
            BusquedaGrillac();
 
		});

		$('#loadSri').on('click',function(){
  
            openFile('../../upload/uploadxml?file=1',650,300)
 

		});

	 
  
	    $('#loadxls').on('click',function(){

	  	  var ffecha1 = $("#ffecha1").val();

		  var ffecha2 = $("#ffecha2").val();

		  var festado = $("#festado").val();

		  

		  var cadena = 'festado='+festado+'&ffecha1='+ffecha1+'&ffecha2='+ffecha2;

		  var page = "../reportes/excel.php?"+cadena;  

 
		  window.location = page;  
 
		});
 
})

 
function changeAction(tipo,action,mensaje){

	 

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 
			  		//$('#mytabs a[href="#tab2"]').tab('show');

                	

				  	LimpiarDatos();

				  

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

// ir a la opcion de editar

function goToURL( id) {

   
 
	 var parametros = {
			 		  'tipo': 'cxp',
                      'id' : id 
  	  };

	  $.ajax({

					data:  parametros,
 					url:   '../model/Model_Aux.php',
 					type:  'GET' ,
 					cache: false,
 					beforeSend: function () { 
  							$("#ViewFiltroAux").html('Procesando');
   					},
 					success:  function (data) {
 							$("#ViewFiltroAux").html(data);  // $("#cuenta").html(response);
  					} 

			}); 
 
	 $('#myModalCxp').modal('show');

 }
 
//ir a la opcion de editar

function LimpiarDatos() {  

	

	$("#baseimponible").val(0);

	

	$("#baseimpgrav").val(0);

	

	$("#montoiva").val(0);

	

	$("#basenograiva").val(0);

	

	$("#montoice").val(0);

	

	$("#descuento").val(0);

	

	$("#porcentaje_iva").val(0);

	

	$("#valorretbienes").val(0);

	

	$("#valorretservicios").val(0);

	

	$("#valretserv100").val(0);

	

	$("#baseimpair").val(0);

  

	$("#codretair").val("");    

	

}

//-------------------------------------------------------------------------

 



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

 

    return today;

            

} 

 

  //------------------------------------------------------------------------- 

  function BusquedaGrilla(){        	 



	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

	  	var suma = 0;
	    var total1 = 0;
	    
		$.ajax({
  
		    url: '../grilla/grilla_xpagar.php',

			dataType: 'json',

			cache: false,

			success: function(s){

			//console.log(s); 

			oTable.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTable.fnAddData([

	                      s[i][0],

	                      s[i][1] , 

	                      s[i][2],

	                     '$ ' + s[i][3]  , 
  
	                      '<button class="btn btn-xs" title= "Novedad" onClick="javascript:goToURLNovedad('+ "'" +s[i][0]+ "'" +')"><i class="glyphicon glyphicon-comment"></i></button>&nbsp;  '  +
	                      
	                      '<button class="btn btn-xs" title="Detalles" onClick="javascript:goToURL('+ "'" +s[i][0]+ "'" +')"><i class="glyphicon glyphicon-tasks"></i></button>&nbsp;  '   

 	                  ]);									
 				  
					  suma  =  s[i][3] ;

					  total1 += parseFloat(suma) ;

					  $("#totalPago").html('$ '+ total1.toFixed(2) );
					  
				} // End For

				

			}				

										

			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});
 
 

  }   

//--------------
//------------------------------------------------------------------------- 

  function BusquedaGrillaa()

  {

	  	var suma = 0;
	    var total1 = 0;
	    
		$.ajax({
  
		    url: '../grilla/grilla_xanticipo.php',

			dataType: 'json',

			cache: false,

			success: function(s){

			//console.log(s); 

			oTablea.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTablea.fnAddData([

	                      s[i][0],

	                      s[i][1] , 

	                      s[i][2],

	                     '$ ' + s[i][3]  ,
	                     
	                      '<button class="btn btn-xs" title="Detalles" onClick="javascript:goToURL('+ "'" +s[i][0]+ "'" +')"><i class="glyphicon glyphicon-tasks"></i></button>&nbsp;  '   

 
 	                  ]);									
 				  
					  suma  =  s[i][3] ;

					  total1 += parseFloat(suma) ;

					  $("#totalPago1").html('$ '+ total1.toFixed(2) );
					  
				} // End For

				

			}				

										

			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});
 	  
 
  	

  }
//--------------------
  function BusquedaGrillac()

  {

	  	var suma = 0;
	    var total1 = 0;
	    
		$.ajax({
  
		    url: '../grilla/grilla_xcxc.php',

			dataType: 'json',

			cache: false,

			success: function(s){

			//console.log(s); 

			oTablec.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTablec.fnAddData([

	                      s[i][0],

	                      s[i][1] , 

	                      s[i][2],

	                     '$ ' + s[i][3]  ,
	                     
	                      '<button class="btn btn-xs" title="Detalles" onClick="javascript:goToURL('+ "'" +s[i][0]+ "'" +')"><i class="glyphicon glyphicon-tasks"></i></button>&nbsp;  '   

 
 	                  ]);									
 				  
					  suma  =  s[i][3] ;

					  total1 += parseFloat(suma) ;

					  $("#totalPago2").html('$ '+ total1.toFixed(2) );
					  
				} // End For

				

			}				

										

			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});
 	  
 
  	

  }

  //------------------------------------------------------------------------- 

  function DetalleAsientoIR()

  {

	  

  

	  var id_asiento = $('#id_asiento').val(); 

	  

	  var parametros = {

 			    'id_asiento' : id_asiento 

     };

	  

  	$.ajax({

 			data:  parametros,

 			 url:   '../model/ajax_DetAsientoIR.php',

 			type:  'GET' ,

 			cache: false,

 			beforeSend: function () { 

 						$("#retencion_fuente").html('Procesando');

 				},

 			success:  function (data) {

 					 $("#retencion_fuente").html(data);   

 				     

 				} 

 	});

 

  }

 

//------------------------------------------------------------------------- 

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

		 			 

		 			 

			 

		 		//		 BusquedaGrilla(oTable);

	 

	}



 }

 



//------------------------------------------------------------------------- 

 function ViewDetAuxiliar(codigoAux)

 {

 	 

 

 	 var parametros = {

			    'codigoAux' : codigoAux 

    };

 	 

 	$.ajax({

			data:  parametros,

			 url:   '../controller/Controller-co_asientos_aux01.php',

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

//----------------------------------------------

 function GuardarNovedad()

 {

 
    var idprov  =  $("#prove").val(   );
    var comment =  $("#comment").val(   );
    
 
 			 	 var parametros = {
 						    'idprov' : idprov ,
						    'comment':comment,
						    'accion' : 'editar'
  			    };

 
			 	$.ajax({

						data:  parametros,
 						url:   '../model/ajax_GuardaCiuNovedad.php',
 						type:  'GET' ,
 						cache: false,
 						beforeSend: function () { 

									$("#guardarNovedad").html('Procesando');

							},

						success:  function (data) {

								   $("#guardarNovedad").html(data);   
  
							} 

				});
 
 }
 

function openFile(url,ancho,alto) {

	   var posicion_x; 
       var posicion_y; 
       var enlace; 
 

  posicion_x=(screen.width/2)-(ancho/2); 

  posicion_y=(screen.height/2)-(alto/2); 
 
  enlace = url  ;
 
  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

}

//--------------------

function goToURLNovedad( id ) {

	 
		$("#prove").val( id );
	 
 	   var parametros = {
	 						    'idprov' : id  ,
							    'accion' : 'visor'
	  	};

	    $.ajax({

							data:  parametros,
	 						url:   '../model/ajax_GuardaCiuNovedad.php',
	 						type:  'GET' ,
	 						cache: false,
	 							 success:  function (data) {

	 								$("#comment").val(  data  );
	  
								} 

					});
				 	
		 $('#myModalNovedad').modal('show');
 
}
 
function ListaAux( vprod)
{

	  

  var parametros = {

 			    'idprov': vprod

  };

 
		$.ajax({

			data:  parametros,

			url:   '../model/Model_listaAuxCxp.php',

			type:  'GET' ,

			beforeSend: function () { 

					$("#ViewFormAux").html('Procesando');

			},

		success:  function (data) {

				 $("#ViewFormAux").html(data);   

			     

			} 

 			

		 

	});	 

 



}
