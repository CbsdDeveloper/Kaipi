var oTable ;

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
    
        oTable = $('#jsontable').dataTable(); 
           
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
 
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
 	    
	   $('#load').on('click',function(){
 
            BusquedaGrilla(oTable);
  		
		});
 	   $('#Selec').hide(); 
 
 //-----------------------------------------------------------------

});  
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
function goToURL(accion,id) {
  
	var parametros = {
					'accion' : accion ,
                    'id' : id 
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
     }
//-------------------------------------------------------------------------//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
	
		var fecha = fecha_hoy();
	
		$("#fecha").val(fecha);
		
		$("#id_periodo").val("0");
		
    	$("#id_asiento").val(0);
	   
		$("#comprobante").val(" "); 
		$("#documento").val(" "); 
		$("#estado").val(" ");          
		$("#tipo").val(" ");
		$("#detalle").val("");
	 
		$("#action").val("add");
	 
		$("#fechaemision").val(fecha);
		
		$("#tipocomprobante").val("");
		   
		$("#codsustento").val("");
	   
	 	$("#serie").val("");
	   
		$("#secuencial").val("");
	   
		$("#autorizacion").val("");       
		
		$("#id_compras").val("");
		
		$("#idprov").val("");
		
		$("#razon").val("");
		
		$("#txtcuenta").val("");
		
		$("#cuenta").val("");
 
		
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
 
	 //----- LIMPIA 
	 var parametro = {
 			    'id_asiento' : 0 
     };
	  
  	$.ajax({
 			data:  parametro,
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
 
  //-------------------------------------------------------------------------  function BusquedaGrilla(oTable){      	  	  var idprove = $("#idprove_seleccione").val(); 					      BusquedaGrillaProv(oTable,idprove) ; 		   $('#Selec').show(); 		   		   $('#apagar').prop("readonly", true);		  		   $("#pago_tipo").val('S');	 	  } //------------------------------------------------------------------------- 
   //-------------------------------------------------------------------  function BusquedaGrillaProv(oTable,idprove){        	 	  	  var suma = 0;	  var total1 = 0;       var parametros = {   				'idprove' : idprove       }; 		$.ajax({		 	data:  parametros,		    url: '../grilla/grilla_te_cobro.php',			dataType: 'json',			cache: false,			success: function(s){		//	console.log(s); 			oTable.fnClearTable();			if(s){				for(var i = 0; i < s.length; i++) {					  oTable.fnAddData([	                      s[i][0],	                      s[i][1],	                      s[i][2],	                      s[i][3],	                      s[i][4],	                      s[i][5],	                     '<div align="right">' +  s[i][6] + '</div>', 	                     '<input type="checkbox" id="myCheck'+ s[i][0] +'"   onclick="myFunction('+ s[i][0] +',this)" '   + '>'     	                  ]);							   					  suma  =  s[i][6] ;					  total1 += parseFloat(suma) ;					  $("#totalPago").html('$ '+ total1.toFixed(2) );					  				} // End For 			}																	},			error: function(e){			   console.log(e.responseText);				}			});  	   }    

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
    

	 $("#ViewForm").load('../controller/Controller-te_cobro.php');
      

 }
 
 
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-te_cobro_filtro.php');
	 
 }
//----------------------
 
//----------------------
 function accion(idasiento,id,modo,comprobante)
 {
 
	    $("#id_asiento_aux").val(id); 
	    $("#id_asiento_ref").val(idasiento);	    	    
	    if ( idasiento > 0) {
	    	alert('Transaccion realizada con exito '  );
	    }	    $("#comprobante").val(comprobante);
  	    if ( modo == 'editar') {	    		    	  $("#action").val('aprobacion');	    	  	    }else {	    		    	  $("#action").val('editar');	    		    	  BusquedaGrilla(oTable);  	    	  	    	 	    }
 	   	
	 
 }
 
//---------------
 function NaN2Zero(n){
	    return isNaN( n ) ? 0 : n; 
	} 
//--------------------------------------------------- function myFunction(codigo,objeto) {  	   var idprove = $("#idprove_seleccione").val(); 	   var accion = 'check';	   var estado = '';	   	    if (objeto.checked == true){	    	estado = 'S'	        	    } else {	    	estado = 'N'	    }	    	    var parametros = {				'accion' : accion ,                'id' : codigo ,                'estado':estado,                                'idprove' : idprove	  };	          $.ajax({				data:  parametros,				url:   '../model/Model-te_cobro.php',				type:  'GET' ,				cache: false,				beforeSend: function () { 							$("#mensajeEstado").html('Procesando');					},				success:  function (data) {						 $("#mensajeEstado").html(data);   					     					} 		});   } //------------------ function PagoVarios() {	 	 $("#pago_tipo").val('S');	 	 $("#pago_valor").html(' ');	     	  var idprove = $("#idprove_seleccione").val();	    	  var nombre = $("#idprove_seleccione option:selected").text();  	 	  $('#mytabs a[href="#tab2"]').tab('show');	  	  var valor =  $("#mensajeEstado").html();    	  	  var total_amount_float = parseFloat(valor.replace(",", ".")).toFixed(2); 	   	  	  $("#detalle").val('Pago Efectuado: ');	  	  $("#action").val('aprobacion');	  	  var resultadoIVA = total_amount_float ;	   	  alert(resultadoIVA);	         $("#apagar").val(resultadoIVA);  	 	  $("#idprov").val(idprove);	  	  $("#beneficiario").val(nombre);	    } //-----------------------ValidaMonto function ValidaMonto(monto) {		 var monto_valida = $("#monto_valida").val();	 	 var var1 = parseInt(monto_valida).toFixed(2);	 	 var var2 = parseInt(monto).toFixed(2);	 	 var total  = var1 - var2;	  	 	 if ( total > 0 ) { 		 		 $("#pago_valor").html('Saldo : ' + total );		 	 }else {		 		  $("#apagar").val(monto_valida);		  		  $("#pago_valor").html('Execede a pagar...' + total );	 } 	  } ///------------------------------------- function open_pop_dato(url) {	 var ancho = 1080;	 var alto  = 490;	      var posicion_x;      var posicion_y;      var enlace;      posicion_x=(screen.width/2)-(ancho/2);      posicion_y=(screen.height/2)-(alto/2);      enlace = url  ;      window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');}