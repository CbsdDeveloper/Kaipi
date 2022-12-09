var oTable;

var formulario = 'ren_arriendo';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
         oTable = $('#jsontable').dataTable(); 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
   		    
	    BusquedaGrilla( oTable);
 		
	 	   $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
			});
	 
  
 	    //-----------------------------------------------------------------
  
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {

	  var resultado = Mensaje( accion ) ;
	   
		var parametros = {
						'accion' : accion ,
	                    'id' : id 
	 	  };
		
	 	
		$.ajax({
			  url:   '../model/Model-'+ formulario,
			  type:  'GET' ,
			  data:  parametros,
			  dataType: 'json',  
				}).done(function(respuesta){
						
					$("#idren_local").val (respuesta.idren_local);
	 			 
					$("#fecha").val (respuesta.fecha);

					$("#id_par_ciu").val(respuesta.id_par_ciu);
					$("#idprov").val(respuesta.idprov);
					$("#servicio").val(respuesta.servicio);
					$("#tipo").val(respuesta.tipo);
					$("#contrato").val(respuesta.contrato);
 					$("#fecha_inicio").val(respuesta.fecha_inicio);
					$("#fecha_fin").val(respuesta.fecha_fin);
					$("#novedad").val(respuesta.novedad);
					$("#factura").val(respuesta.factura);
					$("#finalizado").val(respuesta.finalizado);
					$("#periodo").val(respuesta.periodo);
					 
					$("#ubicacion").val(respuesta.ubicacion);
					$("#numero").val(respuesta.numero);
					$("#razon").val(respuesta.razon);
					
					$("#arriendo").val(respuesta.arriendo);
					

 			 
					
						 						
					$("#action").val(accion); 
				 	$("#result").html(resultado);
 	 
				 	ListaAux( respuesta.idprov );
				 	
				 	VerFacturacion_proceso(respuesta.idren_local);
				 	
				  
					 
				 
				 	
				});
	 
			
		 
		
	 	$('#mytabs a[href="#tab2"]').tab('show');

    }
 

function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	$("#action").val("add");
	
	var fecha = fecha_hoy();
	
	$("#idren_local").val("");
	$("#id_par_ciu").val("");
	$("#idprov").val("");
	$("#servicio").val("");
	$("#tipo").val("");
	$("#contrato").val("");
	
 	$("#fecha").val(fecha);
	$("#fecha_inicio").val("");
	$("#fecha_fin").val("");
	$("#novedad").val("");
	$("#factura").val("");
	$("#finalizado").val("");
	$("#periodo").val("");
    }
   
 
 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	//$("#idprov").val(id);
 
	   BusquedaGrilla(oTable);

 
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
    
 
    return today;
 
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

 
	  
   	var ftipo = $("#ftipo").val();
   	
 	var ffinalizado = $("#ffinalizado").val();
 	
 
    
    var parametros = {
				'ftipo' : ftipo,  
				'ffinalizado' : ffinalizado 
    };
    
   
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		 	console.log(s); 
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
							'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+"'" +s[i][8] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+',' +"'" + s[i][8] +"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			  } 					
			} 
	 	});
 
 
		
  }   
//--------------
  function myFunction(codigo,objeto)

  {

  	   var accion 		  =  'check';
 	   var estado 		  =  '';
  
 	    if (objeto.checked == true){
  	    	estado = 'S'
  	    } else {
  	    	estado = 'N'
  	    }

 	    

 	    var parametros = {
 		          'codigo' : codigo ,
                  'estado':estado ,
                  'bandera': 'S',
                  'accion' : 'datos'

 	  };

 	    
 		      $.ajax({
  						data:  parametros,

 						url:   '../model/ajax_a_seleccion_abono.php',

 						type:  'GET' ,

 						cache: false,

 						beforeSend: function () { 

 									$("#ViewSeleccionPago").html('Procesando');

 							},

 						success:  function (data) {

 								 $("#ViewSeleccionPago").html(data);   

 							     

 							} 

 				}); 
 }
   //------------------------------------------------------------------------- 
 
  function PoneSeleccion()

  {

  	   
 	       
  var idprov	=  $("#idprov").val();
  	 
  $("#idprov_abono").val(idprov);
  
  	 
 	    var parametros = {
 		          'codigo' : idprov ,
                   'accion' : 'saldos'

 	  };

 	    
 		      $.ajax({
  						data:  parametros,

 						url:   '../model/ajax_a_seleccion_abono.php',

 						type:  'GET' ,

 						cache: false,

 						beforeSend: function () { 

 									$("#ViewFiltroIngreso").html('Procesando');

 							},

 						success:  function (data) {

 								 $("#ViewFiltroIngreso").html(data);   

 							     

 							} 

 				}); 
 		      
 			  $('#guardarIngreso').html('');
 }
 //-------------------------------------------------
  function actualiza_datod(  id )
  {
	  
	 var objeto1 					 =  'base_' + id;
	 var objeto2 					 =  'iva_' + id;
	 var objeto3 					 =  'base0_' + id;
	 var objeto4 					 =  'interes_' + id;
	 var objeto5 					 =  'total_' + id;
	  
 
	
	  var base	=       document.getElementById(objeto1).value;
	  var iva	=       document.getElementById(objeto2).value;
	  var base0	=       document.getElementById(objeto3).value;
	  var interes	=   document.getElementById(objeto4).value;
 	  
	  var  IVA			= 12/100; 
	  var  monto_iva = 0;
	  var  total_iva = 0;
	  var  total_monto = 0;
	  var  total_imprime = 0;
	  

 
	  var CalcularBase1 = parseFloat(base);  
	  var CalcularBase2 = parseFloat(iva);  
	  var CalcularBase3 = parseFloat(base0);  
	  var CalcularBase4 = parseFloat(interes);  
	  
	  if ( CalcularBase1 == 0 )  {
		  
		  $(objeto2).val('0');
		  
	  }else {
		  monto_iva = CalcularBase1 * IVA;
		  total_iva = parseFloat(monto_iva);  
		  document.getElementById(objeto2).value = total_iva.toFixed(2);
	  }
	  
	  total_monto = CalcularBase1+ total_iva+ CalcularBase3+ CalcularBase4;
	  
	  total_imprime = parseFloat(total_monto);  
	  
	  document.getElementById(objeto5).value = total_imprime;
	  
	  
	  total_factura_abono();
	  
  }
 //----------totalIngresoabono
  function total_factura_abono(){
		
	    var formulario = document.getElementById("foxx");
		var layFormulario            = formulario.elements;
		var lnuElementos             = layFormulario.length;
				
 	    var Calculartotal             	 = 0;
	 			 	
	        for( var xE = 0; xE < lnuElementos; xE++ ){		 
	        					var lobCampo            = layFormulario[ xE ];
	        					var lstNombre           = lobCampo.name;
	                    		var lnuCampo            = lobCampo.value;
	        					
	        					var layDatosNombre         = lstNombre.split( '_' );
	        					var lstCampo               = layDatosNombre[0];
	        					    lnuCampo               = parseFloat (lnuCampo); 
	        						
	        					if (lstCampo == 'total'){
	        						Calculartotal =  Calculartotal + lnuCampo;
	                             }
	               				 
	       } 
	         
	       // total
	        Calculartotal = parseFloat(Calculartotal);  
	        
	  	   $('#totalIngresoabono').html('TOTAL ABONO <b>'+ Calculartotal + '</b>'); 
	  	   
 
	 
	  return true;
	}
 //--------------------------------------------------------------------------------- 
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
      
	  
 //	 $("#ViewFormGestion").load('../controller/Controller-'+formulario+'_gestion.php');
	 
	 
	 
 }
 function openView(url){        
		
	 
	   
	    var posicion_x; 
	    var posicion_y; 
	    var enlace = url  
	    var ancho = 1000;
	    var alto = 420;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	 
	 }
//---------------------------------------- 
 function openfac( ){      
	 
	 
 
	    var id= $("#idfacturas").val();
	    var posicion_x; 
	    var posicion_y; 
	    var enlace = '../view/ven_facturaId.php?id='  + id +'&accion=editar'; 
	    var ancho = 1200;
	    var alto = 540;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	     
 }
//---------------------------------------- 
 function openfacDetalle( id ){      
	 
 
	    var posicion_x; 
	    var posicion_y; 
	    var enlace = '../view/ven_facturaId.php?id='  + id +'&accion=editar'; 
	    var ancho = 1200;
	    var alto = 540;
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
	     
 }
//------------------------ 
 function openfac_nuevo(tipo ){      
	 
	 
	 // carriendo cluz cagua fecha_emite cdetalle
	 
	    var idprov      = $("#idprov").val();
	    var idren_local = $("#idren_local").val();
	 
	    var carriendo      = $("#carriendo").val();
	    var cluz 		   = $("#cluz").val();
	    var cagua          = $("#cagua").val();
	    var fecha_emite    = $("#fecha_emite").val();
	    var cdetalle 	   = $("#cdetalle").val();
	    
	    
	    var parametros = {
		   		  'idprov': idprov ,
			      'idren_local': idren_local ,
			      'carriendo': carriendo ,
			      'cluz': cluz ,
			      'cagua': cagua ,
			      'fecha_emite': fecha_emite ,
			      'cdetalle': cdetalle ,
			      'tipo' : tipo
	    	};
 

	    alertify.confirm("Desea generar el comprobante " + idprov, function (e) {
		  if (e) {
			 
			  $.ajax({
		 			data:  parametros,
		 			url:   '../model/Model-ven_fac_arriendo.php',
		 			type:  'GET' ,
		 		    success:  function (data) {
		 				 $("#anulado_fac").html(data);   
		 				 alert('Informacion generada...');
		 			} 
		 
		 	});	 
				 
		  }
		 }); 

	     
}
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');
	 

 }
//----------------
function validarCiu() {
     
	 
	 var cad = document.getElementById("idprov").value.trim();
	 
	 var tpidprov = document.getElementById("tpidprov").value.trim();
	 
      
     var total = 0;
     var longitud = cad.length;
     var longcheck = longitud - 1;
 

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
 			    	
 			    	   document.getElementById("idprov").value = 'NO_VALIDO';
		 
			       }else{
			    	   valida_identificacionExiste(cad,tpidprov);
			       }
		     }else{
		    	 document.getElementById("idprov").value = 'NO_VALIDO';
		     }
		    	 
       }
     //-----------------------------------
     if (tpidprov == '01'){
    	 validarRUC();
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
							 $("#idprov").val(data);  // $("#cuenta").html(response);
						     
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
	     //alert('Los dos primeros dígitos no pueden ser mayores a 24.');
	     document.getElementById("idprov").value = 'NO_VALIDO';
	     return;
	    }
  
	    var porcion1 = number.substring(2,3);
	  /*  if(porcion1<6){
	     alert('El tercer dígito es menor a 6, por lo \ntanto el usuario es una persona natural.\n');
	    }
	    else{
	     if(porcion1==6){
	      alert('El tercer dígito es igual a 6, por lo \ntanto el usuario es una entidad pública.\n');
	     }
	     else{
	      if(porcion1==9){
	       alert('El tercer dígito es igual a 9, por lo \ntanto el usuario es una sociedad privada.\n');
	      }
	     }
	    }*/
	   }
	   else{
		   document.getElementById("idprov").value = 'NO_VALIDO';
	   }
 
	 }
 //--------------------------
//-------------------
 function ListaAux( vprod)
 {
 	  
   var parametros = {
  			    'idprov': vprod
   };
   
    
 	 
 	 
 		$.ajax({
 			data:  parametros,
 			url:   '../model/Model_listaAux.php',
 			type:  'GET' ,
 			beforeSend: function () { 
 					$("#ViewFormAux").html('Procesando');
 			},
 		success:  function (data) {
 				 $("#ViewFormAux").html(data);   
 			     
 			} 
 
 	});	 
 
 } 	
//---------------------
 function ListaAuxvisor(  )
 {
 	  
	 
  var idprov =	$("#idprov").val();
	 
	 
   var parametros = {
  			    'idprov': idprov
   };
   
    
 	 
 	 
 		$.ajax({
 			data:  parametros,
 			url:   '../model/Model_listaAux.php',
 			type:  'GET' ,
 			beforeSend: function () { 
 					$("#ViewFormAux").html('Procesando');
 			},
 		success:  function (data) {
 				 $("#ViewFormAux").html(data);   
 			     
 			} 
 
 	});	 
 		
 		  $('#guardarIngreso').html('');
 
 }
//-------------------------------- 
 function ListaAuxServicios( vprod)
 {
 	  
   var parametros = {
  			    'idprov': vprod
   };
   
 
 		$.ajax({
 			data:  parametros,
 			url:   '../model/Model_listaAuxServicios.php',
 			type:  'GET' ,
 			beforeSend: function () { 
 					$("#ViewDetalleCliente").html('Procesando');
 			},
 		success:  function (data) {
 				 $("#ViewDetalleCliente").html(data);   
 			     
 			} 
 
 	});	 
 
 } 
//------  
 function GuardaContrato(  )
 {
 	  
  var idprov =  $("#idprov").val();
		
  var servicio		=  $("#servicio").val();
  var contrato		=  $("#contrato").val();
  var fecha_inicio	=  $("#fecha_inicio").val();
  var novedad		=  $("#novedad").val();
  var periodo		=  $("#periodo").val();
  var factura		=  $("#factura").val();
  var finalizado	=  $("#finalizado").val();
  
  
   var parametros = {
		   		  'accion': 'actualiza' ,
  			      'idprov': idprov ,
	  			  'servicio': servicio ,
	  			  'contrato': contrato ,
	  			  'fecha_inicio': fecha_inicio ,
	  			  'novedad': novedad ,
	  			  'periodo': periodo ,
	  			  'factura': factura ,
	  			  'finalizado': finalizado 
   };
   
 
 		$.ajax({
 			data:  parametros,
 			url:   '../model/Model_listaAuxServiciosAdd.php',
 			type:  'GET' ,
 			beforeSend: function () { 
 					$("#ViewGuardaCliente").html('Procesando');
 			},
 		    success:  function (data) {
 				 $("#ViewGuardaCliente").html(data);   
 				 
 				 alert(data) ;
 			     
 			} 
 
 	});	 
 
 } 
//-----------------------------------------------------
 function VerFacturacion_proceso(  idren_local )
 {
 	  
  var idprov =  $("#idprov").val();
 
  var url    =  '../controller/Controller-'+formulario+'_gestion.php';
 
  
   var parametros = {
		   		  'accion': 'editar' ,
		   		  'idren_local': idren_local,
  			      'idprov': idprov 
   };
   
 
 		$.ajax({
 			data:  parametros,
 			url:   url,
 			type:  'GET' ,
 		    success:  function (data) {
 				 $("#ViewFormGestion").html(data);   
 			} 
 
 	});	 
 
 } 
 
 //------------------------- 
 function VerFacturacion_anular(  )
 {
 	  
  var idprov        =  $("#idprov").val();
  var idfacturas    =  $("#idfacturas").val();
  var url    =  '../model/Model-ren_arriendo_canulo.php';  
  
  var parametros = {
		   		  'idfacturas': idfacturas ,
  			      'idprov': idprov 
   };
   
 
   alertify.confirm("Desea anular el comprobante " + idfacturas, function (e) {
		  if (e) {
			 
			  $.ajax({
		 			data:  parametros,
		 			url:   url,
		 			type:  'GET' ,
		 		    success:  function (data) {
		 				 $("#anulado_fac").html(data);   
		 			} 
		 
		 	});	 
				 
		  }
		 }); 
 
 
 } 
//-------------------
 function VerContrato(  )
 {
 	  
  var idprov =  $("#idprov").val();
		
   
   var parametros = {
		   		  'accion': 'visor' ,
  			      'idprov': idprov 
   };
   
 
 		$.ajax({
 			data:  parametros,
 			url:   '../model/Model_listaAuxServiciosAdd.php',
 			type:  'GET' ,
 			beforeSend: function () { 
 					$("#ViewGuardaCliente").html('Procesando');
 			},
 		    success:  function (data) {
 				 $("#ViewGuardaCliente").html(data);   
 				 
 				 
 			     
 			} 
 
 	});	 
 
 } 
 //----------------
 function GenerarRuc(  )
 {
	 
	 var idprov = $("#idprov").val(); 
			
		  alertify.confirm("<p>Desea actualizar cliente - proveedor <br><br></p>", function (e) {
		  if (e) {
			 
			  var parametros = {
		  			    'idprov': idprov
		   };
		   
		     		$.ajax({
		 			data:  parametros,
		 			url:   '../model/Model-cli_ingreso_prov.php',
		 			type:  'GET' ,
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
 
  