var oTable;
var modulo_sistema     =  'kpersonal';
 
 
//-------------------------------------------------------------------------
$(document).ready(function(){
	
		modulo();
	
		FormView();


       oTable 	= $('#jsontable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
           aoColumnDefs: [
  		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "ye", "aTargets": [ 1 ] },
 		      { "sClass": "de", "aTargets": [ 4 ] } 
 		    ] 
      } );
       
      
 
		$.ajax({
 			 url: "../model/ajax_unidad_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qunidad').html(response);
	       }
		 });
	    
	    $.ajax({
			 url: "../model/ajax_regimen_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qregimen').html(response);
	       }
		 });
	    

 	   $('#load').on('click',function(){
 		   			BusquedaGrilla(oTable);
		});

     
		$('#loadDoc').on('click',function(){
 
            openFile('../../upload/uploadDoc',650,370);
 
		});
 
		$('#excelload').on('click',function(){
 
			exportar_excel('../../reportes/excel_personal');

 		});
 
  
		
		$('#loadContrato').on('click',function(){
 			
			  var str = $('#regimen').val();
  			  var res = str.substring(0, 8);
 
  			  if ( res == 'CONTRATO'){
  				$('#myModalContrato').modal('show');
  				
  			   var programa = $('#programa').val();
  			   var regimen = $('#regimen').val();
  			   var id_departamento = $('#id_departamento').val();
  			   var id_cargo = $('#id_cargo').val();
  			   var sueldo = $('#sueldo').val();
  			   var fecha = fecha_hoy();
    			   
  			    $('#novedad_c').val('');
  				$('#fecha_rige').val(fecha);
  				$('#p_regimen').val(regimen);
  				$('#p_programa').val(programa);
  				$('#p_id_departamento').val(id_departamento);
  				$('#p_id_cargo').val(id_cargo);
  				$('#p_sueldo').val(sueldo);
    					
  			  }
 

		});

		$('#loadTeletrabajo').on('click',function(){
 			
		 	 var str = $('#regimen').val();
			

			  $('#myModalTrabajo').modal('show');

			 
 

			   var fecha = fecha_hoy();

			   var nombre =  $('#razon').val();

			   $('#fun_tele').val(nombre);

			   
			 
			    $('#fecha_tele').val(fecha);

				$('#refe_tele').val('');

				$('#motivo_tele').val('');

				$('#estado_tele').val('');
		 
			   


	  });

	  $.ajax({
		url: "../model/ajax_respon_lista.php",
	   type: "GET",
	   success: function(response)
	   {
		   $('#idprov_jefe').html(response);
	   }
});


		
 
		$("#FormPie").load('../view/View-pie.php');
		$("#MHeader").load('../view/View-HeaderModel.php');

});  
//----------------
function valida()
{
	var objetos = [ "#nombre", "#apellido", "#idprov","#carrera","#direccion","#recorrido","#cta_banco"];
  
	var longitud = objetos.length;
	
	var nombre = '';
	var objeto = '';
	var valor  = '';
	var lon ;
	var valida = 0;
	var cadena = "";
	
	for (i = 0; i < longitud; i++) {
		
		nombre  = objetos[i];
		objeto  = $(nombre).val();
		valor   = new String(objeto);
		lon 	= valor.length;
		 
		 
		if (valor == 'null' ){
			cadena = cadena + nombre + ' <br>';
			valida = 1;
		}else{
			if ( lon < 2 ) {
				cadena = cadena + nombre + ' <br>';
				valida = 1;
			} 
		}
  
 }
	
	if ( valida == 1 ){
		 cadena = '<b>Advertencia campos obligatorios: <br>' + cadena + '</b>';
		 $('#result').html(cadena);
	}
	
}
//----------
function imagenfoto(urlimagen)
{
  
	 $("#ImagenUsuario").attr("src",urlimagen);
 

}
//---------------
function openFile(url,ancho,alto) {
    
	  var idprov = $('#idprov').val();
		 
 	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+idprov  ;
	 
	  if ( idprov) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
//-------------------------
function imprimir_informe(url) {
    
	var idprov = $('#idprov').val();
	   
	var ancho = 800;
	var alto  = 650;
	var posicion_x; 
	var posicion_y; 
	var enlace; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
   
	enlace = url+'id='+idprov  ;
   
	if ( idprov) {
			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }
}
//---------------
function exportar_excel(url)

{
	 window.open(url,'_blank');

}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 				 
 					$("#action").val("add");
 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
 
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
function goToURL(accion,id) {

	var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };

	var bandera = 0;	

 	
	 	   if ( accion == 'del'){
 				alertify.confirm("<p>DESEA ELIMINAR FUNCIONARIO? </p>", function (e) {
 					if (e) {
 						 bandera = 1;	
 					}
				}); 
			}

			if ( accion == 'editar'){
				bandera = 1;	
			}	


			if ( bandera == 1 ) {

				  $.ajax({
								data:  parametros,
								url:   '../model/Model-nom_ingreso.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#result").html('Procesando');
			  					},
								success:  function (data) {
												if ( accion == 'del'){
														alert(data);
												} else	{
														$("#result").html(data);   
														Ver_doc_prov(id) ;

														VerTele();
												}
 			  				
				 				}	
				}); 	
			} 	 
 }

//-------------------------------------------------------------------------
function LimpiarPantalla() {
  
	$("#idprov").val("");
	$("#razon").val("");
	$("#direccion").val("");
	$("#telefono").val("");

	$("#correo").val("");
	$("#movil").val("");
	$("#idciudad").val("");
	$("#nombre").val("");
	$("#apellido").val("");

	$("#id_departamento").val("");
	$("#id_cargo").val("");
	$("#responsable").val("");
	$("#regimen").val("");
	$("#fecha").val("");

	$("#contrato").val("");
	$("#sueldo").val("");
	$("#unidad").val("");
	$("#cargo").val("");
	$("#grafico").val("");
	$("#fechan").val("");

	$("#nacionalidad").val("");
	$("#etnia").val("");
	$("#ecivil").val("");
	$("#vivecon").val("");
	$("#tsangre").val("");
	$("#cargas").val("");
	$("#genero").val("");

    }
//---------------------------
function fecha_hoy()
{

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();

    if(dd < 10){
        dd='0'+ dd;
    } 

    if(mm < 10){
        mm='0'+ mm;
    } 

  
    var today = yyyy + '-' + mm + '-' + dd;
   
 return today;
 
} 
//------------------------------------------------------------------------- 
 function BusquedaGrilla(oTable){        	 

  		var user     = $(this).attr('id');
     	var qestado  = $("#qestado").val();
     	var qunidad  = $("#qunidad").val();
     	var qregimen = $("#qregimen").val();

     
       var parametros = {
				'qestado' : qestado  ,
				'qunidad' : qunidad,
				'qregimen' : qregimen

      };

 
		if(user != '')  { 

		$.ajax({
 		 	data:  parametros,
		    url: '../grilla/grilla_nom_ingreso.php',
			dataType: 'json',
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
                           	'<button class="btn btn-xs btn-warning" title="EDITAR REGISTRO SELECCIONADO"   onClick="goToURL('+"'editar'"+','+"'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
 							'<button class="btn btn-xs btn-danger" title="ELIMINAR REGISTRO SELECCIONADO"  onClick="goToURL('+"'del'"+','+ "'"+ s[i][0]+"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
 						]);										
 					}  
 			    }						
 			},
 			error: function(e){
 			   console.log(e.responseText);	
 			}
 			});
 		}

  }   
//-----------------
function accion(id, action)
  {
  	$('#action').val(action);
  	Ver_doc_prov(id) ;
} 
//--------------------------------------
function PoneDoc(file)
  {
       
	var directorio = _directorio('62',1);
  
    var url = directorio + file;

	var parent = $('#DocVisor').parent(); 
	
	$('#DocVisor').remove(); 
	
	var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 

	parent.append(newElement); 

	$('#DocVisor').attr('src',url); 

   	
    	
  }
 
/*
*/
 function modulo()
{
 	  
	 var parametros = {

			    'ViewModulo' : modulo_sistema

    };

 
	$.ajax({
			data:  parametros,
			url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ViewModulo").html(data);  
				} 
	});
 
}
/*
*/

function proceso_doc(accion, codigo)
{


 
var	idprov       =  $('#idprov').val();
 
 	  
	 var parametros = {

			    'accion' : accion,
				'codigo':codigo,
				'idprov':idprov

    };

 

	alertify.confirm("<p>DESEA PROCESAR LA TRANSACCION ?</p>", function (e) {

		if (e) {
			
			$.ajax({
				data:  parametros,
				url:   '../model/ajax_tele_registro.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#resultado_dato").html(data);  

						 VerTele();
					} 
		});

		}

	   }); 
 
}
/*
*/

function GenerarTele()
{


var fecha_tele   =	$('#fecha_tele').val();
var refe_tele    =	$('#refe_tele').val();
var motivo_tele  =	$('#motivo_tele').val();
var	estado_tele  =  $('#estado_tele').val();
var	idprov       =  $('#idprov').val();
var	idprov_jefe       =  $('#idprov_jefe').val();

 	  
	 var parametros = {

			    'accion' : 'add',
				'fecha_tele' : fecha_tele,
				'refe_tele' : refe_tele,
				'motivo_tele' : motivo_tele,
				'estado_tele' : estado_tele,
				'idprov_jefe':idprov_jefe,
				'idprov':idprov

    };

 

	alertify.confirm("<p>DESEA GENERAR ACTIVIDADES PARA TELETRABAJO?</p>", function (e) {

		if (e) {
			
			$.ajax({
				data:  parametros,
				url:   '../model/ajax_tele_registro.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#resultado_dato").html(data);  

						 VerTele();
					} 
		});

		}

	   }); 
 
}
/*
*/
function VerTele()
{

 
var	idprov       =  $('#idprov').val();

 	  
	 var parametros = {

			    'accion' : 'visor',
				'idprov':idprov

    };

  	
			$.ajax({
				data:  parametros,
				url:   '../model/ajax_tele_registro.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ListaFormtele").html(data);  
					} 
		});

	 
 
}
/*
*/
 function FormView()
 {

	 $("#ViewForm").load('../controller/Controller-nom_ingreso.php');

	 $("#ViewFormContrato").load('../controller/Controller-nom_contrato.php');
 
}
//------------ 
 function GenerarHistorial()
 {
	 
	 
	 var nombre =   $('#apellido').val() + ' ' + $('#nombre').val()  ;

	  alertify.confirm("Desea Generar la transaccion de: " + nombre, function (e) {

		  if (e) {
 			  
			  var parametrosd = {
						'idprov' : $('#idprov').val()  
				};
  			  
 			 var parametros = {
  					  'idprov'  : $('#idprov').val(),
 			 		  'novedad' : $('#novedad_c').val(),
			          'motivo'  : $('#motivo_c').val(),
					  'programa'  : $('#programa').val(),
			   		  'regimen'   : $('#regimen').val(),
				      'id_departamento'  : $('#id_departamento').val(),
				      'id_cargo'  : $('#id_cargo').val(),
				      'sueldo'    : $('#sueldo').val(),
				      'fecha'     : $('#fecha').val(),
		 			  'fecha_rige'  : $('#fecha_rige').val(),
					  'p_regimen'   : $('#p_regimen').val(),
					  'p_programa'  : $('#p_programa').val(),
					  'p_id_departamento'  : $('#p_id_departamento').val(),
					  'p_id_cargo'         : $('#p_id_cargo').val(),
					  'p_sueldo'           : $('#p_sueldo').val()
 			 };

	 	    $.ajax({
 	 					data:  parametros,
	  					url:   '../model/Model-nom_contrato.php',
	  					type:  'POST' ,
	  					success:  function (data) {
	  							alert(data);
	  							 //-----------------------------------------
	  							$.ajax({
	  								data:  parametrosd,
	  								url:   '../model/Model-nom_rol_ac.php',
	  								type:  'GET' ,
	  								success:  function (data) {
	  										 $("#ListaFormContrato").html(data);  
	  				 				} 
	  				 		   }); 
	  						   //-----------------------------------------	
 	   					} 
	
	 			}); 
  		
		  }

		 }); 
	 
}
///----------------cedula
function validarCiu() {

     
	 var action 	= $('#action').val();
 	 var cad 		= document.getElementById("idprov").value.trim();
 	 var tpidprov 	= document.getElementById("tpidprov").value.trim();

	 var total = 0;
     var longitud = cad.length;
     var longcheck = longitud - 1;

    
    if ( action == 'add'){
 			     if (tpidprov == '02'){
			 
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
			
			 			    	   document.getElementById("idprov").value = '';
			
						       }else{
			
						    	   valida_identificacionExiste(cad,tpidprov);
			
						       }
			
					          }else{
			
					        	  document.getElementById("idprov").value = '';
			
					           }
			              }
					      //-----------------------------------
					      if (tpidprov == '01'){
					
					    	 validarRUC();
					
					     }
    		}
     

   }

 //---------------------------------------------------------

 function valida_identificacionExiste(cedula,tipo) {

	 
     var parametros = {
 					'cedula' : cedula ,
                     'tipo' : tipo 
  	  };

	  $.ajax({

					data:  parametros,
 					url:   '../model/Model-cedula.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#idprov").val(data);  
 						     

  					} 

			}); 
 

    }

 //--------------------------------------

 function validarRUC(){

	 

	  var number = document.getElementById('idprov').value;

	  var dto = number.length;

	  var valor;

	  var acu=0;

	 

 

	   for (var i=0; i<dto; i++){

	   valor = number.substring(i,i+1);

		   if(valor==0||valor==1||valor==2||valor==3||valor==4||valor==5||valor==6||valor==7||valor==8||valor==9){

		    acu = acu+1;

		   }

	   }

	   if(acu==dto){

	    while(number.substring(10,13)!=001){

	    	//    alert('Los tres últimos dígitos no tienen el código del RUC 001.');

	     document.getElementById("idprov").value = 'NO_VALIDO';

	     return;

	    }

	    while(number.substring(0,2)>24){    

	     document.getElementById("idprov").value = 'NO_VALIDO';

	     return;

	    }

  

	    var porcion1 = number.substring(2,3);

	   }

	   else{

		   document.getElementById("idprov").value = 'NO_VALIDO';

	   }

 

	 }
//----------------
function Ver_doc_prov(idprov) {

	 
     var parametros = {
 					'idprov' : idprov  
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-nom_rol_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
 
  					} 

			}); 
 
	  //-----------------------ListaFormContrato
	  var parametrosd = {
					'idprov' : idprov  
	  };
	    
	  $.ajax({
			data:  parametrosd,
			url:   '../model/Model-nom_rol_ac.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ListaFormContrato").html(data);  // $("#cuenta").html(response);

			} 

	}); 
	  
}


//-----------------------  
function goToURLDocdel(idcodigo,idprov) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'prov'   : idprov  
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-nom_rol_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
  
