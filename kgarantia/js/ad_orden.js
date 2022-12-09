var oTable;
var formulario 		   =  'ad_orden';
var modulo_sistema     =  'kgarantia';

   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	var mes = fecha_hoy()

	var mes1 = fecha_primero()

	
	$("#qinicial").val(mes1);

	$("#qfinal").val(mes);

	


	$("#FormPie").load('../view/View-pie.php');
     
	$("#MHeader").load('../view/View-HeaderModel_ad.php');

	modulo();
  		
	FormView();
	
	oTable 	= $('#jsontable').dataTable( {      
		searching: true,
		paging: true, 
		info: true,         
		lengthChange:true ,
		aoColumnDefs: [
			 { "sClass": "highlight", "aTargets": [ 4 ] },
			 { "sClass": "ye", "aTargets": [ 0 ] },
			 { "sClass": "de", "aTargets": [ 5 ] }
		   ] 
	 } );
		
		
	   	    
 		 
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
          
	 	$('#loadDoc').on('click',function(){
             openFile('../../upload/uploadChofer',1024,350)
 		});


		
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					 
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
					url:   '../model/Model-ad_orden.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
 							 	
							 BuscarOrdenMatriz(id);
  					} 
  					
			}); 

    }
 
//-------------------------------------------------------------------------
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}
//-----------
function url_ficha(url){        
	
	var variable    = $('#id_bien').val();
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------------------------------------------------------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_orden').val(id); 
	  
 
}
//---------------------------
function goToURLDocdelG(idcodigo,idcaso) {

 alert ('Opcion No disponible');
 
  }
//------------------goToURLDocdel
function goToURLDocdel(idcodigo,idprov) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'prov'   : idprov  
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-ad_chofer_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
//----------------------------------------- 
function BuscarOrden()
{
  
	var vchofer    = $("#vchofer").val();
	var vcarro     = $("#vcarro").val();
	var vorden     = $("#vorden").val();
 		 
	 var parametros = {
			    'vchofer' : vchofer,
				'vcarro' : vcarro,
				'vorden' : vorden
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ad_vehi_com.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#matriz_orden").html('Procesando');
				},
			success:  function (data) {
					 $("#matriz_orden").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-------------------------
function BuscarOrdenMatriz(codigo)
{
  
 	 
	 var parametros = {
			    'codigo' : codigo,
				'tipo' : 'orden' 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ad_com_vehi_view.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormCombustible_orden").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormCombustible_orden").html(data);   
				     
				} 
	});
     

}
//-----------------------------------------------
function LimpiarOrden()
{
  
	$("#vchofer").val('');
	$("#vcarro").val('');
	$("#vorden").val('');
 		 
	 var parametros = {
			    'vchofer' : '',
				'vcarro'  : '',
				'vorden'  : '0',
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ad_com_vehi.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#matriz_orden").html('Procesando');
				},
			success:  function (data) {
					 $("#matriz_orden").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}  
 
 
//-------
function anular_orden( ) {

	 var id     = $('#id_orden').val();
	 var accion = 'eliminar'


var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

		alertify.confirm("<p>Desea Anular la orden de movilizacion</p>", function (e) {
			  if (e) {
				  
					  $.ajax({
					data:  parametros,
					url:   '../model/Model-ad_orden.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
   					} 
 					}); 
					 
			  }
			 }); 



 
	 
}
//--------------------
function imprimir_informe(url){        
	
	var variable    = $('#id_orden').val();
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
// ir a la opcion de editar
function LimpiarPantalla() {
  
	
	var fecha = fecha_hoy();
 
	$("#id_orden").val("");
	$("#id_bien").val("");
	$("#fecha").val(fecha);
	$("#fecha_orden").val(fecha);
	$("#fecha_salida").val("");
	
	$("#hora_in").val("");
	$("#hora_llegada").val("00:00");
	
	$("#unidad").val("");
	
	$("#sale_km").val("0");
	$("#llega_km").val("0");
	$("#estado").val("solicitado");
	$("#motivo_traslado").val("");
	$("#id_prov_solicita").val("");
	$("#id_prov_chofer").val("");
	$("#nro_ocupantes").val("2");
	$("#origen").val("");
	$("#destino").val("");
	$("#novedad").val("Registrar novedad");

 
    }
   
 
 //---------------------------
 function _mes()
{
   
     var today = new Date();
     var mm = today.getMonth()+1; //January is 0!
     var yyyy = today.getFullYear();
    
 
   if(mm < 10){
        mm='0'+ mm
    } 
    
    var today = yyyy + '-' + mm ;
    
 
    return today;
            
} 
//-----------------------------
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
//---------------------------
function fecha_primero()
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
  
    
    var today = yyyy + '-' + mm + '-01' ;
    
 
    return today;
            
} 
//----------------------------
 function openFile(url,ancho,alto) {
	    
	  var idprov = $('#idprov').val();
		 
	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+idprov  ;
	 
	  if ( idprov) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
 //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
		var qestado = $("#qestado").val();
		
		 var qinicial   = $("#qinicial").val();
      
		 var qfinal   = $("#qfinal").val();
      
 
 
            var parametros = {
					'accion' : 'visor',
					'qestado':qestado,
					'qinicial':qinicial,
					'qfinal':qfinal
 	       };
      
        
            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ad_orden.php',
				dataType: 'json',
				success: function(s){
						//console.log(s); 
						oTable.fnClearTable();
						if(s ){ 
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
								s[i][8],
                                	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ "'" + s[i][0] + "'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
 //--
function modulo()
{
 
 
		 
	 var parametros = {
			    'ViewModulo' : modulo_sistema
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ad_orden.php');
     

}
 
//-------
function Departamento_visor(id_prov)
{
 
 		 
	var parametros = {
				'id_prov' : id_prov  
};

 
	$.ajax({
	    type:  'GET' ,
		data:  parametros,
		url:   '../model/_lista_unidad_visor.php',
		dataType: "json",
			success:  function (response) {
  				 $("#unidad").val( response.a );  
				 
 		  } 
   });
     

}
//---------------------
function PonePlaca( ) {

	var vcarro     = $("#placa").val();

	$("#vcarro").val(vcarro);
}	
//---------------------------
function Enlazar( $accion,idcodigo) {

  
	var id_orden = $('#id_orden').val();


	if ( id_orden > 0 ){
				var parametros = {
							'accion' : 'orden' ,
							'idcodigo': id_orden,
							'id_combus' : idcodigo
				};
				$.ajax({
							data:  parametros,
							url:   '../model/Model-ad_combustible_matriz.php',
							type:  'GET' ,
								success:  function (data) {
										$("#result").html(data);   
  								} 
								
					}); 
					$('#myModalContrato').modal('hide');

					BuscarOrdenMatriz(id_orden);

				

		}else {
				alert('Genere la orden de combustible');
    }
 }
//-------------
function Vehiculo_visor(idbien)
{
 
 		 
	var parametros = {
				'idbien' : idbien  
};

 
	$.ajax({
	    type:  'GET' ,
		data:  parametros,
		url:   '../model/_lista_carro_visor.php',
		dataType: "json",
			success:  function (response) {
				
  				 $("#placa").val( response.a );  
  				 $("#id_prov_chofer").val( response.b );  
  				 $("#sale_km").val( response.c );  
				 
  	             
                 
 		  } 
   });
     
//-----------------------------
	 var parametros1 = {
			 'idbien'  : idbien  
    };
	 
	 $.ajax({
		 data:  parametros1,
		 url: "../model/_lista_carro_comb.php",
		 type: "GET",
       success: function(response)
       {
           $('#id_combus').html(response);
       }
	 });
 
     

}
//----------------------------------------
function verdocumento_bien(idprov)
{
 
 		 
	var parametros = {
				'idprov' : idprov  
};

$.ajax({
				data:  parametros,
				url:   '../model/Model-ad_chofer_doc.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);

				} 

	}); 
     

}
 