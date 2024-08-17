var oTablea;  
var oTablec;  


$(document).ready(function(){
     
      
        
        oTable =  $('#jsontable').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 1] },
		      { "sClass": "ye", "aTargets": [ 3 ] },
 		      
		    ] ,
		    "language":  [ {
	            "decimal": ",",
	            "thousands": "."
	           }
		    ] 
          } 
        );
        
    
        
        modulo(); 

		$("#MHeader").load('../view/View-HeaderModel.php');

	    $("#FormPie").load('../view/View-pie.php');
  		
	    $("#ViewFormAux").load('../controller/Controller-co_aux.php');
	    
	   
	    $('#load').on('click',function(){
 
            BusquedaGrilla();
 
		});

		$('#load30').on('click',function(){
 
            BusquedaGrilla30();
 
		});


	    $('#load2').on('click',function(){
	    	 
            BusquedaGrillaa();
 
		});
	    
	    
	    $('#load21').on('click',function(){
	    	 
            BusquedaAux();
 
		});
	 
	    
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
 
	    $.ajax({
 			url: "../model/Model_aux_resumen_det.php",
			type: "GET",
			success: function(response)
			{
					$('#cuenta1').html(response);
			}
		});
 
		$("#loadxls21").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewFormAuxc').html()));
	        e.preventDefault();
 	    });
		
	    var j = jQuery.noConflict();
	    
		j("#loadp").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};
			  j("#ViewBalancePrint").printArea( options );
		});

		
		  var j = jQuery.noConflict();
		    
			j("#loadp11").click(function(){
					var mode = 'iframe'; //popup
					var close = mode == "popup";
					var options = { mode : mode, popClose : close};
				  j("#ViewBalancePrint1").printArea( options );
			});
			
			
			$("#loadxls31").click(function(e) {
		        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewBalancePrint1').html()));
		        e.preventDefault();
	 	    });
			
			

			 
		 
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
			url:   '../model/Model_listaAuxTotal_b.php',
			type:  'GET' ,
			beforeSend: function () { 

					$("#ViewFormAuxc").html('Procesando');

			},
			success:  function (data) {
				 $("#ViewFormAuxc").html(data);   

			} 
	});	 


 } 
//---- 
function changeAction(tipo,action,mensaje){

	 

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 
			  		//$('#mytabs a[href="#tab2"]').tab('show');

                	

				  	LimpiarDatos();

				  

                    LimpiarPantalla();

 

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
 //--------------
  function BusquedaGrilla_total(){        	 

	  
	  
	  
	  var anio = $("#anio").val();
       
      var cuenta  =  $("#cuenta131").val();
      
      var bandera =  $("#bandera").val();  
 
      var parametros = {
 				'anio' : anio  ,
 				'cuenta' : cuenta   ,
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
 //---------- 
 function BusquedaGrilla30(){        	 

	  
	  
 
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
		  url:   '../model/Model_listaAuxq30.php',
		  type:  'GET' ,
		  beforeSend: function () { 

				  $("#ViewFormAux").html('Procesando');

		  },
		  success:  function (data) {
			   $("#ViewFormAux").html(data);   

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
function imprimir(nombreDiv) {

	

    var contenido= document.getElementById(nombreDiv).innerHTML;

    

     var contenidoOriginal= document.body.innerHTML;



     document.body.innerHTML = contenido;



     window.print();



     document.body.innerHTML = contenidoOriginal;

      

}
 
//----------------------

 function accion(id,modo,estado)

 {

  

	if (id > 0){

		 

  			 if (modo == 'aprobado'){

					$("#action").val('aprobado');

					$("#estado").val('aprobado');          

					$("#comprobante").val(estado);       

			 }else{

					$("#action").val(modo);

					$("#estado").val(estado);          

		 	 }

			 		

			  $("#id_asiento").val(id);

		 			 

		 			 

			 

		 		//		 BusquedaGrilla(oTable);

	 

	}



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

//--------------------

function goToURLNovedad( id , nombre) {

	  var anio = $("#anio").val();

	  $("#prove").val( id );
	  
	  $("#ViewProveedor").html( nombre );
	  
	 
	  
 	   var parametros = {
	 						    'idprov' : id  ,
	 						    'anio' : anio
	  	};
 
		$.ajax({
			data: parametros,
			url: "../model/Model_aux_resumen_cta.php",
			type: "GET",
			success: function(response)
			{
					$('#cuenta').html(response);
			}
		});
 	   
 
		
 	  $('#mytabs a[href="#tab2"]').tab('show');
}