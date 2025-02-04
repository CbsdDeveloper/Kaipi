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

 

var oTable;
var oTableFactura;
var oTableItems;



var formulario = 'inv_importaciones';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
         oTable			 = $('#jsontable').dataTable(); 
         
         oTableFactura  = $('#jsontable_factura').dataTable(); 
          
         oTableItems  = $('#jsontable_items').dataTable(); 
         
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
   		    
 
 		
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
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
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



function nueva_factura( ) {
	
	  var id_importacion = $("#id_importacion").val();
		
	  if (id_importacion ) {
		  
		  alertify.confirm("Crear Nueva Factura", function (e) {
			  if (e) {
				 
				    LimpiarPantallaFactura();
	                
					$("#action_factura").val("add");
					
					$("#resultFactura").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
			  }
			 }); 
	  }else     {
		  alert('Seleccione el codigo de importacion');
	  }
	  
}

//------------------

function nueva_items( ) {
	
	// id_importacionfacitem
	
 
	
   var id_importacionfac = $("#id_importacionfac_key").val();
		
	var id_importacion = $("#id_importacion_item").val();
	
 
	
	  if (id_importacionfac ) {
		  
		  alertify.confirm("Crear nuevo Item", function (e) {
			  if (e) {
				 
				    LimpiarPantallaItems();
	                
					$("#action_items").val("add");
					
					$("#resultItems").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
			  }
			 }); 
	  }else     {
		  alert('Seleccione el codigo de importacion');
	  }
	  
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
						     
							 $("#id_importacion_key").val(id);

							 BusquedaGrillaFactura(oTableFactura);	
  					} 
			}); 

    }
//-------------------------------------------------------------------------
//ir a la opcion de editar
function goToURLFac(accion,id) {

	var parametros = {
					'accion' : accion ,
                   'id' : id 
	  };
	

	
	 $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_importaciones_factura.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#resultFactura").html('Procesando');
					},
					success:  function (data) {
							 $("#resultFactura").html(data);  // $("#cuenta").html(response);
						     
								$('#myModal').modal('show');
 					} 
			}); 
		 
} 
//ir a la opcion de editar
function goToURLItem(accion,id) {

	var parametros = {
					'accion' : accion ,
                   'id' : id 
	  };
	

	
	 $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_importaciones_Items.php' ,
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#resultItems").html('Procesando');
					},
					success:  function (data) {
							     $("#resultItems").html(data);  // $("#cuenta").html(response);
						     
								$('#myModalItems').modal('show');
 					} 
			}); 
		 
} 


///------
function goToURLDet( id) {

 
	
	var id_importacion = $("#id_importacion").val();
	
	$("#id_importacion_item").val(id_importacion);
	
	$("#id_importacionfac_key").val(id);
	
	BusquedaGrillaItems(oTableItems);

	$('#mytabs a[href="#tab4"]').tab('show');
} 
///------goToURLDet 
function goToURLInv( id) {

	
	var cierre 		   = $("#cierre").val();
	var id_importacion = $("#id_importacion").val();
	var idbodega1 		= $("#idbodega1").val();
	
	 	 
	 if (cierre == 'S') {
		
		 var parametros = {
			'id_importacion' : id_importacion,
			'idbodega1' : idbodega1,
			'id' : id 
		 	};
		 
		 $.ajax({
			data:  parametros,
			url:   '../model/Model-inv_importacion_bodega.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#ImportaGuarda").html('Procesando');
			},
			success:  function (data) {
					 $("#ImportaGuarda").html(data);  // $("#cuenta").html(response);
				     
					 alert('Movimiento Ingresado');
			} 
		 }); 
	
		 
		 
	 }
	 
 
	
 
} 
 //---------------------------------------
function ElectronicoTool( ) {

	
	
	var estado =  $("#estado").val();
	 
	 
	 if (estado) {
		 alert('guia electronica');
	 }
		 
		 
		 
	/*var parametros = {
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
*/
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
   
	var fecha = fecha_hoy();
	$("#action").val("add");
	
	$("#id_importacion").val("");
	$("#fecha").val(fecha);
 	$("#dai").val("");
	$("#distrito").val("(055) QUITO");
	$("#regimen").val("(10) IMPORTACION A CONSUMO");
	$("#tipodespacho").val("DESPACHO NORMAL");
	$("#tipopago").val("PAGO NORMAL");
	$("#nrodespacho").val("");
	$("#fechaaceptacion").val(fecha);
	$("#codigodeclarante").val("");
	$("#identificaciondeclarante").val("");
	$("#nombredeclarante").val("");
	$("#direcciondeclarante").val("");
	$("#paisprocede").val("United States");
	$("#codigoendoso").val("(00) SIN ENDOSE - DOC DE");
	$("#doctrasporte").val("");
	$("#nrocarga").val("");
	
 	//$("#cierre").val("");
	
	$("#fob").val("0.00");
	$("#flete").val("0.00");
	$("#seguro").val("0.00");
	$("#aduana").val("0.00");
	$("#items").val("0.00");
	$("#peso").val("0.00");
	$("#unidadfisica").val("0.00");
	$("#tributo").val("0.00");
	$("#unidadcomercial").val("0.00");
 
		
    }
 //---------
function LimpiarPantallaFactura() {
	   
	var fecha 		   = fecha_hoy();
	var id_importacion = $("#id_importacion").val();
	
	
	$("#action_factura").val("add");
	
	$("#id_importacionfac").val("");
	$("#id_importacion_key").val(id_importacion);
	
	$("#fechafactura").val(fecha);
 	$("#factura").val("");
	$("#nombre_factura").val("");
	$("#naturaleza").val("(11) COMPRA/VENTA A PRECIO FIRME PARA SU EXP AL PAIS");
	$("#iconterm").val("(FOB Franco a Bordo)");
	$("#valor").val("0.00");
 
		
    }
function LimpiarPantallaItems() {
	   
	var fecha 		   = fecha_hoy();
	var id_importacion = $("#id_importacion").val();
 	
	$("#action_items").val("add");
	
	$("#id_importacion_item").val(id_importacion);
  
	$("#id_importacionfacitem").val("");
 
	
	$("#idproducto").val("");
	$("#partida").val("");
	$("#cantidad").val("1");
	$("#costo").val("0.00");
	$("#peso").val("0.00");
	$("#advalorem").val("0.00");
	$("#infa").val("0.00");
	$("#iva").val("0.00");
	$("#salvaguardia").val("0.00");
	$("#aranceles").val("0.00");
	
		
    }


 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	$("#id_importacion").val(id);
 
	//   BusquedaGrilla(oTable);

}
//-------------------------
function accion_factura(id,modo,estado)
{
 
	 
	$("#action_factura").val(modo);
	
	$("#id_importacionfacitem").val(id);
 
	BusquedaGrillaFactura(oTableFactura);

}

//---------------
function accion_item(id,modo,estado)
{
 
	 
	$("#action_items").val(modo);
	
	$("#id_importacionfacitem").val(id);
	
	BusquedaGrillaItems(oTableItems)
 
 
	


}
//--------------
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

   	var festado = $("#festado").val();
   	
 	var ffecha1 = $("#ffecha1").val();
 	
	var ffecha2 = $("#ffecha2").val();
 
	 
    var parametros = {
				'festado' : festado,  
				'ffecha1' : ffecha1,
				'ffecha2': ffecha2
    };
 
   
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
			 console.log(s); 
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
						s[i][7],
						s[i][8],
	  					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ "'"+ s[i][0]+"'"  +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ "'"+  s[i][0] +"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
				]);										
			} // End For
			} 						
		 } 
	 	});
 
 
 }   
//--------------
//------------------------------------------------------------------------- 
  function BusquedaGrillaFactura(oTableFactura){        	 

		var id_importacion = $("#id_importacion").val();
	 
		 
	    var parametros = {
					'id_importacion' : id_importacion 
	    };
 
			$.ajax({
			 	data:  parametros,
	 		    url: '../grilla/grilla_inv_importaciones_fac.php' ,
				dataType: 'json',
				cache: false,
				success: function(s){
				console.log(s); 
				oTableFactura.fnClearTable();
				if(s ){ 
				for(var i = 0; i < s.length; i++) {
					oTableFactura.fnAddData([
						    s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
							s[i][4],
							s[i][5],
							s[i][6],
 		  					'<button class="btn btn-xs" onClick="javascript:goToURLFac('+"'editar'"+','+ "'"+ s[i][7]+"'"  +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURLFac('+"'del'"+','+ "'"+  s[i][7] +"'" +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;' +
							'<button class="btn btn-xs" title="Items por factura" onClick="javascript:goToURLDet('+ s[i][7]  +')"><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;&nbsp;&nbsp;' +
							'<button class="btn btn-xs" title="Crear Ingreso a Bodega" onClick="javascript:goToURLInv('+ s[i][7]  +')"><i class="glyphicon glyphicon-globe"></i></button>&nbsp;'  

							]);										
				} // End For
				} 						
			 } 
		 	});
	 
	 
	 } 
 //----------
  //------------------------------------------------------------------------- 
  function BusquedaGrillaItems(oTableItems){        	 

	 		
   	var id_importacionfac_key = $("#id_importacionfac_key").val();
   	
   	 
    var parametros = {
				'id_importacionfac_key' : id_importacionfac_key 
    };
 
   
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_inv_importaciones_items.php'  ,
			dataType: 'json',
			cache: false,
			success: function(s){
			 console.log(s); 
			 oTableItems.fnClearTable();
			if(s ){ 
			for(var i = 0; i < s.length; i++) {
				oTableItems.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
						s[i][3],
						s[i][4],
						s[i][5],
						s[i][6],
						s[i][7],
						s[i][8],
	  					'<button class="btn btn-xs" onClick="javascript:goToURLItem('+"'editar'"+','+ "'"+ s[i][9]+"'"  +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
						'<button class="btn btn-xs" onClick="javascript:goToURLItem('+"'del'"+','+ "'"+  s[i][9] +"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
				]);										
			} // End For
			} 						
		 } 
	 	});
 
 
 }   
 //------------------------------------------------------------------------------------------------------
 function modulo()
 {
 	 var modulo =  'kinventario';
 	 
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
      
	 $("#ViewFactura").load('../controller/Controller-inv_importaciones_factura.php' );

	 $("#ViewFacturaItems").load('../controller/Controller-inv_importaciones_items.php' );
	 
	 $("#FiltroBodega").load('../controller/Controller-FiltroBodega.php' );
	 
 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');
	 

 }

//-------------------------------

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
 //---------------------------------------------------------
 function PoneDato( ) {
	 
	
	
	 
	var factura =  $("#factura").val();
	 
	 	 
	 if (factura) {
		 
		 alert('Busca Factura ' + factura);
		 
		     var parametros = {
							'factura' : factura  
		 	  };
		     
			  $.ajax({
							data:  parametros,
							url:   '../model/Model-guia_factura.php',
							type:  'GET' ,
		 					success:  function (data) {
									 $("#det_factura").html(data);  // $("#cuenta").html(response);
								     
		  					} 
					}); 
		
		    }
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
  