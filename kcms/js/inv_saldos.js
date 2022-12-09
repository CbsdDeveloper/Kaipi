var oTable;

var formulario = 'inv_saldos';

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
        
	  
	 oTable =  $('#jsontable').dataTable( {
		    "aoColumnDefs": [
		      { "sClass": "highlight", "aTargets": [ 6] },
		      { "sClass": "ya", "aTargets": [ 7 ] },
		      { "sClass": "ye", "aTargets": [ 8 ] }
		    ] ,
		    "language":  [ {
	            "decimal": ",",
	            "thousands": "."
	           }
		    ] 
       } 
     );
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		$("#ViewForm").load('../controller/Controller-inv_saldos.php');
		 
		modulo();
 	     
	    FormFiltro();
   		
	    $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
		});
	 
	    var j = jQuery.noConflict();
 
		j("#printButton").click(function(){

				var mode = 'iframe'; //popup

				var close = mode == "popup";

				var options = { mode : mode, popClose : close};

			  j("#ImprimeK").printArea( options );

			});
	
		  
		   $('#loadxls').on('click',function(){
	  	  
	  
		    var page = "../../reportes/excel_saldos.php";  
	      
		     window.location = page;  
  			
	    	});
		   
		   $('#loadxls_matriz').on('click',function(){
			  	  
				  
			    var page = "../../reportes/excel_saldos1.php";  
		      
			     window.location = page;  
	  			
		    	});
		   
		   
		   $('#loadKardex').on('click',function(){
			  	  
			   kardex_item();
			   
		    });
 
	       $('#loadSaldo').on('click',function(){
	  	  
	  
					   $.ajax({
 						 url:   '../model/Model-saldo_bodega.php',
						type:  'POST' ,
						cache: false,
						beforeSend: function () { 
									$("#SaldoBodega").html('Procesando');
							},
						success:  function (data) {
								 $("#SaldoBodega").html(data); 

							} 
				});
  			
	    	});
   
	       fecha_hoy();
	
});  



 

//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
				 
					 
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
						 $("#ViewForm").html(data);   
						 activaTab();
					} 
		});
	    
	    $("#itemkardex").val(id);
 
		
		
		
 }
//----
function kardex_item(  ) {
	 
	
	var iditem =   $("#itemkardex").val();
	
	var fecha1 =    $("#fecha1").val();
    
	var fecha2 =   $("#fecha2").val();
    
 
	  var parametros = {
	            'iditem' : iditem,  
	            'fecha1' : fecha1,
	            'fecha2' : fecha2
	    };
	    
		$.ajax({
			    url:  '../controller/Controller-inv_saldos_kardex.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewKardex").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewKardex").html(data);  // $("#cuenta").html(response);
					     
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
    
    var today1 = yyyy + '-' + '01' + '-' + '01';
    
    $("#fecha1").val(today1);
    
    $("#fecha2").val(today);
      
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 
 
	  
   	var tipo 			= $("#tipo").val();
   	
   	var facturacion 	= $("#facturacion").val();
  	
 	var idmarca 		= $("#idmarca").val();
 	
 	var idcategoria 	= $("#idcategoria").val();
 	
 	var nivel 			= $("#nivel").val();
 	
 	var idbodega 		= $("#idbodega1").val();
  	
	var nombre_producto = $("#nombre_producto").val();

 	var codigog 			= $("#codigog").val();
	
	
 	
 	
    
    var parametros = {
				'tipo' : tipo,  
				'facturacion' : facturacion,
				'idmarca': idmarca,
				'codigog' : codigog,
				'idcategoria' : idcategoria,  
				'nivel' : nivel,  
				'nombre_producto':nombre_producto,
				'idbodega':idbodega
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
								'<div align="right">' +s[i][5]  + '</div>',
								'<div align="right">' + s[i][6] + '</div>',
								'<div align="right">' + s[i][7] + '</div>',
								'<div align="right">' + s[i][8] + '</div>',
 							'<button class="btn btn-xs" onClick="javascript:goToURL(' + s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
						]);		
						 
						 
					} // End For
			} 					
			} 
	 	});
 
 
		
  }   
//--------------
//------------------------------------------------------------------------- 
 function modulo()
 {
	 var modulo1 =  'kcms';
 	 
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
	 

 }
 //------------------------------------------------
 
  