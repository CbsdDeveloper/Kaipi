var oTable ;
var formulario = 'ven_plantillas';


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
   		
    oTable = $('#jsontable').dataTable(); 
	
    //----------------------------
   

 		
 	 $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
 
		});
      
 	   
	         
});  

//---------------------------
function accion(id,modo,estado)
{
 	 
	$("#action").val(modo);
	
	$("#id_plantilla").val(id);
 
	if (id) {
		BusquedaGrilla(oTable);

		visor_editor( );
	
	}

}

//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
                    ListaUsuario( 0 );
 					 
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
						 visor_editor( );
					} 
		}); 
	
	
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
	
	$("#id_plantilla").val("");
	$("#titulo").val("");
	$("#tipo").val("");
	$("#contenido").val("");
	$("#vinculo").val("");
	$("#publicar").val("");
	$("#ambito").val("");
    
    
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
    
 
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

     var qtipo = $("#qtipo").val();
          
      var parametros = {
				'qtipo' : qtipo  
      };
      
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
							s[i][4],
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
 
		
  }   
//--------------
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
    

	 $("#ViewForm").load('../controller/Controller-'+formulario);
      

 }
   //---
///---------- editor edicion
 function visor_editor( ) {
  

    var id =   $('#id_plantilla').val();

    var url =  'editor.php?id='+ id;

	 if (id){
		 
			$('#ieditor').attr('src', url);
			$('#ieditor').reload();

      }  

 }	
 //---------------------
 function open_editor(url,ovar,ancho,alto) {
	    var posicion_x; 
	    var posicion_y; 
	    var enlace; 

	   var id =   $('#idcontenido').val();

	   
		   if ( id )  {
		   			
		    posicion_x=(screen.width/2)-(ancho/2); 
		    
		    posicion_y=(screen.height/2)-(alto/2); 
		    
		    enlace = url + '?id='+ id;
		    
		    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
		    
		   }	   

	}	 
//-----------------------------
function asignav(cod, idusuario, action ){
 
var idvengrupo =    $("#idvengrupo").val();
	 
var parametros = {
				 "tipo" 		: action,
				 "idusuario" 	: idusuario,
				 "idcodigo" 	: cod,
				 'idvengrupo' : idvengrupo
 		 };
	
	 $.ajax({
			 type : 'GET',
			 data:  parametros,
			 url:   '../model/ajax_rol_user_ac.php',
			 success:  function (response) {
						 $("#asignado").html(response);
				 }

		});

 	 
	 
}
//-----------------------------
function  asignaa( ){
 
 
	
    var idusuario  =    $("#idusuario").val();
    var sector     =    $("#sector").val();
    var idvengrupo =    $("#idvengrupo").val();
	  
    var mensaje 	    = 0;
	
	 if($("#sector").val().length < 5) {  
	        alert("Seleccione el Sector");  
	        mensaje = 1;
	 }  

	 if($("#idvengrupo").val() < 1) {  
	        alert("Seleccione el grupo asignado");  
	        mensaje = 1;
	 }  

	 if($("#idusuario").val() < 1) {  
	        alert("Selecione el usuario vendedor");  
	        mensaje = 1;
	 } 
	 
 
	 if (mensaje== 0)  {  
			
		   var parametros = {
						   'tipo' : 'add' ,
		                   'idusuario' : idusuario ,
		                   'sector' : sector,
		                   'idvengrupo': idvengrupo
			  };
		   
							$.ajax({
								data:  parametros,
								url:   '../model/ajax_rol_user_ac.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#asignado").html('Procesando');
			  					},
								success:  function (data) {
										 $("#asignado").html(data);  // $("#cuenta").html(response);
									     
			  					} 
						})
		}
 
} 