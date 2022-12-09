$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


var oTable;
var oTableCliente;

var formulario = 'ven_interes';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
         oTable = $('#jsontable').dataTable(); 
         
         FormView();
      
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		
		modulo();
 		
		BusquedaGrilla('','3');
	  
  
});  
//---------------------------------------------------
function accion(id,modo)
{
  
			$("#action").val(modo);
			
			$("#idvengestion").val(id);          

			VerActividadActualiza() ;

}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
 			  	 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
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
function goToURL(  ) {
	
	var idcliente = $("#idcliente").val();
	
	var idvengestion = $("#idvengestion").val();
	
 	
	var razon =  $("#nombre").val();
	
 
	
	var accion;
 
	LimpiarPantalla();
	
	$("#razon_nombre").val(razon);
	
	
	
	if (idvengestion){
		accion = 'editar';
		$("#action").val("editar");
		$("#result").html('<img src="../../kimages/kedit.png" align="absmiddle"/><b> EDITAR REGISTRO TRANSACCION</b>');
   			   
	}else{
		accion = 'add';
		$("#action").val("add");
		$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
		
	}
	
  
	var parametros = {
					'idcliente' : idcliente ,
                    'idvengestion' : idvengestion ,
                    'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_interes.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 						    	$("#result").html('Procesando');
  					},
					success:  function (data) {
 
							    $("#result").html(data);
 							
  					} 
			}); 

    }
//----------------
function goToURLTarea(  ) {
	
	var idcliente = $("#idcliente").val();
	
	var idvengestion = $("#idvengestion").val();
	
	var accion;
 
	LimpiarPantalla();
	
	
	if (idvengestion){
		accion = 'editar';
		$("#action").val("editar");
		

	}else{
		accion = 'add';
		$("#action").val("add");
		
	}
	
  
	var parametros = {
					'idcliente' : idcliente ,
                    'idvengestion' : idvengestion ,
                    'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_interes.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 						    	$("#result").html('Procesando');
  					},
					success:  function (data) {
 
							    $("#result").html(data);
 							
  					} 
			}); 

    }
//-------------------------------------------
function goToURLCIU(  ) {
	
	var idcliente = $("#idcliente").val();
	
    var accion = 'editar';
	
    $("#actionCiu").val("editar");
	 
    
 
	var parametros = {
					'idcliente' : idcliente ,
                     'accion': accion
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inte_clientes.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 						    	$("#guardarCliente").html('Procesando');
  					},
					success:  function (data) {
 
							    $("#guardarCliente").html(data);
 							
  					} 
			}); 

    }
//---------------
function VerHistorial( id, nombre )
{
  
 	
	$("#nombre_actual").html('<img src="../../kimages/mano.png" align="absmiddle"/> <b>[ '+nombre+' ]</b>');
	
	$("#nombre").val(nombre);
	$("#idcliente").val(id);
	
	$("#razon").val(nombre);
	$("#idprov").val(id);
	 
	
	VerActividad(id,nombre);
	
	VerAvance(id);
} 

//------------
function VerActividad(idcliente,nombre) {

	var accion = 1;
 	
	$("#idvengestion").val('');
	 
	$("#idcliente").val(idcliente);
	$("#nombre").val(nombre);
	
	
	$("#idprov").val(idcliente);
	$("#razon").val(nombre);
	
	
	var parametros = {
					'accion' : accion ,
                    'idcliente' : idcliente 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_interes_ac.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#BandejaHistorial").html('Procesando');
  					},
					success:  function (data) {
							 $("#BandejaHistorial").html(data);  
							 
						//	 VerAvance(idcliente);
						     
  					} 
			}); 

    }
//----------------------------------------
function VerAvance(idcliente) {

 
  	
	var parametros = {
                     'idcliente' : idcliente 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_in_avance.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewAvance").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewAvance").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
//-----------
function VerActividadActualiza() {

	var accion = 1;
	var idcliente	= $("#idcliente").val( );
 	
	$("#idvengestion").val('');
	

	 
	
	var parametros = {
					'accion' : accion ,
                    'idcliente' : idcliente 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_interes_ac.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#ViewFormActividad").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewFormActividad").html(data);  // $("#cuenta").html(response);
						     
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
   
	
	$("#estado").val("");
	$("#proceso").val("");
	$("#medio").val("");
	$("#canal").val("");
	$("#sesion").val("");
	$("#novedad").val("");
	$("#fecha").val("");
	$("#producto").val("");
	$("#porcentaje").val("");
	
	
    }
   
 
 

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
///----------------
 function BuscaCanton(cprov)
 {
    
	 var parametros = {
			 'cprov'  : cprov  
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_buscaCanton.php",
		 type: "GET",
        success: function(response)
        {
            $('#vcanton').html(response);
        }
	 });
      
 } 
 ///--
 function BuscaCantond(cprov)
 {
    
	 var parametros = {
			 'cprov'  : cprov  
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_buscaCanton.php",
		 type: "GET",
        success: function(response)
        {
            $('#canton').html(response);
        }
	 });
      
 }  
 
  //------------------------------------------------------------------------- 
 function BusquedaGrilla(cumplimiento,estado){        	 
	 
	  
	    var parametros = {
 				 'estado' : estado,
				 'pagina': 0
	   };
	    
	    $("#estado1").val(estado);
 	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-interesCliente.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
		  
		    $("#nombre_actual").html('[ Seleccionar cliente ]</b>');
			$("#nombre").val('');
			$("#idcliente").val('');
			
			$("#razon").val('');
			$("#idprov").val('');
			
			
		 $("#pag").val(0);
		 
	
}   
 
 //------------
 function PaginaGrilla(signo){        	 
	  
	  
	   var estado       = $("#estado1").val();
 	   
	   var acumula		= $("#pag").val();
	   
	   var pagina 		= parseInt(acumula) ;
	   
	   if (signo  > 0 ){  
		   pagina = pagina + 8 ;
	   }else { 
		   pagina = pagina - 8 ;
	   }
	   
	   var acumula		=parseInt(pagina) ;
	   
	   //------------------------------------------	   
	   $("#pag").val(acumula );
	   
	   if ( pagina < 0 ) { 
		   $("#pag").val(0);
	   }
	   //------------------------------------------ 
	    
	    var parametros = {
 				 'estado' : estado,
				 'pagina': pagina
	   };
	    
	 //VerHistorial
	  	 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model-interesCliente.php",
			 type: "GET",
	        success: function(response)
	        {
	            $('#BandejaDatos').html(response);
	        }
		 });
		 
	
}    
  
 //----------------
  function filtroUser(us){        	 

	  
		var parametros = {
				'user' : us  
	  };

		
		$.ajax({
			data:  parametros,
	 		url:   '../model/Model-interesCliente.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFormLista").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormLista").html(data);  // $("#cuenta").html(response);
				     
					} 
		});
 
	  }   
 
//--------------
   
 function modulo()
 {
 	 var modulo =  'kventas';
 	 
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
    

	 $("#ViewFormCliente").load('../controller/Controller-' + formulario);
     
	 
	 $("#ViewFormProv").load('../controller/Controller-inte_clientes.php');

	 
	 
 }
 
//----------------------
 function FormFiltro()
 {
  
	 
	 

 }
//-----------------
 function abrirGoogle()
 {
    

	 	var idprov = $("#idprov").val();
	 	 
	 	window.open('https://www.google.com.ec/search?q='+idprov,'_blank');
      

 }
    
  