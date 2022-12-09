 

$(document).ready(function(){
     
         modulo(); 

		$("#MHeader").load('../view/View-HeaderModel.php');

	    $("#FormPie").load('../view/View-pie.php');
  		 
	    
	    $('#load311').on('click',function(){
	    	 
	    	BusquedaGrilla_total();
 
		});
	    
	    
		var today = new Date();
		var yyyy = today.getFullYear();

	    $("#anio").val(yyyy);
		
		
  
	    $('#loadxls').on('click',function(){
	  	  var ffecha1 = $("#ffecha1").val();
		  var ffecha2 = $("#ffecha2").val();
		  var festado = $("#festado").val();
		  var cadena = 'festado='+festado+'&ffecha1='+ffecha1+'&ffecha2='+ffecha2;
		  var page = "../reportes/excel.php?"+cadena;  
		  window.location = page;  
 
		});
 
		var j = jQuery.noConflict();
	    
	    //-- imprime balance de comprobancion

		j("#loadp11").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#ViewBalancePrint1").printArea( options );

		});

		j("#loadp41").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};

		  j("#reporte_detalle").printArea( options );

	});


		
	 
			$("#loadxls31").click(function(e) {
		        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewBalancePrint1').html()));
		        e.preventDefault();
	 	    });
			
			

			 
			 $("#ViewForm").load('../controller/control_anticipo.php');

			 
		 
})

//------
function BusquedaAux(){        	 
	  
	 var anio = $("#anio").val();
      
     var cuenta  =  $("#cuenta1").val();
 
     var parametros = {
				'anio' : anio  ,
				'cuenta' : cuenta  
       };
     
     
     $.ajax({
			data:  parametros,
			url:   '../model/Model_listaAuxTotal.php',
			type:  'GET' ,
			beforeSend: function () { 

					$("#ViewFormAuxc").html('Procesando');

			},
			success:  function (data) {
				 $("#ViewFormAuxc").html(data);   

			} 
	});	 


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

  function BusquedaGrilla(){        	 

	  
	  

	  var tipo = $("#tipo").val();
 	  var anio = $("#anio").val();

	  

 

      var parametros = {
 				'tipo' : tipo  ,
 				'anio' : anio   
       };
      
      
 
		$.ajax({
			data:  parametros,
		    url: '../grilla/grilla_xpagar_aux.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();

			if(s){

				for(var i = 0; i < s.length; i++) {

					  oTable.fnAddData([
 	                      s[i][0],
 	                      s[i][1] , 
 	                      s[i][2],
 	                      s[i][3]  , 
 	                      '<button class="btn btn-xs btn-warning" title= "Detalle de transacciones del auxiliar"  onClick="goToURLNovedad('+ "'" +s[i][0]+ "',"+ "'" + s[i][1] +"'"  +')"><i class="glyphicon glyphicon-info-sign"></i></button>'
  
 	                  ]);									
  					  
				}  
  
			}				
 
			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});
 
 

  }   
/*
BUSQUEDA DE TRAMITES DE ANTICIPOS FINANCIEROS
*/
  function BusquedaGrilla_total(){        	 

	   
	  
	  var anio = $("#anio").val();
       
      var bandera =  $("#bandera").val();  
 
      var parametros = {
 				'anio' : anio  ,
  				'bandera' : bandera   
       };
      
      
      $.ajax({
			data:  parametros,
			url:   '../model/Model_listaAuxq_total.php',
			type:  'GET' ,
			beforeSend: function () { 

					$("#ViewFormAuxc1").html('Procesando');

			},
			success:  function (data) {
				 $("#ViewFormAuxc1").html(data);   

			} 
	});	 

      
		 
		 

  }  
//---------------------------------
 function BusquedaGrillaa(){        	 

	  
	  
 
	  var anio = $("#anio").val();
      var prove =  $("#prove").val();
      
      var cuenta  =  $("#cuenta").val();
      var bandera =  $("#bandera").val();  
 
      var parametros = {
 				'anio' : anio  ,
 				'cuenta' : cuenta   ,
 				'prove' : prove  ,
 				'bandera' : bandera   
       };
      
      
      $.ajax({
			data:  parametros,
			url:   '../model/Model_listaAuxq.php',
			type:  'GET' ,
			beforeSend: function () { 

					$("#ViewFormAux").html('Procesando');

			},
			success:  function (data) {
				 $("#ViewFormAux").html(data);   

			} 
	});	 

      
		 
		 

  }   
//------------------------------------------------------------------------- 
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
			cache: false,
			beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				} 

	});

 }
 //-------

 function abrirReporte(idprov) {

 
	var parametros = {
			   'idprov' : idprov 
 };

   $.ajax({

		  data:  parametros,
		   url:   '../controller/Controller-anticipo.php',
		  type:  'GET' ,
		  cache: false,
		  beforeSend: function () { 
					  $("#ViewFormDetalle").html('Procesando');
			  },
		  success:  function (data) {
				   $("#ViewFormDetalle").html(data);  // $("#cuenta").html(response);
			  } 

  });

  $('#mytabs a[href="#tab2"]').tab('show');
  
  
}
//----------------- 
function imprimir(nombreDiv) {

	

    var contenido= document.getElementById(nombreDiv).innerHTML;

    

     var contenidoOriginal= document.body.innerHTML;



     document.body.innerHTML = contenido;



     window.print();



     document.body.innerHTML = contenidoOriginal;

      

}
  
 



//------------------------------------------------------------------------- 

 function ViewDetAuxiliar(codigoAux)

 {

   

 	 var parametros = {

			    'codigoAux' : codigoAux 

    };

 	 

 	$.ajax({

			data:  parametros,

			 url:   '../controller/Controller-co_asientos_aux01.php',

			type:  'GET' ,

			cache: false,

			beforeSend: function () { 

						$("#ViewFiltroAux").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewFiltroAux").html(data);  // $("#cuenta").html(response);

				     

				} 

	});

 

 }

//----------------------------------------------
 

function openFile(url,ancho,alto) {

	   var posicion_x; 
       var posicion_y; 
       var enlace; 
 

  posicion_x=(screen.width/2)-(ancho/2); 

  posicion_y=(screen.height/2)-(alto/2); 
 
  enlace = url  ;
 
  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

}
 