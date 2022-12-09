$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


var oTable;

//-------------------------------------------------------------------------
$(document).ready(function(){
    	    var posicion_x; 	    var posicion_y; 	    var enlace; 	    var ancho = 720; 	    var alto = 550; 
         oTable = $('#jsontable').dataTable( {			 	        "paging":   true,				        "ordering": false,				        "info":     false				    } );
         
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php'); 	
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
   		    
	    BusquedaGrilla( oTable);
 		
 	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
            $("#action").val('aprobar'); 
		});
 	    //-----------------------------------------------------------------
 	   $('#recargar').on('click',function(){
          BusquedaGrilla(oTable);
			
		}); 	  $('#loadxls').on('click',function(){	  	  var fanio = $("#fanio").val();		  var fmes = $("#fmes").val();		  var cuenta = $("#cuenta").val();		  		  var cadena = 'fanio='+fanio+'&fmes='+fmes+'&cuenta='+cuenta;		  var page = "../reportes/excel_caja.php?"+cadena;  			 		  window.location = page;    		 		}); 	   	  $('#load1').on('click',function(){	  	  var fanio = $("#fanio").val();		  var fmes = $("#fmes").val();		  var cuenta = $("#cuenta").val();		  		  var id_co_caja = $("#id_co_caja").val();	      var cadena = 'fanio='+fanio+'&fmes='+fmes+'&cuenta='+cuenta+'&id_co_caja='+id_co_caja;		  var page = "../reportes/ResumenCajaCuentas.php?"+cadena;  		  posicion_x=(screen.width/2)-(ancho/2); 				      		  posicion_y=(screen.height/2)-(alto/2); 				      		  window.open(page,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');       		 		}); 	   	//--------------------------------------------------- 	   $('#load2').on('click',function(){	  	  var fanio = $("#fanio").val();		  var fmes = $("#fmes").val();		  var cuenta = $("#cuenta").val();		  		  var id_co_caja = $("#id_co_caja").val();	      var cadena = 'fanio='+fanio+'&fmes='+fmes+'&cuenta='+cuenta+'&id_co_caja='+id_co_caja;		  var page = "../reportes/MensualCajaCuentas.php?"+cadena;  		  posicion_x=(screen.width/2)-(ancho/2); 				      		  posicion_y=(screen.height/2)-(alto/2); 				      		  window.open(page,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');       		 		}); 	    	    	  $('#load3').on('click',function(){	  	  var fanio = $("#fanio").val();		  var fmes = $("#fmes").val();		  var cuenta = $("#cuenta").val();		  		  var id_co_caja = $("#id_co_caja").val();	      var cadena = 'fanio='+fanio+'&fmes='+fmes+'&cuenta='+cuenta+'&id_co_caja='+id_co_caja;		  var page = "../reportes/MensualCajaCuentasDet.php?"+cadena;  		  posicion_x=(screen.width/2)-(ancho/2); 				      		  posicion_y=(screen.height/2)-(alto/2); 				      		  window.open(page,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');       		 		}); 	  	  
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
					url:   '../model/Model-co_caja.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 	
	  
    }
//-------------------------------------------------------------------------function DetallePagoCxp(fanio,fmes,cuenta ) { 	var parametros = {					'fanio' : fanio,  					'fmes'   : fmes  	  };	  $.ajax({					data:  parametros,					url:   '../model/Model-co_caja_cxp.php',					type:  'GET' ,					cache: false,					beforeSend: function () {  							$("#DetallePago").html('Procesando');  					},					success:  function (data) {							 $("#DetallePago").html(data);  // $("#cuenta").html(response);   					} 			}); 	        ///---------------------	        var parametros_caja = {	        						'cuenta' : cuenta 								};  				$.ajax({					data: parametros_caja,					url: "../model/Model_caja_responsable.php",					type: "GET",					success: function(response)					{					$('#idprov').html(response);					}				});	       }//--------------------------------------------------------
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
   
	$("#action").val("add");
	
	$("#id_co_caja").val("");	$("#fecha").val(fecha_hoy('-')); 	$("#anio").val(fecha_hoy('A'));	$("#mes").val(fecha_hoy('M'));		$("#detalle").val("");	$("#sesion").val("");	$("#creacion").val("");	$("#estado").val("");	$("#cuenta").val("");   
} 
 //---------------------------
function accion( )
{	$("#detalle").val("");	$("#documento").val("");		$("#cheque").val("");	$("#idprov").val("");
  
     BusquedaGrilla(oTable);
 
}//---------------function CrearPeriodo (){		 $.ajax({ 			url:   '../model/Model-co_periodos_anio.php',			type:  'GET' ,			cache: false,			beforeSend: function () { 					$("#result").html('Procesando');			},			success:  function (data) {					 $("#result").html(data);  // $("#cuenta").html(response);				     alert(data);			} 	}); 	 	  BusquedaGrilla(oTable);	}
//---------------
 function fecha_hoy(tipo)
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
     if ( tipo == '-'){    	return today;    }     	
    if ( tipo == 'A'){    	return yyyy;    }        if ( tipo == 'M'){    	return mm;    }
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 
 
     	var fanio = $("#fanio").val();
     	var fecha = new Date();
     	var ano = fecha.getFullYear();
     	     	var fmes = $("#fmes").val();     	     	     	var cuenta = $("#cuenta").val();        $("#idbancos").val(cuenta);                
     	if(fanio==null){
     		fanio = ano;
     	}
         
      var parametros = {
				'fanio'   : fanio  ,				'fmes'    : fmes  ,				'cuenta'  : cuenta   
      };      
       var sumai = 0;      var sumae = 0;      var totali = 0;      var totale = 0;            var total = 0;      
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_caja_mov.php',
			dataType: 'json',
			cache: false,
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
						s[i][5],												s[i][6] 
 
				]);														  sumai  =  s[i][5] ;				  totali += parseFloat(sumai) ;				  sumae  =  s[i][6] ;				  totale += parseFloat(sumae) ;				  				  total  =  (totali) -  (totale) ;								     	 $("#totalPago").html('<h4><b>Saldo  $ '+ total.toFixed(2)  + '</b></h4>');						 
			    } // End For 
			} 
			} 
			,
				error: function(e){
						console.log(e.responseText);	
			 }
			});
 		DetallePagoCxp(fanio,fmes,cuenta);
 	 		
  }    
 //-------------------------------------------------------------------------   function myFunction(asiento,objeto) {	   var accion = 'check';	   var estado = ''; 	   	    if (objeto.checked == true){	    	estado = 'S' 	    } else {	    	estado = 'N'	    } 	    var parametros = {				'accion' : accion ,                'id' : asiento ,                'estado':estado	  };       $.ajax({				data:  parametros,				url:   '../model/Model-co_caja_cxp.php',				type:  'GET' ,				cache: false,				beforeSend: function () { 							$("#mensajeEstado").html('Procesando');					},				success:  function (data) {						 $("#mensajeEstado").html('<h4><b>  $ '+data + '</b></h4>');      						 					} 		});  }
 
 function modulo()
 {
 	 var modulo =  'kcontabilidad';
 	 var parametros = {
			    'ViewModulo' : modulo 
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
    

	 $("#ViewForm").load('../controller/Controller-co_caja_mov.php');
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-co_caja_mov_filtro.php');
	 

 }
//---------- function PoneDato(codigo) {   	 var parametros = {				"codigo" : codigo 		};		 		$.ajax({			    type:  'GET' ,				data:  parametros,				url:   '../model/ajax_idcaja_var.php',				dataType: "json",				success:  function (response) { 					  							 $("#fanio").val( response.a );  						 						 $("#fmes").val( response.b );  						 						 $("#cuenta").val( response.c ); 						  				} 		}); } 
    
  