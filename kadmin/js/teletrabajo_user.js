var oTable;


 
//-------------------------------------------------------------------------


$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   

    	
	  
		$("#MHeader").load('../view/View-HeaderInicioAgenda.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
	//	modulo();
 	
    	inicial_actividad();


         FormView();
    
		EstadoProceso();
 
 
});  
 
 
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#idcaso").val(id);          
 
			  $('#mytabs a[href="#tab2"]').tab('show');

}
//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
		 
		 
			$("#action").val("add");
			
		    $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b> ]  AGREGAR NUEVO REGISTRO</b>');
			 
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
	
 
	
 	 
	$("#actividades").val('');
 	
	 
   
 
 
	 
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
 

//-------------------------------------------------------------------------

function FormArbolCuentas()
{

   // $("#ViewFormArbol").load('../controller/Controller-proceso_caso01.php' );
   
   $("#ViewFormProceso").load('../controller/Controller-proceso_caso02.php' );

}

function fecha_hoy(dias)
{
   
    var today = new Date();
    var dd = today.getDate() + dias;
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
 
/*
 ir a la opcion de editar
 pone informacion de los tramites
*/
function goToURL(nombre,cargo,unidad,idprov,id_teleasigna) {
	

	$("#id_teleasigna").val(id_teleasigna);
	$("#idprov").val(idprov);
	$("#razon").val(nombre);
	$("#cargo").val(cargo);
	$("#unidad").val(unidad);


	$("#fecha_inicio").val(fecha_hoy(0));

 
	$("#fecha_fin").val(fecha_hoy(5));

	$('#mytabs a[href="#tab2"]').tab('show');


			var parametros = {
				'accion' : 'visor',
				'idprov' : idprov,
				'id_teleasigna' : id_teleasigna
		};

			$.ajax({
				data:  parametros,
				url:   '../model/ajax_visor_tele_actividad.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
							$("#VisorActividades").html('Procesando');
					},
				success:  function (data) {
					
							$("#VisorActividades").html(data); 
 					 
							
					} 
			}); 
 
 
 }

//----------------------------------------------------
function VerPersonal( id) {
 
    
	
	$("#idprov_jefe").val(id);

	var parametros = {
			'accion' : 'visor' ,
            'id' : id 
	};
 
							  $.ajax({
									data:  parametros,
									url:   '../model/ajax_tele_asigna_jefe.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
										$("#visor_general").html(data);
  				 					} 
							}); 
  
 
   }
//----------------
function BusquedaGrilla(idproceso, estado){        	 
   
 
 var semana =   $('#semana').val();

 alert(semana);
 
   var parametros = {
				'idproceso' : idproceso  ,
				'estado' : estado 
      };
	  
/*
 
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
 */
 

	
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
 function visor_actividades()
 {
	 
		 

	
	var id_teleasigna = $("#id_teleasigna").val();
	var idprov        = $("#idprov").val();
 
 

			var parametros = {
				'accion' : 'visor',
				'idprov' : idprov,
				'id_teleasigna' : id_teleasigna
		};

			$.ajax({
				data:  parametros,
				url:   '../model/ajax_visor_tele_actividad.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
							$("#VisorActividades").html('Procesando');
					},
				success:  function (data) {
					
							$("#VisorActividades").html(data); 
 					 
							
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
						url:   '../controller/Controller-teletrabajo_user_estado.php',
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
     
     

         $("#ViewFormularioTarea").load('../controller/Controller-teletrabajo_user.php');
    	 
 
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
						     
						} 
			}); 
		
		 
  }
 //--------------------------
function inicial_actividad() {

	 
     
 

	var parametros = {
			'accion' : 'gerencial'  
	};
 
							  $.ajax({
									data:  parametros,
									url:   '../model/ajax_tele_asigna_user.php',
									type:  'GET' ,
									cache: false,
 									success:  function (data) {
										$("#visor_general").html(data);
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
			 

		 if ( estado == '4')  {

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
											 $("#result").html(data);  // $("#cuenta").html(response);
										     
				  					} 
							}); 
				  
						 
		 
				  }
			 }); 
	 }
	 //-------------------------------------------------
	 
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
											 $("#result").html(data);  // $("#cuenta").html(response);
										     
				  					} 
							}); 
				  
						  EstadoProceso() ;
						  Recorrido(id);
		 
				  }
			 }); 
	 }
	 //-------------------------------------------------
	 
 }
 