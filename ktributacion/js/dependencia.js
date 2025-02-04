var oTable; 
var formulario = 'dependencia'; 

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
 
 	   $('#loade').on('click',function(){
   			
			goToURLEmailLote() 

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
//----


function proceso_rdep( ) {

	
 var anio = 	$("#canio").val();   
	
	var parametros = {
					'accion' : 'proceso' ,
                    'anio' : anio 
	   };
	   
	    alertify.confirm("DESEA GENERAR EL PROCESO DEL PERIODO " + anio, function (e) {
			  if (e) {
				 
				 $.ajax({
					data:  parametros,
					url:   '../model/Model-'+formulario,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#view_proceso").html('Procesando');
  					},
					success:  function (data) {
							 $("#view_proceso").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
                     
			  }
			 }); 
	 

    }
//---------------------------

function goToURLEmailLote() {   

	 alert('Notificar por medio electronica');
		 
		 var i = 0 ;
		 
		 $('#jsontable tr').each(function() { 
			    
			 
			   var customerId = $(this).find("td").eq(0).html();  
			
			   if (  i >   0  ) { 
				   
				 envia_correo(customerId);
				        

			
				   
			   }
			   
			   i = i + 1;
			  
	     }); 

}
//---------

function envia_correo(id){   

	  var canio 			= 	$('#canio').val();
	

	   var parametros = {
                  'id' 	  : id, 
                 'canio'   : canio 
 	   	};
 

	   $.ajax({

				data:  parametros,

				url:   '../model/EnvioPersonalCorreo.php',

				type:  'GET' ,

				success:  function (data) {

						 $("#ViewSave").html(data);  // $("#cuenta").html(response);

					     

				} 

		}); 

	

} 
//------------------------	
function Imprime107( )
{

	var id = 	$("#id_redep").val();          


   enlace = '../reportes/informe107?id=' +id;

 
	    if (id  > 0) {

	    	  window.open(enlace,'#','width=750,height=480,left=30,top=20');
	    	  
	     }

 
 
 }
function accion(id,modo)
{
 
  
			$("#action").val(modo);
			
			$("#id_redep").val(id);          

	 

}
function ProcesoInformacion( ){   

 
	var banio 			= 	$('#canio').val();
	var idprov   		= 	$('#idret').val();
  

	var parametros = {
					'banio' 		  : banio, 
					'idprov': idprov 
	 };

	var parametros1 = {
					'banio' 		  : banio, 
					'idprov': idprov 
	 };
	 
	 $.ajax({
				   data:  parametros,
				   url:   '../../kpersonal/model/ajax_personal_rol00.php',
				   type:  'GET' ,
					beforeSend: function () { 
							$("#Viewrol").html('Procesando');
					 },
				   success:  function (data) {
							$("#Viewrol").html(data); 

					 } 

		   }); 
		   
		   
	   
		$.ajax({
				   data:  parametros1,
				   url:   '../../kpersonal/model/ajax_personal_rol01.php',
				   type:  'GET' ,
					beforeSend: function () { 
							$("#ViewResumen").html('Procesando');
					 },
				   success:  function (data) {
							$("#ViewResumen").html(data); 

					 } 

		   }); 	
		   
		   


} 
//----------------
function goToDeta2( accion, nombre){   

 
	var banio 			= 	$('#canio').val();
	var idprov   		= 	$('#idret').val();

	var parametros = {
					'banio' 		  : banio, 
					'idprov': idprov ,
					'tipo': 2,
					'accion' :accion,
					'nombre' : nombre
	 };

 
	 
	 $.ajax({
				   data:  parametros,
				   url:   '../../kpersonal/model/ajax_personal_rol02.php',
				   type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormRolPersona").html('Procesando');
					 },
				   success:  function (data) {
							$("#ViewFormRolPersona").html(data); 

					 } 

		   }); 


$('#myModal').modal('show');

} 

//---------
function goToDeta1( accion, nombre){   

 
	var banio 			= 	$('#canio').val();
	var idprov   		= 	$('#idret').val();

	var parametros = {
					'banio' 		  : banio, 
					'idprov': idprov ,
					'accion' :accion,
					'tipo': 1,
					'nombre' : nombre
	 };

 
	 
	 $.ajax({
				   data:  parametros,
				   url:   '../../kpersonal/model/ajax_personal_rol02.php',
				   type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormRolPersona").html('Procesando');
					 },
				   success:  function (data) {
							$("#ViewFormRolPersona").html(data); 

					 } 

		   }); 


$('#myModal').modal('show');

} 
//---------
function goToRol(accion, id_rol1)
  {
  	 
  	 var id =  	$('#idret').val();
  	 
  	   var url = '../../reportes/view_rol_nomina.php'

	       var posicion_x; 
	       var posicion_y; 
	       var enlace = url + '?codigo='+id +'&id_rol=' + id_rol1+ '&accion='+accion;

	       var ancho = 1000;

	       var alto = 520;

	       posicion_x=(screen.width/2)-(ancho/2); 
	       posicion_y=(screen.height/2)-(alto/2); 

	       window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  	 
} 
//-------
function genera_xml()
{

   
  var anio = 	$("#canio").val();   
	
  alert('Generar XML' + anio );

  enlace = '../model/xml_rdep?anio=' + anio ;
										   
  var win = window.open(enlace, '_blank');
  
  win.focus();

 	 
}  
//---
function resumen_rdep( ) {
 
	
	 var anio = 	$("#canio").val();   

	var parametros = {
					'anio' : anio ,
  	  };
	  $.ajax({
					data:  parametros,
					url:   '../controller/Controller-dependencia_resumen.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#view_resumen").html('Procesando');
  					},
					success:  function (data) {
							 $("#view_resumen").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
//-------------------------------------------------------------------------
//---

//ir a la opcion de editar
function goToURLCalculo(tipo) {
 
	var anio   = $("#anio").val();
	var idret  = $("#idret").val();
	
	
	alert('Revisa los datos de Base Imponible/Actualiza información');

	var parametros = {
					'accion' : tipo ,
                    'anio' : anio ,
                    'idret' : idret
 	  };
	

	  if ( tipo == '3'){

					$.ajax({
						data:  parametros,
						url:   '../model/Model-'+formulario,
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
								$("#result").html('Procesando');
						},
						success:  function (data) {
								$("#result").html(data);   
								
						} 
				}); 



      }else{
				$.ajax({
					type:  'GET' ,
					data:  parametros,
					url:   '../model/Model-'+formulario,
					dataType: "json",
					success:  function (response) {
			
						
							$("#basimp").val( response.a );  
							
							$("#valret").val( response.b );  
							
					} 
			});
				
		}

    }


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
   
 
	
	$("#id_redep").val("");
	
	$("#anio").val("");
	$("#idret").val("");
	
	$("#bengalpg").val("NO");
	$("#enfcatastro").val("NO");
	$("#tipidret").val("C");

	
	$("#apellidotrab").val("");
	$("#nombretrab").val("");

	$("#estab").val("001");
	$("#residenciatrab").val("01");
	$("#paisresidencia").val("593");
	$("#aplicaconvenio").val("NA");
	$("#tipotrabajdiscap").val("01");
	$("#porcentajediscap").val("0");
	$("#tipiddiscap").val("N");
	$("#iddiscap").val("999");


	$("#suelsal").val("0.00");
	$("#sobsuelcomremu").val("0.00");
	$("#partutil").val("0.00");
	$("#intgrabgen").val("0.00");
	$("#imprentempl").val("0.00");
	$("#decimter").val("0.00");
	$("#decimcuar").val("0.00");
	$("#fondoreserva").val("0.00");
	$("#salariodigno").val("0.00");
	$("#otrosingrengrav").val("0.00");
	$("#inggravconesteempl").val("0.00");
	$("#sissalnet").val("1");
	$("#apoperiess").val("0.00");
	$("#aporperiessconotrosempls").val("0.00");
	$("#deducvivienda").val("0.00");
	$("#deducsalud").val("0.00");
	$("#deduceducartcult").val("0.00");
	$("#deducaliement").val("0.00");
	$("#deducvestim").val("0.00");
	$("#exodiscap").val("0.00");
	$("#exotered").val("0.00");
	$("#basimp").val("0.00");
	$("#imprentcaus").val("0.00");
	$("#valretasuotrosempls").val("0.00");
	$("#valimpasuesteempl").val("0.00");
	$("#valret").val("0.00");
		
	
    }
  
//--
function validarCiu() {
     
	 
	 var cad = document.getElementById("idret").value.trim();
	 
	 var tpidprov = document.getElementById("tipidret").value.trim();
	 

      
     var total = 0;
     var longitud = cad.length;
     var longcheck = longitud - 1;
 

     if (tpidprov == 'C'){
    	 
			     if (cad != "" && longitud == 10){
			       for(i = 0; i < longcheck; i++){
			         if (i%2 === 0) {
			           var aux = cad.charAt(i) * 2;
			           if (aux > 9) aux -= 9;
			           total += aux;
			         } else {
			           total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
			         }
			       }
			
			       total = total % 10 ? 10 - total % 10 : 0;
			
					 
						
			       if (cad.charAt(longitud-1) != total) {
 			    	
 			    	   document.getElementById("idret").value = 'NO_VALIDO';
		 
			       } 
		     }else{
		    	 document.getElementById("idret").value = 'NO_VALIDO';
		     }
		    	 
       }
     //-----------------------------------
    
     
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
  function BusquedaGrilla(oTable){        	 

  		
     var anio = $("#canio").val();
     	
          
      var parametros = {
				'anio' : anio  ,
       };

 
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
							s[i][6],
							s[i][7],
							'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			}				
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
	 
		
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
  
    
//---------------
 function NaN2Zero(n){
	    return isNaN( n ) ? 0 : n; 
	}
//---------------
    