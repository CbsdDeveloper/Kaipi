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
//------------------------
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
//-----------------------------------------------------------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {
 

	   var resultado = Mensaje( accion ) ;
		
	  
		
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };

		$.ajax({
			  url:   '../model/Model-inv_movimientoe.php',
			  type:  'GET' ,
			  data:  parametros,
			  dataType: 'json',  
		}).done(function(respuesta){
	 			
			$("#id_movimiento").val(respuesta.id_movimiento);
			$("#fecha").val(respuesta.fecha);
			
		 	$("#detalle").val(respuesta.detalle);
		 	$("#comprobante").val(respuesta.comprobante);
			$("#estado").val(respuesta.estado);
			
			$("#tipo").val(respuesta.tipo);
			$("#documento").val(respuesta.documento);
			$("#idprov").val(respuesta.idprov);
			
			$("#razon").val(respuesta.razon);
			$("#id_departamento").val(respuesta.id_departamento);
			$("#idbodega").val(respuesta.idbodega);
			
			
		 
			$("#fechaa").val(respuesta.fechaa);
	 			 						
					$("#action").val(accion); 
				    $("#result").html(resultado);
	 	 
		 
		});
	 
		 AsignaBodega1();
		 
		 DetalleMov(id,'edit');
		  
	 	$('#mytabs a[href="#tab2"]').tab('show');
 
 
	  
	  
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
            
            var id_departamentoe = $("#id_departamentoe").val();
           
 
         
            var parametros = {
					'estado' : estado , 
                    'tipo' : tipo  ,
                    'fecha1' : fecha1  ,
                    'fecha2' : fecha2,
                    'idbodega1':idbodega1,
                    'id_departamentoe' : id_departamentoe
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_movimientose.php',
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
			
			AsignaBodega1();
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
 

	 var moduloOpcion =  'kcms';
		 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-inv_movimientoe.php');
     
	 
 
	 

}
 
//----------------------
function FormFiltro()
{
 
	
	 $("#ViewFiltro").load('../controller/Controller-inv_movimientoe_filtro.php');
	 
	 

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
//-----------------------
//-------------------AsignaBodega
function AsignaBodega1()
{
    var  idbodega     = $("#idbodega1").val();
   
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
 			url:   '../controller/Controller-inv_movimientoDet_e.php',
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
								url:   '../model/Model-addproductoe.php',
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
//----------------------------
function RedondeaDosDecimal(num) {    
	 return +(Math.round(num + "e+2")  + "e-2");
	}
//--------------------------------------------------------
function calcular(id) {
    
	
	var estado 			= $('#estado').val();
 	var ingreso_egreso 	= $('#tipo').val();
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	var	lcosto                   = parseFloat (costo).toFixed(4);

	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		=  parseFloat (sal1).toFixed(2);
	
	objeto 			=   '#cantidad_' + id;
	var cantidad 	=   $(objeto).val();
	var cantidad 		=  parseFloat (cantidad).toFixed(2);
 

	objeto 				=  '#tipo_' + id;
	var tipo_mov1 		= $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	
 
	if(parseInt(cantidad) > parseInt(saldo)){
		
		  alert('Saldo No Disponible');
 		  objeto =  '#cantidad_' + id;
 		  $(objeto).val(0);
 		  
	}else{
		
		 
		    baseiva     =   0 ;
		    monto_iva   =   0;
		    
			tarifa_cero 	=   lcosto * cantidad	;
 			tempBase  		=   lcosto * cantidad;
			total 			=   parseFloat (tempBase).toFixed(2);
		 
			objeto =  '#total_' + id;
			total = parseFloat (total).toFixed(2);
			$(objeto).val(total);
			
			guarda_detalle(baseiva,monto_iva,tarifa_cero,cantidad,total,estado,ingreso_egreso,id,0,0);
			
			
	}
		
	total_factura();	
 
    
}
 
//-------------------------------------------------------

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
 
	         
			});
 
	 	
	 	Calculartotal = parseFloat(Calculartotal.toFixed(2));  
	 	
	    $('#TotalF').html('<b>'+ Calculartotal + '</b>'); 
	   
	    
 
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
            "id" : id 
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
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,p1,descuento)
{
  
 
 
	 
	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": ingreso_egreso,
 			"id" : id ,
 			"p1": 0,
 			"descuento":0	
	};
	
 
		
 
		
			$.ajax({ 
		 			url:   '../model/Model-editproductoe.php',
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
			 			 url:   '../model/Model-inv_movimientoe.php',
			 			data:  parametros,
						type:  'GET' ,
						dataType: 'json',  
						success:  function (data) {
							  $('#result').html(data.resultado);
			 				  $( "#result" ).fadeOut( 1600 );
			 			 	  $("#result").fadeIn("slow");

			 			 	  $("#action").val(data.accion); 
			 			 	  $("#id_movimiento").val(data.id );

			 			 	  $("#estado").val(data.estado); 
			 			 	  $("#comprobante").val(data.comprobante );
							     
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
//------
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
 
