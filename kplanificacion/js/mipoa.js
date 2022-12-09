$(function() {
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
 
});

//-------------------------------------------------------------------------
$(document).ready(function(){
     
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		$("#FormPie").load('../view/View-Pie.php');
		
		modulo();
 		
		FormView();
	   
 
		$('#load').on('click',function(){
			 
		 	busquedaObjetivos();
 
			VisorObjetivos()
			
			goToURLDatoOO() ;
 			
			busquedaIndicadores ();
			
		 });
		
  
});  
//-----------
function PonePac() {
	   
	   
	     var value =  $('#enlace_pac option:selected').html()
 
 
           $('#tareapac').val(value);
    
	 
}
//-----------
function ListaPac() {
	   
 var parametros = {
			 'unidad'  : 0  
  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_lista_pac.php",
		 type: "GET",
       success: function(response)
       {
           $('#enlace_pac').html(response);
       }
	 });
 
	 
}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
				 
					$("#result").html("Ingrese la información requerida");
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
// ir a la opcion de editar
function DetalleOpcion() {
 
    var id =   $('#id_par_modulo').val();
 
     var parametros = {
                    'id' : id 
 	  };
     
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-admin_opcion_det.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#opcionModulo").html('Procesando');
  					},
					success:  function (data) {
							 $("#opcionModulo").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
  //--------------------------------------------------------------------	
 function verifica_ii() {

}
//-------------
function PoneObjetivoI()
{
 
 
var id_dato      = $('#Q_IDUNIDAD').val();

var idperiodo =   $('#Q_IDPERIODO').val();
	
 
  var parametros = {
			    'codigo'    : id_dato ,
			    'idperiodo' : idperiodo
   };
	  
 
  $.ajax({
		  data: parametros,
		  url:   '../model/Model-UnidadObjIndicador.php',
		  type: "GET",
		  success: function(response)
		  {
			  $('#idobjetivo_indicador').html(response);
		  }
	  });
	  
 
 
}
///--------
//-------------------
function LimpiarPantallaIndicador() 
{
	 
	var qanio        =   $('#Q_IDPERIODO').val();
	
	var id_dato      = $('#Q_IDUNIDAD').val();

 	
    $("#anio_indicador").val(qanio);
  	
	$("#id_departamento_indicador").val(id_dato);
	
	$("#actionindicador").val("add");
	
	$("#anio_indicador").val(qanio);

	  

		$("#id_idobjetivoindicador").val("");
		$("#idobjetivo_indicador").val("");
 		$("#indicador").val("");
		$("#detalle").val("");
		$("#tipoformula").val("");
		
	 	$("#idperiodo_indicador").val("");
	 	
		$("#estado2").val("S");
		$("#periodo").val("");
 		$("#variable1").val("");
		$("#variable2").val("");
		$("#formula").val("");
		$("#meta").val("");
		$("#medio").val("");
		
		 
 
		$("#actionindicador").val("add");
	 
}
//-------------
function goToIndicador(vid) {

	 
    var action =  "visor"; 
    var id  =  vid  ;
    
   
   
    var parametros = {
					'actionindicador' : action ,
                    'id' :id 
	  };

	   $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OO-indicador_uni.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#resultadoIndicador").html('Procesando');
					},
					success:  function (data) {
						
							 $("#resultadoIndicador").html(data);   
						     
						   
					} 
			}); 
 
}
//---------
function accionIndicador(id,modo)
{
 
  	 $("#actionindicador").val(modo);
 
	 $("#id_idobjetivoindicador").val(id);
	   
	 
   
}

//-----------------
function FormView()
{
   
	 
	 $("#ViewFiltro").load('../controller/Controller-poa_filtro.php');
	 
	 
	 $("#ViewForm").load('../controller/Controller-actividad.php');
	 
	 
	 $("#ViewFormTareas").load('../controller/Controller-tarea.php');
	 
 
 	 $("#result").html('Desea agregar información');
 	
 	
 	 $("#ViewFormOO").load('../controller/Controller-objetivoo_uni.php');
 	 
 	 $("#ViewFormIndicador").load('../controller/Controller-objetivo_indicador.php');
 	 
}
 
function accion(id,modo)
{
 
  	 $("#action").val(modo);
  
	 
	 $("#idactividad").val(id);
 
	 VisorActividad( );
	
	 
}

function accionTarea(id,modo)
{
 
  	 $("#actionTarea").val(modo);
  
	 
	 $("#idtarea").val(id);
 
      VisorObjetivos ( );
	 
}

//------------

function accion_oo(id,modo)
{
 
  	 $("#actionoo").val(modo);
  
	 
	 $("#idobjetivoo").val(id);
 
     // VisorObjetivos ( );
	 
}

//---------
function LimpiarPantalla_oo( )
{

	var id_dato      = $('#Q_IDUNIDAD').val();


 	$("#actionoo").val('add');
 	
 	$("#idobjetivo").val("");
 	

   
 	$("#idestrategia").val("");
 	$("#objetivo").val("");
 	$("#estadoo").val("");
 	$("#anio").val("");
 	 
 	$("#resultoo").html('[ <img src="../../kimages/m_verde.png" align="absmiddle"><b>   AGREGAR NUEVO OBJETIVO... VERIFIQUE LA INFORMACION </b>');
 
 
  	$("#id_departamentoo").val(id_dato);
   

  	
  
}
 //-------------------
function LimpiarPantalla( )
{

    var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
    
    var Q_IDPERIODO =  $("#Q_IDPERIODO").val();

	poneObjetivosUnidad( );

     
 	$("#anio").val(Q_IDPERIODO);
 	
 	$("#id_departamento").val(Q_IDUNIDAD);
 	
    $("#action").val('add');
  
  	
 	$("#idactividad").val("");
 	
 	$("#producto").val("");

 	$("#idperiodo").val("");
 	$("#actividad").val("");
 	$("#aportaen").val("actividad");
 	
 	$("#beneficiario").val("Funcionarios");
 		
 	$("#estado").val("S");

 
 	poneObjetivosIndicadores( );
 

 	
 	
  
}
//-------------------
function poneObjetivosUnidad( )
{
	
// filtro para poner los objetivos de la unidad	
	
 //	$("#idobjetivo").select2({dropdownCssClass : 'bigdrop'});
 	

	 
	var Q_IDUNIDAD  =  $("#Q_IDUNIDAD").val();
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
		
	var parametros = {
				 'Q_IDUNIDAD'  : Q_IDUNIDAD ,
	             'Q_IDPERIODO' : Q_IDPERIODO 
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-ooFiltro.php",
		 type: "GET",
       success: function(response)
       {
           $('#idobjetivo').html(response);
       }
	 });
	 
 	 
	 
}
/**/

function Notificacion( Q_IDUNIDAD)
{
	
//filtro para poner los objetivos de la unidad	
	 
var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 
 
	
	
	var parametros = {
				 'Q_IDPERIODO'  : Q_IDPERIODO ,
				 'Q_IDUNIDAD'  : Q_IDUNIDAD
 	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/ajax_envio_poa.php",
		 type: "GET",
     success: function(response)
     {
			alert('Enviado');
     }
	 });
	 
}

//-------------------poneObjetivosIndicadores( )
function poneObjetivosIndicadores( )
{
	
//filtro para poner los objetivos de la unidad	
	 
	var Q_OBJETIVO =  $("#idobjetivo").val();
 
	var Q_IDUNIDAD  =  $("#Q_IDUNIDAD").val();
	
	
	var parametros = {
				 'Q_OBJETIVO'  : Q_OBJETIVO ,
				 'Q_IDUNIDAD'  : Q_IDUNIDAD
 	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-ooFiltroIndicador.php",
		 type: "GET",
     success: function(response)
     {
         $('#idobjetivoindicador').html(response);
     }
	 });
	 
}
//-------------------
function poneUnidadIndicadores( )
{
	
//filtro para poner los objetivos de la unidad	
	/*
 	$("#idobjetivo_indicador").select2({dropdownCssClass : 'bigdrop1'});
	 
	var Q_OBJETIVO =  $("#idobjetivo").val();
 	var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
	 
	
	var parametros = {
				 'Q_OBJETIVO'  : Q_OBJETIVO ,
				 'Q_IDUNIDAD'  : Q_IDUNIDAD	
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-ooFiltroIndicador.php",
		 type: "GET",
   success: function(response)
   {
       $('#idobjetivo_indicador').html(response);
   }
	 });
	 
	 */
}
 
//--------------
function fecha_hoy(inicio)
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
  
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 	
    
 	if ( inicio == 1) {
 		
 		  var today = Q_IDPERIODO + '-' + '12' + '-01' ;
 		
 	}else{
 		
 		  var today = Q_IDPERIODO + '-' + mm + '-' + dd;
 	}
  
    
    return today;
 
} 
 

//-------------------
function LimpiarPantallaTarea( idactividad )
{

    var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
    
    var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 
    
    	 $("#nombre_funcionario").val( '' );
 
 
    $("#programa_unidad").val(Q_IDUNIDAD);
    
 	
    $("#actionTarea").val('add');
     
    //-----------------------------------------------------------------

var fecha1 =  fecha_hoy(0);
var fecha2 =  fecha_hoy(1);

	 		 
		 $("#fechainicial").val(fecha1 );
		 $("#fechafinal").val( fecha2 );
 
		 $("#recurso").val("");
		 
		  $("#justificacion").val("-");
		  $("#clasificador1").val("-");
		  $("#clasificador2").val("-");
		  
		  $("#responsable").val("");
		  	  	  
		  	  	  
		  	  	  
 		 
	 
		 $("#idtarea").val("");
		 $("#idactividad_tarea").val( idactividad);
		 $("#estado1").val("S");
		 $("#tarea").val("");
		 $("#clasificador").val("-");		
		 
		 $("#anio_tarea").val(Q_IDPERIODO);	
		 
		 
		  var resultado =  `<div class="alert alert-success"><img src="../../kimages/if_error_36026.png" align="absmiddle" />&nbsp;<strong>AGREGAR NUEVO REGISTRO DE TRANSACCION</strong>   COMPLETE LA INFORMACION PARA GUARDAR LA INFORMACION </div>`;
  
 	$('#resultadoTarea').html(resultado);
 	
    $('#m1').attr('readonly', true);
    $('#m2').attr('readonly', true);
    $('#m3').attr('readonly', true);
    
    $('#m4').attr('readonly', true);
    $('#m5').attr('readonly', true);
    $('#m6').attr('readonly', true);
    
    $('#m7').attr('readonly', true);
    $('#m8').attr('readonly', true);
    $('#m9').attr('readonly', true);
    
    $('#m10').attr('readonly', true);
    $('#m11').attr('readonly', true);
    $('#m12').attr('readonly', true);
    

    $('#m1').val(0.00);
    $('#m2').val(0.00);
    $('#m3').val(0.00);
    
    $('#m4').val(0.00);
    $('#m5').val(0.00);
    $('#m6').val(0.00);
    
    $('#m7').val(0.00);
    $('#m8').val(0.00);
    $('#m9').val(0.00);
    
    $('#m10').val(0.00);
    $('#m11').val(0.00);
    $('#m12').val(0.00);
    
    $('#TOTALPOA').val(0.00);
    
    $('#TOTALPOA1').val(0.00);
    
    
    
}
//-------------------
function LimpiarMontos( )
{

   
  $('#m1').val(0.00);
  $('#m2').val(0.00);
  $('#m3').val(0.00);
  
  $('#m4').val(0.00);
  $('#m5').val(0.00);
  $('#m6').val(0.00);
  
  $('#m7').val(0.00);
  $('#m8').val(0.00);
  $('#m9').val(0.00);
  
  $('#m10').val(0.00);
  $('#m11').val(0.00);
  $('#m12').val(0.00);
  
  $('#TOTALPOA').val(0.00);
  
 
}
 
//---------------------
//---------------------
function modulo ( )
 {
	
	var modulo_sistema =  'kplanificacion';
	 
	 var parametros = {
			    'ViewModulo' : modulo_sistema 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
	
 }
//---------------
function RefrescaMatriz ( )
{
	
	  var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
	
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO ,
				'tipo':1
      };
	  
	 
	  $.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_MATRIZ.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAMatrizOO").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAMatrizOO").html(data); // PONE OBJETIVOS Y MATRIZ POA

			     
			} 
    });
}	
//---------------------
function busquedaObjetivos ( )
{
 
  	    var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
      
      	//var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
  		 $("#id_departamentoo").val(Q_IDUNIDAD);
  		 
  
  		PoneObjetivoI();
  		
  		
  		poneObjetivosUnidad( );
  		
  		poneObjetivosIndicadores();
  
   		ListaPac() ;
  
  		VisorActividad();
   
}
//-------------------
function VisorActividad( )
{
	
	  var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
    
    
	var parametros5 = {
					 'Q_IDUNIDAD'  : Q_IDUNIDAD ,
		             'Q_IDPERIODO' : Q_IDPERIODO 
		   };
			 
			 $.ajax({
				 data:  parametros5,
				 url: "../model/Model-ooTareaActividad.php",
				 type: "GET",
		        success: function(response)
		        {
		            $('#idactividad_tarea').html(response);
		        }
			 });
			 
}
//-----------------------
function PoneActividad( codigo_programa)
{
	
	 
    
	var parametros5 = {
					 'codigo_programa'  : codigo_programa 
		   };
			 
			 $.ajax({
				 data:  parametros5,
				 url: "../model/ajax_dato_actvividad.php",
				 type: "GET",
		        success: function(response)
		        {
		            $('#actividad_tarea').html(response);
		        }
			 });
			 
}
//---------------
function BuscaCatalogo( valor,tipo)
{
	
	 if ( tipo == 1 ){
		var variable = '#clasificador2';
	}else{
		var variable = '#clasificador';
	}
	 
	 
 var variable = '#clasificador';
	 
    
 var parametros = {
			 'tipo'  : 2,
			 'valor' : valor
  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_lista_presupuesto.php",
		 type: "GET",
       success: function(response)
       {
           $(variable).html(response);
       }
       
	 });
			 
}
//---------------------
function VisorObjetivos ( )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
    
 	 $("#id_departamentoo").val(Q_IDUNIDAD);
 	  	
 	  	
	tipo  = 1;
 
 var parametros1 = {
	'Q_IDUNIDAD'  : Q_IDUNIDAD ,
	'Q_IDPERIODO' : Q_IDPERIODO,
	'tipo' : tipo
};


	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_MATRIZ.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAMatrizOO").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
			     
			} 
  });
 
	//-----------------------------------
 
  /*
	
	var parametros1 = {
				 'Q_OBJETIVO'  : 0 ,
				 'Q_IDUNIDAD'  : Q_IDUNIDAD	
	  };
	 
	 $.ajax({
		 data:  parametros1,
		 url: "../model/Model-ooFiltroIndicador.php",
		 type: "GET",
   success: function(response)
   {
       $('#idobjetivo_indicador').html(response);
   }
	 });
	
	*/
	
	

}
//----------------------
function habilitaperiodo (tipo )
{
 
	  var fecha 			=   $("#fechafinal").val();
	  
	 var fechainicial    	=   $("#fechainicial").val();
	  
	  
	  var validatarea 	    = 	$("#recurso").val();
	  var str 				= validatarea.trim();
	  var i;
	  
	  var array_fechasol = fecha.split("-") 
	  var month = parseInt(array_fechasol[1])  ;
	 
	  var array_fechaso2 = fechainicial.split("-") 
	  var month0 = parseInt(array_fechaso2[1])  ;
	 
	  
	  var objeto='m';


	  
	 	  
	 if (str  == 'S'){
		 
 		  $("#clasificador").removeAttr('disabled');
		 
		  for (i=1;i<=12;i++) { 
			  
			  	objeto = '#m' + i;
			  	
			  	 $(objeto).attr('readonly', true);
			  	
			  }  
			  
		    for (i=month0;i<=month;i++) { 
			  
			  	objeto = '#m' + i;
			  	
			  	 $(objeto).attr('readonly', false);
			  	
			  }   
			  
			  
	 }else{
		 
		 $("#clasificador").attr('disabled', 'disabled');
		  
		 for (i=1;i<=12;i++) { 
			  
			  	objeto = '#m' + i;
			  	
			  	 $(objeto).attr('readonly', true);
			  	
			  }  
		
		 	 
 
	 }

 
	 
 

}
//-------------------
function anular_iinformacion ( )
{

     var id_idobjetivoindicador =  $("#id_idobjetivoindicador").val();
  
 	  var Q_IDPERIODO 			=  $("#Q_IDPERIODO").val();
 	
	  var parametros = {
					 'actionindicador' : 'eliminar' ,
	                 'id_idobjetivoindicador' : id_idobjetivoindicador,
	                 'id': Q_IDPERIODO
 		  };
	  
		  $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OO-indicador_uni.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#resultadoIndicador").html('Procesando');
					},
					success:  function (data) {
						
							 $("#resultadoIndicador").html(data);   
						     
						   
					} 
			}); 
   
			busquedaIndicadores ();
}
//-------------------
function anular_ainformacion ( )
{

     var idactividad =  $("#idactividad").val();
 
 
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 	
	  var parametros = {
					 'action' : 'eliminar' ,
	                 'idactividad' : idactividad,
	                 'id': Q_IDPERIODO
 		  };
	  
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-ActividadPOA.php',
						type:  'POST' ,
						beforeSend: function () { 
								$("#result").html('Procesando');
						},
						success:  function (data) {
								 $("#result").html(data);  // $("#cuenta").html(response);
							     
							     RefrescaMatriz();
						} 
				}); 
		
   
	
}
//----------------
function busquedaIndicadores ( )
{
	
 	
      var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
      
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
       $("#anio_indicador").val(Q_IDPERIODO);
      
       $("#id_departamento_indicador").val(Q_IDUNIDAD);
      
      
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
     };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-OOtree_uni.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#UnidadArticula").html('Procesando');
				},
			success:  function (data) {
					 $("#UnidadArticula").html(data);  
				     
				} 
	});
	
 
	
 
}
 
//-----------------
function anular_oo ( )
{

 	
    var idobjetivoo =  $("#idobjetivoo").val();
 	var id 			=  $("#Q_IDPERIODO").val();
  
 
				var parametros = {
							'actionoo' : 'eliminar',
							'idobjetivoo': idobjetivoo,
						    'id' : id 
			    };
				  
				 
				  $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OO_uni.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#resultoo").html('Procesando');
					},
					success:  function (data) {
							 $("#resultoo").html(data);   
						     
						     goToURLDatoOO();
					} 
			}); 
 
	
}

//-------------------
function anular_informacion ( )
{

 	
    var idtarea =  $("#idtarea").val();
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  


				var parametros = {
							'actionTarea' : 'eliminar',
							'Q_IDPERIODO': Q_IDPERIODO,
						    'idtarea' : idtarea 
			    };
				  
				 
				$.ajax({
					data:  parametros,
					 url:   '../model/Model-OO-tarea.php',
					type:  'POST'  ,
					success:  function (data) {
			
						 $("#resultadoTarea").html(data);  
			
						RefrescaMatriz();
			
			 			} 
			 });
 
	
}

//----------------------
function PoneValida ( )
{

 
	
    var IDACTIVIDAD =  $("#IDACTIVIDAD1").val();
  	
	var parametros = {
			    'IDACTIVIDAD' : IDACTIVIDAD 
    };
	  
	 
	$.ajax({
		data:  parametros,
		 url:   '../model/Model-OO-POA_VAL_TAREA.php',
		type:  'GET'  ,
		success:  function (data) {
			 $("#validatarea").val(data);  
 			} 
 });
 
   
	
}
//----------------------
 //----------------------
function PoneBoton ( )
{

	var validaBoton ='-' ;
	
	 
	validaBoton =  $("#recurso").val();  
	
	var str = validaBoton.trim();
	
	if ( str == 'N') {
		
		 $('#BotDet').attr('disabled', true);
	
		$("#modulo").val('tareas');  
	 
	  
 	     
	 
	}else{
	
		 
		 $('#BotDet').attr('disabled', false);
	
		 $("#clasificador").val('-');  

		 habilitaperiodo('S');
   
		 
	 
		 $("#modulo").val('requerimiento');  

	}
 

}
//----------------------
//----------------------
function TotalSuma ( )
{

	var TotalSuma1 = 0;
	var TotalSuma2 = 0;
	
	TotalSuma1 = 	parseFloat( $('#m1').val() ) + parseFloat( $('#m2').val() ) +  parseFloat( $('#m3').val() ) +
					parseFloat( $('#m4').val() ) + parseFloat( $('#m5').val() ) +  parseFloat( $('#m6').val() ) +
					parseFloat( $('#m7').val() ) + parseFloat( $('#m8').val() ) +  parseFloat( $('#m9').val() ) +
					parseFloat( $('#m10').val() ) + parseFloat( $('#m11').val() ) +  parseFloat( $('#m12').val() ) ;

	
  
	$("#TOTALPOA").val(TotalSuma1);  
	
	
//	TotalSuma2 = number_format(TotalSuma1,2);
	
	TotalSuma2 =  TotalSuma1 ;
	
	
	$("#TOTALPOA1").val(TotalSuma2);  
	 
 
}
//----------------------
//----------------------
function valorMes (objeto,valor )
{

	var ccobjeto = '#' + objeto;
	
	$(ccobjeto).val(valor) ;
	 

}
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToActividad(action,id) {


	  var visor= 'S';
 
 
 
	  var parametros = {
					 'action' : action ,
	                 'id' : id ,
	                 'visor': visor
		  };
	  
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-ActividadPOA.php',
						type:  'POST' ,
						beforeSend: function () { 
								$("#result").html('Procesando');
						},
						success:  function (data) {
								 $("#result").html(data);  // $("#cuenta").html(response);
							     
						} 
				}); 
		
 
	  $("#action").val(action);
		  	  	  

 }
 //------------ PONE PARA INSERTA OBJETIVOS
 function goToURLDatoOO() {
	
	 
	     var id  	  =  $('#Q_IDUNIDAD').val();
	     var periodo  =  $('#Q_IDPERIODO').val();
	     
	    

 
	     
	     var parametros = {
 	                   'id' 	:id ,
 	                   'periodo':periodo
		  };
	 
	 	   $.ajax({
						data:  parametros,
				    	url:   '../model/Model-DatoUnidadOO_uni.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
								$("#ViewPOAObjetivo").html('Procesando');
	 					},
						success:  function (data) {
								 $("#ViewPOAObjetivo").html(data);   
							     
	 					} 
				}); 
	 	   
 		 
 }	 
//------------------------------------------------------------------------
function goToURLArbol(vid) {

 
    var action =  "visor" 
    var id  =  vid  ;
   
    var parametros = {
					'actionoo' : action ,
                    'id' :id 
	  };

	   $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OO_uni.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#resultoo").html('Procesando');
					},
					success:  function (data) {
							 $("#resultoo").html(data);   
						     
					} 
			}); 
 
} 
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToTarea(action,id) 
{

	 var visor= 'S';
	
	 ListaPac();
	 LimpiarMontos();
	  
	
	 var parametros = {
					 'actionTarea' : action ,
	                 'id' : id ,
	                 'visor': visor
		  };
		  
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-OO-tarea.php',
						type:  'POST' ,
						beforeSend: function () { 
								$("#resultadoTarea").html('Procesando');
						},
						success:  function (data) {
								 $("#resultadoTarea").html(data);  // $("#cuenta").html(response);
							     
						} 
				}); 
				
				
	$("#clasificador1").val("-");
	$("#clasificador2").val("-");
	
	if ( action == 'add'){
		
	   LimpiarMontos();
		  
	}	
	   $("#actionTarea").val('editar');

}
 

//--------
function ResumenPOA(departamento) 
{

 
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  
	enlace = '../../reportes/resumen_acta_poa.php?id=' + departamento + '&periodo=' + Q_IDPERIODO ;
  
  
	window.open(enlace,'#','width=950,height=520,left=30,top=20');
	   

}
//---------------
function ResumenPAPP(departamento) 
{

 
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  
	enlace = '../../reportes/resumen_papp_poa.php?id=' + departamento + '&periodo=' + Q_IDPERIODO ;
  
  
	window.open(enlace,'#','width=950,height=520,left=30,top=20');
	   

}
//----------------------------------------------
function ResumenPOA_O(departamento) 
{

 
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  
	enlace = '../../reportes/resumen_obj_poa.php?id=' + departamento + '&periodo=' + Q_IDPERIODO ;
  
  
	window.open(enlace,'#','width=950,height=520,left=30,top=20');
	   

}
	