var oTable;
var oTableAux;

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
		var fecha = fecha_hoy();
		var today = new Date();
 	    var mm = today.getMonth() + 1 ; //January is 0!

		 oTable = $('#jsontable').dataTable(); 
		
		 $("#fechae").val(fecha);
		 $("#fechao").val(fecha);
 	     $("#mes").val(mm);

		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
    
		$("#MHeader").load('../view/View-HeaderModel.php');
        
		$('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	       
	     $.ajax({
	    		url: "../model/Model_busca_periodo.php",
	    		type: "GET",
	    		success: function(response)
	    		{
	    				$('#anio').html(response);
	    			 
	    		}
	    	  });


	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
				  if ($("#referencia").val()) {
					  
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>'+action);
                	
                      LimpiarPantalla();
                    
					  $("#action").val("add");
					
					  SimularEmision();
					
				  }else {
					  alert('Seleccione el tramite previamente...');
					  }	 
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
  
	
	  var frubro = $("#frubro").val();
	  
	   variablea_tramites(id,frubro);
	
 	   
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
		
		  $.ajax({

				data:  parametros,
				url:   '../model/Model-ren_tramites.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#result").html('Procesando');

				},
				success:  function (data) {
						 $("#result").html(data);  
 				} 
		}); 
		  
		  visor_tramites(id,frubro);
	 	
	      SimularEmision();

		  $("#ViewFormResultado").html('');
		  
    }
//-------------------------------------------------------------------------
function LimpiarPantalla() {
  
	var f1 = fecha_hoy();
 
    $("#id_ren_tramite").val("");
    $("#id_par_ciu").val("");
    $("#id_departamento").val("");
    
    $("#estado").val("digitado");
    $("#fecha_inicio").val(f1);
    $("#fecha_cierre").val("");
    $("#detalle").val("");
    $("#resolucion").val("No Aplica");
    $("#multa").val("N");
    $("#base").val("0.00");
	
    $("#idprov").val("");
    $("#razon").val("");

}
//------------------------------------------------------------------------- 
function accion(id, action,estado)
{
 
	$('#action').val(action);
	
	$('#id_ren_tramite').val(id); 
	
	if ( estado ){
		$('#estado').val(estado); 
	}


}
//------------------------------------------------------------------------- 
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
             
           	var ffecha1 = $("#ffecha1").val();
            var ffecha2 = $("#ffecha2").val();
            var festado = $("#festado").val();
            var frubro = $("#frubro").val();
          
            var ruc = $("#ruc").val();
            var nombrec = $("#nombrec").val();
             
       
            var parametros = {
					'ffecha1' : ffecha1 , 
                    'ffecha2' : ffecha2  ,
                    'festado' : festado , 
                    'frubro' : frubro ,
                    'ruc' : ruc,
                    'nombrec' : nombrec
  	       };
              
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ren_tramites_ser.php',
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
                                '<button title= "EMITIR TRAMITE SELECCIONADO" class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button title= "ANULAR TRAMITE SELECCIONADO" class="btn btn-xs btn-danger" onClick="goToURLDel('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-trash"></i></button>' 
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
function goToURLDel(accion,id) {
	
	var parametros = {
						'accion' : accion,
	                    'id' : id
	 	  };

		 alertify.confirm("Desea eliminar el tramite generado?", function (e) {
			  if (e) {
				 
 						
						 $.ajax({
 								data:  parametros,
								url:   '../model/Model-ren_tramites_uni',
								type:  'GET' ,
								beforeSend: function () { 
										$("#result").html('Procesando');
				
								},
								success:  function (data) {
										 $("#result").html(data);  
									     BusquedaGrilla(oTable);
				 				} 
						}); 
 			  }
			 });  

}
//--------------------------------------
function aprobacion_tramite() {
	
   var id_ren_tramite =  $("#id_ren_tramite").val();

   var estado         =   $("#estado").val();
   var bandera 		 = 0;


	var parametros = {
						'accion' : 'aprobado' ,
	                    'id' : id_ren_tramite
	 	  };

	if ( estado== 'digitado') {
		bandera = 1;
	  }
	if ( estado== 'enviado') {
		bandera = 1;
	  }

		 alertify.confirm("Ud. va a realizar la autorizacion del tramite a generar el pago", function (e) {
			  if (e) {
				 
					if ( bandera == 1 ) {
						
						 $.ajax({
 								data:  parametros,
								url:   '../model/Model-ren_tramites_uni',
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
			 });  


}
 
//--------------------------------------
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
//--------------------------------------------
function variablea_tramites(tramite,rubro)
{
	
	
	 var parametros = {
 			    'tramite' : tramite,
 			    'rubro' : rubro
		};
 	  
	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_ren_tramite_variable.php',
			type:  'GET' ,
 			success:  function (data) {
					 $("#ViewFormVar").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
	 
 
}
//---------------------------------------
function Actualiza_ciu()
{
 	
	var idprov    =    $("#idprov").val();
	var direccion =    $("#direccion").val();
	var razon     =    $("#razon").val();
	var correo    =    $("#correo").val();

 
	 var parametros = {
 			    'idprov'    : idprov,
 			    'direccion' : direccion,
				'razon'     : razon,
				'correo'    : correo
	 };
	  
    if ( idprov){
	  if ( razon){
 	 	$.ajax({
				data:  parametros,
				url:   '../model/ajax_actualiza_ciu.php',
				type:  'GET' ,
	 			success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	   }	
    }
}	
///---------------------------------
function visor_tramites(tramite,rubro)
{
 	
	 var parametros = {
 			    'tramite' : tramite,
 			    'rubro' : rubro
	 };
	  
 	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_ren_visor_tramite.php',
			type:  'GET' ,
 			success:  function (data) {
					 $("#ViewFormHistorial").html(data);   
				     
				} 
	});
	 
 
}	
//--------------------- 
function Elimina_pre_emision(tramite,rubro,emision,estado,fecha )
{
	
	var parametros = {
		'tramite' : tramite,
		'rubro' : rubro,
		'emision' : emision,
		'estado' : estado,
		'fecha' : fecha
};

	 
	  

	 alertify.confirm("<p>Desea eliminar la transacción<br><br></p>", function (e) {
		if (e) {
 	
					$.ajax({
						data:  parametros,
							url:   '../model/ajax_ren_visor_tramite.php',
						type:  'GET' ,
							success:  function (data) {
									$("#ViewFormHistorial").html(data);   
									
							} 
				});
					
  
		}
	   }); 
 
	  

 
}	
//------------------------------------
function SimularEmision( )
{
	
	
	  var frubro = $("#frubro").val();
	  var tramite = $("#id_ren_tramite").val();

	  var fechae = $("#fechae").val();
	  
	  var anio = $("#anio").val();

	  
	
	 var parametros = {
 			    'tramite' : tramite,
 			    'rubro' : frubro,
				 'anio' :anio,
				 'fechae':fechae
	 };
	  
 
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_ren_simula_tramite.php',
			type:  'GET' ,
 			success:  function (data) {
					 $("#ViewFormResultado").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
	 
 
}	
//----------------------------------------
function modulo()
{
 

	 var modulo1 =  'kservicios';
		 
	 var parametros = {
			    'ViewModulo' : modulo1
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
 
//-----------------
function FormView()
{
   
	 
	 $("#ViewForm").load('../controller/Controller-ren_tramites.php');
	 
	 $("#ViewFormOpcion").load('../controller/Controller-ren_tramite_boton.php');
	 
	 $("#ViewRubro").load('../controller/Controller-ren_tramite_lista_dato.php');
	 
	 
	 
}
//----------------------
function FormFiltro()
{
 
	 $("#ViewFiltro").load('../controller/Controller-ren_tramites_filtro.php');
 

}
//--------------------- 
function AsignaRubro( valor  )
{
 
	var opcion_seleccionada ;  
	
	$("#id_rubro").val(valor);
	$("#frubro").val(valor);
	
	opcion_seleccionada=  $('#midrubro option:selected').html();
 	
	$("#NombreSeleccion").html(opcion_seleccionada);

	$("#referencia").val(opcion_seleccionada);
	
			var parametros = {
				    'accion': 'visor',
				    'id' : valor
		};
		  
		  
		$.ajax({
				data:  parametros,
				 url:   '../controller/Controller-ren_tramites_dato.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ViewFormDetalle").html(data);   
 					} 
		});
 
		BusquedaGrilla(oTable);
 
} 
//---------------------
function AsignaMovimiento( valor,opcion_seleccionada )
{
 
	   
	$("#id_rubro").val(valor);
	$("#frubro").val(valor);
	
	$("#NombreSeleccion").html(opcion_seleccionada);

	$("#referencia").val(opcion_seleccionada);
	
			var parametros = {
				    'accion': 'visor',
				    'id' : valor
		};
		  
		  
		$.ajax({
				data:  parametros,
				 url:   '../controller/Controller-ren_tramites_dato.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ViewFormDetalle").html(data);   
 					} 
		});
 
		BusquedaGrilla(oTable);
 
} 
//----------------------------------------------------------
function relacion_dato( valor, objeto)
{
	
var parametros = {
		'valor' : valor  
		};

		$.ajax({
			data: parametros,
			url: "../model/ajax_ren_lista_dinamica.php",
			type: "GET",
			success: function(response)
			{
				$('#'+ objeto).html(response);
			}
		});
		
} 		

function imprimir_informe(url){        
	
	  
	var tramite = $("#id_ren_tramite").val();
	 
  var posicion_x; 
  var posicion_y; 
  var enlace = url  + '?id=' +tramite;
  var ancho = 1000;
  var alto = 420;
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
  if ( tramite > 0 ){
	  window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  }
   

}
//--------------------------------------------------- 
function IrRecaudar(  )
{
	
	var id_par_ciu =  $("#id_par_ciu").val();
	
	 var x = Math.floor((Math.random() * 100) + 1);
	 
	
	window.open('../view/ren_caja?id='+id_par_ciu+'&caja='+x, '_self');
	
}
	
///-------------------------------------------------------
function VerEmision(  )
{
	
	
	  var frubro = $("#frubro").val();
	  var tramite = $("#id_ren_tramite").val();
	  
	  var fechae = $("#fechae").val();
	  var fechao = $("#fechao").val();




	  var anio   = $("#anio").val();
	  var mes = $("#mes").val();
	  
 	   
	 var parametros = {
			    'tramite' : tramite,
			    'rubro' : frubro,
			    'fechae' : fechae,
			    'mes' : mes,
			    'anio' : anio,
				'fechao':fechao
	 };
	  
	 
alertify.confirm("Generar Emision de titulos", function (e) {
	  if (e) {
		 
		  $.ajax({
				data: parametros,
				url: "../model/ajax_ren_emision_servicio.php",
				type: "GET",
				success: function(response)
				{
					
					  $('#ViewFormGenerado').html(response);
					
					 visor_tramites(tramite,frubro);
				
				   
				}
			});
		  
	  }
	 });

} 	