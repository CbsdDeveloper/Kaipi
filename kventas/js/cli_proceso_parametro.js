var oTable;
var oTableDoc;  
var oTableReq ;
var b1;
var b2;
var b3;
//------------------------------------------------------------
// inicio 
$(function(){
 
    $(document).bind("contextmenu",function(e){
        return false;
    });
 	
});
//-------------------------------------------------------------------------
// inicio de variables 
$(document).ready(function(){
//------------------------- 
	  	b1 = $("#bandera1").val();
	  	b2 = $("#bandera2").val();
	  	b3 = $("#bandera3").val();
	  	
	    oTable = $('#json_variable').dataTable(); 
	
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
  

});  
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
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
	  
	 

	 
	  
 
    }
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

//---------------------------------------------
//--------------- crea y actualiza formulario de tareas....
// ............................................
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
				     
				} 
	}); 



     $('#guardarTarea').html('Asigne las variables a la tarea');

 	 $('#myModaltarea').modal({show: true});
 	
 	 VerResponsableTarea( idproceso, id  );
 	
     VerRequisitoTarea( idproceso, id  );
 	
 	 VerDocumentoTarea( idproceso, id  );
 
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
//------------
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
	
    $("#guardarAux").html('Agregue  variable [Agregar Registro]' );
	
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
	
	$("#tipo").val("");
 	
	$("#estado").val("");
 

 }
 
//----------------------
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
 
 //------------------------------- datos
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
//-----------------
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
 
 function valida()
 {
	 
	 var tipo = $("#tipo").val(); 
  
	 $("#tabla").prop('disabled', 'disabled');
 
	 $("#lista").prop("readonly", true);
	 
	 if (tipo == 'lista'){
		 $("#lista").prop("readonly", false);
 	 }
	 
	 if (tipo == 'listaDB'){
		 $("#tabla").removeAttr("disabled");
		
	 }
 
	 if (tipo == 'vinculo'){
		 $("#lista").prop("readonly", false);
 	 }
 
 }

 //---
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
						'<b>'+s[i][1] + '</b>',
						s[i][2],
						s[i][3],
						'<button class="btn btn-xs" onClick="javascript:goToURL1('+"'editar'"+','+ s[i][4] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs" onClick="javascript:goToURL1('+"'del'"+','+ s[i][4] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
							'<button class="btn btn-xs" onClick="javascript:goToURL3('+"'editar'"+','+ s[i][3] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL3('+"'del'"+','+ s[i][3] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
			beforeSend: function () { 
						$("#DetalleUnidadTarea").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleUnidadTarea").html(data);  // $("#cuenta").html(response);
				     
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
			async: true,
			cache: false,
			beforeSend: function () { 
						$("#DetalleUnidadTarea").html('Procesando');
				},
			success:  function (data) {
					 $("#DetalleUnidadTarea").html(data);  // $("#cuenta").html(response);
				     
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
//-------------- guarda responsable por tarea del proceso / requisitos
function GuardaRequisitos( idproceso, idtarea  ){    

	 var idproceso_requi 		= $('#idproceso_requisito').val();
 	 var requisito_perfil  		= $('#requisito_perfil').val();
	 var accionAdd			    = 'add';
	  
	 
 
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
					 $("#DetalleRequisitos").html(data);  // $("#cuenta").html(response);
					  
					 alert('Dato actualizado correctamete...');
					  
					  $('#requisito_perfil').val('');
					  
					  VerRequisitoTarea( idproceso, idtarea  );
					  
				} 
	}); 
 
}
//----------------- Visor de tarea proceso requisito
function VerRequisitoTarea( idproceso, idtarea  ){    
	 
	 
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
					 
					 $("#tipo").val( response.b );  
					 
					 $("#enlace").val( response.c );  
					 
					 $("#tabla").val( response.d );  
					 
					 $("#lista").val( response.e );  
					 
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
function GuardaDocumento( idproceso, idtarea  ){    

	 var idproceso_docu 		= $('#idproceso_docu_var').val();
	 var perfil_documento  		= $('#perfil_documento').val();
	 var accionAdd			    = 'add';
	  
 
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
					 $("#DetalleDocumentos").html(data);  // $("#cuenta").html(response);
				     
					 alert('Dato actualizado correctamete...');


					 $('#perfil_documento').val('');

					 VerDocumentoTarea( idproceso, idtarea  );
					 
				} 
	}); 
 
}
//----------------- Visor de tarea proceso requisito
function VerDocumentoTarea( idproceso, idtarea  ){    
	 
	 
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