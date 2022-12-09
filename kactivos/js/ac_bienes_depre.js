var oTable;
var oTable_doc;

var formulario = 'ac_bienes_depre';


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
	    
	     $('#bbienesd').on('click',function(){
	 		 
	    	 bbienesd( );
          
		});  
	     
	     
     $('#resumend').on('click',function(){
	 		 
	    	 resumen_depre( );
          
		});  
	     
	     
     $('#resumenc').on('click',function(){
 		 
    	 resumen_conta( );
      
	});  
	 

	  $('#contad').on('click',function(){
 		 
    	Contabilizar();
      
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
					
  			
			$("#id_bien_dep").val(respuesta.id_bien_dep);
			$("#fecha2").val( respuesta.fecha2);
			$("#fecha").val(respuesta.fecha);
			$("#cuenta").val(respuesta.cuenta);
			$("#anio").val(respuesta.anio);
			$("#detalle").val(respuesta.detalle);
			$("#estado").val(respuesta.estado);
			$("#idprov").val(respuesta.idprov);
					
			$("#tipo").val(respuesta.tipo);
						
			$("#mes").val(respuesta.mes);		
					
					 						
			$("#action").val(accion); 
			$("#result").html(resultado);
			 
			});
 
	DetalleActivosNoAsignados( id );
	
	$('#mytabs a[href="#tab2"]').tab('show');
	

	  
}
//---------------------- ../model/Model-ac_bienes_depre.php

//ir a la opcion de editar
function AutorizarTramite( ) {
 
	var id      = $("#id_bien_dep").val();
	var estado  = $("#estado").val();

	
	
	var parametros = {
					'accion' : 'autorizar' ,
                    'id' : id 
 	  };
 
	
	if ( estado == 'N'){
		
 

	  alertify.confirm("Desea autorizar el proceso por grupo depreciado?...", function (e) {
		  if (e) {
			 
             	
				 $.ajax({
					 data:  parametros,
					  url:   '../model/Model-'+ formulario,
					 type: "GET",
			       success: function(response)
			       {
			           $('#result').html(response);
			           
			           $("#estado").val('S');
			       }
				 });
 
		  }
		 }); 
	  
	}
 
	  
}
//---- 
function EliminarTramite( ) {
	 
	var id      = $("#id_bien_dep").val();
	var estado  = $("#estado").val();

	
	
	var parametros = {
					'accion' : 'eliminar_datos' ,
                    'id' : id 
 	  };
 
	
	if ( estado == 'N'){
		
 

	  alertify.confirm("Desea Eliminar los bienes BLD para generar informacion posterior?...", function (e) {
		  if (e) {
			 
             	
				 $.ajax({
					 data:  parametros,
					  url:   '../model/Model-'+ formulario,
					 type: "GET",
			       success: function(response)
			       {
			           $('#result').html(response);
			           
			       	DetalleActivosNoAsignados( id );
			    	
 			       }
				 });
 
		  }
		 }); 
	  
	}
 
	  
}
//------------------------------------
function AnularTramite( ) {
	 
	var id      = $("#id_bien_dep").val();
	var estado  = $("#estado").val();

	
	
	var parametros = {
					'accion' : 'del' ,
                    'id' : id 
 	  };
 
	
	if ( estado == 'N'){
		
 

	  alertify.confirm("Desea Eliminar el tramite de depreciacion?...", function (e) {
		  if (e) {
			 
             	
				 $.ajax({
					 data:  parametros,
					  url:   '../model/Model-'+ formulario,
					 type: "GET",
			       success: function(response)
			       {
			           $('#result').html(response);
			           
			       	DetalleActivosNoAsignados( id );
			    	
 			       }
				 });
 
		  }
		 }); 
	  
	}
 
	  
}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	 
 
    var today = new Date();
  
    var yyyy = today.getFullYear();
	
    var fecha = yyyy + '-01-01';
    
	$("#id_bien_dep").val("");
	$("#estado").val("");

	
  
	$("#fecha2").val(fecha_hoy());
	
	$("#fecha").val(fecha);
	
	
	$("#cuenta").val("");
	$("#anio").val(yyyy);
	$("#detalle").val("Depreciacion del periodo " + yyyy + ' correspondiente al grupo ');

	 DetalleActivosNoAsignados( 0 );
	 
}
//-------------
function DetalleActivosNoAsignados( id_bien_dep ) {
	   
	 

	 var parametros = {
				 'id_bien_dep'  : id_bien_dep  
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model_bien_depre_deta.php",
			 type: "GET",
	       success: function(data)
	       {
	           $('#DetalleActivosNoAsignado').html(data);
	       }
		 });
	 
 
	 
}
//---------------------------------

function Contabilizar( ) {


		var anio  = $("#anio").val();
        var tipo  = $("#tipo").val();
 		var mes   = $("#mes").val();
		var cuenta_depre  = $("#cuenta_depre").val();
		
		
		var parametros = {
						'anio' : anio,
						'tipo' : tipo,
						'mes': mes,
						'cuenta_depre':cuenta_depre
	 	  };
		   
 
		 	alertify.confirm("<p>Desea generar la contabilizacion? </p>", function (e) {

				 if (e) {
					
						$.ajax({

								data:  parametros,
								url:   '../model/Model-Reportes_contabiliza.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
											$("#GuardaDatoConta").html('Procesando');
									},
								success:  function (data) {
										$("#GuardaDatoConta").html(data);   
									} 

						});

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
function bbienesd(  ) {
	
 
 
		   
	   var  id_bien_dep     = 	$("#id_bien_dep").val();
	   var  cuenta 		    = 	$("#cuenta").val();
	   
	   var  estado 		    = 	$("#estado").val();
	   var  fecha 		    = 	$("#fecha").val();
	   var  fecha2 		    = 	$("#fecha2").val();
	   var  anio 		    = 	$("#anio").val();
	   
  var  tipo 		    = 	$("#tipo").val();
		

	    var parametros = {
               'id_bien_dep' : id_bien_dep ,
               'cuenta':cuenta ,
               'estado' : estado ,
               'fecha':fecha ,
               'fecha2' : fecha2 ,
               'anio' : anio,
			   'tipo' : tipo
   	  };

	    
		  alertify.confirm("GENERAR DEPRECIACION DE LA CUENTA" + cuenta, function (e) {
			  if (e) {
				 
				  $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_depreciar_cta.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#GuardaDato").html('Procesando');
							},
						success:  function (data) {
								 $("#GuardaDato").html(data);   
								 
								 DetalleActivosNoAsignados( id_bien_dep );
							} 

				}); 
         				 
			  }
			 }); 

		  $('#myModal').modal('hide')

 
	 
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
	  
 
 
 	var vestado	    = $("#vestado").val();
 	var vperiodo	= $("#vperiodo").val();
 	
 	
 	
 	
    var parametros = {
 				'vestado' : vestado ,
 				'vperiodo' : vperiodo 
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
    					'<button class="btn btn-xs" onClick="javascript:goToURL(' +"'editar'" + ','+ "'" + s[i][0] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
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
 	 
	 
	   var cuenta	= 	$("#cuenta").val ();
	 
	    var idsede	    = 	0;
	 	var ccustodio	= 	$("#ccustodio").val ();
	 	var ccactivo	= 	$("#ccactivo").val ();
	
	    var anio	= 	$("#anio").val ();
	    var fecha2  =  	$("#fecha2").val ();
	  	 
	 	
	    var parametros = {
	 				'idsede' : idsede  ,
	 				'ccustodio': ccustodio,
	 				'ccactivo' : ccactivo,
	 				'cuenta' : cuenta,
				'anio' : anio,
				'fecha2' : fecha2
					};
	  
		  
	 	  
			$.ajax({
			 	data:  parametros,
	 		    url: '../grilla/grilla_ac_depre_bienes_p.php',
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
							s[i][7]
 					]);										
				} // End For
			  } 						
			 } 
		 	});

			 $("#ccustodio").val ('');
		     $("#ccactivo").val ('');
	} 
 //------------
 function selecciona_cuenta(cuenta)
 {
    
	 document.getElementById("cuenta_tmp").value = cuenta ;
	 
 
	 
 }
 
 function url_ficha(url){        
		
		var variable    = $('#id_bien_dep').val();
		var cuenta      = $("#cuenta").val();
		
	    var posicion_x; 
	    var posicion_y; 
	    
	    var enlace = url + '?codigo='+variable +'&cuenta=' + cuenta  ;
	    var ancho  = 1000;
	    var alto   = 520;
	    
	    posicion_x =(screen.width/2)-(ancho/2); 
	    posicion_y =(screen.height/2)-(alto/2); 
	    
	    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
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
 
 // resumen 
  
 function resumen_depre( ) {
 
		var anio  = $("#anio").val();
        var tipo  = $("#tipo").val();
 		var mes   = $("#mes").val();
		
		
		
		var parametros = {
						'anio' : anio,
						'tipo' : tipo,
						'mes': mes
	 	  };
		
		     	
					 $.ajax({
						 data:  parametros,
						  url:   '../model/Model_resumen_depre.php',
						 type: "GET",
				       success: function(response)
				       {
				           $('#DetalleConta').html(response);
				           
 				       }
					 });
 
	}
 
 //----------------------------------
 function resumen_conta( ) {
	 
		var anio  = $("#anio").val();
        var tipo  = $("#tipo").val();
 		var mes   = $("#mes").val();
		var cuenta_depre  = $("#cuenta_depre").val();
		
		
		var parametros = {
						'anio' : anio,
						'tipo' : tipo,
						'mes': mes,
						'cuenta_depre':cuenta_depre
	 	  };
		
		
		     	
					 $.ajax({
						 data:  parametros,
						  url:   '../model/Model_resumen_deprec.php',
						 type: "GET",
				       success: function(response)
				       {
				           $('#DetalleContaProceso').html(response);
				           
				       }
					 });

	}