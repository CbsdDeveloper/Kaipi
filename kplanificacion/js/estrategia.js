$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
     
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
 		
		FormView();
	   
		$("#FormPie").load('../view/View-Pie.php');
     
     
		FormArbolCuentas(1,'-');
	
 
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	//	$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
  		 			var resultado =  `<div class="alert alert-success"><img src="../../kimages/if_error_36026.png" align="absmiddle" />&nbsp;<strong>AGREGAR NUEVO REGISTRO DE TRANSACCION</strong>   COMPLETE LA INFORMACION PARA GUARDAR LA INFORMACION </div>`;
 					$("#result").html(resultado);
 
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
 
  function EliminarInformacion()
{


var vid = $("#idestrategia").val();
	
	  alertify.confirm("<p>DESEA ELIMINAR LA INFORMACION ?</p>", function (e) {
			  if (e) {
				 
 
			     var action =  "del" 
			    var id  =  vid  ;
			   
			    var parametros = {
								'action' : action ,
			                    'idestrategia' :id 
				  };
			
				   $.ajax({
								data:  parametros,
						    	url:   '../model/Model-OE.php',
								type:  'POST' ,
								cache: false,
								beforeSend: function () { 
										$("#result").html('Procesando');
								},
								success:  function (data) {
										 $("#result").html(data);   
									     
								} 
						}); 
						
			
 
			  }
			 }); 
			 
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
    
 
  
            
} 
 
  //------------------------------------------------------------------------- 
 function FormArbolCuentas(nivel,tipo)
 {
 
  
 
	 $("#ViewFormArbol").load('../controller/Controller-oe_arbol.php' );
 
 }
 
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function DetalleOpcion() {
 
     var id =   $('#id_par_modulo').val();
 
     var parametros = {
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-admin_opcion_det.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#opcionModulo").html('Procesando');
  					},
					success:  function (data) {
							 $("#opcionModulo").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
//--------------------------------------------------------------------	
// datos para desplegar los onjetivos
function goToURLDato(vid) {
	
	 
	     var id  =  vid ;
	    
	     var parametros = {
 	                   'id' :id 
		  };
	 
	 	   $.ajax({
						data:  parametros,
				    	url:   '../model/Model-DatoOE.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
								$("#ViewVisorArbol").html('Procesando');
	 					},
						success:  function (data) {
								 $("#ViewVisorArbol").html(data);   
							     
	 					} 
				}); 
	 	   
	  
	 	  
 }	  

function goToURLArbol(vid) {

 
    var action =  "visor" 
    var id  =  vid  ;
   
    var parametros = {
					'action' : action ,
                    'id' :id 
	  };

	   $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OE.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							 $("#result").html(data);   
						     
					} 
			}); 
 
 
   $('#mytabs a[href="#tab2"]').tab('show');
	 
	
}
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToURL(accion,id) {


	
  var parametros = {
					'accion' : accion ,
                 'id' : id 
	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-admin_opcion.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
					} 
			}); 

 }

function modulo()
{
 

	 var modulo =  'kplanificacion';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
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
//-------------
function PoneCodigo(codigo)
{
 
 
 var parametros = {
			    'codigo' : codigo 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-CodiUnidad.php?',
			type:  'GET' ,
				beforeSend: function () { 
						$("#IDESTRATEGIA").val('Procesando');
				},
			success:  function (data) {
					 $("#IDESTRATEGIA").val(data);  // $("#cuenta").html(response);
				     
				} 
	});
     
 
}

//-----------------
function FormView()
{
   
	 
 	 $("#ViewForm").load('../controller/Controller-OE.php');
     
 	 $("#result").html('Desea agregar información');
 	
}
 
function accion(id,modo)
{
 
  	 $("#action").val(modo);
  
  	 $("#idestrategia").val(id);
 
	 FormArbolCuentas(1,'-');
	 
	 
}
 //-------------------
function LimpiarPantalla( )
{
	 
 	 $("#action").val('add');
 	 
 	$("#idestrategia").val("");
 	$("#idestrategia_padre").val("0");
 	$("#idestrategia_matriz").val("0");
 	$("#objetivoe").val("");
 	$("#estado").val("");
 	$("#aporte").val("");
 	$("#ambito").val("");
 	$("#nivel").val(""); 

}