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
   		
	     oTable = $('#jsontable').dataTable(); 
	    
	    BusquedaGrilla( oTable);
 		
 
    
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
					$("#result").html("AGREGAR INFORMACIÓN... REGISTRE TODA LA INFORMACIÓN");
					 
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
					url:   '../model/Model-inv_configura.php',
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
  
	﻿$("#tipo").val("");
	$("#carpeta").val("");
	$("#modulo").val("");
	$("#carpetasub").val("");
	$("#formato").val("");
	
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

 
 	  
		var user = $(this).attr('id');
      
 
		if(user != '') 
		{ 
		$.ajax({
 		    url: '../grilla/grilla_inv_configura.php',
			dataType: 'json',
			success: function(s){
			console.log(s); 
			
			oTable.fnClearTable();
			
			if (s){
			
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
 	                        s[i][3],
                          s[i][4],
                         	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
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
 function modulo()
 {

	 var modulo =  'kcrm';
		 
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
//-----------------------------------------
 function accion(id,modo)
 {
   
 			$("#action").val(modo);
 			
 			$("#tipo").val(id);          

 			BusquedaGrilla(oTable );

 }
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-inv_configura.php');
      

 }
    
  