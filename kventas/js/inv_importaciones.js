$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


var oTable;

var formulario = 'inv_importaciones';

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
   
	$("#action").val("add");
	
	$("#cab_codigo").val("");
	$("#cab_autorizacion").val(" ");
	
	$("#estab").val("001");
	$("#ptoemi").val("001");
	
	var fecha = fecha_hoy();
	
		$("#secuencial").val(" "); 
		$("#identificacioncomprador").val(" "); 
		$("#razonsocialcomprador").val(" ");   
		
		$("#estado").val("digitado");   
	  
    	$("#guiaremision").val("-");
		$("#placa").val("AAA-0001");
		$("#marca").val("");
		$("#modelo").val("");
	  
		$("#ruta").val("QUITO-COCA");
		$("#color").val("");
		
		$("#fechaemision").val( fecha );
		$("#fechafintransporte").val( fecha);
		
		$("#identificaciondestinatario").val("");
		$("#razonsocialdestinatario").val("");
		$("#dirdestinatario").val("");
		
		$("#motivotraslado").val("");
		$("#numdocsustento").val("");
		$("#numautdocsustento").val("");
		$("#fechaemisiondocsustento").val("");
		$("#coddocsustento").val("01");
		$("#factura").val("01");
		
		
    }
 
 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	$("#cab_codigo").val(id);
 
	//   BusquedaGrilla(oTable);

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
  