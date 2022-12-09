var oTableProducto;

var oTable;

var formulario = 'ven_seg';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
          
	     oTable			= $('#jsontable_producto').dataTable(); 
  
         
          
         FormView();
      
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
	      
  
		modulo();
		
		$("a[rel='pop-up']").click(function () {
	      	var caracteristicas = "height=500,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
	      	nueva=window.open(this.href, 'Popup', caracteristicas);
	      	return false;
		 });
  
});  
 
//-------------------------------------------------------------

 function accion(id,modo)
{
  
			$("#action").val(modo);
			
			$("#idvengestion").val(id);          

			VerActividadActualiza() ;

}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	 
                     
					$("#action").val("add");
					 
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
function goToURL(  ) {
	
	
	LimpiarPantalla();
	
	var idcliente = $("#idcliente").val();
	
	var idvengestion = $("#idvengestion").val();
 	
	var razon =  $("#nombre").val();
	
	var accion = 'editar';
	
 	$("#action").val(accion);
 	 	
	$("#razon_nombre").val(razon);
	   
	 $("#idprov1").val(idcliente);
	 
	var parametros = {
					'idcliente' : idcliente ,
                    'idvengestion' : idvengestion ,
                    'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_fin.php',
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
//ir a la opcion de editar
function goToURLEditor( accion,idcliente, idvengestion,razon) {
	
	  $("#idcliente").val(idcliente) ;
	  
	  $("#idcliente").val(idprov) ;
	
	  $("#idvengestion").val(idvengestion);
   
	  $("#action").val(accion);
	 
	  $("#nombre").val(razon);
	 	
	  $("#razon_nombre").val(razon);
	  
	  $("#idprov1").val(idcliente);
	   
	var parametros = {
					'idcliente' : idcliente ,
                    'idvengestion' : idvengestion ,
                    'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_pedido.php',
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
//----------------
function goToURLProd( accion,idcodigo ) {
	
  var idvengestion = $("#idvengestion_pro").val();
	   
	var parametros = {
					'id' : idcodigo ,
                    'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_prod_cli.php',
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
	   
		 BusquedaProd(oTable,idvengestion);
		 

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
		   
		  BusquedaDoc(oTableProducto,idvengestion);
			 

	    }


//----------------
function goToURLFile(  cfile ) {
	
	
	 window.open(cfile , '_blank');
	 
 
	
}

function goToURLCIU(  ) {
	
	var idcliente = $("#idcliente").val();
	
    var accion = 'editar';
	
    $("#actionCiu").val("editar");
	 
    
 
	var parametros = {
					'idcliente' : idcliente ,
                     'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inte_clientes_fin.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 						    	$("#guardarCliente").html('Procesando');
  					},
					success:  function (data) {
 
							    $("#guardarCliente").html(data);
 							
  					} 
			}); 

    }
///--------------------------------------------------------
function ClienteCIU(  ) {
	
	var idcliente = $("#idcliente").val();
	var razon = $("#razon").val();
	var idvengestion     = $("#idvengestion").val();
	
	
	var parametros = {
			'idcliente' : idcliente  ,
			'idvengestion' : idvengestion
    };
	
	 
		  alertify.confirm("Actualizar la informacion al modulo de Clientes?", function (e) {
		  if (e) {
			 
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-inte_clientes_enlace.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
						    	$("#mensaje_ciu").html('Procesando');
					},
					success:  function (data) {

							    $("#mensaje_ciu").html(data);
							
					} 
			}); 
 		   }
		 }); 
   }
//--  CerrarFactura
//---------------------
function CerrarFactura(  ) {
	
	var idcliente 		 = $("#idcliente").val();
	var razon    		 = $("#razon").val();
	var idvengestion     = $("#idvengestion").val();
	
	
	var parametros = {
			'idcliente' : idcliente  ,
			'idvengestion' : idvengestion
    };
	
	 
		  alertify.confirm("Desea Cerrar proceso de venta?", function (e) {
		  if (e) {
			 
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-inte_clientes_precierre.php',
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
//---------------------
function ClienteFactura(  ) {
	
	var idcliente 		 = $("#idcliente").val();
	var razon    		 = $("#razon").val();
	var idvengestion     = $("#idvengestion").val();
	
	
	var parametros = {
			'idcliente' : idcliente  ,
			'idvengestion' : idvengestion
    };
	
	 
		  alertify.confirm("Desea generar prefactura de servicios/bienes?", function (e) {
		  if (e) {
			 
			  $.ajax({
					data:  parametros,
					url:   '../model/Model-inte_clientes_prefactura.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
						    	$("#mensaje_factura").html('Procesando');
					},
					success:  function (data) {

							    $("#mensaje_factura").html(data);
							
					} 
			}); 
 		   }
		 }); 
	
}
//----------------  ViewFormActividad
function VerActividad(idcliente,nombre,idvengestion) {

	var accion = 1;
 	
	$("#idvengestion").val(idvengestion);
 	$("#idcliente").val(idcliente);
	$("#nombre").val(nombre);
	
 	$("#idprov").val(idcliente);
	$("#razon").val(nombre);
	$("#idvengestion_pro").val(idvengestion);
	
	$("#actionProducto").val('add');
	
	$("#idproducto").val('');
	$("#detalle").val('');
	$("#producto").val('');
	
	$("#guardarProducto").html('Agregue los productos que va a realizar la venta');
	
	var parametros = {
					'accion' : accion ,
                    'idcliente' : idcliente,
                    'idvengestion':idvengestion
 	  };
	/*
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_seg_ac.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#BandejaHistorial").html('Procesando');
  					},
					success:  function (data) {
						
							 $("#BandejaHistorial").html(data);  
						     
						 	
							 
						//	 BusquedaDoc(oTableProducto,idvengestion);
  					} 
			}); 
*/
    }
//----------------------------------------
function VerAvance(idcliente,idvengestion) {


	var parametros = {
                     'idcliente' : idcliente ,
                     'idvengestion':idvengestion,
                     'accion':1
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_avance.php' ,
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
              'idcliente' : idcliente ,
              'idvengestion':idvengestion,
              'accion':2
};
	  
	  $.ajax({
			data:  parametros1,
			url:   '../model/Model-ven_avance.php' ,
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#ViewAvancedias").html('Procesando');
			},
			success:  function (data) {
					 $("#ViewAvancedias").html(data);  
				     
			} 
	}); 
	  
	 
	  VerOrden();
	  
	  VerCotizacion();
	  
  }
//--------------------------------------
function VerCotizacion(){
	
	 var idcliente = $("#idcliente").val();
	  
	 var idvengestion = $("#idvengestion").val();
 	 
	 var razon =  $("#nombre").val();
	
	  
	
 
    	var parametros = {
									"idcliente"   : idcliente ,
									"razon"       :razon,
									"idvengestion": idvengestion
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ven_seg_cotizar_visor.php',
									dataType: "json",
									success:  function (response) {
 	 
										 $("#editor2").html(response.a);
 										 
 								    	 $("#editor3").html(response.b);
								    	
								    	 $("#id_cotizacion").val( response.c );   
								    	 
									    
											  
									} 
							});
		 
			 
}
//--------------------------------------
function VerOrden(){
	
	 var idcliente = $("#idcliente").val();
	  
	 var idvengestion = $("#idvengestion").val();
 	 
	 var razon =  $("#nombre").val();
	
	 
 
    	var parametros = {
									"idcliente"   : idcliente ,
									"razon"       :razon,
									"idvengestion": idvengestion
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ven_seg_orden_visor.php',
									dataType: "json",
									success:  function (response) {
 	 
 									 
 										 $("#editor6").html(response.a);
 										 
 								    	 $("#editor5").html(response.b);
								    	
								    	 $("#id_orden").val( response.c );   
											  
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
function GuardarCotizacion(){
	
	var id_cotizacion =  $("#id_cotizacion").val( );   
 	var modulo        =  'preventa';   
	var idcliente     =  $("#idcliente").val();
 	var razon         =  $("#nombre").val();
	var accion        =  'add';
	var idvengestion  =  $("#idvengestion").val();
	
	var editor2 = tinyMCE.get('editor2').getContent();
	
	var editor3 = tinyMCE.get('editor3').getContent();
	
	 alertify.confirm("<p>Desea guarda parametros de cotizacion<br><br></p>", function (e) {
		 
		  if (e) {
			 
		  	 if (id_cotizacion  > '0' ){
		  		accion = 'edit';
		  	 }else{
		  		accion = 'add'; 
		  	 }
                
		  	var parametros = {
					 'id_cotizacion' : id_cotizacion ,
                     'modulo' : modulo ,
                     'idcliente' : idcliente ,
                     'razon' : razon ,
                     'accion': accion,
                     'editor2':editor2,
                     'editor3':editor3,
                     'idvengestion':idvengestion
 	        };
	
	        $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_seg_cotizadd.php',
					type:  'POST' ,
					cache: false,
					success:  function (data) {
 
							 alert('Nro. Cotizacion generada ' + data);
							 
							 $("#id_cotizacion").val( data );   
 							
  					} 
			}); 
		  	
				 
				 
		  }
		 });
	 
}
//---------------------------
///------------------------
function VerHistorial( id, nombre,idvengestion )
{
  
 
    $("#idvengestion").val(idvengestion);
	$("#nombre_actual").html('<img src="../../kimages/mano.png" align="absmiddle"/> <b>[ '+nombre+' ] </b>');
	$("#nombre").val(nombre);
	$("#idcliente").val(id);
 	$("#razon").val(nombre);
	$("#idprov").val(id);
	
	$("#mensaje_ciu").html('');
	$("#mensaje_proceso").html('');
	$("#mensaje_factura").html('');
 
	 
	VerActividad(id,nombre,idvengestion);
	
	BusquedaProd(oTable,idvengestion)   
    
    VerAvance(id,idvengestion);
} 

//-----------
function VerActividadActualiza() {

	var accion = 1;
	var idcliente	 = $("#idcliente").val( );
 	var idvengestion = $("#idvengestion").val( );
 	
 
	 
	var parametros = {
			'accion' : accion ,
            'idcliente' : idcliente,
            'idvengestion':idvengestion
    };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_seg_ac.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormActividad").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewFormActividad").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
//-------------------------------------------------------------------------
function llamadoc() {
	

	var id = $("#idvengestion_pro").val();
	
    var posicion_x; 
    var posicion_y; 
    var url = '../view/docuload?id='+id;
    
    ancho = 560;
    alto = 300;
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
  
    if ( id > 0 )   {
    	  window.open(url, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
    }
  
   
    
}
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
	
	$("#estado").val("");
	$("#proceso").val("");
	$("#medio").val("");
	$("#canal").val("");
	$("#sesion").val("");
	$("#novedad").val("");
	
	$("#fecha").val(fecha);
	
	$("#producto").val("");
	$("#porcentaje").val("");
	
	
    }
//----------------------------------------------
function limpiaEmail() {
   
	 
	ListaEmailDe() ;
	
	$("#tasunto").val("");
 	
	$("#editor1").attr("value", "");
	   
 	$("#mensaje_enviado").html("");
 	
 	
 
 }
//----------------------------------------------
function limpiaEmailEnvio(mensaje) {
   
 	
	alert(mensaje) ;
	
	$("#tasunto").val("");
 	
	$("#editor1").attr("value", "");
  
  
 	 
 	$("#mensaje_enviado").html("");
 	
 	 $('#myModalEmailMensaje').modal('hide');  
 
 }
//---------------------------------------------
function ListaEmailDe() {

	var parametros = {
			 'bandera' : 0
     };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/ListaDeEmail.php",
		 type: "GET",
       success: function(response)
       {
           $('#tde').html(response);
       }
	 });
 
}
//----------------------------------------------
function limpiaProducto() {
   
 	
	$("#detalle").val("");
    
	$("#idproducto").val("");
 	
	$("#cantidad").val("1");
 	
	$("#tarifa").val("12");
 	
	$("#descuento").val("0");
 
	$("#precio").val("0");
	
	/*	 CKEDITOR.instances.editor1.setData( '' );
	
	
 	$("#mensaje_enviado").html("");
 */
 }
 
///----------------
 function BuscaCanton(cprov)
 {
    
	 var parametros = {
			 'cprov'  : cprov  
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_buscaCanton.php",
		 type: "GET",
        success: function(response)
        {
            $('#vcanton').html(response);
        }
	 });
      
 } 
 ///--
 function BuscaCantond(cprov)
 {
    
	 var parametros = {
			 'cprov'  : cprov  
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_buscaCanton.php",
		 type: "GET",
        success: function(response)
        {
            $('#canton').html(response);
        }
	 });
      
 }  
 
 function BusquedaGrilla(cumplimiento,estado,nombre){        	 
	 
 	    var parametros = {
				 'estado' : estado,
				 'pagina': 0
	   };
	    
	    $("#estado1").val(estado);
	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-SegCliente.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
		 
		 
		   $("#etiqueta_estado").html(nombre);
		   
		   
		 if ( estado == '12') {
			 $('#BtActividad').attr("disabled", true);
		 }else {
			 $('#BtActividad').attr("disabled", false); 
		 }
		 
		 
		 
	 		 
		 $("#pag").val(0);
		
		 $("#nombre_actual").html('[ Seleccionar cliente ]</b>');
		 $("#nombre").val('');
		 $("#idcliente").val('');
		 $("#razon").val('');
		 $("#idprov").val('');
			
		 $("#ViewAvancedias").html('');  
		 $("#ViewAvance").html('');  
		 
 
			$("#mensaje_ciu").html('');
			$("#mensaje_proceso").html('');
			$("#mensaje_factura").html('');
		  
		 tab_show( );
	
}   
//------------
 function tab_show( ){     
	  
	 $('#mytabs a[href="#home"]').tab('show');
 }
//----------------------------
  function BusquedaProd(oTable,idseg){        
	  
      var parametros = {
				'id' : idseg , 
       };

   	$.ajax({
		 	data:  parametros,  
		    url: '../grilla/grilla_ven_prod.php',
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
                            s[i][7]
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
//----------------------------
  function BusquedaDoc(oTableProducto,idseg){        
	  
 
   
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
 							'  &nbsp; <button class="btn btn-xs" onClick="javascript:goToURLProd('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			 }						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		 
}  
  //------------------------------
   function ImprimirCotizacion(  ) {

	   var url = '../reportes/Cotizacion'
		   
		   
		    var variable         = $("#idcliente").val();
		   
		    var id_cotizacion    = $("#id_cotizacion").val().trim();
		    
		    var idvengestion     = $("#idvengestion").val();
			 
			 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+variable +'&cotiza=' + id_cotizacion +'&idvengestion=' + idvengestion     ;
		    
		    var ancho = 1000;
		    
		    var alto = 520;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

}
   //-------------
   function ImprimirOrden(  ) {

	   var url = '../reportes/orden'
		   
		   
		    var variable         = $("#idcliente").val();
		   
		    var id_cotizacion    = $("#id_orden").val().trim();
		    
		    var idvengestion     = $("#idvengestion").val();
			 
			 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+variable +'&cotiza=' + id_cotizacion +'&idvengestion=' + idvengestion     ;
		    
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
function ListaEmail(seguimiento_cliente){        	 

	  var parametros = {
				'seguimiento_cliente' : seguimiento_cliente  
	  };

		
		$.ajax({
			data:  parametros,
			 url:   '../model/Model-SegCliEmail.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#lista_enviados").html('Procesando');
				},
			success:  function (data) {
					 $("#lista_enviados").html(data);  // $("#cuenta").html(response);
				     
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
 	 var modulo =  'kventas';
 	 
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
    

	 $("#ViewFormCliente").load('../controller/Controller-ven_fin.php');
      
	 $("#ViewFormProducto").load('../controller/Controller_ven_prod.php'  );
	 
	 $("#ViewFormProv").load('../controller/Controller-inte_clientes_fin.php');
	 
 }
 
//----------------------
 function FormFiltro()
 {
  
	 
	 

 }
//-----------------
 function abrirGoogle()
 {
    

	 	var idprov = $("#idprov").val();
	 	 
	 	window.open('https://www.google.com.ec/search?q='+idprov,'_blank');
      

 }
 
 function EnviarWhatsapp()
 {
    
	   var tfono =   $.trim( $("#tfono").val()   )  ;
	 	var tasunto = $.trim( $("#tmensajee").val() );
	 
	 if (tasunto)	 {
		   
 	 	window.open('https://api.whatsapp.com/send?phone='+tfono+'&text='+tasunto,'_blank');
      
	 }
 }
 
    
  