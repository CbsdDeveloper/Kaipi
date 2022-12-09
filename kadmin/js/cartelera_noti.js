var oTable;


  

$(function(){

    $(document).bind("contextmenu",function(e){

        return false;

    });

    window.addEventListener("keypress", function(event){

        if (event.keyCode == 13){

            event.preventDefault();

        }

    }, false);

});

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

   		

	     oTable = $('#jsontable').dataTable(); 

	    

	    BusquedaGrilla( oTable);

 
    

	         

});  

//-----------------------------------------------------------------

function changeAction(tipo,action,mensaje){

 
			if (tipo =="confirmar"){			 
 
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                     
			  		 LimpiarPantalla();
 
					 $("#action").val("add");
 

					 $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');

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

 

//--   () 
function imprimir_informe(){        
	
    
    var posicion_x; 
    var posicion_y; 
    var plantilla = $('#plantilla').val();
    var id_cartelera = $('#id_cartelera').val();
    
    
    var enlace = 'visor_html?id='+plantilla +'&notifica='+id_cartelera;
 
    
    var ancho = 600;
    
    var alto = 475;
    
   
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 } 
//-
function goToURL(accion,id) {
 
 
     var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-cartelera_noti.php',
 					type:  'GET' ,
  					beforeSend: function () { 
  							$("#result").html('Procesando');
   					},
 					success:  function (data) {
 							 $("#result").html(data);   
   					} 
 			}); 

}
//-------------------------------


function EnviarNotificacion( ) {
	 
	
     var plantilla    = $('#plantilla').val();
     var id_cartelera = $('#id_cartelera').val();
     var regimen      = $('#regimen').val();

	 var unidades      = $('#unidades').val();
	 
     var parametros = {
				'plantilla' : plantilla ,
                'id_cartelera' : id_cartelera ,
                'regimen' : regimen,
				'unidades' : unidades
      };
             
	  alertify.confirm("Enviar Notificacion electronica", function (e) {
 		  if (e) {

					  $.ajax({
							data:  parametros,
							url:   '../model/EnvioPersonalNotificacion.php',
							type:  'GET' ,
							beforeSend: function () { 
									$("#ViewEnvio").html('Procesando');
							},
							success:  function (data) {
									 $("#ViewEnvio").html(data);  // $("#cuenta").html(response);
							} 
					}); 
 
 		  }

		 }); 
  
}
 

//-------------------------------------------------------------------------

// ir a la opcion de editar

function LimpiarPantalla() {

  
var fecha = fecha_hoy();
	
	$("#id_cartelera").val("");
	$("#asunto").val("");
	$("#notificacion").val("");
	$("#estado").val("");
	$("#sesion").val("");
	$("#fecha").val(fecha);
	

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

 	  var user = $(this).attr('id');
      var parametros = {
			'GrillaCodigo' : 1  
      };



		if(user != '') 

		{ 

		$.ajax({
 		 	data:  parametros,
 		    url: '../grilla/grilla_cartera.php',
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

 

//-----------------

  function accion(id, action)

  {

   

  	$('#action').val(action);

  	

	$('#id_cartelera').val(id);

  	

  

    BusquedaGrilla( oTable);

  	

  } 

 

  

 function modulo()

 {

   

	 var modulo1 =  'kadmin';

		 

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

   
	 $("#ViewForm").load('../controller/Controller-cartelera_noti.php');
 

 }

    

  