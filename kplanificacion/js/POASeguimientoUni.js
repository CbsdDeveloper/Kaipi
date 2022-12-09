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
		 
 
		VisorObjetivosUser();

		$('#load').on('click',function(){
			 
	 	//	VisorObjetivos();
	 		
	 	    VisorObjetivosUser();
 
		 });
		
 
 
});  
 
//------------------
function busquedaArticulado ( )
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
						$("#UnidadArticula").html('Procesando');
				},
			success:  function (data) {
					 $("#UnidadArticula").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
 
}
//-------------------------------------------------------------------------
function poa_resumen ( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
 
       
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
   
	  	 
	   $("#ViewForm").load('../controller/Controller-actividad_ejecuta.php');
	 
 	   $("#ViewFormCompras").load('../controller/Controller_tarea_seg01.php');
 	 

	   $("#ViewFormTarea").load('../controller/Controller_tarea_seg02.php');
}

 
 
//-------------------
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

//---------------------../model/Model_tarea_seg01.php
function busquedatarea ( tarea )
{
 
	 var parametros = {
			    'tarea'  : tarea  
 };
	  
 
 
 	$.ajax({
		data:  parametros,
		 url:   '../controller/Controller_menu_datos_tarea.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#VisorTarea").html('Procesando');
			},
		success:  function (data) {
				 $("#VisorTarea").html(data);  
			     
			} 
    });

   
 
	VisorTareas ( tarea );
    
    VerAvance(0,0);
   

	 $('#mytabs a[href="#tab2"]').tab('show');
	
 	 $('#my_tabs_evento a[href="#menu_evento01"]').tab('show');
	
}
//-------------------
//---------------------
function VisorObjetivos ( )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDADPADRE").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
    
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
};
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_TAREA_SEG.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAMatrizOO").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
			     
			} 
  });
 

}
//--------------

function LlamaVariables ( seg_tarea1 ,seg_tarease1    )
{
 
	$("#seg_tarea1").val(seg_tarea1);
	$("#seg_tarease1").val(seg_tarease1);
	$("#seg_comentario").val('');

}
//------------
function VerPoa(tarea,segtarea,estado)
{

	 
	 if ( estado == 'ejecucion'){
		
		 var enlace = '../../reportes/aval_poa?id='+tarea+'&seg='+segtarea ;
		  
		 window.open(enlace,'#','width=750,height=480,left=30,top=20');
	}
 

}
//--------
function VerAvance ( seg_tarea1 ,seg_tarease1    )
{
 
 
		 var parametros1 = {
					'idtarea'  : seg_tarea1  ,
					'seg_tarease1': seg_tarease1
				}
		 
		$.ajax({
			data:  parametros1,
			 url:   '../model/ajax_tarea_avance.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#Seguimiento_tarea").html('Procesando');
				},
			success:  function (data) {
					 $("#Seguimiento_tarea").html(data);   
					 
				} 
	  });
 
 
 	  if ( seg_tarease1 > 0 ){
			$('#my_tabs_evento a[href="#menu_evento03"]').tab('show');
      }
	  


}
//----------------------
function Confirmar(e){
	
var mensaje = "Desea enviar el requerimiento para ejecuccion...";

    if (!confirm(mensaje)){
    e.preventDefault();
	}
}
 
 
//-----------
function VisorTareas ( idtarea )
{

 if ( idtarea == 0){
	idtarea  = $("#idtarea_matriz").val();
} 
	 var parametros1 = {
			    'idtarea'  : idtarea  
};
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/ajax_tarea_seg01.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewFormActividades").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewFormActividades").html(data);  // $("#cuenta").html(response);
			     
			} 
  });
 

}
//----------------------
function VisorObjetivosUser ( )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDADPADRE").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
    
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
};
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_TAREA_User.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAUser").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAUser").html(data);  
			     
			} 
  });
 

}
/*
*/
function VisorObjetivosUserTar (idprov )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDADPADRE").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
    
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO ,
			    'idprov':idprov
};
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_TAREA_SEG_U.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAMatrizOO").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAMatrizOO").html(data);  
			     
			} 
  });
 

}
/*
*/ 
function InicioProceso01 ( )
{
	
	
	    // abre el formulario modal
		
		$("#myModal").modal('show'); 
		 

		var idtarea_matriz  = $("#idtarea_matriz").val();
		var idpac_matriz 	= $("#idpac_matriz").val();
		var modulo          = $("#modulo").val();
 
		$("#idtarea").val(idtarea_matriz);
		$("#idpac").val(idpac_matriz);
		$("#seg_proceso").val(modulo);
	 

		var fecha = fecha_hoy();

		$("#seg_fecha").val(fecha);
		$("#seg_tarea_seg").val('');
		$("#seg_solicitado").val('0.00');

		$("#action_02").val('add');
		
		var codificado    = $("#codificado").val();  
		var certificacion = $("#certificacion").val();  

		var total1 = parseFloat(codificado).toFixed(2)  ;
		var total2 = parseFloat(certificacion).toFixed(2)  ;

		var total3 = total1 - total2;

		$("#saldo_tarea").val(total3);
		
	 
 
}
//-----------------------------------
function InicioProceso02 ( )
{
	
	
	    // abre el formulario modal
		
		$("#myModalTarea").modal('show'); 
		 

		var idtarea_matriz  = $("#idtarea_matriz").val();
		var idpac_matriz 	= $("#idpac_matriz").val();
		var modulo          = $("#modulo").val();
 
		$("#idtarea1").val(idtarea_matriz);
 		$("#seg_proceso1").val(modulo);
	 

		var fecha = fecha_hoy();

		$("#seg_fecha1").val(fecha);
		$("#seg_tarea_seg1").val('');
 
		$("#action_03").val('add');
		
		 
		
	 
 
}
//-------------------------------------
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