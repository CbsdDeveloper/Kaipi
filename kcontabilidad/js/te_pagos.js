var oTable ;

//-------------------------------------------------------------------------

$(document).ready(function(){
    
       "use strict" ;

        oTable = $('#jsontable').dataTable(); 
 
		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		 modulo();

	     FormView();

	     FormFiltro();
		
	     BusquedaGrilla(oTable);

	      $('#load').on('click',function(){

            BusquedaGrilla(oTable);

		  });
 
	     $('#Selec').hide(); 

});  

//----------------------------------------------------

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
function changeAction(tipo,action,mensaje){


			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
			  		//$('#mytabs a[href="#tab2"]').tab('show');
				  	LimpiarDatos();
                    LimpiarPantalla();

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

function goToURL(accion,id, idprov) {

  

	var parametros = {
					'accion' : accion ,
                    'id'     : id ,
                    'idprov' : idprov
 	  };


	$("#pago_valor").html(' ');

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-te_pagos.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {

							 $("#result").html(data);  // $("#cuenta").html(response);
 
  					} 

			}); 

	  		DetalleAsiento(id,idprov);
	  
     }

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// ir a la opcion de editar

function LimpiarPantalla() {

	

		var fecha = fecha_hoy();

 

 }

//ir a la opcion de editar

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
 function BusquedaGrilla(oTable){      
	 
	  "use strict" ;
	  
	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();

	  var idprove = '-' ; //$("#idprove_seleccione").val();
	  
	  BusquedaGrillaAll(oTable,ffecha1,ffecha2,idprove) ;
	  

//	   $('#Selec').hide(); 
	   
	   
	   
	   $("#pago_tipo").val('N');
	
	   /*
	  if ( idprove == '-'){   
	  }else{ 
		  BusquedaGrillaProv(oTable,ffecha1,ffecha2,idprove) ;
		   $('#Selec').show(); 
		   $('#apagar').prop("readonly", true);
		   $("#pago_tipo").val('S');	
	  }
 	 
*/
 }
 //------------------------------------
 function DetalleAsiento(id,idprov)
 {
       
 	  var parametros = {
  			    'id_asiento' : id ,
  			    'idprov' : idprov
      };

   	$.ajax({
  			data:  parametros,
  			url:   '../model/ajax_AsientosGastosPago.php',
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
 //------------------------------------------------------------------------- 
  function BusquedaGrillaAll(oTable,ffecha1,ffecha2,idprove){        	 
 

	  var suma = 0;
	  var total1 = 0;

	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'idprove' : idprove
       };

		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_te_pagos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
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
	                     '<div align="right">' +  s[i][6] + '</div>', 
	                     '<div align="right"><button title = "Seleccionar el registro para el pago" class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0]+",'" + s[i][3] + "'" +')"><i class="glyphicon glyphicon-ok"></i></button></div> '  
	                  ]);		

					  suma  =  s[i][6] ;

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
//-------------------------------------------------------------------
  function BusquedaGrillaProv(oTable,ffecha1,ffecha2,idprove){        	 
	  
	  var suma = 0;
	  var total1 = 0;

	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'idprove' : idprove
       };
 		
 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_te_pagos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
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
	                     '<div align="right">' +  s[i][6] + '</div>', 
	                     '<input type="checkbox" id="myCheck'+ s[i][0] +'"   onclick="myFunction('+ s[i][0] +',this)" '   + '>'   
	                  ]);		

 					  suma  =  s[i][6] ;
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

	 $("#ViewForm").load('../controller/Controller-te_pagos.php');

}
//----------------------
 function FormFiltro()
{

	 $("#ViewFiltro").load('../controller/Controller-te_pagos_filtro.php');

}
//----------------------
//----------------------
 function accion(idasiento,id,modo,comprobante)
 {

 
	    $("#id_asiento_aux").val(id);
	    $("#id_asiento_ref").val(idasiento);
	    

	    if ( idasiento > 0) {

	    	alert('Transaccion realizada con exito '  );

	    }

	    $("#comprobante").val(comprobante);

	    
	    $('#apagar').prop("readonly", true);
  
	    if ( modo == 'editar') {
	    	
	    	  $("#action").val('aprobacion');
	    	  
	    }else {
	    	
	    	  $("#action").val('editar');
	    	
	    	  BusquedaGrilla(oTable);  
	    	 
 	    	 
	    }
 	   	

	 

 }

 

//---------------

 function NaN2Zero(n){

	    return isNaN( n ) ? 0 : n; 

	}
 
//---------------------------------------------------
 function myFunction(codigo,objeto)

 {

  
	   var idprove = $("#idprove_seleccione").val();
 
	   var accion = 'check';

	   var estado = '';

	   

	    if (objeto.checked == true){

	    	estado = 'S'

	        

	    } else {

	    	estado = 'N'

	    }

	    

	    var parametros = {

				'accion' : accion ,

                'id' : codigo ,

                'estado':estado,
                
                'idprove' : idprove

	  };

	    

      $.ajax({

				data:  parametros,

				url:   '../model/Model-te_pagos.php',

				type:  'GET' ,

				cache: false,

				beforeSend: function () { 

							$("#mensajeEstado").html('Procesando');

					},

				success:  function (data) {

						 $("#mensajeEstado").html(data);   

					     

					} 

		}); 
 
 }
 //------------------
 function PagoVarios()
 {
	 
	 $("#pago_tipo").val('S');
	 
	 $("#pago_valor").html(' ');
	   
  
	  var idprove = $("#idprove_seleccione").val();
	  
  	  var nombre = $("#idprove_seleccione option:selected").text();
  	 
	  $('#mytabs a[href="#tab2"]').tab('show');
	  
	  var valor =  $("#mensajeEstado").html();    
	  
	  var total_amount_float = parseFloat(valor.replace(",", ".")).toFixed(2); 
 
 	  
	  $("#detalle").val('Pago Efectuado: ');
	  
	  $("#action").val('aprobacion');
	  
      var resultadoIVA = total_amount_float ;
	  
	  
	  alert(resultadoIVA);
	  
       $("#apagar").val(resultadoIVA);
 
 	 
	  $("#idprov").val(idprove);
	  
	  $("#beneficiario").val(nombre);

	   
 }
 //-----------------------ValidaMonto
 function ValidaMonto(monto)
 {
	
	 var monto_valida = $("#monto_valida").val();
	 
	 var var1 = parseInt(monto_valida).toFixed(2);
	 
	 var var2 = parseInt(monto).toFixed(2);
	 
	 var total  = var1 - var2;
	 
 
	 
	 if ( total > 0 ) {
 		 
		 $("#pago_valor").html('Saldo : ' + total );
		 
	 }else {
		 
		  $("#apagar").val(monto_valida);
		  
		  $("#pago_valor").html('Execede a pagar...' + total );
	 }
 
	 
 }
