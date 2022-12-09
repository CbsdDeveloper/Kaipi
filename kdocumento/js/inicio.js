var oTable;
var codigo_proceso ;
 

$(document).ready(function(){
       
 
 

 oTable 	= $('#json_variable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
		   lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'Todos']],
           aoColumnDefs: [
  		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "de", "aTargets": [ 4 ] } 
 		    ] 
      } );
        
	
	    $("#MHeader").load('../view/View-HeaderModelDoc.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
		
		FormView();
 
    	codigo_proceso = 21;

		Visor('editar', codigo_proceso,0,0,0 );

		EstadoProceso();
		
    	FormArbolCuentas(); 
    	
   
    	goToURLProceso('1','2');
 
 
});  
//-------------

function openView(url){        
		
	  
	   
	var posicion_x; 
	var posicion_y; 
	var enlace = url  
	var ancho = 1000;
	var alto = 420;
	
	posicion_x=(screen.width/2)-(ancho/2); 
	posicion_y=(screen.height/2)-(alto/2); 
	
	 window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
 ///-------------------
function  enlance_externo( url_dato,accion )
{
	 

	    var   idcaso = $("#idcaso").val();
       var posicion_x; 
       var posicion_y; 
       var enlace; 
       ancho = 1124;
       alto = 480;
       posicion_x=(screen.width/2)-(ancho/2); 
       posicion_y=(screen.height/2)-(alto/2); 
     
 
       if (idcaso) {
       	
       	   enlace = '../enlaces/' + url_dato + '?task='+idcaso + '&accion='+accion;
              
              window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
              
       }

 }
//----
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
		 
	  	      
			$("#action").val("add");
			
			 $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
			 
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

//-----------------------------------------------------------------
//ir a la opcion de editar
function LimpiarPantalla() {
	
	var id = 	$("#nro_objetos").val();
	
 	var i		= 1;
	
 	var cobjeto = '';
	
 
	$("#novedad_proceso").val('');
	
	$("#sesion_siguiente").val('');
	
	$("#idprov").val('');
	
	$("#razon").val('');
	
	
	var  idproceso =  $("#codigoproceso").val();
	  
	
	 $("#proceso_codigo").val(idproceso);
    
	 
	 valida_botones(  );
	 
	 
 }

 /*
  */
 

 
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#idcaso").val(id);          
 
			
		   if (bandera == 1 ){
			   $('#mytabs a[href="#tab2"]').tab('show');
		   }
	 		
			 
	 
		 

}
//-------------------------------------------------------------------------

function FormArbolCuentas()
{

   $("#ViewFormArbol").load('../controller/Controller-proceso_ejecuta' );

}
//--------------- 
function EstadoProceso()
 {
	 
 	var parametros = {
			
                     'accion' : '2' 
 	  };
 
		  $.ajax({
						url:   '../controller/Controller-proceso_estado.php',
						type:  'GET' ,
					    data:  parametros,
						cache: false,
						success:  function (data) {
								 $("#ViewEstado").html(data);   
							     
	  					} 
				}); 
 
 } 
 

//-------------------------------------------------------------------------
// ir a la opcion de editar
// pone informacion de los tramites

function Recorrido(idcaso) {
	
	
	var parametros = {
            'id' : idcaso 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/Model-proceso_recorrido.php',
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
//--------------------------------------------

function goToURLProceso(festado,ftipo) {
	
	
	    $("#festado").val(festado);
 	    
		var parametros = {
					'festado' : festado  ,
					'ftipo' : ftipo
 		  };
		  
	
		
		jQuery.ajax({
			data:  parametros, 
		    url: '../grilla/grilla_cli_inicio.php',
			dataType: 'json',
			success: function(s){
		 	//console.log(s); 
		 	oTable.fnClearTable();
			if(s ){ 
				for(var i = 0; i < s.length; i++) {
					oTable.fnAddData([
								s[i][0],
								s[i][1] ,
								s[i][2],
								s[i][3],
								s[i][4],
			                  s[i][5],
		                      s[i][6], 
			                     	'<button class="btn btn-xs btn-warning" title="Ver Tramite" onClick="goTocaso('+"'editar'"+','+ s[i][0]+','+s[i][7]+','+ s[i][8]+','+ s[i][9]+')"><i class="glyphicon glyphicon-cog"></i></button> '   
 							]);										
						} // End For
			}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				
			});
 
 	 
    }
//-------------------------------------------()
function AnularProceso() {

    
	var id = $("#idcaso").val();      

   var novedad 	 = $("#novedad").val();

	var parametros = {
			'accion' : 'del' ,
			'novedad': novedad,
            'id' : id 
	};
  		
		  alertify.confirm("Desea Anular el tramite emitido?", function (e) {
			  if (e) {
 				  
							  $.ajax({
									data:  parametros,
									url:   '../model/Model-cli_incidencias_tarea.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
 										$("#result").html(data);	
										 alert('Proceso anulado...');
									     Recorrido(id);
  				 					} 
							}); 
 				  }
			 });
 	}
//------------------------	 
 function TerminarProceso() {

    
	var id = $("#idcaso").val();      

 var novedad 	 = $("#novedad").val();

	var parametros = {
			'accion' : 'terminar' ,
			'novedad' : novedad,
            'id' : id 
	};
	
 		
		  alertify.confirm("Desea Finalizar el tramite nro:" + id, function (e) {
			  if (e) {
 				  
							  $.ajax({
									data:  parametros,
									url:   '../model/Model-cli_incidencias_tarea.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
 										$("#result").html(data);	
										 alert('Proceso terminado...');
										Recorrido(id) ;
  				 					} 
							}); 
 				  }
			 });
 	}
//----------------------------------------------------
function goTocaso(accion,id,doc_user,proceso,tarea) {
	

	 Visor(accion, proceso,tarea,id,doc_user ); // pone tarea en el formulario


 
	 Ver_doc_prov(id);   

	 Ver_doc_user(id);

	 flujo(proceso); 	 

	 Recorrido( id );
 
 	
	 $('#mytabs a[href="#tab2"]').tab('show');
 
    $("#result").html('<img src="../../kimages/kedit.png" align="absmiddle"/><b> TRAMITE SELECCIONADO PARA RESPONDER ' + id + '</b>');
	 
   }
//----------------
//-------------------------------------------------------------------------  
 function modulo()
 {
 	 var modulo1 =  'kdocumento';
 	 
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
 // datos
  
 //----------------------------------------------
 function informacionproceso()
 {
	 
		var id = $("#codigoproceso").val( );
	 
 
		var parametros = {
	                     'id' : id 
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-procesoinformacion.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#InformaProceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#InformaProceso").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
 
 } 
//-----------------
 function FormView()
 {
     
    	 
    	 $("#ViewFiltro").load('../controller/Controller-caso_filtro.php');
    	 
    	 $("#ViewFormularioTarea").load('../controller/Controller-caso_tramite.php');
    	 
    	 
 
 }
//----------
//-------------------
 function  cc_sesion(sesion_siguiente)
 {
  
      var idcaso 			= $("#idcaso").val();
 	 
 	   var parametros = {
					'idcaso': idcaso,
					'accion' : 'add',
					'sesion_siguiente' :sesion_siguiente,
					'tipo' : 'N'
			};
  
  if ( idcaso > 0 ) {
		$.ajax({
					data:  parametros,
					url:   '../model/Model-caso__sesion_tarea.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormfilepara").html('Procesando');
						},
					success:  function (data) {
							   $("#ViewFormfilepara").html(data);   
						     
						} 
			}); 
		
	  }	 
  }
//--------
function  goToURLDocUserdel( id, idcaso)
 {
  
 
 	   var parametros = {
					'idcaso': idcaso,
					'accion' : 'del',
					'id' :id,
					'tipo' : '-'
			};
  
  if ( idcaso > 0 ) {
		$.ajax({
					data:  parametros,
					url:   '../model/Model-caso__sesion_del.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormfilepara").html('Procesando');
						},
					success:  function (data) {
							   $("#ViewFormfilepara").html(data);   
						     
						} 
			}); 
		
	  }	 
  }
//-----------
 function  Visor_user(idcaso)
 {
  
 	  
 	   var parametros = {
					'idcaso': idcaso,
					'accion' : 'visor',
					'sesion_siguiente' :'-',
					'tipo' : 'S'
			};
  
 
		$.ajax({
					data:  parametros,
					url:   '../model/Model-caso__sesion_tarea.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormfilepara").html('Procesando');
						},
					success:  function (data) {
							   $("#ViewFormfilepara").html(data);   
						     
						} 
			}); 
	 
  }
/*
 Formulario para ingreso de datos
 */
 function  Visor( accion,idproceso, tarea  ,idcaso,doc_user)
 {
  
  		var parametros = {
 		            'idproceso': idproceso,
					'tarea' : tarea,
					'idcaso' : idcaso,
					'accion' : accion,
					'doc_user': doc_user
			};
  
		$.ajax({
					data:  parametros,
					url:   '../controller/Controller-caso_tarea_tramite',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
 						     
							 $("#ViewFormularioTarea").html(data);   
						     
 						
						} 
			}); 
        
  }
 //-------------------------------------------------------
 function PoneUsuarioCondicion(tarea,idproceso,idcaso)
 {
	
	 
	 var parametros = {
			 'tarea' : tarea ,
			 'idproceso' : idproceso,
			 'idcaso':idcaso
			 };
	 
			 $.ajax({
					 data: parametros,
					 url: "../model/ajax_siguiente_tarea.php",
					 type: "GET",
					 success: function(response)
					 {
						 	$('#sesion_siguiente').html(response);
					 }
			 });
 
	 
	
 }
 //---------------------------
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
 /*
 */
 function  formato_doc_visor(   idproceso_docu  )
 {
	
 

	    var   	idcaso         = $("#idcaso").val();
 
	    var 	posicion_x; 
	    var 	posicion_y; 
	    var   	enlace = '../reportes/documento_matriz.php?caso='+idcaso+'&doc='+idproceso_docu;
	    var 	ancho = 1000;
	    var 	alto = 520;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
        
  }
 //--------------------------
function Ver_doc_user(idcaso) {

	 
     var parametros_user = {
    		 		'accion' : 'visor',
 					'idcaso' : idcaso  
  	  };

	  $.ajax({
 					data:  parametros_user,
 					url:   '../model/Model-caso__doc_tra02.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfileDoc").html(data);   
 
  					} 

			}); 
  
	  
}
//----------
 function  formato_doc_firmado( idproceso_docu  )
 {
	
	    var   	idcaso = $("#idcaso").val();
 
	    var   	enlace = '../reportes/documento_firma.php?caso='+idcaso+'&doc='+idproceso_docu;


 
 
		window.location.href = enlace;
	
        
  }

//-------------------
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
									url:   '../model/Model-addDoc01.php',
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
//---------------------------------------------
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
									url:   '../model/Model-addDoc01.php',
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
Archivos q se descargan.....
*/
function Ver_doc_prov(idcaso) {

	 
      var parametros = {
    		 		'accion' : 'visor',
 					'idcaso' : idcaso  
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-caso__doc_tra.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);   
   					} 

			}); 
  
	  
      var parametros1 = {
    		 		'accion' : 'variable',
 					'id' : idcaso  
  	  };

	  $.ajax({
 					data:  parametros1,
 					url:   '../model/Model-cli_incidencias_tarea.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#Resultados").html(data);   
 
  					} 

			}); 
}
 //------------------------
 function goToURLDocdel(idcodigo,idcaso) {

 	 
     var parametros = {
  					'idcodigo' : idcodigo  ,
 					'idcaso'   : idcaso,
 					'accion' : 'del'
  	  };

 	  $.ajax({
  					data:  parametros,
  					url:   '../model/Model-caso__doc_tra.php',
  					type:  'GET' ,
  					success:  function (data) {
  						
  							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
   
  					} 

 			}); 
  
   }
 //------------
 function openFile(url,ancho,alto) {
     
 	  var idcaso = $("#idcaso").val();
 		 
 	  var posicion_x; 

 	  var posicion_y; 

 	  var enlace; 
 	 
 	  posicion_x=(screen.width/2)-(ancho/2); 

 	  posicion_y=(screen.height/2)-(alto/2); 
 	 
 	  enlace = url+'?id='+idcaso  ;
 	 
 	  if ( idcaso > 0) {
 		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

 		}
 }

 function openFileedit(codigo,url,ancho,alto) {
     
 	  var idcaso = $("#idcaso").val();
 		 
 	  var posicion_x; 

 	  var posicion_y; 

 	  var enlace; 
 	 
 	  posicion_x=(screen.width/2)-(ancho/2); 

 	  posicion_y=(screen.height/2)-(alto/2); 
 	 
 	  enlace = url+'?id='+idcaso+'&accion=edit&iddoc=' +codigo  ;

	   if ( idcaso > 0) {
 		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

 		}
 }
//----------------------
 function openFileadd(url,ancho,alto) {
     
 	  var idcaso = $("#idcaso").val();
 		 
 	  var posicion_x; 

 	  var posicion_y; 

 	  var enlace; 
 	 
 	  posicion_x=(screen.width/2)-(ancho/2); 

 	  posicion_y=(screen.height/2)-(alto/2); 
 	 
 	  enlace = url+'?id='+idcaso+'&accion=add'  ;
 	 
 	 if ( idcaso > 0) {

 		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

 		}
 }
 /*
 */
 function visor_editor( id ) {
 
 
    var url =  '../view/cli_editor_caso_seg.php?id=' + id +'&accion=add'  ;

  	$('#ieditor').attr('src', url);
		 
 
	 

 }	
 //---------------------------
 function  solicita_valida(  )
 {
	 
 
 	   var idproceso = 	$("#codigoproceso").val();
		
  	   
		var parametros = {
 		           'idproceso': idproceso
			};
  
		$.ajax({
			    type:  'GET' ,
				data:  parametros,
				url:   '../model/Valida_user_solicita.php',
				dataType: "json",
				success:  function (response) {

					
						 $("#idprov").val( response.a );  
						 
						 $("#razon").val( response.b );  
						  
				} 
		});
        
  }
//---------------
function  SiguienteDato( paso )
 {

	var sesion_siguiente = $("#sesion_siguiente").val();  
	
	if ( sesion_siguiente ) {
	 
		$('#mytabs a[href="#f2"]').tab('show');
	}else{
		alert('Ingrese');
	}


  }
  //-----------------
 function  flujo( idproceso )
 {
	 
  		
		var parametros = {
 		           'id': idproceso
			};
  
		$.ajax({
					data:  parametros,
					url:   '../controller/Controller-proceso_dibujo.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#DibujoFlujo").html('Procesando');
						},
					success:  function (data) {
							 $("#DibujoFlujo").html(data);  // $("#cuenta").html(response);
						     
						} 
			}); 
        
  }
 //-------------- pone documento para revision
 function  formato_doc(idproceso, tipo , codigo ,idtarea)
 {
	 
 
	    var   idcaso = $("#idcaso").val();
        var posicion_x; 
        var posicion_y; 
        var enlace; 
        ancho = 1124;
        alto = 600;
        posicion_x=(screen.width/2)-(ancho/2); 
        posicion_y=(screen.height/2)-(alto/2); 
      
  
        if (idcaso) {
        	
        	   enlace = '../view/cli_editor_caso?caso='+idcaso+'&task='+idtarea+'&process='+idproceso+'&tipo='+tipo+'&codigo='+codigo;
               
               window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
               
        }
 
  }
 //-----------------

 
 //------------------------ 
 function LeerProceso() {
	 
	var mensaje = 'Marcar leido Documento.... No se olvide de agregar comentario!!!';			 
	   
	var id 		     = $("#idcaso").val( );
   
	if ( id > 0 ) {
	   
		 alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			 
		 if (e) {
			
			   var idproceso 	         = $("#codigoproceso").val();
				var tarea_actual         = $("#tarea_actual").val();
			   var novedad 	 			 = $("#novedad").val();
			   var sesion_siguiente 	 = $("#sesion_siguiente").val();
			   var siguiente 			 = $("#doc_user").val();
			   var sesion_reasigna 	     = $("#sesion_reasigna").val();
			   
		   
			   if (sesion_siguiente){		

								 var parametros = {
												'id' : id ,
												'idproceso' : idproceso,
												'accion': 'leido',
												'tarea_actual' : tarea_actual,
												'novedad' : novedad,
												'sesion_siguiente' : sesion_siguiente,
												'siguiente' : siguiente,
												'sesion_reasigna' : sesion_reasigna
								  };
								 
								  $.ajax({
											   data:  parametros,
											   url:   '../model/Model-cli_incidencias_tarea.php',
											   type:  'GET' ,
											   cache: false,
											   beforeSend: function () { 
														$("#result").html('Procesando');
												 },
											   success:  function (data) {
														$("#result").html(data);  
														
														Recorrido( id );
												 } 
									   }); 
				   } else{		
					   alert('Verifique el usuario que requiere enviar el tramite...');
				   }
			  }
		}); 
	}	 
}
 //--------------------
 function EnviarProcesoSeg() {
	 
		 var mensaje = 'Desea generar el proceso para su gestion?';			 
			
	     var id 		     = $("#idcaso").val( );
		
	     if ( id > 0 ) {
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
				  
			  if (e) {
				 
				    var idproceso 	 = $("#codigoproceso").val();
 				    var tarea_actual = $("#tarea_actual").val();
				    var novedad 	 = $("#novedad").val();
				    var sesion_siguiente 	 = $("#sesion_siguiente").val();
					var siguiente 			 = $("#doc_user").val();
					var sesion_reasigna 	 = $("#sesion_reasigna").val();
				    
				
					if (sesion_siguiente){		

 									 var parametros = {
								                     'id' : id ,
								                     'idproceso' : idproceso,
								                     'accion': 'aprobado',
								                     'tarea_actual' : tarea_actual,
								                     'novedad' : novedad,
													 'sesion_siguiente' : sesion_siguiente,
													 'siguiente' : siguiente,
													 'sesion_reasigna' : sesion_reasigna
								 	  };
 									 
		 							  $.ajax({
													data:  parametros,
													url:   '../model/Model-cli_incidencias_tarea.php',
													type:  'GET' ,
													cache: false,
													beforeSend: function () { 
								 							$("#result").html('Procesando');
								  					},
													success:  function (data) {
															 $("#result").html(data);  
														     
															 Recorrido( id );
								  					} 
											}); 
						} else{		
							alert('Verifique el usuario que requiere enviar el tramite...');
						}
 				  }
			 }); 
	     }	 
 }
 