var oTable;

var formulario = 'inv_saldos';
/*
Deshabilitar tecla enter
*/
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});
/*
Inicio de variables 
*/
$(document).ready(function(){


	modulo();
 	     
	FormFiltro();
	
	fecha_hoy();

	
	 oTable =  $('#jsontable').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 6] },
		      { "sClass": "ya", "aTargets": [ 7 ] },
		      { "sClass": "ye", "aTargets": [ 8 ] }
		    ] ,
		    "language":  [ {
	            "decimal": ",",
	            "thousands": "."
	           }
		    ] 
       } 
     );
  	 
	
   		
	    $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
		});

		$('#loadposi').on('click',function(){
	 		   
			BusquedaGrillaS(oTable);
			  
	});

		$('#printButton1').on('click',function(){
 
			var printContents = document.getElementById('impresionk').innerHTML;
			
				    var estilo = '<style>.tabla{width:100%;border-collapse:collapse;margin:16px 0 16px 0;}.tabla th{border:1px solid #ddd;padding:4px;background-color:#d4eefd;text-align:left;font-size:15px;}.tabla td{border:1px solid #ddd;text-align:left;padding:6px;}</style>';
			
					w = window.open();
					w.document.write(estilo + printContents);
					w.document.close(); // necessary for IE >= 10
					w.focus(); // necessary for IE >= 10
					w.print();
					w.close();
        
		});
	
 
	 
	    var j = jQuery.noConflict();
 
		j("#printButton").click(function(){

				var mode = 'iframe'; //popup

				var close = mode == "popup";

				var options = { mode : mode, popClose : close};

			  j("#ViewFicha").printArea( options );

			});
	
	
	   
	
		  
		   $('#loadxls').on('click',function(){
	  	  
			var idbodega 			= $("#idbodega1").val();

		    var page = "../../reportes/excel_saldos.php?id="+idbodega;  
	      
		     window.location = page;  
  			
	    	});
	
	
	
		   $('#loadxls1').on('click',function(){
	  	  
			var idbodega 			= $("#idbodega1").val();

		    var page = "../../reportes/excel_saldosd.php?id="+idbodega;  
	      
		     window.location = page;  
  			
	    	});
		   
		   
		   $('#loadxls_matriz').on('click',function(){
			  	  
				  
			    var page = "../../reportes/excel_saldos1.php";  
		      
			     window.location = page;  
	  			
		    	});
		   
		   
		   $('#loadKardex').on('click',function(){
			  	  
			   kardex_item();
			   
		    });
 
		    $('#saldos_costos').on('click',function(){
		 		   
	            Costos();
	  			
		});

		    
		    $('#loadxls_cero').on('click',function(){
			  	  
				  
			    var page = "../../reportes/excel_saldos0.php";  
		      
			     window.location = page;  
	  			
		    	});
		    
		    
	       $('#loadSaldo').on('click',function(){
	  	  
	  
					   $.ajax({
 						 url:   '../model/Model-saldo_bodega.php',
						type:  'POST' ,
						cache: false,
						beforeSend: function () { 
									$("#SaldoBodega").html('Procesando');
							},
						success:  function (data) {
								 $("#SaldoBodega").html(data); 

							} 
				});
  			
	    	});
 

		   $("#MHeader").load('../view/View-HeaderModel.php');
	
		   $("#FormPie").load('../view/View-pie.php');
		   
		   $("#ViewForm").load('../controller/Controller-inv_saldos.php');
	
}); 
/*
parametros para csetae
*/
function formatNumber(num1) {

	total2 = parseFloat(num1) ;
	var num  = total2.toFixed(2); 

    if (!num || num == 'NaN') return '-';
    if (num == 'Infinity') return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + ',' + cents);
}
/*
verifica los costos por bodega
*/
function Costos( ) {
	 
	 var i = 0 ;
	 
	 alert('Actualizando Costos');
	 
	 $('#jsontable tr').each(function() { 
 		 
		   var id = $(this).find("td").eq(0).html();  
		
		   if (  i >   0  ) { 
				 var parametrosf = {
			    					'id' : id 
  				 };

				$.ajax({
						data:  parametrosf,
						url:   '../model/_saldos.php',
						type:  'GET' ,
						success:  function (data) {
							
							$("#SaldoBodega").html(data + ' ' + id); 
							
							} 
				});
			    	   
		   }
		   i = i + 1;
    }); 
}
/*
verifica los costos por bodega por articulo
*/ 
function verificar_costo( id,prod,costo,cantidad) {
 
  	$("#prod").val(id);
  	$("#mov").val(prod);
  	$("#cantidad").val(cantidad);
  	$("#costo").val(costo);          		         
	$('#myModal').modal('show');
		
 }
/*
Actualiza Montos
*/ 
function Actualizar_monto(  ) {
 
  var prod 			= $("#prod").val();
  var mov 			= $("#mov").val();
  var cantidad 		= $("#cantidad").val();
  var costo 		= $("#costo").val();     

	 var parametros = {
	            'prod' : prod,  
				'mov':mov,
				'cantidad' : cantidad,
				'costo':costo
 	    };
	   
   if (costo > 0)  {
		$.ajax({
			    url:  '../model/ajax_costo_egreso.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormres").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormres").html(data);   
						 goToURL_a( prod );
					} 
		});
	    
	   	$('#myModal').modal('hide');
  }
 }
/*
envia los datos para dibujar el historial del articulo
*/ 
function goToURL_a( id) {
 
	 var parametros = {
	            'id' : id,  
 	    };
	    
		$.ajax({
			    url:  '../controller/Controller-inv_saldos_ka.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewForm").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewForm").html(data);   
 					} 
		});
	    
   
 }
/*
envia los datos para dibujar el historial del articulo
*/ 
function goToURL( id) {
 
	 var parametros = {
	            'id' : id,  
 	    };
	    
		$.ajax({
			    url:  '../controller/Controller-inv_saldos_ka.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewForm").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewForm").html(data);   
						 activaTab();
					} 
		});
	    
	    $("#itemkardex").val(id);
  
 }
/*
envia los datos para dibujar el historial del articulo
*/ 
function kardex_item(  ) {
	 
	
	var iditem =   $("#itemkardex").val();
	var fecha1 =    $("#fecha1").val();
	var fecha2 =   $("#fecha2").val();
    
 
	  var parametros = {
	            'iditem' : iditem,  
	            'fecha1' : fecha1,
	            'fecha2' : fecha2
	    };
	    
		$.ajax({
			    url:  '../controller/Controller-inv_saldos_kardex.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewKardex").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewKardex").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	    		
}
/*
envia los datos para dibujar el historial del articulo
*/  
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
    
    var today1 = yyyy + '-' + '01' + '-' + '01';
    
    $("#fecha1").val(today1);
    
    $("#fecha2").val(today);
      
} 
/*
envia los datos para dibujar el historial del articulo
*/ 
  function BusquedaGrilla(oTable){        	 
 
	  
   	var tipo 				= $("#tipo").val();
   	var facturacion 		= $("#facturacion").val();
 	var idmarca 			= $("#idmarca").val();
 	var idcategoria 		= $("#idcategoria").val();
 	var nivel 				= $("#nivel").val();
 	var idbodega 			= $("#idbodega1").val();
	var nombre_producto 	= $("#nombre_producto").val();
 	var codigog 			= $("#codigog").val();
	
    
    var parametros = {
				'tipo' : tipo,  
				'facturacion' : facturacion,
				'idmarca': idmarca,
				'codigog' : codigog,
				'idcategoria' : idcategoria,  
				'nivel' : nivel,  
				'nombre_producto':nombre_producto,
				'idbodega':idbodega
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
 			oTable.fnClearTable();
			if(s ){ 
					for(var i = 0; i < s.length; i++) {
						 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
								s[i][3],
								s[i][4],
								'<div align="right">' + s[i][5]  + '</div>',
								'<div align="right">' + formatNumber(s[i][6]) + '</div>',
								'<div align="right">' + formatNumber(s[i][7]) + '</div>',
								'<div align="right">' + formatNumber(s[i][8]) + '</div>',
 							'<button class="btn btn-xs" onClick="javascript:goToURL(' + s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
						]);		
						 
						 
					} // End For
			} 					
			} 
	 	});
 		
 }   
 
 function BusquedaGrillaS(oTable){        	 
 
	  
	var tipo 				= $("#tipo").val();
	var facturacion 		= $("#facturacion").val();
  var idmarca 			= $("#idmarca").val();
  var idcategoria 		= $("#idcategoria").val();
  var nivel 				= $("#nivel").val();
  var idbodega 			= $("#idbodega1").val();
 var nombre_producto 	= $("#nombre_producto").val();
  var codigog 			= $("#codigog").val();
 
 
 var parametros = {
			 'tipo' : tipo,  
			 'facturacion' : facturacion,
			 'idmarca': idmarca,
			 'codigog' : codigog,
			 'idcategoria' : idcategoria,  
			 'nivel' : nivel,  
			 'nombre_producto':nombre_producto,
			 'idbodega':idbodega
 };

	 $.ajax({
		  data:  parametros,
		  url: '../grilla/grilla_inv_saldos_p.php' ,
		 dataType: 'json',
		 cache: false,
		 success: function(s){
		  oTable.fnClearTable();
		 if(s ){ 
				 for(var i = 0; i < s.length; i++) {
					  oTable.fnAddData([
							 s[i][0],
							 s[i][1],
							 s[i][2],
							 s[i][3],
							 s[i][4],
							 '<div align="right">' + s[i][5]  + '</div>',
							 '<div align="right">' + formatNumber(s[i][6]) + '</div>',
							 '<div align="right">' + formatNumber(s[i][7]) + '</div>',
							 '<div align="right">' + formatNumber(s[i][8]) + '</div>',
						  '<button class="btn btn-xs" onClick="javascript:goToURL(' + s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
					 ]);		
					  
					  
				 } // End For
		 } 					
		 } 
	  });
	  
}   
/*
Dibuja menu, funcion general para colocar el menu lateral
*/  
function modulo()
 {
 	 var modulo1 =  'kinventario';
 	 
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
/*
Dibuja menu, funcion general para colocar el menu lateral
*/  
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');
	 

 }