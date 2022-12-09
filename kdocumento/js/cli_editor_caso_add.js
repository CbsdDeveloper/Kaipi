var validacion = 0;

$(document).ready(function(){
 
            var   idcaso    =  getParameterByName('id');
            var   idproceso =  getParameterByName('process');
            var   tipo 	  	=  getParameterByName('tipo');
            var   codigo 	  =  getParameterByName('codigo');

           $("#idproceso").val('21');
           
           $("#idcaso").val(idcaso);
            
              var parametros  =  {
                        'tipo': tipo,
                        'codigo' : codigo,
                        'idproceso': idproceso,
                        'idcaso': idcaso
                 };
           
              /*
              PONE FORMULARIO DE DATOS 
              */
           
                $.ajax({
                        data:  parametros,
                        url:   '../controller/Controller-formatoDoc_ver.php',
                        type:  'GET' ,
                        cache: false,
                        beforeSend: function () { 
                                    $("#docu").html('Procesando');
                            },
                        success:  function (data) {
                                 $("#docu").html(data);  

                            } 
                }); 
           
           
              
              $("#perfilUserWeb").load('../controller/Controller-firma_doc_ver.php');
           
             var parametros2  = {
                         'idcaso': idcaso
                 };
              

          
              /*
              PONE DESTINATARIOS PARA Y CC
              */
                $.ajax({
                        data:  parametros2,
                        url:   '../model/Model-caso__sesion_add.php',
                        type:  'GET' ,
                        cache: false,
                        beforeSend: function () { 
                                    $("#docu_par").html('Procesando');
                            },
                        success:  function (data) {
                                 $("#docu_par").html(data);   

                            } 
                }); 
               
      }); 
      
      /* 
        Documento para impresion
      */
      function  formato_doc_visor(   )
      {
       
           var    idproceso_docu = $("#idcasodoc").val();
           
           var   	idcaso = $("#idcaso").val();
           var 	posicion_x; 
           var 	posicion_y; 
           var   	enlace = '../reportes/documento_matriz.php?caso='+idcaso+'&doc='+idproceso_docu;
           var 	ancho = 1000;
           var 	alto = 520;
           
           posicion_x=(screen.width/2)-(ancho/2); 
           posicion_y=(screen.height/2)-(alto/2); 
           
           window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
             
       }         
        
//--- limpia variables --------------------------------
        
    function  LimpiarVariable(    ) {
        
        $("#tipo").val('-');
        
        $("#documento").val('');
        
        $("#docu_serie").html('');
        
             
        
    }	
    
//--- Crea documento  --------------------------------			
        
function  DocumentoUsuario( tipo  ) {

            var uso = $("#uso").val();

            var parametros = {
                       'tipo': tipo,
                       'uso' : uso
                };

            $.ajax({
                    type:  'GET' ,
                    data:  parametros,
                    url:   '../model/Valida_tipo_documento.php',
                    dataType: "json",
                    success:  function (response) {

                              $("#documento").val( response.a);  
                             $("#tipoDoc").val( tipo);  
                             $("#secuencia_dato").val( response.b);  

                    } 
            });

  }

/*
VER SECUENCIA DE ACUERDO AL TIPO DE DOCUMENTO
*/
function Ver_secuencia(tipo) {

   
  var idcaso = $("#idcaso").val();

   var parametros = {
                         'tipo'  : tipo ,
                          'uso'   : 'U',
                          'idcaso': idcaso
              };
 
  

                $.ajax({
                    type:  'GET' ,
                    data:  parametros,
                    url:   '../model/Valida_tipo_documento.php',
                    dataType: "json",
                    success:  function (response) {
                              $("#documento").val( response.a);  
                              $("#tipoDoc").val( tipo);  
                              $("#secuencia_dato").val( response.b);  
       
                     } 
            });
 
 
		  var parametros1 = {
		              'tipo'  : tipo ,
		               'uso'   : 'E'
		   };
		 
           $.ajax({
                     data:  parametros1,
                     url: "../model/Valida_tipo_seq.php",
                     type: "GET",
                   success: function(response)
                   {
                       $('#docu_serie').html(response);
                       
                       
                   }
                 });
  
       ListaModelo(tipo) ;
}	
        
//----------------------------------------
        
function ListaModelo(tipo) {

             var parametros = {
                         'tipo'  : tipo  
              };

                 $.ajax({
                     data:  parametros,
                     url: "../model/Valida_tipo_plantilla.php",
                     type: "GET",
                   success: function(response)
                   {
                       $('#plantilla').html(response);
                   }
                 });
          }		 
        
//--------------- Seq_User
        
function Seq_User(secuencia, tipo, bandera) {

             var parametros = {
                         'tipo'  : tipo,
                          'secuencia'  : secuencia,
                          'bandera':bandera
              };

                 $.ajax({
                     data:  parametros,
                     url: "../model/Valida_secuencia.php",
                     type: "GET",
                   success: function(response)
                   {
                       $('#serie_mensaje').html(response);
                       
                       DocumentoUsuario( tipo  );
                   }
                 });
 
    ListaModelo(tipo) ;
 
}
        
//-----------------------------------------
        
function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
           }


/*
Actualizar formulario
*/           
function Finalizar() {        

var idcaso =    $("#idcaso").val();

var parametros = {
                 'accion' : 'visor',
                 'idcaso' : idcaso  
    };

  $.ajax({
                 data:  parametros,
                 url:   '../model/Model-caso__doc_tra01.php',
                 type:  'GET' ,
                 success:  function (data) {

                           opener.$("#ViewFormfileDoc").html(data);  
 
                         
                                 
                  } 

        }); 

 
}
/*
*/
function goToURLDocBloqueaUser( tipo) {
	
    var    idcaso = $("#idcaso").val();

	var opcion = confirm("Clicka en Aceptar o Cancelar");
	
	var idcasodoc =  $("#idcasodoc").val();
			 
	 if (opcion) {
		 
				   var parametros = {
									'id'     : idcasodoc ,
									'idcaso' : idcaso,
									'accion' : 'seguro'
					  };


		            if ( tipo == '2'){
		
		               $("#myModalCorreo").modal('show');
		
		            }else{
		
		                  $.ajax({
		                    data:  parametros,
		                    url:   '../model/Model-addDoc01.php',
		                    type:  'POST' ,
		                    cache: false,
		                    beforeSend: function () { 
		                      $("#result_Doc").html('Procesando');
		                    },
		                    success:  function (data) {
		                      $("#result_Doc").html(data);   
		                      
		                    } 
		                }); 
		
		               formato_doc_firmado( idcasodoc,tipo );
		
		            }
           }
	 }
/*
*/
function  formato_doc_firmado( idproceso_docu,tipo  )
{
   
	   var   	idcaso = $("#idcaso").val();

 
     if ( tipo == '2'){
      var   	enlace = '../reportes/documento_firma_electronica.php?caso='+idcaso+'&doc='+idproceso_docu+'&tipo='+tipo;
    }else{
      var   	enlace = '../reportes/documento_firma.php?caso='+idcaso+'&doc='+idproceso_docu+'&tipo='+tipo;
    }
	

     var 	ancho = 1000;
     var 	alto = 520;
     
     posicion_x=(screen.width/2)-(ancho/2); 
     posicion_y=(screen.height/2)-(alto/2); 
     
 
     window.location.href = enlace;

  
	   
 }	 
     
 //
 function Firma_electronica_fin(  ) {
	
  var      idcaso    = $("#idcaso").val();
  var    idcasodoc = $("#idcasodoc").val();
  var    acceso1   = $("#acceso1").val();
  var      smtp1     = $("#smtp1").val();
  
  if ( acceso1 ) {

    if ( smtp1 ) {

                  var parametros = {
                    'id'     : idcasodoc ,
                    'idcaso' : idcaso,
                    'accion' : 'seguro',
                    'acceso1': acceso1
                };

                var parametros1 = {
                  'smtp1' : smtp1,
                  'acceso1': acceso1
              };

                if ( smtp1 ) {
	
                         $.ajax({
                          data:  parametros1,
                          type:  'POST' ,
                          url:   '../reportes/usuario_firma_pem.php',
                          cache: false,
                          beforeSend: function () { 
                            $("#ResultadoUserWeb").html('Procesando');
                          },
                          success:  function (data) {
                            
                            validacion = data;
                            validacion = validacion.trim();
                             
                            $("#ResultadoUserWeb").html(validacion);   
                            
                           } 
                       }); 
                       
                       if ( validacion == 'FIRMA VALIDA'){
				 						 
				 				 	 $.ajax({
			                               data:  parametros,
			                              url:   '../model/Model-addDoc01.php',
			                              type:  'POST' ,
			                              cache: false,
			                              beforeSend: function () { 
			                                $("#ResultadoUserWeb").html('Procesando');
			                              },
			                              success:  function (data) {
			                                $("#ResultadoUserWeb").html(data);   
			                                
			                              } 
			                        }); 
	 						 
	 								 $("#myModalCorreo").modal('hide');
	 								 
	 								 formato_doc_firmado( idcasodoc,'2' ); 
					   }
                    
                   
                  }
              }
        }  
	 }
/*
actualiza eiinar para elaborar documento
*/	
			   
  function goToURLDocdelvi(idcodigo,idcaso) {

 
				var parametros = {
								 'idcodigo' : idcodigo  ,
								'idcaso'   : idcaso  ,
								'accion' : 'del'
				   };
			
				  $.ajax({
								 data:  parametros,
								 url:   '../model/Model-caso__doc_tra05.php',
								 type:  'GET' ,
								 success:  function (data) {
										  $("#ViewFormfile").html(data);   
			  
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
   
	enlace = url+'?id='+idcaso+'&visor=1'  ;
   
	if ( idcaso > 0 ) {

			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }
}	 
//---------------------------------------------
function CargaPlantilla() {  
           
              var    idplantilla = $("#plantilla").val();
              var   idproceso = $("#idproceso").val();
              var    idtarea = $("#idtarea").val();
              var    idcaso = $("#idcaso").val();
              var   tipo = $("#tipo").val();

              var   asunto = $("#asunto").val();

           
             var parametros = {
                       'idplantilla': idplantilla,
                       'idproceso' :idproceso,
                       'idtarea' : idtarea,
                       'idcaso' : idcaso,
                       'tipo' : tipo,
                       'asunto':asunto
                };
            
                $.ajax({
                                type:  'GET' ,
                                data:  parametros,
                                url:   '../model/carga_plantilla.php',
                                dataType: "json",
                                success:  function (response) {
  
                                      tinyMCE.get('editor1').setContent( response.a );
                                    
                                     
                                          
                                } 
                        });
        
              }	 