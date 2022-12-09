 var oTable;
var modulo_sistema     =  'kpersonal';
 

//-------------------------------------------------------------------------
$(document).ready(function(){
		 

		$("#MHeader").load('../view/View-HeaderModel.php');

		modulo();

		FormView()

       oTable 	= $('#jsontable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
           aoColumnDefs: [
  		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "ye", "aTargets": [ 1 ] },
 		      { "sClass": "de", "aTargets": [ 4 ] } 
 		    ] 
      } );
       
       
		$("#FormPie").load('../view/View-pie.php');

		$.ajax({
 			 url: "../model/ajax_unidad_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qunidad').html(response);
	       }
		 });
	    
	    $.ajax({
			 url: "../model/ajax_regimen_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qregimen').html(response);
	       }
		 });
	    
	    
	    $('#load').on('click',function(){
 		   			BusquedaGrilla(oTable);
		});

 
		 var j = jQuery.noConflict();

			j("#loadPrint").click(function(){
					var mode = 'iframe'; //popup

					var close = mode == "popup";

					var options = { mode : mode, popClose : close};

					j("#ViewResumenRol").printArea( options );

			});


			
});  

//-----------------------------------------------------------------
function BusquedaGrilla(oTable){        	 

  		var user     = $(this).attr('id');
     	var qestado  = $("#qestado").val();
     	var qunidad  = $("#qunidad").val();
     	var qregimen = $("#qregimen").val();

     
       var parametros = {
				'qestado' : qestado  ,
				'qunidad' : qunidad,
				'qregimen' : qregimen

      };

 
		if(user != '')  { 

		$.ajax({
 		 	data:  parametros,
		    url: '../grilla/grilla_nom_ingreso.php',
			dataType: 'json',
			success: function(s){
			oTable.fnClearTable();
			if (s){ 
					for(var i = 0; i < s.length; i++) {
						oTable.fnAddData([
 							s[i][0],
 							s[i][1],
 							s[i][2],
  	                        s[i][3],
                            s[i][4],
                            s[i][5],
                            s[i][6],
                           	'<button class="btn btn-xs btn-warning" title="EDITAR REGISTRO SELECCIONADO"   onClick="goToURL('+"'editar'"+','+"'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' 
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
//-------------------------------------------------------------------------

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

function accion(id, action)
  {
  	$('#action').val(action);
  	 
} 
//------------
  function goToURL( accion,id){   

	   var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };

	var bandera = 0;	

 	
	 	  

			if ( accion == 'editar'){
				bandera = 1;	
			}	


			if ( bandera == 1 ) {

				  $.ajax({
								data:  parametros,
								url:   '../model/Model-nom_ingreso_datos.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#result").html('Procesando');
			  					},
								success:  function (data) {
												if ( accion == 'del'){
														alert(data);
												} else	{
														$("#result").html(data);   
														 

													 
												}
 			  				
				 				}	
				}); 	
			} 	 
		  
 
}   
//----------- 
function goToDeta1( accion, nombre){   

 
	     var banio 			= 	$('#banio').val();
	     var idprov  	    = 	$('#idprov').val();
	   

	     var parametros = {
	                     'banio' 		  : banio, 
	                     'idprov': idprov ,
	                     'accion' :accion,
	                     'tipo': 1,
	                     'nombre' : nombre
	      };

 	 
	      
		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_personal_rol02.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewFormRolPersona").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewFormRolPersona").html(data); 

	  					} 

				}); 
 
 
 $('#myModal').modal('show');

} 
function goToDeta2( accion, nombre){   

 
	     var banio 			= 	$('#banio').val();
	     var idprov  	    = 	$('#idprov').val();
	   

	     var parametros = {
	                     'banio' 		  : banio, 
	                     'idprov': idprov ,
	                     'tipo': 2,
	                     'accion' :accion,
	                     'nombre' : nombre
	      };

 	 
	      
		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_personal_rol02.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewFormRolPersona").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewFormRolPersona").html(data); 

	  					} 

				}); 
 
 
 $('#myModal').modal('show');

} 
//--------------------------------------------
function goToRol(accion, id_rol1)
  {
  	 
  	 var id =  	$('#idprov').val();
  	 
  	   var url = '../../reportes/view_rol_nomina.php'

	       var posicion_x; 
	       var posicion_y; 
	       var enlace = url + '?codigo='+id +'&id_rol=' + id_rol1+ '&accion='+accion;

	       var ancho = 1000;

	       var alto = 520;

	       posicion_x=(screen.width/2)-(ancho/2); 
	       posicion_y=(screen.height/2)-(alto/2); 

	       window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  	 
} 
  
//----------------
 function ProcesoInformacion( ){   

 
	     var banio 			= 	$('#banio').val();
	     var idprov   = 	$('#idprov').val();
	   

	     var parametros = {
	                     'banio' 		  : banio, 
	                     'idprov': idprov 
	      };

 		var parametros1 = {
	                     'banio' 		  : banio, 
	                     'idprov': idprov 
	      };
	      
		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_personal_rol00.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#Viewrol").html('Procesando');
	  					},
						success:  function (data) {
								 $("#Viewrol").html(data); 

	  					} 

				}); 
				
				
			
			 $.ajax({
						data:  parametros1,
						url:   '../model/ajax_personal_rol01.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#ViewResumen").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewResumen").html(data); 

	  					} 

				}); 	
				
				

} 
   

 
 
//---------------------------
function ImprimirActa( id_certifica ) {

	
	 
	 
	 
	if ( id_certifica > 0 )    {
		
		var url = '../../kpresupuesto/reportes/certificacion_nomina'
		
	}else  {
		
		var url = '../../kpresupuesto/reportes/certificacion_nomina'
			
		id_certifica = $("#certificado").val( );  
	}	

		
 
		    var posicion_x; 
		    var posicion_y; 
		    
		    var enlace = url + '?codigo='+id_certifica    ;
		    
		    var ancho = 1000;
		    
		    var alto = 520;
		    
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	
	
	
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

	  

	  $("#ViewForm").load('../controller/Controller-nom_ingreso_datos.php');

}