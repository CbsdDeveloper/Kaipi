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
			
			busquedaArticulado ( );
 
			 
		 });
		
 
 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	//	$('#mytabs a[href="#tab2"]').tab('show');
                	
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
function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return amount_parts.join('.');
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
 

//-----------------
function FormView()
{
   
	 
	 $("#ViewFiltro").load('../controller/Controller-poa_filtro.php');
	 
	 
	 $("#ViewForm").load('../controller/Controller-actividad.php');
	 
	 
	 $("#ViewFormTareas").load('../controller/Controller-tarea.php');
	 
 
 	 $("#result").html('Desea agregar información');
 	
 	 
}
 
function accion(id,modo)
{
 
  	 $("#action").val(modo);
  
	 
	 $("#IDACTIVIDAD").val(id);
 
	 VisorObjetivos ( );
	 
}

function accionTarea(id,modo)
{
 
  	 $("#actionTarea").val(modo);
  
	 
	 $("#IDTAREA").val(id);
 
	 VisorObjetivos ( );
	 
}

 //-------------------
function LimpiarPantalla( )
{

    var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
    
    var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
     
    
    $("#action").val('add');
 	 
 	$("#IDACTIVIDAD").val(0);
 	
 	$("#IDUNIDAD").val(Q_IDUNIDAD);
 	
 	$("#IDPERIODO").val(Q_IDPERIODO);
 	
 	
 	poneObjetivosUnidad( );

 	$("#IDOBJETIVO").val("");	
 	
 	$("#ACTIVIDAD").val("");
 	
 	$("#TIPOGESTION").val("");
 	
 	$("#PROGRAMA").val("");
 	
 	$("#COMPONENTE").val("");
 	
 	$("#ESTADO").val("");
 
 	$("#APORTAEN").val("");
 	
 	$("#LISTAAPORTE").val("");
 
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
function poneObjetivosIndicadores( )
{
	
//filtro para poner los objetivos de la unidad	
	 
	var Q_OBJETIVO =  $("#IDOBJETIVO").val();
 
	var Q_IDUNIDAD =  '-';
	
	
	var parametros = {
				 'Q_OBJETIVO'  : Q_OBJETIVO ,
				 'Q_IDUNIDAD'		: Q_IDUNIDAD
 	  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-ooFiltroIndicador.php",
		 type: "GET",
     success: function(response)
     {
         $('#IDINDICADOR').html(response);
     }
	 });
	 
}
//-------------------
function poneUnidadIndicadores( )
{
	
//filtro para poner los objetivos de la unidad	
	 
	var Q_OBJETIVO =  0;
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
       $('#IDINDICADOR').html(response);
   }
	 });
	 
}
 
//-------------------
function LimpiarPantallaTarea( )
{

    var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
    
    var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
     
    $('#IDACTIVIDAD1').prop('disabled', false);  
 
    
    $("#CLASIFICADOR").attr('disabled', 'disabled');

 	
    $("#actionTarea").val('add');
    
    
	var parametros = {
			 'Q_IDUNIDAD'  : Q_IDUNIDAD ,
            'Q_IDPERIODO' : Q_IDPERIODO 
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-ooTareaActividad.php",
		 type: "GET",
        success: function(response)
        {
            $('#IDACTIVIDAD1').html(response);
        }
	 });
	 
	 
	 var fecha = fecha_hoy();
	 
	 
 	 $("#IDTAREA").val(0);
	 $("#TAREA").val("");
	 $("#ESTADO1").val("");
	 $("#RESPONSABLE").val("");
 	 $("#CLASIFICADOR").val("");
 	 $("#PRODUCTO").val("");
	 $("#FECHAEJECUTA").val(fecha);
  
 
 	$('#resultadoTarea').html('Crear nueva tarea');
 	
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

//---------------------
function busquedaObjetivos ( )
{
 
	
      var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
      
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
      var select = $("#Q_IDUNIDAD option:selected").text();
      
      
      $("#UnidadSeleccionada").html('<center><h5><b>Unidad Seleccionada ['+select+' ]</b></h5></center>');
      
      
       
	
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
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

}
//-------------------
//---------------------
function VisorObjetivos ( )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDAD").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
    
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
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
 

}
//----------------------
function habilitaperiodo ( )
{
 
	  var fecha 			=   $("#FECHAEJECUTA").val();
	  
	  var validatarea 	    = 	$("#validatarea").val();
	
	  var str = validatarea.trim();
	  
	  var i;
	  
	  var array_fechasol = fecha.split("-") 
	  
	  var month = parseInt(array_fechasol[1]);
	  
	  var objeto='m';
	 	  
	 if (str  == 'S'){
		 
 		  $("#CLASIFICADOR").removeAttr('disabled');
		 
		    for (i=month;i<=12;i++) { 
			  
			  	objeto = '#m' + i;
			  	
			  	 $(objeto).attr('readonly', false);
			  	
			  }   
	 }else{
		 
		 $("#CLASIFICADOR").attr('disabled', 'disabled');
		  
		 for (i=1;i<=12;i++) { 
			  
			  	objeto = '#m' + i;
			  	
			  	 $(objeto).attr('readonly', true);
			  	
			  }  
		
		 
	 }
	

}
//-------------------
//----------------------
function PoneValida ( )
{

	var validaBoton ='-' ;
	
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
	
	 
	validaBoton =  $("#validatarea").val();  
	
	var str = validaBoton.trim();
	
	if ( str == 'N') {
		
		 $('#BotDet').attr('disabled', true);
	
	}else{
	
		 $('#BotDet').attr('disabled', false);
	
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
	
 
      poneObjetivosUnidad( );
	 
 
	// poneUnidadIndicadores( );
  	 
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
		
 
		  
		  

 }
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToTarea(action,id) 
{

	 var visor= 'S';
	
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
	
	   LimpiarMontos();
		  
	   $('#IDACTIVIDAD1').prop('disabled','disabled');
	   
		
	   $("#actionTarea").val('editar');

}
 