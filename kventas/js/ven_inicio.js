var oTable;
var oTableCliente;
var formulario = 'ven_inicio';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});



//-------------------------------------------------------------------------
$(document).ready(function(){
    
	     
	    
         oTable = $('#jsontable').dataTable(); 
         
         oTableCliente = $('#jsontableCliente').dataTable(); 
         
      
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		
		modulo();
 		
 	    FormFiltro();
	    
 	   FormView();
 	   
	    $.ajax({
	 		 url: "../model/Model_lista_Grupo.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#vgrupo').html(response);
	       }
		 });
 

	 	   $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
			});
	 	   
		   $('#loadVerifica').attr("disabled", true);
		   $('#loadok').attr("disabled", true);
		  											
		   
		   
 
 
 	    //-----------------------------------------------------------------
  
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
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
function goToURL(accion,id) {

	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-'+ formulario,
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

//----
function CargaCampana( id) {

	var parametros = {
                     'id' : id 
 	  };
	
	 $.ajax({
		 type : 'GET',
		 data:  parametros,
		 url:   '../model/Model_lista_Campana.php',
		 success:  function (response) {
					 $("#ViewFormCampana").html(response);
			 }

	});
	 
 
    }
//--------------
function CampanaLista( id,campo,medio) {

 
 
 	$("#id_campana_temp").val( id );
	
  	$("#medio_temp").val( medio );
	
    BusquedaGrilla(oTable);
  	
    var titulo = campo.toUpperCase();
     
    $("#vista").html('<h4><b>' + titulo + '</b></h4>');
 	
	 
	 $('#mytabs a[href="#tab2"]').tab('show')
	 
	 
	//--- para telefono 
	 if ( medio == 'telefono' ){
			
		 $("#ViewForm").load('../controller/Controller-' + formulario+ '_phone');
 	  
		 $('#loadVerifica').attr("disabled", true);
		 $('#loadok').attr("disabled", true);
		   
	  }
	
	//--- para correo
	 if ( medio == 'email grupo' ){
			
		 $("#ViewForm").load('../controller/Controller-' + formulario + '_grupoe.php?id='+id);
 		 
		 
		 $('#loadVerifica').attr("disabled", false);
		 
		  $('#loadok').attr("disabled", false);
 	  
	  }
	 
	//--- para whasap 
	 if ( medio == 'whatsapp' ){
			
		 $("#ViewForm").load('../controller/Controller-' + formulario+ '_what');
 	  
		 $('#loadVerifica').attr("disabled", true);
		 $('#loadok').attr("disabled", true);
		   
	  }
	   
	 
	 
    }

//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToURLClientes(accion,id) {

	
	var medio     = $("#medio_temp").val( );
 	var idcampana = $("#id_campana_temp").val()
 	
	//----------------------------------------------------------------------------
 	if ( medio == 'telefono' ){
		
		 alert('Campaña Nro.' + idcampana);
		
		 $("#idcampana_1").val(idcampana);
		 
		 var parametros = {
					'accion' : accion ,
					'id' : id 
	  };
	    $.ajax({
					data:  parametros,
					url:   '../model/Model-'+ formulario,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							   $("#result").html(data);  // $("#cuenta").html(response);
						     
						        $('#mytabs a[href="#tab3"]').tab('show');
						        
					} 
			}); 
	}
 	//----------------------------------------------------------------------------
 	if ( medio == 'email grupo' ){
		
		 alert('Campaña Nro.' + idcampana);
		
		 $("#idcampana_1").val(idcampana);
		 
		 var parametros = {
					'accion' : accion ,
					'id' : id 
	  };
	    $.ajax({
					data:  parametros,
					url:   '../model/Model-'+ formulario,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							   $("#result").html(data);  // $("#cuenta").html(response);
						     
						        $('#mytabs a[href="#tab3"]').tab('show');
						        
					} 
			}); 
	}
 	//----------------------------------------------------------------------------
 	if ( medio == 'whatsapp' ){
		
		 alert('Campaña Nro.' + idcampana);
		
		 $("#idcampana_1").val(idcampana);
		 
		 var parametros = {
					'accion' : accion ,
					'id' : id 
	  };
	    $.ajax({
					data:  parametros,
					url:   '../model/Model-'+ formulario,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							   $("#result").html(data);  // $("#cuenta").html(response);
						     
						        $('#mytabs a[href="#tab3"]').tab('show');
						        
					} 
			}); 
	}
 }
//------------------------------------------
function goToURLDel(accion,id) {
	
	
  	var idcampana = $("#id_campana_temp").val()
	
    var parametros = {
					'accion' : accion ,
					'id' : id 
	  };
	    $.ajax({
					data:  parametros,
					url:   '../model/Model_lista_AsignaCampanaDel.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							   $("#result").html(data);   
							   
							   $("#ProcesoInformacion").html(data);   
 						        
							   BusquedaGrilla(oTable);
					} 
			}); 
 
 }
//------------------------------------------
function goToURLver(accion,id) {
	
	
  	var idcampana = $("#id_campana_temp").val()
  	
  	var medio =  	$("#medio_temp").val(  );
  	
	if ( medio == 'email grupo' ) {
		
	    var parametros = {
						'accion' : accion ,
						'id' : id ,
						'idcampana': idcampana
		  };
		    $.ajax({
						data:  parametros,
						url:   '../model/Model_lista_AsignaCampanaDel.php' ,
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
								$("#result").html('Procesando');
						},
						success:  function (data) {
								   $("#result").html(data);   
								   
								   $("#ProcesoInformacion").html(data);   
	 						        
								   BusquedaGrilla(oTable);
						} 
				}); 
	}else {
		alert('Opcion solo disponible para correo');
	}
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
   
	$("#action").val("add");
	
	$("#idprov").val("");
	$("#razon").val(" ");
	$("#direccion").val(" ");
	$("#telefono").val("");
		$("#correo").val(" "); 
		$("#movil").val(" "); 
		$("#tipo").val(" ");   
	  
    	$("#idciudad").val("");
		$("#contacto").val("");
		$("#ctelefono").val("");
		$("#cmovil").val("");
	  
		$("#ccorreo").val("");
		$("#estado").val("");
		$("#tpidprov").val("");
		$("#naturaleza").val("");
    }
//---------------------------
function EnviarWhatsapp()
{
   
	 var tfono =   $.trim( $("#movil").val()   )  ;
	 var tasunto = $.trim( $("#menwha").val() );
	 
	 if (tasunto)	 {
		   
	 	window.open('https://api.whatsapp.com/send?phone='+tfono+'&text='+tasunto,'_blank');
     
	 }
}

function SegContactos(){        
	  
	 
 
	var id = $("#id_campana_temp").val()
	 
	 var parametros = {
              'id' : id 
      };
	 
    $.ajax({
				data:  parametros,
				url:   '../model/Model_lista_CampanaSegVisor.php',
				type:  'GET' ,
				cache: false,
 				success:  function (data) {
						 $("#ContactosCampana").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 

		 
	 } 
 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	$("#idvencliente").val(id);
 
 
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
 function GenerarPorVerificar( )
 {
    
	      var id_campana = $("#id_campana_temp").val();
  
		  var bool=confirm("Seguro de verificar toda la informacion");
		  
		  if(bool){
			  
			  var parametros = {
	                     'id' : id_campana ,
	                     'estado' : '1' 
		 	  };
			
			 $.ajax({
 				 data:  parametros,
				 url:   '../model/Model_lista_AsignaCampanaMail.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#ProcesoInformacion").html('Procesando');
					},
					success:  function (data) {
							 $("#ProcesoInformacion").html(data);  // $("#cuenta").html(response);
						     
					} 
 	
			});
			  
		    alert("Informacion actualizada");
		    
		    BusquedaGrilla(oTable);
		    
		  }else{
			  
		    alert("cancelo la solicitud");
		    
		  }
       
 }  
 //-------------
 function GenerarPorVerificado( )
 {
    
	      var id_campana = $("#id_campana_temp").val();
  
		  var bool=confirm("Seguro de validar  la informacion");
		  
		  if(bool){
			  
			  var parametros = {
	                     'id' : id_campana ,
	                     'estado' : '2' 
		 	  };
			
			 $.ajax({
 				 data:  parametros,
				 url:   '../model/Model_lista_AsignaCampanaMail.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#ProcesoInformacion").html('Procesando');
					},
					success:  function (data) {
							 $("#ProcesoInformacion").html(data);  // $("#cuenta").html(response);
						     
					} 
 	
			});
			  
		    alert("Informacion actualizada");
		    
		    BusquedaGrilla(oTable);
		    
		  }else{
			  
		    alert("cancelo la solicitud");
		    
		  }
       
 }  
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

    
   	var id_campana = $("#id_campana_temp").val();
   	
  	var estado = $("#qestado").val();
   	
     var parametros = {
 				'id_campana': id_campana,
 				'estado' : estado
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ven_clientesSesion.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
					if (s){
								for(var i = 0; i < s.length; i++) {
									 oTable.fnAddData([
											s[i][0],
											s[i][1],
											s[i][2],
											s[i][3],
											s[i][4],
											s[i][5] +
										'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-xs" title="Editar informacion" onClick="javascript:goToURLClientes('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
										'<button class="btn btn-xs" title="Informacion Verificada ok" onClick="javascript:goToURLver('+"'ver'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-ok"></i></button>&nbsp;' +
										'<button class="btn btn-xs" title="Eliminar informacion" onClick="javascript:goToURLDel('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-trash"></i></button>&nbsp;' +
										'<button class="btn btn-xs" title="Deshabilitar Informacion" onClick="javascript:goToURLDel('+"'anular'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-ban-circle"></i></button>'
										 
									]);										
								} // End For
					} 				
			} 
	 	});
 
  }   
//--------------
/*
  function BusquedaGrillaCliente(oTableCliente){        	 

   	var vprovincia = $("#vprovincia").val();
   	
 	var vcanton = $("#vcanton").val();
 
    
    var parametros = {
 				'vprovincia' : vprovincia,
				'vcanton': vcanton
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ven_inicioCliente.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTableCliente.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
				oTableCliente.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
						s[i][3],
					'<button class="btn btn-xs" onClick="javascript:goToURLClientes('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
				]);										
			} // End For
	 							
			} 
	 	});
 
  }   
  */  
  //------------------------------------------------------------------------- 
 
 
 
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
    

	 $("#ViewForm").load('../controller/Controller-' + formulario);
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFormCliente").load('../controller/Controller-ven_inicioCli.php');
	 

 }
//-----------------
 function abrirGoogle()
 {
    

	 	var idprov = $("#idprov").val();
	 	 
	 	window.open('https://www.google.com.ec/search?q='+idprov,'_blank');
      

 }
//-----------------
 function CrearCampanaEmail()
 {
    
     var id_campana  = $("#id_campana_temp").val();
     var envio_email = $("#envio_email").val();
     var tipo_envio  = $("#tipo_envio").val();
     var fecha_email = $("#fecha_email").val();
     var plantilla   = $("#plantilla").val();
      
     var asunto   = $("#asunto").val();
     
	  var bool=confirm("Generar Campaña Email");
	  
	  if(bool){
		  
		  var parametros = {
                    'id' : id_campana ,
                    'envio_email'  : envio_email,
                    'tipo_envio'   : tipo_envio,
                    'fecha_email'  : fecha_email,
                    'plantilla'    : plantilla,
                    'bandera'	   : 0,
                    'asunto'	   : asunto
                  
	 	  };
		
		 $.ajax({
			 data:  parametros,
			 url:   '../model/Model_lista_CampanaMail.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#result").html('Procesando');
				},
				success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
				} 

		});
		  
	    alert("Informacion actualizada para generar inicio de Campaña");
	    
	 
	    
	  }else{
		  
	    alert("cancelo la solicitud");
	    
	  }
      

 }    
//-----------------
 function IniciarCampanaEmail()
 {
    
     var id_campana  = $("#id_campana_temp").val();
     var envio_email = $("#envio_email").val();
     var tipo_envio  = $("#tipo_envio").val();
     var fecha_email = $("#fecha_email").val();
     var plantilla   = $("#plantilla").val();
     
     var asunto   = $("#asunto").val();
     
     
	  var bool=confirm("Generar Campaña Email");
	  
	  if(bool){
		  
		  var parametros = {
                    'id' : id_campana ,
                    'envio_email'  : envio_email,
                    'tipo_envio'   : tipo_envio,
                    'fecha_email'  : fecha_email,
                    'plantilla'    : plantilla,
                    'bandera'	   : 1,
                    'asunto'	   : asunto
                  
	 	  };
		
		 $.ajax({
			 data:  parametros,
			 url:   '../model/Model_lista_CampanaMail.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#result").html('Procesando');
				},
				success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
				} 

		});
		  
	    alert("Informacion generada realice el seguimiento en el modulo de Gestion de Seguimiento");
	    
	 
	    
	  }else{
		  
	    alert("cancelo la solicitud");
	    
	  }
      

 }  
 
  