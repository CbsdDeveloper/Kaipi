var oTable;

var formulario = 'inv_ventas';

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
		
	 
		modulo();
 	     
	    FormFiltro();
   		
	    $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
		});
	 
	    
	    //-------------------------------------------
	   
	    $("#ExcelButton").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm').html()));
	        e.preventDefault();
	    });
	  
	    
 
 
	    
	  
	    
	    var j = jQuery.noConflict();
 
		j("#printButton").click(function(){

				var mode = 'iframe'; //popup

				var close = mode == "popup";

				var options = { mode : mode, popClose : close};

			  j("#ViewForm").printArea( options );

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
function goToURL( id ) {
 
	 
	 
   	var tipo       = $("#tipo1").val();
  	var fecha1     = $("#fecha1").val();
  	var fecha2     = $("#fecha2").val();
 	
 
    var parametros = {
				'tipo' : tipo,  
 				'fecha1' : fecha1,  
				'fecha2' : fecha2,  
				'id' : id
    };
	    
		$.ajax({
			    url:  '../model/Model-ReportesVentas.php' ,
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
		//	console.log(s); 
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
								'<p align="right">' +  formatNumber.new(s[i][7], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][8], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][9], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][10], "") + '</p>' ,
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
	 

 }
//------------------------------------------------
//----------------------
 function Contabilizar()
 {
  
 	  	var fecha1     = $("#fecha1").val();
	  	var fecha2     = $("#fecha2").val();
	  	var idbancos     = $("#idbancos").val();
	 	
	 
	    var parametros = {
 	 				'fecha1' : fecha1,  
					'fecha2' : fecha2,  
					'idbancos': idbancos
 	    };
		    
			$.ajax({
				    url:  '../model/Model-ContaVentas.php' ,
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#ContabilizadoVentas").html('Procesando');
						},
					success:  function (data) {
							 $("#ContabilizadoVentas").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	 

 } 
  