var oTable; 
var formulario = 'anulados'; 

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
    
    window.addEventListener("keypress", function(event){
        if (event.keyCode == 13){
            event.preventDefault();
        }
    }, false);
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
        oTable = $('#jsontable').dataTable(); 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
 		
 	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
  			
		});
 
 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$("#action").val("add");
					
                    LimpiarPantalla();
                    
                	$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
                    
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }

function accion(id,modo)
{
 
  
			$("#action").val(modo);
			
			$("#id_anulados").val(id);          

	 

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accionDato,id) {

	
 
	
	var parametros = {
					'accion' : accionDato ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-'+formulario,
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
   
	mes = mes_a();
	anio= anio_a();
	
	
	$("#anio").val(anio);
	$("#mes").val(mes);
	
	
	$("#id_anulados").val("");
	$("#tipocomprobante").val("");
	$("#establecimiento").val("");
	$("#puntoemision").val("");
	$("#secuencialinicio").val("");
	$("#secuencialfin").val("");
	$("#autorizacion").val("");
	 
 
	
    }
   
 
 //---------------------------
 function anio_a()
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
  
    
    var today = yyyy ;
    
   return today;
            
} 
 
 //-------------------
 function mes_a()
 {
    
     var today = new Date();
     var dd = today.getDate();
     var mm = today.getMonth()+1; //January is 0!
 
   
     
     var today =   mm  ;
     
    return today;
             
 } 
  
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
		var user = $(this).attr('id');
		
     	var anio = $("#canio").val();
    	var mes = $("#cmes").val();
    	
          
      var parametros = {
				'anio' : anio  ,
				'mes' : mes  
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_' + formulario  ,
			dataType: 'json',
			cache: false,
			success: function(s){
	 
			oTable.fnClearTable();
			if (s){ 
					for(var i = 0; i < s.length; i++) {
						 oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
							s[i][4],
							s[i][5],
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			}				
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
 
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 
 function modulo()
 {
 	 var modulo =  'ktributacion';
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
    

	 $("#ViewForm").load('../controller/Controller-' + formulario );
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro.php');
	 

 }
 //------------------------
   
//---------------
 function NaN2Zero(n){
	    return isNaN( n ) ? 0 : n; 
	}
 
//---------------
function ponedatos( ){
	
	 
	var secuencial =  parseFloat( $('#establecimiento').val()  )
	
	var h =('000' + secuencial).slice (-3);
	 
	$('#establecimiento').val(h);
	 
	var secuencial1 =  parseFloat( $('#puntoemision').val()  )
 	
	if ( secuencial1  ){
		
		var h1 =('000' + secuencial1).slice (-3);
		 
		$('#puntoemision').val(h1);
	}

 }

//------------------------------------------------------------------------- .


function validadatos( ){
	
	 
	var secuencial1 =  parseFloat( $('#secuencialinicio').val()  )
	var secuencial2 =  parseFloat( $('#secuencialfin').val()  )
	
	 
	if ( secuencial1 > secuencial2){
		alert('Verifique la secuencia de los comprobantes');
		$('#secuencialinicio').val('');
		$('#secuencialfin').val('');
	}
 
	    
	 
	}


  