var oTable;
var modulo_sistema     =  'kpersonal';
 
 
//-------------------------------------------------------------------------
$(document).ready(function(){
	
		modulo();
	
		FormView();


       oTable 	= $('#jsontable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
           aoColumnDefs: [
  		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "ye", "aTargets": [ 1 ] },
 		      { "sClass": "de", "aTargets": [ 4 ] } 
 		    ] 
      } );
       
      
 
		$.ajax({
 			 url: "../model/ajax_unidad_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qunidad').html(response);
	       }
		 });
	    
	 

 	   $('#load').on('click',function(){
 		   			BusquedaGrilla(oTable);
		});

     
		$('#loadDoc').on('click',function(){
 
            openFile('../../upload/uploadDoc',650,370);
 
		});
 
		$('#excelload').on('click',function(){
 
			exportar_excel('../../reportes/excel_personal');

 		});
 
 

		
 
		$("#FormPie").load('../view/View-pie.php');
		$("#MHeader").load('../view/View-HeaderMedico.php');

});  
//----------------

function valida( ) {

}	
//---------------
function myFunction(codigo,objeto)

 {
  	   var estado = '';
 	   
	   var  id_atencion = $("#id_atencion").val();

	    if (objeto.checked == true){
 	    	estado = 'S'
 	    } else {
 	    	estado = 'N'
 	    }

 
	    var parametros = {
 			 	'accion' : 'habito' ,
                 'id' : id_atencion ,
				 'codigo':codigo,
                 'estado':estado

	  };

	 
      $.ajax({

				data:  parametros,
 				url:   '../model/ajax_habito_medico.php',
 				type:  'GET' ,
 				cache: false,
 				beforeSend: function () { 
 							$("#result").html('Procesando');
 					},
 				success:  function (data) {
 						 $("#result").html(data);   
 					} 

		}); 
 
 }

//-------------------------
function imprimir_informe(url) {
    
	var idprov = $('#idprov').val();
	   
	var ancho = 800;
	var alto  = 650;
	var posicion_x; 
	var posicion_y; 
	var enlace; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
   
	enlace = url+'id='+idprov  ;
   
	if ( idprov) {
			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }
}
//---------------
function exportar_excel(url)

{
	 window.open(url,'_blank');

}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 				 
 					$("#action").val("add");
 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
 
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

//-------------------------------------------------------------------------
function goToURL(accion,id) {

	var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };

	var bandera = 0;	

 	
	 	   if ( accion == 'del'){
 				alertify.confirm("<p>DESEA ELIMINAR FUNCIONARIO? </p>", function (e) {
 					if (e) {
 						 bandera = 1;	
 					}
				}); 
			}

			if ( accion == 'editar'){
				bandera = 1;	
			}	


			if ( bandera == 1 ) {

				  $.ajax({
								data:  parametros,
								url:   '../model/Model_me_atencion.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#result").html('Procesando');
			  					},
								success:  function (data) {
												if ( accion == 'del'){
														alert(data);
												} else	{
														$("#result").html(data);   
 
 												}
 			  				
				 				}	
				}); 	
			} 	 
			
			go_enfermo(id);
			GrillaAntecedentes(id);
			GrillaFamilia(id);
			GrillaReceta(id);

 }
 //-------------------------------------------------------- 
 function inserta_enfermedad(codigo,enfermedad) {

var id_atencion = $("#id_atencion").val();

	var parametros = {
 					'accion' : 'add' ,
                     'id' : id_atencion, 
                     'enfermedad' : enfermedad
  	  };
  	  

		if (  codigo > 0 ){
			
			if (id_atencion  > 0 ) {
				
				  $.ajax({
								data:  parametros,
								url:   '../model/Model_me_enfermedad.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#ViewEnfermo").html('Procesando');
			  					},
								success:  function (data) {
 									 $("#ViewEnfermo").html(data);   
   			  				
				 				}	
				}); 	
				
			}
			
		}

	
}
//------------
 function inserta_signos() {

var id_atencion = $("#id_atencion").val();

var peso			= $("#peso").val();
var estatura		= $("#estatura").val();
var arterial		= $("#arterial").val();
var cardio			= $("#cardio").val();
var respiratorio	= $("#respiratorio").val();
var temperatura		= $("#temperatura").val();
var so2				= $("#so2").val();
var imc				= $("#imc").val();

var comentario		= $("#comentario").val();
var examen_fisico	= $("#examen_fisico").val();
var revision_organos= $("#revision_organos").val();
        




	var parametros = {
 					 'accion' : 'signos' ,
                     'id' : id_atencion, 
                     'peso' : peso, 
			          'estatura' : estatura, 
			          'arterial' : arterial, 
			          'cardio' : cardio, 
			          'respiratorio' : respiratorio, 
			          'temperatura' : temperatura, 
			          'so2' : so2, 
			          'imc' : imc,
					  'comentario':comentario,
					  'examen_fisico':examen_fisico,
					  'revision_organos':revision_organos
  	  };
  	  

 			
			if (id_atencion  > 0 ) {
				
				  $.ajax({
								data:  parametros,
								url:   '../model/Model_me_atencion.php',
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
//-------------------------------------------------------------------------
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
$("#fatencion").val(fecha);
$("#hora").val(hora);

$("#enfermedad").val('');

$("#id_atencion").val("");
$("#id_prov").val("");
$("#nombre_funcionario").val("");

$("#motivo").val("");
$("#sintomas").val("");
$("#revision_organos").val("");
$("#diagnostico").val("");
$("#examen_fisico").val("");
$("#comentario").val("");
 
 	 $("#edad").val('' );  
	 $("#tsangre").val('' );  
  
$("#estado").val("solicitado");


	 $("#peso").val('0.00' );  
	 $("#estatura").val('0.00' );  
	 $("#arterial").val('000/000' );  
	 $("#cardio").val('0' );  
	 $("#respiratorio").val('0' );  
	 $("#temperatura").val('0' );  
	 $("#so2").val('0' );  
	 $("#imc").val('0' );  
	 
	 	 
  		 
        
 }
//---------------------------
function fecha_hoy()
{

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();

    if(dd < 10){
        dd='0'+ dd;
    } 

    if(mm < 10){
        mm='0'+ mm;
    } 

  
    var today = yyyy + '-' + mm + '-' + dd;
   
 return today;
 
} 
//------------------------------------------------------------------------- 
 function BusquedaGrilla(oTable){        	 

  		var user     = $(this).attr('id');
     	var qestado  = $("#qestado").val();
     	var qunidad  = $("#qunidad").val();
 
     
       var parametros = {
				'qestado' : qestado  ,
				'qunidad' : qunidad 

      };

 
		if(user != '')  { 

		$.ajax({
 		 	data:  parametros,
		    url: '../grilla/grilla_me_atencion',
			dataType: 'json',
			success: function(s){
			oTable.fnClearTable();
			if (s){ 
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
  							'<button class="btn btn-xs btn-warning" title="EDITAR REGISTRO SELECCIONADO"   onClick="goToURL('+"'editar'"+','+"'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
 							'<button class="btn btn-xs btn-danger" title="ELIMINAR REGISTRO SELECCIONADO"  onClick="goToURL('+"'del'"+','+ "'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-remove"></i></button>'   						
 							]);										
 					}  
 			    }						
 			},
 			error: function(e){
 			   console.log(e.responseText);	
 			}
 			});
 		}

  }   
//-----------------
function accion(id, action)
  {
  	 $('#action').val(action);
  	
  	 $('#id_atencion').val(id);
  	 
  	 inserta_signos();
  	
  	 
} 
  
 
/*
*/
 function modulo()
{
 	  
	 var parametros = {

			    'ViewModulo' : modulo_sistema

    };

 
	$.ajax({
			data:  parametros,
			url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ViewModulo").html(data);  
				} 
	});
 
}

// --------------------------------------------
function LimpiaAntecedentes() {
  

 
	var id_atencion = $("#id_atencion").val();
	
	var estado 		= $("#estado").val();


   if ( estado == 'solicitado') {
	
				if ( id_atencion > 0 ){
			
			 		$("#id_atencion_per").val("");
			 		$("#pe_detalle").val("");
			 		$("#pe_tipo").val("");
			 		
 			 		
					$("#action_01").val("add");
					$("#id_atencion_01").val(id_atencion);
				 	$("#myModalAntecedentes").modal('show'); // abre el formulario modal
			 
				}	 
   }	 
}
//---------------
function LimpiarReceta() {
  

 
	var id_atencion = $("#id_atencion").val();
	
	var estado 		= $("#estado").val();


   if ( estado == 'solicitado') {
	
				if ( id_atencion > 0 ){
			
			 		$("#nombre_medicamento").val("");
			 		$("#indicaciones").val("");
			 		$("#cantidad").val("1");
			 		
					 $("#id_atencion_rece").val("");
					 $("#id_id_medicina").val("");
 

					 $("#ViewUso").html("");

					$("#action_03").val("add");
					$("#id_atencion_03").val(id_atencion);
				 	$("#myModalReceta").modal('show'); // abre el formulario modal
			 
				}	 
   }	 
}
//-----------------------------
function LimpiaFamilia() {
  

 
	var id_atencion = $("#id_atencion").val();
	
	var estado 		= $("#estado").val();


   if ( estado == 'solicitado') {
	
				if ( id_atencion > 0 ){
			
			 		$("#id_atencion_per").val("");
			 		$("#pe_detalle").val("");
			 		$("#pe_tipo").val("");
			 		
 			 		
					$("#action_02").val("add");
					$("#id_atencion_02").val(id_atencion);
				 	$("#myModalFamilia").modal('show'); // abre el formulario modal
			 
				}	 
   }	 
}
/*
FUNCION QUE DIBUJA LA GRILLA DEL ACTIVIDADES DE LA BITCORA
*/
function GrillaAntecedentes(id_atencion)
{

 
	if ( id_atencion == -1 ) { 
		  id_atencion = $("#id_atencion").val();
	}

	var parametros = {
			   'id_atencion' : id_atencion 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_me_atencion02.php',
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
GrillaAntecedentes
*/
function GrillaFamilia(id_atencion)
{

 
	if ( id_atencion == -1 ) { 
		  id_atencion = $("#id_atencion").val();
	}

	var parametros = {
			   'id_atencion' : id_atencion 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_me_atencion03.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewGrillaFamilia").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewGrillaFamilia").html(data);  
					
			   } 
   });
	
	 
}
//-----------
function GrillaReceta(id_atencion)
{

 
	if ( id_atencion == -1 ) { 
		  id_atencion = $("#id_atencion").val();
	}

	var parametros = {
			   'id_atencion' : id_atencion 
    };
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/ajax_me_atencion04.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#ViewGrillaReceta").html('Procesando');
			   },
		   success:  function (data) {
					$("#ViewGrillaReceta").html(data);  
					
			   } 
   });
	
	 
}
//------------------------------
  function imc_calculo()
 {
 
 
var peso     = $("#peso").val();
var estatura = $("#estatura").val();
	
 var parcial = parseFloat(estatura).toFixed(2)  * parseFloat(estatura).toFixed(2) ;

 
$("#ViewICM").html(parcial);

if ( parcial > 0 ) {
	
			    var imc = parseFloat(peso).toFixed(2) / parseFloat(parcial).toFixed(2) ;
					
				var calculo_imc = parseFloat(imc).toFixed(2)
				 
				 
				 $("#imc").val(calculo_imc);
				 
				 if ( calculo_imc < 18.5 ) {
					
					    $("#ViewICM").html('Peso inferior al normal	Menos de 18.5');
					 
				 }	else if ( ( calculo_imc  > 18.5) && ( calculo_imc < 24.9) ) {
					
						 $("#ViewICM").html('Peso inferior al normal Normal	18.5 – 24.9');
						 
				  }
				  else if ( ( calculo_imc  > 24.9) && ( calculo_imc < 29.9) ) {
					
						 $("#ViewICM").html('Peso superior al normal	25.0 – 29.9');
						 
				  }
				   else if ( ( calculo_imc  > 24.9) ) {
					
						 $("#ViewICM").html('Obesidad Más de 30.0');
						 
				  }
		 	
	}else {
		
         $("#imc").val('0.00');
    }
}
 
 
/*
*/
 function FormView()
 {

	 $("#ViewForm").load('../controller/Controller_me_atencion.php');

	 $("#ViewSignos").load('../controller/Controller_me_atencion01.php');
  
  	 $("#ViewAntecedente").load('../controller/Controller_me_atencion03.php'); 

	 $("#ViewFamilia").load('../controller/Controller_me_atencion04.php'); 

	 $("#ViewReceta").load('../controller/Controller_me_atencion05.php'); 
  	 
}

//--------
function goToURL_personal(accion,id_atencion_per)
{

   var id_atencion = $("#id_atencion").val();
   
	$("#action_01").val(accion);
	
    $("#id_atencion_01").val(id_atencion);


	var parametros = {
			   'id' : id_atencion_per ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/Model_me_atencion02.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarAntecedente").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarAntecedente").html(data);  
					
			   } 
   });
	
   $("#myModalAntecedentes").modal('show'); // abre el formulario modal

}   
//------------------
function goToURL_familia(accion,id_atencion_fami)
{

   var id_atencion = $("#id_atencion").val();
   
	$("#action_02").val(accion);
	
    $("#id_atencion_02").val(id_atencion);


	var parametros = {
			   'id' : id_atencion_fami ,
			   'accion' : accion 
    };
	 
	 
	 
   $.ajax({
		   data:  parametros,
			url:   '../model/Model_me_atencion03.php',
		   type:  'GET' ,
			   beforeSend: function () { 
					   $("#guardarFamilia").html('Procesando');
			   },
		   success:  function (data) {
					$("#guardarFamilia").html(data);  
					
			   } 
   });
	
   $("#myModalFamilia").modal('show'); // abre el formulario modal

}   
//-----------------------  
function goToURL_enfermo(accion,id_atencion_enf) {

	 
   var id_atencion = $("#id_atencion").val();
   
   var estado = $("#estado").val();

	var parametros = {
 				 	 'accion' : accion ,
                     'id' : id_atencion, 
                     'id_atencion_enf' : id_atencion_enf
  	  };


  if ( estado == 'solicitado'){
	
				   $.ajax({
											data:  parametros,
											url:   '../model/Model_me_enfermedad.php',
											type:  'GET' ,
						 					beforeSend: function () { 
						 							$("#ViewEnfermo").html('Procesando');
						  					},
											success:  function (data) {
			 									 $("#ViewEnfermo").html(data);   
			   			  				
							 				}	
							}); 	
	  }
  }
  
/*
*/
 function go_enfermo(id_atencion)
{
 	  
	var parametros = {
 				 	 'accion' : 'visor' ,
                     'id' : id_atencion 
  	  };


 
  $.ajax({
											data:  parametros,
											url:   '../model/Model_me_enfermedad.php',
											type:  'GET' ,
						 					beforeSend: function () { 
						 							$("#ViewEnfermo").html('Procesando');
						  					},
											success:  function (data) {
			 									 $("#ViewEnfermo").html(data);   
			   			  				
							 				}	
							}); 	
 
}