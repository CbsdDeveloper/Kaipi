var oTable;

$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   

    	
	  
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
    	FormArbolCuentas(); 
    
		EstadoProceso();
 
 
});  
//----------------
function LimpiarCliente( ) {


	  $('#idprov').val('');
	  $('#razon').val('');
	  $('#correo').val('');
		
	  $('#telefono').val('');  
 }
//------------
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
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#idcaso").val(id);          
 
			  $('#mytabs a[href="#tab2"]').tab('show');

}
//-------------
function secuencia_dato(id)
{
  
 			
			$("#secuencia").val(id);          
 
 
}
//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
		 
		   var texto =  $('#vidproceso_nombre').val()
		   
		   var res = texto.toUpperCase();
	  	      
			$("#action").val("add");
			
		    $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b> ' + res + ' ]  AGREGAR NUEVO REGISTRO</b>');
			 
			LimpiarPantalla();
 
			$("#estado").val("1");

			$("#vestado").val("1");
 			
		    $('#mytabs a[href="#tab2"]').tab('show');

			valida_botones();
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
	
 
	
	var  idproceso =  $("#codigoproceso").val();
	 
	$("#novedad_proceso").val('');

	$("#secuencia").val('');
 	
	var cadena = $("#idprov").val();
	
	variable = cadena.length;
 	
	if ( variable < 6 ){
		
		$("#idprov").val('');
		
		$("#razon").val('');
	}
	
	
    $("#proceso_codigo").val(idproceso);
   
 
 
	 
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
//-----	
function openNav_proceso() {
	  document.getElementById("mySidenav_proceso").style.width = "350px";
	  document.getElementById("main_proceso").style.marginLeft = "350px";
	 
	}

	function closeNav_proceso() {
	  document.getElementById("mySidenav_proceso").style.width = "0";
	  document.getElementById("main_proceso").style.marginLeft= "0";
	   
	}

//-------------------------------------------------------------------------

function FormArbolCuentas()
{

   $("#ViewFormArbol").load('../controller/Controller-proceso_caso01.php' );
   
 
}
 
/*
 ir a la opcion de editar
 pone informacion de los tramites
*/
function goToURL(idproceso,proceso) {
	
     $("#codigoproceso").val(idproceso);
      
     $("#vidproceso").val(idproceso);
     
	 $("#proceso_codigo").val(idproceso);
 
     $("#nombre_proceso_se").html(proceso);
     
     $("#vidproceso_nombre").val(proceso);
     
     var estado     =    $("#vestado").val();
 
	 var parametros = {
			
                     'id' : idproceso
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../controller/Controller-caso_filtro.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewCasos").html('Procesando');
  					},
					success:  function (data) {
						
							 $("#ViewCasos").html(data); 
						     
							
							 
  					} ,
  					complete: function ( ) {

						     Visor();

							 flujo();
							 
							 BusquedaGrilla(idproceso,estado);

					 
			 	  }	
			}); 
	  
	  EstadoProceso();
 
	  closeNav_proceso();
 }

//----------------------------------------------------
function goTocaso(accion,id) {
 
    
    var estado      =    $("#vestado").val();
    var vidproceso  =    $("#vidproceso").val();
    var texto 		=    $('#vidproceso_nombre').val()
	var res 		= 	 texto.toUpperCase();
	var detalle ;

	var bandera     = 0;

	 
	var parametros = {
			'accion' : accion ,
            'id' : id 
	};
	
	if ( accion== 'del') {
		
		if ( estado == '4'){
			bandera = 1;
		}
		if ( estado == '5'){
			bandera = 1;
		}

		if ( bandera  == 0 ){
					alertify.confirm("Desea Anular el tramite emitido?", function (e) {
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

 	}
	else 	{
		
			  $.ajax({
							data:  parametros,
							url:   '../model/Model-cli_incidencias.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
									$("#result").html('Procesando');
		 					},
							success:  function (data) {
									 detalle = '<b>' +  res + '</b>'+ ' ' + data ;
								 
									 $("#result").html(detalle);   
									 Recorrido(id) ;
									 valida_botones();
									 Ver_doc_prov(id);
		 					} ,
							 complete:  function ( ) {
									Ver_doc_prov(id);
							} 
					}); 
	 }
	 


	$("#proceso_codigo").val(vidproceso);


   }
//----------------
function BusquedaGrilla(idproceso, estado){        	 
   

	if ( idproceso == '0'){     
		  idproceso = $("#codigoproceso").val();
		  $("#vestado").val(estado);
	 }	  
 
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
  	                     	'<button class="btn btn-xs btn-warning" title="Visualizar Tramite" onClick="goTocaso('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
							'<button class="btn btn-xs btn-danger" title="Anular Tramite" onClick="goTocaso('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-warning-sign"></i></button>' 
						]);										
					} // End For
		}						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			
   		

		});
 
 

	
}   
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

/*
01. Estado de los procesos
*/

function EstadoProceso()
 {
	 
 	var parametros = {
			
                     'accion' : '1' 
 	  };
 
		  $.ajax({
						url:   '../controller/Controller-proceso_estado00.php',
						type:  'GET' ,
					    data:  parametros,
						cache: false,
						success:  function (data) {
								 $("#ViewEstado").html(data);   
							     
	  					} 
				}); 
 
 } 
 
//-----------------
 function FormView()
 {
     
    	 
    	 $("#ViewFiltro").load('../controller/Controller-caso_filtro.php');
    	 
 
 }
 //-----------------
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

/*
02.  llamada a formulario de datos
*/
 function  Visor(  )
 {
  
 	   var idproceso = 	$("#codigoproceso").val();
		
	   var estado = 	$("#vestado").val();

 	   var parametros = {
					'idproceso': idproceso,
					'estado' : estado
			};
  
		$.ajax({
					data:  parametros,
					url:   '../controller/Controller-caso_tarea.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormularioTarea").html('Procesando');
						},
					success:  function (data) {
							   $("#ViewFormularioTarea").html(data);   
						     
						} ,
						complete: function ( ) {
 						 
							$("#action").val(estado);
	
							}	 
			}); 
		
		 
  }
 //--------------------------
function Ver_doc_prov(idcaso) {

	 
 
     var parametros = {
 					'idcaso' : idcaso  ,
					 'accion': 'visor'
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-caso__doc_tra.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);   
 
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

//------------------------
function goToURLDocdel(idcodigo,idcaso) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'idcaso'   : idcaso  
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
  //-----------------
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
 //-------------- pone documento para revision
 function  formato_doc(idproceso, tipo , codigo ,idtarea)
 {
	 
 
	    var   idcaso = $("#idcaso").val();
        var posicion_x; 
        var posicion_y; 
        var enlace; 
        ancho = 1124;
        alto = 580;
        posicion_x=(screen.width/2)-(ancho/2); 
        posicion_y=(screen.height/2)-(alto/2); 
      
  
        if (idcaso) {
        	
        	   enlace = '../view/cli_editor_caso?caso='+idcaso+'&task='+idtarea+'&process='+idproceso+'&tipo='+tipo+'&codigo='+codigo;
               
               window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
               
        }
 
  }
 //----------------- 
 function  enlance_externo( url_dato,accion )
 {
	 
 
	    var   idcaso = $("#idcaso").val();
        var posicion_x; 
        var posicion_y; 
        var enlace; 

        ancho = 1124;
        alto  = 495;
        posicion_x=(screen.width/2)-(ancho/2); 
        posicion_y=(screen.height/2)-(alto/2); 
      
  
        if (idcaso) {
        	
        	   enlace = '../enlaces/' + url_dato + '?task='+idcaso + '&accion='+accion;
               
               window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
               
        }
 
  }
 //---------------------------------------------------------
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
 //---------  
 function FinProceso() {
	 
		 var mensaje = 'Desea finalizar el proceso?';			 
			
	     var estado 		  = $("#estado").val( );
			 
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

											 EstadoProceso();
											 
											 BusquedaGrilla(idproceso, estado);

										     
				  					} 
							}); 
				  
						 
		 
				  }
			 }); 
	 
	 
 }
 //--------------------
 function EnviarProceso() {
	 
		 var mensaje 		  = 'Desea generar el proceso para su gestion?';			 
			
	     var estado 		  = $("#estado").val( );

	     if ( estado == '1')  {

	    	 alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
				 
 					var id 		  = $("#idcaso").val( );
				    var idproceso = $("#codigoproceso").val();

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
											 Recorrido(id);
											 EstadoProceso() ;
											 BusquedaGrilla(0,2);
										     
				  					} 
							}); 
				  
						 
					
		 
				  }
			 }); 
	 }
	 //-------------------------------------------------
	 
 }
 