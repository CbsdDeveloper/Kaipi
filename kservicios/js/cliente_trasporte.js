 var oTable;
   
 
//-------------------------------------------------------------------------
$(document).ready(function(){
     
		 
 	  
	    $("#ViewForm").load('../controller/Controller-clientes_trasporte.php');
	    
		$("#FormPie").load('../view/View-pie.php');
 
	         
});  

function actualiza_cliente(idprov,razon,id_par_ciu,correo) {
	 
	 
      
     
    window.opener.document.getElementById( "idprov" ).value = idprov;
    window.opener.document.getElementById( "razon" ).value = razon;
    window.opener.document.getElementById( "correo" ).value  = correo;
    window.opener.document.getElementById( "id_par_ciu" ).value  = id_par_ciu;

    window.opener.document.getElementById( "nombre_cooperativa" ).innerHTML= '<h3><b>2. ' + razon + '</b></h3>';

    


     window.close();

   }
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	     LimpiarPantalla();
                    
						$("#action").val("add");
					
					    $("#result").html("<b>AGREGAR INFORMACION DEL NUEVO CLIENTE</b>");
			 		 
				 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
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
     