 /*
 
 Emision de comprobantes electronicos

 */
//--------------------------
// EMITE COMPROBANTE DE RETENCION PRIMERA VEZ 
function _Generar_factura( ) {
		
 
   var id 			 =  $('#emision_iva').val()  ;
	 
   var id_renpago    =  $('#id_renpago').val()  ;

   var parametros = {
	'id' : id 
	};

	
	   
	if ( id_renpago  > 0 ) {
				if ( id > 0 ) {
					
							alert('Genera Comprobante Eletronico');
									
							$.ajax({
									data:  parametros,
									url:   '../../facturae/_crearXMLFactura.php',
									type:  'GET' ,
									beforeSend: function () { 
										$("#Resultado_facturae").html('<img src="loader.gif"/>');
									},
									success:  function ( data ) {
												
											$("#Resultado_facturae").html(data);

										}
								, complete : function(){
										
										firma_auto( id );
						
								}  
							});
			
				}
	 	}else{
			alert('Debe guardar la transaccion... para emitir el comprobante electronico...');
	    }
}
//------------------------------
function _Generar_factura_id( id_renpago,emision_iva) {
		
  	  
 
	$('#emision_iva').val(emision_iva)  ;
 
	var parametros = {
	 'id' : emision_iva 
	 };
 
		
	 if ( id_renpago  > 0 ) {

				 if ( emision_iva > 0 ) {
					 
							 alert('Genera Comprobante Eletronico');
									 
							 $.ajax({
									 data:  parametros,
									 url:   '../../facturae/_crearXMLFactura.php',
									 type:  'GET' ,
									 beforeSend: function () { 
										 $("#Resultado_facturae").html('<img src="loader.gif"/>');
									 },
									 success:  function ( data ) {
												 
											 $("#Resultado_facturae_id").html(data);
 
										 }
								 , complete : function(){
										 
										 firma_auto_id( emision_iva );
						 
								 }  
							 });
			 
				 }
		  }else{
			 alert('Debe guardar la transaccion... para emitir el comprobante electronico...');
		 }
 }
//--------
function _Imprimir_factura( ) {

	 var id  =  $('#emision_iva').val()  ;
 	 
     var ancho = 650;

	 var alto  = 350;


			if ( id > 0 ) {
									
				var url = '../../facturae/_factura_electronica.php';
						
				posicion_x=(screen.width/2)-(ancho/2); 
				
				posicion_y=(screen.height/2)-(alto/2); 
				
				enlace = url + '?id='+ id;
				
				window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

		}	 

}
/*
*/
function _Imprimir_factura_id( id  ) {

 
	 
	var ancho = 650;

	var alto  = 350;


		   if ( id > 0 ) {
								   
			   var url = '../../facturae/_factura_electronica.php';
					   
			   posicion_x=(screen.width/2)-(ancho/2); 
			   
			   posicion_y=(screen.height/2)-(alto/2); 
			   
			   enlace = url + '?id='+ id;
			   
			   window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

	   }	 

}
//---------------
function firma_auto( id ) {
  	 
	var parametrosf = {
			 'id' : id 
   };
 
  
   var url =  '../../facturae/_autoriza_factura.php';
	 
 	 
	$.ajax({
		 data:  parametrosf,
		 url:   url,
		 type:  'GET' ,
		 beforeSend: function () { 
			 
 			 $("#Resultado_facturae").html('<img src="loader.gif"/>');
	 },
	 
		 success:  function (data) {
		 
			 $("#Resultado_facturae").html(data);  
			 
 				  
			 } 
 });

}
///---------
function firma_auto_id( id ) {
  	 
	var parametrosf = {
			 'id' : id 
   };
 
  
   var url =  '../../facturae/_autoriza_factura.php';
	 
 	 
	$.ajax({
		 data:  parametrosf,
		 url:   url,
		 type:  'GET' ,
		 beforeSend: function () { 
			 
 			 $("#Resultado_facturae_id").html('<img src="loader.gif"/>');
	 },
	 
		 success:  function (data) {
		 
			 $("#Resultado_facturae_id").html(data);  
			 
 				  
			 } 
 });

}

//-----------
function _elimina_factura_id( id ) {
  	 
	var parametrosf = {
			 'id' : id 
   };
 
  
	alertify.confirm("Desea eliminar la autorizacion del comprobnate electronico?.... debe anular en el sri para generar nuevamente... " +id , function (e) {
		if (e) {
			$.ajax({
				data:  parametrosf,
				url:   '../model/ajax_factura_revertir.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#Resultado_facturae_id").html('Procesando');
				},
				success:  function (data) {
							$("#Resultado_facturae_id").html(data);  
						
				} 
		}); 
	}
	}); 

 	 
 

}