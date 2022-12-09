 
var oTable;

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	$("#MHeader").load('../view/View-HeaderModel.php');
	
	modulo();
		
	FormFiltro();
	
	FormView();
    
	$("#FormPie").load('../view/View-pie.php');
 
     oTable = $('#jsontable').dataTable(); 
        

     
     $('#load').on('click',function(){
 
     	 BusquedaGrilla(oTable);
       
		});
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');

					 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
//-------------------------------------------------------------------------
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
 
 
  var id     = 	$("#id_bita_bom").val();        
  var estado = 	$("#estado").val();          
   
 
  
	
     var parametros = {
					'accion' : 'aprobar' ,
                    'id' : id 
 	  };
 	  
 	  
 	  if ( estado == 'digitado'){ 
 	  
 	    alertify.confirm("<p>AUTORIZAR BITACORA</p>", function (e) {
			  if (e) {
				 
                 	
		               $.ajax({
							data:  parametros,
							url:   '../model/Model-bom_bitacora_bom.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#result").html('Procesando');
		  					},
							success:  function (data) {
									    $("#result").html(data);  
									 	$("#estado").val('autorizado');          
								     
		  					} 
					}); 

					 
			  }
			 }); 
			 
	} 

	}	 

// ir a la opcion de editar
function goToURL(accion,id) {
 
 
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-bom_bitacora_bom.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

			GrillaPersonal(id);
			GrillaActividad(id);
			GrillaCarro(id);
			GrillaMaterial(id);

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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  

	var fecha = fecha_hoy();
	
	var hoy = new Date();
	
	var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
	
	$("#id_bita_bom").val("");
 	$("#fecha").val(fecha);
	$("#peloton").val("");
	$("#novedad").val("Turno del dia " + fecha + ' Hora de reporte: ' +hora);
	$("#estado").val("digitado");
       			   
    }
  /*
 Limpia y valida la informacion de los bomberos e ifnromacion 
  */ 
 
function LimpiaPersonal() {
  

 
	var id_bita_bom = $("#id_bita_bom").val();
	
	var estado = $("#estado").val();


   if ( estado == 'digitado') {

			if ( id_bita_bom > 0 ){
		
				$("#idprov").val("");
				$("#id_bom_bita").val("");
				$("#denominacion").val("");
				$("#actividad").val("NO EXISTE NOVEDAD");
				$("#action_01").val("add");
				$("#id_bita_bom_01").val(id_bita_bom);
		 
				$("#myModal").modal('show'); // abre el formulario modal
		 
			}	 
     }	
}
  /*
 Limpia y valida la informacion de los bomberos e ifnromacion 
  */ 
 
function LimpiaActividades() {
  

 
	var id_bita_bom = $("#id_bita_bom").val();
	var estado = $("#estado").val();


   if ( estado == 'digitado') {
	
				if ( id_bita_bom > 0 ){
			
			 		$("#id_bom_acti").val("");
			 		$("#actividad_d").val("NO EXISTE NOVEDAD");
					$("#action_02").val("add");
					$("#id_bita_bom_02").val(id_bita_bom);
				 
			   
					$("#myModalActividad").modal('show'); // abre el formulario modal
			 
				}	 
   }	 
}
/*
LimpiaVehiculos
*/
function LimpiaVehiculos() {
  

 
	var id_bita_bom = $("#id_bita_bom").val();
	
		var estado = $("#estado").val();


   if ( estado == 'digitado') {
		
			if ( id_bita_bom > 0 ){
		 
		 
				$("#idbien").val("");
		  		$("#id_bom_carro").val("");
		 		$("#actividad_c").val("SIN NOVEDAD");
				$("#action_03").val("add");
				$("#id_bita_bom_03").val(id_bita_bom);
				
				$("#km").val("");
				$("#comb").val("2/4");
				$("#aceite_a").val("0");
				$("#aceite_c").val("0");
				
			
			 
				$("#myModalCarro").modal('show'); // abre el formulario modal
		 
			}	 
    }	 
}
/*
LimpiaVehiculos
*/
function LimpiaMateriales() {
  

 
	var id_bita_bom = $("#id_bita_bom").val();

	var estado = $("#estado").val();


   if ( estado == 'digitado') {
	
			if ( id_bita_bom > 0 ){
		 
		 
				$("#tipo_m").val("");
		  		$("#id_bom_mate").val("");
		 		$("#actividad_m").val("");
				$("#action_04").val("add");
				$("#id_bita_bom_04").val(id_bita_bom);
			 	$("#cantidad").val("00");
		 	 
		   
				$("#myModalMaterial").modal('show'); // abre el formulario modal
		 
			}	 
}		 
 
 
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
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
 
        var ffecha1  			= $("#ffecha1").val();
        var ffecha2  			= $("#ffecha2").val();
        var vid_departamento	= $("#vid_departamento").val();
			
           	
            var parametros = {
					'ffecha1' : ffecha1 ,
					'ffecha2' : ffecha2 ,
					'vid_departamento' : vid_departamento 
  	       };
 
 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_bom_bitacora_bom.php',
				dataType: 'json',
				success: function(s){
				//console.log(s); 
				if (s){
						oTable.fnClearTable();
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
                                s[i][4],  
                                s[i][5],
   								'<button class="btn btn-xs btn-warning" title="EDITAR REGISTRO " onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs btn-danger" title="ELIMINAR REGISTRO" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} 
				 }							
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			
			
			
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
FUNCION QUE DIBUJA LA GRILLA DEL PERSONAL DE LA BITCORA
*/
function GrillaPersonal(bitacora)
{

	if ( bitacora == -1 ) { 
		  bitacora = $("#id_bita_bom").val();
	}

	var parametros = {
			   'bitacora' : bitacora 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_bitacora_usuario.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewGrillaPersonal").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewGrillaPersonal").html(data);  
					
			   } 
   });
	
}
/*
FUNCION QUE DIBUJA LA GRILLA DEL ACTIVIDADES DE LA BITCORA
*/
function GrillaActividad(bitacora)
{

 
	if ( bitacora == -1 ) { 
		  bitacora = $("#id_bita_bom").val();
	}

	var parametros = {
			   'bitacora' : bitacora 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_bitacora_actividad.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewGrillaActividades").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewGrillaActividades").html(data);  
					
			   } 
   });
	
	 
}
/*
FUNCION QUE DIBUJA LA GRILLA DEL ACTIVIDADES DE LA BITCORA
*/
function GrillaMaterial(bitacora)
{

 
	if ( bitacora == -1 ) { 
		  bitacora = $("#id_bita_bom").val();
	}

	var parametros = {
			   'bitacora' : bitacora 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_bitacora_material.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewGrillaMateriales").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewGrillaMateriales").html(data);  
					
			   } 
   });
	
	 
}

/*
FUNCION QUE DIBUJA LA GRILLA DEL ACTIVIDADES DE LA BITCORA
*/
function GrillaCarro(bitacora)
{

 
	if ( bitacora == -1 ) { 
		  bitacora = $("#id_bita_bom").val();
	}

	var parametros = {
			   'bitacora' : bitacora 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_bitacora_carro.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewGrillaVehiculos").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewGrillaVehiculos").html(data);  
					
			   } 
   });
	
	 
}
/*
llama datos al formulario de bomberos bitacora
*/
function goToURL_bomberos_bitacora(accion,id_bom_bita)
{

	var id_bita_bom_01 = $("#id_bita_bom").val();

	$("#action_01").val(accion);
	
	$("#id_bita_bom_01").val(id_bita_bom_01);


	var parametros = {
			   'id' : id_bom_bita ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/Model-bom_bitacora_bom_01.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarDocumento").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarDocumento").html(data);  
					
			   } 
   });
	
   $("#myModal").modal('show'); // abre el formulario modal

}
//
function goToURL_bomberos_actividad(accion,id_bom_bita)
{

	var id_bita_bom_01 = $("#id_bita_bom").val();

	$("#action_02").val(accion);
	
	$("#id_bita_bom_02").val(id_bita_bom_01);


	var parametros = {
			   'id' : id_bom_bita ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/Model-bom_bitacora_bom_02.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarActividad").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarActividad").html(data);  
					
			   } 
   });
	
   $("#myModalActividad").modal('show'); // abre el formulario modal

}
//--
function goToURL_bomberos_carro(accion,id_bom_bita)
{

	var id_bita_bom_01 = $("#id_bita_bom").val();

	$("#action_03").val(accion);
	
	$("#id_bita_bom_03").val(id_bita_bom_01);


	var parametros = {
			   'id' : id_bom_bita ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/Model-bom_bitacora_bom_03.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarActividad").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarActividad").html(data);  
					
			   } 
   });
	
   $("#myModalCarro").modal('show'); // abre el formulario modal

}
///
function goToURL_bomberos_material(accion,id_bom_bita)
{

	var id_bita_bom_01 = $("#id_bita_bom").val();

	$("#action_04").val(accion);
	
	$("#id_bita_bom_04").val(id_bita_bom_01);


	var parametros = {
			   'id' : id_bom_bita ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/Model-bom_bitacora_bom_05.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarMaterial").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarMaterial").html(data);  
					
			   } 
   });
	
   $("#myModalMaterial").modal('show'); // abre el formulario modal

}
/*
Carga de formularios
*/
function FormView()
{
   
	  $("#ViewNovedad").load('../controller/Controller-bom_novedad.php');
    
	/* $("#ViewFormPersonal").load('../controller/Controller-bom_bitacora_bom_01.php'); // personal
 
 	 $("#ViewActividad").load('../controller/Controller-bom_bitacora_bom_02.php'); // actividad
 
    $("#ViewCarro").load('../controller/Controller-bom_bitacora_bom_03.php'); // carro
 
    $("#ViewMaterial").load('../controller/Controller-bom_bitacora_bom_04.php'); // carro
 
 */
 
}
//----------------------
function FormFiltro()
{
   
 // $("#ViewFiltro").load('../controller/Controller-bom_bitacora_bom_filtro');

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