var oTable;

var formulario = 'inv_mov';

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
        
    oTable = $('#jsontable').dataTable(); 
	   
		modulo();
 	     
	    FormFiltro();

	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		$("#ViewForm").load('../controller/Controller-inv_saldos.php');
		 
		
   		
	    $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
		});
	 
	    
	    //-------------------------------------------
	   
	    $("#ExcelButton").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm1').html()));
	        e.preventDefault();
	    });
	    
	    $("#ExcelButton2").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm2').html()));
	        e.preventDefault();
	    });
	  
	    $("#ExcelButton3").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm3').html()));
	        e.preventDefault();
	    });
	    
	    $("#ExcelButton4").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm4').html()));
	        e.preventDefault();
	    });
	  
	    $("#ExcelButton5").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm5').html()));
	        e.preventDefault();
	    });
	    
	    $("#ExcelButton6").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm6').html()));
	        e.preventDefault();
	    });
	    
	    
	    var j = jQuery.noConflict();
		j("#printButton").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};
			    j("#ViewForm1").printArea( options );
		});
		  
		j("#printButton2").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};
		    j("#ViewForm2").printArea( options );
  	  });
		 
		j("#printButton3").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};
		    j("#ViewForm3").printArea( options );
  	  });
		
		
		j("#printButton4").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};
		    j("#ViewForm4").printArea( options );
  	  });
		
		j("#printButton5").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};
		    j("#ViewForm5").printArea( options );
  	  });
		
		j("#printButton6").click(function(){
			var mode = 'iframe'; //popup
			var close = mode == "popup";
			var options = { mode : mode, popClose : close};
		    j("#ViewForm6").printArea( options );
  	  });		
    //-- seleccion de bodega
		 
		 $.ajax({
			 url: "../model/ajax_bodega_resumen.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#cbodega').html(response);
	       }
		 });
		 
		 
		 $.ajax({
			 url: "../model/ajax_cuenta_resumen.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#ccuentas').html(response);
	       }
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
function goToURL( id, vista ) {
 
	 
	 
   	var tipo       = $("#tipo1").val();
  	var fecha1     = $("#fecha1").val();
  	var fecha2     = $("#fecha2").val();
	var producto_busca = $("#producto_busca").val();
 	
 
  	var cbodega     = $("#cbodega").val();
  	var ccuentas    = $("#ccuentas").val();
  	
    var parametros = {
				'tipo' : tipo,  
 				'fecha1' : fecha1,  
				'fecha2' : fecha2,  
				'id' : id,
				'cbodega' : cbodega,
				'ccuentas' : ccuentas,
				'producto_busca':producto_busca
    };
	    
		$.ajax({
			    url:  '../model/Model-Reportes.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#" +vista).html('Procesando');
					},
				success:  function (data) {
						 $("#" +vista).html(data);  // $("#cuenta").html(response);
					     
					} 
		});
	    
 
 
		
    }
 //-----------
function goToProceso(  ) {
	 
	 
	 
  	var fecha2     = $("#fecha2").val();
  	var cbodega     = $("#cbodega").val();
  	
    var parametros = {
 				'fecha2' : fecha2,  
 				'cbodega' : cbodega
     };
	    
		$.ajax({
			    url:  '../model/_saldos_periodo.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ViewForm61" ).html('Procesando');
					},
				success:  function (data) {
						 $("#ViewForm61").html(data);   
					     
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
 
	  
   	var tipo       = $("#tipo1").val();
  	var fecha1     = $("#fecha1").val();
  	var fecha2     = $("#fecha2").val();
 	
  	
 	
    
    var parametros = {
				'tipo' : tipo,  
 				'fecha1' : fecha1,  
				'fecha2' : fecha2
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
								'<p align="right">' +  formatNumber.new(s[i][6], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][7], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][8], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][9], "") + '</p>' ,
 						]);										
					} // End For
			} 					
			} 
	 	});
 		
  }   
//--------------
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

//---------------------  
function BuscaMov(id)
{
 
	var tipourl 				  = $( '#tipo1' ).val();
	objeto 					      =  '#url_' + id;
	var url 				      = $(objeto).val();	
	
	var parametros = {
			"tipourl" : tipourl ,
            "url" : url ,
            "id" : id
	};
	
	$.ajax({
 			 url:   '../controller/Controller-unidad_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticuloActualiza").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticuloActualiza").html(data);   
				     
				} 
	});
 
}  
//----------------
function BuscaCuenta(id)
{
 
	var objeto 					  =  '#tipourl_' + id;
	var tipourl 				  = $(objeto).val();
	objeto 					      =  '#url_' + id;
	var url 				      = $(objeto).val();	
	
	var parametros = {
			"tipourl" : tipourl ,
            "url" : url ,
            "id" : id
	};
	
	$.ajax({
 			 url:   '../controller/Controller-picture_articulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticuloActualiza").html('Procesando');
				},
			success:  function (data) {
					 $("#VisorArticuloActualiza").html(data);   
				     
				} 
	});
 
}  
///---------------
function ActualizaCuenta( )
{
 
	 var cuenta_inventario 	= 	 $('#cuenta_inventario').val();
	 var idproductop 		= 	 $('#idproductop').val();
	 var cuenta_gas 		= 	 $('#cuenta_gas').val(); 
     
	
	var parametros = {
			"cuenta_inventario" : cuenta_inventario ,
            "idproductop" : idproductop ,
            "cuenta_gas" : cuenta_gas
	};
	
	$.ajax({
 			 url:   '../model/Model-editCuentaArticulo.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#GuardaDatoA").html('Procesando');
				},
			success:  function (data) {
					 $("#GuardaDatoA").html(data);   
				     
				} 
	});
     

}
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
//------------------------------------------------
 function Contabilizar( ) {


	   	var tipo       = $("#tipo1").val();
	  	var fecha1     = $("#fecha1").val();
	  	var fecha2     = $("#fecha2").val();
	 	
	 
	    var parametros = {
					'tipo' : 'E',  
	 				'fecha1' : fecha1,  
					'fecha2' : fecha2 
	    };
		   
 
		 	alertify.confirm("<p>Desea generar la contabilizacion? </p>", function (e) {

				 if (e) {
					
						$.ajax({

								data:  parametros,
								url:   '../model/Model-Reportes_contabiliza.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
											$("#view_conta").html('Procesando');
									},
								success:  function (data) {
										$("#view_conta").html(data);  // $("#cuenta").html(response);
									} 

						});

			  }

			 }); 

} 
  