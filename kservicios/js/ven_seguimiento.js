var oTable;
var oTableAux;

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        oTable = $('#jsontable').dataTable(); 
 
        var fecha = fecha_hoy();
        
        $("#fechae").val(fecha);
        
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});


		 $('#GuardarSeg').on('click',function(){
 	 		 
			AgregarSeguimiento();
			
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
function enviar_informacion() {
	
   var id_ren_tramite =  $("#id_ren_tramite").val();

   var estado         =   $("#estado").val();

   var dato_si         =   $("#dato_si").val();

	var parametros = {
						'accion' : 'envio_seg' ,
						'dato_si' : dato_si,
	                    'id' : id_ren_tramite
	 	  };

		 alertify.confirm("Ud. va a realizar el envio del tramite a generar el pago", function (e) {
			  if (e) {
				 
				 
						
						 $.ajax({
 								data:  parametros,
								url:   '../model/Model-ren_tramites_seg.php',
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
//----------------------------
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
//------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {
   
	
	  var frubro = $("#frubro").val();
	  
	   variablea_tramites(id,frubro);
	
 	   
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
		
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
		  
		  
		  visor_tramites(id,frubro);
		  
		  Ver_doc_prov(id);

		  VerSeg( id ) ;
	  
		  
    }

//-------------------------------------------------------------------------
// ir a la opcion de editar
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
   
	
    $("#idprov").val("");
    $("#razon").val("");
    
    $("#base").val('0');
    
    
  }
 
function accion(id, action,estado)
{
 
	$('#action').val(action);
	
	$('#id_ren_tramite').val(id); 
	
	
	if ( estado ){
		$('#estado').val(estado); 
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
			    url: '../grilla/grilla_ren_tramites.php',
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
                                '<button class="btn btn-xs btn-warning" title="EDITAR TRAMITE SELECCIONADO" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs btn-danger" title="ELIMINAR/ANULAR TRAMITE SELECCIONADO" onClick="goToURLDel('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
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

//----------------
function openFile(url,ancho,alto) {
    
	  var tramite = $("#id_ren_tramite").val();
		 
	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+tramite  ;
	 
	  if ( tramite) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}

//-----------
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
//-------------------------
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
//---------------
///------------------
function PoneDoc(file)
{
 
 
 var url = '../../userfiles/files/' + file;

	document.getElementById("DocVisor").src= url;
	
  	
}
//------------------------------------
function goToURLDocdel(idcodigo,idcaso) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'id'   : idcaso  ,
					'accion' : 'del'
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../../upload/Model-ser_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfileDoc").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
//-------------------------- ViewFormfile
function Ver_doc_prov(id) {

	
	
	var parametros = {

			'id' : id  ,
			'accion' : 'visor'  

};

$.ajax({

			data:  parametros,

			url:   '../../upload/Model-ser_doc.php',

			type:  'GET' ,

			success:  function (data) {

					 $("#ViewFormfileDoc").html(data);  // $("#cuenta").html(response);

				     

				} 

	}); 

  
	  
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
					 $("#ViewFormHistorial").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
	 
 
}	
//------------------------------------
function SimularEmision( )
{
	
	
	  var frubro = $("#frubro").val();
	  var tramite = $("#id_ren_tramite").val();
	  
	  
	
	 var parametros = {
 			    'tramite' : tramite,
 			    'rubro' : frubro
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ren_tramites_apro.php');
	 
	 $("#ViewFormOpcion").load('../controller/Controller-ren_tramite_boton.php');
	 
	 $("#ViewRubro").load('../controller/Controller-ren_tramite_lista_seg.php');
	 
	 
	 
	 $("#ViewSeguimiento").load('../controller/Controller-ren_tramites_seg');

	 
	 
}
//----------------------
function FormFiltro()
{
 
	 $("#ViewFiltro").load('../controller/Controller-ren_tramites_uni_filtro.php');
 

}
//----------------------
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
//---------------- 
function AsignaMovimiento( valor,opcion_seleccionada,idprov, dato)
{
 
	   //frubro,festado,ffecha1,ffecha2
	   
	$("#id_rubro").val(valor);
	$("#frubro").val(valor);
	$("#ruc").val(idprov);
    

    $("#dato_si").val(dato);
    
	
	
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
//--------------
function relacion_dato( valor, objeto)
{
	
var parametros = {
		'valor' : valor  ,
		'objeto':objeto
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
//----------() 
function IrRecaudar(  )
{
	
	var id_par_ciu =  $("#id_par_ciu").val();
	
	 var x = Math.floor((Math.random() * 100) + 1);
	 
	
	window.open('../view/ren_caja?id='+id_par_ciu+'&caja='+x, '_self');
	
}
/* */
function anular_informacion(  )
{
	
	$('#myModalanular').modal('show');
	
	$("#novedada").val('');
	

}
/*
*/
function anularTramite(  )
{
	
	var tramite = $("#id_ren_tramite").val();
	var novedada = $("#novedada").val();

	var parametros = {
		'id' : tramite,
		'novedad' : novedada,
		'accion' : 'anula' 
};



	alertify.confirm("<p>Desea Anular/Cierre del tramite seleccionado<br><br></p>", function (e) {
		if (e) {
		   

			$.ajax({
				data: parametros,
				url: "../model/Model-ren_tramites_uni.php",
				type: "GET",
				success: function(response)
				{
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> CIERRE DE TRANSACCION... </b>'+response);
				}
			});


			$('#myModalanular').modal('hide'); 
		}
	   }); 


	
}

function LimpiaSeg(  )
{

	$("#responsable_seg").val('');
	$("#novedad_seg").val('');
	$("#accion_seg").val('');
}	
/*

*/
function AgregarSeguimiento(  )
{
	
	var tramite 		= $("#id_ren_tramite").val();
	var fecha_seg       = $("#fecha_seg").val();
	var hora 			= $("#hora").val();
	var responsable_seg = $("#responsable_seg").val();
	var novedad_seg     = $("#novedad_seg").val();
	var accion_seg      = $("#accion_seg").val();
	 

	var parametros = {
		'id' : tramite,
		'fecha_seg' : fecha_seg,
		'hora' : hora ,
		'responsable_seg' : responsable_seg,
		'novedad_seg' : novedad_seg ,
		'accion_seg' : accion_seg,
		'accion' : 'add' ,
};



	alertify.confirm("<p>Desea  agregar informacion adicional<br><br></p>", function (e) {
		if (e) {
		   

			$.ajax({
				data: parametros,
				url: "../model/ajax_ren_seg_add.php",
				type: "POST",
				success: function(response)
				{
					
					$("#MensajeParametro").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> CIERRE DE TRANSACCION... </b>'+response);

					VerSeg( tramite );
				}
			});

 
		}
	   }); 


	
}
//
function VerEmision(  )
{
	
	
	  var frubro = $("#frubro").val();
	  var tramite = $("#id_ren_tramite").val();
	  
	  var fechae = $("#fechae").val();
	  var anio   = $("#anio").val();
	  var mes = $("#mes").val();
	  
	  alert(anio);
	   
	 var parametros = {
			    'tramite' : tramite,
			    'rubro' : frubro,
			    'fechae' : fechae,
			    'mes' : mes,
			    'anio' : anio
	 };
	  
	 
alertify.confirm("Generar Emision de titulos", function (e) {
	  if (e) {
		 
		  $.ajax({
				data: parametros,
				url: "../model/ajax_ren_emision_servicio.php",
				type: "GET",
				success: function(response)
				{
					
					  alert(  response);
					
					 visor_tramites(tramite,frubro);
				}
			});
		  
	  }
	 });


		
		
} 	

///---------------()
function VerSeg( tramite )
{
	
	 
	   
	 var parametros = {
			    'id' : tramite,
 			    'accion' : 'visor'
	 };
	  
	 
 
		 
		  $.ajax({
				data: parametros,
				url: "../model/ajax_ren_seg_add.php",
				type: "POST",
				beforeSend: function () { 
					$("#ViewFormSeguimiento").html('Procesando');

					},
					success:  function (data) {
							$("#ViewFormSeguimiento").html(data);  
					} 
			});
 

		
		
} 	