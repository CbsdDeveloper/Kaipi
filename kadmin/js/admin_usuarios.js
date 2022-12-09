 var oTable;
  
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		modulo();
 		
	    FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
   		
        oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 0 ] },
  		      { "sClass": "ye", "aTargets": [ 1 ] },
  		      { "sClass": "de", "aTargets": [ 6 ] }
  		    ] 
       } );
	    
	    BusquedaGrilla( oTable);
 		
 	   $('#load').on('click',function(){
 	 		 
 		   			BusquedaGrilla(oTable);
          
		});
     
 	   
    
    
	         
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

//-------------------------------------		   
  function openFile(url,ancho,alto) {
    
			var posicion_x; 
		  var posicion_y; 
		  var enlace; 
		  
		  posicion_x=(screen.width/2)-(ancho/2); 
		  posicion_y=(screen.height/2)-(alto/2); 
		  
		 
		  
		  enlace = url  ;
	  
		  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
	  }		   
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {
 
 
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
     
     var vurl ='';
     
     if ( accion == 'email'){
    	 vurl = '../model/EnvioCorreoEmail.php';
     }else{
    	 vurl = '../model/Model-admin_usuarios.php';
     }
     
	  $.ajax({
					data:  parametros,
					url:   vurl,
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
						
						  if ( accion == 'email'){
						    	 alert(data);
						     }else{
						    		$("#result").html(data);
						     }
						     
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
  
                    $("#login").val("");
                    $("#idusuario").val("");
                    
                    $("#estado").val("");
                    $("#email").val("");
                    $("#cedula").val("");
                    $("#nombre").val("");
                    $("#apellido").val("");
                    $("#idciudad").val("");
                    $("#estado").val("");
                    $("#direccion").val("");
                    $("#telefono").val("");
                    $("#movil").val("");
                    $("#tipo").val("");
                    $("#clave").val("");
                    $("#nomina").val("");
                    $("#caja").val("");
                    $("#supervisor").val("");
                    $("#noticia").val("");
                    $("#tarea").val("");
                    $("#url").val("");
                    
                    $("#brazon").val("");
                    
       			   
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

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

 	  
		var user = $(this).attr('id');
      
     	var GrillaCodigo 	= $("#qestado").val();
     	var qrol 			= $("#qrol").val();
     	var qdirector 		= $("#qdirector").val();
    
          

          	 


      var parametros = {
				'GrillaCodigo' : GrillaCodigo,
				'qrol' : qrol,
				'qdirector':qdirector	
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_admin_usuarios.php',
			dataType: 'json',
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
			    		    s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
 	                        s[i][4],
                            s[i][5],
                            s[i][6],
                        	'<button class="btn btn-xs btn-warning" title= "Editar transaccion" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp; ' + 
							'<button class="btn btn-xs btn-danger" title= "Eliminar transaccion" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;&nbsp;'  +
							'<button class="btn btn-xs btn-info" title= "Notificar acceso a usuario" onClick="goToURL('+"'email'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-wrench"></i></button>' 
						]);										
					} // End For
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
		
		 
 		 
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 function imagenfoto(urlimagen)
{
  
	 $("#ImagenUsuario").attr("src",urlimagen);
 

}
 function modulo()
 {
  
   

	 var modulo1 =  'kadmin';
		 
	 var parametros = {
			    'ViewModulo' : modulo1
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
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
    

	 $("#ViewForm").load('../controller/Controller-admin_usuarios.php');
      

 }
    
  