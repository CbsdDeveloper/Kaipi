 var oTable;
 
 var oTableArticulo;
   
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
    
	 window.addEventListener("keypress", function(event){
	        if (event.keyCode == 13){
	            event.preventDefault();
	        }
	    }, false);
	    
	 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        oTable = $('#jsontable').dataTable(); 
	    
 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
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
	     
	
	         
});  
//-----------------------------------------------------------------
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
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
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

	  AsignaBodega();
	  
    }
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
	var fecha = fecha_hoy();
	
	$("#id_movimiento").val("");
	
	$("#fecha").val(fecha);
	
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
 
   
			var user = $(this).attr('id');
            
            var  estado		= $("#estado1").val();
            var  tipo      = $("#tipo1").val();
            var  fecha1      = $("#fecha1").val();
            var  fecha2     = $("#fecha2").val();
            
            var  idbodega1     = $("#idbodega1").val();
            
            
           
 
         
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
                               	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
 
 function imagenfoto(urlimagen)
{
  
	 
    var path_imagen =  '../'+ urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
         var id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  

function modulo()
{
 

	 var moduloOpcion =  'kinventario';
		 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-inv_movimiento.php');
     
	 
 
	 

}
//-----------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_movimiento').val(id); 
	  
	DetalleMov(id,action);

}
//-----------------
function acciona(comprobante, estado)
{
 
	$('#estado').val(estado);
	
	$('#comprobante').val(comprobante); 
	  
	 

}
//----------------------
function FormFiltro()
{
 
	$.ajax({
 			 url:   '../controller/Controller-inv_movimiento_filtro.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFiltro").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltro").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-------------------AsignaBodega
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
					 $("#SaldoBodega").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-------------------------------------------------------------
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
					 $("#DivMovimiento").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-----------
function inserta_serie()
{
 
	
	
    var id_movimiento = $('#id_movimiento').val();
	
 	var idproducto    = $('#idproducto_serie').val();
	 
 	var serie  =   $('#serie').val()  ;
 	
 
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
							 $("#VisorSerie").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
 	}	     

}
//-------------------------
//----------------------
function InsertaProducto()
{

	var id_movimiento = $('#id_movimiento').val();
	
 	var idproducto    = $('#idproducto').val();
	 
 	var estado  = $.trim( $('#estado').val() );
 	
 	
 	var tipo    = $('#tipo').val();
 	
 	
 	
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
				//-----------------
 				  $('#idproducto').val('');
						 	 
				  $('#CodBarra').val('');
							 
				 $('#articulo').val('');
						  
			 	  
		}	
	}else{
	
		alert('Guarde información de la solicitud');

	}
	


 
 	
}

 
//--------------------------------------------------------------------	   
function openFile(url,ancho,alto) {
      
	  var posicion_x; 
      var posicion_y; 
      var enlace; 
      
      posicion_x=(screen.width/2)-(ancho/2); 
      posicion_y=(screen.height/2)-(alto/2); 
      
     
      
      enlace = url  ;

      window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}
//--------------------------------------------------------
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
	var	lcosto                   = parseFloat (costo).toFixed(4);
	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		= parseFloat (sal1).toFixed(2);
	
	var	total 		= 0;
  	var	baseiva 	= 0;
	var	tarifa_cero	= 0;
	var	monto_iva 	= 0;
	var tempBase 	= 0;
	var	IVA = 12/100; 
	var	DesgloseIVA = 1 + IVA ; 

	objeto 				=  '#tipo_' + id;
	var tipo_mov1 		= $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	
	/*	baseiva     =  total / DesgloseIVA ;
		monto_iva   =  total   -  baseiva ;
		 total = lcantidad * lcosto;  */
	
	//--- INGRESO
	if (ingreso_egreso == 'I'){
					if (tipo_movimiento == 'I'){
			
						baseiva 	=  parseFloat (lcosto).toFixed(2) *  parseFloat (lcantidad).toFixed(2); 
						monto_iva 	=  baseiva * parseFloat (IVA).toFixed(2);
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
					 	objeto =  '#total_' + id;
 					    $(objeto).val(total);
					}
				 	 	//--------------------------------
				 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id);
  	}
 	else { 
	 	 		 //---------------- egresos 
 				 if ( (saldo * 10) >= (lcantidad *10) ) { 	   
 	 					if (tipo_movimiento == 'I'){
		 	 						baseiva 	=  parseFloat (lcosto).toFixed(2) *  parseFloat (lcantidad).toFixed(2); 
		 							monto_iva 	=  baseiva * parseFloat (IVA).toFixed(2);
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
					 	guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id);
				 	 	
				  }else{
					  alert('Saldo No Disponible');
			 		  objeto =  '#cantidad_' + id;
					  $(objeto).val(0);
				  }
	}
 //------------------------------------------------------------------
 		
	total_factura();	
 
    
}
  
function total_factura(){
	
    var formulario = document.getElementById("fo3");
	var layFormulario            = formulario.elements;
	var lnuElementos             = layFormulario.length;
			
    var CalcularIva             	 = 0;
    var Calculartotal             	 = 0;
    var CalcularBIva             	 = 0;
    var CalcularBase            	 = 0;
                
//	var TIPO_MOVIMIENTO = $('#tipo').val();
	
    
	//if (TIPO_MOVIMIENTO == 'I') {
		
		 	
        for( var xE = 0; xE < lnuElementos; xE++ ){		 
        					var lobCampo            = layFormulario[ xE ];
        					var lstNombre           = lobCampo.name;
                    		var lnuCampo            = lobCampo.value;
        					
        					var layDatosNombre         = lstNombre.split( '_' );
        					var lstCampo               = layDatosNombre[0];
        					    lnuCampo               = parseFloat (lnuCampo); 
        						
        					if (lstCampo == 'total'){
        						Calculartotal =  Calculartotal + lnuCampo;
                             }
               				if (lstCampo == 'baseiva'){
               					CalcularBIva =  CalcularBIva + lnuCampo;
                             }
                            if (lstCampo == 'tarifacero'){
                            	CalcularBase =  CalcularBase + lnuCampo;
                             } 
                            if (lstCampo == 'montoiva'){
                            	CalcularIva =  CalcularIva + lnuCampo;
                              } 
       } 
         
       // total
        Calculartotal = parseFloat(Calculartotal.toFixed(2));  
  	   $('#TotalF').html('<b>'+ Calculartotal + '</b>'); 
       // iva
  	   CalcularIva = parseFloat(CalcularIva.toFixed(2));  
       $('#Iva').html(CalcularIva); 
       // ----
       CalcularBIva = parseFloat(CalcularBIva.toFixed(2));  
       $('#baseI').html(CalcularBIva); 
       // ----
       CalcularBase = parseFloat(CalcularBase.toFixed(2));  
      
     
       
       if (isNaN(CalcularBase)){
    	   $('#Cero').html('0,00');  
        }else{
    	   $('#Cero').html(CalcularBase); 
        }
     
       
   // } 
 
  return true;
}
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

//-----------------
function PictureArticulo(id)
{
 
	var objeto 					 =  '#tipourl_' + id;
	var tipourl 				  = $(objeto).val();
	
	objeto 					 =  '#url_' + id;
	var url 				  = $(objeto).val();	
	
 
	
	var parametros = {
			"tipourl" : tipourl ,
            "url" : url ,
            "id" : 'id' 
	};
	
	$.ajax({
 			 url:   '../controller/Controller-picture_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticulo").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-----------------
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
					 $("#VisorArticulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});

}

//-----------------
function RefSerie(nombre,id)
{
 
 
	 
  $('#idproducto_serie').val(id); 
	 
 
 var cantidad_serie = $('#cantidad_'+id).val(); 
 
 $('#serie').val(cantidad_serie); 
 
 
 inserta_serie();
  

}
//-----------------
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id)
{
  
 
 
	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": ingreso_egreso,
 			"id" : id  
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
//------------------ aprobacion

function aprobacion(  ){

	 
  var id 	 = $('#id_movimiento').val();
  var estado  = $.trim( $('#estado').val() );
  var tipo   = $('#tipo').val();	
  
 
  
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
//---------
function actualiza_serie( idserie,valor ){

	 
	  var id 	 = $('#id_movimiento').val();
	  var estado  = $.trim( $('#estado').val() );
	  
	  var serie_valor  = $.trim( valor );
	  
	  
	  var tipo   = $('#tipo').val();	
	  
	 
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
									 $("#GuardaSerie").html(data);  // $("#cuenta").html(response);
								     
								} 
					});
				} 
 		 
       } 
	 
	}

//-------
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
//-------
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
//--------
//-------
function modalImportar(url){        
	
    
    var id_movimiento = $('#id_movimiento').val();
    var estado  = $('#estado').val();
    var tipo    = $('#tipo').val();
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1024;
    
    var alto = 500;
    
    if ( tipo == 'I') { 
	    if ( estado == 'digitado') { 
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace + '?id='+id_movimiento,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	    
	    }
    }    
    
 }
//------
function modalProducto(url){        
	
    
    var id_movimiento = $('#id_movimiento').val();
    var estado  = $('#estado').val();
    var tipo    = $('#tipo').val();
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1024;
    
    var alto = 500;
 
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace ,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
    
 }


//------------------
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

//--- enlace con la contabilidad //

function enlace_contabilidad(url){        
	
	var idmovimiento1    = $('#id_movimiento').val();
	
	var estado    = $('#estado').val();
	
	var transaccion    = $('#transaccion').val();
	
	var tipo = $('#tipo').val();
   
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
		   		
			
			 
				//-------------------------------------------
			    var posicion_x; 
			    var posicion_y; 
			    var enlace = url + idmovimiento1;
			    var ancho = 1000;
			    var alto = 520;
			    
			    posicion_x=(screen.width/2)-(ancho/2); 
			    posicion_y=(screen.height/2)-(alto/2); 
			    
			     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
			     
		   		}
	   }	
	  }		
	   
   }		 
 
 }

