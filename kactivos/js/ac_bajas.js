var oTable;
var oTable_doc;

var formulario = 'ac_bajas';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
        oTable 				= $('#jsontable').dataTable(); 
        
        oTable_doc			= $('#jsontableBienes').dataTable(); 
        
        
          

        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable);
          
		});
	    
	     $('#bbienes').on('click',function(){
	 		 
	    	 BusquedaGrillaCustodio(oTable_doc);
          
		});
	    
		 
	     $('#bbienesr').on('click',function(){
	 		 
	    	 BusquedaGrillaRepo(oTable_doc);
          
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
						
  
					$("#id_acta").val (respuesta.id_acta);
	 			 
					$("#fecha").val (respuesta.fecha);
					$("#clase_documento").val (respuesta.clase_documento);
					$("#documento").val (respuesta.documento);
					$("#estado").val (respuesta.estado);
			 
					$("#detalle").val (respuesta.detalle);
					$("#resolucion").val (respuesta.resolucion);
					$("#tipo").val (respuesta.tipo);
					$("#idsede").val (respuesta.idsede);
					
					$("#idprov").val (respuesta.idprov);
 				 
					
						 						
					$("#action").val(accion); 
				 	$("#result").html(resultado);
				 
				 	 	  
				 	DetalleActivosNoAsignados( );
				 	
				});
	 
	
	
	//BusquedaGrillaCustodio(oTable_doc);
	
 	$('#mytabs a[href="#tab2"]').tab('show');
 
	
}

// ir a la opcion de editar goToURLvisor
function goToURLvisor(id) {

	var id_acta = $("#id_acta").val ();
	
	var estado = $("#estado").val ();
	
	
	
	var parametros = {
					'accion' : 'agregar' ,
					'id_acta' : id_acta,
                    'id' : id 
 	  };
	
  
	if ( estado == 'N') {
		
		if ( id_acta > 0 ) {
			 $.ajax({
				 data:  parametros,
				 url: "../model/Model-ac_asigna_baja.php",
				 type: "GET",
		       success: function(data)
		       {
		           $('#GuardaDato').html(data);

				   DetalleActivosNoAsignados();

		       }
			 });
 
		 }
		
		$('#myModal').modal('hide');
 
		
	 }
 
	  
}
//---------------------- 
function goToURLDetalle(id) {


	var id_acta = $("#id_acta").val ();
	
	var estado = $("#estado").val ();
	
	
	
	var parametros = {
					'accion' : 'eliminar' ,
					'id_acta' : id_acta,
                    'id' : id 
 	  };
	
  
	if ( estado == 'N') {
		
		if ( id_acta > 0 ) {
			
			
			 alertify.confirm("Eliminar seleccion del bien", function (e) {
				  if (e) {
					 
	                 	
						 $.ajax({
							 data:  parametros,
							 url: "../model/Model-ac_asigna_baja.php",
							 type: "GET",
					       success: function(data)
					       {
					           $('#GuardaDato').html(data);
							   DetalleActivosNoAsignados();
					       }
						 });
						 
				  }
				 }); 
 
		 }
 		
 		
	 }
 
	  
}
//---------------------------
function AutorizarBaja() {


	var id_acta = $("#id_acta").val ();
	
	var estado = $("#estado").val ();
	
	
	
	var parametros = {
					'accion' : 'aprobar' ,
                    'id' : id_acta 
 	  };
	
  
	if ( estado == 'N') {
		
		if ( id_acta > 0 ) {
			
			
			 alertify.confirm("Autorizar Proceso de Baja de Bienes", function (e) {
				  if (e) {
					 
	                 	
						 $.ajax({
							 data:  parametros,
							  url:   '../model/Model-'+ formulario,
							 type: "GET",
					       success: function(data)
					       {
					    		$("#result").html(data);
					    		
					    		$("#estado").val ('S');
					       }
						 });
						 
				  }
				 }); 
 
		 }
 		
		DetalleActivosNoAsignados( );
		
	 }
 
	  
}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	 
 
	$("#fecha").val(fecha_hoy());
	$("#forma_ingreso").val(fecha_hoy());
	$("#fecha_comprobante").val(fecha_hoy());

	
	$("#id_acta").val("");
	$("#clase_documento").val("Acta Baja de Bienes");
	$("#documento").val("");
	
	$("#resolucion").val("");
 
	
	
	$("#estado").val("N");
	$("#detalle").val("Acta Baja de Bienes generada " + fecha_hoy());
 
	 
}
//-------------
function DetalleActivosNoAsignados( ) {
	   
	
	
	var id_acta =	$("#id_acta").val ();
  
	 var parametros = {
				 'id_acta'  : id_acta  
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model_bien_listaBajas.php",
			 type: "GET",
	       success: function(data)
	       {
	           $('#DetalleActivosNoAsignado').html(data);
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
  function BusquedaGrilla(oTable){       
	  
 
 
 	var ffecha1	= $("#ffecha1").val();
 	var ffecha2	= $("#ffecha2").val();
 	
 	var vestado			    = $("#vestado").val();
 	var vidsede			    = $("#vidsede").val();
 	 
 	
    var parametros = {
 				'ffecha1' : ffecha1 ,
 				'ffecha2' : ffecha2 ,
 				'vestado'     : vestado ,
 				'vidsede'     : vidsede
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
    					'<button class="btn btn-xs btn-warning" onClick="goToURL(' +"'editar'" + ','+ "'" + s[i][0] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
				]);										
			} // End For
		  } 						
		 } 
	 	});

}   
  



//----------------- ViewForm
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');
	 
 }
//--------------- 
 function BusquedaGrillaCustodio(oTable_doc){       
 	 
	 
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
	 		    url: '../grilla/grilla_' + formulario + '_bienes',
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
							s[i][6],
							s[i][7],
							s[i][8],
	    					'<button class="btn btn-xs btn-warning" title = "Seleccionar bien" onClick="goToURLvisor(' + s[i][0]  +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' 
 					]);										
				} // End For
			  } 						
			 } 
		 	});

			 $("#ccustodio").val ('');
		     $("#ccactivo").val ('');
	} 
 
//----------
function depre_acta( ) {


	  var  id_acta     = 	$("#id_acta").val();
 	   var  fecha 	   = 	$("#fecha").val();
 	   
 		

	    var parametros = {
               'id_acta' : id_acta ,
               'fecha':fecha 
   	  };

	    
		  alertify.confirm("GENERAR DEPRECIACION DE LA BAJA " + id_acta, function (e) {
			  if (e) {
				 
				  $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_depreciar_baja.php',
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
			 }); 

 		   	DetalleActivosNoAsignados( );
} 

//----------
	function BusquedaGrillaRepo(oTable_doc){       
 	 
	 
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
				url: '../grilla/grilla_' + formulario + '_bienes1',
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
						   s[i][6],
						   s[i][7],
						   s[i][8],
						   '<button class="btn btn-xs btn-warning" title = "Seleccionar bien" onClick="goToURLvisor(' + s[i][0]  +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' 
					]);										
			   } // End For
			 } 						
			} 
			});

			$("#ccustodio").val ('');
			$("#ccactivo").val ('');
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
 function url_ficha( ) {

	  var ancho = 800; 
	  var alto = 550; 
	  var posicion_x ; 
	  var posicion_y ; 
	  var enlace; 
	 
	var id_acta = 	$("#id_acta").val ( );
		
	  posicion_x=(screen.width/2)-(ancho/2); 
	  posicion_y=(screen.height/2)-(alto/2); 

	  
	  if ( id_acta > 0 ) {
		  
		    var url = '../reportes/acta_entrega_baja';
		    
		    enlace = url+'?id='+id_acta  ;
		 
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	}  
	
  
//----------------------------
 function editor_ficha( ) {

	  var ancho = 800; 
	  var alto = 550; 
	  var posicion_x ; 
	  var posicion_y ; 
	  var enlace; 
	 
	var id_acta = 	$("#id_acta").val ( );
		
	  posicion_x=(screen.width/2)-(ancho/2); 
	  posicion_y=(screen.height/2)-(alto/2); 

	  
	  if ( id_acta > 0 ) {
		  
		    var url = '../view/editor.php';
		    
		    enlace = url+'?id='+id_acta  ;
		 
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
  
