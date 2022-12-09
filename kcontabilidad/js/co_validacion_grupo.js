 var oTable ;
 var oTableGasto ;
 var oTableGastoConta ;
 
 var oTableAsiento ;
 var oTableAsientoDev;
 

//-------------------------------------------------------------------------
$(document).ready(function(){
 

	    $("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		oTable =  $('#jsontable').dataTable( {
	 		    "aoColumnDefs": [
	 		      { "sClass": "highlight", "aTargets": [ 1 ] },
	 		      { "sClass": "de", "aTargets": [ 4 ] },
	 		     { "sClass": "sa", "aTargets": [ 7 ] },
	 		      { "sClass": "ye", "aTargets": [ 9 ] }
	 		    ]
	 		  } );
		 
		oTableGasto =  $('#jsontable_grupo_dev').dataTable( {
 		    "aoColumnDefs": [
 		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "sa", "aTargets": [ 2 ] }
 		    ]
 		  } );
		
		oTableGastoConta =  $('#jsontable_grupo_conta').dataTable( {
 		    "aoColumnDefs": [
 		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		     { "sClass": "sa", "aTargets": [ 2 ] },
 		     { "sClass": "sa", "aTargets": [ 3 ] },
 		      { "sClass": "de", "aTargets": [ 4 ] }
 		    ]
 		  } );
		
		  
		  
		 oTableAsiento =  $('#jsontable_asiento_dev').dataTable();
		 
		 oTableAsientoDev =  $('#jsontable_asiento_conta').dataTable();
		 
	 
		
		 
		modulo();
	    FormView();
	    FormFiltro();
  

	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
		});

//-----------------------------------------------------------------
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

				alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			    if (e) {

                    LimpiarPantalla();
                    accion(0,'');
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

///---------------
function irAsiento(idasiento){        
	
    
    var posicion_x; 
    var posicion_y; 
  
    var enlace = '../view/co_validacion_asiento?codigo=' + idasiento  ;
  
  
    
    
    var ancho = 1000;
    
    var alto = 475;
    
   
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }  
///---------------
 function irAsientoPago(idasiento){        
 	
     
     var posicion_x; 
     var posicion_y; 
   
     var enlace = '../view/co_validacion_asiento_pago?codigo=' + idasiento  ;
   
   
     
     
     var ancho = 1000;
     
     var alto = 475;
     
    
     
     posicion_x=(screen.width/2)-(ancho/2); 
     posicion_y=(screen.height/2)-(alto/2); 
     
      window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  
  } 
//-------------
function modalVentana(url){        
	
    
    var posicion_x; 
    var posicion_y; 
  
    var enlace = url ;
  
  
    
    
    var ancho = 1000;
    
    var alto = 475;
    
   
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 } 
 
//-------------------------------------------------------------------------
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

 

     return  today;      

} 

 

  //------------------------------------------------------------------------- 
// busqueda de grupos totales de ingreso y gastos
  function BusquedaGrilla(oTable){        	 


 
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var ftipo   = $("#ftipo").val();

	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'ftipo' : ftipo  
      };

	  
	  //---- grupo ingresos y gastos
	  
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_validacion_grupo.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
				  oTable.fnAddData([
                      s[i][0],
                      '<b> <a href="#" onClick="goGrupo( oTableGasto,'+ "'"+ s[i][0] +"'" + "," + "'" + s[i][1] +"'"  +')">' +s[i][1] + '</a></b>',
                      s[i][2],
                      s[i][3],
                      '<b>' + s[i][4] +'</b>',
					  s[i][5],
					  s[i][6],
					  s[i][7],
					  s[i][8],
					  s[i][9],
					  s[i][10],
					  s[i][11]
                  ]);									
			  } // End For
 			}				
  	  },
		error: function(e){
			   console.log(e.responseText);	
			}

			});

 
 

  }   
 //---------------------------------- 
  function goAsiento( oTableAsiento,cuenta) {

		 
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
 
	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'cuenta' : cuenta   
      };

      var suma = 0;
      var total1 = 0;
      
      var suma1 = 0;
      var total2 = 0;
	  
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_validacion_asiento.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTableAsiento.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
							oTableAsiento.fnAddData([
							         	 '<b> <a href="#" onClick="irAsiento('+ s[i][0]   +')">' +s[i][0] + '</a></b>',
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][4],
										s[i][5],
   		                 ]);	
							suma    =  s[i][4] ;
 						    total1 += parseFloat(suma) ;
							var titulo2  = total1.toFixed(2); 
							$("#devengo45").html(' $ '+ formatNumber(titulo2) );
 						    
						    suma1    =  s[i][5] ;
 						    total2 += parseFloat(suma1) ;
							var titulo3  = total2.toFixed(2); 
							$("#devengo46").html(' $ '+ formatNumber(titulo3) );
 						 
						   

						} // End For
					}				
			},
			error: function(e){
			   console.log(e.responseText);	
			}
		});
		
		$('#mytabs a[href="#tab3"]').tab('show');
		 
} 
//--------------goAsiento_lado_cta
function goAsiento_lado_cta( oTableAsientoDev,item) {
	   
		 
	var ffecha1 = $("#ffecha1").val();
	var ffecha2 = $("#ffecha2").val();

	var parametros = {
			  'ffecha1' : ffecha1  ,
			  'ffecha2' : ffecha2  ,
			  'item' : item   
	};

	   var suma = 0;
	   var total1=0;

	   var suma2 = 0;
	   var total2=0;
	   
	  $.ajax({
		   data:  parametros,
		  url: '../grilla/grilla_co_validacion_asiento_ladoc.php',
		  dataType: 'json',
		  cache: false,
		  success: function(s){
			  oTableAsientoDev.fnClearTable();
				  if(s){
					  for(var i = 0; i < s.length; i++) {
						  oTableAsientoDev.fnAddData([
								'<b> <a href="#" onClick="irAsientoPago('+ s[i][0]   +')">' +s[i][0] + '</a></b>',
									  s[i][1],
									  s[i][2],
									  s[i][3],
									  s[i][4],
									  s[i][5],
									  s[i][6],
									  s[i][7]
						 ]);		
						  
						  suma    =  s[i][5] ;
						   total1 += parseFloat(suma) ;
						   var titulo3  = total1.toFixed(2); 
						   $("#devengo4").html(' $ '+ formatNumber(titulo3) );

						  
						   suma2    =  s[i][6] ;
						   total2 += parseFloat(suma2) ;
						   var titulo3  = total2.toFixed(2); 
						   $("#devengo5").html(' $ '+ formatNumber(titulo3) );
  						  
					  } // End For
				  }				
		  },
		  error: function(e){
			 console.log(e.responseText);	
		  }
	  });
	  
	  $('#mytabs a[href="#tab3"]').tab('show');
	   
}   
  //------------ revision de datos
  function goAsiento_lado( oTableAsientoDev,item) {
	   
		 
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var ftipo   =  $("#ftipo").val();
 
	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'item' : item   ,
				'ftipo' : ftipo
      };

		 var suma = 0;
		 var total1=0;

		 var suma2 = 0;
		 var total2=0;
		 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_validacion_asiento_lado.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTableAsientoDev.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
							oTableAsientoDev.fnAddData([
					         	 '<b> <a href="#" onClick="irAsientoPago('+ s[i][0]   +')">' +s[i][0] + '</a></b>',
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][4],
										s[i][5],
										s[i][6],
										s[i][7]
  		                 ]);		
							
							suma    =  s[i][5] ;
 						    total1 += parseFloat(suma) ;
						    $("#devengo4").html(' $ '+ total1.toFixed(2) );
						    
						    
						    suma2    =  s[i][6] ;
 						    total2 += parseFloat(suma2) ;
						    $("#devengo5").html(' $ '+ total2.toFixed(2) );
						    
						} // End For
					}				
			},
			error: function(e){
			   console.log(e.responseText);	
			}
		});
		
		$('#mytabs a[href="#tab3"]').tab('show');
		 
}   
//-------------- devenadbdo cuenta
  function goGrupoConta( oTableGastoConta,tipo,item) {

		 
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var tipo_cta = $("#tipo_cta").val();
 
	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'fitem' : item  ,
				'tipo' : tipo,
				'tipo_cta':tipo_cta
      };
	  
		 var suma = 0;
		 var total1=0;

		 var suma2 = 0;
		 var total2=0;

		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_validacion_gastoc.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTableGastoConta.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
							oTableGastoConta.fnAddData([
										'<b> <a href="#" onClick="goAsiento_lado( oTableAsientoDev,'+  "'" + s[i][0] +"'"  +')">' +s[i][0] + '</a></b>',
										'<b> <a href="#" onClick="goAsiento_lado_cta( oTableAsientoDev,'+  "'" + s[i][1] +"'"  +')">' +s[i][1] + '</a></b>',
										s[i][2],
										s[i][3],
										s[i][4]
  		                 ]);	
							
							suma    =  s[i][2] ;
							suma2    =  s[i][3] ;

 						    total1 += parseFloat(suma) ;
							total2 += parseFloat(suma2) ;
 						    
							var titulo  = total1.toFixed(2); 
							var titulo2  = total2.toFixed(2); 


						    $("#devengo2").html(' $ '+ formatNumber(titulo) );
							$("#devengo3").html(' $ '+ formatNumber(titulo2) );
						    
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

	 $("#ViewForm").load('../controller/Controller-co_validacion_grupo.php');

      
}
//--------------
 function cerrar_pago(validaDato)

 {

	 

 

	 if (validaDato == 1 )  {

		 

	    alert('No requiere Comprobante de Pago');

	    

 	    $('#myModalPago').modal('hide');

 	    

	 }  

 

 }

 

//-----------------

 function PagoAsiento()

 {

    

	 

	var id = $('#id_asiento').val(); 

	  

 

	 var parametros = {

			 'accionpago' : accion ,

             'id' : id 

     };

	 

     $.ajax({

				data:  parametros,

				url:   '../model/Model-co_asiento_pagos.php',

				type:  'GET' ,

				cache: false,

				beforeSend: function () { 

						$("#result_pago").html('Procesando');

				},

				success:  function (data) {

						 $("#result_pago").html(data);  // $("#cuenta").html(response);

					     

				} 

		}); 

 }
//----------------------
function FormFiltro()

 {

  

	 $("#ViewFiltro").load('../controller/Controller-co_validacion_grupo_filtro.php');

	 

 }
//----------------------
function formatNumber(num) {
    if (!num || num == 'NaN') return '-';
    if (num == 'Infinity') return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + ',' + cents);
}
//-------------- devenado

 function goGrupo( oTableGasto,tipo,item) {

	 
	  var ffecha1 =  $("#ffecha1").val();
	  var ffecha2 =  $("#ffecha2").val();
	  var tipo_cta = $("#tipo_cta").val();
 
	  var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'fitem' : item  ,
				'tipo' : tipo,
				'tipo_cta':tipo_cta
      };

		 
		 var suma = 0;
		 var total1=0;

		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_validacion_gasto.php',
			dataType: 'json',
			cache: false,
			success: function(s){
				oTableGasto.fnClearTable();
					if(s){
						for(var i = 0; i < s.length; i++) {
							oTableGasto.fnAddData([
										s[i][0],
										'<b> <a href="#" onClick="goAsiento( oTableAsiento,'+  "'" + s[i][1] +"'"  +')">' +s[i][1] + '</a></b>',
										s[i][2]
  		                 ]);	
							suma        =  s[i][2] ;
 						    total1     += parseFloat(suma) ;
							var titulo  = total1.toFixed(2); 
						    $("#devengo1").html(' $ '+ formatNumber(titulo) );
						} // End For
					}				
			},
			error: function(e){
			   console.log(e.responseText);	
			}
		});
		
		
		
		
		
		goGrupoConta(oTableGastoConta,tipo,item);
		
		$('#mytabs a[href="#tab2"]').tab('show');
		 
}