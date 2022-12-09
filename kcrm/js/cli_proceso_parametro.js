var oTable;
var oTableDoc;  
var oTableReq ;
var b1;
var b2;
var b3;
//------------------------------------------------------------

$(function(){
 
    $(document).bind("contextmenu",function(e){
        return false;
    });
 	
});

//-------------------------------------------------------------------------
// inicio de variables 

$(document).ready(function(){
	
 
	  	b1 = $("#bandera1").val();
	  	b2 = $("#bandera2").val();
	  	b3 = $("#bandera3").val();
	  	
	    oTable    = $('#json_variable').dataTable(); 
	
	    oTableDoc = $('#json_documento').dataTable(); 
	    
	    oTableReq = $('#json_requisito').dataTable(); 
	     
	  //------------------------- formulario de datos
	    
	    $("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
		
		FormArbolCuentas(); 
		
    	FormVariables();
    	
	  //------------ ---------------  ejecuta opciones de busqueda
		  $('#loadvariables').on('click',function(){
			  
			  VariableGrilla(oTable);
	  			
		 });
		
		  $('#saliraux').on('click',function(){
			  
			  VariableGrilla(oTable);
	  			
		 });
		
			 $('#baprobacion').on('click',function(){
	    		   
	    		  publicacion_proceso();
	    			
	  		});
			 
			 
			 $('#brevertir').on('click',function(){
		  		   
		   		  revertir_proceso();
		   			
		 		}); 
		  
		  //------------ carga documentos ---------------------------------
		  
	    $('#loaddocumento').on('click',function(){
			  
			  DocumentoGrilla(oTableDoc);
	  			
		 });
	
	    $('#saliraux2').on('click',function(){
		  
		  DocumentoGrilla(oTableDoc);
  			
	   });
	    
	  //------------ carga requisitos  ---------------------------------
	  $('#loadrequisito').on('click',function(){
		  
		  RequisitosGrilla(oTableReq);
  			
	 });
	  
	  $('#saliraux1').on('click',function(){
		  
		  RequisitosGrilla(oTableReq);
  			
	 });
	  
	 //------------ carga requisitos  ---------------------------------
	   
	 $('#variablequery').on('click',function(){
				  if (b1 == 'N') {
					  VariableGrilla(oTable);
					  $("#bandera1").val('S');
				  }
			 });	 
			  
	  $('#requisitosquery').on('click',function(){
			  if (b2 == 'N') {
				  RequisitosGrilla(oTableReq);
				  $("#bandera2").val('S');
			  }
 			 });	
		  
	  $('#documentoquery').on('click',function(){
			  if (b3 == 'N') {
				  DocumentoGrilla(oTableDoc);
				  $("#bandera3").val('S');
			  }
 		 });  
  
	  
	  $('#guardaproce').on('click',function(){
		   
  		  procedimiento_proceso();
  			
		}); 
	  
	 
		
	  $("a[rel='pop-up']").click(function () {
		  
			var id = $("#codigoproceso").val();
			
	      	var caracteristicas = "height=500,width=1024,scrollTo,resizable=1,scrollbars=1,location=0";
	      	
	      	nueva=window.open(this.href + '?id='+id, 'Popup', caracteristicas);
	      	
	      	return false;
	  });   

});  
///-----------------------
///-----------------
function revertir_proceso(   ){    
	 
    var id =   $("#codigoproceso").val( );
       
    var observa =  $("#observa").val();
   
	 var parametros = {
	       'idproceso': id ,
	       'observa' : observa,
	       'accion' : 2
			};
	
	  
	  alertify.confirm("<p>Desea revertir proceso!!!..." +id+ " <br><br></p>", function (e) {
			  if (e) {
			  	 
				  	 	$.ajax({
							data:  parametros,
							url:   '../model/Model-publicacion.php',
							type:  'GET' ,
							async: true,
							cache: false,
							beforeSend: function () { 
										$("#publicadoProceso").html('Procesando');
								},
							success:  function (data) {
									 $("#publicadoProceso").html(data);  
								     
								} 
					}); 
                 
               
			  }
			 }); 

}
//----------------------
function Ver_doc_user(idcaso) {

	 
     var parametros_user = {
    		 		'accion' : 'visor',
 					'idcaso' : idcaso  
  	  };

	  $.ajax({
 					data:  parametros_user,
 					url:   '../model/ajax_file_visor.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);   
 
  					} 

			}); 
  
	  
}
//------------
  function goToURLDocdel(idcodigo,idcaso) {

 

				var parametros = {
								'idcodigo' : idcodigo  ,
								'idcaso'   : idcaso  ,
								'accion' : 'del'
				   };
			
				  $.ajax({
								 data:  parametros,
								url:   '../model/ajax_file_visor.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#ViewFormfile").html(data);   
			  
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
//----------------- Visor de tarea proceso requisito
function publicacion_proceso(   ){    
	 
	     var id =   $("#codigoproceso").val( );
	        
	     var observa =  $("#observa").val();
	    
		 var parametros = {
 		       'idproceso': id ,
 		       'observa' : observa,
 		      'accion' : 1
  			};
		
		  
		  alertify.confirm("<p>Desea publicar proceso!!!..." +id+ " <br><br></p>", function (e) {
				  if (e) {
 				  	 
					  	 	$.ajax({
								data:  parametros,
								url:   '../model/Model-publicacion.php',
								type:  'GET' ,
								async: true,
								cache: false,
								beforeSend: function () { 
											$("#publicadoProceso").html('Procesando');
									},
								success:  function (data) {
										 $("#publicadoProceso").html(data);  
									     
									} 
						}); 
	                  
	                
				  }
				 }); 
 
}
//-----------------------------------------------------------------
function FormArbolCuentas()
{

   $("#ViewFormArbol").load('../controller/Controller-proceso_parametro' );

}

function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
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
/*
00 LLAMAR A LAS FUNCIONES PARA PONER EL PROCESO SELECCIONADO.
*/
function goToURL(id,modelador) {
	
	
	
	$("#codigoproceso").val(id);
	$("#idproceso").val(id);
	$("#idproceso2").val(id);
	$("#idproceso1").val(id);
	$("#action").val('add');
	$("#action1").val('add');
	$("#action2").val('add');
	$("#bandera1").val('N');
	$("#bandera2").val('N');
	$("#bandera3").val('N');
	
	var parametros = {
                     'id' : id 
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
						
							 $("#DibujoFlujo").html(data);   
							 
							  cargaproceso(modelador);
							  
							  tareaproceso(modelador);
							  
						     
  					} 
			}); 
	  
	 	    Ver_doc_user(id) ;
	 	     
	        procedimiento_ver(id);
}
/*
00.01 CARGA PROCEDIMIENTO DEL PROCESO
*/
function procedimiento_ver( id  ){  
	
	 
    
    var parametros = {
		       'idproceso': id ,
 		       'accion' : 2
			};
    
			$.ajax({
				type:  'POST' ,
				data:  parametros,
				url:   '../model/Model-procedimiento.php',
				dataType: "json",
				success:  function (response) {
						
							 tinyMCE.get('procedimiento').setContent(response.a);
 
				} 
		   });
		   
		   

    var parametros1 = {
		       'idproceso': id ,
 		       'accion' : 3
			};

	$.ajax({
				type:  'POST' ,
				data:  parametros1,
				url:   '../model/Model-procedimiento.php',
				dataType: "json",
				success:  function (response) {
						
 	 
						      var urlimagen = response.a;
						      
						      var path_imagen = '../../archivos/' + urlimagen ;
 
							  var imagenid = document.getElementById("ImagenUsuario");
							    
							  imagenid.src = path_imagen; 
				} 
		   });

 

    
}
//-------------------------------------------------
function goToURL1(accionTipo,id) {
	
	  
	var parametros = {
			'accion' : accionTipo ,
            'id' : id 
	};
	
	$("#action").val(accion);
	
	$("#idproceso_var").val(id);
	
	
$.ajax({
			data:  parametros,
			url:   '../model/Model-variables.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#guardarAux").html('Procesando');
				},
			success:  function (data) {
					 $("#guardarAux").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 

 	$('#myModalAux').modal({show: true});
 
    }

/*
01.01  crea y actualiza formulario de tareas....
*/
function wktarea(id,idproceso) {
 
	var parametros = {
             'id' : id ,
             'idproceso': idproceso
	};
	
	$('#codigotarea').val(id);
 
	$.ajax({
			data:  parametros,
			url:   '../controller/Controller-wtarea.php',
			type:  'GET' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#ViewTarea").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewTarea").html(data);  // $("#cuenta").html(response);
				     
					 	 VerResponsableTarea( idproceso, id  );
						
					     VerRequisitoTarea( idproceso, id  );
					  	
					 	 VerDocumentoTarea( idproceso, id  );
					 
				} 
	}); 

	



     $('#guardarTarea').html('Asigne las variables a la tarea');

 	 $('#myModaltarea').modal({show: true});
 	
 	
 	

    }


//------------
function goToURL3(accion,id) {
	
	  
	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	$("#action2").val(accion);
	
	$("#idproceso_docu").val(id);
	
 
$.ajax({
			data:  parametros,
			url:   '../model/Model-documento.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#guardarDocumento").html('Procesando');
				},
			success:  function (data) {
					 $("#guardarDocumento").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 

 	$('#myModaldocumento').modal({show: true});
 
    }

/*
GUARDAR PROCEDIMIENTO DEL PROCESO
*/	
function procedimiento_proceso(){  
	
	var id 			    = $("#codigoproceso").val( );
    var procedimiento   = tinyMCE.get('procedimiento').getContent();

    
    var parametros = {
		       'idproceso': id ,
		       'procedimiento' : procedimiento,
		       'accion' : 1
			};
    
    $.ajax({
			data:  parametros,
			url:   '../model/Model-procedimiento.php',
			type:  'POST' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#GuardaProcedimiento").html('Procesando');
				},
			success:  function (data) {
					    $("#GuardaProcedimiento").html(data);  
				     
				} 
	}); 
    
}
//----------------
function goToURL2(accion,id) {
	
	  
	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	$("#action1").val(accion);
	
	$("#idproceso_requi").val(id);
	
 
$.ajax({
			data:  parametros,
			url:   '../model/Model-requisito.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#guardarRequisito").html('Procesando');
				},
			success:  function (data) {
					 $("#guardarRequisito").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 

 	$('#myModalRequisito').modal({show: true});
 
    }
//-------------------------------------------------------------------------
//ir a la opcion de editar
function agregaVariable( ) {
	
	LimpiarPantalla();
	
    $("#guardarAux").html('NUEVO REGISTRO [ AGREGAR VARIABLE AL PROCESO ]' );
	
    $("#action").val('add');
	
 }

//ir a la opcion de editar
function agregaDocumento( ) {
	
	LimpiarPantalla2();
	
    $("#guardarDocumento").html('Agregue el documento, la variable tipo fecha esta dentro de cada tarea');
	
    $("#action2").val('add');
	
 }
//ir a la opcion de editar
function agregaRequisito( ) {
	
	LimpiarPantalla1();
	
    $("#guardarRequisito").html('Agregue el requisito, la variable tipo fecha esta dentro de cada tarea');
	
    $("#action1").val('add');
	
 }

//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
	
	$("#idproceso_var").val(0);
	$("#variable").val("");
	$("#tipo").val("");
	$("#tabla").val("");
	$("#estado").val("");
	$("#lista").val("");
	 $("#sistema").val( 'N' );  
	 $("#enlace_url").val("");
 

	 
    }

//-------------------------------------------------------------------------
//ir a la opcion de editar
function LimpiarPantalla2() {
	
	$("#idproceso_docu").val(0);
	
	$("#documento").val("");
	
	$("#tipo").val("");
 	
	$("#estado").val("");
 

 }
//ir a la opcion de editar
function LimpiarPantalla1() {
	
	$("#idproceso_requi").val(0);
	
	$("#requisito").val("");
	
	$("#tipo_req").val("");
 	
	$("#estado_req").val("");
 

 }
 
//---------------------- 
//--- CONTROL DE INGRESO DE VARIABLES
 function accion(id,accionTipo)
 {
    
			$("#action").val(accionTipo);
			
			$("#idproceso_var").val(id);          
 
 }
//----------------------
 
 function accion2(id,modo)
 {
    
			$("#action2").val(modo);
			$("#idproceso_docu").val(id);          
 
 }
//----------------------
 
 function accion1(id,modo)
 {
   
			$("#action1").val(modo);
			
			$("#idproceso_requi").val(id);          
 
 }
  //------------------------------------------------------------------------- 
  function BusquedaGrilla( ){        	 

	  $.ajax({
 			url:   '../controller/Controller-proceso01.php',
			type:  'POST' ,
			cache: false,
			beforeSend: function () { 
					$("#listaproceso").html('Procesando');
			},
			success:  function (data) {
					 $("#listaproceso").html(data);  // $("#cuenta").html(response);
				     
			} 
	}); 
 	
  }   
  //------------------------------------------------------------------------- 
 function modulo()
 {
 	 var moduloOpcion =  'kcrm';
 	 var parametros = {
			    'ViewModulo' : moduloOpcion 
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
 
 // ------------------------------------- datos
 function cargaproceso(modelador)
 {
	 
		var id = $("#codigoproceso").val( );
		
		var urlProceso =  '../model/Model-procesocarga.php';
		
	 
		if (modelador == 1) {
			urlProceso =  '../model/Model-procesocarga_B.php';
         } 
			
		
 
		var parametros = {
	                     'id' : id 
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   urlProceso,
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#ViewProceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewProceso").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
		
			

 } 
 
 /*
 01. Lista de tareas
 */
 function tareaproceso(modelador)
 {
	 
		var id = $("#codigoproceso").val( );
	 
 
		var parametros = {
	                     'id' : id 
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-procesotarea.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#listaTareas").html('Procesando');
	  					},
						success:  function (data) {
								 $("#listaTareas").html(data);  // $("#cuenta").html(response);
							     
	  					} 
	   }); 
 
 
 
 
 } 
//------------------------------------------------------------------------------------- 
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
//-----------------------------------------------------------------------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-cli_proceso.php');
      

 }
/*
01.01.01 valida condicion de las tareas
*/
 function  valida_condicion( dato)
 {
    
	 if (dato == 'S'){
		  $('#anterior').prop('disabled', false);
	 }else{
		 $('#anterior').prop('disabled', 'disabled');
	 }
 
 }
 //----------------------
 function FormVariables()
 {
  
	 $("#ViewVariables").load('../controller/Controller-variables.php');
	 
	 $("#ViewRequisitos").load('../controller/Controller-requisitos.php');
	 
	 $("#ViewDocumento").load('../controller/Controller-documento.php');
	 
	 
 }
 /*
 valida variables para seleccion de tipo de variables
 */
 function valida()
 {
	 
	 var tipo = $("#tipo_var").val(); 
  
	 $("#tabla").prop('disabled', 'disabled');
 
	 $("#lista").prop("disabled", true);

	 $("#enlace_url").prop("disabled", true);
	 
	 if (tipo == 'lista'){
		 $("#lista").prop("disabled", false);
 	 }
	 
	 if (tipo == 'listaDB'){
		 $("#tabla").removeAttr("disabled");
		
	 }
 
	 if (tipo == 'vinculo'){
		$("#enlace_url").prop("disabled", false);
   	 }
 
 }
//-----------------------------------------
 function openFile(url,ancho,alto) {
	
	
    var idproceso =	$("#codigoproceso").val();
      
 	  var posicion_x; 

 	  var posicion_y; 

 	  var enlace; 
 	 
 	  posicion_x=(screen.width/2)-(ancho/2); 

 	  posicion_y=(screen.height/2)-(alto/2); 
 	 
 	  enlace = url + '?id=' + idproceso;
 	 
 	  if ( idproceso > 0) {
 		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

 		}
 }
/*
Pone variables en la tabla para visualizacion y edicion
*/
 function VariableGrilla( oTable ){        	 

	 
     	var id =	$("#codigoproceso").val();
      	
        var parametros = {
				'id' : id  
        };
 
     
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_wk_variables.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
					 oTable.fnAddData([
						'<b>'+s[i][0] + '</b>',
					     s[i][1] ,
						'<b>'+s[i][2] + '</b>',
						s[i][3],
						s[i][4],
						'<button class="btn btn-xs btn-warning" onClick="goToURL1('+"'editar'"+','+ s[i][5] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs btn-danger" onClick="goToURL1('+"'del'"+','+ s[i][5] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
					]);										
				} // End For
			 }				
 			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
 
  }   
//------------------
function DocumentoGrilla( oTableDoc ){        	 

	 
     	var id =	$("#codigoproceso").val();
 
     	
        var parametros = {
				'id' : id  
        };
 
     
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_wk_documentos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTableDoc.fnClearTable();
			if (s){ 
					for(var i = 0; i < s.length; i++) {
						oTableDoc.fnAddData([
							'<b>'+s[i][0] + '</b>',
							s[i][1],
							s[i][2],
							'<button class="btn btn-xs btn-warning" onClick="goToURL3('+"'editar'"+','+ s[i][3] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs btn-danger" onClick="goToURL3('+"'del'"+','+ s[i][3] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
									
			  }							
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
 
  }   
//------------------
function RequisitosGrilla( oTableReq ){        	 

	 
     	var id =	$("#codigoproceso").val();
 
     	
        var parametros = {
				'id' : id  
        };
 
     
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_wk_requisitos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTableReq.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
					oTableReq.fnAddData([
						'<b>'+s[i][0] + '</b>',
						s[i][1],
						s[i][2],
						'<button class="btn btn-xs" onClick="javascript:goToURL2('+"'editar'"+','+ s[i][3] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs" onClick="javascript:goToURL2('+"'del'"+','+ s[i][3] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
					]);										
				} // End For
 			  }							
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
 
  }   
 //-------------- guarda responsable por tarea del proceso / parametrizacion
 function GuardaResponsable( idproceso, idtarea  ){    
 
	 var ambito_proceso = $('#ambito_proceso').val();
	 var unidad  		= $('#unidad').val();
	 var reasignar  	= $('#reasignar').val();
	 var perfil  		= $('#perfil').val();
	 var accionAdd		= 'add';
	  
	 var parametros = {
             'idtarea' : idtarea ,
             'idproceso': idproceso,
             'ambito_proceso' : ambito_proceso,
             'unidad' : unidad,
             'reasignar' : reasignar,
             'perfil' : perfil,
             'accion': accionAdd
	};
	 
    $.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_user.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
					  $("#GuardaUnidadTarea").html(data);  // $("#cuenta").html(response);
				     
					  alert('Dato actualizado correctamete...');
					    
					  VerResponsableTarea( idproceso, idtarea  );
				} 
	}); 
 }
//----------------- Visor de tarea proceso respomsable
 function VerResponsableTarea( idproceso, idtarea  ){    
	 
 	 
	 var parametros = {
             'idtarea' : idtarea ,
             'idproceso': idproceso ,
             'tipo': 'D' 
	};
	 
	  $.ajax({
			data:  parametros,
			url:   '../model/Model-visortarea_user.php',
			type:  'GET' ,
			cache: false,
			success:  function (data) {
				
					 $("#UnidadTarea1").html(data);  
				     
				} 
	}); 
	  
 
 
 }
//----------------- Visor de tarea proceso respomsable
function delResponsable( acciondel, idprimario  ){    
	 
	var idtarea =  $('#codigotarea').val();
	var idproceso   =  $('#codigoproceso').val();
	
	 var parametros = {
             'id' : idprimario ,
             'accion': acciondel
	};
	 
   $.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_user.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleUnidadTarea").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleUnidadTarea").html(data);  // $("#cuenta").html(response);
					 
					 alert('Dato Eliminado correctamete...');
					   
					 VerResponsableTarea( idproceso, idtarea  );
				} 
	}); 
 
} 
/*
01.01.03 guarda responsable por tarea del proceso / requisitos
*/
function GuardaRequisitos( tipo, idproceso, idtarea, idproceso_requi ,objeto ){    

 
 	 
	 var accionAdd			    = 'add';
	  
	 var che1 =  '#operador'     + idproceso_requi ;
	 var che2 =  '#observador'   + idproceso_requi;
	 
 
	 
	 if ( tipo == 1){
 		 if (objeto.checked == true){
 			   requisito_perfil ='operador';
 			    $(che1).prop('checked', true);
 			    $(che2).prop('checked', false);
  	 	    } else {
	 	    	requisito_perfil ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
 	 }else{
		
		 if (objeto.checked == true){
			    requisito_perfil ='observador';
			    $(che1).prop('checked', false);
			    $(che2).prop('checked', true);
	 	    } else {
	 	    	requisito_perfil ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
	 }
		 
	 
 	 
				 var parametros = {
			           'idtarea'  : idtarea ,
			           'idproceso': idproceso,
			           'idproceso_requi' : idproceso_requi,
			           'requisito_perfil' : requisito_perfil ,
			           'accion': accionAdd
				};
			 
			  $.ajax({
						data:  parametros,
						url:   '../model/Model-addtarea_requisito.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
							
									$("#DetalleRequisitos").html('Procesando');
							},
						success:  function (data) {
							
								 $("#DetalleRequisitos").html(data);   
								  
							 
			 	  
							} 
				}); 
				 
 
}
//----------------- Visor de tarea proceso requisito
function VerRequisitoTarea( idproceso, idtarea  ){    
	 
	 /*
	 var parametros = {
           'idtarea' : idtarea ,
           'idproceso': idproceso 
	};
	 
  $.ajax({
			data:  parametros,
			url:   '../model/Model-visortarea_requi.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleRequisitos").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleRequisitos").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 
*/
}
//----------------- Visor de tarea proceso requisito
function AsignaVariableG(  valor_variable  ){    
	
	 
	 
	var parametros = {
			"valor_variable" : valor_variable 
	};
	 
	$.ajax({
		    type:  'GET' ,
			data:  parametros,
			url:   '../model/VariableSistema.php',
			dataType: "json",
			success:  function (response) {

				
					 $("#variable").val( response.a );  
					 
					 $("#tipo_var").val( response.b );  
					 
					 $("#enlace").val( response.c );  
					 
					 $("#tabla").val( response.d );  
					 
					 $("#lista").val( response.e );  

					 $("#enlace_url").val( response.f );  
					 
					 $("#variableSistema").val( 0 );  
					 
					 $("#sistema").val( 'S' );  
			} 
	});
	

}
//----- 
//----------------- Visor de tarea proceso respomsable
function delRequisito( acciondel, idprimario  ){    
	 
	var idtarea =  $('#codigotarea').val();
	var idproceso   =  $('#codigoproceso').val();
	
	 var parametros = {
           'id' : idprimario ,
           'accion': acciondel
	};
	 
 $.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_requisito.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleRequisitos").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleRequisitos").html(data);  // $("#cuenta").html(response);
				     
					 alert('Dato Eliminado correctamete...');
					 
					 VerRequisitoTarea( idproceso, idtarea  );
				} 
	}); 
  
} 
//--------------------------------
//-------------- guarda responsable por tarea del proceso / requisitos
function GuardaDocumento( tipo, idproceso, idtarea,idproceso_docu ,objeto ){    

	 
	 
 	  
	 var che1 =  '#doperador'     + idproceso_docu ;
	 var che2 =  '#dobservador'   + idproceso_docu;
 
	 var perfil_documento  		=  '';
	 var accionAdd			    = 'add';
	 
	 if ( tipo == 1){
		 if (objeto.checked == true){
			    perfil_documento ='operador';
			    $(che1).prop('checked', true);
			    $(che2).prop('checked', false);
 	 	    } else {
	 	    	requisito_perfil ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
	 }else{
		
		 if (objeto.checked == true){
			    perfil_documento ='observador';
			    $(che1).prop('checked', false);
			    $(che2).prop('checked', true);
	 	    } else {
	 	    	 perfil_documento ='-';
	 	    	 $(che1).prop('checked', false);
	 			 $(che2).prop('checked', false);
	 	    }
	 }
	 
 
	 var parametros = {
         'idtarea'  : idtarea ,
         'idproceso': idproceso,
         'idproceso_docu' : idproceso_docu,
         'perfil_documento' : perfil_documento ,
         'accion': accionAdd
	};
	 
	 $.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_doc.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleDocumentos").html('Procesando');
				},
			success:  function (data) {
					
					 $("#DetalleDocumentos").html(data);  
				    
 					 
				} 
	}); 
 
}
//----------------- Visor de tarea proceso requisito
function VerDocumentoTarea( idproceso, idtarea  ){    
	 
	 /*
	 var parametros = {
         'idtarea' : idtarea ,
         'idproceso': idproceso 
	};
	 
$.ajax({
			data:  parametros,
			url:   '../model/Model-visortarea_docu.php',
			type:  'GET' ,
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#DetalleDocumentos").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleDocumentos").html(data);  // $("#cuenta").html(response);
				     
				} 
	}); 
*/
}
//----------------- Visor de tarea proceso respomsable
function delDocumento( acciondel, idprimario  ){    
	 
	var idtarea =  $('#codigotarea').val();
	var idproceso   =  $('#codigoproceso').val();
	
	 var parametros = {
         'id' : idprimario ,
         'accion': acciondel
	};
	 
$.ajax({
			data:  parametros,
			url:   '../model/Model-addtarea_doc.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#DetalleDocumentos").html('Procesando');
				},
			success:  function (data) {
				
					 $("#DetalleDocumentos").html(data);  
				     
 					 alert('Dato Eliminado correctamete...');

					 VerDocumentoTarea( idproceso, idtarea  );
					 
				} 
	}); 
 
} 