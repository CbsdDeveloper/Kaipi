"use strict";

var oTableTramite;
var oTableFactura;


//-------------------------------------------------------------------------
$(document).ready(function(){


        
          
         oTableTramite =  $('#jsontable_tramite').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "de", "aTargets": [ 5 ] },
		      { "sClass": "ye", "aTargets": [ 2 ] }
		    ]
		  } );
        
         oTableFactura =  $('#jsontable_factura').dataTable( {
 		    "aoColumnDefs": [
 		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "highlight", "aTargets": [ 1 ] },
 		      { "sClass": "highlight", "aTargets": [ 2 ] }
 		    ]
 		  } );
         
         
         
    	$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		modulo();

	    FormView();

	    BusquedaGrillaTramite(oTableTramite);
 
 
});  

//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
 
 	  	      
 
		    $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b>   ]  AGREGAR NUEVO PROCESO</b>');
			 
			LimpiarPantalla();
 			
		
		  }
	 }); 
	}
	if (tipo =="alerta"){			 
	  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
	  });
	 }		  
	return false	  
   } 
//--------
function  BuscaPersonal(unidad)
{
 
 
	var parametros = {
		'unidad': unidad
	};
	
	$.ajax({
		data:  parametros,
		url: "../../kdocumento/model/ajax_usuario_unidad.php",
		type: "GET",
	  success: function(response)
	  {
		  $('#sesion_siguiente').html(response);
	  }
	});
	   
	 
 }
 //------
 function LimpiarPantalla() {
	
 
	
	$("#idcaso").val('');

	$("#idtramite").val('0');
   
	$("#categoria").val('');      
	 
	$("#caso").val('');

		 
	$("#sesion_siguiente").val('');


	$("#estado").val('1');
	
		 
	$("#unidad_destino").val('');
 

	$("#action").val("add");


	


 }  
/*
*/
function LimpiarVariable() {
 
	   
	$("#tipo").val('');      
	 
	$("#msg").val('');

} 

//--------------
function impresion_pago(enlace,codigo_x1)

{

	 

 var id_asiento  = document.getElementById(codigo_x1).value;  
  

  enlace = enlace +id_asiento;

  alertify.confirm("Desea generar la orden de pago?", function (e) {

	    if (e) {

	    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
	     }

	 }); 
  
 
}	
//-------------------
function PonePartida( ){
    
	  var id_tramite = $("#id_tramite").val();
	  var festado    = $("#festado").val();


    var parametros = {
				'id_tramite' : id_tramite  ,
				'festado' : festado  
    };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_xpagar_gasto.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			oTableGrid.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
								oTableGrid.fnAddData([
										s[i][0],
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][4],
					                     '<button class="btn btn-xs" onClick="javascript:goToURLGasto('+ "'" + s[i][0] +"',"+ "'" + s[i][1] +"',"+  "'" + s[i][2] +"',"+ s[i][4] +"," + s[i][5] +')"><i class="glyphicon glyphicon-edit"></i></button> '  
		                 ]);									
						} // End For
					}				
			},
			error: function(e){
			   console.log(e.responseText);	
			}
		});

 
}
//----------------------
function accion(id,modo,estado,id_tramite)
{

	
	if (id > 0){

		 	 $("#action").val(modo);
  
			  $("#idcaso").val(id);
			  
 	    	  BusquedaGrillaTramite(oTableTramite);

			  CargaDatos(id_tramite) ;

		 	  Ver_doc_user(id);
			  
	}

}
//------------------------------------------------------------------------- 
function Busqueda(   ){        
	
	BusquedaGrillaTramite(oTableTramite);
		
	
}

function openFile(url,ancho,alto) {
    
	var idcaso = $("#idcaso").val();
	   
	var posicion_x; 

	var posicion_y; 

	var enlace; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
   
	enlace = url+'?id='+idcaso  ;
   
	if ( idcaso > 0 ) {

			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }
}
/*
ver documentos visor 
*/
function Ver_doc_prov(idcaso) {

	 
	var parametros = {
					'accion' : 'visor',
					'idcaso' : idcaso  
	   };

	 $.ajax({
					data:  parametros,
					url:   '../../kdocumento/model/Model-caso__doc_tra.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#ViewFormfile").html(data);   

					 } 

		   }); 
 
	 
}
/*

*/
function Ver_control_nov(idcaso) {

	 
	var parametros = {
					'accion' : 'visor',
					'idcaso' : idcaso  
	   };

	 $.ajax({
					data:  parametros,
					url:   '../model/ajax_cprevio_visor.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#ViewFormControl").html(data);   

					 } 

		   }); 
 
	 
}
/*
Visualiza Documento generado
*/ 
function Ver_doc_user(idcaso) {

	
	var parametros = {
					'accion' : 'visor',
					'idcaso' : idcaso  
	   };

	 $.ajax({
					data:  parametros,
					url:   '../../kdocumento/model/Model-caso__doc_tra01.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#ViewFormfileDoc").html(data);   

					 } 

		   }); 
 
	 
}
///------------------
function PoneDoc(file)
{
 
 
 var url = '../../userfiles/files/' + file;
 
 
	 var parent = $('#DocVisor').parent(); 
	 $('#DocVisor').remove(); 
	 
	 var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
	 parent.append(newElement); 
	 

	 
	 var myStr = file;
	   
    var strArray = myStr.split(".");
     
    if ( strArray[1] == 'pdf' ){
   	 
    	 
   	    $('#DocVisor').attr('src',url); 
   	    
   	 
 
    }else{
   	 
   	 $('#DocVisor').attr('src',url); 
    	 
 
    }  
 
  	
}
//-------------------------
function goToURLDocdel(idcodigo,idcaso) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'idcaso'   : idcaso  ,
					'accion' : 'del'
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../../kdocumento/model/Model-caso__doc_tra.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
//------------------------------------------------------------------------- 

function BusquedaGrillaTramite(oTableTramite){        	 
 
 
	
	  var vestado    = $("#vestado").val();
	  var idtramiteb = $("#idtramiteb").val();
	  var idcasob    = $("#idcasob").val();
	  

	  var parametros = {
				'vestado'    : vestado   ,
				'idtramiteb' : idtramiteb   ,
				'idcasob'    : idcasob   
    };


			$.ajax({
				data:  parametros,
			    url: '../grilla/grilla_co_xpagar_control.php',
				dataType: 'json',
				cache: false,
				success: function(s){
				oTableTramite.fnClearTable();

				if(s){

					for(var i = 0; i < s.length; i++) {
						oTableTramite.fnAddData([
		                      s[i][0],
		                      s[i][1],
		                      s[i][2],
		                      s[i][3],
		                      s[i][4],
		                      s[i][5],
		                      s[i][6],
							  '<button class="btn btn-xs btn-warning" title="EDITAR REGISTRO SELECCIONADO" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' +
							  '<button class="btn btn-xs btn-danger" title="ANULAR TRAMITE SELECCIONADO" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-ban-circle"></i></button>'
		                  ]);									
					} // End For
				   }				
				},
				error: function(e){
				   console.log(e.responseText);	
				}
		 });
}   
//-----
function BusquedaGrillaFactura(oTableFactura,idtramite){        	 

	
	 var parametros = {
				'idtramite' : idtramite  
     };

 

	$.ajax({
		data:  parametros,
	    url: '../grilla/grilla_co_xpagar_factura.php',
		dataType: 'json',
		cache: false,
		success: function(s){
			oTableFactura.fnClearTable();

		if(s){

			for(var i = 0; i < s.length; i++) {
				oTableFactura.fnAddData([
                      s[i][0],
                      s[i][1],
                      s[i][2],
                      s[i][3],
                      s[i][7],
                  ]);									
			} // End For
		   }				
		},
		error: function(e){
		   console.log(e.responseText);	
		}
 });
}   
//--------------------
function  formato_doc_firmado( idproceso_docu  )
{
   
	   var   	idcaso = $("#idcaso").val();

	   var   	enlace = '../../kdocumento/reportes/documento_firma.php?caso='+idcaso+'&doc='+idproceso_docu;
 

	   window.location.href = enlace;
   
	   
 } 
//------------
function FinProceso() {
	 
	var mensaje = 'Desea finalizar el proceso?';			 
	   
	var estado 		  = $("#estado").val( );
		

	if ( estado == '3')  {

		 alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

		 if (e) {
			

			   var id 		  = $("#idcaso").val( );

			   var idproceso = $("#codigoproceso").val();
				
			   var parametros = {
								'id' : id ,
								'idproceso' : idproceso,
								'accion': 'terminado'
				  };
			   
				 $.ajax({
							   data:  parametros,
							   url:   '../../kdocumento/model/Model-cli_incidencias.php',
							   type:  'GET' ,
							   cache: false,
							   beforeSend: function () { 
										$("#result").html('Procesando');
								 },
							   success:  function (data) {
										$("#result").html(data);  
										$("#estado").val('4');
										
								 } 
					   }); 
			 
					
	
			 }
		}); 
}

} 
//-------------------
function goToURL(accion,id) {

	  var parametros = {
					'accion' : accion ,
                    'id' : id 
	  };

	  $.ajax({

					data:  parametros,
					url:   '../model/Model-controlPrevio.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 

							$("#result").html('Procesando');
					},
					success:  function (data) {
						
						     $("#result").html(data);   
						 
						     $('#mytabs a[href="#tab2"]').tab('show');
					} 
 
			}); 
 
			Ver_control_nov(id);

			Recorrido(id);
 		 
			Ver_doc_prov(id);
		//	BusquedaGrillaFactura(oTableFactura,id);
 
}
/*
*/
function proceso_doc(accion,id) {


	var idcaso = $("#idcaso").val();
	var estado = $("#estado").val();


	var parametros = {
				  'accion' : accion ,
				  'id' : id 
	};


	if ( accion == 'del' )  {

 		if ( estado == '1' )  {

			$.ajax({
 						data:  parametros,
						url:   '../model/ajax_novedad_doc.php',
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
 	}else{

					$.ajax({
						data:  parametros,
						url:   '../model/ajax_novedad_doc.php',
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

	 Ver_control_nov(idcaso);
	 

}

/*
*/
function GuardarNovedad( ) {

	
	var idcaso = $("#idcaso").val();

	var tipo   = $("#tipo").val();      
	 
	var msg    = $("#msg").val();


	var idtramite = $("#idtramite").val();

	var parametros = {
				  'accion' : 'novedad' ,
				  'id' : idcaso,
				  'tipo' : tipo,
				  'msg' : msg,
				  'idtramite' : idtramite

	};


    if (idcaso > 0 )  {
				$.ajax({

							data:  parametros,
							url:   '../model/Model-controlPrevio.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 

									$("#guardarGasto").html('Procesando');
							},
							success:  function (data) {
								
									$("#guardarGasto").html(data);   
								
									Ver_control_nov(idcaso);
							} 

					}); 

	 
	}else{
			alert('Actualice y guarde la información... ');

	}

}
/*
*/

function goToURLDocdelUser(codigo, idcaso) {
	
	var mensaje = 'Desea Eliminar el documento?';		
alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
   
if (e) {
				
			 
				   var parametros = {
									'id' : codigo ,
									'idcaso' : idcaso,
									'accion': 'eliminar'
					  };
				   
					 $.ajax({
								   data:  parametros,
								   url:   '../../kdocumento/model/Model-addDoc01.php',
								   type:  'POST' ,
								   cache: false,
								   beforeSend: function () { 
											$("#result").html('Procesando');
									 },
								   success:  function (data) {
											$("#result").html(data);  // $("#cuenta").html(response);
											Ver_doc_user(idcaso) ;
									 } 
						   }); 
	
				 }
			}); 
	   
 }	
/*
*/
function goToURLDocBloqueaUser(codigo, idcaso) {
	
	var mensaje = 'Desea Bloquear y generar  Documento para enviarlo?';		

alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
   
if (e) {
				
			 
				   var parametros = {
									'id' : codigo ,
									'idcaso' : idcaso,
									'accion': 'seguro'
					  };
				   
					 $.ajax({
								   data:  parametros,
								   url:   '../../kdocumento/model/Model-addDoc01.php',
								   type:  'POST' ,
								   cache: false,
								   beforeSend: function () { 
											$("#result").html('Procesando');
									 },
								   success:  function (data) {
											$("#result").html(data);  // $("#cuenta").html(response);
											 Ver_doc_user(idcaso) ;
									 } 
						   }); 
	
				 }
			}); 
}	
//---------------
function  formato_doc_visor( idproceso_docu  )
{
   
	   var   	idcaso = $("#idcaso").val();
	   var 	posicion_x; 
	   var 	posicion_y; 
	   var   	enlace = '../../kdocumento/reportes/documento_matriz.php?caso='+idcaso+'&doc='+idproceso_docu;
	   var 	ancho = 1000;
	   var 	alto = 520;
	   
	   posicion_x=(screen.width/2)-(ancho/2); 
	   posicion_y=(screen.height/2)-(alto/2); 
	   
	   window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	   
 }   
//------------------------------------------------------------------------- 
 function modulo()
{

	 var modulo1 =  'kcontabilidad';

 	 var parametros = {
			    'ViewModulo' : modulo1 
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
//---------------------------------------------------
 function VerBeneficiarios( )
 {
 	 var	id_asiento    =   $("#id_asiento").val( );
 	 
 	 var parametros = {
 			    'id_asiento' : id_asiento 
   };


 	$.ajax({
 			data:  parametros,
 			url:   '../model/Model-ver_lista_beneficiarios.php',
 			type:  'GET' ,
 			cache: false,
 			beforeSend: function () { 
 						$("#ViewFiltroProv").html('Procesando');
 				},
 			success:  function (data) {
 					 $("#ViewFiltroProv").html(data);   
 				} 
 	});
 }
//--------------
 function notificar_correo( )
 {
	 
	 
 	 var	idtramite    =   $("#idtramite").val( );
 	 
 	 var	solicita    =   $("#solicita").val( );
 
 
 	 
 	 var parametros = {
 			    'idtramite' : idtramite ,
 			    'solicita': solicita
     };


 	$.ajax({
 			data:  parametros,
 			url:   '../model/ajax_envio_email_control.php',
 			type:  'GET' ,
 			cache: false,
 			beforeSend: function () { 
 						$("#result").html('Procesando');
 				},
 			success:  function (data) {
 					 $("#result").html(data);   
 					 alert('Mensaje Enviado');
 				} 
 	});
 }
//-----------------
 function FormView()
{

	 $("#ViewForm").load('../controller/Controller-controlPrevio.php');

} 
  
  
 //------------------------
 function ViewDetAuxiliar(codigoAux)
 {

  	 var parametros = {
 			    'codigoAux' : codigoAux 
     };

  	$.ajax({
 			 data:  parametros,
 			 url:   '../controller/Controller-co_asientos_aux1.php',
             type:  'GET' ,
 			 cache: false,
 			 beforeSend: function () { 
 				 $("#ViewFiltroAux").html('Procesando');

 				},
 			success:  function (data) {

 					 $("#ViewFiltroAux").html(data);  // $("#cuenta").html(response);

 				} 

 	});

}

function CargaDatos(idtramite) {

 
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
						 $("#ViewFormRuta").html(data);   
					     
					} 
		}); 
 
} 	
//---------

function Recorrido(idcaso) {
	
	
	var parametros = {
            'id' : idcaso 
    };

	$.ajax({
				data:  parametros,
				url:   '../../kdocumento/model/Model-proceso_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewRecorrido").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewRecorrido").html(data);  // $("#cuenta").html(response);
					     
					} 
		}); 

 	 
	}
/*
Funcion para aprobar el proceso
*/
function aprobacion(){
 
	 
	var mensaje = 'Desea generar el proceso para su gestion?';			 
			
	var estado 		  = $("#estado").val( );

			if ( estado == '1')  {
		
				alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
		
				 if (e) {
					
						var id 		  = $("#idcaso").val();
		
					   var idproceso =  21;
		
					   var parametros = {
										'id' : id ,
										'idproceso' : idproceso,
										'accion': 'aprobado'
						  };
					   
						 $.ajax({
									   data:  parametros,
									   url:   '../../kdocumento/model/Model-cli_incidencias.php',
									   type:  'GET' ,
									   cache: false,
									   beforeSend: function () { 
												$("#result").html('Procesando');
										 },
									   success:  function (data) {
												$("#result").html(data);   
												
										 } 
							   }); 
					 
						 
							 Recorrido(id);
			
					 }
				}); 
		}

}
//--------------------
 function Actualizar_Proceso(){
 
	 
	var mensaje = 'Desea generar el proceso para su gestion de anticipos?';			 
			
	var estado 		  = $("#estado").val();
	var categoria 	  = $("#categoria").val();
	

			if ( estado == '4')  {
		
				alertify.confirm("<p>"+mensaje+' '+estado+"<br></p>", function (e) {
		
				 if (e) {
					
						var id 		  = $("#idcaso").val();
		
					   var idproceso =  21;
		
					   var parametros = {
										'id' : id ,
										'idproceso' : idproceso,
										'accion': 'anticipo'
						  };
					   
					   	if ( categoria == 'Anticipo Remuneracion')  {
						
								 $.ajax({
											   data:  parametros,
											   url:   '../model/ajax_anticipo_autoriza.php',
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
						 
							 Recorrido(id);
			
					 }
				}); 
		}

}