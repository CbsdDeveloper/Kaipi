var oTable;
var oTableAux;

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 		oTable    = $('#jsontable').dataTable(); 
        var fecha = fecha_hoy();

  		var today = new Date();
 	    var mm    = today.getMonth() + 1; //January is 0!

 	    $("#mes").val(mm);
        $("#fechae").val(fecha);
		$("#fechao").val(fecha);
		
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
				 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>'+action);
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
				 
					DetalleBaja(  0 );
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
function goToURL(id) {
     
		 var parametros = {
						'accion' : 'busqueda' ,
	                    'id' : id 
	 	  };
		
		  $.ajax({
 				data:  parametros,
				url:   '../model/Model-baja_lista.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#result").html('Procesando');

				},
				success:  function (data) {
						 $("#result").html(data);  
 				} 
		}); 
 		  
 	 	DetalleBaja(  id );
 }
//-------------------------------------------------------------------------
function LimpiarPantalla() {
  
 
	var f1 = fecha_hoy();
 
 	    
 
  $("#id_ren_baja").val(0);
 
    $("#fechab").val(f1);


    $("#tipo").val("");
    $("#resolucion").val("");
     
	
    $("#idprov").val("");
    $("#razon").val("");

    $("#direccion").val("");
    $("#correo").val("");
    
   $("#id_par_ciu").val('0');

	 
    
    
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
            
            var ruc     = $("#ruc").val();
            var nombrec = $("#nombrec").val();
             
       
            var parametros = {
					'ffecha1' : ffecha1 , 
                    'ffecha2' : ffecha2  ,
                    'ruc' : ruc,
                    'nombrec' : nombrec
  	       };
      

           
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ren_tramites_baja.php',
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
                                '<button class="btn btn-xs" onClick="goToURL('+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			 
 }   
//-------------------------------------
//----------------------------
function goToURLDel(id) {
	
  
var id_par_ciu = $("#id_par_ciu").val();
	  
	  
	
	 var parametros = {
 			    'id_par_ciu' : id_par_ciu ,
				'id': id,
			    'accion' : 'del'
	 };
	  
 
if ( id_par_ciu) {
	  
			$.ajax({
					data:  parametros,
					 url:   '../model/Model-baja_lista.php',
					type:  'GET' ,
		 			success:  function (data) {
							 $("#DetalleActivosNoAsignado").html(data);   
						     
						 
						} 
			});
	 }



}
//--------------------------------------
function aprobacion_tramite() {
	
	  var id_par_ciu = $("#id_par_ciu").val();
	  var tipo 	     = $("#tipo").val();
	  var resolucion = $("#resolucion").val();
	  var fechab	 = $("#fechab").val();

	  var id_ren_baja	 = 	$("#id_ren_baja").val();
	
	 var parametros = {
 			    'id_par_ciu' : id_par_ciu ,
			    'accion'     : 'aprobar',
				'tipo'       :tipo,
				'resolucion' :resolucion,
				'fechab'     :fechab

	 };

  if (id_ren_baja == 0) {
		 alertify.confirm("Ud. va a realizar la baja de titulos", function (e) {
			  if (e) {
				  if ( tipo) {
					if ( id_par_ciu) {
						  if ( resolucion){
 									 $.ajax({
			 								data:  parametros,
											url:   '../model/Model-baja_lista.php',
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
                } 
			  }
			 });  
    }

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
function BuscarTitulos( )
{
	
	  var id_par_ciu = $("#id_par_ciu").val();
	  var tipo 	     = $("#tipo").val();
	  var accion     = $("#action").val();
	  var resolucion = $("#resolucion").val();
	
	
	
	 var parametros = {
 			    'id_par_ciu' : id_par_ciu ,
			    'accion' : 'titulo'
	  };
		
	if ( accion == 'add')	{ 	  
		    if ( tipo) {
				if ( id_par_ciu) {
						  if ( resolucion){
								$.ajax({
										data:  parametros,
										 url:   '../model/Model-baja_lista.php',
										type:  'GET' ,
							 			success:  function (data) {
												 $("#ViewFiltroTitulo").html(data);  // $("#cuenta").html(response);
											     
											} 
								});
									$('#myModalpa').modal('show');
						    }			
					 }
				}else {
				    alert('Seleccione el motivo de del tramite de Baja de Titulos');
		 			$('#myModalpa').modal('hide');
				}
 		}else {
				  alert('Presione el icono para crear la transaccion...');
			  	  $('#myModalpa').modal('hide');
		}
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
//-----------------------
function myFunction(codigo,objeto ) {
	
 	    
	    var  accion 		    =  'check';
 
	    if (objeto.checked == true){
	    	estado = 'S'
	    } else {
	    	estado = 'N'
	    }
	    
	     
		   

	    var parametros = {
               'idbien' : codigo ,
              'estado':estado ,
              'bandera': 'S'

	  };


    $.ajax({
						data:  parametros,
						url:   '../model/Model-ac_listaCheckNo.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#GuardaDato").html('Procesando');
							},
						success:  function (data) {
								 $("#GuardaDato").html(data);   
							} 

				}); 
 
	 
}
//-----------------
function FormView()
{
 	 
	 $("#ViewForm").load('../controller/Controller-ren_baja.php');
	 
	 $("#ViewFormOpcion").load('../controller/Controller-ren_tramite_boton.php');
	 
 	 
}
//----------------------
function FormFiltro()
{
 
	 $("#ViewFiltro").load('../controller/Controller-ren_baja_filtro.php');
 

}
//--------------------- 
function goToURLPone( id_ren_movimiento  )
{
 
var id_par_ciu = $("#id_par_ciu").val();
 	  
	
	 var parametros = {
 			    'id_par_ciu' : id_par_ciu ,
				'id_ren_movimiento': id_ren_movimiento,
			    'accion' : 'add'
	 };
	  
 
if ( id_par_ciu) {
	  
			$.ajax({
					data:  parametros,
					 url:   '../model/Model-baja_lista.php',
					type:  'GET' ,
		 			success:  function (data) {
							 $("#DetalleActivosNoAsignado").html(data);  // $("#cuenta").html(response);
						     
							 $('#myModalpa').modal('hide');
						} 
			});
	 }


 
 
} 
//---------------------
function DetalleBaja(  idbaja )
{
	 
	var id_par_ciu = $("#id_par_ciu").val();
	
	 var parametros = {
 			    'id_par_ciu' : id_par_ciu ,
				'idbaja' : idbaja,
			    'accion' : 'detalle'
	 };
	  
			$.ajax({
					data:  parametros,
					 url:   '../model/Model-baja_lista.php',
					type:  'GET' ,
		 			success:  function (data) {
							 $("#DetalleActivosNoAsignado").html(data);  // $("#cuenta").html(response);
						     
 						} 
			});
	 



  
} 
//--------------
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
//----------() 
function imprimir_informe(url){        
	
	  
   var tramite = $("#id_ren_baja").val();
	   
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
///---------------()
function VerEmision(  )
{
	
	
	  var frubro = $("#frubro").val();
	  var tramite = $("#id_ren_tramite").val();
	  
	  var fechae = $("#fechae").val();
	  var fechao = $("#fechao").val();




	  var anio   = $("#anio").val();
	  var mes = $("#mes").val();
	  
	  alert(anio);
	   
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
					
					  alert(  response);
					
					 visor_tramites(tramite,frubro);
				}
			});
		  
	  }
	 });


		
		
} 	