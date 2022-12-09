 var oTable;
 var oTableArticulo;
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        oTable = $('#jsontable').dataTable(); 
	    
 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
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
					url:   '../model/Model-inv_carga.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
	var fecha = fecha_hoy();
	
	$("#id_cmovimiento").val("");
	
	$("#fecha").val(fecha);
	
 	$("#detalle").val("");
  
	$("#estado").val("digitado");
	
	$("#tipo").val("");
	$("#documento").val("");
	$("#idprov").val("");
	
 
 
	$("#fechaa").val("");
	
	$("#action").val("add");
 
	DetalleMov(0,'add');

	$("#result").html("<b>Agregar Nueva Solicitud</b>");
	
	
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
           
 
         
            var parametros = {
					'estado' : estado , 
                    'tipo' : tipo  ,
                    'fecha1' : fecha1  ,
                    'fecha2' : fecha2
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_carga.php',
				dataType: 'json',
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
                                 	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-inv_carga_ini.php');
     

}
//-----------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_cmovimiento').val(id); 
	  
	DetalleMov(id,action);

}
//-----------------
function acciona(comprobante, estado)
{
 
	$('#estado').val(estado);
	
	  
	 

}
//----------------------
function FormFiltro()
{
 
	$.ajax({
 			 url:   '../controller/Controller-inv_carga_filtro.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFiltro").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltro").html(data);  // $("#cuenta").html(response);
				     
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
 			url:   '../controller/Controller-inv_cargaDet.php',
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
//-------------------------
//----------------------
function InsertaProducto()
{

	var id_movimiento = $('#id_cmovimiento').val();
	
 	var categoria    = $('#detalle').val();
	 
 	var estado  = $.trim( $('#estado').val() );
 	
 	
 	var tipo    = $('#tipo').val();
 	
 	
 	
	if (categoria){
		
		if (estado == 'digitado'){ 
	 
			
						var parametros = {
								"categoria" : categoria ,
				                "id_movimiento" : id_movimiento ,
				                "estado" : estado,
				                "tipo" : tipo,
				                "accion" : 'add' 
						};
					 
				          
						  $.ajax({
								data:  parametros,
								url:   '../model/Model-addcarga.php',
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
    
	
	var estado = $('#estado').val();
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	/// CANTIDAD
	objeto =  '#cantidad_' + id;
	var cantidad =  $(objeto).val();
	var	lcantidad                = parseFloat (cantidad).toFixed(2);
	var	lcosto                   = parseFloat (costo).toFixed(2);
	//----
	var	total; 
	total = lcantidad * lcosto;

	objeto =  '#total_' + id;
	total = parseFloat (total).toFixed(2);
		
	$(objeto).val(total);
	 	
	 //--------------------------------
	guarda_detalle( lcantidad,total,estado, id);
		
	 total_factura();
 
}
  
function total_factura(){
	
    var formulario = document.getElementById("fo3");
	var layFormulario            = formulario.elements;
	var lnuElementos             = layFormulario.length;
			
     var Calculartotal             	 = 0;
                 
 
		 	
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
               			 
       } 
         
       // total
        Calculartotal = parseFloat(Calculartotal.toFixed(2));  
  	   $('#TotalF').html('<b>'+ Calculartotal + '</b>'); 
       // iva
  	  
          
       if (isNaN(CalcularBase)){
    	   $('#Cero').html('0,00');  
        }else{
    	   $('#Cero').html(CalcularBase); 
        }
 
 
  return true;
}
function EliminarDet(id) {
	 
	
	var id_movimiento = $('#id_cmovimiento').val();
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
				url:   '../model/Model-addcarga.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#DivProducto").html('Procesando');
				},
				success:  function (data) {
						 $("#DivProducto").html(data);  // $("#cuenta").html(response);
						 
						 DetalleMov(id_movimiento,'edit');
					     
				} 
		}); 
	 
	
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
function guarda_detalle(lcantidad,total,estado, id)
{
   
	var parametros = {
 			"lcantidad" : lcantidad  ,
			"total" : total  ,
	 		"id" : id  
	};
	
	if (estado == 'digitado'){
		
			$.ajax({
		 			 url:   '../model/Model-editCarga.php',
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

function url_comprobante(url){        
	
	var variable    = $('#id_movimiento').val();
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + variable + '&tipo=53' ;
    
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

