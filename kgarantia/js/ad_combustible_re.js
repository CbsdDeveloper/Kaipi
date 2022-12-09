var oTable;
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
        var mes = _mes();
    
        $("#qmes").val(mes);
        
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

		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        $("#MHeader").load('../view/View-HeaderModel_ad.php');
		

        $.ajax({
             url: "../model/ajax-estacion_proveedor.php",
            type: "GET",
                success: function(response)
                {
                $('#qproveedor').html(response);
                }
            });


 	    
		 BusquedaGrilla(oTable);
		 
	     $('#load').on('click',function(){
            BusquedaGrilla(oTable);
  		});
   	      
	     
	 	$('#loadDoc').on('click',function(){
             openFile('../../upload/uploadChofer',1024,350)
 		});
	
	         
});  
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
			return false	;
			
		 
   }


//-------------------------------------------------------------------------

function Pone_secuencia()
	{
	
	 
			 
			
		 
	}
	//-----------------

function imprimir_informe(url){        
	
	var variable    = $('#id_combus').val();
   
    var posicion_x; 
    
    var posicion_y; 
    
    var enlace = url + '?codigo=' + variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
// ir a la opcion de editar
function goToURL(accion, id) {
 
	var parametros = {
		'accion' : accion ,
 		'id' : id
};

$.ajax({
		data:  parametros,
		url:   '../model/Model-ad_combustible_estacion.php',
		type:  'GET' ,
		 success:  function (data) {
				 $("#result").html(data);   
  
				 
		 } 
		  
}); 

if ( accion == 'del') {
	alert('Registro eliminado con exito...');
	BusquedaGrilla(oTable);

}	else  {

	$('#mytabs a[href="#tab2"]').tab('show');
}


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
 

    razon = 	$('#idprov').val(); 


    $('#qproveedor').val(razon); 
	 

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
		
		 var secuencial =  parseFloat( $('#referencia').val()  )
		 var h =('00000000' + secuencial).slice (-9);
	            $('#referencia').val(h);
	 
		
		 
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

// ir a la opcion de editar
function LimpiarPantalla() {
  
	
	var fecha = fecha_hoy();
 
	var hoy = new Date();

	var hora = hoy.getHours() + ':' + hoy.getMinutes() ;
	
	var km = $("#u_km").val();
	
	$("#id_combus").val("");
 	$("#fecha").val(fecha);
	$("#hora_in").val(hora);
	$("#u_km_inicio").val(km);
    $("#u_km_fin").val(km);
	$("#referencia").val("");
 	$("#tipo_comb").val("");
	$("#cantidad").val("0.0000");
	$("#costo").val("0.0000");
	 

    $("#idprov").val("");
    $("#id_prov").val("");

    $("#razon").val("");
 
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
 
   
	      var qmes    = $("#qmes").val();

          var qproveedor    = $("#qproveedor").val();

	      var parametros = {
					'accion' : 'visor',
					'qestado':qmes,
                    'qproveedor' : qproveedor
 	       };
      
         
            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ad_combustible_estacion.php',
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
                                   s[i][9],
                                	'<button class="btn btn-xs btn-warning" title="Visualizar Combustible" onClick="javascript:goToURL('+"'editar'"+','+   s[i][0]   +')"><i class="glyphicon glyphicon-time"></i></button>&nbsp;'  +
									'<button class="btn btn-xs btn-danger" title="Eliminar Combustible" onClick="javascript:goToURL('+"'del'"+','+   s[i][0]   +')"><i class="glyphicon glyphicon-remove"></i></button>'
								]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ad_combustible_estacion.php');
     

}
//----------------------
function FormFiltro()
{
 
}
//-------
//----------------------------------------
function verdocumento_bien(idbien)
{
 
 		 
	var parametros = {
				'idbien' : idbien  
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
 