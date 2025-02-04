var oTable;
var oTable_doc;
var oTable_libre;

var formulario = 'ac_acta_inicial';

 


//-------------------------------------------------------------------------
$(document).ready(function(){


	oTable_libre			= $('#jsontableBienes').dataTable();

	oTable 	= $('#jsontable').dataTable( {      
		searching: true,
		paging: true, 
		info: true,         
		lengthChange:true ,
		aoColumnDefs: [
			 { "sClass": "highlight", "aTargets": [ 1 ] },
			{ "sClass": "ye", "aTargets": [ 2 ] },
			{ "sClass": "de", "aTargets": [ 3 ] }
 		  ] 
   } );
	
        
 
        
        
        oTable_doc 	= $('#jsontable_doc').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 4 ] },
  		      { "sClass": "de", "aTargets": [ 5 ] },
  		      { "sClass": "di", "aTargets": [ 0 ] },
  		    ] 
       } );
        
        
          
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable);
          
		});
	    
		$('#bbienes').on('click',function(){
	 		 
			BusquedaGrillaLibre(oTable_libre);
		 
	   });
		
 
		
});  
//----------------------------------------
function modulo()
{
 

	 var modulo1 =  'kactivos';
		 
	 var parametros = {
			    'ViewModulo' : modulo1
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
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR - EMITIR UNA ACTA DE ENTREGA-RECEPCION</b>');
					
					DetalleActivosNoAsignados( );
					 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
 
//----------------------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}
//--------------
function goToURL(accion,id) {
	
	
	$("#razon").val (accion);
	$("#idprov").val (id);
	
	$("#nombre_doc").html(' <b>'+ accion+' </b>');
	
	BusquedaGrillaCustodio(oTable_doc);
	
 	$('#mytabs a[href="#tab2"]').tab('show');
 	
	 DetalleActivosNoAsignados( );
 
	
}

// ir a la opcion de editar
function goToURL_datp(accion,id) {

    var resultado = Mensaje( accion ) ;
	   
	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	
 	
	$.ajax({
		  url:   '../model/Model-'+ formulario,
		  type:  'GET' ,
		  data:  parametros,
		  dataType: 'json',  
			}).done(function(respuesta){
					
				$("#id_bien").val (respuesta.id_bien);
 			 
				$("#fecha").val (respuesta.fecha);
				$("#forma_ingreso").val (respuesta.forma_ingreso);
				$("#identificador").val (respuesta.identificador);
				$("#descripcion").val (respuesta.descripcion);
		 
				$("#origen_ingreso").val (respuesta.origen_ingreso);
				$("#tipo_documento").val (respuesta.tipo_documento);
				$("#clase_documento").val (respuesta.clase_documento);
				$("#tipo_comprobante").val (respuesta.tipo_comprobante);
				$("#fecha_comprobante").val (respuesta.fecha_comprobante);
				
				$("#codigo_actual").val (respuesta.codigo_actual);
				$("#estado").val (respuesta.estado);
				$("#costo_adquisicion").val (respuesta.costo_adquisicion);
				$("#depreciacion").val (respuesta.depreciacion);
				$("#serie").val (respuesta.serie);
			
				$("#id_marca").val (respuesta.id_marca);
				
				$("#clasificador").val (respuesta.clasificador);
				$("#cuenta").val (respuesta.cuenta);
				
				$("#clase_esigef").val (respuesta.clase_esigef);
				$("#marca").val (respuesta.marca);
				
			 
				$("#valor_residual").val (respuesta.valor_residual);
				$("#anio_depre").val (respuesta.anio_depre);
				$("#vida_util").val (respuesta.vida_util);
				$("#color").val (respuesta.color);
				$("#dimension").val (respuesta.dimension);
			
				$("#uso").val (respuesta.uso);
				$("#fecha_adquisicion").val (respuesta.fecha_adquisicion);
				$("#clase").val (respuesta.clase);
			 
				$("#material").val (respuesta.material);
				$("#razon").val (respuesta.razon);
				$("#idprov").val (respuesta.idprov);
				$("#id_departamento").val (respuesta.id_departamento);
			 
				$("#tiene_acta").val (respuesta.tiene_acta);
				$("#tipo_ubicacion").val (respuesta.tipo_ubicacion);
				
				$("#detalle").val (respuesta.detalle);
				
				
					 						
				$("#action").val(accion); 
			 	$("#result").html(resultado);
			 
			 	selecciona_cuenta(respuesta.cuenta);
			 	
			 	var id_modelo = respuesta.id_modelo;
			 		
			 	ListaModeloAsignado(respuesta.id_marca,id_modelo) ;
  			 	  
			 
			 	
			});
 
		
	 
	

	  
}
//----------------------
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	 
 
	$("#fecha").val(fecha_hoy());
	$("#forma_ingreso").val(fecha_hoy());
	$("#fecha_comprobante").val(fecha_hoy());

	
	$("#id_acta").val("");
	$("#clase_documento").val("Acta de Entrega - Recepcion");
	$("#documento").val("");
 
	$("#estado").val("N");
	$("#detalle").val("Acta de Entrega inicial generada " + fecha_hoy());
 
	 
}
//-------------
function DetalleActivosNoAsignados( ) {
	  
	var idprov =	$("#idprov").val ();
	$("#bandera").val('custodio');

	 var parametros = {
				 'idprov'  : idprov  
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-_bien_noasignado.php",
			 type: "GET",
	       success: function(data)
	       {
	           $('#DetalleActivosNoAsignado').html(data);
	       }
		 });
	 
 
	 
}
//-------------
function DetalleActivosTodos( ) {
	  
	var idprov =	$("#idprov").val ();
	$("#bandera").val('todos');

	 var parametros = {
				 'idprov'  : idprov  
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-_bienes_todos.php",
			 type: "GET",
	       success: function(data)
	       {
	           $('#DetalleActivosNoAsignado').html(data);
	       }
		 });
	 
 
	 
}
//----------------------------------------
function ListaModeloAsignado(idmarca,id_modelo) {
	   
	 var parametros = {
				 'idmarca'  : idmarca,
				 'id_modelo' :id_modelo
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model_ac_auto_lista_modelo.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#id_modelo').html(response);
	       }
		 });
		 
		 VerVariables();
		 
	}

/* lista*/


function VisorActa( ) {
	   
	var canio =	$("#canio").val ();
	var cmes  =	$("#cmes").val ();

	 
	var parametros = {
				'canio'  : canio,
				'cmes' :cmes
	 };
		
		$.ajax({
			data:  parametros,
			url: "../model/ajax_visor_acta.php",
			type: "GET",
		  success: function(response)
		  {
			  $('#VisorActa').html(response);
		  }
		});
 		
   }
 /* */
 function VerLibres( ) {
	   
	
	var idprov =	$("#idprov").val ();

	if ( idprov)  {

			$('#myModalLibres').modal('show');

	}

 }
   
//------------------------
function myFunction(codigo,objeto ) {
	
 	    
	    var  accion 		    =  'check';
 
	    if (objeto.checked == true){
	    	estado = 'S'
	    } else {
	    	estado = 'N'
	    }
	    
	     
		   

	    var parametros = {
               'idbien' : codigo ,
              'estado':estado ,
              'bandera': 'S'

	  };


    $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_listaCheckNo.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#GuardaDato").html('Procesando');
							},
						success:  function (data) {
								 $("#GuardaDato").html(data);   
							} 

				}); 
 
	 
}
//-------------------
  function MarcarTodo(codigo ) {
		
	    
	    var  accion 		    =  'todo';
 	    var  idprov 		    =  $("#idprov").val();
		
 
	    var parametros = {
             'accion' : accion ,
             'codigo' : codigo ,
             'idprov' : idprov

	  };


  $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_listaCheckNo.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#GuardaDato").html('Procesando');
							},
						success:  function (data) {
								 $("#GuardaDato").html(data);   
							} 

				}); 

  DetalleActivosNoAsignados( );
}
//-------------------
  function MarcarTodos(codigo ) {
		
	    var  accion 		    =  'todo';
 	    var  idprov 		    =  $("#idprov").val();
		
 
	    var parametros = {
             'accion' : accion ,
             'codigo' : codigo ,
             'idprov' : idprov

	  };


  $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_listaCheckNoTodos.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#GuardaDato").html('Procesando');
							},
						success:  function (data) {
								 $("#GuardaDato").html(data);   
							} 

				}); 

  DetalleActivosTodos( );
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
	  
 
 
 	var Vid_departamento	= $("#Vid_departamento").val();
 	var vtiene_acta			= $("#vtiene_acta").val();
 	
	var vidsede			= $("#vidsede").val();

	var vrazon			= $("#vrazon").val();

 	
 	
 	
 	
    var parametros = {
 				'Vid_departamento' : Vid_departamento ,
 				'vtiene_acta' : vtiene_acta ,
 				'vidsede' : vidsede,
				 'vrazon' : vrazon
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		    //console.log(s); 
			oTable.fnClearTable();
			if(s)  {
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
						s[i][3],
						s[i][4],
						s[i][5],
    					'<button class="btn btn-xs btn-warning" title="Visualizar documentos emitidos" onClick="goToURL(' +"'" + s[i][1] + "'" + ','+ "'" + s[i][0] +"'" +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' 
				]);										
			} // End For
		  } 						
		 } 
	 	});


		 $("#vrazon").val('');
		
		
		
}   
  



//----------------- ViewForm
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');
	 
 }
//--------------- 
 function BusquedaGrillaCustodio(oTable_doc){       
 	 
	 
	 	var idprov	= 	$("#idprov").val ();
	 
	 	
	    var parametros = {
	 				'idprov' : idprov  
					};
	  
		  
	 	  
			$.ajax({
			 	data:  parametros,
	 		    url: '../grilla/grilla_' + formulario + '_custodio',
				dataType: 'json',
				cache: false,
				success: function(s){
			    //console.log(s); 
			 oTable_doc.fnClearTable();
				if(s)  {
				for(var i = 0; i < s.length; i++) {
					oTable_doc.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
							s[i][4],
							s[i][5],
 	    					'<button class="btn btn-xs btn-warning" title = "Visor de informacion Documento" onClick="goToURLvisor(' +   s[i][0]+',' +i +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' +
	    					'<button class="btn btn-xs btn-info"   title = "Generacion y Emision de Acta" onClick="goToURLdoc(1,' +   s[i][0]   +')"><i class="glyphicon glyphicon-file"></i></button>&nbsp;'  +
							'<button class="btn btn-xs btn-default"   title = "Generacion y Emision de Acta (Html)" onClick="goToURLdoc(3,' +   s[i][0]   +')"><i class="glyphicon glyphicon-file"></i></button>&nbsp;'  +
	    					'<button class="btn btn-xs btn-info" title = "Enviar Documento" onClick="EnviaCorreoFuncionario('+ s[i][0]   +')"><i class="glyphicon glyphicon-envelope"></i></button>&nbsp;'+
	    					'<button class="btn btn-xs btn-danger" title = "Anular Documento" onClick="goToURLdoc(2,' +   s[i][0]   +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;'
					]);										
				} // End For
			  } 						
			 } 
		 	});

	} 
	/*
	Bienes libres
	*/
	function BusquedaGrillaLibre(oTable_libre){       
 	 
	 
		var idsede	= 	$("#idsede").val ();
		
		var ccustodio	= 	$("#ccustodio").val ();
		var ccactivo	= 	$("#ccactivo").val ();
		  
		
	   var parametros = {
					'idsede' : idsede  ,
					'ccustodio': ccustodio,
					'ccactivo' : ccactivo
				   };
	 
		 
		  
		   $.ajax({
				data:  parametros,
				url: '../grilla/grilla_ac_libre_bienes.php',
			   dataType: 'json',
			   cache: false,
			   success: function(s){
			   //console.log(s); 
			   oTable_libre.fnClearTable();
			   if(s)  {
			   for(var i = 0; i < s.length; i++) {
				oTable_libre.fnAddData([
						   s[i][0],
						   s[i][1],
						   s[i][2],
						   s[i][3],
						   s[i][4],
						   s[i][5],
						   s[i][6],
						   s[i][7],
						   '<button class="btn btn-xs btn-warning" title = "Seleccionar bien" onClick="goToURLLibre(' + s[i][0]  +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' 
					]);										
			   } // End For
			 } 						
			} 
			});

		 
   } 
	
 //------------
 function selecciona_cuenta(cuenta)
 {
    
	 document.getElementById("cuenta_tmp").value = cuenta ;
	 
 
	 
 }
//--- 
 function goToURLvisor(idacta,fila) {
	 
	 
	 var parametros = {
				 'idacta' : idacta 
  };
	 
	
   $.ajax({
		 data:  parametros,
		 url: "../model/ajax_bienes_acta.php",
		 type: "GET",
       success: function(response)
       {

    		   $('#VisorBIenes').html(response);
    	  
    		 
       }
	 });
	 
 	var id1 = document.getElementById('jsontable_doc').tBodies[0].rows[fila].cells[3].innerHTML;
	var id2 = document.getElementById('jsontable_doc').tBodies[0].rows[fila].cells[4].innerHTML;
	var id3 = document.getElementById('jsontable_doc').tBodies[0].rows[fila].cells[0].innerHTML;

	$("#tfecha").val (id1);
	$("#tdetalle").val (id2);
	$("#tacta").val (id3);
	 

	 $('#myModalbienes').modal('show');
	 
 }
 /*
 asigna custodio libre
 */
 function goToURLLibre(codigo) {
	 

	var idprov   = $("#idprov").val ();
	 
	var parametros = {
				'idprov' : idprov ,
				'codigo':codigo
 };
	
   
  $.ajax({
		data:  parametros,
		url: "../model/ajax_actualiza_libre.php",
		type: "GET",
	  success: function(response)
	  {

			 alert(response);
		 
			
	  }
	});
	
	DetalleActivosNoAsignados( );

	$('#myModalLibres').modal('hide');
	
}
//----------------- 
function ActualizaActa(  ) {
	
 	    
	var tfecha   = $("#tfecha").val ();
	var tdetalle = $("#tdetalle").val ();
	var tacta    = $("#tacta").val ();
	   

	var parametros = {
		   'tfecha' : tfecha ,
		  'tdetalle': tdetalle ,
		   'tacta'  : tacta

  };


$.ajax({
					data:  parametros,
					url:   '../model/Model-ac_actualiza_acta.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#GuardaDato").html('Procesando');
						},
					success:  function (data) {
							 $("#GuardaDato").html(data);   
						} 

			}); 

 
}
//----------------------
 function confirmar_envio(event)
 {
    

	 var opcion = confirm("Desea generar el ACTA DE ENTREGA RECEPCION?");
	  if(!opcion) {
	    event.preventDefault();
	  }

 } 
//-----------------
 function printDiv(divID) {
	 
	 var objeto=document.getElementById(divID);  //obtenemos el objeto a imprimir
	 
	  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	  
	  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	  ventana.document.close();  //cerramos el documento
	  ventana.print();  //imprimimos la ventana
	  ventana.close();  //cerramos la ventana
        
}
//----
function goToURL_acta(  ) {

	var ancho = 800; 
	var alto = 550; 
	var posicion_x ; 
	var posicion_y ; 
	var enlace; 

	var referencia	= 	$("#id_acta").val ();
   
	posicion_x=(screen.width/2)-(ancho/2); 
	posicion_y=(screen.height/2)-(alto/2); 

 
		  var url = '../reportes/acta_entrega';
		  enlace = url+'?id='+referencia  ;
	   
			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 
	
  } 
//----------------------------
 function goToURLdoc(tipo, referencia ) {

	  var ancho = 800; 
	  var alto = 550; 
	  var posicion_x ; 
	  var posicion_y ; 
	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 
	  posicion_y=(screen.height/2)-(alto/2); 

	  
	  if ( tipo == 1) {
	     	var url = '../reportes/acta_entrega';
			 enlace = url+'?id='+referencia + '&formato=0' ;
		 
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}


		if ( tipo == 3) {
		    var url = '../reportes/acta_entrega';
		    enlace = url+'?id='+referencia + '&formato=1' ;
		 
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	  //--------------------
	  if ( tipo == 2) {
		  
		  alertify.confirm("Desea Anular documento Acta ", function (e) {
			  if (e) {
				 
					 var parametros = {
							 'idacta' : referencia 
			         };
				 
                 	
				   $.ajax({
						 data:  parametros,
						 url: "../model/ajax_anula_acta.php",
						 type: "GET",
				       success: function(response)
				       {

				    		   $('#Actanegada').html(response);
				    	  
				    		 
				       }
					 });
				   BusquedaGrillaCustodio(oTable_doc);
					 
			  }
			 }); 
	  }
	  
	} 
 //---------------------------------
 function BuscaPrograma( codigo) {
	 	
 
		 var parametros = {
 					 'codigo' : codigo,
					 'tipo'   : 0
		  };
			 
			
		   $.ajax({
				 data:  parametros,
				 url: "../model/ajax_bienes_sede_uni.php",
				 type: "GET",
		       success: function(response)
		       {
  
		    		   $('#Vid_departamento').html(response);
		    	  
		    		 
		       }
			 });
	 
			 
		} 

	function EnviaCorreoFuncionario( codigo) {

	var id_acta   = $("#id_acta").val ();
	if (codigo) {
		var id_acta   = codigo;
	}

	var parametros = {
		'id_acta' : id_acta,
	};

	// alert(id_acta);
	// return;

	$.ajax({
		data:  parametros,
		url: "../model/acta_envio_correo_notificacion.php",
		type: "GET",
		success: function(response)
		{
			$('#Vid_departamento').html(response);
			alert("Notificación enviada al funcionario");
		}
	});


	} 