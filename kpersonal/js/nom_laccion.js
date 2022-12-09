var oTable;

 





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

function goToURL(accion,id) {

 

 

     var parametros = {

					'accion' : accion ,

                    'id' : id 

 	  };

	  $.ajax({

					data:  parametros,

					url:   '../model/Model-nom_laccion.php',

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

 


	$("#id_accionl").val("");

	$("#nombre").val("");

	$("#legal").val("");

	$("#sesion").val("");

	$("#activo").val("");

	$("#afecta").val("");
	
	$("#tiempo").val("");

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

		    url: '../grilla/grilla_nom_laccion.php',

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

//--------------

 

  function accion(id, action)

  {

   

  	$('#action').val(action);

  	

	$('#id_accionl').val(id);

  	

  

    BusquedaGrilla( oTable);

  	

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

    



	 $("#ViewForm").load('../controller/Controller-nom_laccion.php');

      



 }

    

  