function _genera_comprobante( codigo) {
		
 
    var id_asiento    = $('#id_compras').val(); 
	 
     

    var parametros = {
     'id_asiento' : id_asiento 
     };
 
 

           if ( id_asiento > 0 ) {
                     
                             alert('Genera Comprobante Eletronico');
                                     
                             $.ajax({
                                     data:  parametros,
                                     url:   '../../facturae/_crearXMLComprobante.php',
                                     type:  'GET' ,
                                     beforeSend: function () { 
                                         $("#data").html('<img src="loader.gif"/>');
                                     },
                                     success:  function ( data ) {
                                                 
                                             $("#data").html(data);
 
                                         }
                                 , complete : function(){
                                         
                                        firma_auto( id_asiento );
                         
                                 }  
                             });
            
          }else{
             alert('Debe guardar la transaccion... para emitir el comprobante electronico...');
         }
 }
 //-----------
 //---------------
function firma_auto( id ) {
  	 
	var parametrosf = {
			 'id' : id 
   };
 
  
   var url =  '../../facturae/_autoriza_comprobante.php';
	 
 	 
	$.ajax({
		 data:  parametrosf,
		 url:   url,
		 type:  'GET' ,
		 beforeSend: function () { 
			 
 			 $("#data").html('<img src="loader.gif"/>');
	 },
	 
		 success:  function (data) {
		 
			 $("#data").html(data);  
			 
 				  
			 } 
 });

}
/*
*/
function _ImprimirRetencion(  ) {


	 
    var posicion_x; 
    var posicion_y; 
    var enlace; 
    var ancho = 720; 
    var alto = 550; 
  
    var id  =   $('#id_compras').val();
	
    var parametrosf = {
        'id' : id 
    };

 

    if ( id > 0 ) {
		
 
        $.ajax({
            data:  parametrosf,
            url:   '../model/ajax_actualiza_agrupa.php',
            type:  'GET' ,
             success:  function (data) {
                 $("#result").html(data);  
                 } 
       });

		
    
		      var url = '../../facturae/_comprobante_electronico_tributa.php';
		     			
		      posicion_x=(screen.width/2)-(ancho/2); 
		      
		      posicion_y=(screen.height/2)-(alto/2); 
		      
		      enlace = url + '?id='+ id;
		      
		      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

    
    }
 

}
//----------------
