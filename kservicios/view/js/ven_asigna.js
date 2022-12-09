var oTable ;

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
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					 
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
					url:   '../model/Model-ven_asigna.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
							  asignav(  id, 'visor' );

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

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

 
     	var GrillaCodigo = $("#qestado").val();
    
          
      var parametros = {
				'GrillaCodigo' : GrillaCodigo  
      };

 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_ven_asigna.php',
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
                          s[i][5],
                        	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'visor'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-edit"></i></button> '  
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
    

	 $("#ViewForm").load('../controller/Controller-ven_asigna.php');
      

 }
   //---
 function AsignaModulo(sector,tipo){   //esperando la carga... 
	 
	 
	 
	  var idusuario =    $("#idusuario").val();
      var vprovincia =    $("#vprovincia").val();
	  
 	  
     var parametros = {
					 'tipo' : tipo ,
                     'idusuario' : idusuario ,
                     'vcanton' : sector,
                     'vprovincia': vprovincia
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
//-----------------------------
function asignav( idusuario, action ){
 

var parametros = {
				 "tipo" 		: action,
				 "idusuario" 	: idusuario
 		 };
	
	 $.ajax({
			 type : 'GET',
			 data:  parametros,
			 url:   '../model/ajax_rol_user_ac.php',
			 success:  function (response) {
						 $("#asignado").html(response);
				 }

		});

	 $("#result").html('<b>SELECCIONE  LA ZONA PARA ASIGNAR AL USUARIO GESTOR DE VENTAS</b>'); 
	 
	 
}
//-----------------------------
function  asignaa( idcodigo,idusuario ,action ){
 

var parametros = {
				 "tipo" 		: action,
				 "idcodigo" 	: idcodigo,
				 "idusuario" 	: idusuario
 		 };
	
	 $.ajax({
			 type : 'GET',
			 data:  parametros,
			 url:   '../model/ajax_rol_user_ac.php',
			 success:  function (response) {
						 $("#asignado").html(response);
				 }

		});

	 $("#result").html('<b>SELECCIONE  LA ZONA PARA ASIGNAR AL USUARIO GESTOR DE VENTAS</b>'); 
	 
	 
}
 
  