 
var formulario = 'comprasc'; 

 
//------------------------------------------------------------------------- 
$(document).ready(function(){
    
       

       var codigo = getParameterByName('codigo');
 		
	    FormView(codigo);
	    
	   
 	   
 		$('#loadSri').on('click',function(){
  		   
            openFile('../../upload/uploadxml?file=1',650,300)
  			
		});
	
	
	   
 
});  
/**
 * @param String name
 * @return String
 */
 function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
					
			  		$("#action").val("add");
					
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

function accion(id,modo)
{
 
  
			$("#action").val(modo);
			
			$("#id_compras").val(id);          

			DetalleAsientoIR();

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accionDato,id) {

	
 
	
	var parametros = {
					'accion' : accionDato ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-'+formulario,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
							 DetalleAsientoIR();
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
	
	$("#id_compras").val("0");
	$("#codsustento").val("01");
	 
	
	$("#tipocomprobante").val("01");
	$("#fecharegistro").val(fecha);
	 
	$("#serie").val("001001");
	
	$("#secuencial").val("");
	$("#fechaemision").val(fecha);
	$("#autorizacion").val("");

	$("#bservicios").val(0);
	$("#bbienes").val(0);
	
 
	
	$("#basenograiva").val(0);
	$("#baseimponible").val(0);
	$("#baseimpgrav").val(0);
	$("#montoice").val(0);
	$("#montoiva").val(0);
	$("#valorretbienes").val(0);
	$("#valorretservicios").val(0);
	$("#valretserv100").val(0);
	$
	$("#porcentaje_iva").val(0);
	$("#baseimpair").val(0);
	
	$("#pagolocext").val("01");
	$("#paisefecpago").val("NA");
	$("#faplicconvdobtrib").val("NA");
	$("#fpagextsujretnorLeg").val("NA");
	
	$("#formadepago").val("01");
	$("#fechaemiret1").val(fecha);
	$("#serie1").val("001001");
	$("#secretencion1").val("");
	$("#autretencion1").val("");
	
	$("#docmodificado").val("");
	$("#secmodificado").val("");
	$("#estabmodificado").val("");
	$("#autmodificado").val("");
	$("#fpagextsujretnorleg").val("");   
	

	DetalleAsientoIR();


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
    
   return today;
            
} 
  
//-----------------
 function FormView(codigo)
 {
    

	 $("#ViewForm").load('../../ktributacion/controller/Controller-compras_asiento.php?codigo='+codigo );
      

 }
//---------------base_ir 
 function base_ir(valor,tipo ){

	 

	  var base12  	=  NaN2Zero ( $('#baseimpgrav').val() ) ; 


	  var base0		=  NaN2Zero ( $('#baseimponible').val() ) ; 


	  var baseNo	=  NaN2Zero ( $('#basenograiva').val() ) ; 


	  


	  if (tipo == 1){


		    base0		= valor ; 


 	  }


	  if (tipo == 2){


		  baseNo		= valor ; 


	  }


	  


	  var totalBase 	= parseFloat(base12)  + 


	  					  parseFloat(base0)   + 


	  					  parseFloat(baseNo)  ;


	  


	  var flotante = parseFloat(totalBase).toFixed(2)  ;


	  


	  $('#baseimpair').val(flotante)





}
 
 //------------------------
 function monto_iva(valor_base){
	 
 
	  var flotante = parseFloat(valor_base)    * (12/100);
	  
	  if (valor_base > 0){
		  
		  $('#montoiva').val(flotante.toFixed(2));
		  
		  $('#bservicios').val(flotante.toFixed(2));
		  
	  }else{
 		
		  $('#montoiva').val(0); 
 	  
	  }
	
	  var base12  	=  valor_base  ; 
	  var base0		=  $('baseimponible').val()  ; 
	  var baseNo	=  $('basenograiva').val() ; 
	 
	  var totalBase 	= parseFloat(base12).toFixed(2)  + parseFloat(base0).toFixed(2)  + parseFloat(baseNo).toFixed(2);
	  
	  
	  flotante = parseFloat(totalBase).toFixed(2)  ;
	  
	  $('#baseimpair').val(flotante);
 
}
//-----------------------
function ActualizaRuc(  ) {

	$("#myModalCIU").modal('show'); 

	var idprov = $('#idprov').val();

	$('#usr').val(idprov);
	
	

}	
 //-------------------
 function EnviarRetencion(  ) {

	 
	  
	    var id  =   $('#id_compras').val();

	    var parametros = {
	              'id' : id 
		};
	   
	 
	   $.ajax({
			data:  parametros,
			 url:   '../model/EnvioEmailComprobante.php',
			type:  'GET' ,
			success:  function (response) {
				 
				   $("#FacturaElectronica").html(response); 
				
					alert('Enviado');
					
				} 
	});  

		       

	}
 //--------------------------------------------------
 function AnularRetencion(  ) {

	 
	  
	    var id  =   $('#id_compras').val();

 
	 
		  alertify.confirm("<p>Desea Anular la Factura y Retencion</p>", function (e) {
			  if (e) {
 
					var parametros = {
							'accion' : 'anular' ,
		                    'id' : id 
		 	  };
			  $.ajax({
							data:  parametros,
							url:   '../model/Model-'+formulario,
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
		 							$("#result").html('Procesando');
		  					},
							success:  function (data) {
									 $("#result").html(data);  // $("#cuenta").html(response);
								     
		  					} 
					}); 
					
                    LimpiarPantalla();
                    
			  }
			 });   
	    
	  
		       

	}
//----------------------------------
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
//---------------
 function NaN2Zero(n){
	    return isNaN( n ) ? 0 : n; 
	}
//---------------
 function monto_riva(tipo_retencion){
	
	  var monto_iva      =  $('#bservicios').val(); 
	  var ivas           = parseFloat(monto_iva).toFixed(2)  ;
	  
	  var monto_iva_real =  $('#montoiva').val(); 
	  var iva            = parseFloat(monto_iva_real).toFixed(2)  ;
	  
	  var diferencia = iva - ivas;
	  
	  if ( monto_iva == monto_iva_real){
		  $('#bbienes').val(0); 
	  }else{
		  
		  $('#bbienes').val(diferencia); 
	  }
	  
	  
 
	  var iva = 0;
	  var flotante = 0 ;
	 
	  if (tipo_retencion == 0){
		  
		  $('#valorretservicios').val(0);
		  $('#valretserv100').val(0);
		  $('#bservicios').val(0); 
		  $('#bbienes').val(monto_iva_real); 
		  
 		  }
  
	//-------------------
	  if (tipo_retencion == 2){
		  iva = monto_iva * (70/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretservicios').val(flotante);
		  $('#valretserv100').val(0);
 		  } 
	//-------------------
	  if (tipo_retencion == 3){
		  iva = monto_iva * (100/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretservicios').val(0);
		  $('#valretserv100').val(flotante);
 		  }  
 
	  if (tipo_retencion == 11){
		  iva = monto_iva * (50/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretservicios').val(flotante);
		  $('#valretserv100').val(0);
 		  }  
		//-------------------
	  if (tipo_retencion == 10){
		  iva = monto_iva * (20/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
 		  $('#valorretservicios').val(flotante);
		  $('#valretserv100').val(0);
 		  } 	  
}
//-------------------
 function monto_rivab(tipo_retencion){
		
	 
 	  var iva 				 = 0;
	  var flotante 			 = 0 ;
	  var servicios 		 = $('#bservicios').val();
	  var monto_iva_servicio = parseFloat(servicios).toFixed(2)  ;
	  
	  var  monto_iva1 		 =  $('#bbienes').val(); 
	  var  monto_iva2 		 = parseFloat(monto_iva1).toFixed(2)  ;
	 
	  if (tipo_retencion == 0){
		  $('#valorretbienes').val(0);
 		  }
	 //-------------------
	 if ( monto_iva_servicio >  0){
		 
		 monto_iva = monto_iva1; 
		 
	 }else {
		 
		 monto_iva =  monto_iva2; 
	 
	 }
	 
	  if (tipo_retencion == 1){
		  iva = monto_iva * (30/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(flotante);
 		  }
  
	//-------------------
	  if (tipo_retencion == 9){
		  iva = monto_iva * (10/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(flotante);
 		  }  
		//-------------------
	  if (tipo_retencion == 10){
		  iva = monto_iva * (20/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(0);
 		  } 	  
}
//---------------
function factura_codigo(n){
	
	 
	 var secuencial =  parseFloat( $('#secuencial').val()  )
	
	 var h =('00000000' + secuencial).slice (-9);
	 
	 $('#secuencial').val(h);
	 
	 
	 
	}

//------------------------------------------------------------------------- .
//-------------------
function calculoFuente(codigoAux)
{
	 
	var baseimpair =  $('#baseimpair').val();
	 

	 var parametros = {
			    'codigoAux' : codigoAux ,
			    'baseimpair': baseimpair
  };
	 
	 if (baseimpair){
	 
		$.ajax({
				data:  parametros,
				 url:   '../model/ajax_FuenteCalculo.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
							$("#retencion_fuente").html('Procesando');
					},
				success:  function (data) {
						 $("#retencion_fuente").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	 }
}
//------------------------------------------------------------------------- 
function DetalleAsientoIR()
{
	  

	  var id_compras = $('#id_compras').val(); 
	  
	  var parametros = {
			    'id_compras' : id_compras 
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
//-----------presupuesto_tramite
function BuscaTramite()
{
	
	
     var idprov = $('#idprov').val(); 
	  
	  var parametros = {
			    'idprov' : idprov 
 };
 
	  
	$.ajax({
		data:  parametros,
 			 url:   '../model/ajax_tramiteAnexo.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#presupuesto_tramite").html('Procesando');
				},
			success:  function (data) {
					 $("#presupuesto_tramite").html(data);   
				     
				} 
	});

}
//--------------------------
function deltramite(accion,codigo,fila){
	
 
	 var id ;
	 var id1;
	 var id2 ;
	  	 
	      id  =  document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[0].innerHTML;
		  id1 = document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[2].innerHTML;
		  id2 = document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[4].innerHTML;
	        
		    $("#id_tramite").val(id);   
 		    $("#unidad").val(id1);   
		    
		    var str 	= id2;
		    var cadena  = str.trim();
		    var tope 	= cadena.length;
		    
		    if ( tope < 150 ){
		    	   $("#detalle").val(cadena);   
		    }
		    
		 
		    
		    
		    $("#myModal").modal('hide');//ocultamos el modal
		 
};
//------------------------------------
function openFile(url,ancho,alto) {
    
	  var posicion_x; 
  var posicion_y; 
  var enlace; 
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
 
  
  enlace = url  ;

  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}

/*
*/
function ActualizaProveedor() {
    
	  var idprov     =  $('#usr').val();  
	  var razon      =  $('#razon').val();  
	  var id_compras =  $('#id_compras').val();  
	  
  	  if (idprov) {
  	
	   var parametros = {
		 			    'idprov' : idprov,
						 'razon' : razon,
						 'id_compras' : id_compras
		     };
			  
		  	$.ajax({
		 			data:  parametros,
		 			 url:   '../model/ajax_CambioProv.php',
		 			type:  'GET' ,
		 			cache: false,
		 			success:  function (data) {
		 					 alert(data);
		 				} 
		 	});
		  	
  	 }

 }
//-----------------

function ComprobanteActualiza( retencion,autorizacion,fechap) {
 
	 	 $('#secretencion1').val(retencion); 

		 $('#autretencion1').val(autorizacion); 

		 $('#fechaemiret1').val(fechap); 

 

}
