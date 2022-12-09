var oTable;
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel_ad.php');

		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
	
     
   
		 oTable 	= $('#jsontable').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 4 ] },
			      { "sClass": "de", "aTargets": [ 3 ] }
			    ] 
	      } );
 	    
		 BusquedaGrilla(oTable);
		 
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     var fecha  =  fecha_hoy();
	     var fecha1 =  fecha_dia();
	  
	      $("#fecha1").val(fecha1);
	      $("#fecha2").val(fecha);
	      
	      
	      $.ajax({
 					url: "../model/_lista_carro_dis.php",
					type: "GET",
					success: function(response)
					{
						$('#qunidad').html(response);
					}
			});
	     
	 	$('#loadDoc').on('click',function(){
	 		 
            openFile('../../upload/uploadChofer',1024,350)

  			

		});
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			

		var nombre = 	$('#nombre_vehiculo').val();

	    if ( nombre){

			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					 
				    Pone_secuencia();
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	;
			
		}	else{
					alert('Seleccione el vehiculo/maquinaria para agregar la orden de combustible')
 		 }
   }


//-------------------------------------------------------------------------

function Pone_secuencia()
	{
	
	 
			
			$.ajax({
 					url:   '../model/_comprobante_combustible.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#referencia").val('Procesando');
  					},
					success:  function (response) {
						
							 $("#referencia").val(response);   
 							  
							var value = $("#referencia").val();
 
   						    var value_without_space = $.trim(value);

 							$("#referencia").val(value_without_space);

  					} 
			});
			
		 
	}
	//-----------------

function imprimir_informe(url){        
	
	var variable    = $('#id_combus').val();
   
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
function goToURL(accion,id) {
 
 
     $('#idbien_temp').val(id);
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
 	  
 	  if ( accion == 'visor'){
 	   
 	   			 verdocumento_bien(id,'digitado');
 	  		   
 	  		   
 	  		    $('#mytabs a[href="#tab3"]').tab('show');
 	  
 	  }else{
	
	  		  grafico_visor( id );
	  
			  $.ajax({
							data:  parametros,
							url:   '../model/Model-ad_chofer_comb.php',
							type:  'GET' ,
		 					success:  function (data) {
									 $("#result").html(data);   
		 					} 
		  					
					}); 
					
					
					    
         }
    }
//---------------- 
 function pasoToURL(accion,id) {
 
 
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ad_chofer_comb.php',
					type:  'GET' ,
 					success:  function (data) {
							 $("#result").html(data);   
							
							  $('#mytabs a[href="#tab2"]').tab('show');
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
	
	$('#id_combus').val(id); 
	  
	var idbien = $('#id_bien').val();
	
	 $('#idbien_temp').val(idbien);
	    
	     
	 var costo         = $("#costo").val();
	 var cantidad      = $("#cantidad").val();
	 
	 var total         =  parseFloat(costo).toFixed(4) *   parseFloat(cantidad).toFixed(2)
	 var total_consumo =  parseFloat(total).toFixed(4) 
	 
	 $("#total_consumo").val(total);
	    	   
	 var iva =  (12/ 100);
	 
	 var monto_iva = total_consumo * iva;
	 
     $("#iva").val(monto_iva);
     
      
      suma=parseFloat(monto_iva)+parseFloat(total_consumo);  
      
  	   var total_uni =  parseFloat(suma).toFixed(4) 
  
 	  $("#total_iva").val(total_uni);


	 verdocumento_bien(idbien,'digitado');
 
	

	 

}
//---------------------------
function Enlazar( $accion,idcodigo) {

  
	var id_combus = $('#id_combus').val();


	if ( id_combus > 0 ){
				var parametros = {
							'accion' : 'combustible' ,
							'idcodigo': idcodigo,
							'id_combus' : id_combus
				};
				$.ajax({
							data:  parametros,
							url:   '../model/Model-ad_combustible_matriz.php',
							type:  'GET' ,
								success:  function (data) {
										$("#result").html(data);   
  								} 
								
					}); 
					BuscarOrdenMatriz(id_combus);

					$('#myModalContrato').modal('hide');

		}else {
				alert('Genere la orden de combustible');
    }
 }
//---------------------------
function goToURLdetalle(accion,idcodigo,idbien) {

  

     var parametros = {
					'accion' : accion ,
					'idbien': idbien,
                    'id' : idcodigo
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ad_combustible.php',
					type:  'GET' ,
 					success:  function (data) {
							 $("#result").html(data);   
						
						 	  goToURL('editar',idbien) ;

							  BuscarOrdenMatriz(idcodigo);
 					} 
  					
			}); 

   $('#mytabs a[href="#tab2"]').tab('show');
   
  }
//---------------  
function Notificar( ) {

    var idcodigo = $("#id_combus").val();

     var parametros = {
                    'id' : idcodigo
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/_enviar_notificacion.php',
					type:  'GET' ,
 					success:  function (data) {
							 $("#result").html(data);   
  
  					} 
  					
			}); 

   $('#mytabs a[href="#tab2"]').tab('show');
   
  }
//---------------------------------------
function EnvioDato() {


	
	var estado = $("#estado").val();
	
	var idcodigo = $("#id_combus").val();
	
   

     var parametros = {
					'accion' : 'enviado' ,
                    'id' : idcodigo
 	  };
 	  
 	  if ( estado == 'digitado'){}
 	  
 	     alertify.confirm("<p>ENVIAR NOTIFICACION A RESPONSABLE DE LA ORDEN DE COMBUSTIBLE</p>", function (e) {
			  if (e) {
				 
				  $.ajax({
								data:  parametros,
								url:   '../model/Model-ad_combustible.php',
								type:  'GET' ,
			 					success:  function (data) {
			 							 $("#result").html(data);   
			 							  $("#estado").val('enviado');
			 							 
			 					} 
 						}); 
 			     }
			 }); 
     }
//------------- 
  function Autorizar() {


	
	var estado = $("#estado").val();
	
	var idcodigo = $("#id_combus").val();
	
   

     var parametros = {
					'accion' : 'autorizar' ,
                    'id' : idcodigo
 	  };
 	  
 	  if ( estado == 'enviado'){ 
 	  
 	     alertify.confirm("<p>AUTORIZAR LA ORDEN DE COMBUSTIBLE</p>", function (e) {
			  if (e) {
				 
				  $.ajax({
								data:  parametros,
								url:   '../model/Model-ad_combustible.php',
								type:  'GET' ,
			 					success:  function (data) {
			 							 $("#result").html(data);   
			 							  $("#estado").val('autorizar');
			 							 
			 					} 
 						}); 
 			     }
			 }); 
     }
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
//---
function grafico_visor( idbien ) {

var options = {
        chart: {
            renderTo: 'div_grafico',
            type: 'line'
        },
        title: {
            text: ' ',
         },
        xAxis: {
            categories: [],
            title: {
                text: 'Mes'
            }
        },
        yAxis: {
            title: {
                text: 'Consumo'
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
        },
        
        credits: {
            enabled: false
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: []
    };
	
    $.getJSON("../grilla/grafico_combu_carro.php?idbien="+idbien, function(json) {
        options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
        options.series[0] = json[1];
        chart = new Highcharts.Chart(options);
    });
}
 //----------------
function monto_combustible(tipo) {
	   
	 var parametros = {
				 'tipo'  : tipo  
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model_monto_combustible.php",
			 type: "GET",
			 dataType: 'json',  
	       success: function(response)
	       {
	           $('#costo').val(response.a);
	       }
		 });
		
 
		 
	}
 
//----------------------
function HabilitaCampo_dato(uso){
	
 var km = $("#u_km").val();

	if ( uso == 'N'){
		$("#u_km_inicio").val('0.00');
		$("#ubicacion_salida").val('Uso Interno');
 	}else{
		$("#u_km_inicio").val(km);
			$("#ubicacion_salida").val('');
    }
	
}
//--------------------
function habilita_campo(texto){
	
 

	if ( texto == 'GALON'){
		$("#cantidad_ca").val('0');
		
		$('#cantidad_ca' ).prop('readonly', true);

		 
 	}else{
		$("#cantidad_ca").val('1');
		
		$('#cantidad_ca'  ).prop('readonly', false);

    }
	
}
// ir a la opcion de editar
function LimpiarPantalla() {
  
	
	var fecha = fecha_hoy();
 
	var hoy = new Date();

	var hora = hoy.getHours() + ':' + hoy.getMinutes() ;
	
	var km = $("#u_km").val();
	
	
	$("#estado").val("digitado");
	
	$("#id_combus").val("");
	
	$("#medida").val("");
	
	$("#cantidad_ca").val("0");
	
 	$("#fecha").val(fecha);
	$("#hora_in").val(hora);
	$("#u_km_inicio").val(km);
	$("#referencia").val("");
	$("#ubicacion_salida").val("Matriz");
	$("#tipo_comb").val("-");
	$("#cantidad").val("0.0000");
	$("#costo").val("0.0000");
	$("#uso").val("S");

	$("#iva").val("0.0000");
	
$("#chofer_vehiculo").val("");


	$("#total_consumo").val("0.0000");
	
	 
    $("#total_iva").val("0.0000");
     

 
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
//--------------------
 function fecha_dia()
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
 
   
	      var qestado    = $("#qestado").val();
	      var qcodigo    = $("#qcodigo").val();
	      var qunidad    = $("#qunidad").val();
	      
	       
	      
	      
	      var parametros = {
					'accion' : 'visor',
					'qestado':qestado,
					'qcodigo':qcodigo,
					'qunidad':qunidad
 	       };
      
         
            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ad_combustible.php',
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
                                	'<button class="btn btn-xs btn-warning" title="Visualizar historial Combustible" onClick="goToURL('+"'editar'"+','+ "'" + s[i][5] + "'" +')"><i class="glyphicon glyphicon-signal"></i></button>&nbsp;' +
                                	'<button class="btn btn-xs btn-success" title="Visualizar historial Combustible" onClick="goToURL('+"'visor'"+','+ "'" + s[i][5] + "'" +')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' +
                                	'<button class="btn btn-xs btn-info" title="Generar Combustible" onClick="pasoToURL('+"'paso'"+','+ "'" + s[i][5] + "'" +')"><i class="glyphicon glyphicon-plus""></i></button>&nbsp;'
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
				
				 $("#qcodigo").val('');
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
//-------------------------
function BuscarOrdenMatriz(codigo)
{
  
 	 
	 var parametros = {
			    'codigo' : codigo,
				'tipo' : 'combustible' 
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
//----------------
function modulo()
{
 

 var modulo1 =  'kgarantia';
		 
	 var parametros = {
			    'ViewModulo' : modulo1
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ad_combustible.php');
     

}
//----------------------
function FormFiltro()
{
 
}
//-------
//----------------------------------------
function verdocumento_bien(idbien,tipo)
{
 
 
 if ( idbien == 0){
	 idbien    = $('#idbien_temp').val();
}
  
 
 var fecha1	=	  $("#fecha1").val();
 var fecha2	=	  $("#fecha2").val();
	      
 		 
	var parametros = {
				'idbien' : idbien  ,
				'tipo':tipo,
				'fecha1':fecha1,
				'fecha2':fecha2 
};

$.ajax({
				data:  parametros,
				url:   '../model/Model-ad_carro_comb.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ViewFormCombustible").html(data);  // $("#cuenta").html(response);

				} 

	}); 
     

}
 