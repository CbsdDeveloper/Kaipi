var oTableProducto;

var oTable;

var formulario = 'compromiso';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
          
		 $('#visible1').hide(); 
		 $('#visible2').hide(); 
	   
	     oTable			= $('#jsontable_partida').dataTable(); 
 
         FormView();
      
 
  
	 	BusquedaGrilla('','2','2. (*) Tramite Autorizado',0);
	 
		$("a[rel='pop-up']").click(function () {
	      	var caracteristicas = "height=500,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
	      	nueva=window.open(this.href, 'Popup', caracteristicas);
	      	return false;
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
			 
			 $('#visible1').show(); 
			 $('#visible2').hide(); 
			
			 nombre_estado = '2. Tramites Autorizado';	
		 } 

		 if ( estado == '3') {
			 $('#p1_nuevo').attr("disabled", false);
			 $('#p1_savec').attr("disabled", false);
			 $('#p1_savecc').attr("disabled", false);
			 $('#visible1').hide(); 
			 $('#visible2').show(); 
			 
			 nombre_estado = '3. (*) Emision Certificacion';
		 } 
	 
		 if ( estado == '5') {
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p1_savec').attr("disabled", true);
			 $('#p1_savecc').attr("disabled", false);
			 
			 $('#visible2').show(); 
			 $('#visible1').hide(); 
			 
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
	 
	 
	    var parametros = {
				 'estado' : estado,
				 'qbusqueda' : qbusqueda,
				 'qtramite' : qtramite,
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
  var fcertifica=   $("#fcertifica").val();
  
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
									 
																 alert('Nro. Comprobante emitido ' + data);
																 
																 $("#comprobante").val( data );   
									 							
																 
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
			  alert('Tramite no se encuentra en el estado CERTIFICACION AUTORIZADA ' + idtramite1);
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
	  
	  var parametros = {
				 'idtramite' : idtramite1 ,
				 'fcompromiso' : fcompromiso
	  };
	  
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
										 
																	 alert('Comprobante para generar el devengado! ' + idtramite1);
																	 
																	 BusquedaProd(oTable,idtramite1); 
										 							
										  					} 
													}); 
										 		  }
										  
								 });
			  		   }
 		   }
			  else {
				  alert('Tramite no   encuentra FECHA COMPROMISO AUTORIZADA ' + idtramite1);
			  }
	}
//---------------------------------------------------------------------
function GuardarPedidoMemo(){
	
	
 
	var id_certifica      = $("#idtramite1").val( );   
 	var editor2 		  = tinyMCE.get('editor6').getContent();
	var memo			  = $("#nro_memo").val( );   
 	
	 alertify.confirm("<p>Desea guardar Memo requerimiento <br><br></p>", function (e) {
		  if (e) {
			 
                 
				  	var parametros = {
							 'id_certifica' : id_certifica ,
		                     'editor2':editor2 ,
 		                     'memo' : memo,
 		                     'accion' : 'edit'
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

///------------------------
function VerHistorial( id_tramite, nombre,solicitado )
{
  
 
 
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

			    	 tinyMCE.get('editor6').setContent(htmlEntities(response.a));

			    	 $("#nro_memo").val( response.b );   
			    	 $("#fcertifica").val( response.c);   
			    	 $("#comprobante").val( response.d);   
			    	 $("#fcompromiso").val( response.e);  
					  
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
 //-----------------
function LimpiaOrden() {
   
 
	 tinyMCE.get('editor6').setContent(htmlEntities(''));
 
 }
///----------------
 function PonePlantilla( )
 {
    
	var a =  $("#solicita1").val();
	var b =  $("#nombre").val();
	     
	 var cadena = '<b>PARA:</b><br/>' + '<b>Responsable</b><br/>' +  'Direccion Financiera<br/><br/>' + 
	 			  '<b>DE:</b><br/>' + '<b>'+ a +'</b><br/>' + b + '<br/><br/><br/>' + 
		 		  'Por medio del presente, y a fin de dar cumplimiento a la Planificacion Institucional, solicito a ud, se sirva disponer a quien corresponda la emision de la certificacion presupuestaria ' + 
	 		      'respectiva de acuerdo al Plan Anual de Contratacion, para la adquisicion de <br/><br/>' + 
		          'Particular que pongo en su conocimiento, para los fines administrativos pertinentes.<br/><br/>' +
		          'Atentamente,'+ '<br/><br/><br/>' + a + '<br/>' + b;
		          
	 
	 tinyMCE.get('editor6').setContent(cadena);
      
 } 
 ///----------------------
 function PoneCalculo(valor)
 {
    
 	  var tipo = $("#tipo_aplica").val();
 	  
 	  var totalBase 	= 0;

	  var flotante = parseFloat(valor)    * (12/100);


	  if ( tipo == 'I'){

		  var valorIva = parseFloat(flotante).toFixed(2)  ;
 
		  $('#iva').val(valorIva);

		  totalBase 	= parseFloat(valorIva)  + parseFloat(valor)  ;
		    
		  $("#certificado").val(totalBase.toFixed(2) );
		  
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
		 
 
		 $('#p1_nuevo').attr("disabled", true);
		 $('#p1_savec').attr("disabled", true);
		 $('#p1_print_c').attr("disabled", false);
		 $('#p1_savecc').attr("disabled", true);
		 
		 if ( estado == '2') {
			 $('#p1_nuevo').attr("disabled", false);
 			 $('#p1_savec').attr("disabled", false);
 			 
 			 $('#visible1').show(); 
 			 $('#visible2').hide(); 
 			
 
		 } 
 
		 if ( estado == '3') {
			 $('#p1_nuevo').attr("disabled", false);
 			 $('#p1_savec').attr("disabled", false);
 			 $('#p1_savecc').attr("disabled", false);
 			 $('#visible1').hide(); 
 			 $('#visible2').show(); 
		 } 
	 
		 if ( estado == '5') {
			 $('#p1_nuevo').attr("disabled", true);
			 $('#p1_savec').attr("disabled", true);
			 $('#p1_savecc').attr("disabled", false);
			 
			 $('#visible2').show(); 
 			 $('#visible1').hide(); 
		 } 
	 
	 	  
		 
		

		   
 
		 if ( ban > 0 ){ 
			 $('#mytabs a[href="#home"]').tab('show');
		 }
		
	
}   
//------------
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
	 	                       '<button title="Asignar Monto Compromiso " class="btn btn-xs" onClick="javascript:goToURLmonto('+ "'" + s[i][6] + "'" +')"><i class="glyphicon glyphicon-hand-left"></i></button>&nbsp;' +
	 							'<button title="Editar partida" class="btn btn-xs" onClick="javascript:goToURLpartida('+ "'" + s[i][6] + "'" +')"><i class="glyphicon glyphicon-file"></i></button>&nbsp;' +
	 							'&nbsp;<button class="btn btn-xs" onClick="javascript:goToURLProd('+"'del'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
  	 

	 if (idprov){

 			 	 var parametros = {
						    'idtramite' : idtramite1 ,
						    'idprov' : idprov ,
						    'accion' : 'add'
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
