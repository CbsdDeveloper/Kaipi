var oTableProducto;

var oTable;

var formulario = 'compromiso';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	    
	     
	        oTable 	= $('#jsontable_partida').dataTable( {      
	            searching: true,
	            paging: true, 
	            info: true,         
	            lengthChange:true ,
	            aoColumnDefs: [
	   		      { "sClass": "highlight", "aTargets": [ 0 ] },
	  		      { "sClass": "ye", "aTargets": [ 3 ] },
	  		      { "sClass": "de", "aTargets": [ 4 ] }
 	  		    ] 
	       } );
	        
	     
 	     
	     modulo(); 
          
         FormView();
      
		 $("#MHeader").load('../view/View-HeaderModel.php');
	
		 $("#FormPie").load('../view/View-pie.php');
	      
  
		//-------------- BANDEJA DE ENTRADA DE DOCUMENTOS  
		 
	  	BusquedaGrilla('','2','2. Autorizado x Emitir Certificacion',0);
	 
	  	
		$("a[rel='pop-up']").click(function () {
	      	var caracteristicas = "height=500,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
	      	nueva=window.open(this.href, 'Popup', caracteristicas);
	      	return false;
		 });
		
		 $('#loadSaldosg').on('click',function(){
			SaldoPresupuesto('G') ;
	});
 
  
});  

//-------------------------------
function impresion_orden_pago()
{

	
	// enlace,codigo_x1
	
var enlace = '../../kcontabilidad/reportes/ficheropagoorden?a=';	

 var id_asiento  = document.getElementById('idasiento1').value;  
  

  enlace = enlace +id_asiento;
  
  if (id_asiento){

		  alertify.confirm("Desea generar la orden de pago?", function (e) {
		
			    if (e) {
		
			    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
			    	  
			     }
		
			 }); 
  }	
 
}	
function modalVentana(url){        
		
	    
	    var posicion_x; 
	    var posicion_y; 
	      
	    var enlace = '../../kcontabilidad/view/' + url ;
 
	  
	    
	    
	    var ancho = 1000;
	    
	    var alto = 475;
	    
	   
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
	 }
//-------------------------------------------------------------
 function accion(id,modo,visor)
{
  
			$("#action").val(modo);
			
			$("#id_tramite").val(id);          

		if ( visor == 0 ){
			
			BusquedaGrilla('','1','1. Requerimiento Solicitado',1);
			
		}
			

}
//------------------------
 function VerHistorialUni( id_tramite, nombre,solicitado,estado )
 {
   
 	
 	     $("#estado1").val(estado);
 	   
 	     var nombre_estado ='';
 		 
   
 	    $("#nombre_actual").html('<b>' + ' [ Seleccionar cliente ] </b>');
		 
 	   
		 $('#p1_nuevo').attr("disabled", true);
		 $('#p1_savec').attr("disabled", true);
		 $('#p1_print_c').attr("disabled", false);
		 $('#p1_savecc').attr("disabled", true);
		 
		 if ( estado == '2') {
			 $('#p1_nuevo').attr("disabled", false);
			 $('#p1_savec').attr("disabled", false);
			 
 
			
			 nombre_estado = '2. Tramites Autorizado';	
		 } 

		 if ( estado == '3') {
			 $('#p1_nuevo').attr("disabled", false);
			 $('#p1_savec').attr("disabled", false);
			 $('#p1_savecc').attr("disabled", false);
 
			 
			 nombre_estado = '3. (*) Emision Certificacion';
		 } 
	 
		 if ( estado == '5') {
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p1_savec').attr("disabled", true);
			 $('#p1_savecc').attr("disabled", false);
			 
 
			 
			 nombre_estado = '5. Emitir Compromiso';
		 } 
	 
		  $("#etiqueta_estado").html('<b>' +nombre_estado + '</b>');
 	     
 	     $("#idtramite1").val(id_tramite);
 	     $("#solicita1").val(solicitado);
 	     $("#nombre").val(nombre);
 	 	 
 	     $("#id_tramite_prod").val(id_tramite);
 	     $("#mensaje_proceso").html(' ');
 	 	 $("#nombre_actual").html('<img src="../../kimages/mano.png" align="absmiddle"/> <b>[ '+id_tramite+ '-' + nombre +' - ' + solicitado +' ] </b>');
 		
 	 	VerMemo(id_tramite);
 	 		
 	 	BusquedaProd(oTable,id_tramite) ;
 	 
 	    VerAvance(id_tramite);
 	 	
 	     $("#Viewdetalle").html('');   
 		 $("#estado_parcial").val('-');  
  	

 }  
//-------------------------------------------------------------
 function accion_producto(id,modo,visor)
{
  
 	 
     		var id_tramite = $("#id_tramite_prod").val();
     
			$("#actionProducto").val(modo);
			
			$("#id_tramite_deta").val(id);          

			if ( visor == 0 ){
				
				BusquedaProd(oTable,id_tramite);
				
				$('#myModalProducto').modal('hide');
				
			}
			

}
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
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToURLEditor( accion,id_tramite, user_sol, nombre) {
	
	// $eventoGo =  ' onClick="'.'goToURLEditor('."'".$accion."',"."'".$id_tramite."',".$user_sol.','.$nombre.')" ';
	 	
	  $("#idtramite1").val(idtramite1) ;
	  $("#idtramite").val(idtramite1) ;
	  
	  $("#action").val(accion);
	  $("#solicita1").val(user_sol);
	  $("#nombre").val(nombre);
	  
 	    
	   
	var parametros = {
					 'id_tramite'     : id_tramite ,
                     'accion'        : accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-certificacion.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 						    	$("#result").html('Procesando');
  					},
					success:  function (data) {
 
							    $("#result").html(data);
 							
  					} 
			}); 

	  $('#myModal').modal('show');  
	  
	  
	  
    }
///////////////
function PonePartida(fuente)
{
	    var  clasificador     = $("#grupo").val();
	    var  actividad        = $("#actividad").val();
 	    var  programa  = $("#programa").val();
	    
	    var parametros = {
	            'fuente'       : fuente ,
	            'clasificador' : clasificador ,
	            'actividad' : actividad ,
	            'programa' : programa
	    };
	    
	   

 
	    
	    $.ajax({
			data: parametros,
			url: "../model/Model_busca_partida.php",
			type: "GET",
			success: function(response)
			{
					$('#partida').html(response);
			}
		});


}
//----------------------------------
function BusquedaCliente( ){        	 
	 
	 
	 var estado 	=  $("#estado1").val();
	 var qbusqueda  =  $("#qbusqueda").val();
	 var qtramite   =  $("#qtramite").val();
	 
	 var qdetalle  =  $("#qdetalle").val();
	 var qmes      =  $("#qmes").val();
	 
		 
	 
	    var parametros = {
				 'estado' : estado,
				 'qbusqueda' : qbusqueda,
				 'qtramite' : qtramite,
				 'qdetalle': qdetalle,
				 'qmes':qmes,
				 'pagina': 0
	   };
	    
	   
	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-BusquedaTramiteUni.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
	 	

		 
		 $("#pag").val(0);
		
		 $("#nombre").val('');
  
		 $("#ViewAvancedias").html('');  
		 $("#ViewAvance").html('');  
		 
	 
		 $("#qbusqueda").val('');
 		 $("#qtramite").val('');
 		 
		 $("#qdetalle").val('');
 		 $("#qmes").val('-');
		 
 
		 
	
}  
//----------------
function goToURLProd( accion,idcodigo ) {
	
	 
	var id_tramite = $("#idtramite1").val();
	
    var parametros = {
				 'id_tramite_det'     : idcodigo ,
	             'accion'        : accion
	};
	
 

		//--------------------------
    
		  alertify.confirm("Desea Eliminar partida", function (e) {
			  
			  if (e) {
				 
						  $.ajax({
								data:  parametros,
								url:   '../model/Model-certificacion_partida.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
									    	$("#guardarProducto").html('Procesando');
									},
								success:  function (data) {
					
										    $("#guardarProducto").html(data);
										    
										    alert('No se olvide de revisar los saldos por partida');
										    
										    BusquedaProd(oTable,id_tramite);
										
									} 
						}); 
			    
	                     
			  }
			 }); 
		
 

    }
//-------------------------
function goTodel( accion,idcodigo ) {
	
	  var idvengestion = $("#idvengestion_pro").val();
		   
		var parametros = {
						'id' : idcodigo ,
	                    'accion': accion
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-ven_doc_cli.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 						    	$("#guardarProducto").html('Procesando');
	  					},
						success:  function (data) {
	 
								    $("#guardarProducto").html(data);
	 							
	  					} 
				}); 
		  
		  $("#guardarProducto").html('Agregue los productos que va a realizar la venta');
		   
		//  BusquedaDoc(oTableProducto,idvengestion);
			 

	    }


//---------------- goToURLpartida -- 
function goToURLmonto(  codigo ) {
	
	var estado     =   $("#estado1").val();
	
	var idtramite1 =   $("#idtramite1").val();
	
 
	
	 if ( estado == '3') {
		 
		 var parametros = {
				 'id_tramite_det'     : codigo  
	    };

		 $.ajax({
				data:  parametros,
				url:   '../model/Model-certificacion_partida_monto.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						    	$("#guardarProducto").html('Procesando');
					},
				success:  function (data) {
 						    	$("#guardarProducto").html(data);
 							
					} 
		}); 

		    BusquedaProd(oTable,idtramite1) ; 
	 }
	 
}
function goToURLpartida(  codigo ) {
	
	var estado =   $("#estado1").val();
	  
	var bandera  =   0;
 	
	 if ( estado == '2') {
		 bandera = 1;
 		$('#certificado').attr('readonly', false);
 		$('#compromiso').attr('readonly', true);
	 }
	 
	 if ( estado == '3') {
		  bandera = 1;
	 	  $('#certificado').attr('readonly', false);
	 	  $('#compromiso').attr('readonly', false);
	 }
		
	 if ( estado == '5') {
		  bandera = 1;
	 	  $('#certificado').attr('readonly', false);
	 	  $('#compromiso').attr('readonly', false);
	 }
  
  if ( bandera == 1) {
		 
		 
	
		 var parametros = {
						 'id_tramite_det'     : codigo ,
	                     'accion'        	  : 'editar'
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-certificacion_partida.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 						    	$("#guardarProducto").html('Procesando');
	  					},
						success:  function (data) {
	 
								    $("#guardarProducto").html(data);
								    
								     
	 							
	  					} 
				}); 
	
		  $('#myModalProducto').modal('show');  
		 
  }
		
}

//----------------------------------------
function VerAvance(idtramite) {


	var parametros = {
                     'idtramite' : idtramite ,
                     'accion':1
 	  };
	
	   $.ajax({
					data:  parametros,
					url:   '../model/Model-avance_certificado.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewAvance").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewAvance").html(data);  
						     
  					} 
			}); 

	  //-----------------------------
	  var parametros1 = {
              'idtramite' : idtramite ,
              'accion':2
		};
			  
			  $.ajax({
					data:  parametros1,
					url:   '../model/Model-avance_certificado.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#ViewAvancedias").html('Procesando');
					},
					success:  function (data) {
							 $("#ViewAvancedias").html(data);  
						     
					} 
			}); 
	  
	 
  }

//------------
function PaginaGrilla(signo){        	 
	  
	  
	   var estado       = $("#estado1").val();
	   
	   var acumula		= $("#pag").val();
	   
	   var pagina 		= parseInt(acumula) ;
	   
	   if (signo  > 0 ){  
		   pagina = pagina + 12 ;
	   }else { 
		   pagina = pagina - 12 ;
	   }
	   
	   var acumula		=parseInt(pagina) ;
	   
	   //------------------------------------------	   
	   $("#pag").val(acumula );
	   
	   if ( pagina < 0 ) { 
		   $("#pag").val(0);
	   }
	   //------------------------------------------ 
	    
	    var parametros = {
				 'estado' : estado,
				 'pagina': pagina
	   };
	    
	 //VerHistorial
	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-BusquedaTramite.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
	
}    
 
//--------------
function htmlEntities(str) {
	  var map =
	    {
	        '&amp;': '&',
	        '&lt;': '<',
	        '&gt;': '>',
	        '&quot;': '"',
	        '&#039;': "'"
	    };
	    return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
	
	}
//-----------------------------
function GenerarCertificacion(){
	
	
  var estado 	 =   $("#estado1").val();
  var idtramite1 =   $("#idtramite1").val();
  
  var fcertifica =   $("#fcertifica").val();
//  var comprobante=   $("#comprobante").val();
  
  
  var parametros = {
			 'idtramite' : idtramite1 ,
			 'fcertifica' : fcertifica
  };
  
  
  if ( estado == '2'){
	  
	  	if (fcertifica){
 		  		 
					  
		  			alertify.confirm("<p>Desea generar la certificacion <br><br></p>", function (e) {
							
					 	  if (e) {
										
										        $.ajax({
														data:  parametros,
														url:   '../model/Model_emite_certificacion.php',
														type:  'GET' ,
														cache: false,
														success:  function (data) {
 																 
																 if ( data == '0' ){ 
																	 
																	  alert('COMPROBANTE NO EMITIDO VERIFIQUE PERIODO' + data);
																	  
																 }else{
																	 
																	   alert('Nro. Comprobante emitido ' + data);
																	 
																 	    $("#comprobante").val( data );   
																 	    
																 	    BusquedaGrilla('','3','3. Certificacion Presupuestaria',0);
																
																 	    $('#mytabs a[href="#home"]').tab('show');
																 	    
																 }
																	 	
									 							
																 
									  					} 
												}); 
									 		  }
									  
							 });
 	  		}else{
	  			
	  			 alert('Tramite ingrese la FECHA DE LA CERTIFICACION ' + idtramite1);
	  		}
	   }
		 
}
//---------------------------
// ()
//----------------------------
function GenerarCompromiso(){
	
	
	  var estado 	 =   $("#estado1").val();
	  var idtramite1 =   $("#idtramite1").val();
	  
	  var fcompromiso=   $("#fcompromiso").val();
	  var comprobante=   $("#comprobante").val();
	  
	  var idprov =   $("#idprov").val();
	   
	  var valida = idprov.trim();
	  
	  var n = valida.length;
 
 
	  
	  var parametros = {
				 'idtramite' : idtramite1 ,
				 'fcompromiso' : fcompromiso 
	  };
	  
 
	  
	  if ( n > 8 ){
		  
 	  
		  	if ( estado == '3'){
		  
		  			if (fcompromiso){
			  		
 			  			alertify.confirm("<p>Desea Comprometer los recursos <br><br></p>", function (e) {
								
			  							if (e) {
														
														        $.ajax({
																		data:  parametros,
																		url:   '../model/Model_emite_compromiso.php',
																		type:  'GET' ,
																		cache: false,
																		success:  function (data) {
													 
																			var str = data;
 																			
																			 if (str.trim() == '0' ){ 

																				Swal.fire({
																					title: 'Error!',
																					html: 'No se pudo emitir el compromiso! <br> El año del compromiso no corresponde al periodo de ejecución',
																					icon: 'error',
																					confirmButtonText: 'Entendido'
																				  })
																				 
																				//   alert('COMPROBANTE NO EMITIDO VERIFIQUE PERIODO / ASIGNE MONTO COMPROMETIDO ' + str);
																				  
																			 } else if (str.trim() == '2' ){ 

																				Swal.fire({
																					title: 'Error!',
																					html: 'No se pudo emitir el compromiso! <br> No se ha establecido el Beneficiario',
																					icon: 'error',
																					confirmButtonText: 'Entendido'
																				  })
																				 
																				//   alert('COMPROBANTE NO EMITIDO VERIFIQUE PERIODO / ASIGNE MONTO COMPROMETIDO ' + str);
																				  
																			 } else if (str.trim() == '3' ){ 

																				Swal.fire({
																					title: 'Error!',
																					html: 'No se pudo emitir el compromiso! <br> No se ha establecido el Número de documento.',
																					icon: 'error',
																					confirmButtonText: 'Entendido'
																				  })
																				 
																				//   alert('COMPROBANTE NO EMITIDO VERIFIQUE PERIODO / ASIGNE MONTO COMPROMETIDO ' + str);
																				  
																			 } else if (str.trim() == '4' ){ 

																				Swal.fire({
																					title: 'Error!',
																					html: 'No se pudo emitir el compromiso! <br> No se ha asignado monto a comprometer en ninguna partida.',
																					icon: 'error',
																					confirmButtonText: 'Entendido'
																				  })
																				 
																				//   alert('COMPROBANTE NO EMITIDO VERIFIQUE PERIODO / ASIGNE MONTO COMPROMETIDO ' + str);
																				  
																			 } else{
																				 
																				//    alert('Comprobante para generar el devengado! ' + str);

																				   Swal.fire({
																					title: 'Listo!',
																					html: 'Compromiso Generado con Éxito! <br> Ahora puede imprimir el comprobante.',
																					icon: 'success',
																					confirmButtonText: 'Ok'
																				  })
																				 
			 																 	    BusquedaProd(oTable,idtramite1); 
																			 	    
																			 	    BusquedaGrilla('','5','5. Compromiso Presupuestario',0);
																			
																			 	    $('#mytabs a[href="#home"]').tab('show');
																			 	    
																			 }
																			 
 																				
													 							
													  					} 
																}); 
													}
										  
								 });
			  		   }
   			            else {
   			            			alert('REGISTRE FECHA DE COMPROMISO AUTORIZADA ');
   			           }
	  
			   } else {
				   alert('ESTADO NO VALIDA PARA LA TRANSACCION' );
			   }
	    }
	  else {
		   alert('REGISTRE EL BENEFICIARIO DEL TRAMITE' );
	   }
 
    }
//---------------------------------------------------------------------
function VerHistorial( id_tramite, nombre,solicitado )
{
  
 
 
     $("#idtramite1").val(id_tramite);
     $("#solicita1").val(solicitado);
     $("#nombre").val(nombre);
 	 
     $("#id_tramite_prod").val(id_tramite);
     $("#mensaje_proceso").html(' ');
     $("#Viewdetalle").html('');   
	 $("#estado_parcial").val('-');  
	 
	 
	 
 	 $("#nombre_actual").html('<img src="../../kimages/mano.png" align="absmiddle"/> <b>[ '+id_tramite+ '-' + nombre +' - ' + solicitado +' ] </b>');
	
 	 //----- pone fechas de proceso
 	 VerMemo(id_tramite);
 		
 	 //----- poner partidas
 	 BusquedaProd(oTable,id_tramite) ;
 
 	 //----- numero de dias que pasa el tramite
     VerAvance(id_tramite);
 	
     //---------- pone tramite
     goToURLEditor_visor( 'editar',id_tramite, nombre, solicitado);
	  
     //--------
	 Ver_doc_tramite(id_tramite);
	 
} 
//--------------------------------------
function PoneDoc(file)
{
 
   
	  
    var url = '../../archivos/doc/' + file;

    var parent = $('#DocVisor').parent(); 
    $('#DocVisor').remove(); 
    
    var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
    parent.append(newElement); 
   	 
     $('#DocVisor').attr('src',url); 	
  	
}
//----------------------------------
function Ver_doc_tramite(id) {

	 
    var parametros = {

					'id' : id  ,
					'accion' : 'consulta'  
 
	  };

	  $.ajax({

					data:  parametros,

					url:   '../../upload/Model-pre_doc.php',

					type:  'GET' ,
 
					success:  function (data) {

							 $("#ViewFormfile").html(data);   

 
 					} 

			}); 


   }
//---------------------------------------------------------
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
// ir a la opcion de editar
function LimpiarPantalla() {
   
	var fecha = fecha_hoy();
	
	 
 	$("#fecha").val(fecha);
 	$("#id_tramite").val("");
 	$("#solicita").val("");
 	$("#detalle").val("");
 	
 	$("#sesion_asigna").val("");
  	$("#comprobante").val("");
 	$("#estado").val("");
  	$("#documento").val("");
 	$("#id_departamento").val("");
  	$("#planificado").val("");
 	
    }
//-------------
function LimpiaDatosPartida() {
	   
	   
	 
 	$("#base").val(0);
 	$("#iva").val(0);
 	$("#certificado").val(0);
 	 
    }

//-------------
function limpiaAux() {
	   
 
    var idtramite1 =   $("#idtramite1").val();
   	 
    $("#estado_parcial").val('-');  
    
     var parametros = {
			 'idtramite' : idtramite1 ,
             'accion' 		: 'visor'
   };

	$.ajax({
	    type:  'GET' ,
		data:  parametros,
		url:   '../model/Model_certificacion_user.php',
		dataType: "json",
		success:  function (response) {

 
		    	 $("#idprov").val( response.a );   
		    	 $("#beneficiario").val( response.b);   
		    	 $("#cur").val( response.c);   
		    	    
		} 
  });
	
     

 	 
 	 
 }
//----------------------------------------------
//---------------------------------------------
function VerMemo(id_tramite) {

	  
		var parametros = {
				 'id_certifica' : id_tramite ,
                 'accion' 		: 'visor'
        };

		$.ajax({
		    type:  'GET' ,
			data:  parametros,
			url:   '../model/Model-compromiso_memo_add.php',
			dataType: "json",
			success:  function (response) {
  
			    	 $("#nro_memo").val( response.b );   
			    	 $("#fcertifica").val( response.c);   
			    	 $("#comprobante").val( response.d);   
			    	 $("#fcompromiso").val( response.e);  
			    	 $("#idasiento1").val( response.f);  
			    	 
			    	 $("#idprov").val( response.g);  
			    	 $("#idproveedor").val( response.g);  
			    	 $("#proveedor").val( response.h);  
			    	 $("#beneficiario").val( response.h);  
			    	 
			    	  
					  
			} 
	   });
		
		 
		
 
}
//----------------------------------------------
function limpiaPartida() {
   
 	
	$("#detalle").val("");
    
	$("#idproducto").val("");
 	
	$("#cantidad").val("1");
 	
	$("#tarifa").val("12");
 	
	$("#descuento").val("0");
 
	$("#precio").val("0");
	
	$("#actionProducto").val("add");
	
 
 }
 //----------------- pone informacion del tramite
 function goToURLEditor_visor( accion,id_tramite, user_sol, nombre) {
		
		// $eventoGo =  ' onClick="'.'goToURLEditor('."'".$accion."',"."'".$id_tramite."',".$user_sol.','.$nombre.')" ';
		 	
	 
		  
		  $("#action").val(accion);
		  $("#solicita1").val(user_sol);
		  $("#nombre").val(nombre);
		  
	 	    
		   
		var parametros = {
						 'id_tramite'     : id_tramite ,
	                     'accion'        : accion
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-compromiso.php',
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
 ///----------------------
 function PoneCalculo(valor)
 {
    
 	  var tipo = $("#tipo_aplica").val();
 	  
 	  var totalBase 	= 0;

	   
	   
	   if ( tipo == 'I'){
		  var flotante = parseFloat(valor)    * (12/100);

		  var valorIva = parseFloat(flotante).toFixed(2)  ;
 
		  $('#iva').val(valorIva);

		  totalBase 	= parseFloat(valorIva)  + parseFloat(valor)  ;
		    
		//   $("#certificado").val(totalBase.toFixed(2) );
		  $("#certificado").val(parseFloat(valor).toFixed(2) );
		  
	  }else if ( tipo == 'I-15'){
		var flotante = parseFloat(valor)    *  (15/100);
		var valorIva = parseFloat(flotante).toFixed(2)  ;

		$('#iva').val(valorIva);

		totalBase 	= parseFloat(valorIva)  + parseFloat(valor)  ;
		  
		// $("#certificado").val(totalBase.toFixed(2) );
		$("#certificado").val(parseFloat(valor).toFixed(2) );
		
	}else{


		  $('#iva').val(0); 

		  totalBase 	=   parseFloat(valor)  ;
		  
		  $("#certificado").val(totalBase.toFixed(2) );
 
	  }
	  
	 
      
 }  
	//-------------- BANDEJA DE ENTRADA DE DOCUMENTOS  
 function BusquedaGrilla(cumplimiento,estado,nombre,ban){        	 
	 
 	    var parametros = {
				 'estado' : estado,
				 'pagina': 0
	   };
	    
 	    
	    $("#estado1").val(estado);
	  	 
		$.ajax({
			 data:  parametros,
			 url: "../model/Model-BusquedaTramite.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		
		
		 $("#etiqueta_estado").html('<b>' +nombre + '</b>');
		 
		 $("#pag").val(0);
		
		 $("#nombre_actual").html('<b>' + ' [ Seleccionar cliente ] </b>');
		 
		 
		 if ( estado == '2') {
			 
			 $('#p1_nuevo').attr("disabled", false);
			 $('#p2_nuevo').attr("disabled", true);
			 
			 $('#fcertifica').attr("readonly", false);
			 $('#fcompromiso').attr("readonly", true);
 
			 
			 
		 } 
		 
		if ( estado == '3') {
			 
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p2_nuevo').attr("disabled", false);
 
			 $('#fcertifica').attr("readonly", true);
			 $('#fcompromiso').attr("readonly", false);
		 } 
		 
		if ( estado == '5') {
			 
 			 $('#p2_nuevo').attr("disabled", false);
 			 $('#p1_nuevo').attr("disabled", true);
 			 
 		 } 
		 
		
 
		 if ( ban > 0 ){ 
			 $('#mytabs a[href="#home"]').tab('show');
		 }
		
	
}   
//------------ DETALLE DE PARTIDAS --------------
//------------------------------------------------
  function BusquedaProd(oTable,idseg){        
	  
      var parametros = {
				'id' : idseg , 
       };

   	$.ajax({
		 	data:  parametros,  
		    url: '../grilla/grilla_certifica_partida.php',
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
	 	                       '<button title="Asignar Monto Compromiso " class="btn btn-xs" onClick="javascript:goToURLmonto('+ "'" + s[i][6] + "'" +')"><i class="glyphicon glyphicon-hand-left"></i></button>&nbsp;' +
	 							'<button title="Editar partida" class="btn btn-xs" onClick="javascript:goToURLpartida('+ "'" + s[i][6] + "'" +')"><i class="glyphicon glyphicon-file"></i></button>&nbsp;' +
	 							'&nbsp;<button class="btn btn-xs" onClick="javascript:goToURLProd('+"'del'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;'  +
	 							'&nbsp;<button title="Liquidar partida"  class="btn btn-xs" onClick="javascript:goToURLcer('+s[i][3]+','+s[i][5]+ ',' + s[i][6] +')"><i class="glyphicon glyphicon-eye-open"></i></button>' 
							]);										
					} // End For
			 }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		

	
}     
 //----
  function GuardarDatosLiquida(  ) {
	  
	  var id_tramite = $("#idtramite1").val() ;
	  
	  var monto1 = $("#mcertifica").val() ;
	  var monto2 = $("#mdevenga").val() ;
	  var id_tramite_det = $("#mid").val() ;
	  var comment =   $("#comment").val() ;
	  
	  var parametros = {
				 'id_tramite'     : id_tramite ,
				 'id_tramite_det' : id_tramite_det,
				 'monto1' : monto1,
				 'monto2' : monto2,
                 'accion'        : 'liquida',
                 'comment' : comment
};
	  
	  alertify.confirm("<p>Desea liquidar el monto de la certificacion...</p>", function (e) {
		  if (e) {
			
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-certificacion.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
						    	$("#liquida_proceso").html('Procesando');
					},
					success:  function (data) {

							    $("#liquida_proceso").html(data);
							
							    $("#comment").val('')
					} 
			}); 
	 			  
				 
		  }
		 }); 
	  
	  
	  
		

			 
  }
 //------------ 
  function goToURLcer( monto1,monto2,id_tramite_det) {
		
  	
 
		 
	  $("#mcertifica").val(monto1) ;
	  $("#mdevenga").val(monto2) ;
	  $("#mid").val(id_tramite_det) ;
	  
	  var estado1    =  $("#estado1").val() ;
	  
	  var mcertifica = parseFloat(monto1.toFixed(2));  
	  
	  var mdevenga = parseFloat(monto2.toFixed(2));  
	 
	  if ( estado1 == '6'){
	    
			  if ( mcertifica > mdevenga ){
				  
				   $('#myModalDocCertifica').modal('show');  
				   
			  }
	  
	  }
		  
		  
		  
     }  
//-------------
function ImprimirOrden(  ) {

	   var url = '../reportes/orden'
	 	   
		    var id_certifica         = $("#idtramite1").val();
				  
			 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+id_certifica    ;
		    
		    var ancho = 1000;
		    
		    var alto = 520;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

	}
//----------------- 
   function ImprimirActa(  ) {

	   var url = '../reportes/certificacion'
	 	   
		    var id_certifica         = $("#idtramite1").val();
				  
			 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+id_certifica    ;
		    
		    var ancho = 1000;
		    
		    var alto = 520;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

	}
 //----------------- 
   function ImprimirActac(  ) {

	   var url = '../reportes/compromiso'
	 	   
		    var id_certifica         = $("#idtramite1").val();
				  
			 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+id_certifica    ;
		    
		    var ancho = 1000;
		    
		    var alto = 520;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

	} 
  //-------------------------------
  function Grilladoc( ){        
	  
 
		  
	 var idseg = $("#idvengestion_pro").val();
	  
	   
      var parametros = {
				'id' : idseg , 
       };


      
		$.ajax({
		 	data:  parametros,  
		    url: '../grilla/grilla_ven_doc.php',
			dataType: 'json',
			success: function(s){
		//	console.log(s); 
			oTableProducto.fnClearTable();
					if(s ){ 
						for(var i = 0; i < s.length; i++) {
							oTableProducto.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
 	                        s[i][3],
 							'<button class="btn btn-xs" onClick="javascript:goToURLFile('+ "'" + s[i][4] + "'" +')"><i class="glyphicon glyphicon-file"></i></button>' +
 							'  &nbsp; <button class="btn btn-xs" onClick="javascript:goTodel('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			 }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		 
}   
  
 //-----------------------------
function Limpiar_producto( ){        	 

	  alertify.confirm("Desea Agregar partida", function (e) {
		  if (e) {
			 
	 			     $("#actionProducto").val("add");
	 			     
                     $("#guardarProducto").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
				 
                  
                     $("#partida").val("");
                     $("#saldo").val(0);
                     $("#iva").val(0);
                     $("#base").val(0);
                     $("#certificado").val(0);
                     $("#compromiso").val(0);
                     $("#devengado").val(0)
		
                     $("actividad").val("");
                     $("fuente").val("");
                     $("grupo").val("");
                     $("programa").val("");
    
                     
		  }
		 }); 
 
}   
 
  //----------------
  function filtroUser(us){        	 

	  
		var parametros = {
				'user' : us  
	  };

		
		$.ajax({
			data:  parametros,
			 url:   '../model/Model-SegCliente.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFormLista").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormLista").html(data);  // $("#cuenta").html(response);
				     
					} 
		});
 
	  }    
//--------------
   
 function modulo()
 {
 	 var modulo =  'kpresupuesto';
 	 
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
    

	 $("#ViewFormCliente").load('../controller/Controller-compromiso.php');
      
     $("#ViewFormProducto").load('../controller/Controller-compromiso_partida.php'  );
	 
     $("#ViewFiltroAux").load('../controller/Controller-certificacion_user.php'  );
     
     
 
 	 
 }
 
//----------------------
 function agregar_producto()
 {
  
	 $("#producto").val("");
	 $("#detalle").val("");
	 $("#medio").val("");
	 

 }
//-----Viewdetalle  
 function ParcialCertificacion(condicion)
 {
  
	    var estado 	   =   $("#estado1").val();
	    var idtramite1 =   $("#idtramite1").val();
		var idprov     =	$("#idprov").val( );  
	 
		if ( condicion == 'S') {
			
			 var parametros = {
					    'idtramite' : idtramite1  
		    };

		 	 
		 	$.ajax({

					data:  parametros,
					url:   '../model/Model_certificacion_parcial.php',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
							 $("#Viewdetalle").html(data);   

						} 

			});
		}else{
			 $("#Viewdetalle").html('');   
			 $("#estado_parcial").val('-');  
			 
		}

 }
//---------

function SaldoPresupuesto(tipo )

{


	var today = new Date();
  

    var fanio = today.getFullYear();
	  
   	 
	  var parametros = {
			    'fanio' : fanio ,
			    'tipo' : tipo
			  
	  };

	  $.ajax({

			data:  parametros,
			url:   '../model/Model_saldo_ingreso.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
 					alert(data);
  				} 

	  });
	  
	 
	  

}  
//------- 
 function actualiza_parcial(   saldo,valor,iddet)
 {
	 
	  vsaldo 	=   parseFloat(saldo)  ;
	  vmonto 	=   parseFloat(valor)  ;
	  
	  var idtramite1 =   $("#idtramite1").val();
      var idprov     =	$("#idprov").val( );  
		
	  var parametros = {
				"iddet" : iddet,
				"idtramite" : idtramite1,
				"vmonto" : vmonto
		};
	  
	  if (vmonto > vsaldo) {
		  
		  $("#guardarAux").html( 'Monto sobrepasa al valor certificado' );  
		  $("#di_" +iddet ).val( 0);  
		  
	  }else{
		  if (vmonto > 0 ) {
			  
					$.ajax({
						    type:  'GET' ,
							data:  parametros,
							url:   '../model/Model_saldo_parcial.php',
							dataType: "json",
							success:  function (data) {
									 $("#guardarAux").html( data);  
									  
							} 
					}); 
					
		  }
	  }
	   
 
	
	 
 }

//--------------------------
function agregar_beneficiario()
 {

    
    var estado 	   =   $("#estado1").val();
    var idtramite1 =   $("#idtramite1").val();
	var idprov     =	$("#idprov").val( );
  	 
	var cur     =	$("#cur").val( );
 	 
	 if (idprov){

 			 	 var parametros = {
						    'idtramite' : idtramite1 ,
						    'idprov' : idprov ,
						    'accion' : 'add',
						    'cur' : cur
 			    };

			 	 
			 	$.ajax({

						data:  parametros,
						url:   '../model/Model_certificacion_user.php',
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
//-----------------
 function PoneSaldo(partida)
 {
    

	 var parametros = {
				"partida" : partida 
		};
		 
		$.ajax({
			    type:  'GET' ,
				data:  parametros,
				url:   '../model/Model_saldo_partida.php',
				dataType: "json",
				success:  function (response) {

					
						 $("#saldo").val( response.a );  
						 
						 
						  
				} 
		});
      

 }
 
 function EnviarWhatsapp()
 {
    
	   var tfono =   $.trim( $("#tfono").val()   )  ;
	 	var tasunto = $.trim( $("#tmensajee").val() );
	 
	 if (tasunto)	 {
		   
 	 	window.open('https://api.whatsapp.com/send?phone='+tfono+'&text='+tasunto,'_blank');
      
	 }
 }
 //--------------------------------------------
 function AnularTramite(  ) {
		
	var estado 	   =   $("#estado").val();
  	var idtramite1 =   $("#id_tramite").val();
  
 
  
	
	var parametros = {
				'id_tramite' : idtramite1 ,
				'estado' : estado,
				'action' : 'anula'
	};
	
 
	
		 
			  alertify.confirm("Desea Anular el tramite?", function (e) {
			  if (e) {
				 
				  $.ajax({
						data:  parametros,
						url:   '../model/Model-compromiso.php',
						type:  'POST' ,
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
