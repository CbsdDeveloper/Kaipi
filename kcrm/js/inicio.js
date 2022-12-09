 var oTable;

 
$(document).ready(function(){
       
 
	    
	    oTable =  $('#json_variable').dataTable( {
 		    "aoColumnDefs": [
 		      { "sClass": "de", "aTargets": [ 0 ] },
 		      { "sClass": "highlight", "aTargets": [ 4 ] }
  		    ]
 		  } );
        
        
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
		
		FormView();
 

		EstadoProceso();
		
    	FormArbolCuentas(); 
    	
   
    	goToURLProceso(2,1);
 
 
});  
//-------------
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
	
	for (i=1;i<=id;i++) { 
	
		cobjeto = '#col_' + i;
		
		$(cobjeto).val('');
	
	} 

	$("#novedad_proceso").val('');
	
	$("#sesion_siguiente").val('');
	
	$("#idprov").val('');
	
	$("#razon").val('');
	
	
	var  idproceso =  $("#codigoproceso").val();
	  
	
	 $("#proceso_codigo").val(idproceso);
    
	 
	 valida_botones(  );
	 
	 
 }

//-----------------------------------------
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
/*
00. BUSCA PROCESOS EN PANTALLA
*/
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
								s[i][7] ,
								s[i][1],
								s[i][2],
								s[i][6],
			                    s[i][3],
		                        s[i][4], 
								s[i][8] ,
 			                     	'<button class="btn btn-xs btn-warning" title="Ver Tramite" onClick="goTocaso('+"'editar'"+','+ s[i][0]+','+s[i][5]+','+s[i][9] +')"><i class="glyphicon glyphicon-cog"></i></button> '   
 							]);										
						} // End For
			}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				
			});
 
 	 
    }
/*
00.01 llama a la pantalla
*/
function goTocaso(accion,id,proceso,tarea) {
	
   
	 Visor(accion, proceso,tarea,id ); // pone tarea en el formulario

	 Recorrido( id );
 	 
	 Ver_doc_prov(id);   
	
	 flujo(proceso); 		 // dibujo de flujo del proceso


	 $('#mytabs a[href="#tab2"]').tab('show');
	
 
	 
   }
//----------------
//-------------------------------------------------------------------------  
 function modulo()
 {
 	 var modulo1 =  'kcrm';
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
 /*
 00.02 Formulario para ingreso de datos
 */
 function  Visor( accion,idproceso, tarea  ,idcaso)
 {
 
	
	   

	   var mensaje = '<img src="../../kimages/z_add.png" align="absmiddle"/><b> VERIFICAR LA INFORMACION</b>';
	 
  		var parametros = {
 		            'idproceso': idproceso,
					'tarea' : tarea,
					'idcaso' : idcaso,
					'accion' : accion
			};
  
		$.ajax({
					data:  parametros,
					url:   '../controller/Controller-caso_tarea_tramite',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
 							 $("#ViewFormularioTarea").html(data);   
 						} ,
				    complete: function ( ) {
 							$("#result").html(mensaje);
 	 			}	
			}); 
        
  }
 /*
 */
//---------  
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
								'accion': 'finaliza'
				  };
			   
				 $.ajax({
							   data:  parametros,
							   url:   '../model/Model-cli_incidencias.php',
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
		}); 
}
//-------------------------------------------------

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
  

 //	document.getElementById("DocVisor").src= url;
 	
   	
 }
 //--------------------------
function Ver_doc_prov(idcaso) {

	 
     var parametros = {
 					'idcaso' : idcaso  ,
 					'accion' : 'visor'
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-caso__doc_tra.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);   
 
  					} ,
					complete:  function ( ) {
					 

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
 	 
 	  if ( idcaso) {
 		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

 		}
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
/*
00.02 flujo del proceso
*/
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
							 $("#DibujoFlujo").html(data);   
						     
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
 //----------- 
 function  reporte_doc_visor( idproceso, tipo , idproceso_docu ,id_docmodelo  )
 {
	
	    var   	idcaso = $("#idcaso").val();
	    var 	posicion_x; 
	    var 	posicion_y; 
	    var   	enlace = '../reportes/documento_matriz_dato.php?caso='+idcaso+'&process='+idproceso+'&doc='+id_docmodelo;
	    var 	ancho = 1000;
	    var 	alto = 520;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
        
  }
 //-----------------

 function  formato_doc_visor( idproceso, tipo , idproceso_docu ,idtarea  )
 {
	
	    var   	idcaso = $("#idcaso").val();
	    var 	posicion_x; 
	    var 	posicion_y; 
	    var   	enlace = '../reportes/documento_matriz.php?caso='+idcaso+'&process='+idproceso+'&doc='+idproceso_docu;
	    var 	ancho = 1000;
	    var 	alto = 520;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
        
  }
 //--------------------
 function EnviarProceso() {
	 
		 var mensaje = 'Desea generar el proceso para su gestion?';			 
			
	     var id 		     = $("#idcaso").val( );
		
	     if ( id > 0 ) {
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
				  
			  if (e) {
				 
				   
	 				
					
				    var idproceso 	 = $("#codigoproceso").val();
 				    
				    var tarea_actual = $("#tarea_actual").val();
					 
				    var novedad 	 = $("#novedad").val();
				    
				    var sesion_siguiente 	 = $("#sesion_siguiente").val();
					
					var siguiente 	= $("#siguiente").val();
				    
				
					if (sesion_siguiente){		
 									 var parametros = {
								                     'id' : id ,
								                     'idproceso' : idproceso,
								                     'accion': 'aprobado',
								                     'tarea_actual' : tarea_actual,
								                     'novedad' : novedad,
													 'sesion_siguiente' : sesion_siguiente,
													 'siguiente' : siguiente
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

															 EstadoProceso();

															 goToURLProceso(2,1);
															 
								  					} 
											}); 
						} else{		
							alert('Verifique el usuario que requiere enviar el tramite...');
						}
 				  }
			 }); 
	     }	 
 }
 