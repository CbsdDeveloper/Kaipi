/* Funciones JavaScript
   Version 1.1
   Autor: jasapas
   Tema: Formulario para cierre de cajas
*/

var oTable;
var oTableArticulo;
 //
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
//
$(document).ready(function(){
    
	 
 	
	   oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 2 ] },
  		      { "sClass": "di", "aTargets": [ 6 ] },
  		    ] 
       } );

		modulo();
			
		FormFiltro();
		
		FormView();
		
		$("#MHeader").load('../view/View-HeaderModel.php');
		$("#FormPie").load('../view/View-pie.php');
     
 
		
        $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
        
       
    
       
	         
});  
// 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion1,id) {
  
      var parametros = {
					'accion' : accion1 ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_cierre.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
 
    }
 //  
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
 
   
			var user = $(this).attr('id');
            
            var  estado		 = $("#estado1").val();
            var  cajero      = $("#cajero").val();
            var  fecha1      = $("#fecha1").val();
            var  cierre      = $("#cierre1").val();
   
         
            var parametros = {
					'estado' : estado , 
                    'cajero' : cajero  ,
                    'fecha1' : fecha1  ,
                    'cierre' : cierre
 	       };
            
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_cierre.php',
				dataType: 'json',
				success: function(s){
				//console.log(s); 
				        	oTable.fnClearTable();
				    	if(s ){  		
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
                                s[i][8],
								'<button title ="REVERSAR TITULO EMITIDO DE PAGO"    class="btn btn-xs btn-danger" onClick="goToURLDel('+"'del'"+','+ s[i][9] +')"><i class="glyphicon glyphicon-remove"></i></button> &nbsp;' +
								'<button title ="DESCARGAR IMPRIMIR TITULO DE PAGO"  class="btn btn-xs btn-info" onClick="goToURreporte('+s[i][10]+','+ s[i][9] +')">' +
							   '<i class="glyphicon glyphicon-download-alt"></i></button> &nbsp;'  +
							   '<button title ="EMITIR COMPROBANTES ELECTRONICOS"  data-toggle="modal" data-target="#myModalFac_view" class="btn btn-xs btn-success" onClick="goToLista('+ s[i][9] +')">' +
							   '<i class="icon-globe icon-white"></i></button> &nbsp;' +
							  ' <button title ="ACTUALIZAR DATOS..."  class="btn btn-xs btn-info" onClick="goToex('+ s[i][9] +')">' +
			 				   '<i class="icon-globe icon-white"></i></button> &nbsp;'
							]);										
						} // End For
			    	}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
			
			 // '<button title ="ACTUALIZAR DATOS..."  class="btn btn-xs btn-info" onClick="goToex('+ s[i][9] +')">' +
			//				   '<i class="icon-globe icon-white"></i></button> &nbsp;'

			VentasResumen();
			
			VentasResumenDet(); 
			
			VentaPagoFacturacion();
			
			$("#fecha").val(fecha1);
			
		   
	
 }   
 //-----------
 function goToLista(idpago)
{
 
	var estado1 =  $('#cierre1').val();

  	var parametros = {
			"idpago" : idpago  
	};
		
 	if ( estado1 == 'N') {

		$.ajax({
				url:   '../model/ajax_ren_visor_factura_id.php',
				data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#lista_datos").html('Procesando');
					},
				success:  function (data) {
						$("#lista_datos").html(data);   
						
					} 
		});
		
		$("#Resultado_facturae_id").html('');   
		

 	}
}
 //---------------
 function goToURreporte(id_par_ciu,variable){        
	
	 
 
	var url ='../../reportes/titulo_credito_cobro?tipo=51';
		
	 var posicion_x; 
	 var posicion_y; 
	 
		var enlace = url + '&codigo='+variable + '&id='+id_par_ciu  ;
	 
	 var ancho = 1000;
	 
	 var alto = 520;
	
		 
	 posicion_x=(screen.width/2)-(ancho/2); 
	 
	 posicion_y=(screen.height/2)-(alto/2); 
	 
	 window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');


}
 //------------
 function goToURLDel(accion1,id) {

 	var cierre = 	$("#cierre1").val();

	var parametros = {
				   'accion' : accion1 ,
				   'id' : id 
		};
	
	
	if ( cierre == 'N'){
	  
			alertify.confirm("Reversar Registro " +id , function (e) {
				if (e) {
					  $.ajax({
						  data:  parametros,
						  url:   '../model/Model-ren_cajas.php',
						  type:  'GET' ,
						  beforeSend: function () { 
								  $("#data").html('Procesando');
						  },
						  success:  function (data) {
									$("#data").html(data);  
								 
						  } 
				  }); 
			  }
		}); 	  	 
	}else{
				alert('No se puede Reversar este pago...');
	}

}
//------------------------- 
  function ActualizaFac(tipo)
  {
  	
  	var id_movimiento = $('#movi').val();
  	
  	var comprobante = $('#comprobantee').val();
  	var fecha       = $('#fechae').val();
  	var fechaa      = $('#fechaa').val();
  	
      var parametros = {
              'id'   : id_movimiento,
      	    'tipo' : tipo,
      	    'comprobante' : comprobante,
      	    'fecha' : fecha,
      	    'fechaa' : fechaa
       };
   	 
  	 
       alertify.confirm("Desea realizar actualizacion de la informacion?", function (e) {
  		  if (e) {
  			 
  			    
  				$.ajax({
  			 			url:   '../model/inv_cierre_datos.php',
  			 			data:  parametros,
  						type:  'GET' ,
  							beforeSend: function () { 
  									$("#VisorArticuloWebDato").html('Procesando');
  							},
  						success:  function (data) {
  								 $("#VisorArticuloWebDato").html(data);  // $("#cuenta").html(response);
  							     
  							} 
  				}); 

  				 
  		  }
  		 }); 
 

  } 
  //----------------------
  function goToURLve(id_movimiento)
  {
  	
  	
  	
  	
  	$('#movi').val(id_movimiento);
   
      var parametros = {
              'id' : id_movimiento
       };
      
  	$.ajax({
   			url:   '../controller/Controller-inv_cierre_fac.php',
   			data:  parametros,
  			type:  'GET' ,
  				beforeSend: function () { 
  						$("#VisorArticuloWeb").html('Procesando');
  				},
  			success:  function (data) {
  					 $("#VisorArticuloWeb").html(data);  // $("#cuenta").html(response);
  				     
  				} 
  	});
       

  }
 //---------------- 
 function goToex(idpago)
 {
	 
 
	 var parametros = {
			 'id' : idpago
	  };
	 
	 $.ajax({
			  url:   '../model/ajax_bomberos_prevencion.php',
			  data:  parametros,
			 type:  'GET' ,
				 beforeSend: function () { 
						 $("#result").html('Procesando');
				 },
			 success:  function (data) {
				 	alert(data);
					  
				 } 
	 });
	  

 }
function modulo()
{
 

	 var moduloOpcion =  'kservicios';
		 
	 var parametros = {
			    'ViewModulo' : moduloOpcion 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
			type:  'GET' ,
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
   
 	 $("#ViewForm").load('../controller/Controller-inv_cierre.php');

}  
//----------------------
function FormFiltro()
{
	  	 $("#ViewFiltro").load('../controller/Controller-inv_cierre_filtro.php');
 
 
}
/*
*/
function SeleccionCajero(caja){
 

	var fecha    	  = $('#fecha1').val();
	
	var parametros_caja = {
		"cajero" : caja,
		"fecha"   : fecha
	 };


	$.ajax({
		data: parametros_caja,
		url: "../model/ajax_caja_parte_dia.php",
		type: "GET",
		success: function(response)
		{
				$('#reporte_dato').html(response);
		}
});


}
//-------------------------------------------------------- 
function VentasResumenDet(){
	
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
	
	 
		var parametros = {
                 "fecha": fecha,
                 "cajero": cajero
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-resumenventasDet.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivDetalleMovimiento").html('Procesando');
				},
				success:  function (data) {
						 $("#DivDetalleMovimiento").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
 
  return true;
}
function VentasResumen( ) {
	 
	
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
	
	 
		var parametros = {
                 "fecha": fecha,
                 "cajero": cajero
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-resumenventas.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivMovimiento").html('Procesando');
				},
				success:  function (data) {
						 $("#DivMovimiento").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
			
		 
}	
//-----------------
function VentaPagoFacturacion( )
{
	
 
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
	
	 
		var parametros = {
                 "fecha": fecha,
                "cajero": cajero
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-resumenpago.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivDetallePago").html('Procesando');
				},
				success:  function (data) {
						 $("#DivDetallePago").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
 
}
//------------------ aprobacion
function aprobacion(  ){

	 

  var novedad = $('#novedad').val();	
  var fecha   = $('#fecha').val();	
  var cajero   = $('#cajero').val();	

  var parametros_caja = {
	"cajero" : cajero,
	"fecha"   : fecha
 };
  
  var mensaje =  confirm("Desea aprobar la transaccion?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"novedad" : novedad,
	 			"fecha"   : fecha,
				 "cajero" : cajero,
	 			"accion" : 'aprobacion'
		};
		
		
			
				$.ajax({
			 			 url:   '../model/Model-ren_cierre.php',
			 			data:  parametros,
						type:  'GET' ,
							beforeSend: function () { 
									$("#result").html('Procesando');
							},
						success:  function (data) {
								 $("#result").html(data);  

 									$.ajax({
											data: parametros_caja,
											url: "../model/ajax_caja_parte.php",
											type: "GET",
											success: function(response)
											{
													$('#reporte_dato').html(response);
											}
									});
							     
							} 
				});
 
	 
  }
 
 
}
//-------------------
function impresion(url){        
	
	var variable    = $('#id_movimiento').val();
   
    var posicion_x; 
    var posicion_y; 
    var enlace = url + variable
    var ancho = 1000;
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------------
function url_comprobante(url){        
	
	var variable    = $('#id_movimiento').val();
	
	
 	
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '&codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------------
function ImpresionParte(parte){        
	
	var fecha    	  = $('#fecha1').val();
 	var cajero 		  = $('#cajero').val();
 	
 
	 if ( parte == '-'){
 
	}else {
			var posicion_x; 
			var posicion_y; 
			
			var enlace =   '../../reportes/reporteCierreCaja.php?&fecha='+fecha+ '&cajero='+ cajero + '&parte='+ parte;
			
			var ancho = 1000;
			
			var alto = 520;
			
			posicion_x=(screen.width/2)-(ancho/2); 
			
			posicion_y=(screen.height/2)-(alto/2); 
			
			window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
		}
}


