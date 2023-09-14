var oTable;
 
$(document).ready(function(){


		$("#MHeader").load('../view/View-HeaderModel.php');

		modulo();

		FormView()

		$("#FormPie").load('../view/View-pie.php');

		$('#loadC').on('click',function(){

			goToURL( );

	    });
		
		$('#load').on('click',function(){

			goToURLDelVisor( );

	    });
		
	 	
		$('#loadBuscar').on('click',function(){

			goToURLResumenIngreso( );

        });

     $('#loadELiminar').on('click',function(){

			Elimina_rubro( );

        });


		

		var parametros = {
			'tipo' : 'I'  
			};

			$.ajax({
				data: parametros,
				url: "../model/ajax_rubros_regimen.php",
				type: "GET",
				success: function(response)
				{
						$('#rubro_total').html(response);
				}
			});


		
});  
//---------------
function Elimina_rubro( ) {
	
		var id_rol1    = 	$('#id_rol1').val();
		var id_config1 =  	$('#id_config1').val();
									
	  if (id_config1 == '-' ){
					alert('Seleccione Configuracion del rubro');
		       }else{ 
					 alertify.confirm("<p>Desea eliminar la informacion del rubro seleccionado...</p>", function (e) {

							  if (e) {
 									
				 
										 var parametros = {
													 'id_config1'  : id_config1 , 
													 'id_rol1' : id_rol1
										  };
  										   $.ajax({
												 data:  parametros,
												 url: "../model/ajax_elimina_rol_rubro.php",
												 type: "GET",
										       success: function(response)
										       {
					 					    		   $('#ViewSave').html(response);
					 						 	      
										       }
											 }); 
										  goToURLDelVisor();
 									}
						 }); 		
			  }

			
}	
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
			  		$('#mytabs a[href="#tab2"]').tab('show');
                    LimpiarPantalla();
					$("#action").val("add");
					$('#result').html("<b>CREAR UN NUEVO REGISTRO...</b>");
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
/*
*/

function GenerarDatosRegimen( ) {


	alertify.confirm("<p>VA A REALIZAR EL PROCESO DE ROL POR RUBRO Y REGIMEN... ESTA SEGURO? <br><br></p>", function (e) {

		if (e) {
			 
			var periodo      = 	$('#q_periodo').val();
			var rubro_total = 	$('#rubro_total').val();
			var id_rol1     = 	$('#id_rol1').val();
			var regimen     =   $('#regimen').val();

			var parametros = {
							 'periodo' : periodo,
							 'rubro_total' : rubro_total,
							 'id_rol' : id_rol1,
							 'regimen' : regimen
			   };

 

 
				$.ajax({
							data:  parametros,
							url:   '../model/Model-nom_extra_regimen.php',
							type:  'GET' ,
								beforeSend: function () { 
										$("#ViewFormproceso").html('Procesando');
								},
							success:  function (data) {
										$("#ViewFormproceso").html(data);  // $("#cuenta").html(response);
								} 

					}); 


			   
			   

		}

	   }); 


}

// ir a la opcion de editar

function PonerDatos( ) {

    var periodo = 	$('#q_periodo').val();

    var parametros = {
                     'periodo' : periodo
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_horas_view.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewProceso").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewProceso").html(data);  // $("#cuenta").html(response);
  					} 

			}); 
}
//------------------------------------------------------------------------- 

  function goToURL( ){   

		 var id_rol1 			= 	$('#id_rol1').val();
	     var id_config1     	= 	$('#id_config1').val();
	     var id_departamento1   = 	$('#unidad').val();
	     var regimen    		= 	$('#regimen').val();
	     var programa  			= 	$('#programa').val();

	     var parametros = {
	                     'id_rol' 		  : id_rol1, 
	                     'id_config' 	  : id_config1, 
	                     'id_departamento': id_departamento1,
	                     'regimen' 		  : regimen, 
	                     'programa'   	  : programa,
	                     'accion'		  : 'add'
	      };

 
	     
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_extra_grilla.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewProceso").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewProceso").html(data);  // $("#cuenta").html(response);
	  					} 

				}); 

} 

/*
pone informacion de la accion

veraccion('seleccion','1204448086',0)

*/
function veraccion( accion,codigo,col ){   

	var periodo      = 	$('#q_periodo').val();
 	var id_rol1      = 	$('#id_rol1').val();
    var id_config1    = 	$('#id_config1').val();

 
	var parametros = {
					 'periodo' : periodo,
					 'accion': accion,
 					 'id_rol' : id_rol1,
					 'codigo' : codigo ,
					 'col': col,
					 'id_config1':id_config1
 	   };

 
	if ( id_config1) {
		
				$.ajax({
							url:   '../model/ajax_rol_novedad.php',
							data:  parametros,
							type:  'GET' ,
							beforeSend: function () { 
									$("#AccionCreada").html('Procesando');
								},
							success:  function (data) {
									$("#AccionCreada").html(data);  
								} 

					}); 

		}

}   

/*
*/
function VerNovedades( ){   

	 
	 

	
	 $.ajax({
 				   url:   '../model/ajax_ver_accion.php',
				   type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormAccion").html('Procesando');
					 },
				   success:  function (data) {
							$("#ViewFormAccion").html(data);  // $("#cuenta").html(response);
					 } 

		   }); 

}   

//-----------------------------------------------  
function goToURLDelVisor( ){   

	 var id_rol1 			= 	$('#id_rol1').val();
     var id_config1     	= 	$('#id_config1').val();
     var id_departamento1   = 	$('#unidad').val();
     var regimen    		= 	$('#regimen').val();
     var programa  			= 	$('#programa').val();
     

     var parametros = {
                     'id_rol' 		  : id_rol1, 
                     'id_config' 	  : id_config1, 
                     'id_departamento': id_departamento1,
                     'regimen' 		  : regimen, 
                     'programa'   	  : programa,
                     'accion'		  : 'visor'
      };


     
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_extra_grilla.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewProceso").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewProceso").html(data);  // $("#cuenta").html(response);
  					} 

			}); 

}   

//--------------
function go_actualiza(accion,id ){   

	 	if (accion == 'del') { 
 
			  var parametros = {
		                'id' 	   : id, 
		                'accion'   : accion
			   	};

			   $.ajax({
						data:  parametros,
						url:   '../model/Model_nom_extra_save.php',
						type:  'GET' ,
						success:  function (data) {
							
							    $("#ViewSave").html(data); 
							    
							    goToURLDelVisor( );
							    
						} 
				}); 
		  }
 	

	     if (accion == 'visor') { 

			     var id_rol1 			= 	$('#id_rol1').val();

			     var parametros = {
	                     'id_rol' 			  : id_rol1,
	                     'idprov' 			  : id
			     };
 	     

			     $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_fichar_rol.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewFormRolPersona").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewFormRolPersona").html(data);  // $("#cuenta").html(response);

	  					} 
				});
			     
			    $('#myModal').modal('show');  

	     }	
}
//--------------
function go_actualiza_dato(id,valor ){   

	   var accion = 'edit';
  
	   var parametros = {
                'id' 	  : id, 
                'valor'   : valor,
                'accion'  : accion
	   	};

	    $.ajax({
				data:  parametros,
				url:   '../model/Model_nom_extra_save.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ViewSave").html(data);  // $("#cuenta").html(response);
				} 

		}); 
}
//------------------------------------------------------------------------- 
function accion(id, action)
{

  	$('#action').val(action);

	$('#id_config').val(id);
  	
} 
//----------------------------------------------------------------------------------
function modulo()
{

	 var modulo1 =  'kpersonal';

	 var parametros = {
			    'ViewModulo' : modulo1
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
//---------------------------
function FormView()
{
  
	 $("#ViewFiltro").load('../controller/Controller-nom_extra_filtro.php');

}
//-----------------------
//----------------------------------------
function BuscaPrograma( codigo,tipo) {
	   
	 

	if ( tipo == 1 ) {
		
		var regimen   = $("#regimen").val();
		var programa  = codigo;
	}
 
	if ( tipo == 0 ) {
		
		var programa = '-';
		var regimen  = codigo
	}

	
	 var parametros = {
				 'regimen'  : regimen ,
				 'programa' : programa,
				 'tipo' :tipo
	  };
		 
		
	   $.ajax({
			 data:  parametros,
			 url: "../model/ajax_busca_prog.php",
			 type: "GET",
	       success: function(response)
	       {
 
	    	   if ( tipo == 0 ) {
	    		   
	    		   $('#programa').html(response);
  	    		   
	    	   }else{
	    		   
	    		   $('#unidad').html(response);
	    		   
 	    	   }
 	 	        
	    	   BuscaRubro( regimen,programa );
	    	   
	    	   BuscaRubroQuery( regimen) ;
	    	  
	       }
		 });
 
		  
	}
//------------------------------------------------------------------
function BuscaRubro( codigo,programa) {

	 var regimen  = codigo
     var id_rol1 =	$('#id_rol1').val();

	 
 
	 var parametros = {
				 'regimen'  : regimen , 
				 'programa' : programa,
				 'id_rol1' : id_rol1
	  };
	 
	
   $.ajax({
		 data:  parametros,
		 url: "../model/ajax_busca_rubro.php",
		 type: "GET",
       success: function(response)
       {
 
    		   $('#id_config1').html(response);
    	   
	 	        
       }
	 });
 	 
}
//-------
function goToURLResumenDescuento( ){   

		 var id_rol1 			= 	$('#id_rol1').val();
	     var id_config1     	= 	$('#filtroDes').val();
	     var regimen    		= 	$('#regimen').val();

	     var parametros = {
	                     'id_rol' 		  : id_rol1, 
	                     'id_config' 	  : id_config1, 
	                     'regimen' 		  : regimen 
	      };

	     

		  $.ajax({

						data:  parametros,
						url:   '../model/Model-nom_descuento_grilla_m.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewFormDescuento").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewFormDescuento").html(data);  // $("#cuenta").html(response);
	  					} 

				}); 

} 
//--------------------------------------
function BuscaRubroQuery( codigo) {

 	var regimen  = codigo
 
	 var parametros = {
				 'regimen'  : regimen ,
				 'tipo' :  'I' 
 	  };
	 
	
   $.ajax({
		 data:  parametros,
		 url: "../model/ajax_busca_rubrodmatriz.php",
		 type: "GET",
       success: function(response)
       {
 
    		   $('#filtroDes').html(response);
    	   
	 	        
       }
	 });
 	 
}
function goToURLResumenIngreso( ){   

	 var id_rol1 			= 	$('#id_rol1').val();
    var id_config1     	= 	$('#filtroDes').val();
     var regimen    		= 	$('#regimen').val();

    var parametros = {
                    'id_rol' 		  : id_rol1, 
                    'id_config' 	  : id_config1, 
                    'regimen' 		  : regimen ,
                    'tipo'			  : 'I'
     };

    

	  $.ajax({

					data:  parametros,
					url:   '../model/Model-nom_descuento_grilla_m.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormDescuento").html('Procesando');
 					},
					success:  function (data) {
							 $("#ViewFormDescuento").html(data);  // $("#cuenta").html(response);
 					} 

			}); 

} 