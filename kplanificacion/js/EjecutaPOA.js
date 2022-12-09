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
			 
			busqueda_Objetivos_tarea();
			
			busqueda_Objetivos_Articulacion( );
 
			poa_resumen ();
			
			busqueda_Objetivos_indicador();
			
			 
		 });
		
 
 
});  
 
//------------------
function busqueda_Objetivos_Articulacion( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
     };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-OOtreeVisor.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#UnidadObjetivoArticula").html('Procesando');
				},
			success:  function (data) {
					 $("#UnidadObjetivoArticula").html(data);  
				     
				} 
	});
 
}
//--------------------------------------------------------------------------
//------------------
function busqueda_Objetivos_indicador( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
     };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-OOIndicadorVisor.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#UnidadObjetivoIndicador").html('Procesando');
				},
			success:  function (data) {
					 $("#UnidadObjetivoIndicador").html(data);  
				     
				} 
	});
 
}
//-------------------------------------------------------------------------
function poa_resumen ( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
   
      
 
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
    };
	 
	  
	 $.ajax({
		    type:  'GET' ,
			data:  parametros,
			 url:   '../model/ajax_resumen_poa.php',
			dataType: "json",
			success:  function (response) {

				     $("#techo").html( response.a );  
					 $("#inicial").html( response.b );  
 					 $("#ejecutado").html( response.c );  
 					 $("#ejecutadop").html( response.d );  
					 
				     $("#nobjetivos").html( response.e );  
					 $("#nindicadores").html( response.f );  
 					 $("#ntareas").html( response.g );  
 					 $("#ntareasp").html( response.h );  
			} 
	});
 
	
} 
//-------------------------------------------------------------------------
//-----------------
function FormView()
{
   
	 
	 $("#ViewFiltro").load('../controller/Controller-poa_filtro.php');
	 
	 
	 $("#ViewForm").load('../controller/Controller-actividad.php');
	 
 
 	
 	 
}

//-------------------
function poneObjetivosUnidad( )
{
	
// filtro para poner los objetivos de la unidad	
	 
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
           $('#IDOBJETIVO').html(response);
       }
	 });
	 
}
 
//-------------------
function VerTarea( idtarea )
{
	
// filtro para poner los objetivos de la unidad	
	 
	 
	var parametros = {
				 'idtarea'  : idtarea 
	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../controller/Controller_ver_tarea.php",
		 type: "GET",
       success: function(response)
       {
           $('#ViewFormTarea').html(response);
       }
	 });
	 
}
//---------------------

function SiguientePaso( idtarea1 ,idtarea_seg,idtarea_segcom)
{
	
// filtro para poner los objetivos de la unidad	
$("#idtarea1").val( idtarea1 );
$("#idtarea_seg").val( idtarea_seg );
$("#idtarea_segcom").val( idtarea_segcom );
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom
    };
 
	$.ajax({
				data:  parametros,
				 url:   '../controller/Controller_ver_tarea_paso.php',
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormComentario").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormComentario").html(data); 
					     
					} 
		});
 
	 
}
//--------

function SiguienteProceso( )
{
	
// filtro para poner los objetivos de la unidad	
var idtarea1 			= $("#idtarea1").val(  );
var idtarea_seg 		= $("#idtarea_seg").val(  );
var idtarea_segcom 		= $("#idtarea_segcom").val(  );

var secuencia_next			= $("#secuencia_next").val(  );
var idtarea_segcom_next		= $("#idtarea_segcom_next").val(  );
var comentario_dato         = $("#comentario_dato").val(  );


var proceso = $("#proceso_nombre").val();
 
	 
	  var parametros = {
			    'idtarea1' : idtarea1,
			    'idtarea_seg':idtarea_seg,
			    'idtarea_segcom':idtarea_segcom,
			    'secuencia_next':secuencia_next,
			    'idtarea_segcom_next':idtarea_segcom_next,
			    'comentario_dato':comentario_dato
    };
 
 
 if(confirm("Desea guardar y enviar el proceso seleccionado?"))
	{
	              	$.ajax({
										data:  parametros,
										 url:   '../model/ajax_tarea_ejecuta.php',
										type:  'POST' ,
											beforeSend: function () { 
													$("#guardarDatosCom").html('Procesando');
											},
										success:  function (data) {
												    $("#guardarDatosCom").html(data); 
												    
												    busqueda_proceso (proceso );
						 					} 
								});
	}
	else
	{
	   return false;
	}
 
}

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

//---------------------
function busqueda_proceso (proceso )
{
 
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 
 $("#proceso_nombre").val(proceso);
 
 
	 var parametros1 = {
			    'proceso'  : proceso ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
 };
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model_seg_proceso.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#PendientesVisor").html('Procesando');
			},
		success:  function (data) {
				 $("#PendientesVisor").html(data);   
			     
			} 
    });

	
}