$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


var oTable;
var oTableProducto;

var formulario = 'ven_seg';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
         oTable = $('#jsontable_producto').dataTable(); 
         
         oTableProducto = $('#jsontable_doc').dataTable(); 
         
 
         
         FormView();
      
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		
		modulo();
        
		
		Calendario_seguimiento() ;
        
        
 	    BusquedaGrilla();
 		
 	   
	  
  
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
	
	var idcliente = $("#idcliente").val();
	
	var idvengestion = $("#idvengestion").val();
	
	var accion;
 
	LimpiarPantalla();
	
	 accion = 'editar';
	 $("#action").val("editar");
	 
	   
	var parametros = {
					'idcliente' : idcliente ,
                    'idvengestion' : idvengestion ,
                    'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_seg.php',
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


//---------------- 
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
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_seg_ac.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormActividad").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewFormActividad").html(data);  
							 
							 VerAvance(idcliente);
						     
							 ListaEmail(idvengestion);
							 
							 BusquedaProd(oTable,idvengestion);
							 
							 BusquedaDoc(oTableProducto,idvengestion);
  					} 
			}); 

    }
//----------------------------------------
function VerAvance(idcliente) {

 
	var idvengestion = $("#idvengestion").val( );
  	
	var parametros = {
                     'idcliente' : idcliente ,
                     'idvengestion':idvengestion
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
							 $("#ViewAvance").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

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


//-------------------------------------------------------------------------

var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	
	$("#estado").val("");
	$("#proceso").val("");
	$("#medio").val("");
	$("#canal").val("");
	$("#sesion").val("");
	$("#novedad").val("");
	$("#fecha").val("");
	$("#producto").val("");
	$("#porcentaje").val("");
	
	
    }
//----------------------------------------------
function limpiaEmail() {
   
	alert('Nuevo Mensaje');
	
	$("#tasunto").val("");
 	
	$("#editor1").attr("value", "");
	 	
 
	 CKEDITOR.instances.editor1.setData( '' );
	
	
 	$("#mensaje_enviado").html("");
 
 }
//----------------------------------------------
function limpiaEmailEnvio() {
   
 	
	$("#tasunto").val("");
 	
	$("#editor1").attr("value", "");
  
	 CKEDITOR.instances.editor1.setData( '' );
	
	
 	$("#mensaje_enviado").html("");
 
 }
//----------------------------------------------
function limpiaProducto() {
   
 	
/*	$("#tasunto").val("");
 	
	$("#editor1").attr("value", "");
  
	 CKEDITOR.instances.editor1.setData( '' );
	
	
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
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(){        	 

 
  	$.ajax({
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
							'<button class="btn btn-xs" onClick="javascript:goToURLProd('+"'del'"+','+ s[i][5] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
    

	 $("#ViewFormCliente").load('../controller/Controller-' + formulario);
      
	 $("#ViewFormProducto").load('../controller/Controller_ven_prod.php'  );
	 

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
    
  