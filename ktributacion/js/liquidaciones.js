var oTable; 
var formulario = 'liquidaciones'; 

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
 
 	   
 		$('#loadSri').on('click',function(){
  		   
            openFile('../../upload/uploadxml?file=1',650,300)
  			
		});
	
	
	   $('#loadxls').on('click',function(){

	  	  var canio = $("#canio").val();

		  var cmes = $("#cmes").val();

		  

		  var cadena = 'canio='+canio+'&cmes='+cmes;

		  var page = "../reportes/excelCompras.php?"+cadena;  

	      

		  window.location = page;  

  			

		});
 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
					
			  		$("#action").val("add");
					
                    LimpiarPantalla();
                    
                    Detalle_liquidacion(-2);
                    
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
			
			$("#id_liquida").val(id);          

			 

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
					url:   '../model/Model_'+formulario,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
						     Detalle_liquidacion(id);
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
	
	
	$("#id_liquida").val("");
	$("#idprov").val("");
	$("#tipocomprobante").val("");
	
	$("#detalle_d").val("");
	
	
	$("#fecharegistro").val(fecha);
	$("#secuencial").val("-");
	$("#fechaemision").val(fecha);
	$("#autorizacion").val("");
	$("#baseimponible").val("0.00");
	$("#baseimpgrav").val("0.00");
	
	$("#montoiva").val("0.00");
 	
	$("#formadepago").val("01");
  
	$("#serie").val("001001");

	$("#iva_si").val("-");
	
	
	$("#cantidad").val("1");
	$("#servicios").val("0.00");
	   

	$("#detalle").val("Referencia");   
	
	$("#razon").val("");   
	
	$("#transaccion").val("N");   

	

    }
 //------------
 
 
function ImprimirRetencion(  ) {


 	 
    var posicion_x; 
    var posicion_y; 
    var enlace; 
    var ancho = 720; 
    var alto = 550; 
  
    var id  =   $('#id_liquida').val();

    if ( id > 0 ) {
    
		      var url = '../../facturae/liquidacion_electronico.php';
		     			
		      posicion_x=(screen.width/2)-(ancho/2); 
		      
		      posicion_y=(screen.height/2)-(alto/2); 
		      
		      enlace = url + '?id='+ id;
		      
		      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

    
    }
 

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
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
		var user = $(this).attr('id');
		
     	var anio 	 = $("#canio").val();
    	var mes 	 = $("#cmes").val();
    	var cnombre  = $("#cnombre").val();
    	
          
      var parametros = {
				'anio' : anio  ,
				'mes' : mes  ,
				'cnombre':cnombre
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_liquidaciones.php'    ,
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
							'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][7] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][7] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			}				
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
 
 		$("#cnombre").val('');
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 
 function modulo()
 {
 	 var modulo =  'ktributacion';
 	 
 	 var parametros = {
			    'ViewModulo' : modulo 
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
    

	 $("#ViewForm").load('../controller/Controller_liquidaciones.php'   );
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller_' + formulario + '_filtro.php');
	 

 }
 //------------------------
 function monto_iva(valor_base){
	 
 
	  var flotante = parseFloat(valor_base)    * (12/100);
	  
	  if (valor_base > 0){
		  
		  $('#montoiva').val(flotante.toFixed(2));
 	  
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
    
//---------------
 function NaN2Zero(n){
	    return isNaN( n ) ? 0 : n; 
	}
//---------------
 function Detalle_liquidacion(id_liquida){
	
	   	  
  	 
	 
	  
	 var parametros = {
				'accion' :'visor',
			    'id_liquida' : id_liquida 		 
  };
	  
	$.ajax({
						data:  parametros,
						 url:   '../model/ajax_liquidacion_d.php',
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
//-------------------
//---------------
function factura_codigo(n){
	
	 
	 var secuencial =  parseFloat( $('#secuencial').val()  )
	
	var h =('00000000' + secuencial).slice (-9);
	 
	 $('#secuencial').val(h);
	 
	 
	 
	}

//------------------------------------------------------------------------- .
//-------------------
function Agrega_detalle(tipo )
{
	 

	var id_liquida =  $('#id_liquida').val();
	 
	 var cantidad  =  $('#cantidad').val();
	 var servicios =  $('#servicios').val();
	 
	 var detalle_d =  $('#detalle_d').val();
	 var bandera = 1;
	 
	 
	 if (tipo == '-') {
		bandera = 0;
	}
	 
	   
	  

	 var parametros = {
				'accion' : 'add',
			    'id_liquida' : id_liquida ,
			    'tipo': tipo,
			    'cantidad': cantidad,
			    'servicios':servicios,
			    'detalle_d':detalle_d
  };
	 
	 if ( detalle_d ){
			 if (servicios > 0 ){
			 
			 		if ( bandera == 1 ){ 
						$.ajax({
								data:  parametros,
								 url:   '../model/ajax_liquidacion_d.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
											$("#retencion_fuente").html('Procesando');
									},
								success:  function (data) {
									
										 $("#retencion_fuente").html(data);   
									     $('#cantidad').val('1');
									     $('#servicios').val('0.00');
									     $('#detalle_d').val('');
		 
									} 
						});
					 }	
			 }
	}		 
}
//------------------------------------------------------------------------- 
function Modifica_dliquida(accion,codigo)
{
	  
var id_liquida =  $('#id_liquida').val();
var transaccion =  $('#transaccion').val();	 
	 
	 
	  
	 var parametros = {
				'accion' :accion,
			    'id_liquida' : id_liquida ,
			    'codigo': codigo ,
			    'transaccion':transaccion
  };
	  
	$.ajax({
						data:  parametros,
						 url:   '../model/ajax_liquidacion_d.php',
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
//-----------
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
//--
function goToURLAsiento(valor) {
    
	
	  var id_compras =  $('#id_compras').val(); 
	  
	  var id_asiento =  $('#id_asiento').val(); 
	  
	  var idprov =  $('#idprov').val();  
	  
	  var secuencial =  $('#secuencial').val();  
	  
	  
	  
  	  if (id_compras) {
  		 
  	
	   var parametros = {
		 			    'id_compras' : id_compras  ,
		 			    'id_asiento': id_asiento,
		 			    'idprov' : idprov,
		 			    'secuencial': secuencial
		     };
			  
		  	$.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-enlace_asientos.php',
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

 }
//-----------------

function ComprobanteActualiza( retencion,autorizacion,fechap) {

	

	 	 $('#secretencion1').val(retencion); 

		 $('#autretencion1').val(autorizacion); 

		 $('#fechaemiret1').val(fechap); 

    

	       
		//goToURLElectronico
}
//------------
function generar_comprobante() {
    
	
 	var transaccion  = $('#transaccion').val(); 
 
	if ( transaccion == 'N'){
		$('#autorizacion').val(''); 
		alert('Genere de nuevo la transaccion');
	}	
 
 
}
//------------------
function Anular_comprobante() {
    
	
	var id_liquida  = $('#id_liquida').val(); 
	var transaccion  = $('#transaccion').val(); 
 
	var parametros = {
		'accion' : 'anula' ,
		'id' : id_liquida 
};

 alertify.confirm("<p>Desea Anular comprobante electronico<br></p>", function (e) {

  if (e) {
	  
	if ( transaccion == 'S'){
			
			$.ajax({
				data:  parametros,
				url:   '../model/Model_'+formulario,
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
  }	
			
 }); 	 
 
}
//-------------------- 
function goToURLElectronico(valor) {
    
	
	  var id_liquida  = $('#id_liquida').val(); 
	  var secuencial  = $('#secuencial').val(); 
	  var idprov      = $('#idprov').val(); 
	//  var autorizacion  = $("#autorizacion").val();

	    

	  var parametros = {
			    'valor':valor,
 			    'id_liquida' : id_liquida ,
 			    'secuencial': secuencial,
			    'idprov': idprov

   };

   alertify.confirm("<p>Desea generar comprobante electronico<br></p>", function (e) {
  
	if (e) {
		 
		 $.get("../../facturae/crearClaveAcceso.php?id="+id_liquida+"&tipo=3"); 
		 
	 	 $.get("../../facturae/_crearXMLiquidacion.php?id="+id_liquida); 
		  
 
		 $.ajax({
			   data:  parametros,
			   url:   '../../facturae/_autoriza_liquidacion.php',
			   type:  'GET' ,
			   beforeSend: function () { 

				  $("#data").html('<img src="ajax-loader.gif"/>');

			},
				success:  function (data) {

					$("#data").html(data); 

			 
					
			   } 
	   });
	  
	}	
			  
   }); 	 
  

	  

}
//----------------------------------
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