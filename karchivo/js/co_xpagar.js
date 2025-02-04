var oTableGrid;  
var oTable ;
 
//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
		
       var transacionID = getParameterByName('transacionID');
       
       FormView(transacionID);
	 

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

	 $("#txtcuenta").val('');
	 $("#cuenta").val('');
	 
	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-co_xpagar.php',
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
//-------------------------------------------------------------------------
  
//-------------------------------------------------------------------------
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
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
		var user = $(this).attr('id');
    
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var festado = $("#festado").val();
	  
 
      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  
      };

 
		
		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_xpagar.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
				  oTable.fnAddData([
                      s[i][0],
                      s[i][1],
                      s[i][2],
                      s[i][3],
                      s[i][4],
                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' +
                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'
                  ]);									
			} // End For
							
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
 
  }   
//--------------
 //------------------------------------------------------------------------- 
  function DetalleAsiento()
  {
	  
  
	  var id_asiento = $('#id_asiento').val(); 
	  
	  var parametros = {
 			    'id_asiento' : id_asiento 
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
//-----------------
 function FormView(id_variable)
 {
    

	 $("#ViewForm").load('../controller/Controller-co_xpagar.php?idmov=' + id_variable);
      

 }
 
 function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	    results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
 
 
//----------------------
 
//----------------------
 
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
			 url:   '../controller/Controller-co_asientos_aux.php',
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
//------------------------------------------------------------------------- 
 function GuardarAuxiliar()
 {
 	 
	 var valida = validaPantalla();
	 
	var	id_asiento  =  $("#id_asiento").val( );
	var codigodet  =	$("#codigodet").val( );
	var idprov         =	$("#idprov").val( );
 	 
	 if (valida ==0 ){
		 
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'codigodet' : codigodet ,
						    'idprov' : idprov 
 			    };
			 	 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosaux.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarAux").html('Procesando');
							},
						success:  function (data) {
								 $("#guardarAux").html(data);   
							     
							} 
				});
 	 }else{
		 alert('Ingrese la informacion del beneficiario');
	 }

 }
  
 //------------------------
 function monto_iva(valor_base){
	 
 
	  var flotante = parseFloat(valor_base)    * (12/100);
	  
	  if (valor_base > 0){
		  
		  $('#montoiva').val(flotante.toFixed(2) );
 	  
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
//------.
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
function calculoFuente()
{
	 
	var baseimpair		=  $('#baseimpair').val();
	var codigoAux 		=  $('#codretair').val();
	var id_compras 		=  $('#id_compras').val();
	var id_asiento 		=  $('#id_asiento').val();
	var secuencial 		=  $('#secuencial').val();
    
	

	 var parametros = {
			    'codigoAux' : codigoAux ,
			    'baseimpair': baseimpair,
			    'id_compras': id_compras,
			    'id_asiento': id_asiento,
			    'secuencial': secuencial
  };
	 
	$.ajax({
			data:  parametros,
			 url:   '../model/ModelFuente.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#retencion_fuente").html('Procesando');
				},
			success:  function (data) {
					 $("#retencion_fuente").html(data);   
					 DetalleAsientoIR();
				} 
	});

}
 
 