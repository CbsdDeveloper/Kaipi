 var oTable;
   
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
     
		
	    $("#ViewFormCIU").load('../controller/Controller-clientesRUC.php');
	  
	    $("#ViewForm").load('../controller/Controller-clientes.php');
	    
		$("#FormPie").load('../view/View-pie.php');
 
	         
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
 
 
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-cli_clientes',
					type:  'GET' ,
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
  
	
	$("#idprov").val("");
	$("#razon").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#correo").val("");
	$("#movil").val("");
	$("#idciudad").val("");
	$("#contacto").val("");
	$("#ctelefono").val("");
	$("#ccorreo").val("");
	$("#estado").val("");
	$("#tpidprov").val("");
 
	$("#action").val("add");
 
       			   
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
    
    document.getElementById('fechatarea').value = today ;
    
    document.getElementById('fechafinal').value = today ;
    
    $("#tarea").val("");
	
    $("#tareaproducto").val("");
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
			var user = $(this).attr('id');
            
           var  estado 		  = $("#estado1").val();
            var naturaleza    = $("#naturaleza1").val();
           
 
         
            var parametros = {
					'estado' : estado , 
                    'naturaleza' : naturaleza  
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_cli_clientes.php',
				dataType: 'json',
				success: function(s){
			//	console.log(s); 
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
                               	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
				 }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
 }   
 
 function imagenfoto(urlimagen)
{
  
	 
    var path_imagen =  '../'+ urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
 
function actualiza_cliente() {
 
     var idprov =   $('#idprov').val();
     var razon =   $('#razon').val();
     var correo =   $('#correo').val();
      
     
     window.opener.document.getElementById( "idprov" ).value = idprov;
     window.opener.document.getElementById( "razon" ).value = razon;
     window.opener.document.getElementById( "correo" ).value  = correo;
     
 
     window.close();
 
    }
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
         var id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  

function modulo()
{
 
 
}
//-----------------
 
//-----------------
function accion(id, action)
{
 
	$('#action').val(action);
 
	  
   

}
 
//--------------------------------------------------------------------	   
function BusquedaWSCiu() {
      
	
 
	   var vid    =   $('#idprovRUC').val();
	   var vrazon =   $('#razonRUC').val();
	
	   alert(vid);
 
	var parametros = {
			"vid" : vid, 
			"vrazon": vrazon
	};
	 
	$.ajax({
		    type:  'GET' ,
			data:  parametros,
			url:   '../model/WSCedulas.php',
			dataType: "json",
				success:  function (response) {

					
					 $("#idprov").val( response.a );  
					 
					 $("#razon").val( response.b );  
					 
					 $("#fechaRUC").val( response.c );  
					 
					 $("#nacimiento").val( response.c );   
					 
					 $("#tpidprov").val( '02' );   
					 
			} 
	});
 
}
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
  