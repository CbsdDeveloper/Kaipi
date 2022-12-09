var oTable;


 
//-------------------------------------------------------------------------


$(document).ready(function(){
       
	
    	oTable = jQuery('#json_variable').dataTable();   

    	
	  
		$("#MHeader").load('../view/View-HeaderInicioAgenda.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
        FormView();
 
		BusquedaGrilla(0, 1);
 
 
});  
  
 
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#id_vacacion").val(id);          
 
  


		 


}
//-------------
function changeAction(tipo,action,mensaje){
	
	if (tipo =="confirmar"){			 
	
	  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
	  if (e) {
		 
 		   
 	  	      
			$("#action").val("add");
			
			var resultado =  `<div class="alert alert-success"><img src="../../kimages/if_error_36026.png" align="absmiddle" />&nbsp;<strong>AGREGAR NUEVO REGISTRO DE TRANSACCION</strong>   COMPLETE LA INFORMACION PARA GUARDAR LA INFORMACION </div>`;
			$("#result").html(resultado);
			 
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
/*
*/
function fecha_hoy()
 {
 
	 var today = new Date();
	 var dd = today.getDate() ;
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
//-----------------------------------------------------------------
//ir a la opcion de editar
function LimpiarPantalla() {
	
     
	var fecha = fecha_hoy();
	$("#fecha_out").val(fecha);
	$("#fecha_in").val(fecha);
		
		$("#id_vacacion").val('');
		
		$("#novedad").val('');

        $("#motivo").val('');

        $("#tipo").val('');
 
		$("#estado").val('1');
	 

		
 
 
 
	 
 }
//-------------------------------------------------------------------------

//-----	
function openNav_proceso() {
	  document.getElementById("mySidenav_proceso").style.width = "350px";
	  document.getElementById("main_proceso").style.marginLeft = "350px";
	 
	}

	function closeNav_proceso() {
	  document.getElementById("mySidenav_proceso").style.width = "0";
	  document.getElementById("main_proceso").style.marginLeft= "0";
	   
	}

/* Función que suma o resta días a una fecha, si el parámetro
   días es negativo restará los días*/
   function sumarDias(dias){

	var today = new Date();
  
	today.setDate(today.getDate() + dias);


	var dd = today.getDate() ;
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
 suma dias
 */
 function addDaysToDate(date, days){

    var res = new Date(date);
    res.setDate(res.getDate() + days);


	var myDate = new Date(res).toISOString();

	const myArray = myDate.split("T");

	str_fecha = myArray[0]; 

 

    return str_fecha;
} 
//-------------------------------------------------------------------------
function valida_tipo(tipo,valor) {
 		
	var fechahoy = sumarDias(1);

	var fechavaca  = sumarDias(15);
	var fechavaca1 = sumarDias(22);

	
	var action = $("#action").val();
 
    var bandera  ;
	

 	if ( tipo == 1){

 		fecha = fecha_hoy();
		$("#fecha_out").val(fecha);
		$("#fecha_in").val(fecha);
		var tipo_seleccion =  valor;

 				var parametros = {
						'tipo'   : valor
					};

				$.ajax({
					data:  parametros,
					url: "../model/ajax_lista_motivos.php",
					type: "GET",
				success: function(response)
				{
						$('#motivo').html(response);
					
				}
				});
				$("#fecha_vaca").val(fechavaca);
				$("#bandera_vaca").val('1');

	}else{
		var tipo_seleccion = $("#tipo").val();
		var fecha = valor;
    }	

 	if ( tipo_seleccion == 'permiso_hora') {
		$("#fecha_in").val(fecha);
		$("#fecha_out").val(fecha);
		$('#hora_out').attr("disabled", false) ;
		$('#hora_in').attr("disabled", false) ;
	}
		
	if ( tipo_seleccion == 'vacaciones') {
		$("#hora_out").val('00:00');
		$("#hora_in").val('00:00');
		$('#hora_out').attr("disabled", true) ;
		$('#hora_in').attr("disabled", true) ;

		bandera = 	$("#bandera_vaca").val();

		if ( action == 'add'){
			if ( bandera  == '1'){
					$("#fecha_out").val(fechavaca);
					$("#fecha_in").val(fechavaca1);
					$("#bandera_vaca").val('2');
		 	}else	{	
				 var original  = $("#fecha_vaca").val();
				 var fecha_out = $("#fecha_out").val();

				 if ( fecha_out > original){	
					fechavaca1 = addDaysToDate(fecha_out, 15);
					$("#fecha_in").val(fechavaca1);
				 }else{	
					$("#fecha_out").val(original);
					$("#fecha_in").val(fechavaca1);
				 }

			}
		}

 	}

	if ( tipo_seleccion == 'permiso_dia') {
				$("#hora_out").val('00:00');
				$("#hora_in").val('00:00');
	 
				if ( action == 'add'){
					$("#fecha_in").val(fechahoy);
					$("#fecha_out").val(fechahoy);
				}
				$('#hora_out').attr("disabled", true) ;
				$('#hora_in').attr("disabled", true) ;
	}
 

}
/*
valida_tipo_fecha
*/
function valida_tipo_fecha() {
 	
  
	var tipo_seleccion = $("#tipo").val();
	var fecha 		   = $("#fecha_out").val();
	 
 
	
 	if ( tipo_seleccion == 'permiso_hora') {
		$("#fecha_in").val(fecha);
 	 
	}
		
	if ( tipo_seleccion == 'vacacion') {
	 
 	}

	if ( tipo_seleccion == 'permiso_dia') {
				 
	}
 

}
//-------------------------------------------------------------------------
function valida_tipo_q(tipo_seleccion) {
  
 
	if ( tipo_seleccion == 'permiso_hora') {
 		$('#hora_out').attr("disabled", false) ;
		$('#hora_in').attr("disabled", false) ;

	}
		
	if ( tipo_seleccion == 'vacacion') {
		$('#hora_out').attr("disabled", true) ;
		$('#hora_in').attr("disabled", true) ;
	}

	if ( tipo_seleccion == 'permiso_dia') {
		$('#hora_out').attr("disabled", true) ;
		$('#hora_in').attr("disabled", true) ;
	}
 

}
//----------------------------------------------------
function goTocaso(accion,id) {
 
	var parametros = {
		'accion' : accion ,
		'id' : id 
};

var estado = $("#bandera1").val();


if ( accion == 'del'){

	if ( estado == '1'){
			alertify.confirm("<p>Va anular el tramite seleccionado...</p>", function (e) {
				if (e) {
					$.ajax({
						data:  parametros,
						url:   '../model/Model-pedido_permiso.php',
						type:  'GET' ,
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
		}else{

				$.ajax({
					data:  parametros,
					url:   '../model/Model-pedido_permiso.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							$("#result").html(data);   
					} 
			}); 
		}

   }
//----------------
function BusquedaGrilla(tipo, estado){        	 
   
	
   $("#bandera1").val(estado);
 
   var parametros = {
				'tipo' : tipo  ,
				'estado' : estado 
      };
	  

 
    jQuery.ajax({
		data:  parametros, 
	    url: '../grilla/grilla_permiso.php',
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
						  s[i][6],
						  s[i][7],
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
  
  
 
//-----------------
 function FormView()
 {


		$("#ViewEstado").load('../controller/Controller-auto_02.php');
     
    	 
    	 $("#ViewFormularioTarea").load('../controller/controller_pedido_permiso');
    	 
 
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
 
 //--------------------------
function Ver_doc_prov(idcaso) {

	 
     var parametros = {
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
function openFile(url) {
    
	var id = $('#id_vacacion').val();

	var tipo  = $("#tipo").val();
	
	var ancho= 650;
	var alto = 550;

	 var posicion_x; 
	var posicion_y; 

	var enlace; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
   


	enlace = url+'?id='+id +'&tipoo='+tipo ;
   
	if ( id) {
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
/**/
function notificar_permiso() {
 
    var id_vacacion  = $('#id_vacacion').val();
 
 
	var parametros = {
				   'accion' : 'notificar' ,
				   'id' : id_vacacion 
	  };


	  alertify.confirm("<p>DESEA NOTIFICAR Y GENERAR ALERTA DE LA SOLICITUD DE PERMISO? </p>", function (e) {
		if (e) {
		   
			$.ajax({
				data:  parametros,
				url:   '../model/Model-pedido_permiso.php',
				type:  'GET' ,
				 beforeSend: function () { 
						 $("#result").html('Procesando');
				  },
				success:  function (data) {
						 $("#result").html(data);  
						 $('#estado').val('4');

						 BusquedaGrilla('0', '1')
						 
				  } 
		}); 
			   
		}
	   }); 

	  }
