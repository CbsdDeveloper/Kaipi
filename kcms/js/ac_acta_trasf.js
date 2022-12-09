var oTable_doc;

var formulario = 'ac_acta_trasf';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
         
        oTable_doc			= $('#jsontable').dataTable(); 
        
        
          
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrillaCustodio(oTable_doc);
          
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
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					
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
	$("#clase_documento").val("Acta Trasferencia de Bienes");
	$("#documento").val("");
 
	$("#estado").val("N");
	$("#detalle").val("Acta de Trasferencia de Bienes generada " + fecha_hoy());
 
	 
}
//-------------
function DetalleActivosNoAsignados( ) {
	   
	
	
	var idprov =	$("#idprov").val ();
	

	 var parametros = {
				 'idprov'  : idprov ,
				 'accion' : '0'
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-_bien_asignado_tras.php",
			 type: "GET",
	       success: function(data)
	       {
	           $('#DetalleActivosNoAsignado').html(data);
	       }
		 });
	 
 
	 
}
//-------------------------------------------
function DetalleActivosNoAsignadosLista( ) {
	   
	
	
	var idprov =	$("#idprov").val ();
	

	 var parametros = {
				 'idprov'  : idprov,  
				 'accion' : '1'
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-_bien_asignado_tras.php",
			 type: "GET",
	       success: function(data)
	       {
	           $('#DetalleActivosNoAsignado').html(data);
	       }
		 });
	 
 
	 
}
//----------------------------------------
function BuscaCustodio( idunidad,tipo) {
	   
	var vidsede =	$("#vidsede").val ();
	
	 var parametros = {
				 'idunidad'  : idunidad ,
				 'vidsede' : vidsede,
				 'tipo' :tipo
	  };
		 
		
	   $.ajax({
			 data:  parametros,
			 url: "../model/Model_ac_auto_lista_custodio.php",
			 type: "GET",
	       success: function(response)
	       {
	    	   if ( tipo == 0){
	    		   
	    		   $('#Vid_departamento').html(response);
	    		   
	    	   }else{
	    		   
	    		   $('#Vidprov').html(response);
	    		   
	    	   }
	        
	       }
		 });
 
		 
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
   
 //----------------- ViewForm
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');
	 
 }
//-------------------
 function MarcarTodo(codigo ) {
		
	    
	    var  accion 		    =  'trasfer';
	    var  idprov 		    =  $("#idprov").val();
		

	    var parametros = {
            'accion' : accion ,
            'codigo' : codigo ,
            'idprov' : idprov

	  };

 
 $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_listaCheckTras.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#GuardaDato").html('Procesando');
							},
						success:  function (data) {
								 $("#GuardaDato").html(data);   
							} 

				}); 

 DetalleActivosNoAsignadosLista( );
 
}
//--------------- 
 function BusquedaGrillaCustodio(oTable_doc){       
 	 
	 
	 	var idprov	= 	$("#Vidprov").val ();
 	 	
	    var parametros = {
	 				'idprov' : idprov  
					};
	  
		  
	    var text = $( "#Vidprov option:selected" ).text();
	    
	    $("#custodio").html(idprov + ' ' + text );
	    
	    $("#razon").val (text);
	    $("#idprov").val (idprov);
	    
	    
	    
 
	 	  
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
 	    					'<button class="btn btn-xs" title = "Visor de informacion Documento" onClick="javascript:goToURLvisor(' +   s[i][0]  +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' +
	    					'<button class="btn btn-xs" title = "Generacion y Emision de Acta" onClick="javascript:goToURLdoc(1,' +   s[i][0]   +')"><i class="glyphicon glyphicon-file"></i></button>&nbsp;'  +
	    					'<button class="btn btn-xs" title = "Notificar por correo electronico" onClick="javascript:goToURLdoc(2,' +   s[i][0]   +')"><i class="glyphicon glyphicon-send"></i></button>&nbsp;'
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
 
 
//-----------------
 function printDiv(divID) {
	 
	 var objeto=document.getElementById(divID);  //obtenemos el objeto a imprimir
	 
	  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	  
	  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	  ventana.document.close();  //cerramos el documento
	  ventana.print();  //imprimimos la ventana
	  ventana.close();  //cerramos la ventana
        
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
		    enlace = url+'?id='+referencia  ;
		 
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
//----------------------------
 function impresion( ) {

	  var ancho = 800; 
	  var alto = 550; 
	  var posicion_x ; 
	  var posicion_y ; 
	  var enlace; 
	 
	  var referencia = 	$("#id_acta").val();
	  
	  posicion_x=(screen.width/2)-(ancho/2); 
	  posicion_y=(screen.height/2)-(alto/2); 

	  
	  if ( referencia >=  1) {
		    var url = '../reportes/acta_entrega';
		    enlace = url+'?id='+referencia  ;
		 
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
 