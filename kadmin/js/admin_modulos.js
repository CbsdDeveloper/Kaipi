$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

var oTable;

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	$("#MHeader").load('../view/View-HeaderModel.php');
	
	modulo();
		
 	FormView();
    
	$("#FormPie").load('../view/View-pie.php');
 
    oTable = $('#jsontable').dataTable(); 
        
      
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
					url:   '../model/Model-modulo_sistema.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
//-----------------------------------------
function accion(id,modo)
{
  
			$("#action").val(modo);
			
			$("#id_par_modulo").val(id);          

			var valor = $("#fid_par_modulo").val();
			
			if (modo == 'editar') {
				BusquedaGrilla(valor);
			}
				

}
  
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
	﻿$("#id_par_modulo").val("");
 	$("#modulo").val("");
	$("#estado").val("");
	$("#vinculo").val("");
	$("#publica").val("");
	$("#script").val("");
	$("#tipo").val("");
	$("#ruta").val("");
	$("#accion").val("");
	$("#detalle").val("");
	$("#logo").val("");
         			   
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
  function BusquedaGrilla(valor){        
 
  
			var user = $(this).attr('id');
			
			   var parametros = {
						'idmodulo' : valor 
	 	       };
			   
 
      
			if(user != '') 
			{
 
			$.ajax({
				data:  parametros,  
			    url: '../grilla/grilla_modulo.php',
				dataType: 'json',
				success: function(s){
				console.log(s); 
				if (s){
						oTable.fnClearTable();
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
 ///////////////////////////////////
 
function modulo()
{
 

	 var modulo =  'kadmin';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-Modulo.php');
     

}
 
  