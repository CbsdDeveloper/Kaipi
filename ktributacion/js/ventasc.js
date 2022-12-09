var oTable; 
var formulario = 'ventasc'; 

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

		$('#loaddato').on('click',function(){
            Proceso_ventas();
  			
		});
 
		$('#loadr').on('click',function(){
            genera_resumen();
  			
		});

		
		
 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$("#action").val("add");
					
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

function accion(id,modo)
{
 
  
			$("#action").val(modo);
			
			$("#id_ventas").val(id);          

	 

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
						     
  					} 
			}); 

    }


	function genera_resumen()
{
	var anio = $("#canio").val();
	var mes = $("#cmes").val();

  enlace = '../controller/ventas_enlace.php?MES=' +  mes + '&anio=' + anio ;


  window.open(enlace,'#','width=1250,height=520,left=30,top=20');
	 
} 

 /*
 
 */
// ir a la opcion de editar
function Proceso_ventas( ) {

	
	var anio = $("#canio").val();
	var mes = $("#cmes").val();
 
	
	var parametros = {
					'accion' : 'enlace' ,
                    'anio' : anio ,
					'mes' : mes 
 	  };

	   alertify.confirm("<p>ENLACE RECAUDACION SERVICIOS - FACTURACION ELECTRONICA</p>", function (e) {
		if (e) {
		   
			$.ajax({
				data:  parametros,
				url:   '../model/Model-'+formulario,
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						 $("#result").html('Procesando Informacion');
				  },
				success:  function (data) {
						alert(data);
						 
				  } 
		}); 
			  
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
	
	
	﻿$("#id_ventas").val("");
 	$("#idcliente").val("");
	$("#razon").val("");
	$("#tipocomprobante").val("18");
	$("#numerocomprobantes").val("1");
	$("#basenograiva").val("0");
	$("#baseimponible").val("0");
	$("#baseimpgrav").val("0");
	$("#montoiva").val("0");
	$("#valorretiva").val("0");
	$("#valorretrenta").val("0");
	$("#secuencial").val("-");
	$("#codestab").val("001");
	$("#fechaemision").val(fecha);
 
	$("#valorretbienes").val("0");
	$("#valorretservicios").val("0");
 	$("#tipoEmision").val("F");
	$("#formaPago").val("20");
	
	
	$("#montoice").val("0");
	 
	
	
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
		
     	var anio = $("#canio").val();
    	var mes = $("#cmes").val();
    	
          
      var parametros = {
				'anio' : anio  ,
				'mes' : mes  
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_' + formulario  ,
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
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][7] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][7] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			}				
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
 
		
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
    

	 $("#ViewForm").load('../controller/Controller-' + formulario );
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro.php');
	 

 }
 //------------------------
 function monto_iva(valor_base){
	 
 
	  var flotante = parseFloat(valor_base)    * (12/100);
	  
	  if (valor_base > 0){
		  
		  $('#montoiva').val(flotante);
 	  
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
 function monto_riva(tipo_retencion){
	
	  var monto_iva =  $('#montoiva').val(); 
	  var base12  	=  NaN2Zero ( $('#baseimpgrav').val() ) ;   
	  var iva = 0;
	  var flotante = 0 ;
	 
	  if (tipo_retencion == 0){
		  $('#valorretbienes').val(0);
		  $('#valorretservicios').val(0);
		  $('#valretserv100').val(0);
 		  }
	 //-------------------
	  if (tipo_retencion == 1){
		  iva = monto_iva * (30/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(flotante);
		  $('#valorretservicios').val(0);
		  $('#valretserv100').val(0);
 		  }
	//-------------------
	  if (tipo_retencion == 2){
		  iva = monto_iva * (70/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(0);
		  $('#valorretservicios').val(flotante);
		  $('#valretserv100').val(0);
 		  } 
	//-------------------
	  if (tipo_retencion == 3){
		  iva = monto_iva * (100/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(0);
		  $('#valorretservicios').val(0);
		  $('#valretserv100').val(flotante);
 		  }  
	//-------------------
	  if (tipo_retencion == 4){
		  iva = monto_iva * (10/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(flotante);
		  $('#valorretservicios').val(0);
		  $('#valretserv100').val(0);
 		  }  
		//-------------------
	  if (tipo_retencion == 5){
		  iva = monto_iva * (70/100);
		  flotante = parseFloat(iva).toFixed(2)  ;
		  $('#valorretbienes').val(0);
		  $('#valorretservicios').val(flotante);
		  $('#valretserv100').val(0);
 		  } 	  
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
//----------------
function base_ir(id,modo)
{
 
  

}
 //--------------
function goToURLAsiento(valor) {
    
	
	  var id_ventas =  $('#id_ventas').val(); 
	  
	  var id_asiento =  $('#id_asiento').val(); 
	  
	  var idprov =  $('#idcliente').val();  
	  
	  var secuencial =  $('#secuencial').val();  
	  
	  
	  
	  if (id_ventas) {
		 
	
	   var parametros = {
		 			    'id_ventas' : id_ventas  ,
		 			    'id_asiento': id_asiento,
		 			    'idprov' : idprov,
		 			    'secuencial': secuencial
		     };
			  
		  	$.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-enlace_asientosv.php',
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