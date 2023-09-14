var oTable;
var oTableAux;

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        oTable = $('#jsontable').dataTable(); 
 	  
        
        oTableAux  = $('#jsontableAux').dataTable(); 
        
        
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     $('#ejecuta_q').on('click',function(){
 	 		 
	           BusquedaGrillaSpi(oTableAux);
	           
	    });
	     
	     anio();
	     
	     $('#GuardaPara').on('click',function(){
 	 		 
	           ActualizaParametro();
	           
	    });
	     
	     $('#GuardaCiu').on('click',function(){
 	 		 
	           Actualizaciu();
	           
	    });
	       
	     
	     $('#ejecuta_all').on('click',function(){
 	 		 
	           RecorreTabla();
	           
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
//------------
function aprobacion_spi( ) {
	
	  var id_spi = 	$("#id_spi").val();
	  var estado = 	$("#estado").val();
	  
		 var parametros = {
				    'accion': 'aprobado',
				    'id' : id_spi,
				    'estado' : estado
	   };
		 
	 alertify.confirm("<p> Desea autorizar el envio del SPI</p>", function (e) {
		  if (e) {
			 
		 		  				$.ajax({
			  						data:  parametros,
			  						 url:   '../model/Model-te_spi.php',
			  						type:  'GET' ,
			  						success:  function (data) {
			  								 $("#result").html(data);   
			   							} 
			  				});
	 			 
		  }
		 }); 
	 
}
// ir a la opcion de editar
function goToURL(accion,id) {
 
 
	
	 var resultado = Mensaje( accion ) ;
	   
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
		
	 	
		$.ajax({
			  url:   '../model/Model-te_spi.php',
			  type:  'GET' ,
			  data:  parametros,
			  dataType: 'json',  
				}).done(function(respuesta){
						
				 	$("#id_spi").val (respuesta.id_spi);
	 			 
 					$("#fecha").val(respuesta.fecha);
					$("#fecha_envio").val(respuesta.fecha_envio);
					$("#detalle").val(respuesta.detalle);
					$("#estado").val(respuesta.estado);
					$("#referencia").val(respuesta.referencia);
					$("#cuenta").val(respuesta.cuenta);
					 
					$("#codigo_control").val(respuesta.codigo_control);
					$("#validacion").val(respuesta.validacion);
					 
					var beneficiario = respuesta.beneficiario;
					
					
					$("#beneficiario").val(beneficiario.trim() );
					 
						 						
					$("#action").val(accion); 
				 	$("#result").html(resultado);
				 	
				 	DetalleSpi(respuesta.id_spi);
				 
				 
				 	
				});
	 
 
	 	$('#mytabs a[href="#tab2"]').tab('show');
		  
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
 
	var f1 = fecha_hoy();
	var today = new Date();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    
    var referencia = '00000';
	    
	
	$("#id_spi").val("");
	$("#fecha").val(f1);
	
	$("#fecha_envio").val("");
	$("#detalle").val("");
	$("#estado").val("");
	$("#referencia").val(referencia);
 	$("#cuenta").val("");
 	
	$("#beneficiario").val("");
	
  }
 
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_spi').val(id); 
	  
	DetalleMov(id,action);

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
 
 function anio()
 {
    
     var today = new Date();
  
     var yyyy = today.getFullYear();
     var yyya = yyyy-1;
     var yyyb = yyyy-2;
      
     $('#nanio').append('<option value="'+yyyb+'" selected="selected">'+yyyb+'</option>');
     $('#nanio').append('<option value="'+yyya+'" selected="selected">'+yyya+'</option>');
     $('#nanio').append('<option value="'+yyyy+'" selected="selected">'+yyyy+'</option>');       
     
     var mm = today.getMonth()+1; //January is 0!
     
     $("#nmes").val(mm);
     
     $("#nmes1").val(mm);
 } 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
             
           	var ffecha1 = $("#ffecha1").val();
            var ffecha2 = $("#ffecha2").val();
            var festado = $("#festado").val();
            var fcuenta = $("#fcuenta").val();
        
            var parametros = {
					'ffecha1' : ffecha1 , 
                    'ffecha2' : ffecha2  ,
                    'festado' : festado , 
                    'fcuenta' : fcuenta , 
  	       };
      

            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_te_spi.php',
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
                               	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			 
 }   

//------------------------------------------------------------------------- 
  function BusquedaGrillaSpi(oTableAux){        
 
   
	   
	  
           	var nanio = $("#nanio").val();
            var ntipo = $("#ntipo").val();
            var nmes = $("#nmes").val();
            var nmes1 = $("#nmes1").val();
            var cuenta = $("#cuenta").val();
            
       
            var parametros = {
					'nanio' : nanio , 
                    'ntipo' : ntipo  ,
                    'nmes' : nmes  ,
                     'nmes1' : nmes1  ,
                    'ncuenta':cuenta
 	       };
 
            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_te_spi_pagos.php',
				dataType: 'json',
				success: function(s){
						//console.log(s); 
					oTableAux.fnClearTable();
						if(s ){ 
							for(var i = 0; i < s.length; i++) {
								oTableAux.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
       	                        s[i][4],
       	                        s[i][5],
       	                        s[i][6],
								  '<button class="btn btn-xs" title="Agregar al tramite de pago" onClick="javascript:goToSpi('+"'add'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-copy"></i></button> ' +
								  '<button class="btn btn-xs" data-toggle="modal" data-target="#myModalciu" title="Actualizar Datos beneficiarios" onclick="goToSpiCiu('+ "'"+ s[i][3] + "'"+ ')"><i class="glyphicon glyphicon-user"></i></button>'
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			
			
			 var id1 =   $('#beneficiario').val();
			 var id2 =   $('#fecha').val();
			 
			 if ( id1 == 'proveedores'){
				 $('#ntipo').val('P');
			 }
			 if ( id1 == 'nomina'){
				 $('#ntipo').val('N');
			 }
			 if ( id1 == 'varios'){
				 $('#ntipo').val('C');
			 }
 
		
 			 /*  
 			 	 var myStr = $('#fecha').val();
 			strArray = myStr.split("-");
			    
			 $('#nanio').val(strArray[0]);
			 $('#nmes').val(strArray[1]);
 
			*/
			
 }     
//-----------------------  
 function valida_estado(valor)
{
 
	 if (valor == 'aprobado'){
		 alertify.alert("<b>ADVERTENCIA... Este proceso es ireversible, desea cerrar la transaccion</b>", function () {
		  });
	 }
		 	 
     

}
//-------------------------------------------------------------------------
 
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
        var id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  
//-------------------------
function parametros_generales()
{
	
	
	 var parametros = {
 			    'accion' : 'visor'
};
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model_te_spi_para.php',
			type:  'GET' ,
			  dataType: 'json',  
	}).done(function(respuesta){
			
		$("#id_spi_para").val(respuesta.id_spi_para);
		$("#fecha_pago").val(respuesta.fecha_pago);
		$("#mes_pago").val(respuesta.mes_pago);
		$("#referencia_pago").val(respuesta.referencia_pago);
		$("#localidad").val(respuesta.localidad);
		$("#responsable1").val(respuesta.responsable1);
		$("#cargo1").val(respuesta.cargo1);
		$("#responsable2").val(respuesta.responsable2);
		$("#cargo2").val(respuesta.cargo2);
		$("#cuenta_bce").val(respuesta.cuenta_bce);
		$("#empresa").val(respuesta.empresa);
		 
		
			 						
 
	});
	
	
	  $('#myModalpa').modal('show');  
	
}
 
	
function modulo()
{
 

	 var modulo1 =  'kventas';
		 
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
//-------------------
//-----------------goToSpi 
function RecorreTabla( ){ 
	
	var id_spi = 	$("#id_spi").val();
 	var estado = 	$("#estado").val();
 	var i = 0; 
	
	if ( id_spi > 0 ){

		$('#jsontableAux tr').each(function() { 
		    
			 
			   var idaux = $(this).find("td").eq(0).html();  
			
			   if (  i >   0  ) { 
				   
				   
				   goToSpiLista('add',idaux)
		 	
				   
			   }
			   
			   i = i + 1;
			  
		}); 
		alert('Transacciones Seleccionadas');
		 $('#myModalprov').modal('hide');  
	}
}
/**/ 

function AgrupaPago()
{
 
var id_spi = 	$("#id_spi").val();
var estado = 	$("#estado").val();

if ( estado == 'digitado' ) {
	
 	if ( id_spi > 0 ){
 				 
				 var parametros = {
 						    'id_spi' : id_spi
			   };
				  

			   alertify.confirm("<p>DESEA AGRUPAR EL PAGO PARA PROVEEDOR</p>", function (e) {
				if (e) {
				   
					$.ajax({
						data:  parametros,
						 url:   '../model/Model-te_spi_lista_agrupa.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#ViewFormDetalle").html(data);   
 							} 
					});
					   
				}
			   }); 

		 
 			
	
				 
	} else 	{
		
		alert('Guarde la informacion para realizar esta transaccion');
	}
}	
 
}
//-----------------goToSpi  
function goToSpi(accion,idaux)
{
 
var id_spi = 	$("#id_spi").val();
var estado = 	$("#estado").val();

if ( estado == 'digitado' ) {
	
 	if ( id_spi > 0 ){
 				 
				 var parametros = {
						    'accion': accion,
						    'idaux' : idaux,
						    'id_spi' : id_spi
			   };
				  
 				$.ajax({
						data:  parametros,
						 url:   '../model/Model-te_spi_lista.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#ViewFormDetalle").html(data);   
 							} 
				});
	
				  $('#myModalprov').modal('hide');  
	} else 	{
		
		alert('Guarde la informacion para realizar esta transaccion');
	}
}	
 
}
//------------------
//-----------------goToSpi  
function goToSpiLista(accion,idaux)
{
 
var id_spi = 	$("#id_spi").val();

var estado = 	$("#estado").val();

 			 
				 
				 var parametros = {
						    'accion': accion,
						    'idaux' : idaux,
						    'id_spi' : id_spi
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../model/Model-te_spi_lista.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#ViewFormDetalle").html(data);   
 							} 
				});
	
				  
	 
 
 
}
//--------------------------
function goToSpiAnula(id_spi_det,id_asiento_aux)
{
 
var id_spi = 	$("#id_spi").val();

var estado = 	$("#estado").val();


if ( estado != 'aprobado' ) {
	
	if ( id_spi > 0 ){
			
				 
				 
				 var parametros = {
						    'accion': 'eliminar',
						    'id_spi_det' : id_spi_det,
						    'id_spi' : id_spi,
						    'id_asiento_aux': id_asiento_aux
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../model/Model-te_spi_lista.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#ViewFormDetalle").html(data);   
 							} 
				});
	
				 
	} else 	{
		
		alert('Guarde la informacion para realizar esta transaccion');
	}
}	
 
}

function goToSpiCambio(id_spi_det,estado_ciu)
{
 
var id_spi = 	$("#id_spi").val();

var estado = 	$("#estado").val();


if ( estado != 'aprobado' ) {
	
	if ( id_spi > 0 ){
			
				 
				 
				 var parametros = {
						    'accion': 'cambio',
						    'id_spi_det' : id_spi_det,
						    'id_spi' : id_spi,
						    'estado_ciu': estado_ciu
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../model/Model-te_spi_lista.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#ViewFormDetalle").html(data);   
 							} 
				});
	
				 
	} else 	{
		
		alert('Guarde la informacion para realizar esta transaccion');
	}
}	
 
}

//------------- 
function ActualizaParametro( )
{
 
	
var id_spi_para = 	$("#id_spi_para").val();
 
var fecha_pago = 	$("#fecha_pago").val();
var mes_pago = 	$("#mes_pago").val();
var referencia_pago = 	$("#referencia_pago").val();
var localidad = 	$("#localidad").val();
var responsable1 = 	$("#responsable1").val();
var cargo1 = 	$("#cargo1").val();

var responsable2 = 	$("#responsable2").val();
var cargo2 = 	$("#cargo2").val();

var cuenta_bce = 	$("#cuenta_bce").val();
var empresa = 	$("#empresa").val();

 
				 
				 var parametros = {
 						    'id_spi_para' : id_spi_para,
						    'fecha_pago' : fecha_pago,
						    'mes_pago' : mes_pago,
						    'referencia_pago' : referencia_pago,
						    'localidad' : localidad,
						    'responsable1' : responsable1,
						    'cargo1' : cargo1,
						    'responsable2' : responsable2,
						    'cargo2' : cargo2,
						    'cuenta_bce' : cuenta_bce,
						    'empresa' : empresa,
						    'accion' : 'actualizar'
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../model/Model_te_spi_para.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#MensajeParametro").html(data);   
 							} 
				});
	
 
 
}
//------------------------------
function goToSpiCiu(idprov)
{
 
 
var estado = 	$("#estado").val();

		
		if ( estado != 'aprobado' ) {
			
		 		 		 
						 var parametros = {
								    'idprov': idprov 
					   };
						  
						  
						$.ajax({
								data:  parametros,
								 url:   '../controller/Controller-te_spi_ciu.php',
								type:  'GET' ,
								success:  function (data) {
										 $("#ViewFiltroProv").html(data);   
		 							} 
						});
		 
			 
		}	
 
}
//-------------------
function Actualizaciu( )
{
 
 
var estado = 	$("#estado").val();
var idprov =    $("#idprov").val();
var id_spi =    $('#id_spi').val(); 


var id_banco   =    $('#id_banco').val(); 
var tipo_cta   =    $('#tipo_cta').val(); 
var cta_banco  =    $('#cta_banco').val(); 


		if ( estado != 'aprobado' ) {
			
		 		 		 
						 var parametros = {
								    'idprov': idprov ,
								    'id_spi':id_spi,
								    'id_banco':id_banco,
								    'tipo_cta':tipo_cta,
								    'cta_banco':cta_banco 
 					   };
						  
						  
						$.ajax({
								data:  parametros,
								 url:   '../model/ajax_spi_ciu.php',
								type:  'GET' ,
								success:  function (data) {
										 $("#guardarciu").html(data);   
										 
										 DetalleSpi(id_spi);
										 
		 							} 
						});
		 
			 
		}	
	 
 
}
//---------------.ViewFiltroProv 
function DetalleSpi(id_spi )
{
 
 

   	
	if ( id_spi > 0 ){
 				 
				 var parametros = {
						    'accion': 'visor',
						    'idaux' : 0,
						    'id_spi' : id_spi
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../model/Model-te_spi_lista.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#ViewFormDetalle").html(data);   
							     
							} 
				});
 
	}
}
//------------------
function GeneraArchivoSpi(  )
{
 
 
	var id_spi = 	$("#id_spi").val();

	var estado = 	$("#estado").val();


   	
	if ( id_spi > 0 ){
 				 
				 var parametros = {
						    'accion': 'archivo',
 						    'id_spi' : id_spi
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../../spi/spi_archivo_txt.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#GeneraArchivotxt").html(data);   
							     
							} 
				});
 
	}
}
//-------------------
function impresion_spi(enlace)
{
	 
	var id_spi = 	$("#id_spi").val();

	var estado = 	$("#estado").val();


   	
	if ( id_spi > 0 ){
		
		
		  var url = '../reportes/'+ enlace + '?id=' + id_spi;
		  
	 	  window.open(url ,'#','width=750,height=480,left=30,top=20');
	 	  
	}
 				 
 
	  
	 
}
//-----------------------
function GeneraArchivoProveedor(  )
{
 
 
	var id_spi = 	$("#id_spi").val();

	var estado = 	$("#estado").val();


   	
	if ( id_spi > 0 ){
 				 
				 var parametros = {
						    'accion': 'archivo',
 						    'id_spi' : id_spi
			   };
				  
				  
				$.ajax({
						data:  parametros,
						 url:   '../../spi/spi_proveedor_txt.php',
						type:  'GET' ,
						success:  function (data) {
								 $("#GeneraArchivotxt").html(data);   
							     
							} 
				});
 
	}
} 
//-----------------
function FormView()
{
   
	 
	 $("#ViewForm").load('../controller/Controller-te_spi.php');
	 
	 
	 $("#ViewFiltroSpi").load('../controller/Controller-te_spi_para.php');
     

}
//----------------------
function FormFiltro()
{
 
	 $("#ViewFiltro").load('../controller/Controller-te_spi_filtro.php');
 

}
 
//------------------------
//----------------------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}
//------------------
function openFile(url,ancho,alto) {
    
	  var posicion_x; 
  var posicion_y; 
  var enlace; 
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
 
  
  enlace = url  ;

  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}
  