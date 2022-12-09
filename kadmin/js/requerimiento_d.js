var oTable;


 
//-------------------------------------------------------------------------


$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   

    	
	  
		$("#MHeader").load('../view/View-HeaderInicioAgenda.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
    	FormArbolCuentas(); 
    	
    	BuscaArchivo(0);
    
  
 
});  
 
 
   
function FormArbolCuentas()
{

   $("#ViewEstado").load('../controller/Controller-auto_03.php' );
   
 
}
 
/*
 ir a la opcion de editar
 pone informacion de los tramites
*/
function BuscaArchivo(unidad) {
	 
	 
    $("#bandera1").val(unidad);
 
	 var parametros = {
			
                     'id' : unidad,
                     'accion': 'visor'
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../../upload/Model-crm_dep.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormfile").html('Procesando');
  					},
					success:  function (data) {
						
							 $("#ViewFormfile").html(data); 
						     
							 
							 
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
   
 
//-----------------
 function FormView()
 {
     
    	 
    	 $("#ViewFiltro").load('../controller/Controller-caso_filtro.php');
    	 
 
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
function goToURLDocdel(idproceso_des,id) {


 
	 
   var parametros = {
			
                     'id' : id,
                     'idproceso_des': idproceso_des,
                     'accion': 'del'
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../../upload/Model-crm_dep.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormfile").html('Procesando');
  					},
					success:  function (data) {
						
							 $("#ViewFormfile").html(data); 
						     
								FormArbolCuentas(); 
							 
  					} 
			}); 
 
  }
//------------
function openFile(url,ancho,alto) {
    
        
    var posicion_x; 

    var posicion_y; 

    var enlace; 
   
    posicion_x=(screen.width/2)-(ancho/2); 

    posicion_y=(screen.height/2)-(alto/2); 
   
    
    window.open(url, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

 
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
   