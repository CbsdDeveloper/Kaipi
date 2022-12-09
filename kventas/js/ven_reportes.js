var oTable;

var formulario = 'inv_saldos';

$(document).ready(function(){
    
        
	  
	   oTable = $('#jsontable').dataTable(); 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		$("#ViewForm").load('../controller/Controller-inv_saldos.php');
		 
		modulo();
 	     
	    FormFiltro();
   		
	    $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
		});
	 
	    
	    
	    $('#GeneraArriendos').on('click',function(){
	 		   
            GeneraArriendos();
  			
	});
 
	    
	    
	    $('#loadprinter').on('click',function(){
	 		   
            impresion_reporte();
  			
     	});
		  
		  
		   $('#loadxls').on('click',function(){
	  	  
			   	var anio = $("#anio").val();
			   	var idproducto = $("#idproducto").val();
			 	var mes = $("#mes").val();
			 	var idcategoria = $("#idcategoria").val();
			 	
				   
			    var page = "../../reportes/excel_ventas_categoria.php?anio="+anio+'&idproducto='+idproducto+'&mes='+mes+'&idcategoria='+idcategoria;  
	      
		     window.location = page;  
  			
	    	});
 
	        

		    var j = jQuery.noConflict();
		    
		    //-- imprime balance de comprobancion

			j("#GeneraImpresion").click(function(){
					var mode = 'iframe'; //popup
					var close = mode == "popup";
					var options = { mode : mode, popClose : close};

				  j("#ViewReporteArriendos").printArea( options );

			});
   
		   
		   
 
	
});  

//---------------------------------------------------------------
function PoneServicios( id ) {
	 
     var mes = $("#mes").val();
		  
	var parametros = {
			'id' : id  ,
			'mes': mes
		}; 
	
		$.ajax({
				data: parametros,
				url: "../model/ajax_servicios_filtro.php",
				type: "GET",
				success: function(response)
				{
					$('#idproducto').html(response);
				}
			});
	
}

function  impresion_reporte(){       
	  
    var posicion_x; 
    var posicion_y; 
    
    var ancho = 900;
    var alto = 520;
    
 	var anio = $("#anio").val();
   	var idproducto = $("#idproducto").val();
 	var mes = $("#mes").val();
 	var idcategoria = $("#idcategoria").val();
 	
	   
    var enlace = "../reportes/VentasServiciosCategoria.php?anio="+anio+'&idproducto='+idproducto+'&mes='+mes+'&idcategoria='+idcategoria;  
 
 
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
    
 }
 

function GeneraArriendos(  ) {
	 
   	var ftipo = $("#ftipo").val();
   	
 	var ffinalizado = $("#ffinalizado").val();
 	
 
    
    var parametros = {
				'ftipo' : ftipo,  
				'ffinalizado' : ffinalizado 
    };
    
		$.ajax({
			    url:  '../model/resumen_arriendo_cartera.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewReporteArriendos").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewReporteArriendos").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	    

		
		
   }



//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL( id) {
 
	 var parametros = {
	            'id' : id,  
 	    };
	    
		$.ajax({
			    url:  '../controller/Controller-inv_saldos.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewForm").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewForm").html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	    
 
		
		
    }
 
 function goToURL_resumen(  ) {
 
 	var anio = $("#anio").val();
   	
 	var mes = $("#mes").val();
 	
 	var idcategoria = $("#idcategoria").val();
 	
 
    var parametros = {
				'anio' : anio,  
				'mes': mes,
				'idcategoria' : idcategoria 
    };
		$.ajax({
			    url:  '../controller/Controller-servicios_saldos.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFiltroResumen").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFiltroResumen").html(data);  // $("#cuenta").html(response);
					     
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
      
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 
 
	  
   	var anio = $("#anio").val();
   	var idproducto = $("#idproducto").val();
 	var mes = $("#mes").val();
 	var idcategoria = $("#idcategoria").val();
 	
 
    var parametros = {
				'anio' : anio,  
				'idproducto' : idproducto,
				'mes': mes,
				'idcategoria' : idcategoria 
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
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
								'<div align="right">' + s[i][7] + '</div>'
						]);		
						 
						 
					}  
			} 					
			} 
	 	});
 
 
		 goToURL_resumen();
		
  }   
//--------------
//------------------------------------------------------------------------- 
 function modulo()
 {
 	 var modulo1 =  'kventas';
 	 
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
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');
	 
	 $("#ViewFormAuxFiltro").load('../controller/Controller-ren_arriendo_filtro.php');
	 

 }
 //------------------------------------------------
 
  