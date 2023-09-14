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
		
		$("#ViewFiltroAux").load('../controller/Controller-co_aux_pago.php');
	   
		$("#ViewFiltroCxp").load('../controller/Controller-co_aux_pago01.php');
		
		

	    $('#load').on('click',function(){
 
            BusquedaGrilla();
 
		});

	    $('#load2').on('click',function(){
	    	 
            BusquedaGrillaa();
 
		});
	    
	    
	   $('#load28').on('click',function(){

			$("#parcial").val('0');

		
            BusquedaGrillaa_resumen();
 
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
 
})

 
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
 	                      '<button class="btn btn-xs btn-warning" title= "Detalle de transacciones del auxiliar" onClick="goToURLNovedad('+ "'" +s[i][0]+ "',"+ "'" + s[i][1] +"'"  +')"><i class="glyphicon glyphicon-info-sign"></i></button>'
  
 	                  ]);									
  					  
				}  
  
			}				
 
			},

			error: function(e){

			   console.log(e.responseText);	

			}

			});
 
 

  }   
 //-----------
 function Marca_Datos(estado_seleccion){        	 

	  
	var anio    = $("#anio").val();
	var prove   =  $("#prove").val();
	var cuenta  =  $("#cuenta").val();
	var bandera =  $("#bandera").val();  
	var cmes =  $("#cmes").val();  

	var marca =  estado_seleccion;  
	
 
	var parametros = {
			   'anio' : anio  ,
			   'cuenta' : cuenta   ,
			   'prove' : prove  ,
			  'bandera' : bandera   ,
			  'cmes' : cmes,
			  'marca': marca
	 };
	
	
	$.ajax({
		  data:  parametros,
		  url:   '../model/Model_listaAuxqSRI_marca.php',
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
 function BusquedaGrillaa_resumen(){        	 

	  
	  var anio    = $("#anio").val();
      var prove   =  $("#prove").val();
      var cuenta  =  $("#cuenta").val();
	  var bandera =  $("#bandera").val();  
      var cmes =  $("#cmes").val();  
	  
      var parametros = {
 				'anio' : anio  ,
 				'cuenta' : cuenta   ,
 				'prove' : prove  ,
				'bandera' : bandera   ,
				'cmes' : cmes
       };
      
      
      $.ajax({
			data:  parametros,
			url:   '../model/Model_listaAuxqSRI_res.php',
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

	  
	  var anio    = $("#anio").val();
      var prove   =  $("#prove").val();
      var cuenta  =  $("#cuenta").val();
	  var bandera =  $("#bandera").val();  
      var cmes =  $("#cmes").val();  
	  
      var parametros = {
 				'anio' : anio  ,
 				'cuenta' : cuenta   ,
 				'prove' : prove  ,
				'bandera' : bandera   ,
				'cmes' : cmes
       };
      
      
      $.ajax({
			data:  parametros,
			url:   '../model/Model_listaAuxqSRI.php',
			type:  'GET' ,
			beforeSend: function () { 

					$("#ViewFormAux").html('Procesando');

			},
			success:  function (data) {
				 $("#ViewFormAux").html(data);   

			} 
	});	 
 
  

  }   

//-----SumaTotal  
function SumaTotal(total,objeto)
 {
 
	var total_dato =  $("#parcial").val();

	var base    = parseFloat(total_dato)  ;
	var parcial = parseFloat(total) ;

	var total = 0;

	if (objeto.checked == true){
 		estado = 'S'

		 total = base + parcial;

		 var base1    = parseFloat(total).toFixed(2)  ;

		 $("#parcial").val(base1);

	} else {

		estado = 'N'

		total = base - parcial;

		var base1    = parseFloat(total).toFixed(2)  ;

		$("#parcial").val(base1);

	}

	$("#ViewParcial").html('<h4><b>' + base1 + '</b><h4>');

 }  
//------------------------------------------------------------------------- 
function myFunction(proveedor,codigo,objeto)

 {
 
	   var estado 		  =  '';

 


	    if (objeto.checked == true){

	    	estado = 'S'

	    } else {

	    	estado = 'N'

	    }

	    

	    var parametros = {

 
                'idaux' : codigo ,
				'estado':estado ,
				'proveedor' : proveedor,
                'bandera': 'S'

	  };

 
	    	 

		      $.ajax({

						data:  parametros,

						url:   '../model/Model-co_lista_sri.php',

						type:  'GET' ,

						cache: false,

						beforeSend: function () { 

									$("#ViewData").html('Procesando');

							},

						success:  function (data) {

								 $("#ViewData").html(data);   

							     

							} 

				}); 

		 
 	

 }
//------------------------------------------------
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

//-
function TotalSeleccion( ) {

	  var anio = $("#anio").val();

 	 var id =  $("#prove").val(  );
 
	 
	  
 	   var parametros = {
								  'anio' : anio,
								   'idprov' : id  
	  	};
 
	 $.ajax({

			data:  parametros,

			 url:   '../model/ajax_SeleccionPagoAux.php',

			type:  'GET' ,

			cache: false,

			beforeSend: function () { 

						$("#ViewFormTotal").html('Procesando');

				},

			success:  function (data) {

					 $("#ViewFormTotal").html(data);  // $("#cuenta").html(response);

				     

				} 

	});


}
//---- 
//----
function VerAsiento( did_asiento, did_asientod, dhaber,cuenta) {

	$("#d_id_asiento").val( did_asiento );
	$("#d_id_asientod").val( did_asientod );
	$("#d_cuenta").val( cuenta );
	$("#d_haber").val( dhaber  );
	$("#d_parcial").val( '0.00' );
	 
 
	
}
//----
function CXPContabilizar( ) {
	
	 var d_id_asiento       =  $("#d_id_asiento").val();
 	 var d_id_asientod 	    =  $("#d_id_asientod").val(  );
 	 var d_cuenta   =  $("#d_cuenta").val(  );
 	 var d_haber    =  $("#d_haber").val(  );
	 var d_parcial       =  $("#d_parcial").val(  );

	  
 	   var parametros = {
								   'd_id_asiento' : d_id_asiento,
								   'd_id_asientod' : d_id_asientod  ,
								   'd_cuenta': d_cuenta,
								   'd_haber':d_haber,
								   'd_parcial' : d_parcial
	  	};
 
       if ( d_haber )
		 	alertify.confirm("<p>Desea generar la contabilizacion? </p>", function (e) {
 					if (e) {
 						$.ajax({
 								data:  parametros,
 								url:   '../model/Model_PagoCxP_Externo01.php',
 								type:  'POST' ,
 								cache: false,
 								beforeSend: function () { 
 											$("#ViewGuarda").html('Procesando');

									},
 								success:  function (data) {
 										$("#ViewGuarda").html(data);  // $("#cuenta").html(response);
 										BusquedaGrillaa();
 									} 
 						});
 			    }
 			 }); 
		 	
		 	
}
function Contabilizar( ) {

	 var anio       = $("#anio").val();
 	 var id 	    =  $("#prove").val(  );
 	 var idbancos   =  $("#idbancos").val(  );
 	 var ffecha2    =  $("#ffecha2").val(  );
	 var cmes       =  $("#cmes").val(  );

	  
 	   var parametros = {
								   'anio' : anio,
								   'idprov' : id  ,
								   'idbancos': idbancos,
								   'ffecha2':ffecha2,
								   'cmes' : cmes
	  	};
 

		 	alertify.confirm("<p>Desea generar la contabilizacion? </p>", function (e) {

								if (e) {
					
						$.ajax({

								data:  parametros,

								url:   '../model/Model_PagoCxP_Externo.php',

								type:  'GET' ,

								cache: false,

								beforeSend: function () { 

											$("#ViewFormTotal").html('Procesando');

									},

								success:  function (data) {

										$("#ViewFormTotal").html(data);  // $("#cuenta").html(response);

										BusquedaGrillaa();

									} 

						});
 
			  }

			 }); 
 
}