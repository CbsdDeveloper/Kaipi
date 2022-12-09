$(document).ready(function(){
    
	$("#MHeader").load('../view/View-HeaderModel.php');
	
 		
	FormFiltro();
	
	FormView();
	
	visor_dia() ;
    
	$("#FormPie").load('../view/View-pie.php');
 
    var fecha = fecha_hoy();
     
     
     $('#fechad').val(fecha);
     $('#fechah').val(fecha);
   

     
	  var j = jQuery.noConflict();

		j("#loadprint2").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#ViewFormDiarioVeh").printArea( options );

		});
	 
	 	j("#loadprint1").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#ViewFormDiario").printArea( options );

		});
	         
});  
 
/*
Impresion de reportes de comprobantes
*/
function imprimir_informe(url){        
	
	var variable    = $('#id_bita_bom').val();
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url +'?id='+ variable  
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
// ir a la opcion de editar
function AprobarBitacora( ) {
 
 
  var hora1     	= 	$("#hora1").val();        
  var hora2 		= 	$("#hora2").val();       
  var actividad     = 	$("#actividad").val();        
  var motivo 		= 	$("#motivo").val();       
  var observacion 	= 	$("#observacion").val();       
  
         
	
     var parametros = {
					'accion' : 'agregar' ,
                    'actividad' : actividad ,
                    'motivo': motivo,
                    'hora1':hora1,
                    'hora2':hora2,
                    'observacion':observacion
 	  };
 	  
 	  
 	  if ( actividad){ 
 			  if ( motivo){ 
	                 if(observacion){ 
			               $.ajax({
								data:  parametros,
								url:   '../model/Model_hoja_novedad.php',
								type:  'POST' ,
			 					beforeSend: function () { 
			 							$("#ViewGrillaPersonal").html('Procesando');
			  					},
								success:  function (data) {
										    $("#ViewGrillaPersonal").html(data);  
	 								     
			  					} 
						}); 
	
 	
						$("#actividad").val("");     
						$("#motivo").val("");     
						$("#observacion").val("");  
 			} 	 		
 	 	 } 		 
			 
	   } 

	}	 

// ir a la opcion de editar
function visor_dia() {
 
 
	
     var parametros = {
					'accion' : 'visor'  
 	  };
 	  
 	   $.ajax({
								data:  parametros,
								url:   '../model/Model_hoja_novedad.php',
								type:  'POST' ,
			 					beforeSend: function () { 
			 							$("#ViewGrillaPersonal").html('Procesando');
			  					},
								success:  function (data) {
										    $("#ViewGrillaPersonal").html(data);  
	 								     
			  					} 
						}); 
	 	 

    }
//-----------    
function EliminaNovedad(id_bom_nov) {
  
     var parametros = {
					'accion' : 'eliminar' ,
					'id_bom_nov':id_bom_nov
 	  };
 	  
 	   $.ajax({
								data:  parametros,
								url:   '../model/Model_hoja_novedad.php',
								type:  'POST' ,
			 					beforeSend: function () { 
			 							$("#ViewGrillaPersonal").html('Procesando');
			  					},
								success:  function (data) {
										    $("#ViewGrillaPersonal").html(data);  
	 								     
			  					} 
						}); 
	 	 

    }
//-----------------------------------------
function accion(id,modo)
{
  
			$("#action").val(modo);
			$("#id_bita_bom").val(id);          

		//	BusquedaGrilla(oTable );

}
//-------------------------------------------------------------------------
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}

//-----------
function Modifica_vehiculo( accion, codigo) {
	
	  $("#myModal").modal('show');  
	  
	  
	   $("#action_03").val(accion);	 
 
	var parametros = {
			   'accion' : accion ,
			   'id':codigo
    };
	 
	 
	 
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
    
     
        
   $.ajax({
		   data:  parametros,
			url:   '../model/Model_bom_nov_01.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarDocumento").html('Procesando');
			   },
		   success:  function (data) {
			
					$("#guardarDocumento").html(data);  
					
 					    
					    var retorna = $("#retorna").val();
  					    
					    if ( retorna == '00:00:00') {
									$("#retorna").val(hora); 
						} 
			   } 
   });
	  
 
}	
//-------------------------------------------------------------------------
// ir a la opcion de editar
function llamarMovil() {
  

 	
	var tipo = 	$("#tipo").val();
	
	if ( tipo == 'CONTROL VEHICULAR') {
		  $("#myModal").modal('show');  
		  
		  
	}
  
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
    
     
	$("#salida").val(hora);
	$("#retorna").val("00:00");  		
 	
 	    
  	$("#km_salida").val("0");
  	$("#km_retorna").val("0");
    $("#orden").val("");  		
      
    $("#action_03").val("add");	   
    	   
    $("#nombre_funcionario").val("");  	
    $("#nombre_bien").val("");  		 	   
    	   
    	   
			   
}
 
//------------  
function llamarEmer() {
  
  
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
    $("#hora1").val(hora);
	$("#hora2").val(hora);
	
	     

 	var hoy = new Date();
 	
	var tipo = 	$("#tipo").val();
    var dd   =  hoy.getHours(); 
    var min  =  hoy.getMinutes() ;
      
		
	
	if ( tipo == 'EMERGENCIA') {
		  $("#myModalEmergencia").modal('show');  
		  
		  
	}
   
	
	if(dd < 10){
        dd='0'+ dd
    } 
   
    
    if(min < 10){
        min='0'+ min
    } 
    
    var hora = dd + ':' + min;
    
 	$("#peloton").val('');
 	$("#sector").val('');
 	$("#direccion").val('');
 	$("#peloton").val('');
 	$("#clasedia").val('');
 	$("#faviso").val('');
 	//$("#especificacion").val('');
 	$("#clave").val('');

   
    $("#aviso").val(hora);
    $("#action_02").val("add");	   
    	   
    	  
			   
    }
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
 
  
 ///////////////////////////////////
 
function modulo()
{
 

	 var modulo =  'kbombero';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
  
/*
FUNCION QUE DIBUJA LA GRILLA DEL ACTIVIDADES DE LA BITCORA
*/
function BusquedaNovedad()
{

 
  var fecha =    $('#fechad').val();

	var parametros = {
			   'fecha' : fecha 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_novedad_usuario.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewFormDiario").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewFormDiario").html(data);  
					
			   } 
   });
	
	 
}
 
//--------------- 
 function BusquedaNota()
{

 
  var fecha =    $('#fechad').val();
  var fechah =    $('#fechah').val();
  
  

	var parametros = {
			   'fecha' : fecha ,
			   'fechah':fechah
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_novedad_usuario_nota.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewFormDiario").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewFormDiario").html(data);  
					
			   } 
   });
	
	 
}

 
 
/*
Carga de formularios
*/
function FormView()
{
	
	
	  $("#ViewForm").load('../controller/Controller_bom_form.php');
   
	  $("#ViewNovedad").load('../controller/controller_hoja_novedad.php');
    
   
   
  
}
//----------------------
function FormFiltro()
{
   
  $("#ViewFiltro").load('../controller/Controller_hoja_filtro.php');

}

//-------------------
function openFile() {
    
   var id_bita_bom_01 = $("#id_bita_bom").val();
    	
   var url =  '../../upload/uploadBom?id=' + id_bita_bom_01;
   var ancho = 650;
   var alto  = 300;
   
   
		  var posicion_x; 
		  var posicion_y; 
 		  
		  posicion_x=(screen.width/2)-(ancho/2); 
		  posicion_y=(screen.height/2)-(alto/2); 
		  
		
	if ( id_bita_bom_01 > 0 )	  {
 	  
		  window.open(url, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
	  }		  
		  
 }	