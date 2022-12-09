var oTable;

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
				
				$("#idsede").val (respuesta.idsede);
				
				$("#detalle_ubica").val (respuesta.detalle_ubica);
				
				$("#cuenta_parametro").val (respuesta.cuenta_parametro);
 			
				$("#action").val(accion); 
			 	$("#result").html(resultado);
			 
			 	
			 	
			 	selecciona_cuenta(respuesta.cuenta);
			 	
			 	var id_modelo = respuesta.id_modelo;
			 		
			 	ListaModeloAsignado(respuesta.id_marca,id_modelo) ;
  			 	  
			 	verdocumento_bien(respuesta.id_bien);
			 	
			 	verComponente_bien(respuesta.id_bien);
			 
			 	
			});
 
		
	 
	
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
	$("#fecha_comprobante").val("");
	$("#codigo_actual").val("");
	$("#estado").val("");
	$("#costo_adquisicion").val("");
	$("#depreciacion").val("");
	$("#serie").val("");
	$("#id_modelo").val("");
	$("#id_marca").val("");
	$("#clasificador").val("");
	$("#cuenta").val("");
	$("#valor_residual").val("");
	$("#anio_depre").val("");
	$("#vida_util").val("");
	$("#color").val("");
	$("#dimension").val("");
	
	$("#detalle").val("");

	
	$("#uso").val("");
	$("#clase").val("");
	$("#material").val("");
	 
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
	 
	 VerVariables();
	 
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
//---------------------------
function PoneDoc(file)
{
 
  	 // document.getElementById("img1").src="image2.jpg";
	  
 var url = '../../archivos/activos/' + file;

	document.getElementById("DocVisor").src= url;
	
  	
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
	  
 
    var vidsede				= $("#vidsede").val();
	var vtipo_bien			= $("#vtipo_bien").val();
	var Vid_departamento	= $("#Vid_departamento").val();
	
	var vcustodio			= $("#vcustodio").val(); 
	var vactivo				= $("#vactivo").val();
	
 
	
    var parametros = {
				'vtipo_bien' : vtipo_bien,  
				'vcustodio' : vcustodio ,
				'Vid_departamento' : Vid_departamento ,
				'vactivo' : vactivo ,
				'vidsede': vidsede
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
  					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
				]);										
			} // End For
		  } 						
		 } 
	 	});

		
		
		$("#vcustodio").val(''); 
		$("#vactivo").val('');
		
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
	 
	 var serie = $('#serie').val();
	 
	 cadena = clase.trim() + ' ' + marca.trim()  + ' ' + modelo.trim() + ' '+ serie.trim();
 	 
	 $('#descripcion').val(cadena);
	 
	 
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