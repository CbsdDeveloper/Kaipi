var oTable;

var formulario = 'inv_kardex';

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
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
	 
	    
	    //-------------------------------------------
	    
	    var j = jQuery.noConflict();
 
		j("#printButton").click(function(){

				var mode = 'iframe'; //popup

				var close = mode == "popup";

				var options = { mode : mode, popClose : close};

			  j("#Impresion").printArea( options );

			});
		  
		
		
		  $("#ExcelButton").click(function(e) {
		        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#Impresion').html()));
		        e.preventDefault();
		    });
   
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
						 $("#ViewForm").html(data);  // $("#cuenta").html(response);
					     
						 goToURLDatos(id);
						 grafico_01(id);
						 
					} 
		});
	    
 
		 $('#mytabs a[href="#tab2"]').tab('show');
		
    }
//---------------------------------
function goToURLDatos( id) {
	 
	 var parametros = {
	            'id' : id,  
	    };
	    
		$.ajax({
			    url:  '../controller/Controller-inv_saldos_datos.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormReporte").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewFormReporte").html(data);  // $("#cuenta").html(response);
					     
 						 
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
 
 
 	
 	var idcategoria = $("#idcategoria").val();
 	
 	var idproducto = $("#idproducto").val();
 	
 	
    
    var parametros = {
  				'idproducto': idproducto,
				'idcategoria' : idcategoria,  
     };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
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
							'<button class="btn btn-xs" onClick="javascript:goToURL(' + s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' 
						]);										
					} // End For
			} 					
			} 
	 	});
 
		grafico(idcategoria);
		
  }   
//--------------
//------------------------------------------------------------------------- 
 function modulo()
 {
 	 var modulo1 =  'kinventario';
 	 
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
 
//----------------------
 function Categoria(dato)
 {
  
	 var parametros = {
			 'dato'  : dato 
    };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model-ListaProductos.php",
		 type: "GET",
        success: function(response)
        {
            $('#idproducto').html(response);
        }
	 });

 }
 //------------------------------------------------
 function grafico(idcategoria) {
	 
 
	 var options = {
             chart: {
                 renderTo: 'div_grafico1',
                 type: 'line'
             },
             title: {
                 text: ' ',
               //  x: -20 //center
             },

             xAxis: {
                 categories: [],
                 title: {
                     text: 'Mes'
                 }
             },
             yAxis: {
                 title: {
                     text: 'Movimientos'
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
			
         $.getJSON("../grilla/grilla_grafico_categoria.php?id="+idcategoria, function(json) {
             options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
             options.series[0] = json[1];
             options.series[1] = json[2];
             chart = new Highcharts.Chart(options);
         });
     
		
    }
 ///------------grilla_grafico_producto.php
 function grafico_01(id) {
	 
	 
	 var options = {
             chart: {
                 renderTo: 'div_grafico',
                 type: 'line'
             },
             title: {
                 text: ' ',
               //  x: -20 //center
             },

             xAxis: {
                 categories: [],
                 title: {
                     text: 'Mes'
                 }
             },
             yAxis: {
                 title: {
                     text: 'Producto'
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
			
         $.getJSON("../grilla/grilla_grafico_producto.php?id="+id, function(json) {
             options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
             options.series[0] = json[1];
             options.series[1] = json[2];
             chart = new Highcharts.Chart(options);
         });
     
		
    }