 var oTable;
 var oTableArticulo;
 var moduloOpcion =  'kinventario';
 
 
 /*
Inicializa las funciones del javascritp
*/ 
$(document).ready(function(){
  
	oTable = $('#jsontable').dataTable(); 

	modulo();
		
	FormFiltro();
	
	FormView();	    
	 

	$('#load').on('click',function(){
		   
	   BusquedaGrilla(oTable);
	   
	 });
	 
	 $('#loadt').on('click',function(){
		   
		 CargaDatos(oTable);
		   
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

		 
});  

/*
Carga datos de tramites
*/ 
function CargaDatos() {

	var idtramite  =  $("#id_tramite").val();

	var parametros = {
            'id' : idtramite 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/ajax-fin_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewFormRuta").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormRuta").html(data);   
					     
					} 
		}); 
 
} 	
/*
Buscar tramites
*/ 
function BuscaTramite()
{
  
    var  idprov     = 	$("#idprov").val();

	var  id_tramite     = 	$("#id_tramite").val();
    
    var parametros  = {
            'idprov' : idprov ,
			'id_tramite' :id_tramite
    };
	  
	$.ajax({
 			 url:   '../model/ajax_tramiteInventario.php',
			type:  'GET' ,
			data:  parametros,
			cache: false,
			beforeSend: function () { 
						$("#VisorTramite").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorTramite").html(data);   
				     
				} 
	});

}
/*
Eliminar tramite
*/ 
function deltramite(tipo,idtramite,fila)
{
	


	var id1 	= document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[3].innerHTML;
	var id2 	= document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[4].innerHTML;

	var id3 	= document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[5].innerHTML;
	var id4 	= document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[6].innerHTML;

	var idprov = $("#idprov").val();

	var str 	= id2;
	var cadena  = str.trim();
	var tope 	= cadena.length;

	var strp 	 = idprov;
	var cadenap  = strp.trim();
	var topep 	 = cadenap.length;



	$("#id_tramite").val(idtramite);
	
    $("#documento").val(id1);   
		    
	if ( tope < 250 ){
		    	   $("#detalle").val(cadena);   
	}


	if ( topep <  5 ){
		$("#idprov").val(id4);   
		$("#razon").val(id3);   
    }
		  
	$('#myModalTramite').modal('hide');

}
/*
Valida enlace del tramite y cuentas
*/ 
function validaEnlace( )
{
	  
	  var  id_tramite     	 = $("#id_tramite").val();
	  var  id_movimiento     = $("#id_movimiento").val();
	  
	  var parametros = {
	            'id_tramite' : id_tramite ,
	            'id_movimiento':id_movimiento
	    };
		  
		$.ajax({
	 			 url:   '../model/ajax_tramiteEnlace.php',
				type:  'GET' ,
				data:  parametros,
				cache: false,
				beforeSend: function () { 
							$("#VisorEnlaceValida").html('Procesando');
					},
				success:  function (data) {
						 $("#VisorEnlaceValida").html(data);   
					     
					} 
		});
    
	$('#myModalEnlace').modal('show');

}

/*
Inicializa las funciones del javascritp
*/ 
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
			  	    $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
 			  	   
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
/*
Ir a la seccion de busqueda para edicion
*/ 
function goToURL(accion1,id) {
  	
     var parametros = {
					'accion' : accion1 ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_movimiento.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);   
						     
							 CargaDatos();
  					} 
			}); 

	  	     AsignaBodega1();
	  
    }
/*
Limpia pantalla para agregar datos
*/ 
function LimpiarPantalla() {
  
	var fecha = fecha_hoy();
	$("#fecha").val(fecha);

	$("#fechaf").val(fecha);

	var  idbodega1     = $("#idbodega1").val();
 	$("#idbodega").val(idbodega1);

	 

	 $("#id_departamento").val("0");	
	
	$("#id_movimiento").val("");	
 	$("#detalle").val("");
 	$("#comprobante").val("");
	$("#estado").val("digitado");
	$("#tipo").val("");
	$("#documento").val("");
	$("#idprov").val("");
	$("#razon").val("");
	$("#idproducto").val("");
	$("#idbarra").val("");
	$("#articulo").val("");
	$("#fechaa").val("");
	$("#action").val("add");
	DetalleMov(0,'add');

 }
/*
Pone Fecha actual
*/ 
 function fecha_hoy()
{
   
    var today = new Date();
    var dd    = today.getDate();
    var mm    = today.getMonth()+1; //January is 0!
    var yyyy  = today.getFullYear();
    
    if(dd < 10){
        dd='0'+ dd
    } 
    if(mm < 10){
        mm='0'+ mm
    } 
    
    var today = yyyy + '-' + mm + '-' + dd;
    
return today;
            
} 
/*
Busqueda para visualizar en la pantalla de informacion
*/  
function BusquedaGrilla(oTable){        
 
   
			var  user 		= $(this).attr('id');
            var  estado		= $("#estado1").val();
            var  tipo       = $("#tipo1").val();
            var  fecha1     = $("#fecha1").val();
            var  fecha2     = $("#fecha2").val();
            var  idbodega1  = $("#idbodega1").val();
            
            var parametros = {
					'estado' : estado , 
                    'tipo' : tipo  ,
                    'fecha1' : fecha1  ,
                    'fecha2' : fecha2,
                    'idbodega1':idbodega1
 	       };
      
			if(user != '') 
			{ 
				$.ajax({
					data:  parametros,  
					url: '../grilla/grilla_movimientos.php',
					dataType: 'json',
					success: function(s){
					console.log(s); 
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
									'<button class="btn btn-xs btn-warning" title="Editar registro" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
									'<button class="btn btn-xs btn-danger" title="Eliminar/Anular registro" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
								]);										
							} // End For
					} 						
					},
					error: function(e){
					console.log(e.responseText);	
					}
					});
			}
			
			AsignaBodega1();
 }   
 /*
Busqueda de imagen del articulo
*/  
 function imagenfoto(urlimagen)
{
	 
    var path_imagen =  '../'+ urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
/*
Busqueda verifica el valor del articulo
*/  
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
         var id 	=   $('#idproducto').val();
        			
         posicion_x	= (screen.width/2)-(ancho/2); 
         
         posicion_y	= (screen.height/2)-(alto/2); 
         
         enlace 	= url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  
/*
Coloca las variables de las opciones del menu lateral
*/ 
function modulo()
{
 

		 
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
					 $("#ViewModulo").html(data);   
				     
				} 
	});  
}
/*
Coloca formulario de ingreso de datos 
*/ 
function FormView()
{
    
	 $("#ViewForm").load('../controller/Controller-inv_movimiento.php');
   
}
/*
Coloca la variable del indice principal
*/ 
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_movimiento').val(id); 
	  
	DetalleMov(id,action);

}
/*
Coloca la variable del indice principal
*/ 
function acciona(comprobante, estado)
{
 
	$('#estado').val(estado);
	
	$('#comprobante').val(comprobante); 
	  
	 

}
/*
Coloca formulario para filtro de busqueda en la pantalla de busquedas
*/ 
function FormFiltro()
{
 

	$("#ViewFiltro").load('../controller/Controller-inv_movimiento_filtro.php');
 

}
/*
Selecciona la bodega disponible
*/ 
function AsignaBodega()
{
    var  idbodega     = $("#idbodega").val();
   
    var parametros = {
            'idbodega' : idbodega 
    };
    
    
	$.ajax({
 			 url:   '../model/ajax_bodega.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#SaldoBodega").html('Procesando');
				},
			 success:  function (data) {
					 $("#SaldoBodega").html(data);   
				     
				} 
	});
	

}
/*
Selecciona la bodega disponible filtro de busqueda
*/ 
function AsignaBodega1()
{
    var  idbodega     = $("#idbodega1").val();

 	$("#idbodega").val(idbodega);
  


    var parametros = {
            'idbodega' : idbodega 
    };
    
	$.ajax({
 			 url:   '../model/ajax_bodega.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#SaldoBodega").html('Procesando');
				},
			 success:  function (data) {
					 $("#SaldoBodega").html(data);   
				     
				} 
	});
 
}
/*
datos...
*/
function CopiarMovimiento()
{
 
	var id_movimiento = $('#id_movimiento').val();

	var estado = $('#estado').val();

    var parametros = {
             'id' : id_movimiento,  
             'accion': 'copiar'
     };
    
	 if ( estado == 'aprobado'){

			alertify.confirm("<p> DESEA GENERAR SALIDA DEL MOVIENTO DE TRANSACCION...</p>", function (e) {
				if (e) {
				
					$.ajax({
						url:   '../model/Model-inv_movimientoe.php',
						data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
									$("#result").html('Procesando');
						},
						success:  function (data) {
									$("#result").html(data);   
								
						} 
			});
						
				}
			}); 

		}

}
/*
Detalle de los detalle de los articulos seleccionados en el movimiento de ingreso a bodega
*/ 
function DetalleMov(id_movimiento,accion1)
{
 
    var parametros = {
             'id' : id_movimiento,  
             'accion': accion1
     };
    
	$.ajax({
 			url:   '../controller/Controller-inv_movimientoDet.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						 $("#DivMovimiento").html('Procesando');
				},
			   success:  function (data) {
					     $("#DivMovimiento").html(data);   
				     
				} 
	});

}
/*
Inserta numero de series de los articulos que se requieren
*/ 
function inserta_serie()
{
	
    var id_movimiento = $('#id_movimiento').val();
	
 	var idproducto    = $('#idproducto_serie').val();
	 
 	var serie  		  = $('#serie').val()  ;
 	
 
 	if(id_movimiento){
		 	
		    var parametros = {
		             'id' : id_movimiento,  
		             'idproducto': idproducto,
		             'serie': serie
		     };
		    
			$.ajax({
		 			url:   '../controller/Controller-inv_movimientoSerie.php',
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#VisorSerie").html('Procesando');
						},
					   success:  function (data) {
							 $("#VisorSerie").html(data);  
						     
						} 
			});
 	}	     

}
/*
Inserta  productos en la tabla de movimientos.
*/ 
function InsertaProducto()
{

	var id_movimiento = $('#id_movimiento').val();
	
 	var idproducto    = $('#idproducto').val();
	 
 	var estado  	  = $.trim( $('#estado').val() );
 	
 	var tipo    	  = $('#tipo').val();
 	
	if (idproducto){
		
		if (estado == 'digitado'){ 
 			
						var parametros = {
								"idproducto" : idproducto ,
				                "id_movimiento" : id_movimiento ,
				                "estado" : estado,
				                "tipo" : tipo,
				                "accion" : 'add' 
						};
				          
						  $.ajax({
								data:  parametros,
								url:   '../model/Model-addproducto.php',
								type:  'GET' ,
								beforeSend: function () { 
										$("#DivProducto").html('Procesando');
								},
								success:  function (data) {
									
										 $("#DivProducto").html(data);  
										 
										 DetalleMov(id_movimiento,'edit');
										  
								} 
						}); 
 				  $('#idproducto').val('');
						 	 
				  $('#CodBarra').val('');
							 
				 $('#articulo').val('');
						  
			 	  
		}	
	}else{
	
		alert('Guarde información de la solicitud');

	}

}
/*
Abre archivo para verificar
*/ 
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
Redondea funcion para ingreso de datos
*/ 
function RedondeaDosDecimal(num) {    
	 return +(Math.round(num + "e+2")  + "e-2");
	}
/*
Redondea funcion para ingreso de datos
*/ 
function calcular(id) {
 	
	
	var estado 			= $('#estado').val();
 	var ingreso_egreso 	= $('#tipo').val();
 	
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	
 

	/// CANTIDAD
	objeto 						 =  '#cantidad_' + id;
	var cantidad 				 =  $(objeto).val();
	var	lcantidad                = parseFloat (cantidad).toFixed(2);
	var	lcosto                   = parseFloat (costo).toFixed(6);
	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		= parseFloat (sal1).toFixed(2);
	
	var	total 		= 0;
  	var	baseiva 	= 0;
	var	tarifa_cero	= 0;
	var	monto_iva 	= 0;
	var tempBase 	= 0;

	var IVA_parametro =   $('#action_iva').val(); 	  // variable IVA parametrizado
	var IVA_variable  =   parseFloat (IVA_parametro);
	var	IVA 		  =   IVA_variable.toFixed(2);   // variable IVA parametrizado
	var	DesgloseIVA  =    1 + IVA ; 

	
	objeto 				=  '#tipo_' + id;
	var tipo_mov1 		= $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	
	objeto 				=  '#pdescuento_' + id;
	var pdtempo 		=  $(objeto).val();
 	
	objeto 				=  '#descuento_' + id;
	var parciald 		=  $(objeto).val();
 	
	
	//--- INGRESO

	if (ingreso_egreso == 'I'){

					if (tipo_movimiento == 'I'){
						
						baseiva 	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 

						tarifa_cero =  0;
						
						if (pdtempo > 0 ){
							parciald   = baseiva * (pdtempo/100);
						    baseiva   = baseiva - parciald;
 						} 
					 
							
 						monto_iva   	=   baseiva.toFixed(6) * parseFloat (IVA);
 			 			tempBase 	    =   baseiva + monto_iva;
			 			 
			 			total =  RedondeaDosDecimal(tempBase);

 						//----------------- ASIGNA
						objeto =  '#baseiva_' + id;
					 	$(objeto).val(baseiva);
					 	objeto =  '#tarifacero_' + id;
					 	$(objeto).val(tarifa_cero);
					 	objeto =  '#montoiva_' + id;
					 	
					 	var monto_iva1   	=  monto_iva.toFixed(6) ;
					 	$(objeto).val(monto_iva1);

					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
 					    
 					    objeto =  '#descuento_' + id;
					    $(objeto).val(parciald);
 		 
 					 
 			 		}else{
 			 			
 			 			tarifa_cero	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
 			 			baseiva     =  0;
						
						if (pdtempo > 0 ){
							parciald      = tarifa_cero * (pdtempo/100);
							tarifa_cero   = tarifa_cero - parciald;
 						} 
						
						baseiva     =   0 ;
			 			monto_iva   =   0;
						tempBase  		=   parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
						total 			=   parseFloat (tarifa_cero).toFixed(2);

 						//----------------- ASIGNA

						objeto =  '#baseiva_' + id;
					 	$(objeto).val(baseiva);
					 	objeto =  '#tarifacero_' + id;
					 	$(objeto).val(tarifa_cero);
					 	objeto =  '#montoiva_' + id;
					 	$(objeto).val(monto_iva);
					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
 					   objeto =  '#descuento_' + id;
					    $(objeto).val(parciald);
					}
				 	 	//--------------------------------
				 		guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,pdtempo,parciald,lcosto);
  	}
 	else { 
	 	 		 //---------------- egresos 
 				 if ( (saldo * 10) >= (lcantidad *10) ) { 	

 	 					if (tipo_movimiento == 'I'){

		 	 						baseiva 	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
		 							//monto_iva 	=  baseiva * parseFloat (IVA).toFixed(2);
		 							
									monto_iva 	=  baseiva.toFixed(4) * parseFloat (IVA);
									monto_iva	= RedondeaDosDecimal(monto_iva);
 		 							
		 				 			tarifa_cero =  0;
		 				 			tempBase 	=   baseiva + monto_iva;
		 				 			total       = parseFloat (tempBase).toFixed(2);
		 	 						//----------------- ASIGNA
		 							objeto =  '#baseiva_' + id;
		 						 	$(objeto).val(baseiva);
		 						 	objeto =  '#tarifacero_' + id;
		 						 	$(objeto).val(tarifa_cero);
		 						 	objeto =  '#montoiva_' + id;
		 						 	$(objeto).val(monto_iva);
		 						 	objeto =  '#total_' + id;
		 	 					    $(objeto).val(total);
				 	     }else{
						 	    	baseiva     	=   0 ;
						 			tarifa_cero 	=   lcosto * lcantidad;
									monto_iva   	=   0;
									tempBase  		=   lcosto * lcantidad;
									total 			=   parseFloat (tempBase).toFixed(2);
									 
									//----------------- ASIGNA
									objeto =  '#baseiva_' + id;
								 	$(objeto).val(baseiva);
								 	objeto =  '#tarifacero_' + id;
								 	$(objeto).val(tarifa_cero);
								 	objeto =  '#montoiva_' + id;
								 	$(objeto).val(monto_iva);
						}

 						objeto 		=  '#total_' + id;
 						total 		= parseFloat (total).toFixed(2);

 					 	$(objeto).val(total);
 					 	//--------------------------------
					 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,pdtempo,parciald,lcosto);
				 	 	
				  }else{
					  alert('Saldo No Disponible');
			 		  objeto =  '#cantidad_' + id;
					  $(objeto).val(0);
				  }
	}
  	total_factura();	
}
/*
*/
function calcularde(id) {


	var estado 			= $('#estado').val();
 	var ingreso_egreso 	= $('#tipo').val();
 	
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	
	/// CANTIDAD
	objeto 						 =  '#cantidad_' + id;
	var cantidad 				 =  $(objeto).val();
	var	lcantidad                = parseFloat (cantidad).toFixed(2);
	var	lcosto                   = parseFloat (costo).toFixed(6);
	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		= parseFloat (sal1).toFixed(2);
	
	var	total 		= 0;
  	var	baseiva 	= 0;
	var	tarifa_cero	= 0;
	var	monto_iva 	= 0;
	var tempBase 	= 0;

	var IVA_parametro =   $('#action_iva').val(); 	  // variable IVA parametrizado
	var IVA_variable  =   parseFloat (IVA_parametro);
	var	IVA 		  =   IVA_variable.toFixed(2);   // variable IVA parametrizado
	
	var	DesgloseIVA = 1 + IVA ; 

	objeto 				=  '#tipo_' + id;
	var tipo_mov1 		= $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	
	objeto 			=  '#pdescuento_' + id;
	var pdtempo 		=  $(objeto).val();
 	
	objeto 			=  '#descuento_' + id;
	var parciald 		=  $(objeto).val();
 
	
	
	//--- INGRESO
	if (ingreso_egreso == 'I'){
					if (tipo_movimiento == 'I'){
						
						baseiva 	=  parseFloat (lcosto).toFixed(4) *  parseFloat (lcantidad).toFixed(2); 
						tarifa_cero =  0;
						
						if (parciald > 0 ){

							pdtempo   =  ( (baseiva * parciald) / 100) * 100;

							baseiva   = baseiva - parciald;

 						   
 						} 
					 
							
 						monto_iva   	=   baseiva.toFixed(6) * parseFloat (IVA);
 			 			tempBase 	    =   baseiva + monto_iva;
			 			 
			 			total =  RedondeaDosDecimal(tempBase);
 						//----------------- ASIGNA
						objeto =  '#baseiva_' + id;
					 	$(objeto).val(baseiva);
					 	objeto =  '#tarifacero_' + id;
					 	$(objeto).val(tarifa_cero);
					 	objeto =  '#montoiva_' + id;
					 	
					 	var monto_iva1   	=  monto_iva.toFixed(4) ;
					 	$(objeto).val(monto_iva1);
					 	
					  
					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
 					 
 			 		}else{
 			 			
 			 			tarifa_cero	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
 			 			baseiva     =  0;
						
						if (parciald > 0 ){

							parciald      = ( (tarifa_cero * parciald) / 100) * 100;

							tarifa_cero   = tarifa_cero - parciald;
						
						
 						} 
						
  

						baseiva     =   0 ;
			 			monto_iva   =   0;
						tempBase  		=   parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
						total 			=   parseFloat (tarifa_cero).toFixed(2);
 						//----------------- ASIGNA
						objeto =  '#baseiva_' + id;
					 	$(objeto).val(baseiva);
					 	objeto =  '#tarifacero_' + id;
					 	$(objeto).val(tarifa_cero);
					 	objeto =  '#montoiva_' + id;
					 	$(objeto).val(monto_iva);
					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
					}
				 	 	//--------------------------------
				 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,pdtempo,parciald,lcosto);
  	}
 	else { 
	 	 		 //---------------- egresos 
 				 if ( (saldo * 10) >= (lcantidad *10) ) { 	   
 	 					if (tipo_movimiento == 'I'){
		 	 						baseiva 	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
		 							//monto_iva 	=  baseiva * parseFloat (IVA).toFixed(2);
		 							
									monto_iva 	=  baseiva.toFixed(6) * parseFloat (IVA);
									monto_iva= RedondeaDosDecimal(monto_iva);
 		 							
		 							
		 				 			tarifa_cero =  0;
		 				 			tempBase 	 =   baseiva + monto_iva;
		 				 			total     = parseFloat (tempBase).toFixed(2);
		 	 						//----------------- ASIGNA
		 							objeto =  '#baseiva_' + id;
		 						 	$(objeto).val(baseiva);
		 						 	objeto =  '#tarifacero_' + id;
		 						 	$(objeto).val(tarifa_cero);
		 						 	objeto =  '#montoiva_' + id;
		 						 	$(objeto).val(monto_iva);
		 						 	objeto =  '#total_' + id;
		 	 					    $(objeto).val(total);
				 	     }else{
						 	    	baseiva     =   0 ;
						 			tarifa_cero =   lcosto * lcantidad;
									monto_iva   =   0;
									tempBase  		=   lcosto * lcantidad;
									total 			=   parseFloat (tempBase).toFixed(2);
									 
									//----------------- ASIGNA
									objeto =  '#baseiva_' + id;
								 	$(objeto).val(baseiva);
								 	objeto =  '#tarifacero_' + id;
								 	$(objeto).val(tarifa_cero);
								 	objeto =  '#montoiva_' + id;
								 	$(objeto).val(monto_iva);
						}
 						objeto =  '#total_' + id;
 						total = parseFloat (total).toFixed(2);
 					 	$(objeto).val(total);
 					 	//--------------------------------
					 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,pdtempo,parciald,lcosto);
				 	 	
				  }else{
					  alert('Saldo No Disponible');
			 		  objeto =  '#cantidad_' + id;
					  $(objeto).val(0);
				  }
	}
 	total_factura();	    
}
/*
Calcular montos adicionales
*/ 
function calculard(id) {


	var estado 			= $('#estado').val();
 	var ingreso_egreso 	= $('#tipo').val();
 	
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	
	/// CANTIDAD
	objeto 						 =  '#cantidad_' + id;
	var cantidad 				 =  $(objeto).val();
	var	lcantidad                = parseFloat (cantidad).toFixed(2);
	var	lcosto                   = parseFloat (costo).toFixed(6);
	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		= parseFloat (sal1).toFixed(2);
	
	var	total 		= 0;
  	var	baseiva 	= 0;
	var	tarifa_cero	= 0;
	var	monto_iva 	= 0;
	var tempBase 	= 0;

	var IVA_parametro =   $('#action_iva').val(); 	  // variable IVA parametrizado
	var IVA_variable  =   parseFloat (IVA_parametro);
	var	IVA 		  =   IVA_variable.toFixed(2);   // variable IVA parametrizado
	
	var	DesgloseIVA = 1 + IVA ; 

	objeto 				=  '#tipo_' + id;
	var tipo_mov1 		= $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	
	objeto 			=  '#pdescuento_' + id;
	var pdtempo 		=  $(objeto).val();
 	
	objeto 			=  '#descuento_' + id;
	var parciald 		=  $(objeto).val();
 
	
	
	//--- INGRESO
	if (ingreso_egreso == 'I'){
					if (tipo_movimiento == 'I'){
						
						baseiva 	=  parseFloat (lcosto).toFixed(4) *  parseFloat (lcantidad).toFixed(2); 
						tarifa_cero =  0;
						
						if (pdtempo > 0 ){
							parciald   = baseiva * (pdtempo/100);
						    baseiva   = baseiva - parciald;
 						} 
					 
							
 						monto_iva   	=   baseiva.toFixed(6) * parseFloat (IVA);
 			 			tempBase 	    =   baseiva + monto_iva;
			 			 
			 			total =  RedondeaDosDecimal(tempBase);
 						//----------------- ASIGNA
						objeto =  '#baseiva_' + id;
					 	$(objeto).val(baseiva);
					 	objeto =  '#tarifacero_' + id;
					 	$(objeto).val(tarifa_cero);
					 	objeto =  '#montoiva_' + id;
					 	
					 	var monto_iva1   	=  monto_iva.toFixed(4) ;
					 	$(objeto).val(monto_iva1);
					 	
					  
					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
 					 
 			 		}else{
 			 			
 			 			tarifa_cero	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
 			 			baseiva     =  0;
						
						if (pdtempo > 0 ){
							parciald      = tarifa_cero * (pdtempo/100);
							tarifa_cero   = tarifa_cero - parciald;
 						} 
						
						baseiva     =   0 ;
			 			monto_iva   =   0;
						tempBase  		=   parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
						total 			=   parseFloat (tarifa_cero).toFixed(2);
 						//----------------- ASIGNA
						objeto =  '#baseiva_' + id;
					 	$(objeto).val(baseiva);
					 	objeto =  '#tarifacero_' + id;
					 	$(objeto).val(tarifa_cero);
					 	objeto =  '#montoiva_' + id;
					 	$(objeto).val(monto_iva);
					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
					}
				 	 	//--------------------------------
				 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,pdtempo,parciald,lcosto);
  	}
 	else { 
	 	 		 //---------------- egresos 
 				 if ( (saldo * 10) >= (lcantidad *10) ) { 	   
 	 					if (tipo_movimiento == 'I'){
		 	 						baseiva 	=  parseFloat (lcosto).toFixed(6) *  parseFloat (lcantidad).toFixed(2); 
		 							//monto_iva 	=  baseiva * parseFloat (IVA).toFixed(2);
		 							
									monto_iva 	=  baseiva.toFixed(6) * parseFloat (IVA);
									monto_iva= RedondeaDosDecimal(monto_iva);
 		 							
		 							
		 				 			tarifa_cero =  0;
		 				 			tempBase 	 =   baseiva + monto_iva;
		 				 			total     = parseFloat (tempBase).toFixed(2);
		 	 						//----------------- ASIGNA
		 							objeto =  '#baseiva_' + id;
		 						 	$(objeto).val(baseiva);
		 						 	objeto =  '#tarifacero_' + id;
		 						 	$(objeto).val(tarifa_cero);
		 						 	objeto =  '#montoiva_' + id;
		 						 	$(objeto).val(monto_iva);
		 						 	objeto =  '#total_' + id;
		 	 					    $(objeto).val(total);
				 	     }else{
						 	    	baseiva     =   0 ;
						 			tarifa_cero =   lcosto * lcantidad;
									monto_iva   =   0;
									tempBase  		=   lcosto * lcantidad;
									total 			=   parseFloat (tempBase).toFixed(2);
									 
									//----------------- ASIGNA
									objeto =  '#baseiva_' + id;
								 	$(objeto).val(baseiva);
								 	objeto =  '#tarifacero_' + id;
								 	$(objeto).val(tarifa_cero);
								 	objeto =  '#montoiva_' + id;
								 	$(objeto).val(monto_iva);
						}
 						objeto =  '#total_' + id;
 						total = parseFloat (total).toFixed(2);
 					 	$(objeto).val(total);
 					 	//--------------------------------
					 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,pdtempo,parciald,lcosto);
				 	 	
				  }else{
					  alert('Saldo No Disponible');
			 		  objeto =  '#cantidad_' + id;
					  $(objeto).val(0);
				  }
	}
 	total_factura();	    
}
/*
Calcular montos adicionales
*/ 
function calcularT(id) {
    
 
    
}
/*
Calcular total valor factura...
*/ 
function total_factura(){
	
	
var Calculartotal = 0;
var CalcularBIva  = 0;
var CalcularBase  = 0;
var CalcularIva   = 0;
var Descuento     = 0;
	
 $("#tabla_mov td input").each(function(){
		 
		 
		 lnuCampo = $(this).attr('id') ;
		
		 layDatosNombre         = lnuCampo.split( '_' );
		 lstCampo               = layDatosNombre[0];
		 Objeto					= '#' + lnuCampo;
		 
	 		 
		 if (lstCampo == 'total'){
			 Calculartotal =  Calculartotal + parseFloat($(Objeto).val());
 		}
		 
		 if (lstCampo == 'baseiva'){ 
				CalcularBIva =  CalcularBIva + parseFloat($(Objeto).val());
          }
		 
         if (lstCampo == 'tarifacero'){
         	CalcularBase =  CalcularBase + parseFloat($(Objeto).val());
          } 
         
         if (lstCampo == 'montoiva'){
         	CalcularIva =  CalcularIva + parseFloat($(Objeto).val());
           } 
         
         if (lstCampo == 'descuento'){
        	 Descuento =  Descuento + parseFloat($(Objeto).val());
            } 
         
         
		});
	 
 
 	// iva
	CalcularIva = parseFloat(CalcularIva.toFixed(2));  
    $('#Iva').html(CalcularIva); 
    
    // ----
    CalcularBIva = parseFloat(CalcularBIva.toFixed(2));  
    $('#baseI').html(CalcularBIva); 
    // ----
    CalcularBase = parseFloat(CalcularBase.toFixed(2));  
    $('#Cero').html(CalcularBase); 
 	
 	Calculartotal = parseFloat(Calculartotal.toFixed(2));  
    $('#TotalF').html('<b>'+ Calculartotal + '</b>'); 
   
    
    Descuento = parseFloat(Descuento.toFixed(2));  
    $('#Descuento').html('<b>'+ Descuento + '</b>'); 
 
  
}
/*
Eliminar detalles de articulos
*/ 
function EliminarDet(id) {
	 
	
	var id_movimiento = $('#id_movimiento').val();
	
	var estado    	  = $('#estado').val();
	
	if (id){
		
		var parametros = {
				"id" : id ,
                "accion" : 'eliminar' ,
                "id_movimiento": id_movimiento,
                "estado" : estado
		};
	 
          
		  $.ajax({
				data:  parametros,
				url:   '../model/Model-addproducto.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivProducto").html('Procesando');
				},
				success:  function (data) {
						 $("#DivProducto").html(data);  // $("#cuenta").html(response);
						 
						 DetalleMov(id_movimiento,'edit');
					     
				} 
		}); 
 			
		 	 $('#idproducto').val('');
		 	 
			 $('#CodBarra').val('');
			 
			 $('#articulo').val('');
 	
	}else{
	
		alert('No se puede eliminar');

	}
}	
/*
Visualizar la imagen del producto
*/ 
function PictureArticulo(id)
{
 
	var objeto 					  =  '#tipourl_' + id;
	var tipourl 				  = $(objeto).val();
	objeto 					      =  '#url_' + id;
	var url 				      = $(objeto).val();	
	
	var id_movimiento	    = 	 $('#id_movimiento').val(); 

	var parametros = {
			"tipourl" : tipourl ,
            "url" : url ,
            "id" : id,
			'id_movimiento':id_movimiento
	};
	
	$.ajax({
 			 url:   '../controller/Controller-picture_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticuloActualiza").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticuloActualiza").html(data);   
				     
				} 
	});
 
}
/*
Visualizar la imagen del producto
*/ 
function ActualizaCuenta( )
{
 
	 var cuenta_inventario 	= 	 $('#cuenta_inventario').val();
	 var idproductop 		= 	 $('#idproductop').val();
	 var cuenta_gas 		= 	 $('#cuenta_gas').val(); 

	 var fcaducidad 		= 	 $('#fcaducidad').val(); 
	 var id_movimiento	    = 	 $('#id_movimiento').val(); 
     
	
	var parametros = {
			"cuenta_inventario" : cuenta_inventario ,
            "idproductop"  : idproductop ,
            "cuenta_gas"   : cuenta_gas,
			'fcaducidad'   : fcaducidad,
			'id_movimiento': id_movimiento
	};
	
	$.ajax({
 			 url:   '../model/Model-editCuentaArticulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#GuardaDatoA").html('Procesando');
				},
			success:  function (data) {
					 $("#GuardaDatoA").html(data);   
				     
				} 
	});
     

}
/*
Referencia articulo
*/ 
function Refarticulo(nombre)
{
 
 
	var parametros = {
			"nombre" : nombre  
	};
	
	$.ajax({
 			 url:   '../controller/Controller-categoria_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticulo").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticulo").html(data);   
				     
				} 
	});

}
/*
Referencia articulo
*/ 
function RefSerie(nombre,id)
{
 
	var cantidad_serie = $('#cantidad_'+id).val(); 
	 
     $('#idproducto_serie').val(id); 
 
 	$('#serie').val(cantidad_serie); 
  
 	inserta_serie();
  

}
/*
Guarda detalle de los detalles seleccionados
*/ 
function guarda_detalle1(  total,id,estado,ingreso_egreso)
{
  
	var parametros = {
 			"total" : total  ,
			"ingreso_egreso": ingreso_egreso,
 			"id" : id 
 	};
	
	if (estado == 'digitado'){
		
			$.ajax({
		 			 url:   '../model/Model-editproductoT.php',
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#DivProducto").html('Procesando');
						},
					success:  function (data) {
							 $("#DivProducto").html(data);  
						     
						} 
			});
	
	}

}
/*
Guarda detalle de los detalles seleccionados
*/ 
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,p1,descuento,lcosto)
{
  
 	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": ingreso_egreso,
 			"id" : id ,
 			"p1": p1,
 			"descuento":descuento,
 			"lcosto" : lcosto
	};
	
	if (estado == 'digitado'){
		
			$.ajax({
		 			 url:   '../model/Model-editproducto.php',
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#DivProducto").html('Procesando');
						},
					success:  function (data) {
							 $("#DivProducto").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	
	}

}
/*
Guarda aprueba informacion del comprobante de ingreso
*/
function aprobacion(){

	 
  var id 	  = $('#id_movimiento').val();
  var estado  = $.trim( $('#estado').val() );
  var tipo    = $('#tipo').val();	
  
  var mensaje =  confirm("¿Desea aprobar la transacción?");
  
  if (mensaje) {
	 
	 var parametros = {
	 			"id" : id   ,
	 			"accion" : 'aprobacion',
	 			"tipo"   : tipo
		};
		
		if (estado == 'digitado'){
			
				$.ajax({
			 			 url:   '../model/Model-inv_movimiento.php',
			 			data:  parametros,
						type:  'GET' ,
							beforeSend: function () { 
									$("#result").html('Procesando');
							},
						success:  function (data) {
								 $("#result").html(data);  // $("#cuenta").html(response);
							     
							} 
				});
		
		} 
	 
	 
  }
 
}
/*
Revertir informacion del comprobante de ingreso
*/
function RevertirDatos(  ){

	 
	  var id 	  = $('#id_movimiento').val();
	  var estado  = $('#estado').val() ;
	  var tipo    = $('#tipo').val();	
	  
	  var mensaje =  confirm("¿Desea Revertir la transacción?");
	  
	  if (mensaje) {
		 
		 var parametros = {
		 			"id" : id   ,
		 			"accion" : 'revertir',
		 			"tipo"   : tipo
			};
			
			if (estado == 'aprobado'){
				
					$.ajax({
				 			 url:   '../model/Model-inv_movimiento.php',
				 			data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#result").html('Procesando');
								},
							success:  function (data) {
									 $("#result").html(data);  // $("#cuenta").html(response);
									 $('#estado').val('digitado') ;
									 $('#action').val('editar') ;
								} 
					});
			
			} 
		 
	  }
	 
	}
/*
Revertir informacion del comprobante de ingreso
*/
function actualiza_serie( idserie,valor ){

	 
	  var id 	 		= $('#id_movimiento').val();
	  var estado  		= $.trim( $('#estado').val() );
	  var serie_valor   = $.trim( valor );
	  var tipo   		= $('#tipo').val();	
	 
   if (tipo == 'I'){
		 
		 var parametros = {
		 			"idserie" : idserie   ,
		 			"valor" : valor
 			};
 
				
				if ( serie_valor!='-'	) {
					
					$.ajax({
				 			 url:   '../model/Model-inv_movimiento_serie.php',
				 			data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#GuardaSerie").html('Procesando');
								},
								success:  function (data) {
									 $("#GuardaSerie").html(data);   
								     
								} 
					});
				} 
 		 
       } 
	 
	}
/*
Impresion de reportes de comprobantes
*/
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
/*
Impresion de reportes de comprobantes
*/
function modalVentana(url){        
	
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1000;
    
    var alto = 450;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
/*
Impresion de reportes de comprobantes
*/
function modalImportar(url){        
	
    
    var id_movimiento = $('#id_movimiento').val();
    
    var idbodega = $('#idbodega').val();
    
    
    var estado  = $('#estado').val();
    var tipo    = $('#tipo').val();
    
    AsignaBodega();
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1024;
    
    var alto = 500;
    
    if ( tipo == 'I') { 
	    if ( estado == 'digitado') { 
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace + '?id='+id_movimiento+'&bodega='+idbodega,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	    
	    }
    }    
    
 }
/*
Impresion de reportes de comprobantes
*/
function modalProducto(url){        
	
    
    var id_movimiento = $('#id_movimiento').val();
    var estado  = $('#estado').val();
    var tipo    = $('#tipo').val();
    
    AsignaBodega();
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1024;
    
    var alto = 500;
 
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace ,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
    
 }
/*
Impresion de reportes de comprobantes
*/
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

/*
Impresion de reportes de comprobantes
*/
function enlace_contabilidad(url){        
	
	var idmovimiento1    = $('#id_movimiento').val();
	var estado   	     = $('#estado').val();
	var transaccion      = $('#transaccion').val();
	var tipo             = $('#tipo').val();
   
	if (estado == 'digitado'){
	   
	   alert('Debe la transacción estar aprobada para la actualización del registro de facturas');
	   
   }else{
	   
	   if (transaccion == 'compra'){
		   
		   	if (tipo == 'I'){
		   		
		   		if ( idmovimiento1 > 0) {
		   			
 						var parametros = {
								'accion' : 'agregar' ,
					            'idmovimiento' : idmovimiento1 
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
		   		
			    var posicion_x; 
			    var posicion_y; 
			    var enlace = url + idmovimiento1;
			    var ancho = 1260;
			    var alto = 520;
			    
			    posicion_x=(screen.width/2)-(ancho/2); 
			    posicion_y=(screen.height/2)-(alto/2); 
			    
			     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
			     
		   		}
	       }	
	  }		
	   
   }		 
 
 }