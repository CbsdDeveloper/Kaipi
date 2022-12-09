var oTable;

var oTable_pres;

var oTable_config;

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	   window.addEventListener("keypress", function(event){

	        if (event.keyCode == 13){

	            event.preventDefault();

	        }

	    }, false);

		$("#MHeader").load('../view/View-HeaderModel.php');

		modulo();

	    FormView();

		$("#FormPie").load('../view/View-pie.php');

	       oTable 	= $('#jsontable').dataTable( {      
	           searching: true,
	           paging: true, 
	           info: true,         
	           lengthChange:true ,
	           aoColumnDefs: [
	  		      { "sClass": "highlight", "aTargets": [ 1 ] },
	 		      { "sClass": "ye", "aTargets": [ 5 ] },
	 		      { "sClass": "de", "aTargets": [ 4 ] } 
	 		    ] 
	      } );

	       oTable_pres 	= $('#jsontable_pre').dataTable( {      
	           searching: true,
	           paging: true, 
	           info: true,         
	           lengthChange:true ,
	           aoColumnDefs: [
	  		      { "sClass": "highlight", "aTargets": [ 0 ] },
	 		      { "sClass": "ye", "aTargets": [ 3 ] },
	 		      { "sClass": "de", "aTargets": [ 4 ] } 
	 		    ] 
	      } );
	       
	 	  
	 	  
 
	 	  
	       BusquedaGrillap(oTable_pres);
	       
	       
	      
 	     $('#load').on('click',function(){
 
 		   			BusquedaGrilla(oTable);
 
		});
 
 	     $('#GuardaParametro').on('click',function(){
 	    	 
	   			GuardaRolParametro();

	   });
 	     
 	     
 	    
 	     
 	     
 	    
 	     
 	     $('#LimpiarParametro').on('click',function(){
 	    	 
 	    	$("#cuentai").val("");

			$("#cuentae").val("");
			
			$("#partida").val("");
			 
			$("#programa").val("");		
			
			$("#regimen").val("");	

			$("#accion_parametro").val("add");	
			
			$('#id_config_reg').val('0');
			
			alert('Crear Nuevo Parametro');
	   });
	     
 	    
 	     
 	   //----------------------------------------------------
 	    $.ajax({
 	   		url:   '../controller/Controller-nom_config_regimen.php',
			type:  'GET' ,
			beforeSend: function () { 
					$("#detalle_datos_regimen").html('Procesando');
				},
			success:  function (data) {
					 $("#detalle_datos_regimen").html(data);  

				} 

	}); 
 	     
 
 	    
 	    
 	    
});  

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

// ir a la opcion de editar

function goToURL(accion,id) {
 

     var parametros = {
					'accion' : accion ,
                    'id' : id 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-nom_config.php',

					type:  'GET' ,

 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);   

							 Verparametros(id);
							 
								$("#cuentai").val("");
								$("#cuentae").val("");
								$("#partida").val("");								 
								$("#programa").val("");		
								$("#regimen").val("");	
								$('#id_config_reg').val('0');
  					} 

			}); 


       
}
//-------------- 
function GuardaRolParametro( ) {
	 
	var id_config = $('#id_config').val();
	var regimen = $('#regimen').val();
	var partida = $('#partida').val();
	var cuentai = $('#cuentai').val();
	var cuentae = $('#cuentae').val();
	var programa = $('#programa').val();
	var tipo = $('#tipo').val();
	
	var id_config_reg = $('#id_config_reg').val();
  
	
	
	var cuentai = $('#cuentai').val();
	
	var accion  = $("#accion_parametro").val();	
	
 
    var parametros = {
					'accion' :  accion ,
                    'id_config' : id_config ,
                    'regimen' : regimen ,
                    'partida' : partida ,
                    'cuentai' : cuentai ,
                    'cuentae' : cuentae ,
                    'programa' : programa ,
                    'tipo' : tipo ,
                    'id_config_reg' : id_config_reg
                    
	  };
    
    if ( id_config)  {
	
    	if ( programa ) {
    		
    		if ( regimen ) {
    	
    			$.ajax({
	
						data:  parametros,
	
						url:   '../model/Model-nom_config_regimen.php',
	
						type:  'GET' ,
	
						beforeSend: function () { 
								$("#detalle_datos").html('Procesando');
	 					},
						success:  function (data) {
								 $("#detalle_datos").html(data);  
	
	 					} 
	
				}); 
		  
			$("#cuentai").val("");

			$("#cuentae").val("");
			
			$("#partida").val("");
			
			 
 			
			$("#programa").val("");

    		}
    	}	
    }
}
//-------------- 
function GuardaRolParametroPro( ) {
	 
	$("#accion_parametro").val("add");	
	
	var accion = 'add';
	var id_config = $('#id_config').val();
	var regimen = $('#regimen').val();
	var partida = $('#partida').val();
	var cuentai = $('#cuentai').val();
	var cuentae = $('#cuentae').val();
	var programa = $('#programa').val();
	var tipo = $('#tipo').val();
	
	var id_config_reg = $('#id_config_reg').val();
  
	
	
	var cuentai = $('#cuentai').val();
	
	var accion  = $("#accion_parametro").val();	
	
 
    var parametros = {
					'accion' :  accion ,
                    'id_config' : id_config ,
                    'regimen' : regimen ,
                    'partida' : partida ,
                    'cuentai' : cuentai ,
                    'cuentae' : cuentae ,
                    'programa' : programa ,
                    'tipo' : tipo ,
                    'id_config_reg' : id_config_reg
                    
	  };
    
    if ( id_config)  {
	
    	if ( programa ) {
    		
    		if ( regimen ) {
    	
    			$.ajax({
	
						data:  parametros,
	
						url:   '../model/Model-nom_config_regimen.php',
	
						type:  'GET' ,
	
						beforeSend: function () { 
								$("#detalle_datos").html('Procesando');
	 					},
						success:  function (data) {
								 $("#detalle_datos").html(data);  
	
	 					} 
	
				}); 
		  
			$("#cuentai").val("");

			$("#cuentae").val("");
			
			$("#partida").val("");
			
			$("#regimen").val("");
 			
			$("#programa").val("");

    		}
    	}	
    }
}
//--------------------------------
function Verparametros( id_config ) {
	 
 
    var parametros = {
					'accion' : 'visor' ,
                    'id_config' : id_config 
	  };
    
 		  $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_config_regimen.php',
						type:  'GET' ,
						beforeSend: function () { 
								$("#detalle_datos").html('Procesando');
	 					},
						success:  function (data) {
								 $("#detalle_datos").html(data);  
 	 					} 
	
				}); 
     
}
//----------------------------
function goToActiva( accion, codigo ) {
	 
 
    var parametros = {
					'accion' : accion,
                    'codigo' : codigo 
	  };
    
 		  $.ajax({
						data:  parametros,
						url:   '../controller/Controller-nom_config_regimen.php',
						type:  'GET' ,
						beforeSend: function () { 
								$("#detalle_datos_regimen").html('Procesando');
	 					},
						success:  function (data) {
 								 $("#detalle_datos_regimen").html(data);  
 	 					} 
	
				}); 
     
}


///--------------
function Verparametros__regimen( ) {
	 

	var id_config = $('#id_config').val();
	
	var regimen = 	$("#regimen").val();	
	 
    var parametros = {
					'accion' : 'visor' ,
                    'id_config' : id_config ,
                    'regimen' : regimen
	  };
    
 
	
		  $.ajax({
	
						data:  parametros,
	
						url:   '../model/Model-nom_config_regimen01.php',
	
						type:  'GET' ,
	
						beforeSend: function () { 
								$("#detalle_datos").html('Procesando');
	 					},
						success:  function (data) {
								 $("#detalle_datos").html(data);  
	
								  
	 					} 
	
				}); 
     
}
//--------goToURLParametro
function goToURLParametro( accion,id_config_reg) {
	 
	 
	var regimen = 	$("#regimen").val();	
	 	
	var id_config = $('#id_config').val();
	 
    var parametros = {
					'accion' : accion ,
					'id_config_reg' : id_config_reg,
                    'id_config' : id_config ,
                    'regimen':regimen
	  };
    
 
    if ( accion == 'del') {
	
		  $.ajax({
	
						data:  parametros,
	
						url:   '../model/Model-nom_config_regimen.php',
	
						type:  'GET' ,
	
						beforeSend: function () { 
								$("#detalle_datos").html('Procesando');
	 					},
						success:  function (data) {
								 $("#detalle_datos").html(data);  
	
	 					} 
	
				}); 
		  
    }	 
    
    if ( accion == 'visor') {
    	 
    	 var fila = id_config_reg;
    	 
      	 var  programa =  document.getElementById('tabla_config').tBodies[0].rows[fila].cells[1].innerHTML;
      	 var  regimen  = document.getElementById('tabla_config').tBodies[0].rows[fila].cells[2].innerHTML;
      	 
      	 var  cuentai  = document.getElementById('tabla_config').tBodies[0].rows[fila].cells[5].innerHTML;
      	 var  cuentae  =  document.getElementById('tabla_config').tBodies[0].rows[fila].cells[6].innerHTML;
      	 
     	 var  partida 	    = document.getElementById('tabla_config').tBodies[0].rows[fila].cells[4].innerHTML;
     	 var  id_config_reg = document.getElementById('tabla_config').tBodies[0].rows[fila].cells[0].innerHTML;
		  
     	 var clasificador = partida.trim();
     	var cuentaee = cuentae.trim();
     	 
      	
     	 $('#programa').val(programa.trim());
     	 $('#regimen').val(regimen.trim());
    	 $('#cuentai').val(cuentai.trim());
     	 $('#cuentae').val(cuentaee);
     	 $('#partida').val(clasificador);
     	 $('#id_config_reg').val(id_config_reg);
     	 
     	 $('#accion_parametro').val('editar');
    	
 
    }
		  
		   if ( accion == 'editar') {
			
 				 
		  			$('#myModalPrograma').modal('show');
		  			
 		  			 
		  			 $('#id_config_reg').val(id_config_reg);
		  			 	 

   		 }
		  
   
     
}
//-------------------------------------------------------------------------
// ir a la opcion de editar

function LimpiarPantalla() {
   

	$("#id_config").val("");

	$("#tipo").val("");

	$("#nombre").val("");

	$("#estado").val("");

	$("#estructura").val("");

	$("#formula").val("");

	$("#cuentai").val("");

	$("#cuentae").val("");
	
	$("#partida").val("");

	$("#monto").val("");

	$("#variable").val("");

	$("#tipoformula").val("");

	$("#regimen").val("");
	
	Verparametros( 0 );
	
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

    

    document.getElementById('fechatarea').value = today ;

    

    document.getElementById('fechafinal').value = today ;

    

    $("#tarea").val("");

	

    $("#tareaproducto").val("");

            

} 

 

  //------------------------------------------------------------------------- 

  function BusquedaGrilla(oTable){        	 
 	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
  
		var user = $(this).attr('id');
     	var tipo = $("#q_tipo").val();

      var parametros = {

				'tipo' : tipo  

      };



		if(user != '') 

		{ 

		$.ajax({

		 	data:  parametros,

		    url: '../grilla/grilla_nom_config.php',

			dataType: 'json',

			success: function(s){

			console.log(s); 

			oTable.fnClearTable();

			

			if (s) { 

				

			

			for(var i = 0; i < s.length; i++) {

			    	oTable.fnAddData([

							s[i][0],
							s[i][1],
							s[i][2],
 	                        s[i][3],
                          s[i][4],
                          s[i][5],
                          s[i][6],
                          	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+"'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
							'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ "'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 

						]);										

					}  
		 		

			   }

			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});

		}

 	

  }   

  
  function BusquedaGrillap(oTable_pres){        	 
	  
			$.ajax({

 			    url: '../controller/Controller-nom_presu_regimen.php',
				dataType: 'json',
				success: function(s){
				console.log(s); 
				oTable_pres.fnClearTable();

				if (s) { 

				for(var i = 0; i < s.length; i++) {
					
					oTable_pres.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
	 	                        s[i][3],
	 	                       s[i][4]
 							]);										
 						}  
 				   }

				},

				error: function(e){

				   console.log(e.responseText);	

				}

				});
 }    
  
 //-------- 
    function GenerarPrograma(  ) {
	   
 		
 		  			 
		var id_config_reg = $('#id_config_reg').val();
		  			 
		var programap =  $('#programap').val();  			 
		  			 
		 var parametros = {
 					 'id_config_reg' : id_config_reg,
 					 'programap' : programap
		  };
			 
			
		   $.ajax({
				 data:  parametros,
				 url: "../model/ajax_partida_progama.php",
				 type: "GET",
		       success: function(response)
		       {
 		    		   
		    		   $('#result').val(response);
		    		   
 		        
		       }
			 });
	 
	 Verparametros__regimen();
			 
		}
//--------------

  function PonePartida( cuenta) {
	   
 		
		 var parametros = {
 					 'cuenta' : cuenta
		  };
			 
			
		   $.ajax({
				 data:  parametros,
				 url: "../model/ajax_partida_cuenta.php",
				 type: "GET",
		       success: function(response)
		       {
 		    		   
		    		   $('#partida').val(response);
		    		   
		    	  
		        
		       }
			 });
	 
			 
		}
//---
  
  function PoneCuenta( cuenta) {
	   
		
	  
	  var parametros = {
			  'cuenta' : cuenta 
			  };
					  $.ajax({
					  data: parametros,
					  url: "../model/ajax_cuenta_nom_lista.php",
					  type: "GET",
						  success: function(response)
						  {
							  	$('#cuentai').html(response);
						  }
			  });
			  
			  
			 
	 
			 
		}
 
   
//-----------------

function accion(id, action)
{

  	$('#action').val(action);

	$('#id_config').val(id);

	BusquedaGrilla(oTable);

	
} 

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
//-----------------
function FormView()
{

	 $("#ViewForm").load('../controller/Controller-nom_config.php');


 	$("#ViewFormPrograma").load('../controller/Controller-nom_config_prog.php');
 



}

    

  