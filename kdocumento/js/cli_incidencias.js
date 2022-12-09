var oTable; 
var codigo_proceso = 21;
/*
Inicio ejecución 
*/
$(document).ready(function(){
        
		oTable 	= $('#json_variable').dataTable( {      
			searching: true,
			paging: true, 
			info: true,         
			lengthChange:true ,
			lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'Todos']],
			aoColumnDefs: [
				{ "sClass": "highlight", "aTargets": [ 0 ] },
				{ "sClass": "ye", "aTargets": [ 2 ] },
				{ "sClass": "de", "aTargets": [ 4 ] } 
				] 
		} );
	
		$("#MHeader").load('../view/View-HeaderModelDoc.php');
		
		$("#FormPie").load('../view/View-pie.php');
 
		// OPCIONES DEL MODULO
		
 		modulo();


		// PONE ESTADO DEL TRAMITE
		FormArbolCuentas();

		// FLUJO DEL PROCESO DE DOCUMENTOS
		flujo();

		// FORMULARIO PERSONALIZADO DE LOS TRAMITES
		Visor( codigo_proceso ,'1');
		
		$('#loadavanzada').on('click',function(){
			BusquedaGrillaTramite()
		});

		fecha_hoy();

	
});  

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
  
    var inicio = yyyy + '-' + mm + '-01' ;
     
    var today = yyyy + '-' + mm + '-' + dd;
    
    document.getElementById('f1_v').value = inicio ;
    
    document.getElementById('f2_v').value = today ;
    
 
            
} 

/*
MODULO DE OPCIONES 
*/ 
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
 /*
 BUSQUEDA DE TRAMITES
 */
 function BusquedaGrillaTramite(){        	 
   
  var idproceso = 21;
	
	Visor( idproceso ,'2');
 
	$("#vestado").val('3');
	$("#codigoproceso").val(idproceso);
	$("#vidproceso").val(idproceso);

 
   

    var iddocaso        =    $("#iddocaso").val();
    var idasunto 		=    $('#idasunto').val()
    var aquien          =    $('#aquien').val()
	
	var parametros = {
				 'iddocaso' : iddocaso  ,
				 'idasunto' : idasunto ,
				 'aquien' : aquien
	   };
	   
 
  
	 jQuery.ajax({
		 data:  parametros, 
		 url: '../grilla/grilla_cli_incidencias_avanza.php',
		 dataType: 'json',
		 success: function(s){
		  //console.log(s); 
		  oTable.fnClearTable();
		 if(s ){ 
			 for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
					s[i][0],
					s[i][1],
					s[i][2],
					s[i][3],
					s[i][4],
					s[i][5],
					'<button class="btn btn-xs" onClick="goTocaso_enviado('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-asterisk"></i></button>' 
						 ]);										
					 } // End For
		 }						
			 },
			 error: function(e){
				console.log(e.responseText);	
			 }
  
 
		 });
  
   $("#vestado").val('3');
	  
 } 
 /*
 ESTADOS DEL DOCUMENTO
 */
 function FormArbolCuentas()
 {
 
	$("#ViewFormArbol").load('../controller/Controller-proceso_caso01.php' );
	
  
 }
 

/*
Busqueda de tramites
*/
function BusquedaGrilla(idproceso, estado){        	 
   
 
	$("#vestado").val(estado);
	$("#codigoproceso").val(idproceso);
	$("#vidproceso").val(idproceso);

	var boton_1 = '<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
	var boton_2 = '<i class="glyphicon glyphicon-warning-sign"></i></button>&nbsp;' ;

	var boton_3 = '<i class="glyphicon glyphicon-list-alt"></i></button>' ;
	
    var boton1 = '<button class="btn btn-xs btn-warning" title="Visualizar Tramite" onClick="goTocaso(' +"'editar'"+',';
	var	boton2 = '<button class="btn btn-xs btn-danger" title="Anular Tramite" onClick="goTocaso(' +"'del'"+',';
  
	var	boton3 = '<button class="btn btn-xs btn-info" title="Reasignar Tramite" onClick="goToasigna(' +"'asigna'"+',';

	var parametros = {
				 'idproceso' : idproceso  ,
				 'estado' : estado 
	   };
  
	 jQuery.ajax({
		 data:  parametros, 
		 url: '../grilla/grilla_cli_incidencias.php',
		 dataType: 'json',
		 success: function(s){
		  //console.log(s); 
		  oTable.fnClearTable();
		 if(s ){ 
			 for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
							 s[i][0],
							 s[i][1],
							 s[i][2],
						     s[i][3],
						     s[i][4],
							 s[i][5],
							 boton1 + s[i][0] +')">' + boton_1 +  boton2 + s[i][0] +')">' + boton_2 +boton3 + s[i][0] +')">' +boton_3
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
Busqueda de tramites
*/
function BusquedaGrillaSeg(idproceso, estado){        	 
   

 
 
	$("#vestado").val(estado);
	$("#codigoproceso").val(idproceso);
	$("#vidproceso").val(idproceso);

 
	var parametros = {
				 'idproceso' : idproceso  ,
				 'estado' : estado 
	   };
  
	 jQuery.ajax({
		 data:  parametros, 
		 url: '../grilla/grilla_cli_incidencias.php',
		 dataType: 'json',
		 success: function(s){
		  //console.log(s); 
		  oTable.fnClearTable();
		 if(s ){ 
			 for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
							 s[i][0],
							 s[i][1],
							 s[i][2],
						     s[i][3],
						     s[i][4],
							 s[i][5],
						 	'<button class="btn btn-xs btn-warning" title="Ver Tramite" onClick="goTocaso_seg('+"'editar'"+','+ s[i][0]+','+s[i][6]+','+ s[i][7]+','+ s[i][8]+')"><i class="glyphicon glyphicon-cog"></i></button> '  
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
Busqueda de tramites
*/
function BusquedaGrillaSesion(idproceso, estado){        	 
   

	Visor( idproceso ,'2');
 
	$("#vestado").val(estado);
	$("#codigoproceso").val(idproceso);
	$("#vidproceso").val(idproceso);

	var boton_1 = '<i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;';
	var boton_2 = '<i class="glyphicon glyphicon-warning-sign"></i></button>' ;
	
    var boton1 = '<button class="btn btn-xs btn-warning" title="Visualizar Tramite" onClick="goTocaso_enviado(' +"'editar'"+',';
	var boton2 = '<button class="btn btn-xs btn-danger" title="Anular Tramite" onClick="goTocaso(' +"'del'"+',';
 
  		 
	var parametros = {
				 'idproceso' : idproceso  ,
				 'estado' : estado 
	   };
  
	 jQuery.ajax({
		 data:  parametros, 
		 url: '../grilla/grilla_cli_incidencias.php',
		 dataType: 'json',
		 success: function(s){
		  //console.log(s); 
		  oTable.fnClearTable();
		 if(s ){ 
			 for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
							 s[i][0],
							 s[i][1],
							 s[i][2],
						     s[i][3],
						     s[i][4],
							 s[i][5],
							 boton1 + s[i][0] +')">' + boton_1 +  boton2 + s[i][0] +')">' + boton_2
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
 */

function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
		 
			Visor( codigo_proceso ,'1');
  
		    $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b>   AGREGAR NUEVO REGISTRO... GENERE EL DOCUMENTO Y ENVIE LA INFORMACION A SU REMITENTE</b>');
 			
  			
			$('#mytabs a[href="#tab2"]').tab('show');
	 
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
   Formulario para ingreso de datos 
 */
   function  Visor( idproceso ,estado)
 {
  
 

 	var parametros = {
					'idproceso': idproceso,
					'estado' : estado
			};

	var mensaje =  '<div class="alert alert-warning"> <img src="../../kimages/m_verde.png" align="absmiddle"><b>   AGREGAR NUEVO REGISTRO... GENERE EL DOCUMENTO Y ENVIE LA INFORMACION A SU REMITENTE</b></div>';
	var estado  =  "add";
	var url     =  '../controller/Controller-caso_tarea.php' ;
 
	if (estado == '2') {
		  mensaje =  '<div class="alert alert-warning"> <img src="../../kimages/m_verde.png" align="absmiddle"><b>   VERIFICAR INFORMACION... GENERE EL DOCUMENTO Y ENVIE LA INFORMACION A SU REMITENTE</b></div>';
		  estado  =  "editar";
 	}	
 
 
		$.ajax({
					data:  parametros,
					url:  url ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormularioTarea").html('Procesando');
						},
					success:  function (data) {
							   $("#ViewFormularioTarea").html(data);   
 						} ,
					complete: function ( ) {
 					 
						$("#result").html(mensaje);
						$("#action").val(estado);

						}	 
			}); 
		
		 
  } 
  /*
  busca personal de la institucion
  */
  function  BuscaPersonal(unidad)
  {
   
   
	  var parametros = {
		  'unidad': unidad
	  };
	  
	  $.ajax({
		  data:  parametros,
		  url: "../model/ajax_usuario_unidad.php",
		  type: "GET",
		success: function(response)
		{
			$('#sesion_siguiente').html(response);
		}
	  });
 	   
   }
  /*
  agrega sesion de usuarios para informes
  */
  function  para_sesion01()
  {
   
	   var idcaso 			 = $("#idcaso").val();
	   var sesion_siguiente  = $("#sesion_siguiente").val(); 
	   var unidad_destino    = $("#unidad_destino").val();
	  
		 var parametros = {
					 'idcaso': idcaso,
					 'accion' : 'add',
					 'sesion_siguiente' :sesion_siguiente,
					 'tipo' : 'S',
					 'unidad_destino':unidad_destino
			 };
   
 

		 $.ajax({
					 data:  parametros,
					 url:   '../model/Model-caso__sesion.php',
					 type:  'GET' ,
					 cache: false,
					 beforeSend: function () { 
								 $("#ViewFormfilepara").html('Procesando');
						 },
					 success:  function (data) {
								$("#ViewFormfilepara").html(data);   
 						 } 
			 }); 
			 $("#sesion_siguiente").val('-'); 
			 $("#unidad_destino").val('0');

 	  
   } 
/*
ver documentos visor 
*/
function Ver_doc_pendiente(idcaso) {

	 
	var parametros = {
				   'accion' : 'visor',
				   'idcaso' : idcaso  
	  };

	$.ajax({
				   data:  parametros,
				   url:   '../model/Model-caso__doc_tra04.php',
				   type:  'GET' ,
				   success:  function (data) {
							$("#ViewFormfilePendiente").html(data);   
					 } 

		  }); 
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
  /*
ver documentos visor 
*/
function Ver_doc_prov_m(idcaso) {

	 
	var parametros = {
				   'accion' : 'visor',
				   'idcaso' : idcaso  
	  };

	$.ajax({
				   data:  parametros,
				   url:   '../model/Model-caso__doc_tra.php',
				   type:  'GET' ,
				   success:  function (data) {
							$("#visor_doc").html(data);   
					 } 

		  }); 

	 
}
/*
*/
function Ver_doc_prov_a(idcaso) {

 
	var parametros = {
					'accion' : 'visor',
					'idcaso' : idcaso  
	   };

	 $.ajax({
					data:  parametros,
					url:   '../model/Model-caso__doc_tra01.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#visor_doc").html(data);   

					 } 

		   }); 
 
	 
}
   /*
   */
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
					  url:   '../model/Model-caso__sesion.php',
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
   */
	function  Visor_user_seg(idcaso)
	{
	 
 
		  
		   var parametros = {
					   'idcaso': idcaso,
					   'accion' : 'seg_visor',
					   'sesion_siguiente' :'-',
					   'tipo' : 'S'
					   
			   };
	 
	
		   $.ajax({
					   data:  parametros,
					   url:   '../model/Model-caso__sesion.php',
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
  ACTUALIZA LA INFORMACION DE LA PANTALLA
  */
  function accion(id,modo,bandera)
  {
	
			  $("#action").val(modo);
			  
			  $("#idcaso").val(id);          

			  if ( bandera == 1)   {
				Recorrido(21); 
			 	$('#mytabs a[href="#tab2"]').tab('show');
		     }
 		 
		 
 
} 
/*
Elimina funcionario para 
*/
 function  goToURLDocUserdel( id, idcaso)
			  {
			   
			  		   var parametros = {
								 'idcaso': idcaso,
								 'accion' : 'del',
								 'id' :id,
								 'tipo' : '-'
						 };
			 
						var bandera = 0; 
				 	    var estado = $("#estado").val();		


						 if ( estado == '1') {
							bandera= 1;
						 }	 
						 if ( estado == '3') {
							bandera= 1;
						 }
					 
			 
							 if ( bandera == '1') {
							 
								 $.ajax({
											 data:  parametros,
											 url:   '../model/Model-caso__sesion.php',
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

/*
*/

function ReasignarProceso() {

	var estado = $("#estado").val();	
	var idcaso = $("#idcaso").val();	
	 
	var visor = 'visor';

	if ( estado == '1') {

		

		$('#myModalCambio').modal('show');

				var parametros = {
 								'idcaso'   : idcaso  ,
								'accion' : visor
				   };
			
				  $.ajax({
								 data:  parametros,
								 url:   '../controller/Controller-usuario_doc.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#visor_usuario").html(data);  
			  
								 } 
			
						}); 
						
					}	
			  }	
/*goToasigna
*/

function goToasigna(visor,idcaso) {

	var estado = $("#estado").val();	
	 
	if ( estado == '1') {

		

		$('#myModalCambio').modal('show');

				var parametros = {
 								'idcaso'   : idcaso  ,
								'accion' : visor
				   };
			
				  $.ajax({
								 data:  parametros,
								 url:   '../controller/Controller-usuario_doc.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#visor_usuario").html(data);  // $("#cuenta").html(response);
			  
								 } 
			
						}); 
						
					}	
			  }		

/*
*/	
function CambiarTramite() {

	var estado = $("#estado").val();	
	 
	if ( estado == '1') {
 	
		var sesion_dato    = $("#sesion_dato").val();	
		var codigo_tramite = $("#codigo_tramite").val();	
	

				var parametros = {
 								'idcaso'   : codigo_tramite  ,
								'sesion_dato' : sesion_dato
				   };
			
				   alertify.confirm("<p>Enviar informacion a verificación</p>", function (e) {
					if (e) {
					   
									$.ajax({
										data:  parametros,
										url:   '../model/model-usuario_doc.php',
										type:  'GET' ,
										success:  function (data) {
											    alert(data);
												$('#myModalCambio').modal('hide');
												FormArbolCuentas();
												BusquedaGrilla(21, 1);
												$('#mytabs a[href="#tab1"]').tab('show');
										} 
 										}); 
				   
						}
				   }); 
 		
		 }	
   }			  
/*
actualiza eiinar para elaborar documento
*/	
			   
  function goToURLDocdel(idcodigo,idcaso) {

	var estado  = $("#estado").val();	

	var bandera = 0;

	if ( estado == '1'){
		bandera = 1;
	}

	if ( estado == '2'){
		bandera = 1;
	}

	if ( estado == '3'){
		bandera = 1;
	}
	 
 
	if ( bandera == 1 ) {

				var parametros = {
								 'idcodigo' : idcodigo  ,
								'idcaso'   : idcaso  ,
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
  }			
/*
Pone documentos para visualizar
*/
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
actualiza editor para elaborar documento
*/			   		  
  function visor_editor( id ) {
  

  var url =  'cli_editor_caso_add.php?id='+ id;
			
 			  $('#ieditor').attr('src', url);
					 
 
			
  }			 
  /*
  */  

  function goToURLDocEditar( id ,idcaso) {
  

	var url =  'cli_editor_caso_seg.php?id='+ idcaso +'&accion=edit&iddoc='+id;
	
			  
	$('#ieditor').attr('src', url);
    
	alert('Verifique el documento para su revision envio de informacion');
	
	$('#ieditor').attr('src', url);				
	
     document.getElementById('ieditor').src = url;
			  
	$('#tab_dato a[href="#f3"]').tab('show');


	}		

 /*
   
  pone informacion de los tramites
 */
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
						 $("#ViewRecorrido").html(data);   
					     
					} 
		}); 

 	 
	} 

	 /*
   
  pone informacion de los tramites
 */
function CargaDatos(idcaso) {
	
	
	var parametros = {
            'id' : idcaso 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/Model-proceso_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#visor_doc").html('Procesando');
					},
				success:  function (data) {
						 $("#visor_doc").html(data);   
					     
					} 
		}); 

 	 
	} 
/*
flujo del proceso de documento
*/
function  flujo(  )
{
	
	 var idproceso = 	$("#codigoproceso").val();
	   
 	   
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
 
/*
Visualiza Documento generado
*/ 
function Ver_doc_user_lista() {

	var idcaso = $("#idcaso").val();

	var parametros = {
					'accion' : 'visor',
					'idcaso' : idcaso  
	   };

	 $.ajax({
					data:  parametros,
					url:   '../model/Model-caso__doc_tra01.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#ViewFormfileDoc").html(data);   

					 } 

		   }); 
 
	 
}
/*
abre archivo de documentos
*/
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
eliminar docmento
*/
function goToURLDocdelUser(idcodigo,idcaso) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'idcaso'   : idcaso  ,
					'accion' : 'del'
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-caso__doc_tra01.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfileDoc").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
  /*
  */
  
  function goTocaso_enviado(accion,id) {
 
 

	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
 

			 $("#idcaso").val(id);

			  $.ajax({
							data:  parametros,
							url:   '../model/Model-cli_incidencias.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
									$("#result").html('Procesando');
		 					},
							success:  function (data) {
									 
								     detalle = '<b>' +  data + '</b>'  ;

									 $("#result").html(detalle);   

									 Recorrido(id) ;

									 Ver_doc_user(id) ;

									 Ver_doc_prov(id)

									 Ver_doc_user_lista();

									 Visor_user(id) ;
 							 
		 					} 
					}); 
 	
					$('#mytabs a[href="#tab2"]').tab('show');

   }

   //-------------------
 function  cc_sesion_reasigna(sesion_siguiente)
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
  
/*
*/
   function goTocaso_seg(accion,idcaso, doc_user, idproceso, tarea ) {
 


	var mensaje =  ' <img src="../../kimages/m_verde.png" align="absmiddle"><b>  VERIFICAR INFORMACION</b>';
 
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
				} ,
				complete: function ( ) {

					$("#result").html(mensaje);

					Ver_doc_prov(idcaso);   

					Ver_doc_user(idcaso);
			
					Recorrido( idcaso );
					 
					Visor_user_seg(idcaso);

					 
			 	}	
		}); 

		
 
		$('#mytabs a[href="#tab2"]').tab('show');

		$("#result").html('<img src="../../kimages/kedit.png" align="absmiddle"/><b> TRAMITE SELECCIONADO PARA RESPONDER ' + idcaso + '</b>');
 
   }
/*
copia sesion 
*/
 function  cc_sesion01(sesion_siguiente)
 {
  
	var idcaso 	  =  $("#idcaso").val();
	var vestado   =  $("#estado").val();

	if (sesion_siguiente)  {
	}	else{
		var sesion_siguiente   = $("#sesion_siguiente").val();
	}	
       

 	   var parametros = {
					'idcaso': idcaso,
					'accion' : 'addCc',
					'sesion_siguiente' :sesion_siguiente,
					'tipo' : 'N' ,
					'vestado' : vestado
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

			$("#sesion_siguiente").val('-'); 
			$("#unidad_destino").val('0');

		
	 
  }

/*
marcar leido
*/
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

  /*
  llama documento para visualizar informacion...
  */
  function goTocaso(accion,id) {
 
 

	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	if ( accion== 'del') {
		
		  alertify.confirm("Desea Anular el tramite emitido ?", function (e) {
			  if (e) {
 				  
							  $.ajax({
									data:  parametros,
									url:   '../model/Model-cli_incidencias.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
 											 alert(data);
 											 goToURL(vidproceso,texto) ;
											 
 				 					} 
							}); 
 				  }
			 });
 	}
	else 	{

			 visor_editor( id );

 			 $("#idcaso").val(id);

			  $.ajax({
							data:  parametros,
							url:   '../model/Model-cli_incidencias.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
									$("#result").html('Procesando');
		 					},
							success:  function (data) {
								     detalle = '<b>' +  data + '</b>'  ;
									 $("#result").html(detalle);   
									 valida_botones();
									 Ver_doc_user_lista();
									 Visor_user(id) ;
  									 Recorrido(id) ;
  							} ,
							complete: function ( ) {
 									Ver_doc_prov(id) ;
									Ver_doc_user(id) ;
									Visor_user(id) ;
									visor_editor( id );
 								}	
					}); 
	 }
 	
 

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
					url:   '../model/Model-caso__doc_tra01.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#ViewFormfileDoc").html(data);   

					 } 

		   }); 
 
	 
}
//--------------
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

 function fileExists(url) {
    if(url){
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status==200;
    } else {
        return false;
    }
}
//------------
function  formato_doc_visor(  enlace  )
 {
	
 
	    var 	posicion_x; 
	    var 	posicion_y; 
 	    var 	ancho = 1000;
	    var 	alto = 520;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
     if (fileExists(enlace)) {
 
			window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
    }

 
        
  }
/*
*/
function  SiguienteDato( paso )
 {

	var id 		          = $("#idcaso").val();
	var sesion_siguiente  = $("#sesion_siguiente").val();  
	var caso			  = $("#caso").val();  

	var longitud = caso.length;
	
	
	if ( longitud  > 5 )  {
		
				if ( sesion_siguiente ) {
				
					$('#mytabsDato a[href="#f2"]').tab('show');

					visor_editor( id );

				}else{

					alert('Ingrese la informacion de los usuarios');

				}
	}else {

		alert('Ingrese el asunto del tramite...');

	}			


  }
   /*
   actualiza la informacion de los clientes
   */
   function ActualizaCliente( ) {


	var idprov     = $('#idprov').val();
	var razon      = $('#razon').val();
	var correo     = $('#correo').val();
	var telefono   = $('#telefono').val();
 
 
  var parametros = {
					'idprov' : idprov ,
                    'razon' : razon, 
                    'correo' : correo ,
                    'telefono' : telefono
	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-clientes_actualiza.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							 $("#result").html(data);   
						     
					} 
			}); 
 
 
 }
 /*
 Limpia informadion de los clente
 */
 function LimpiarCliente( ) {


	$('#idprov').val('');
	$('#razon').val('');
	$('#correo').val('');
	  
	$('#telefono').val('');  
}

/*
enviar proceso a unidades
*/
function EnviarProceso() {
	 
	var mensaje       = 'Desea generar el proceso para su gestion?';			
	 
	var estado 		  = $("#estado").val( );
	var id 		      = $("#idcaso").val();
	var idproceso     = $("#codigoproceso").val();


	if ( estado == '1')  {

		alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

		 if (e) {
			
			

			  

			   var parametros = {
								'id' : id ,
								'idproceso' : idproceso,
								'accion': 'aprobado'
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
										
										FormArbolCuentas();
										BusquedaGrilla(21, estado)
										$('#mytabs a[href="#tab1"]').tab('show');
										Recorrido(id);

								 } 
					   }); 

					  
	
			 }
		}); 
    }

}
/*
*/
function EnviarProcesoSeg() {
	 
	var mensaje = 'Desea generar el proceso para su gestion?';			 
	   
	var id 		     = $("#idcaso").val( );
   
	if ( id > 0 ) {
	   
		 alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			 
		 if (e) {
			
			   var idproceso 	 = $("#codigoproceso").val();
				var tarea_actual = $("#tarea_actual").val();
			   var novedad 	     = $("#novedad").val();
			   var sesion_siguiente 	 = $("#sesion_siguiente").val();
			   var siguiente 			 = $("#doc_user").val();
			   var sesion_reasigna 	     = $("#sesion_reasigna").val();
			   
		   
			   if (sesion_siguiente){		

								 var parametros = {
												'id' : id ,
												'idproceso' : idproceso,
												'accion': 'aprobado',
												'tarea_actual' : tarea_actual,
												'novedad'      : novedad,
												'sesion_siguiente' : sesion_siguiente,
												'siguiente'        : siguiente,
												'sesion_reasigna'  : sesion_reasigna
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
														
														FormArbolCuentas();
														BusquedaGrilla(21, 3)
														$('#mytabs a[href="#tab1"]').tab('show');
														 Recorrido(id);
												 } 
									   }); 
				   } else{		
					   alert('Verifique el usuario que requiere enviar el tramite...');
				   }
			  }
		}); 
	}	 
}
/*

*/
function FinProceso() {

    
	var id = $("#idcaso").val();      

   var novedad 	 = $("#novedad").val();

	var parametros = {
			'accion' : 'terminar' ,
			'novedad': novedad,
            'id' : id 
	};
  		
		  alertify.confirm("Desea Finalizar el tramite ?", function (e) {
			  if (e) {
 				  
							  $.ajax({
									data:  parametros,
									url:   '../model/Model-cli_incidencias_tarea.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
 										$("#result").html(data);	
										 alert('Proceso Finalizado con exito...');
									     Recorrido(id);
  				 					} 
							}); 
 				  }
			 });
 	}
/*
anular proceso
*/
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
/*
*/
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
										 FormArbolCuentas();
										 BusquedaGrilla(21, 3)
										 $('#mytabs a[href="#tab1"]').tab('show');
										  Recorrido(id);
  				 					} 
							}); 
 				  }
			 });
 	}	 
/*
*/
function  formato_doc_firmado( idproceso_docu  )
{
   
	   var   	idcaso = $("#idcaso").val();

	   var   	enlace = '../reportes/documento_firma.php?caso='+idcaso+'&doc='+idproceso_docu;

 
	   window.location.href = enlace;
   
	   
 }	 
 /*
 */

 function MisMemos()
{
	
 	

	   var parametros = {
						'tipodoc' : 'Memo' ,
						'tipo' : 1
		  };
	   
		 $.ajax({
					   data:  parametros,
					   url:   '../model/ajax_lista_doc_tipo_user.php',
					   type:  'GET' ,
					   cache: false,
					   beforeSend: function () { 
								$("#visor_doc").html('Procesando');
						 },
					   success:  function (data) {
								$("#visor_doc").html(data);   
								
						 } 
			   }); 

} 
/* datos leidos*/

function MisMemosL(tipo)
{
	
 		var f1 = $("#f1_v").val();   
 		var f2 = $("#f2_v").val();   
 			

	   var parametros = {
						'tipodoc' : 'Memo'  ,
						'tipo' : tipo,
						'f1':f1,
						'f2':f2
						
		  };
	   
		 $.ajax({
					   data:  parametros,
					   url:   '../model/ajax_lista_doc_tipo_user.php',
					   type:  'GET' ,
					   cache: false,
					   beforeSend: function () { 
								$("#visor_doc").html('Procesando');
						 },
					   success:  function (data) {
								$("#visor_doc").html(data);   
								
						 } 
			   }); 

} 