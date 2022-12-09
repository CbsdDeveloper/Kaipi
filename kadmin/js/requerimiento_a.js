var oTable;


 
//-------------------------------------------------------------------------


$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   
  
		$("#MHeader").load('../view/View-HeaderInicioAgenda.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
        FormView();

		EstadoProceso();

	
 
 
});  
  
 
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#id_anticipo").val(id);          
 
 
			historial();

}
//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
		    
			$("#action").val("add");
		   $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b>   AGREGAR NUEVO REGISTRO... VERIFIQUE LA INFORMACION  Y GENERE LA SOLICITUD DE ANTICIPO</b>');
			 
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
SACA FECHA ACTUAL
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
   
	   return  today;      
	} 
/*
LIMPIA LA PANTALLA
*/
function LimpiarPantalla() {
	
	var today = new Date();
 	var mm    = today.getMonth()+1; //January is 0!
 

	    var fecha  = fecha_hoy();
		var sueldo = $("#sueldo").val();

		$("#detalle").val('');
      	$("#id_vacacion").val('');
		$("#fecha").val(fecha);
		$("#motivo").val('');

        $("#razon_g").val('');
		$("#idprov_g").val('');
 		$("#unidad_g").val('');
 		$("#cargo_g").val('');
		$("#motivo").val('');
		$("#sueldo_g").val('0.00');
 
		$("#solicita").val(sueldo);
		$("#plazo").val('1');
		$("#mensual").val('1');
		$("#rige").val(mm);
 
		$("#documento").val('00000-0000');

		
		
 
		$("#estado").val('solicitado');
       
 }
 
/*
CALCULA EL MES QUE RIGE EL ANTICIPO
*/
function  calculaMes( periodo )
{
	
		var solicita = 	$("#solicita").val();

	  var total_base = parseFloat(solicita).toFixed(1)  ;  


	  var numero_mes = parseFloat(periodo).toFixed(1)  ;

	   
	  var total = total_base / numero_mes;


	  var valor_mes = parseFloat(total).toFixed(2)  ;

	  
	  $("#mensual").val(valor_mes);
   
 }
  
/*
ENVIA LA INFORMACION AL FORMULARIO DE INGRESO DE DATOS
*/
function goTocaso(accion,id) {
 
	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	if ( accion == 'del') {
		
		  alertify.confirm("Desea Anular el tramite emitido?", function (e) {
			  if (e) {
 				  
							  $.ajax({
									data:  parametros,
									url:   '../model/Model-pedido_anticipo.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
 											 alert(data);
											  BusquedaGrilla(0,'solicitado');
 				 					} 
							}); 
 				  }
			 });
		
 	}
	else 	{
		
			  $.ajax({
							data:  parametros,
							url:   '../model/Model-pedido_anticipo.php',
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
/*
*/
   
function goTocasot(accion,id) {
 


	

	$("#myModalDocVisor").modal('show');
 
	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	 
		
			  $.ajax({
							data:  parametros,
							url:   '../controller/controller_pedido_anticipo00.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
									$("#ViewFormularioA").html('Procesando');
		 					},
							success:  function (data) {
									 
									 $("#ViewFormularioA").html(data);   
									  
		 					} 
					}); 
	 
 
   }
  /*
  */
    
function goTocasof(accion,id) {
 


	

	$("#myModalDocFin").modal('show');
 
	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	 
		
			  $.ajax({
							data:  parametros,
							url:   '../controller/controller_pedido_anticipo01.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
									$("#ViewFormularioF").html('Procesando');
		 					},
							success:  function (data) {
									 
									 $("#ViewFormularioF").html(data);   
									  
		 					} 
					}); 
	 
 
   } 
//----------------
function BusquedaGrilla(idproceso, estado){        	 
   
  	  $("#vestado").val(estado);
 
   var parametros = {
				'idproceso' : idproceso  ,
				'estado' : estado 
      };
	  

 
    jQuery.ajax({
		data:  parametros, 
	    url: '../grilla/grilla_anticipo.php',
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
 
 
		historial();

	
}   

//----------------
function BusquedaGrillaT(idproceso, estado){        	 
   
	$("#vestado").val(estado);

	$("#bandera1").val(estado);

var parametros = {
			'idproceso' : idproceso  ,
			'estado' : estado 
  };
  
 
jQuery.ajax({
	data:  parametros, 
	url: '../grilla/grilla_anticipo.php',
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
						   '<button class="btn btn-xs btn-danger" title="VERIFICAR PROCESO DE SOLICITUD" onClick="goTocasot('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-cog"></i></button> ' 
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
//----------------
function BusquedaGrillaF(idproceso, estado){        	 
   
	$("#vestado").val(estado);

	$("#bandera1").val(estado);

var parametros = {
			'idproceso' : idproceso  ,
			'estado' : estado 
  };
  
 
jQuery.ajax({
	data:  parametros, 
	url: '../grilla/grilla_anticipo.php',
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
						   '<button class="btn btn-xs btn-danger" title="VERIFICAR PROCESO DE SOLICITUD" onClick="goTocasof('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-cog"></i></button> ' 
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
	 
	$("#ViewEstado").load('../controller/controller_estado_anticipo.php');
 
 } 
 
//-----------------
 function FormView()
 {
     
    	 
    	 $("#ViewFormularioTarea").load('../controller/controller_pedido_anticipo.php');
    	 
 
 }
 //-----------------
 function openView(url){        
		
	 
	   
	    var posicion_x; 
	    var posicion_y; 
	    var enlace = url  
	    var ancho = 1000;
	    var alto = 420;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
	 }

/*
02.  llamada a formulario de datos
*/
 function  enviar_notificacion(  )
 {


  
 	   var id_anticipo = 	$("#id_anticipo").val();
		
	   var estado = 	$("#estado").val();

 	   var parametros = {
					'id': id_anticipo,
					'accion': 'envio',
					'estado' : estado
			};
  
 
			alertify.confirm("<p>DESEA ENVIAR LA SOLCITUD DE ANTICIPO DE SUELDOS?</p>", function (e) {

				if (e) {
					$.ajax({
						data:  parametros,
						url:   '../model/Model-pedido_anticipo.php',
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
			   }); 



	  
		
		 
  }
 
  
//------------
function openFile(url,ancho,alto) {
    
	  var id = $("#id_anticipo").val();
		 
	  var documento = $("#documento").val();

	  var parametros = {
		"id" : id,
		"documento" : documento 
	  };
 
	  if ( documento == '00000-0000'){
			$.ajax({
					type:  'GET' ,
					data:  parametros,
					url:   '../model/ajax_secuencia_anticipo.php',
					dataType: "json",
					success:  function (response) {
							$("#documento").val( response.a );  
					} 
			});
		}
 
	  var posicion_x; 
	  var posicion_y; 
	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 
	  posicion_y=(screen.height/2)-(alto/2); 
	  enlace = url+'?id='+id  ;
	 
	  if ( id) {

		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}

 //---------------------------
 function  solicita_valida(  )
 {
	 
 
 	   var idproceso = 	$("#codigoproceso").val();
		
  	   
		var parametros = {
 		           'idproceso': idproceso
			};
  
		$.ajax({
			    type:  'GET' ,
				data:  parametros,
				url:   '../model/Valida_user_solicita.php',
				dataType: "json",
				success:  function (response) {
 					
						 $("#idprov").val( response.a );  
						 
						 $("#razon").val( response.b );  
						  
				} 
		});
        
  }
  /*
  proceso para enviar el tramite
  */
  function  proceso_a( accion  )
  {
	  
 	    var tipo     = 	$("#bandera1").val();
		var id 	 	 =  $("#vid_anticipo").val();
		var novedad  =  $("#comentario").val();
		 
		  
		 var parametros = {
					 'id': id,
					 'novedad': novedad,
					 'accion' : accion,
					 'tipo': tipo
			 };
   
	     

	   alertify.confirm("<p>Desea procesar esta accion de <b> " + accion + "</b> el tramite...</p>", function (e) {
				if (e) {
					  
							$.ajax({
								type:  'GET' ,
								data:  parametros,
								url:   '../model/ajax_envio_anticipo.php',
								success:  function (response) {
										alert(response);
								} 
							});
		  
							$("#myModalDocVisor").modal('hide');
							EstadoProceso();
							BusquedaGrilla(0,'solicitado')
					 }
			   }); 
 
   }
 //-------------
 function  proceso_control( accion  )
  {
	  
 	    var tipo     = 	$("#bandera1").val();
		var id 	 	 =  $("#vid_anticipo").val();
		var novedad  =  $("#comentario").val();
	    var id_usuarioe  =  $("#id_usuarioe").val();
		 
		 
		  
		 var parametros = {
					 'id': id,
					 'novedad': novedad,
					 'accion' : accion,
					 'tipo': tipo,
					 'id_usuarioe':id_usuarioe
			 };
   
	     

	   alertify.confirm("<p>Desea procesar esta accion de <b> " + accion + "</b> el tramite...</p>", function (e) {
				if (e) {
					  
							$.ajax({
								type:  'GET' ,
								data:  parametros,
								url:   '../model/ajax_control_anticipo.php',
								success:  function (response) {
										alert(response);
								} 
							});
		  
							$("#myModalDocFin").modal('hide');
							EstadoProceso();
							BusquedaGrilla(0,'solicitado')
					 }
			   }); 
 
   }  
 //-------------- pone documento para revision
 function  historial()
 {
	 
 

	var today = new Date();
 	var anio  = today.getFullYear();

 
	var prove =  $("#idprov").val();
	
	var cuenta  =  '112.%';
	var bandera =  'N';

	var parametros = {
			   'anio' : anio  ,
			   'cuenta' : cuenta   ,
			   'prove' : prove  ,
			   'bandera' : bandera   
	 };
	
	
	$.ajax({
		  data:  parametros,
		  url:   '../../kcontabilidad/model/Model_listaAuxq_anticipo.php',
		  type:  'GET' ,
		  beforeSend: function () { 

				  $("#ViewFormulariohis").html('Procesando');

		  },
		  success:  function (data) {
			   $("#ViewFormulariohis").html(data);   

		  } 
  });	 

	
 
  }
 