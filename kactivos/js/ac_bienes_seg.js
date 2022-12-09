var oTable;
var oTable_doc;

var formulario = 'ac_bienes_seg';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


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
        
        
    oTable_doc 	= $('#jsontable_doc').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 4 ] },
  		      { "sClass": "de", "aTargets": [ 5 ] },
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
	    
	     $("#saveAsExcel").click(function(){
	         var workbook = XLSX.utils.book_new();
	         
	         //var worksheet_data  =  [['hello','world']];
	         //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);
	       
	         var worksheet_data  = document.getElementById("jsontable");
	         var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
	         
	         workbook.SheetNames.push("Test");
	         workbook.Sheets["Test"] = worksheet;
	       
	          exportExcelFile(workbook);
	       
	      
	     });
 
		
});  
//---------------------------------------------------------------
function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}
//----------------------------------------------------------------
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
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}

 function selecciona_cuenta(cuenta)
 {
    
	 document.getElementById("cuenta_tmp").value = cuenta ;
	 
 
	 
 }
 
// ir a la opcion de editar
function goToURL(accion,id,dato) {

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
 
				_asigna('idproveedor',respuesta.tiempo_garantia);
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
  		            
			     
			 	
			 	var id_modelo = respuesta.id_modelo;
			 		
			 	ListaModeloAsignado(respuesta.id_marca,id_modelo) ;
  			 	  
			 	verdocumento_bien(respuesta.id_bien);
			 	
			 	verComponente_bien(respuesta.id_bien);
			 
			 	BusquedaGrillaCustodio(oTable_doc,id,accion);
			
			});
 
		if ( accion== 'user'){
			$('#mytabs a[href="#tab3"]').tab('show');
			$('#Etiqueta').html(dato);
			
		}
	 
		if ( accion== 'item'){
			$('#mytabs a[href="#tab3"]').tab('show');
		    $('#Etiqueta').html(dato);
		}
		
		if ( accion== 'editar'){
			$('#mytabs a[href="#tab2"]').tab('show');
		}
 	

	  
}
//---------------------------
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
//----------------
function goToURLvisor(idacta) {
	 
	 
	 
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
	 
	 
	 
	 $('#myModalbienes').modal('show');
	 
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
//-------------
 function BusquedaGrillaCustodio(oTable_doc,codigo,accion){       
	  
 
 	 	
	    var parametros = {
	 				'codigo' : codigo ,
					'accion' : accion
					};
	  
		  
	 	  
			$.ajax({
			 	data:  parametros,
	 		    url: '../grilla/grilla_ac_bienes_seg_custodio.php',
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
 	    					'<button class="btn btn-xs" title = "Visor de informacion Documento" onClick="javascript:goToURLvisor(' +   s[i][0]  +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' +
	                        '<button class="btn btn-xs" title="Generacion y Emision de Acta" onclick="javascript:goToURLdoc(1,' +   s[i][0]  +')"><i class="glyphicon glyphicon-file"></i></button>' 
					]);										
				} // End For
			  } 						
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
//------------------------
function VerVariables( ) {
	
	var cuenta = $("#cuenta_parametro").val();
	
 
	
	if (cuenta == '141.01.03' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
	}
	
	if (cuenta == '141.01.05' ){
		 $("#elemento_gen").hide();
		 $("#elemento_veh").show();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
	}
	
	if (cuenta == '141.01.06' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
	}
	if (cuenta == '141.01.10' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
	} 	 
		
	if (cuenta == '141.01.11' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
	} 	
	
	if (cuenta == '141.01.04' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
	} 	
	
	if (cuenta == '141.01.07' ){
		 $("#elemento_gen").show();
		 $("#elemento_veh").hide();
		 $("#elemento_inm").hide();
		 $("#elemento_inf").hide();
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
	
	//1410108	bienes artsticos y culturales
	//1410109	libros y colecciones
 
 
	 
}
//------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){       
	  
 
    var vidsede				= $("#vidsede").val();
	var vtipo_bien			= $("#vtipo_bien").val();
	var Vid_departamento	= $("#Vid_departamento").val();
	
	var vcustodio			= $("#vcustodio").val(); 
	var vactivo				= $("#vactivo").val();
	
	var vcodigo				= $("#vcodigo").val();
	
 
	
    var parametros = {
				'vtipo_bien' : vtipo_bien,  
				'vcustodio' : vcustodio ,
				'Vid_departamento' : Vid_departamento ,
				'vactivo' : vactivo ,
				'vidsede': vidsede,
				'vcodigo' : vcodigo
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
						s[i][6],
						s[i][7],
						s[i][8],
						s[i][9],
  					'<button class="btn btn-xs" title="Visualizar detalle del Bien" onClick="goToURL('+"'editar'"+','+ s[i][0] +''+')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  +
			        '<button class="btn btn-xs" title="Visualizar Actas por Custodio" onClick="goToURL('+"'user'"+','+ "'" + s[i][10] + "'," +"'"+ s[i][2] + "'" + ')"><i class="glyphicon glyphicon-user"></i></button>&nbsp;'  +
					'<button class="btn btn-xs" title="Visualizar Actas por Bien" onClick="goToURL('+"'item'"+','+ s[i][0] + "," +"'"+ s[i][4] + "'" +')"><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;'  
				]);										
			} // End For
		  } 						
		 } 
	 	});

		
		
		$("#vcustodio").val(''); 
		$("#vactivo").val('');
		$("#vcodigo").val('');
		
}   
  
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

//-----------------------
 function BuscaCuenta( codigo) {
	 	
 }
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
//-----------------
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');
	 
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
  