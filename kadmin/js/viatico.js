var oTable;


 
//-------------------------------------------------------------------------


$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   

    	
	  
		$("#MHeader").load('../view/View-HeaderInicioAgenda.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
     
     	FormView();
     
		EstadoProceso();
 
});  
//--------------------------------------------------------
 
//------------------
function url_comprobante(url){        
	
	var variable    = $('#id_viatico').val();
     	
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
 	
	        posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
     
		
		 
 
 
 }
 
//-----------------------

function aprobacion(  ){

	 
  var id 	  = $('#id_viatico').val();
  var estado  = $.trim( $('#estado').val() );
   
 
  
  var mensaje =  confirm("¿Desea enviar la transacción?");
  
 if (mensaje) {
	 
	 var parametros = {
	 			"id" : id   ,
	 			"accion" : 'autorizado' 
		};
		
		if (estado == 'solicitado'){
			
			 $.ajax({
											data:  parametros,
											url:   '../model/Model_viatico.php',
											type:  'GET' ,
											cache: false,
		 									success:  function (data) {
		 											 	  $('#result').html(data);
										 				  $( "#result" ).fadeOut( 1600 );
										 			 	  $("#result").fadeIn("slow");
										 			 	  $('#estado').val('enviado') 
 		 				 					} 
									}); 
 				
		} 
	 
	 
  }
 
}
//------------------------
//---------------------------
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
  
    
    var today = yyyy + '-' + mm + '-' + dd;
    
return today;
            
} 
 
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#id_viatico").val(id);          
 
		 

}
//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
		
	  if (e) {
		    
		    LimpiarPantalla();
		      
			$("#action").val("add");
			
		    $("#result").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b> ]  AGREGAR NUEVO REGISTRO</b>');
			 
			
 
			  
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
	
 
	var fecha = fecha_hoy();
	
   var hoy = new Date();
	
	var dd   = hoy.getHours(); 
	
	if(dd < 10){
        dd='0'+ dd
    } 
    
    var min = hoy.getMinutes() ;
    
    if(min < 10){
        min='0'+ min
    } 
    
    var hora = dd + ':' + min;
    
 
	$("#fecha").val(fecha);
	$("#fecha_salida").val(fecha);
	$("#fecha_llegada").val(fecha);
	$("#fecha_sa1").val(fecha);
	$("#fecha_sa11").val(fecha);
	$("#fecha_sa2").val(fecha);
	$("#fecha_sa22").val(fecha);

	$("#id_viatico").val("");
  	$("#documento").val("");
	$("#ciudad_comision").val("");
	
	$("#hora_salida").val(hora);
	$("#hora_llegada").val(hora);
	$("#hora_sa1").val(hora);
	$("#hora_sa11").val(hora);
	$("#hora_sa2").val(hora);
	$("#hora_sa22").val(hora);
	
	$("#servidores").val("");
	$("#motivo").val("");
	$("#tipo_tras1").val("");
	$("#nombre_tras1").val("");
	$("#ruta1").val("");
	$("#tipo_tras2").val("");
	$("#nombre_tras2").val("");
	$("#ruta2").val("");
	
	$("#estado").val("solicitada");
 
    
        
   $("#revisado").val("");           
   $("#autorizado").val("");     
 	
 	$("#productos").val("");
 	$("#informe").val("");
 	
	$("#action").val("add");
 
 
   
 
 
	 
 }
 
 

//----------------------------------------------------
function goTocaso(accion,id,valida) {
 
    
    var estado      =    $("#vestado").val();
 
   var resultado = Mensaje( accion ) ;
		
	  
		
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
 
	if ( accion== 'del') {
		
		if ( estado == 'solicitado'){
			
				  alertify.confirm("Desea Anular el tramite emitido?", function (e) {
					  if (e) {
		 				  
									  $.ajax({
											data:  parametros,
											url:   '../model/Model_viatico.php',
											type:  'GET' ,
											cache: false,
		 									success:  function (data) {
		 											 alert(data);
 		 				 					} 
									}); 
		 				  }
					 });
					 
					 BusquedaGrilla( 1 );
		}	 
 	}
	else 	{
		
		 vurl = '../model/Model_viatico.php';
		
		 $.ajax({
					data:  parametros,
					url:   vurl,
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
 
						    		$("#result").html(data);
						  
  					} 
			}); 
	 }
	 

	


   if ( valida == 'S'){
 
 			$('#informe').attr('disabled', false);
 			$('#productos').attr('disabled', false);

		    $('#motivo').attr('disabled', true);
 			$('#servidores').attr('disabled', true);
  
   }
   if ( valida == 'N '){
   	    	$('#informe').attr('disabled', true);
 			$('#productos').attr('disabled', true);

		    $('#motivo').attr('disabled', false);
 			$('#servidores').attr('disabled', false);
   }
  
	 
   }
//----------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}   
//----------------
function BusquedaGrilla( estado){        	 
   
 
 
 
   var parametros = {
 				'estado' : estado 
      };
	  

 
    jQuery.ajax({
		data:  parametros, 
	    url: '../grilla/grilla_viatico.php',
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
  	                     	'<button class="btn btn-xs btn-warning" title="Visualizar Tramite" onClick="goTocaso('+"'editar'"+','+ s[i][0]+','+"'"+  s[i][6] + "'"+')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
							'<button class="btn btn-xs btn-danger" title="Anular Tramite" onClick="goTocaso('+"'del'"+','+ s[i][0]+ ',' +"'-'" +')"><i class="glyphicon glyphicon-warning-sign"></i></button>' 
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
 

/*
01. Estado de los procesos
*/

function EstadoProceso()
 {
	 
 	var parametros = {
			
                     'accion' : '1' 
 	  };
 
		  $.ajax({
						url:   '../controller/Controller_viatico_estado.php',
						type:  'GET' ,
					    data:  parametros,
						cache: false,
						success:  function (data) {
								 $("#ViewEstado").html(data);   
							     
	  					} 
				}); 
 
 } 
 /*
 */
 function PoneTarea(id_tarea)
 {
	 
 	var parametros = {
                      'id_tarea' : id_tarea
 	  };
 
	 $.ajax({
    										    type:  'GET' ,
    											data:  parametros,
    											url:   '../model/Model_lista_disp.php',
    											dataType: "json",
     											success:  function (response) {
    													 $("#codificado").val( response.a );  
    													 $("#certificacion").val( response.b );  
    													 $("#disponible").val( response.c ); 
    													 
    											} 
    									});
      
 } 
//-----------------
 function FormView()
 {
     
    	 
    	 $("#ViewFormularioTarea").load('../controller/Controller_viatico.php');
    	 
 
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
 
 