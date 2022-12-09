$(function(){
      
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
 
});



var oTableGrid;  
var oTable ;

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
       
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		modulo();
 		
	    FormView();
	    
     
 
 //-----------------------------------------------------------------

});  
//-----------------------------------------------------------------
 
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
                    accion(0,'');
                    
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

	 $("#txtcuenta").val('');
	 $("#cuenta").val('');
	 
	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-co_asientos.php',
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

	var fechaa = fecha_hoy();
	
	$("#fecha").val(fechaa);
	
 	$("#detalle").val("");
 	
 	$("#comprobante").val("");
	
 	$("#estado").val("");
	
 	$("#idprov").val("");
	
 	$("#estado_pago").val("");
	
 	$("#apagar").val(0);
 	
 	$("#id_solpagos").val(0);
	
 	$("#txtidprov").val("");
	
	$("#action").val("");
		
 	
		 
 
 }
   
//-------------------------------------------------------------------------
//ir a la opcion de editar
function validaPantalla() {

	var valida = 1;
 
	if (  $("#idprov").val()  ) { valida = 0 ; } else { valida = 1 ; }
	
/*	if (  $("#comprobante").val()  ) { valida = 0 ; } else { valida = 1 ; }	
	  
	if (  $("#documento").val()  ) { valida = 0 ; } else { valida = 1 ; }
	
	if (  $("#estado").val()  ) { valida = 0 ; } else { valida = 1 ; }	

	if (  $("#tipo").val()  ) { valida = 0 ; } else { valida = 1 ; }
	
	if (  $("#detalle").val()  ) { valida = 0 ; } else { valida = 1 ; }	

	 */
	 	
	 return valida;

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
 
  //------------------------------------------------------------------------- 
    
  
//------------------------------------------------------------------------- 
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
    

	 $("#ViewForm").load('../controller/Controller-co_solicitupago.php');
      

 }
 
//ir a la opcion de editar
 function goToURL(accion,id) {
 
 	 
 	var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };
 	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-co_solicitupago.php',
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
 
 
//----------------------
 
//----------------------
 function accion(id,modo,estado)
 {
	
 
  
	 if (modo == 'aprobado'){
			$("#action").val('aprobado');
			$("#estado").val('aprobado');          
			$("#comprobante").val(estado);       
	 }else{
			$("#action").val(modo);
			$("#estado").val(estado);          
 	 }
	 		
	      $("#id_solpagos").val(id);
 	 
 

 }
 
 
 function tramite(estado){
     
    
 	 
	 var parametros = {
				'estado' : estado  
    };
     
 
			    
				  $.ajax({
								data:  parametros,
								url:   '../controller/Controller-listapago.php',
								type:  'POST' ,
								cache: false,
								beforeSend: function () { 
										$("#listramite").html('Procesando');
								},
								success:  function (data) {
										 $("#listramite").html(data);  // $("#cuenta").html(response);
									     
								} 
						}); 
		 

	}
 
 function idtramite(idcodigo){
     
    
 
 	 
	 var parametros = {
				'idcodigo' : idcodigo  
    };
     
 
			    
				  $.ajax({
								data:  parametros,
								url:   '../controller/Controller-verpago.php',
								type:  'POST' ,
								cache: false,
								beforeSend: function () { 
										$("#vertramite").html('Procesando');
								},
								success:  function (data) {
										 $("#vertramite").html(data);  // $("#cuenta").html(response);
									     
								} 
						}); 
		 

	}