var oTable;

var formulario = 'ac_bienes';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});
//---------------------
function validaCampos()
{
	var objetos = ["#clase_esigef", "#clasificador", "#identificador", "#idprov","#material","#detalle_ubica","#razon"];
 
 
	var longitud = objetos.length;
	
	var nombre = '';
	var objeto = '';
	var valor  = '';
	var lon ;
	var valida = 0;
	var cadena = "";
	
	for (i = 0; i < longitud; i++) {
		
		nombre  = objetos[i];
		objeto  = $(nombre).val();
		valor   = new String(objeto);
		lon 	= valor.length;
		 
		 
		if (valor == 'null' ){
			cadena = cadena + nombre + ' <br>';
			valida = 1;
		}else{
			if ( lon < 2 ) {
				cadena = cadena + nombre + ' <br>';
				valida = 1;
			} 
		}
 
 
 }
	
	if ( valida == 1 ){
		 cadena = '<b>Advertencia campos obligatorios: <br>' + cadena + '</b>';
		 $('#result').html(cadena);
	}
	
}
//-------
function open_spop_marca(url,ovar,ancho,alto) {

	var posicion_x; 

	var posicion_y; 

	var enlace; 

	var tipo = $("#tipo_bien").val();
	 
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 

	enlace = url +'?tipo='+tipo;

	window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');



}
//----------------------------------
function open_spop_modelo(url,ovar,ancho,alto) {
    var posicion_x; 
    var posicion_y; 
    var enlace; 
	 
    
    var id_marca = $("#id_marca").val();
 
   			
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    enlace = url +'?id='+id_marca;
    window.open(enlace,
   		 	 '#',
   		 	 'width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+',toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no');

  
}	
//----
function BuscaTramite()
{
	  
 
    var  idprov     = $("#idproveedor").val();
    
    var parametros = {
            'idprov' : idprov 
    };
    
	  
	$.ajax({
 			 url:   '../model/ajax_tramiteInventario.php',
			type:  'GET' ,
			data:  parametros,
			cache: false,
			beforeSend: function () { 
						$("#VisorTramite").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorTramite").html(data);   
				     
				} 
	});

}
//-----
function deltramite(tipo,idtramite,fila)
{
	  
	$("#id_tramite").val(idtramite);
	
	
 	 var id1;
	 var id2 ;
	  	 
 		  id1 = document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[3].innerHTML;
		  id2 = document.getElementById('tablaBasica').tBodies[0].rows[fila].cells[4].innerHTML;
		  
		//  id_departamento
  
 		    $("#documento").val(id1);   
		    
		    var str 	= id2;
		    var cadena  = str.trim();
 		  
 
		  
		  
	$('#myModalTramite').modal('hide');

}
//--url_ficha_compra
function url_ficha_compra(url){        
	
	var a    = $('#id_tramite').val();
	var b    = $('#factura').val();
	var c    = $('#idproveedor').val();
   
 
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?a='+ a +'&b='+ b +'&c='+c  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//--
function url_ficha(url){        
	
	var variable    = $('#id_bien').val();
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
 //
 function url_ficha_d(tipo, id_bien,a,b,c){        
	
	var variable    = id_bien;
	var posicion_x; 
	var posicion_y; 

	if ( tipo == '1'){        
		var url = '../reportes/fichaActivo';
	
		var enlace = url + '?codigo='+variable  ;
		
		var ancho = 1000;
		
		var alto = 520;
		
		posicion_x=(screen.width/2)-(ancho/2); 
		
		posicion_y=(screen.height/2)-(alto/2); 
		
		window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
	 }else{        
		var url = '../reportes/fichaActivoCompra';
	 
		var posicion_x; 
		var posicion_y; 
		
		var enlace = url + '?a='+ a +'&b='+ b +'&c='+c  ;
		
		var ancho = 1000;
		
		var alto = 520;
		
		posicion_x=(screen.width/2)-(ancho/2); 
		
		posicion_y=(screen.height/2)-(alto/2); 
		
		window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
	 }
 
 
 }
//-------------------------------------------------------------------------
$(document).ready(function(){
    
   
        oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 2 ] },
  		      { "sClass": "de", "aTargets": [ 3 ] },
  		      { "sClass": "di", "aTargets": [ 6 ] },
  		    ] 
       } );
        
        
       
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable);
          
		});


		 	   
		$('#load1').on('click',function(){
	 		 
			BusquedaGrilla1(oTable);
		 
	   });
	    
	     $("#saveAsExcel").click(function(){
 
	    	   enlace = '../model/_exporta_excel.php' ;
	    	 										   
	    	   var win = window.open(enlace, '_blank');
	    	   
	    	   win.focus();
	       
	      
	     });
 


 $('#loadt').on('click',function(){
 	 		 
	    	 CargaDatos();
	           
	 		});
		
});  
function CargaDatos() {


	var idtramite =  $("#id_tramite").val();
	 

	var parametros = {
            'id' : idtramite 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/ajax-fin_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewFormRuta").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormRuta").html(data);  // $("#cuenta").html(response);
					     
					} 
		}); 
 
} 
//-----------------------------------------
function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}
//----------------------------------------
function verdocumento_bien(id)
{
 
 		 
	 var parametros = {
			    'id' : id,
			    'accion' : 'visor'
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ac_bienes_doc_view',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormfile").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormfile").html(data);  
				     
				} 
	});
     

} 
//--------admin_clases
//----------------
function selecciona_tipo(tipo)
{
 
 		 
  var parametros = {
 			    'tipo' : tipo
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_selecciona_tipo_e.php',
			type:  'GET'  ,
			success:  function (data) {
					 $("#lclase").html(data);  
				     
					 $("#clase").val('');  
					 $("#clasificador").val('');  
					 $("#clase_esigef").val('');  
					 $("#cuenta").val('-');  
				} 
	});
     

}
//---------------------------------------------------------------------
function verComponente_bien(id)
{
 
 		 
  var parametros = {
			    'id' : id,
			    'accion' : 'visor'
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ac_bienes_componente.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormComponentes").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormComponentes").html(data);  
				     
				} 
	});
     

}
//------------------------------------------
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
					 
					verdocumento_bien(0);
				 	
				 	verComponente_bien(0);
				 	
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
function CopiarBien( ) {
	
	var id_bien = $("#id_bien").val ();
	
	  var parametros = {
			    'id' : id_bien,
			    'accion' : 'copiar'
       };
	  
 		 
		
		  alertify.confirm("DESEA COPIAR EL CODIGO DE TRANSACCION DEL BIEN ( " + id_bien + ' )' , function (e) {
		  if (e) {
        		  
			$.ajax({
					data:  parametros,
				     url:   '../model/Model-'+ formulario,
					type:  'GET' ,
 					success:  function (resultado) {
 						
						$("#result").html(resultado);
						     
						alert('Verifique la informacion y complete la informacion ...edite el registro');
						} 
			});
				 
		  }
		 }); 
		  
}		 
//-------------------- nombre_bien lote_bien tramite_bien proveedor_bien lote_bien
 function GeneraLotes_bien( ) {
	
 
		var id_bien   = $("#id_bien").val ();
		var lote_bien = $("#lote_bien").val ();
		
		
		  var parametros = {
				    'id' : id_bien,
				    'lote_bien' : lote_bien,
				    'accion' : 'lotes'
	       };
		  
	 		 
		if ( lote_bien > 1 )	{
			  alertify.confirm("DESEA GENERAR LOTE TRANSACCION DEL BIEN ( " + id_bien + ' )' , function (e) {
			  if (e) {
	        		  
				$.ajax({
						data:  parametros,
					     url:   '../model/Model-'+ formulario,
						type:  'GET' ,
	 					success:  function (resultado) {
	 						
							$("#result").html(resultado);
							     
							alert('Verifique la informacion y complete la informacion ...edite el registro');
							} 
				});
					 
			  }
			 }); 
		}		 
}
 //------------------------------------------------------------
function Generarlote( ) {


	var proveedor     = $("#proveedor").val ();
	var lote_bien     = $("#forma_ingreso").val ();
	var nombre_bien   = $("#descripcion").val ();
	var tramite_bien  = $("#id_tramite").val ();
	
	if ( lote_bien == 'Lote')  {
		
		$("#nombre_bien").val (nombre_bien);
		$("#forma_bien").val (lote_bien);
		$("#tramite_bien").val (tramite_bien);
		$("#proveedor_bien").val (proveedor);
		$("#lote_bien").val ('0');
 		
		
		$('#myModalLote').modal('show');
		
	}

	
	
}		 
//--------------------------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}

//--------------

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
//----------------------------------------------------------
function _asigna(variable,valor) {
	
	
	var objeto = '#'+variable;
	
	var variable_asiga = valor;
	
	if (valor){
 	
			if(variable_asiga.length > 0) {
				
				$(objeto).val(variable_asiga.trim() );
				
			}else{
				
				$(objeto).val('');
			}
	}		
	else{
		
		$(objeto).val('');
		
	}
   
	
}
// ir a la opcion de editar
function goToURL(accion,id) {

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
					
			 
				_asigna('id_bien',respuesta.id_bien);
				
				_asigna('fecha',respuesta.fecha);
				_asigna('forma_ingreso',respuesta.forma_ingreso);
				_asigna('identificador',respuesta.identificador);
				_asigna('descripcion',respuesta.descripcion);
				_asigna('tipo_bien',respuesta.tipo_bien);
				
				
				
				_asigna('clase_esigef',respuesta.clase_esigef);
				
				
				_asigna('origen_ingreso',respuesta.origen_ingreso);
				_asigna('tipo_documento',respuesta.tipo_documento);
				_asigna('clase_documento',respuesta.clase_documento);
				_asigna('tipo_comprobante',respuesta.tipo_comprobante);
				_asigna('fecha_comprobante',respuesta.fecha_comprobante);
				
				_asigna('codigo_actual',respuesta.codigo_actual);
				_asigna('estado',respuesta.estado);
				_asigna('costo_adquisicion',respuesta.costo_adquisicion);
				_asigna('depreciacion',respuesta.depreciacion);
 
				_asigna('serie',respuesta.serie);
				_asigna('id_marca',respuesta.id_marca);
  
				_asigna('valor_residual',respuesta.valor_residual);
				_asigna('anio_depre',respuesta.anio_depre);
				_asigna('vida_util',respuesta.vida_util);
				_asigna('color',respuesta.color);
				
				_asigna('dimension',respuesta.dimension);
				_asigna('uso',respuesta.uso);
 
				_asigna('fecha_adquisicion',respuesta.fecha_adquisicion);
				_asigna('clase',respuesta.clase);
			 
				_asigna('material',respuesta.material);
				_asigna('id_departamento',respuesta.id_departamento);
				_asigna('tiene_acta',respuesta.tiene_acta);
 
				_asigna('tipo_ubicacion',respuesta.tipo_ubicacion);
				_asigna('detalle',respuesta.detalle);
				_asigna('idsede',respuesta.idsede);
				
				_asigna('detalle_ubica',respuesta.detalle_ubica);
				_asigna('cuenta_parametro',respuesta.cuenta_parametro);
				
 
				_asigna('id_tramite',respuesta.id_tramite);
				_asigna('clasificador',respuesta.clasificador);
				_asigna('cuenta',respuesta.cuenta);
				
				_asigna('garantia',respuesta.garantia);
				_asigna('razon',respuesta.razon);
				_asigna('idprov',respuesta.idprov);
  
				_asigna('marca',respuesta.marca);
				_asigna('tiempo_garantia',respuesta.tiempo_garantia);
 
				_asigna('idproveedor',respuesta.idproveedor);
				_asigna('proveedor',respuesta.proveedor);
				
				_asigna('factura',respuesta.factura);
 				
				$("#action").val(accion); 
			 	$("#result").html(resultado);
			 
			 	var carro = respuesta.carro;
			 		
			 	if ( carro == 1 ){
			 		_asigna('clase_ve',respuesta.clase_ve);
			 		_asigna('motor_ve',respuesta.motor_ve);
			 		_asigna('chasis_ve',respuesta.chasis_ve);
			 		_asigna('placa_ve',respuesta.placa_ve);
			 		_asigna('anio_ve',respuesta.anio_ve);
			 		_asigna('color_ve',respuesta.color_ve);
   
			 	}
  		            
			 	_asigna('cuenta',respuesta.cuenta);
			 	
  				VerVariables(respuesta.cuenta);
			 	
			 	var id_modelo = respuesta.id_modelo;
			 		
			 	ListaModeloAsignado(respuesta.id_marca,id_modelo) ;
  			 	  
			 	verdocumento_bien(respuesta.id_bien);
			 	
			 	verComponente_bien(respuesta.id_bien);
			 
				
				 
			});
 
		$("#secuencia").html('');  
	 
		
 		 

  

	
 	$('#mytabs a[href="#tab2"]').tab('show');
	  
}
//----------------------

function goToURLDocdel(id_bien_grafico, idbien)
{
 
 		 
	 var parametros = {
			    'id' : idbien,
			    'id_bien_grafico' : id_bien_grafico,
			    'accion' : 'del'
   };
	  
	  alertify.confirm("Desea eliminar Documento? ", function (e) {
		  if (e) {
			 
             	
			  $.ajax({
					data:  parametros,
					 url:   '../model/Model-ac_bienes_doc_view',
					type:  'GET' ,
						beforeSend: function () { 
								$("#ViewFormfile").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewFormfile").html(data);  
						     
						} 
			});
				 
		  }
		 }); 
	  
 
}
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	 
 
	$("#fecha").val(fecha_hoy());
	$("#forma_ingreso").val(fecha_hoy());
	$("#fecha_comprobante").val(fecha_hoy());

	$("#tipo").val("");
	$("#tipo_bien").val("");
	$("#identificador").val("");
	$("#descripcion").val("");
	
	$("#id_bien").val("");
	
	$("#clase_esigef").val("");
	
	

	$("#origen_ingreso").val("");
	$("#tipo_documento").val("");
	$("#clase_documento").val("");
	$("#tipo_comprobante").val("");
	$("#fecha_comprobante").val(fecha_hoy());
	$("#codigo_actual").val("S/D");
	$("#estado").val("");
	$("#costo_adquisicion").val("");
	$("#depreciacion").val("");
	$("#serie").val("S/D");
	$("#id_modelo").val("");
	$("#id_marca").val("");
	$("#clasificador").val("");
	$("#cuenta").val("");
	$("#valor_residual").val("");
	$("#anio_depre").val("");
	$("#vida_util").val("");
	$("#color").val("S/D");
	$("#dimension").val("S/D");
	
	
	$("#idproveedor").val("");
	$("#factura").val("");
	$("#proveedor").val("");
	
	  
	$("#color").val("");
	$("#material").val("SIN DATO");
	$("#dimension").val("S/D");
	$("#clase_ve").val("");
	$("#motor_ve").val("");
	$("#chasis_ve").val("");
	$("#placa_ve").val("");
	$("#color_ve").val("");
 	
	
	$("#idprov").val("");
	$("#razon").val("");
	$("#id_departamento").val("");
	$("#idsede").val("");
	$("#detalle_ubica").val("");
 
	
	
	
	$("#fecha_adquisicion").val(fecha_hoy());
	$("#detalle").val("");
	
	$("#marca").val("");
	
	
	$("#uso").val("");
	$("#clase").val("");
 
	$("#garantia").val("N");
	$("#tiempo_garantia").val("0");
	
	$("#serie").val("S/D");
	$("#dimension").val("S/D");
	
	$("#material").val("SIN DATO");
	$("#dimension").val("S/D");
	$("#codigo_actual").val("S/D");

	$("#marca").val("");
	  $.ajax({
  					 url:   '../model/ajax_secuencia.php',
 					type:  'GET' ,
 						beforeSend: function () { 
 								$("#secuencia").html('Procesando');
 						},
 					success:  function (data) {
 							 $("#secuencia").html(data);  
 						     
 						} 
 			});
	  
	  
	 
}
//-------------
function ListaModelo(idmarca) {
	   
 var parametros = {
			 'idmarca'  : idmarca  
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
		 
	 
		 
	}
//------------------------
function VerVariables( str ) {
	
	//var str = $("#cuenta_parametro").val();

	var cuenta = str.trim() ;
	
	cuenta = cuenta.substring(0, 9);
	
    var subcuenta = cuenta.substring(0, 3);
 
 
 
	if (subcuenta == '911' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('10');
	}
 
 
	if (cuenta == '141.01.03' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('10');
	}
	
	
 
	if (cuenta == '141.01.05' ){
		 $("#elemento_gen").hide();
		 $("#elemento_veh").show();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('5');
	}

 
	if (cuenta == '145.01.05' ){
		 $("#elemento_gen").hide();
		 $("#elemento_veh").show();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('5');
	}

	
	
	
	
	if (cuenta == '141.01.06' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('10');
	}
	if (cuenta == '141.01.10' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('10');
	} 	 
		
	if (cuenta == '141.01.11' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		   $("#vida_util").val('10');
	} 	
	
	if (cuenta == '141.01.04' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").show();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		  $("#vida_util").val('10');
	} 	
	


	
	if (cuenta == '141.01.07' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();

		 $("#vida_util").val('3');
		 
	} 	

	 
	
	
	if (cuenta == '141.03.01' ){
		 $("#elemento_gen").hide();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").show();
		 $("#elemento_inf").hide();
	} 
	if (cuenta == '141.03.02' ){
		 $("#elemento_gen").hide();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").show();
		 $("#elemento_inf").hide();
	} 
	
	
	  
	  	if (subcuenta == '152' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		  $("#vida_util").val('0');
	} 	
	
 	if (subcuenta == '151' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
		  $("#vida_util").val('0');
	} 	
	
	 
	
	//1410108	bienes artsticos y culturales
	//1410109	libros y colecciones
 
 
	 
}
//-------------
function siguiente( menu1 ) {

	if ( menu1=='menu1')  {
		var cuenta = 	$("#cuenta").val();
		
		VerVariables(cuenta);
		
	}	
	 $('#mytabs_1 a[href="#'+ menu1+'"]').tab('show');
	 
	 
	 

}	
//---------------------------
function PoneDoc(file)
{
  	 
	 var parent = $('#DocVisor').parent(); 
	 $('#DocVisor').remove(); 
	 
	 var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
	 parent.append(newElement); 
	 
	 
	  
 	 var url = '../../archivos/activos/' + file;
	 
 	 var myStr = file;
 	   
     var strArray = myStr.split(".");
      
     if ( strArray[1] == 'pdf' ){
    	 
     	 
    	    $('#DocVisor').attr('src',url); 
    	    
    	 
  
     }else{
    	 
    	 $('#DocVisor').attr('src',url); 
     	 
  
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
  function BusquedaGrilla(oTable){       
	  
 
 
	var vtipo_bien			= $("#vtipo_bien").val();
	var vcuenta				= $("#vcuenta").val(); 
	var Vid_departamento	= $("#Vid_departamento").val();
	var vuso				= $("#vuso").val();
	var vtiene_acta			= $("#vtiene_acta").val();
	var vidsede				= $("#vidsede").val();
	
	var vactivo				= $("#vactivo").val();
	
	var vcodigo				= $("#vcodigo").val();
	
	
	   
    var parametros = {
				'vtipo_bien' : vtipo_bien,  
				'vcuenta' : vcuenta ,
				'Vid_departamento' : Vid_departamento ,
				'vuso' : vuso ,
				'vtiene_acta' : vtiene_acta ,
				'vidsede': vidsede,
				'vactivo' :vactivo,
				'vcodigo' :vcodigo
				};
  
	  
				var a    = $('#id_tramite').val();
				var b    = $('#factura').val();
				var c    = $('#idproveedor').val();
			
				
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
						s[i][11],
						s[i][1],
						s[i][2],
						s[i][3],
						s[i][4],
						s[i][5],
						s[i][6],
						s[i][7],
  					'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
					'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;' +
					'<button class="btn btn-xs btn-info"   onClick="url_ficha_d('+'1'+','+ s[i][0] +','+ s[i][8] + ','+ "'" +s[i][9] +"'" +","+ "'"+ s[i][10] +"'"+')"><i class="glyphicon glyphicon-print"></i></button>&nbsp;' +
					'<button class="btn btn-xs btn-success" onClick="url_ficha_d('+'2'+','+ s[i][0] +','+ s[i][8] + ','+ "'" +s[i][9] +"'" +","+ "'"+ s[i][10] +"'" +')"><i class="glyphicon glyphicon-folder-close"></i></button>'
				]);										
			} // End For
		  } 						
		 } 
	 	});
		
		$("#vactivo").val('');
		
		$("#vcodigo").val('');
		 

}   
 /*
 */
 function BusquedaGrilla1(oTable){       
	  
 
	var vidsede				= $("#vidsede").val();
	 
	var vtipo_bien				= $("#vtipo_bien").val();
	
	
	   
    var parametros = {
 
				'vidsede': vidsede,
				'vtipo_bien' : vtipo_bien
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ac_bienes_ultimo' ,
			dataType: 'json',
			cache: false,
			success: function(s){
		    //console.log(s); 
			oTable.fnClearTable();
			if(s)  {
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
					s[i][0],
					s[i][11],
					s[i][1],
					s[i][2],
					s[i][3],
					s[i][4],
					s[i][5],
					s[i][6],
					s[i][7],
						'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;' +
						'<button class="btn btn-xs btn-info"   onClick="url_ficha_d('+'1'+','+ s[i][0] +','+ s[i][8] + ','+ "'" +s[i][9] +"'" +","+ "'"+ s[i][10] +"'"+')"><i class="glyphicon glyphicon-print"></i></button>&nbsp;' +
						'<button class="btn btn-xs btn-success" onClick="url_ficha_d('+'2'+','+ s[i][0] +','+ s[i][8] + ','+ "'" +s[i][9] +"'" +","+ "'"+ s[i][10] +"'" +')"><i class="glyphicon glyphicon-folder-close"></i></button>'
				]);										
			} // End For
		  } 						
		 } 
	 	});
		
		$("#vactivo").val('');
		
		$("#vcodigo").val('');
		 

}   
   



//-----------------
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');
	 
 }
//--------------- 
 function DetalleBien()
 {
     
	 var clase = $('#clase').val();
	 
	 var modelo = $('#id_modelo option:selected').html()
	 
	 var marca = $('#marca').val();
	 
	 var serie = $('#serie').val().toUpperCase();
	 
 	 
	 cadena = clase.trim() + ' ' + marca.trim()  + ' ' + modelo.trim() + ' '+ serie.trim();
 	 
	 $('#descripcion').val(cadena);
	 
	 $('#serie').val(serie);
	 
 }
 //------------------
 function pone_mayuscula()
 {
     
 
	 var cadena = $('#descripcion').toUpperCase();
	 
	 var serie = $('#serie').val().toUpperCase();
  	 
  	 
	 $('#descripcion').val(cadena);
	 
	 $('#serie').val(serie);
	 
 }
 //------------
 function selecciona_cuenta(cuenta)
 {
    
	 document.getElementById("cuenta_tmp").value = cuenta ;
	 
 	 VerVariables(cuenta);
	 
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
 function openFile( ) {

	 var url = '../../upload/uploadAc';
	 
 
	    
	  var id = $('#id_bien').val();

	  var ancho = 650; 
	  var alto = 360; 

	  
	  var posicion_x ; 
	  var posicion_y ; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id  ;
	 
	  if ( id) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
  ///***********
 function openFileComponente( ) {

	 var url = '../view/ac_bienes_componente.php';
	 
 
	    
	  var id = $('#id_bien').val();

	  var ancho = 920; 
	  var alto = 420; 

	  
	  var posicion_x ; 
	  var posicion_y ; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id  ;
	 
	  if ( id) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
 //--------------         
 function goToURLCom(  id_bien_componente,id_bien  ) {

	 var url = '../view/ac_bienes_componente.php';
	 
 
	    
	  var id = $('#id_bien').val();

	  var ancho = 920; 
	  var alto = 420; 

	  
	  var posicion_x ; 
	  var posicion_y ; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id +'&ref='+id_bien_componente ;
	 
	  if ( id) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
 //---
 function goToURLComdel(id_bien_componente, idbien)
 {
  
  		 
 	 var parametros = {
 			    'id' : idbien,
 			    'id_bien_componente' : id_bien_componente,
 			    'accion' : 'del'
    };
 	  
 	  alertify.confirm("Desea eliminar Componente? ", function (e) {
 		  if (e) {
 			 
              	
 			  $.ajax({
 					data:  parametros,
 					 url:   '../model/Model-ac_bienes_componente.php',
 					type:  'GET' ,
 						beforeSend: function () { 
 								$("#ViewFormComponentes").html('Procesando');
 						},
 					success:  function (data) {
 							 $("#ViewFormComponentes").html(data);  
 						     
 						} 
 			});
 				 
 		  }
 		 }); 
 	  
  
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
		    	  
		    		   BuscaCuenta( codigo) ;
		       }
			 });
	 
		   
		   $(".dataTables_filter input[type='search']").val(''); 
			 
		}
 //---------------------------------
 function BuscaCuenta( codigo) {
	 	
 
		 var parametros = {
 					 'codigo' : codigo,
					 'tipo'   : 1
		  };
			 
			
		   $.ajax({
				 data:  parametros,
				 url: "../model/ajax_bienes_sede_uni.php",
				 type: "GET",
		       success: function(response)
		       {
  
		    		   $('#vcuenta').html(response);
		    	  
		       }
			 });
	 
		   $(".dataTables_filter input[type='search']").val(''); 
			 
		}