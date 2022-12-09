var oTable;


 
//-------------------------------------------------------------------------


$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   

    	
	  
		$("#MHeader").load('../view/View-HeaderInicioAgenda.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
     
     	FormView();
     
		EstadoProceso();
		
		 DetalleMov(0,'add');
 
 
});

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
					 $("#DivMovimiento").html(data);   
				     
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
		
		if (estado == 'solicitado'){ 
	 
			
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

//--------------------------------------------------------
function calcular(id) {
    
	
	var estado 			= $('#estado').val();
 	var ingreso_egreso 	= $('#tipo').val();
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	var	lcosto                   = parseFloat (costo).toFixed(6);

	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		=  parseFloat (sal1).toFixed(2);
	
	objeto 			=   '#cantidad_' + id;
	var cantidad 	=   $(objeto).val();
	var cantidad 	=   parseFloat (cantidad).toFixed(2);
 

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
		
 
 
    
}
//-------

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
 
//-----------------------

function aprobacion(  ){

	 
  var id 	 = $('#id_movimiento').val();
  var estado  = $.trim( $('#vestado').val() );
  var tipo   = 'E';
  
 
  
  var mensaje =  confirm("¿Desea enviar la transacción?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"id" : id   ,
	 			"accion" : 'aprobacion',
	 			"tipo"   : tipo
		};
		
		if (estado == 'solicitado'){
			
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
//------------------------

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
				url:   '../model/Model-addproductoe.php',
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
//-------------------AsignaBodega
function AsignaBodega()
{
    var  idbodega     = $("#idbodega").val();
   
    var parametros = {
            'idbodega' : idbodega 
    };
    
    
	$.ajax({
 			 url:   '../../kinventario/model/ajax_bodega.php',
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
 
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#idcaso").val(id);          
 
			  $('#mytabs a[href="#tab2"]').tab('show');

}
//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
		
	  if (e) {
		      
			$("#action").val("add");
			
		    $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b> ]  AGREGAR NUEVO REGISTRO</b>');
			 
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
//ir a la opcion de editar
function LimpiarPantalla() {
	
 
	var fecha = fecha_hoy();
	
    
	$("#idbodega").val('');
	
	$("#id_movimiento").val("");
	
	$("#fecha").val(fecha);
	
 	$("#detalle").val("");
 	$("#comprobante").val("");
	$("#estado").val("solicitado");
	
 
	$("#idproducto").val("");
 	$("#articulo").val("");
 
 	
	$("#action").val("add");
 
//	DetalleMov(0,'add');
   
 
 
	 
 }
 
 

//----------------------------------------------------
function goTocaso(accion,id) {
 
    
    var estado      =    $("#vestado").val();
 
   var resultado = Mensaje( accion ) ;
		
	  
		
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
 
	if ( accion== 'del') {
		
		if ( estado == 'solicitado'){
			
				  alertify.confirm("Desea Anular el tramite emitido?", function (e) {
					  if (e) {
		 				  
									  $.ajax({
											data:  parametros,
											url:   '../model/Model-inv_movimientoe.php',
											type:  'GET' ,
											cache: false,
		 									success:  function (data) {
		 											 alert(data);
 		 				 					} 
									}); 
		 				  }
					 });
					 
					 BusquedaGrilla( 1 );
		}	 
 	}
	else 	{
		
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
	 
 		 
		 DetalleMov(id,'edit');
		  
	 	$('#mytabs a[href="#tab2"]').tab('show');
	 }
	 
	 
   }
//----------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}   
//----------------
function BusquedaGrilla( estado){        	 
   
 
 if ( estado== '1'){
	$("#vestado").val('solicitado');
}
  if ( estado== '2'){
	$("#vestado").val('digitado');
}
 if ( estado== '3'){
	$("#vestado").val('aprobado');
}
  
  
  
 
 
   var parametros = {
 				'estado' : estado 
      };
	  

 
    jQuery.ajax({
		data:  parametros, 
	    url: '../grilla/grilla_requerimiento_b.php',
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
  	                     	'<button class="btn btn-xs btn-warning" title="Visualizar Tramite" onClick="goTocaso('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
							'<button class="btn btn-xs btn-danger" title="Anular Tramite" onClick="goTocaso('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-warning-sign"></i></button>' 
						]);										
					} // End For
		}						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			
   		

		});
 
 

	
}   
//-------------------------------------------------------------------------  
 function modulo()
 {
 	 var modulo1 =  'kcrm';
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
01. Estado de los procesos
*/

function EstadoProceso()
 {
	 
 	var parametros = {
			
                     'accion' : '1' 
 	  };
 
		  $.ajax({
						url:   '../controller/Controller-proceso_estado04.php',
						type:  'GET' ,
					    data:  parametros,
						cache: false,
						success:  function (data) {
								 $("#ViewEstado").html(data);   
							     
	  					} 
				}); 
 
 } 
 
//-----------------
 function FormView()
 {
     
    	 
    	 $("#ViewFormularioTarea").load('../controller/Controller-requerimiento_b.php');
    	 
 
 }
 
//------------------------
function goToURLDocdel(idcodigo,idcaso) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'idcaso'   : idcaso  
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-caso__doc_tra.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
//------------
function openFile(url,ancho,alto) {
    
	  var idcaso = $("#idcaso").val();
		 
	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+idcaso  ;
	 
	  if ( idcaso) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
 
 