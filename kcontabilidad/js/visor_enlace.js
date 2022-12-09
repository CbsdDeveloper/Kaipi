var oTable ;

//-------------------------------------------------------------------------

$(document).ready(function(){
    
       "use strict" ;

        oTable = $('#jsontable').dataTable(); 
 
		$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		 modulo();

	     FormView();

	     FormFiltro();
		
	   

	      $('#load').on('click',function(){

            BusquedaGrilla(oTable);

		  });
 
	 

});  

//----------------------------------------------------
 
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){


			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
			  		//$('#mytabs a[href="#tab2"]').tab('show');
				  	LimpiarDatos();
                    LimpiarPantalla();

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

function goToURL(accion,id, idp) {

  

	var parametros = {
					'accion' : accion ,
                    'id'     : id ,
                    'idp' : idp
 	  };


 

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-visor_enlace.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {

							 $("#result").html(data);  // $("#cuenta").html(response);
							 
							 if ( accion== 'del') {
								 alert('Actualizado el item');
							 }
  					} 

			}); 

 	  
     }

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// ir a la opcion de editar

function LimpiarPantalla() {

	

		var fecha = fecha_hoy();

 

 }

//ir a la opcion de editar

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
	 
	  "use strict" ;
	  
	  var ffecha1 = $("#ffecha1").val();

	  var ffecha2 = $("#ffecha2").val();
	  
	

	  

	  var idprove = '-' ;  
	  
	  BusquedaGrillaAll(oTable,ffecha1,ffecha2,idprove) ;
	  
 
 
 }
 //------------------------------------
 function AbrirEnlace()
 {

 	 

 	 var id_asiento = $("#id_asiento").val();
   
 if (id_asiento > 0 ) {

   var enlace = 'co_validacion_asiento_ve?codigo=' +id_asiento;

    window.open(enlace,'#','width=750,height=480,left=30,top=20');
 	    	  
 }

 	 
  
 }	
 //------------------------------------
 function DetalleAsiento(id,item)
 {
       
 	  var parametros = {
  			    'id' : id ,
  			    'item' : item,
  			    'accion' : 1
       };

 	 $.ajax({
		 data:  parametros,
		 url: "../model/_partida_tramite_asiento.php",
		 type: "GET",
       success: function(response)
       {
           $('#partida').html(response);
       }
	 });

 	 //-------------------------------------------------
 	
	  var parametros1 = {
			    'id' : id ,
			    'item' : item,
			    'accion' : 2
     };

	 $.ajax({
		 data:  parametros1,
		 url: "../model/_partida_tramite_asiento.php",
		 type: "GET",
     success: function(response)
     {
         $('#partidap').html(response);
     }
	 });
 	 
}
 //------------------------------------------------------------------------- 
  function BusquedaGrillaAll(oTable,ffecha1,ffecha2,idprove){        	 
 

	  var suma = 0;
	  var total1 = 0;
	  
	  var cuentaa = $("#cuentaa").val();
	  

	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'idprove' : idprove,
				'cuentaa' : cuentaa
       };

		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_visor_enlace.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTable.fnAddData([
	                      s[i][0],
	                      s[i][1],
	                      s[i][2],
	                      s[i][3],
	                      s[i][4],
	                      s[i][5],
	                      s[i][6],
	                      s[i][7],
	                     '<button title = "Seleccionar el registro para el pago" class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0]+",'" + s[i][1] + "'" +')"><i class="glyphicon glyphicon-ok"></i></button>&nbsp;'  +
	                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0]+",'" + s[i][1] + "'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
	                  ]);		

					  suma  =  s[i][6] ;

					  total1 += parseFloat(suma) ;

					  $("#totalPago").html('$ '+ total1.toFixed(2) );

 				} // End For

 			}				

			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});
 
}   
//-------------------------------------------------------------------
  function BusquedaGrillaProv(oTable,ffecha1,ffecha2,idprove){        	 
	  
	  var suma = 0;
	  var total1 = 0;

	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'idprove' : idprove
       };
 		
 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_te_pagos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTable.fnAddData([
	                      s[i][0],
	                      s[i][1],
	                      s[i][2],
	                      s[i][3],
	                      s[i][4],
	                      s[i][5],
	                     '<div align="right">' +  s[i][6] + '</div>', 
	                     '<input type="checkbox" id="myCheck'+ s[i][0] +'"   onclick="myFunction('+ s[i][0] +',this)" '   + '>'   
	                  ]);		

 					  suma  =  s[i][6] ;
					  total1 += parseFloat(suma) ;
					  $("#totalPago").html('$ '+ total1.toFixed(2) );

 				} // End For
 			}				

			},
			error: function(e){
			   console.log(e.responseText);	
			}

			});

   }    


//------------------------------------------------------------------------- 

 function modulo()

 {

 	 var modulo1 =  'kcontabilidad';

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

//-----------------

 function FormView()
{

	 $("#ViewForm").load('../controller/Controller-visor_enlace.php');

}
//----------------------
 function FormFiltro()
{

	 $("#ViewFiltro").load('../controller/Controller-visor_filtro.php');

}
//----------------------
//----------------------
 function accion(idasiento,id,modo,comprobante)
 {

	  $("#action").val('editar');
 
 

 }

 

//---------------

 function NaN2Zero(n){

	    return isNaN( n ) ? 0 : n; 

	}
 
//---------------------------------------------------
   
