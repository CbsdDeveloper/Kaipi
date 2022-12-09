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
	    
	    oTable 	= $('#jsontable').dataTable( {      
         searching: true,
         paging: true, 
         info: true,         
         lengthChange:true ,
         aoColumnDefs: [
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "de", "aTargets": [ 1 ] }
		    ] 
      } );
	    
	    BusquedaGrilla();
 	    
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
function accion(id, action)

{



	$('#action').val(action);

	

	$('#id_departamento').val(id); 
 

}
/*
*/
function DatoUsuario(valor,tipo,codigo) {
 
 
	var parametros = {
				   'valor' : valor ,
				   'tipo' : tipo ,
				   'codigo' : codigo 
	  };

	 $.ajax({
				   data:  parametros,
				   url:   '../model/ajax_guarda_tipo.php' ,
				   type:  'GET' ,
					beforeSend: function () { 
							$("#result").html('Procesando');
					 },
				   success:  function (data) {

							$("#result").html(data);   
							
 					 } 
		   }); 

   }
// ir a la opcion de editar
function goToURL(accion,id) {
 
 
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-cli_unidad.php' ,
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {

							 $("#result").html(data);   
						     
							
  					} 
			}); 

    }
 
/*

*/
function goToURL_unidad(id) {
 
 
	var parametros = {
				   
				   'id' : id 
	  };

	 $.ajax({
				   data:  parametros,
				   url:   '../controller/Controller-usuario_ini.php' ,
				   type:  'GET' ,
					beforeSend: function () { 
							$("#ViewFormUnidad").html('Procesando');
					 },
				   success:  function (data) {
							$("#ViewFormUnidad").html(data);   
							
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
  
                    $("#ruc_registro").val("");
                    $("#razon").val("");
                    
                    $("#estado").val("");
                    $("#contacto").val("");
                    $("#correo").val("");
                    $("#nombre").val("");
                    $("#web").val("");
                    $("#idciudad").val("");
                    $("#acceso").val("");
                    $("#direccion").val("");
                    $("#telefono").val("");
                    $("#mision").val("");
                    $("#email").val("");
                    $("#tipo").val("");
                    $("#acceso").val("");
                    $("#vision").val("");
                    $("#url").val("");
                    $("#smtp").val("");
                    $("#puerto").val("");
               
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
  function BusquedaGrilla(){        	 

 	  
	  	

	  
			var user = $(this).attr('id');
            
         
         	if(user != '') 
			{ 
			$.ajax({
		 
			    url: '../grilla/grilla_cli_unidad.php',
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
								'<button class="btn btn-xs btn-info" onClick="goToURL_unidad('+"'"+ s[i][4] +"'" +')"><i class="glyphicon glyphicon-search"></i></button> '  +
                                '<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+"'" + s[i][4] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button> '  
								
							]);										
						} // End For
											
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
 }   
 
 
 function modulo()
 {
  
 
 	 var modulo1 =  'kdocumento';

		 
	 var parametros = {
			    'ViewModulo' : modulo1 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
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
    
 	 
	 $("#ViewForm").load('../controller/Controller-cli_unidad.php');
      

 }
 //------   
 function imagenfoto(urlimagen)
 {
  
   
    var path_imagen = '../../kimages/' + urlimagen ;
  
     imagenid = document.getElementById("ImagenUsuario");
     
     imagenid.src = path_imagen;
      

 }  