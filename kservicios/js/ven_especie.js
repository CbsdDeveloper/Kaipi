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


		 $('#GuardaPara').on('click',function(){
 	 		 
			AgregarEspecieTramite();
			
		  });

		 
          
	       
	     
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
    var idproducto_ser =  $("#id_rubro").val();

    if ( idproducto_ser > 0  ){

			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
				  if ($("#referencia").val()) {
					  
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>'+action);
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");

                    nro_especie();
					
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
			return false	  ;


        }
	  }
//-------------------------------------------------------------------------
function enviar_informacion() {
    

   var id_ren_tramite =  $("#id_ren_movimiento").val();

   var estado         =   $("#estado").val();

   var idproducto_ser =  $("#id_rubro").val();


   var cantidad         =   $("#cantidad").val();

   var comprobante         =   $("#comprobante").val();
   


	var parametros = {
						'accion' : 'envio' ,
	                    'id' : id_ren_tramite,
                        'idproducto_ser' : idproducto_ser,
						'cantidad' : cantidad,
						'comprobante': comprobante
	 	  };

		 alertify.confirm("Ud. va a realizar el envio del tramite a generar el pago", function (e) {
			  if (e) {
				 
					if ( estado== 'E') {
						
						 $.ajax({
 								data:  parametros,
								url:   '../model/Model-ren_tramites_espe.php',
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
								url:   '../model/Model-ren_tramites_espe.php',
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
   
	
	 
	  
	 
	
 	   
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
		
		  $.ajax({

				data:  parametros,
				url:   '../model/Model-ren_tramites_espe',
				type:  'GET' ,
				beforeSend: function () { 
						$("#result").html('Procesando');

				},
				success:  function (data) {
						 $("#result").html(data);  
 				} 
		}); 
		  
 
	  
		  
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


    $("#direccion").val("");
    $("#correo").val("");


    
	$("#novedad").val("USUARIO FINAL");
     
    $("#cantidad").val("1");

    $("#estado").val("E");

    var costo =   $("#costo").val();

    flotante = parseFloat(costo).toFixed(0)  ;

    var total = flotante * 1;

    $("#base").val(  total );
   

      
    $("#efectivo").val("");
    
 
    
    $("#cambio").val("");
	
    $("#idprov").val("");
    $("#razon").val("");
    
  
	var id_rubro =  $("#id_rubro").val();

	if ( id_rubro == 14 ){
 			$("#secuencial").val("");
			 $("#detalle").val("");
			 $("#autorizacion").val("");
			 
	}
	else{
	    	$("#secuencial").val("000000");
			$("#detalle").val("CONTROL DE ESPECIES");
			$("#autorizacion").val("-");
	}
    

	 
 


  }
 
function accion(id, action,estado)
{
 
	$('#action').val(action);
	
	$('#id_ren_movimiento').val(id); 
	
	
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

			var ccnombre = $("#ccnombre").val();

			
 
            var parametros = {
					'ffecha1' : ffecha1 , 
                    'ffecha2' : ffecha2  ,
                    'festado' : festado , 
                    'frubro' : frubro ,
					'ccnombre' : ccnombre
   	       };
      

           
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ren_especies.php',
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
 								'<button class="btn btn-xs btn-danger" title="ELIMINAR/ANULAR TRAMITE SELECCIONADO" onClick="goToURLDel('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;&nbsp;' +
								 '<button title= "VISUALIZAR INFORMACION" class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
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
function ReporteDiario(){        
	
    var ffecha1 = $("#ffecha1").val();
     var frubro = $("#frubro").val();
   
			var posicion_x; 
			var posicion_y; 
			
			var enlace =   '../../reportes/reporteDiarioEspecie?&fecha='+ffecha1+   '&frubro='+ frubro;
			
			var ancho = 1000;
			
			var alto = 520;
			
			posicion_x=(screen.width/2)-(ancho/2); 
			
			posicion_y=(screen.height/2)-(alto/2); 
			
			window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
		 
}


//-----------
function ResumenDiario( ){        
	
	  
    var ffecha1 = $("#ffecha1").val();
    var frubro = $("#frubro").val();
  
           var posicion_x; 
           var posicion_y; 
           
           var enlace =   '../../reportes/reporteResumenEspecie?&fecha='+ffecha1+   '&frubro='+ frubro;
           
           var ancho = 1000;
           
           var alto = 520;
           
           posicion_x=(screen.width/2)-(ancho/2); 
           
           posicion_y=(screen.height/2)-(alto/2); 
           
           window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
     
 
 }
 
//---------------
///------------------
function cambio_dato(monto_pagado) {
	
	var tt1   = $('#base').val();
	
	
	 
	 var total = monto_pagado - parseFloat (tt1).toFixed(2);
	    

	 var CalcularPago = parseFloat(total.toFixed(2));  
	 
	 
	   
	 if (isNaN(CalcularPago)){
		 
  	   $('#cambio').html('<h3><b>0.00</b></h3>');  
     
	 }else{
  	   $('#cambio').html('<h3><b>Su Cambio es: '+ CalcularPago+'</b></h3>'); 
     
	 }
	
	
	
}

function cambio_monto(cantidad) {
	
	var tt1   =  parseFloat (cantidad).toFixed(2);

	var costo   = $('#costo').val();
	
	// cantidad costo base
	 
	 var parcial =   parseFloat (costo).toFixed(2);

 

	 var total = costo * tt1;

	  
	  $('#base').val(total);
     
 
	
	
	
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
function nro_especie( )
{
	
	
    var idproducto_ser =  $("#id_rubro").val();
	  
	  
	
	 var parametros = {
 			    'id' : idproducto_ser,
 			    'accion' : 'secuencia'
	 };
	  
 
	  
     $.ajax({
        type:  'POST' ,
        data:  parametros,
        url: "../model/ajax_ren_espe_add.php",
        dataType: "json",
         success:  function (response) {
               
                 $("#comprobante").val( response.a );  
                 
  
                 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ren_tramites_espe.php');
	 
	 $("#ViewFormOpcion").load('../controller/Controller-ren_tramite_boton.php');
	 
	 $("#ViewRubro").load('../controller/Controller-ren_tramite_lista_espe.php');
	 
	 
	 
	 $("#ViewFiltroEspecie").load('../controller/Controller-ren_especie_conf.php');

	 
	 
}
//----------------------
function FormFiltro()
{
 
	 $("#ViewFiltro").load('../controller/Controller-ren_tramites_esp_filtro.php');
 

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
function AsignaMovimiento( valor,opcion_seleccionada,costo )
{
 
	   //frubro,festado,ffecha1,ffecha2
	   
	$("#id_rubro").val(valor);

	$("#frubro").val(valor);

    $("#costo").val(costo);

    
  	
	
    var id_rubro = $("#id_rubro").val();


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

VerSeg( id_rubro ) ;
 
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
function proceso_doc( accion, codigo )
{
	
 

    var parametros = {
		'id' : codigo,
		'accion' : accion
};

var idproducto_ser =  $("#id_rubro").val();

	alertify.confirm("<p>Desea generar el proceso de "+accion + " </p>", function (e) {
		if (e) {
		   

			$.ajax({
				data: parametros,
				url: "../model/ajax_ren_espe_add.php",
				type: "POST",
				success: function(response)
				{
                    $("#MensajeParametro").html('<img src="../../kimages/ksavee.png" align="absmiddle"/>'+response);
				}
			});


            VerSeg( idproducto_ser );

		 
		}
	   }); 


	
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

function LimpiarEspecie(  )
{

	$("#observacion").val('');
	$("#referencia_dato").val('');


	$("#fecha_recepcion").val(fecha_hoy());
    $("#fecha").val(fecha_hoy());

    $("#inicio").val('0');
	$("#fin").val('0');
	$("#actual").val('0');
	$("#detalle").val('CONTROL DE ESPECIES');

     $("#MensajeParametro").html('');

}	
/*

*/
function AgregarEspecieTramite(  )
{
	
   var idproducto_ser =  $("#id_rubro").val();

	var fecha 		          = $("#fecha").val();
	var fecha_recepcion       = $("#fecha_recepcion").val();
	var sesiona 			  = $("#sesiona").val();
	var detalle               = $("#observacion").val();
	var referencia            = $("#referencia_dato").val();
	var inicio                = $("#inicio").val();
    var fin                   = $("#fin").val();
    var actual                = $("#actual").val();
 
  


	var parametros = {
		'idproducto_ser' : idproducto_ser,
		'fecha' : fecha,
		'fecha_recepcion' : fecha_recepcion ,
		'sesiona' : sesiona,
		'detalle' : detalle ,
		'referencia' : referencia,
        'inicio' : inicio,
        'fin' : fin,
        'actual' : actual,
		'accion' : 'add' ,
};



if ( idproducto_ser > 0 )  {


            alertify.confirm("<p>Desea  generar informacion adicional<br><br></p>", function (e) {
                if (e) {
                

                    $.ajax({
                        data: parametros,
                        url: "../model/ajax_ren_espe_add.php",
                        type: "POST",
                        success: function(response)
                        {
                            
                            $("#MensajeParametro").html('<img src="../../kimages/ksavee.png" align="absmiddle"/>'+response);

                         	VerSeg( idproducto_ser );
                        }
                    });

        
                }
            }); 
	
        }

	
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
function VerSeg( idproducto_ser )
{
	
	 
	   
	 var parametros = {
			    'id' : idproducto_ser,
 			    'accion' : 'visor'
	 };
	  
	 
 
		 
		  $.ajax({
				data: parametros,
                url: "../model/ajax_ren_espe_add.php",
				type: "POST",
				beforeSend: function () { 
					$("#ViewFormEspecie").html('Procesando');

					},
					success:  function (data) {
							$("#ViewFormEspecie").html(data);  
					} 
			});
 
		
} 	

//-------------
function Enlace_Bomb_permiso(  )
{
	
	var codigo_ex   = $('#codigo_ex').val();
	var ruc_ex      = $('#ruc_ex').val();
	var nombre_ex   = $('#nombre_ex').val();


	  
	   
	 var parametros = {
			    'codigo_ex' : codigo_ex,
 			     'ruc_ex' : ruc_ex,
				 'nombre_ex' : nombre_ex
	 };
	  
	 
 
		 
		  $.ajax({
				data: parametros,
                url: "../model/ajax_bomberos_autoinspeccion_buscar.php",
				type: "GET",
				beforeSend: function () { 
					$("#Resultado_facturae_id").html('Procesando');

					},
					success:  function (data) {
							$("#Resultado_facturae_id").html(data);  
					} 
			});
 
		
} 	
/*
Enlace_Bomb_asigna
*/
function Enlace_Bomb_asigna( accion, codigo )
{
	
 
 
	 var parametros = {
		'accion' : accion ,
		'id' : codigo 
  };
  
		 $.ajax({
			 type:  'GET' ,
			 data:  parametros,
			 url:   '../model/ajax_ren_emision_especie_b.php',
			 dataType: "json",
			 success:  function (response) {
				 
					 $("#enlace").val( codigo);  

					 $("#id_par_ciu").val( response.a );  
					 $("#detalle").val( response.b );  
					 $("#autorizacion").val( response.c );  

					 $("#idprov").val( response.d );  
					 $("#razon").val( response.e );  
					 $("#direccion").val( response.f );  
					 $("#correo").val( response.g );  

					 $("#direccion_alterna").val( response.h );  

				
			 			 
 					 
			 } 
		 });
 
 
  
	 $("#myModalExterno").modal('hide');
 
		
} 	
//-----------permiso_informacion
function permiso_informacion( ) {
   
	
	var frubro = $("#frubro").val();

	var id_ren_movimiento  = $("#id_ren_movimiento").val();

	
   
  if ( frubro == 14 ) {
	  
			var parametros = {
							'accion' : 'permiso' ,
							'id' : id_ren_movimiento 
				};
			
				$.ajax({

					data:  parametros,
					url:   '../model/Model-ren_tramites_espe.php',
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
/*

*/
function LimpiaPermiso(  )
{

   var id_rubro =  $("#id_rubro").val();


   // 14

   if ( id_rubro == 14 ){


			$('#codigo_ex').val('');
			$('#ruc_ex').val('');
			$('#nombre_ex').val('');

			$('#myModalExterno').modal('show'); 
 	
  }	else{

		$('#myModalExterno').modal('hide'); 
}	

}	
/*
*/
function imprimir_informe(url){        
	
	 
	var id_rubro =  $("#id_rubro").val();

 
	var id_ren_movimiento = $("#id_ren_movimiento").val();  

	


	var estado = $("#estado").val();  
 	
	 var posicion_x; 

	 var posicion_y; 
	 
	 var enlace = url +  '?id='+id_ren_movimiento  ;
	 
	 var ancho = 1000;
	 
	 var alto = 520;
	

	

				if ( id_rubro == 14 ){

					if ( estado == 'P'){
					
							posicion_x=(screen.width/2)-(ancho/2); 
							
							posicion_y=(screen.height/2)-(alto/2); 
							
							window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

				  }else{		
 
							$("#result").html('ADVERTENCIA...  PARA EL PROCESO DE EMISION DE IMPRESION DE PERMISO TIENE QUE PRESIONAR EL ICONO DE PROCESAR');
				
					}			
 
				}
 	
}

/*
*/
function BuscarHistorial(  )
{
	
	var idprov   = $('#idprov').val();
 

	  
	   
	 var parametros = {
			    'idprov' : idprov 
	 };
	  
	 
 
		 
		  $.ajax({
				data: parametros,
                url: "../model/ajax_bomberos_autoinspeccion_his.php",
				type: "GET",
				beforeSend: function () { 
					$("#Resultado_facturae_his").html('Procesando');

					},
					success:  function (data) {
							$("#Resultado_facturae_his").html(data);  
					} 
			});
 
		
			$('#myModalExternoBusqueda').modal('show'); 

} 	

