$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


var oTable;

var formulario = 'ven_clientes';

//-------------------------------------------------------------------------
$(document).ready(function(){
    
         oTable = $('#jsontable').dataTable(); 
	
		  
 		
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
	
	var idprov;
	
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ven_cliente_post.php',
					type:  'GET' ,
					cache: false,
					success:  function (data) {
						  
						   alert(data);
						
						   opener.window.location.reload(); 

 						   window.close();
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
    
 
 
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	   	var bnaturaleza = $("#bnaturaleza").val();
	   	
	 	var bidciudad = $("#bidciudad").val();
	 	
		var bestado = $("#bestado").val();
		
		var bcliente = $("#bcliente").val();
		
	    
	    var parametros = {
					'bnaturaleza' : bnaturaleza,  
					'bidciudad' : bidciudad,
					'bestado': bestado,
					'bcliente':bcliente
	    };
	 
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ven_clientes_post.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
   					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+"'" +s[i][0] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'   
 				]);										
			} // End For
	 							
			} 
	 	});
 
 
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 
 
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
 
//--------------------------------
//-------------------
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
 
  