var oTableProducto;

var oTable;

var formulario = 'certificacion';

//------------------------------------------------------------------------- 
$(document).ready(function(){
    
          
	     oTable			= $('#jsontable_partida').dataTable(); 
  
	     modulo(); 
          
         FormView();
      
		 $("#MHeader").load('../view/View-HeaderModel.php');
	
		 $("#FormPie").load('../view/View-pie.php');
	      
  
	 	BusquedaGrilla('','1','1. Requerimiento Solicitado',0);
	 	
		
		$("a[rel='pop-up']").click(function () {
	      	var caracteristicas = "height=500,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
	      	nueva=window.open(this.href, 'Popup', caracteristicas);
	      	return false;
		 });
		
		
		$('#loadDoc').on('click',function(){

	  		   

            openFile('../../upload/uploadCer',650,320)

  			

		});
 
  
});  
 
//-------------------------------------------------------------
 function accion(id,modo,visor)
{
  
			$("#action").val(modo);
			
			$("#id_tramite").val(id);          

		if ( visor == 0 ){
			
			BusquedaGrilla('','1','1. Requerimiento Solicitado',1);
			
		}
			

}
//-------------------------------------------------------------
 function accion_producto(id,modo,visor)
{
  
 	 
     		var id_tramite = $("#id_tramite_prod").val();
     
			$("#actionProducto").val(modo);
			
			$("#id_tramite_deta").val(id);          

			if ( visor == 0 ){
				
				BusquedaProd(oTable,id_tramite);
				
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
//----------------------------------- g
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
 
	  
	  
	  
    }
///////////////
function PonePartida(fuente)
{
	   var  clasificador    = $("#grupo").val();
	    var  actividad      = $("#actividad").val();
 	    var  programa  		= $("#programa").val();
	    
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
	 
	 
	    var parametros = {
				 'estado' : estado,
				 'qbusqueda' : qbusqueda,
				 'qtramite':qtramite,
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
 		 
 		 
 		 
	
}  
//----------------------
function PoneDoc(file)
{
 
 
	  
 var url = '../../archivos/doc/' + file;

 var parent = $('#DocVisor').parent(); 
 $('#DocVisor').remove(); 
 
 var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
 parent.append(newElement); 
	 
  $('#DocVisor').attr('src',url); 
 
	
  	
}
//---------------
function Ver_doc_tramite(id) {

	 
    var parametros = {

					'id' : id  ,
					'accion' : 'visor'  
 
	  };

	  $.ajax({

					data:  parametros,

					url:   '../../upload/Model-pre_doc.php',

					type:  'GET' ,
 
					success:  function (data) {

							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);

						     

 					} 

			}); 


   }
//----------------------
function openFile(url,ancho,alto) {
    
	var id_tramite = $("#idtramite1").val();
		 
	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id_tramite  ;
	 
	  if ( id_tramite) {
		  
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
//----------------
function goToURLProd( accion,idcodigo ) {
	
 	   
	var id_tramite = $("#idtramite1").val();
    var parametros = {
				 'id_tramite_det'     : idcodigo ,
	             'accion'        : accion
	};
	
    var estado =   $("#estado1").val();
	  
	 if ( estado == '2') {
		 

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
										    
										    BusquedaProd(oTable,id_tramite);
										
									} 
						}); 
			    
	                     
			  }
			 }); 
		
	 }

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


//----------------
function goToURLpartida(  codigo ) {
	
	var estado =   $("#estado1").val();
	  
	 if ( estado == '2') {
	  
		   
		var parametros = {
						 'id_tramite_det'     : codigo ,
	                     'accion'        : 'editar'
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
//------------------
function BusquedaPlanificacion() {
	
	
	$('#mytabs a[href="#home"]').tab('show');
	
		 $("#nombre_actual").html('<b> 0. Solicitud Planificacion </b>');
   
      	 $("#etiqueta_estado").html('<b> 0. Solicitud Planificacion </b>');
   
   
	 
	$.ajax({
 		 url:   '../../kplanificacion/model/Model_seg_proceso_fin.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#BandejaDatos").html('Procesando');
			},
		success:  function (data) {
				 $("#BandejaDatos").html(data);   
			     
			} 
    });


	
	
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
		   pagina = pagina + 8 ;
	   }else { 
		   pagina = pagina - 8 ;
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
  var comprobante=   $("#comprobante").val();
  
  
  var parametros = {
			 'idtramite' : idtramite1 ,
			 'fcertifica' : fcertifica
  };
  
  
  if ( estado == '2'){
	  
	  	if (fcertifica){
	  		
		  		if (comprobante){
		  			
		  			 alert('CERTIFICACION ya emitida' + idtramite1);
		  			 
		  		}else {
					  
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
		  		   }
	  		}else{
	  			
	  			 alert('Tramite ingrese la FECHA DE LA CERTIFICACION ' + idtramite1);
	  		}
	   }
		  else {
			  alert('Tramite ya se encuentra EMITIDA ' + idtramite1);
		  }
}
//---------------------------

function GuardarPedidoMemo(){
	
	
 
	var id_certifica      = $("#idtramite1").val( );   
	
 	var editor2 		  = tinyMCE.get('editor6').getContent();
 	
	var memo			  = $("#nro_memo").val( );   
	
	var id_departamento = $("#id_departamento").val();
 	
	if ( memo ){
		
		if ( id_certifica > 0 ){
			
				alertify.confirm("<p>Desea guardar Memo requerimiento " +memo+  "</p>", function (e) {
			 
			  if (e) {
	                  
					  	var parametros = {
								 'id_certifica' : id_certifica ,
			                     'editor2':editor2 ,
	 		                     'memo' : memo,
	 		                     'accion' : 'edit',
	 		                     'id_departamento' :id_departamento
			 	        };
				
				        $.ajax({
								data:  parametros,
								url:   '../model/Model-certifica_memo_add.php',
								type:  'POST' ,
								cache: false,
								success:  function (data) {
	 									 $("#mensaje_proceso").html( data );   
			 							
			  					} 
						}); 
	  		     }
			 });
		} 
		
	}else{
		alert('Ingrese Nro Memo o Nro.Documento');
	} 
 
}

///------------------------
function VerHistorial( id_tramite, nombre,solicitado )
{
  
 
 
     $("#idtramite1").val(id_tramite);
     
     $("#solicita1").val(solicitado);
     $("#nombre").val(nombre);
 	 
     $("#id_tramite_prod").val(id_tramite);
     $("#mensaje_proceso").html(' ');
 	 $("#nombre_actual").html('<img src="../../kimages/mano.png" align="absmiddle"/> <b>[ '+id_tramite+ '-' + nombre +' - ' + solicitado +' ] </b>');
	
  		
 	BusquedaProd(oTable,id_tramite) ;
 
    VerAvance(id_tramite);
    
    
    Ver_doc_tramite(id_tramite);
 	
    goToURLEditor_visor( 'editar',id_tramite, nombre, solicitado);


	if ( estado == '2') {
			 $('#b2_planilla').attr("disabled", false);
			 $('#b2_save').attr("disabled", false);
		
			 $('#p1_nuevo').attr("disabled", false);
		
			 nombre_estado = '2. Tramite Autorizado';
		 } 


} 
function VerHistorialUni( id_tramite, nombre,solicitado,estado )
{
  
	
	     $("#estado1").val(estado);
	   
	     var nombre_estado ='';
		 
 
		 $("#pag").val(0);
		 $("#nombre_actual").html('<b>' + ' [ Seleccionar cliente ] </b>');
		 
		 
		 $('#b2_planilla').attr("disabled", true);
		 $('#b2_save').attr("disabled", true);
		 $('#b2_print').attr("disabled", false);
		 
		 $('#p1_nuevo').attr("disabled", true);
		 $('#p1_savec').attr("disabled", true);
		 $('#p1_print_c').attr("disabled", false);
			 
	 	   

		 if ( estado == '1') {
			 $('#b2_planilla').attr("disabled", false);
			 $('#b2_save').attr("disabled", false);
			 nombre_estado = '1. Requerimiento Solicitado';
		 } 
		 
	 
	
		 if ( estado == '2') {
			 $('#b2_planilla').attr("disabled", false);
			 $('#b2_save').attr("disabled", false);
		
			 $('#p1_nuevo').attr("disabled", false);
		
			 nombre_estado = '2. Tramite Autorizado';
		 } 
	 
		 if ( estado == '4') {
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p1_savec').attr("disabled", true);
			 nombre_estado = 'Tramite Autorizado';
		 } 
 
		 if ( estado == '3') {
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p1_savec').attr("disabled", true);
			 nombre_estado = '3. (*) Emision Certificacion';
		 } 
		 
		 if ( estado == '0') {
			 nombre_estado = 'Anular proceso';
		 } 
		 
     $("#etiqueta_estado").html('<b>' +nombre_estado + '</b>');
		 
     $("#idtramite1").val(id_tramite);
     $("#solicita1").val(solicitado);
     $("#nombre").val(nombre);
 	 
     $("#id_tramite_prod").val(id_tramite);
     $("#mensaje_proceso").html(' ');
 	 $("#nombre_actual").html('<img src="../../kimages/mano.png" align="absmiddle"/> <b>[ '+id_tramite+ '-' + nombre +' - ' + solicitado +' ] </b>');
	
  		
 	BusquedaProd(oTable,id_tramite) ;
 
    VerAvance(id_tramite);
 	

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
//----------------------------------------------
 
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
 //-----------------
function LimpiaOrden() {
   
 
	 tinyMCE.get('editor6').setContent(htmlEntities(''));
 
 }
///----------------
 function PonePlantilla( )
 {
    
	var a =  $("#solicita1").val();
	var b =  $("#nombre").val();
	
	var c = $("#detalle").val();
	
	var id_departamento = $("#id_departamento").val();
	
 
    var nro_memo = $('#nro_memo').val().trim();
	     
	 var cadena = '<span  style="font-size: 13px"><b>PARA:</b><br/>' + '<b>Responsable</b><br/>' +  'Direccion Financiera<br/><br/>' + 
	 			  '<b>DE:</b><br/>' + '<b>'+ a +'</b><br/>' + b + '<br/><br/><br/>' + 
		 		  'Por medio del presente, y a fin de dar cumplimiento a la Planificacion Institucional, solicito a ud, se sirva disponer a quien corresponda la emision de la certificacion presupuestaria ' + 
	 		      'respectiva de acuerdo al Plan Anual de Contratacion, para la adquisicion de <b>'+ c +'</b> <br/><br/>' + 
		          'Particular que pongo en su conocimiento, para los fines administrativos pertinentes.<br/><br/>' +
		          'Atentamente,'+ '<br/><br/><br/>' + a + '<br/>' + b + '</span>';
		          
	 
	 tinyMCE.get('editor6').setContent(cadena);
      
	 
	 
	  var parametros = {
				 'id_departamento' : id_departamento,
 	   };
	    
	    
	    $("#estado1").val(estado);
	  	 
		    
		if (nro_memo === '') {

			 $.ajax({
				 data:  parametros,
				 url: "../model/ajax_secuencia_departamento.php",
				 type: "GET",
		        success: function(response)
		        {
		            $('#nro_memo').val(response);
		        }
			 });
		 } 
	 
 } 
 ///----------------------
 function PoneCalculo(valor)
 {
    
 	  var tipo = $("#tipo_aplica").val();
 	  
 	  var totalBase 	= 0;

	//   var flotante = parseFloat(valor)    *  (12/100);

	  totalBase 	=   parseFloat(valor)  ;

	  if ( tipo == 'I'){
		var flotante = parseFloat(valor)    *  (12/100);
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
		 
		 
		 $('#b2_planilla').attr("disabled", true);
		 $('#b2_save').attr("disabled", true);
		 $('#b2_print').attr("disabled", false);
		 
		 $('#p1_nuevo').attr("disabled", true);
		 $('#p1_savec').attr("disabled", true);
		 $('#p1_print_c').attr("disabled", false);
			 
	 	   
 
		 if ( estado == '1') {
			 $('#b2_planilla').attr("disabled", false);
			 $('#b2_save').attr("disabled", false);
		 
		 } 
		 
		 if ( estado == '2') {
			 $('#p1_nuevo').attr("disabled", false);
			 $('#b2_planilla').attr("disabled", false);
			 $('#b2_save').attr("disabled", false);
		
	 	     $('#p1_savec').attr("disabled", false);
		 
		 } 
	 
		 if ( estado == '4') {
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p1_savec').attr("disabled", true);
		 } 
	  
		 if ( ban > 0 ){ 
			 $('#mytabs a[href="#home"]').tab('show');
		 }
		
	
}   
//------------

function AbrirDocInicio (tarea, idtarea_seg)
{
	
	$("#tareaf").val(tarea);
	
	$("#idtarea_segf").val(idtarea_seg);
	
	
	var parametros = {
								'idcodigo' : tarea  ,
								'idcaso'   : idtarea_seg  ,
								'accion' : 'archivos',
								'visor' : '2'
				   };
			
				  $.ajax({
								 data:  parametros,
								 url:   '../../kplanificacion/model/Model_nov__doc_tra01.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#Seguimiento_archivo").html(data);   
			  
								 } 
			
						}); 
 
	
 }	
 
//--------------------------- 
function SiguienteProceso( )
{
	
// filtro para poner los objetivos de la unidad	
var idtarea1 			= $("#idtarea1").val(  );
var idtarea_seg 		= $("#idtarea_seg").val(  );
var idtarea_segcom 		= $("#idtarea_segcom").val(  );

var secuencia_next			= $("#secuencia_next").val(  );
var idtarea_segcom_next		= $("#idtarea_segcom_next").val(  );
var comentario_dato         = $("#comentario_dato").val(  );

var fecha_cer         = $("#fecha_cer").val(  );
var cur_cer         = $("#cur_cer").val(  );
  
          

var proceso = $("#proceso_nombre").val();
 
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom,
			    'secuencia_next':secuencia_next,
			    'idtarea_segcom_next':idtarea_segcom_next,
			    'comentario_dato':comentario_dato,
			    'fecha_cer':fecha_cer,
			    'cur_cer':cur_cer 
    };
 
 
 if(confirm("Desea guardar y enviar el proceso seleccionado?"))
	{
	              	$.ajax({
										data:  parametros,
										 url:   '../../kplanificacion/model/ajax_tarea_ejecuta_cer02.php',
										type:  'POST' ,
											beforeSend: function () { 
													$("#guardarDatosCom").html('Procesando');
											},
										success:  function (data) {
												    $("#guardarDatosCom").html(data); 
												    
												     BusquedaPlanificacion();

													 alert('Verifique la informacion y genere el comprobante de certificación');
						 					} 
								});
	}
	else
	{
	   return false;
	}
 
}
//----------

function SiguientePaso( idtarea1 ,idtarea_seg,idtarea_segcom)
{
	
// filtro para poner los objetivos de la unidad	

$("#idtarea1").val( idtarea1 );
$("#idtarea_seg").val( idtarea_seg );
$("#idtarea_segcom").val( idtarea_segcom );
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom
    };
 
	$.ajax({
				data:  parametros,
				 url:   '../../kplanificacion/controller/Controller_ver_tarea_cer.php',
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormComentario").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormComentario").html(data); 
					     
					} 
		});
 
	 
}
//------------------------------
//---------------------
function AdjuntarDoc ()
{
	
	var ancho = 650 ;
	var alto = 360;
 
 var tarea		 =	$("#tareaf").val();
 var idtarea_seg =	$("#idtarea_segf").val();
	
  	   
	var posicion_x; 

	var posicion_y; 

	var enlace = '../../upload/uploadDoc_pla_seg?id='+ tarea + '&seg=' + idtarea_seg; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
 
	if ( tarea > 0 ) {

			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }

} 
//----------------------------
 function VerAvance ( seg_tarea1 ,seg_tarease1    )
{
 
 
 	$("#tareaf").val(seg_tarea1);
	
	$("#idtarea_segf").val(seg_tarease1);
	
 
		 var parametros1 = {
					'idtarea'  : seg_tarea1  ,
					'seg_tarease1': seg_tarease1
				}
		 
		$.ajax({
			data:  parametros1,
			 url:   '../../kplanificacion/model/ajax_tarea_avance_p.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormRecorrido").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormRecorrido").html(data);   
					 
				} 
	  });
 
   
	  


}
//-----------------------------
function AbrirDocInicio (tarea, idtarea_seg)
{
	
	$("#tareaf").val(tarea);
	
	$("#idtarea_segf").val(idtarea_seg);
	
	
	var parametros = {
								'idcodigo' : tarea  ,
								'idcaso'   : idtarea_seg  ,
								'accion' : 'archivos',
								'visor' : '2'
				   };
			
				  $.ajax({
								 data:  parametros,
								 url:   '../../kplanificacion/model/Model_nov__doc_tra01.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#Seguimiento_archivo").html(data);   
			  
								 } 
			
						}); 
 
	
 }	
//----------------------------
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
	 							'<button class="btn btn-xs" onClick="javascript:goToURLpartida('+ "'" + s[i][6] + "'" +')"><i class="glyphicon glyphicon-file"></i></button>' +
	 							'  &nbsp; <button class="btn btn-xs" onClick="javascript:goToURLProd('+"'del'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
					} // End For
			 }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		

	
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
    

	 $("#ViewFormCliente").load('../controller/Controller-certificacion');
      
     $("#ViewFormProducto").load('../controller/Controller-compromiso_partida.php'  );
	 
 	 
 }
 
//----------------------
 function agregar_producto()
 {
  
	 $("#producto").val("");
	 $("#detalle").val("");
	 $("#medio").val("");
	 

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
 //---------------------------- 
 
//-----------------------  
 function goToURLDocdel(idcodigo,idprov) {

 	 
     var parametros = {

 					'idcodigo' : idcodigo  ,
 					'id'   : idprov  ,
 					'accion'   : 'del'
  
 	  };

 	  $.ajax({

 					data:  parametros,

 					url:   '../model/Model-pre_doc.php',

 					type:  'GET' ,
  
 					success:  function (data) {

 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);

  
  					} 

 			}); 


    }
    
 // filtro para poner los objetivos de la unidad	
function VerTarea( idtarea )
{
	 	 
	 
	var parametros = {
				 'idtarea'  : idtarea 
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../../kplanificacion/controller/Controller_ver_tarea_pac.php",
		 type: "GET",
       success: function(response)
       {
           $('#ViewFormTarea').html(response);
       }
	 });
	 
	   $('#guardarPac').html('');
	 
	 
	 
}
 //--------------------------------------------
 function CerrarFactura(  ) {
		
		var idcliente 		 = $("#idcliente").val();
		var razon    		 = $("#razon").val();
		var idvengestion     = $("#idven_gestion").val();
		
		
		var parametros = {
				'idcliente' : idcliente  ,
				'idvengestion' : idvengestion
	    };
		
		 
			  alertify.confirm("Desea Cerrar proceso de venta?", function (e) {
			  if (e) {
				 
				  $.ajax({
						data:  parametros,
						url:   '../model/Model-inte_clientes_precierre_post.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
							    	$("#mensaje_proceso").html('Procesando');
						},
						success:  function (data) {

								    $("#mensaje_proceso").html(data);
								
						} 
				}); 
	 		   }
			 }); 
		
}
