 var oTable;
   
 
//-------------------------------------------------------------------------
$(document).ready(function(){
     
		
	  var id = getParameterByName('id');
	
 	  
	    $("#ViewForm").load('../controller/Controller-ga_registros_garantia.php?id='+id);
	    
  
	         
});  

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function actualiza_cliente() {
	 
	
    var idprov =   $('#idprov').val();
    var razon =   $('#razon').val();
    var correo =   $('#correo').val();
     
    alert(idprov);
    
    window.opener.document.getElementById( "idprov" ).value = idprov;
    window.opener.document.getElementById( "razon" ).value = razon;
    window.opener.document.getElementById( "correo" ).value  = correo;
    

     window.close();

   }
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	     LimpiarPantalla();
                    
						$("#action").val("add");
					
					    $("#result").html("<b>AGREGAR INFORMACION DE LA POLIZA/GARANTIA </b>");
			 		 
				 
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
  
	
 	$("#razon").val("");
	
	$("#idpoliza").val("");
 	$("#idprov_aseguradora").val("");
	$("#nro_poliza").val("");
	$("#tipo_poliza").val("");
	$("#documento").val("");
	$("#estado").val("");
	$("#monto").val("");
 
 
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
 
//-------------------------------------------------------------------------
  function accion(id, action)
  {
   
  	$('#action').val(action);
  	
  	$('#idpoliza').val(id); 
  	  
   
  }
//-------------------------------------------------------------------------
// ir a la opcion de editar
function Salir_ventana() {
 
     var id =   $('#idcontrato').val();
 
     var parametros = {
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-garantia_visor.php',
					type:  'GET' ,
 					success:  function (data) {
						 opener.$("#ViewFormfile").html(data);  
						     
						  var ventana = window.self;
						  ventana.opener = window.self;
						  ventana.close();
  					} 
			}); 

	
	  
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
 