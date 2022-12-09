var oTable;
 
$(function(){
 
    $(document).bind("contextmenu",function(e){
        return false;
    });
 	
});

//-------------------------------------------------------------------------


$(document).ready(function(){
         
	
	oTable = jQuery('#json_variable').dataTable();   
	     
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 	
		FormView();
		
    	FormArbolCuentas(); 

 		 var mes = _mes();
 
	    $("#qmes").val(mes);
 
});  
//----------------------------------------------------
 function _mes()
{
   
     var today = new Date();
     var mm = today.getMonth()+1; //January is 0!
     var yyyy = today.getFullYear();
    
 
   if(mm < 10){
        mm='0'+ mm
    } 
    
    var today = yyyy + '-' + mm ;
    
 
    return today;
            
} 
//----------------------------------------------------
function goToURLProceso(idproceso) {
	
	
	var fecha =  $("#qmes").val();
  	    
		var parametros = {
					'idproceso' : idproceso  ,
					'fecha' : fecha
  		  };
		  
	
		
		jQuery.ajax({
			data:  parametros, 
		    url: '../grilla/grilla_cli_reasignar.php',
			dataType: 'json',
			success: function(s){
		 	//console.log(s); 
		 	oTable.fnClearTable();
			if(s ){ 
				for(var i = 0; i < s.length; i++) {
					oTable.fnAddData([
								s[i][0],
								s[i][1] ,
								s[i][2] ,
								s[i][3],
								s[i][4],
								s[i][5],
 			                     	'<button class="btn btn-xs" title="Ver Tramite" onClick="javascript:goTocaso('+"'editar'"+','+ s[i][0]+')"><i class="glyphicon glyphicon-cog"></i></button> '   
 							]);										
						} // End For
			}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				
			});
 
 	 
    }
//-----------------------------------------------------------------
function goToURL(idproceso,proceso) {
	
	$("#codigoproceso").val(idproceso);
	 
	$("#idproceso").val(idproceso);
 	
	
	$("#nombre_proceso_se").html( proceso);
	
	
  	
	var parametros = {
                     'id' : idproceso
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../controller/Controller-auto_01.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#DibujoFlujo").html('Procesando');
  					},
					success:  function (data) {
							 $("#DibujoFlujo").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
	   
	  goToURLProceso(idproceso);
	  
 	 
    }
//------------------
function accion(id,modo,bandera)
{
  
			$("#action").val(modo);
			
			$("#idcaso").val(id);          
 
			 
		 

}
//------------------------------
function goTocaso(accion,id) {
 	
	 Recorrido(id) ;
	 
	 
     Pone_variables(id,'3','#idtareactual') ;
     
     Pone_variables(id,'1','#unidad_actual') ;
 
     $("#action").val(accion);
     
	var parametros = {
			'accion' : accion ,
            'id' : id 
};
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-cli_reasignar.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
  							 
							 $("#result").html(data);   
							 
 		 
					} 
			}); 


	  
	     $('#mytabs a[href="#tab2"]').tab('show'); 
}
//-------------------()
function FinProceso( ) {
 	
      var idcaso = $("#idcaso").val();
    
	var parametros = {
			'accion' : 'del' ,
            'id' : idcaso
};
	
	
	
	  alertify.confirm("Desea anular el tramite? " +idcaso, function (e) {
		  if (e) {
			 
					  $.ajax({
							data:  parametros,
							url:   '../model/Model-cli_reasignar.php',
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
		 }); 
 
	  
	     $('#mytabs a[href="#tab2"]').tab('show'); 
}
//-------------------
function Pone_variables(id,tipo,variable) {
 
	
	var codigoproceso =	$("#codigoproceso").val();
 	
	 var parametros = {
				 'codigo' : codigoproceso,
				 'id': id,
			     'tipo'   : tipo
  };
	 
	
   $.ajax({
		 data:  parametros,
		 url: "../model/ajax_proceso_tarea.php",
		 type: "GET",
       success: function(response)
       {
     		   $(variable).html(response);
     	 
       }
	 });
   
	
}
//-------------------------------------
function PoneUsuarios(unidad) {
 
	
  	
	 var parametros = {
				 'codigo' : unidad,
			     'tipo'   : '2'
  };
	 
	
   $.ajax({
		 data:  parametros,
		 url: "../model/ajax_proceso_tarea.php",
		 type: "GET",
       success: function(response)
       {
     		   $('#sesion_actual').html(response);
     	 
       }
	 });
   
	
}
//------------------
function Recorrido(idcaso) {
	
	
	var parametros = {
            'id' : idcaso 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/Model-proceso_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewRecorrido").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewRecorrido").html(data);  // $("#cuenta").html(response);
					     
					} 
		}); 

 	 
	}	
//-----------------------------------------
//-----------------------------------------------------------------
function FormArbolCuentas()
{

   $("#ViewFormArbol").load('../controller/Controller-proceso_reasignar.php' );

}
 
//-------------------------------------------------------------------------
  
 
//-------------------------------------------------------------------------  
 function modulo()
 {
	 var modulo1 =  'kdocumento';
	 
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
  
 //----------------------------------------------
 function informacionproceso()
 {
	 
		var id = $("#codigoproceso").val( );
	 
 
		var parametros = {
	                     'id' : id 
	 	  };
		
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-procesoinformacion.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
	 							$("#InformaProceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#InformaProceso").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
 
 } 
//-----------------
 function FormView()
 {
    	 $("#ViewForm").load('../controller/Controller-cli_reasignar.php');
 
 }
 //-----------------
 function  Visor( idtarea)
 {
    
	   var bandera   = $("#bandera2").val();
 	   var idproceso = 	$("#codigoproceso").val();
		
		var parametros = {
		           'id' : idtarea ,
		           'idproceso': idproceso
			};
			
 
		$.ajax({
					data:  parametros,
					url:   '../controller/Controller-auto_03.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewFormularioTarea").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewFormularioTarea").html(data);  // $("#cuenta").html(response);
						     
						} 
			}); 
           //--------------------------------
		if (bandera == 'S'){
			 
			$('#VentanaProceso').modal({show: true});
		 
			$("#bandera2").val('S');
	     }

		 if (bandera == 'N'){
				$("#bandera2").val('S');
		 }
			
 
 }
//--------------------
 function EnviarProceso() {
	 
	 var mensaje = 'Desea generar el Finalizar tramite para su gestion?';			 
		
     var estado    = $("#estado").val( );
	 var id 	   = $("#idcaso").val( );
	 var idproceso = $("#codigoproceso").val();
	 
	var parametros = {
                'id' : id ,
                'idproceso' : idproceso,
                'accion': 'aprobado'
   };

	 
	 if ( estado == '4')  {
		 
		  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

		  if (e) {
 
				  $.ajax({
								data:  parametros,
								url:   '../model/Model-cli_reasignar.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
			 							$("#result").html('Procesando');
			  					},
								success:  function (data) {
										 $("#result").html(data);  // $("#cuenta").html(response);
									     
			  					} 
						}); 
 	 
			  }
		 }); 
 }
 //-------------------------------------------------
 
}