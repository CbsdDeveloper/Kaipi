var formulario 		   =  'ad_orden';
var modulo_sistema     =  'kgarantia';

//-------------------------------------------------------------------------
$(document).ready(function(){
    

	var mes = fecha_hoy()

	var mes1 = fecha_primero()

	
	   $("#qinicial").val(mes1);

	   $("#qfinal").val(mes);

		modulo();
	    
		$("#FormPie").load('../view/View-pie.php');

 		$("#MHeader").load('../view/View-HeaderModel_ad.php');

     
 		 oTable 	= $('#jsontable').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 3 ] },
			      { "sClass": "ye", "aTargets": [ 2 ] },
			      { "sClass": "de", "aTargets": [ 5 ] }
			    ] 
	      } );
 	    
  	     
	    

      $('#load').on('click',function(){
 	 		 
            BusquedaGrilla(oTable);
 
    		BusquedaFinanciero();

           
 		});
         
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
function BusquedaFinanciero( ) {
 
  var mes =  $("#qmes_visor").val();
	
     var parametros = {
					 'mes' :mes
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/_resumen_fin_visor.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewFormFin").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewFormFin").html(data);  // $("#cuenta").html(response);
 						  
 							 
  					} 
  					
			}); 

    }

//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(id) {
 
  var mes  =  $("#qinicial").val();
  var mes1 =  $("#qfinal").val();
 


     var parametros = {
                     'id' : id ,
					 'mes' :mes,
					 'mes1' :mes1
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ad_reportes_comb.php',
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
  function BusquedaGrilla(oTable){        
 
   
	var qinicial   = $("#qinicial").val();
      
	var qfinal   = $("#qfinal").val();

         
            var parametros = {
					'accion' : 'visor',
					'qinicial':qinicial,
					'qfinal':qfinal
 	       };
      
         
            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ad_rep_combustible.php',
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
       	                        s[i][6]
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
    
//------------------------------------------------------
function modulo()
{
 
		 
	 var parametros = {
			    'ViewModulo' : modulo_sistema
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

function fecha_primero()
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
/*
*/
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