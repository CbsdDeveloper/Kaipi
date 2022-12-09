/* Funciones JavaScript
   Version 1.1
   Autor: jasapas
   Tema: Formulario para cierre de cajas
*/

var oTable;
var oTableArticulo;

$(document).ready(function(){
    
	 
 	
	   oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 2 ] },
  		      { "sClass": "di", "aTargets": [ 3 ] },
  		    ] 
       } );



	   oTableArticulo	= $('#jsontable_caja').dataTable( {      
		searching: true,
		paging: true, 
		info: true,         
		lengthChange:true ,
		aoColumnDefs: [
			 { "sClass": "highlight", "aTargets": [ 0 ] },
			{ "sClass": "ye", "aTargets": [ 2 ] },
			{ "sClass": "di", "aTargets": [ 3 ] },
		  ] 
   } );

	   

 
 	    modulo();
 		
		FormView();
		
        fecha_hoy();

		$("#MHeader").load('../view/View-HeaderModel.php');
		$("#FormPie").load('../view/View-pie.php');
     
 
		diario_contabilizacion();
		resumen_datos();
		 
		
        $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);

		   diario_contabilizacion();

		   resumen_datos();
           
 		});
        
		 BusquedaGrillaCaja(oTableArticulo);
    
       
	         
});  
// 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToconta(fecha,cajero,parte) {
  
      var parametros = {
					'fecha' : fecha ,
                    'cajero' : cajero ,
					'parte' :parte
 	  };



	   alertify.confirm("Desea realizar la contabilización del dia: " + fecha, function (e) {
		if (e) {
		   
			
					$.ajax({
						data:  parametros,
						url:   '../model/Model-Contabilizar_proceso.php',
						type:  'GET' ,
						beforeSend: function () { 
								$("#data").html('Procesando');
						},
						success:  function (data) {
								$("#data").html(data);   
								
						} 
				}); 

			   
		}
	   }); 
 
 
    }
 //  
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
    
    $("#fecha_q").val(today);
    
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
			var user = $(this).attr('id');
            
             var  fecha1      = $("#fecha_q").val();
    
         
            var parametros = {
                     'fecha1' : fecha1  ,
  	       };
            
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_deposito.php',
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
							   '<button title ="GENERAR ASIENTOS CONTABLES DE RECAUDACION"  class="btn btn-xs btn-success" onClick="goToconta('+ "'" + s[i][0] + "'" +','+   "'" + s[i][4]+ "'" + "," + "'" + s[i][1]+ "'" +')">' +
							   '<i class="glyphicon glyphicon-cog"></i></button> &nbsp;'
							]);										
						} // End For
			    	}						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
			
			diario_contabilizacion();
			
		   
	
 }   
/*
*/
function BusquedaGrillaCaja(oTableArticulo){        
 
 
	$.ajax({
 		url: '../grilla/grilla_caja_banco.php',
		dataType: 'json',
		success: function(s){
			oTableArticulo.fnClearTable();
				if(s ){  		
					for(var i = 0; i < s.length; i++) {
						oTableArticulo.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],  
						s[i][3],  
						'<input type="checkbox" id="myActivo'+ s[i][0] +'"   onclick="myFunctiona('+ "'"+ s[i][0] +"'" +',this)" '+ s[i][4]  + '>'
					]);										
				} // End For
			}						
		},
		error: function(e){
		   console.log(e.responseText);	
		}
		});
 
   

}     
 
//-----------------
function myFunctiona(codigo,objeto)

{
	 

		var estado = 'N';

	   if (objeto.checked == true){
			estado = 'S';
		} else {
			estado = 'N';
		}


	   var parametros = {
 				'id'     : codigo ,
				'estado' : estado

	 };

	
	 
$.ajax({
				data:  parametros,
				url:   '../model/ajax_seleccion_caja.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#total_marca").html('Procesando');
					},
				success:  function (data) {
						 $("#total_marca").html(data);  
					} 
		}); 

}
//----------------------
 
function modulo()
{
 

	 var moduloOpcion =  'kservicios';
		 
	 var parametros = {
			    'ViewModulo' : moduloOpcion 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  
				     
				} 
	});

}
//-----------------
function FormView()
{
   
 	 $("#ViewForm").load('../controller/Controller-ren_deposito.php');

}  
  
//-------------------------
function impresion_caja(){        
	
 
 
	var  fecha      = $("#fecha_q").val();
 
	var posicion_x; 
	var posicion_y; 
	
	var enlace =   '../view/ren_deposito_caja.php?fecha='+fecha ;
	
	var ancho = 1000;
	
	var alto = 520;
	
	posicion_x=(screen.width/2)-(ancho/2); 
	
	posicion_y=(screen.height/2)-(alto/2); 
	
	window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  
  } 

 
 
//-------------------------
function ImpresionParte(parte,cajero,fecha){        
	
 
 
 
  var posicion_x; 
  var posicion_y; 
  
  var enlace =   '../../reportes/reporteCierreCaja.php?&fecha='+fecha+ '&cajero='+ cajero + '&parte='+ parte;
  
  var ancho = 1000;
  
  var alto = 520;
  
  posicion_x=(screen.width/2)-(ancho/2); 
  
  posicion_y=(screen.height/2)-(alto/2); 
  
  window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

}
/*
*/
 
function diario_contabilizacion()
{
 
	var  fecha      = $("#fecha_q").val();
    
         
	var parametros = {
			 'fecha' : fecha  ,
	 };
 
	  
	$.ajax({
 			 url:   '../model/ajax_diario_registro.php',
			  data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#datadiario").html('Procesando');
				},
			success:  function (data) {
					 $("#datadiario").html(data);   
				     
				} 
	});

}
/*

*/

function resumen_datos()
{
 
	var  fecha      = $("#fecha").val();
    
	 
	var parametros = {
			 'fecha1' : fecha  ,
			 'fecha2' : fecha  ,
			 'cajero': '-',
			 'id' : 83
	 };
 
	  
	$.ajax({
 			 url:   '../model/Model-ven_reportes_periodo.php',
			  data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#resumen_datos").html('Procesando');
				},
			success:  function (data) {
					 $("#resumen_datos").html(data);   
				     
				} 
	});

}
/*
/
*/
 
function LimpiarPantalla()
{

	  

 
	$("#detalle").val();
	$("#documento").val();
	$("#idbancos").val();

	BusquedaGrillaCaja(oTableArticulo);

}

/*
asiento contable
*/
function goToURLParametro(enlace,id_asiento)
{

 
  enlace = '../../kcontabilidad/reportes/ficherocomprobante?a=' + id_asiento;
 
	    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
	 
 
}	