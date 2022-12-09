var oTable;
var formulario = 'ac_externos';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
        oTable 				= $('#jsontable').dataTable(); 
          
        
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
	    BusquedaGrilla(oTable);
	           
 		
		
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
						     
 		    
							 
  					} 
			}); 
 
	  
}
//----------------------
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	$("#action").val("add");

	﻿$("#id_externo").val("");
	$("#identificacion").val("");
	$("#nombre_externo").val("");
	$("#telefono_externo").val("");
	$("#ubicacion_externo").val("");
	$("#estado").val("");
	 
}
 
 
 //---------------------------
function accion(id,modo)
{
 
	 
	$("#action").val(modo);
	
	$("#id_externo").val(id);
	
 
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
 
            
    return today;
} 
//------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){       
	  
/*
   	var tanio            = $("#tanio").val();
 	var tperiodo         = $("#tperiodo").val();

     
    var parametros = {
				'tanio' : tanio,  
				'tperiodo' : tperiodo 
				};
 */
	  
	  
	  
	  
		$.ajax({
		// 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		    //console.log(s); 
			oTable.fnClearTable();
			if(s)  {
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
		  } 						
		 } 
	 	});

}   
  



//-----------------
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
 }
 
//-----------------
 function printDiv(divID) {
	 
	 var objeto=document.getElementById(divID);  //obtenemos el objeto a imprimir
	 
	  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	  
	  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	  ventana.document.close();  //cerramos el documento
	  ventana.print();  //imprimimos la ventana
	  ventana.close();  //cerramos la ventana
        
}
  