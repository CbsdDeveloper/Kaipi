var validacion = 0;

$(document).ready(function(){

    var   idcaso      =  getParameterByName('id');
    var   accion	  =  getParameterByName('accion');
    var   iddoc	      =  getParameterByName('iddoc');
 
 
       $("#idproceso").val('21');
       $("#idcaso").val(idcaso);
       $("#accion").val(accion);
       $("#idcasodoc").val( iddoc);
     
    
      var parametros  = {
               'idproceso': 21,
               'idcaso': idcaso,
               'accion' : accion,
               'iddoc' : iddoc
        };
   
      
      $.ajax({
                data:  parametros,
                url:   '../controller/Controller-formatoDoc_seg.php',
                type:  'GET' ,
                cache: false,
                beforeSend: function () { 
                            $("#docu").html('Procesando');
                    },
                success:  function (data) {
                         $("#docu").html(data); 
                    } 
        }); 
 
        var parametros1 = {
             'idcaso': idcaso,
             'iddoc' : iddoc
         };

 		var parametros11 = {
             'idcaso': idcaso,
             'iddoc' : iddoc
         };
         
    
           $.ajax({
                        type:  'GET' ,
                        data:  parametros1,
                        url:   '../model/carga_editor_doc_seg.php',
                        dataType: "json",
                        success:  function (response) {
                               tinyMCE.get('editor1').setContent( response.a );
                         } 
                });
   
                $("#perfilUserWeb").load('../controller/Controller-firma_doc_ver.php');
                
                
                $.ajax({
                        type:  'GET' ,
                        data:  parametros11,
                        url:   '../model/carga_editor_doc_seg.php',
                        dataType: "json",
                        success:  function (response) {
                               tinyMCE.get('editor1').setContent( response.a );
                         } 
                });      
  
}); 
/*
*/
function  formato_doc_visor(    )
 {
	
 

	    var   	idcaso         = $("#idcaso").val();
      var     idproceso_docu = $("#idcasodoc").val();
	    var 	posicion_x; 
	    var 	posicion_y; 
	    var   	enlace = '../reportes/documento_matriz.php?caso='+idcaso+'&doc='+idproceso_docu;
	    var 	ancho = 1000;
	    var 	alto = 520;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
        
  }

  /*
*/
function goToURLDocBloqueaUser( tipo) {
	
  var    idcaso = $("#idcaso").val();

	var opcion = confirm("Clicka en Aceptar o Cancelar");
	
	var idcasodoc =$("#idcasodoc").val();
			 
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
     
//------------------------------------------		   
function Ver_secuencia(tipo) {

var uso = $("#uso").val();

     var parametros = {
                 'tipo'  : tipo ,
                  'uso':uso
      };

         $.ajax({
             data:  parametros,
             url: "../model/Valida_tipo_seq.php",
             type: "GET",
           success: function(response)
           {
               $('#docu_serie').html(response);
           }
         });
  }
//-------------------------------------
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
           }
         });
  }

//--------------------------			

function  DocumentoUsuario( tipo  ) {

var uso       = $("#uso").val();
var documento = $("#documento").val();
var idcaso    = $("#idcaso").val();

$("#tipo").val(tipo);


    var parametros = {
               'tipo': tipo,
               'uso' : uso,
               'idcaso' :idcaso
        };

   var parametros1 = {
          'tipo'  : tipo ,
          'uso'   : 'E'
      };      

if ( documento ){
    ListaModelo(tipo) ;
}
else{	
    $.ajax({
            type:  'GET' ,
            data:  parametros,
            url:   '../model/Valida_tipo_documento.php',
            dataType: "json",
            success:  function (response) {
               $("#documento").val( response.a);  
               $("#tipoDoc").val( tipo);  
               $("#docpone").val( response.a);  
               $("#secuencia_dato").val( response.b);  
               ListaModelo(tipo) ;
             },
            complete: function (  ) {
                ListaModelo(tipo) ;
            }	
    });
   
    $.ajax({
                data:  parametros1,
                url: "../model/Valida_tipo_seq.php",
                type: "GET",
              success: function(response)
              {
                  $('#docu_serie').html(response);
              }
            });
           
   }
}
//-------------------------------------------


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

//-----------------------------------------

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
   }


function Finalizar() {        

var idcaso =    $("#idcaso").val();

var parametros = {
         'accion' : 'visor',
         'idcaso' : idcaso  
};

$.ajax({
         data:  parametros,
         url:   '../model/Model-caso__doc_tra02.php',
         type:  'GET' ,
         success:  function (data) {

                 opener.$("#ViewFormfileDoc").html(data);  

                          var ventana = window.self;
                          ventana.opener = window.self;
                          ventana.close();
          } 

}); 


}

//---------------------------------------------
function CargaPlantilla() {  
   
     var   idplantilla = $("#plantilla").val();
      var   idproceso = $("#idproceso").val();
     var   idtarea = $("#idtarea").val();
     var   idcaso = $("#idcaso").val();
      var   tipo = $("#tipo").val();

    var   para   = $("#para").val();
    var   de     = $("#de").val();

    var   accion = $("#accion").val();
    var   asunto = $("#asunto").val();
   
     var parametros = {
               'idplantilla': idplantilla,
                'idproceso' :idproceso,
               'idtarea' : idtarea,
               'idcaso' : idcaso,
                 'tipo' : tipo,
                 'para' : para,
                'de' :de,
                'accion' : accion,
                  'asunto':asunto
        };
    
    

        $.ajax({
                        type:  'GET' ,
                        data:  parametros,
                        url:   '../model/carga_plantilla_seg.php',
                        dataType: "json",
                        success:  function (response) {

                              tinyMCE.get('editor1').setContent( response.a );
                            
                                   
                        } 
                });

      }	   

//---------------------------------------------