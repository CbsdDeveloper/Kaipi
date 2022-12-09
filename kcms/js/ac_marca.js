var oTable;
var oTableModelo;
var formulario = 'ac_marca';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
  	 
       oTable 				= $('#jsontable').dataTable(
    		    {
    		        "paging":   true,
    		        "ordering": false,
    		        "info":     false,
    		        "lengthMenu": [[5,10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    		        "dom": '<"toolbar">frtip'
    		    } 
    		   ); 
 
       
       oTableModelo 				= $('#jsontableModelo').dataTable(
   		    {
   		        "paging":   true,
   		        "ordering": false,
   		        "info":     false,
   		        "searching": false,
   		        "lengthMenu": [[5,10, 25, 50, -1], [5, 10, 25, 50, "All"]],
   		        "dom": '<"toolbar">frtip'
   		    } 
   		   ); 
       
       
 
       
     //  $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');
       
 	
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

	
	$("#ViewModelo").html('<h5>Marca:<b> ' + accion + '</h5></b>');
	
	$("#ViewModeloForm").html('<h5>Marca:<b> ' + accion + '</h5></b>');
 	
	$("#id_marca").val(id);
	
	LimpiarPantalla();
	
	
	BusquedaGrillaModelo(oTableModelo);
	
	
	 
}
//----------------------
function goToURLModelo(accion,id) {
	

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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	$("#action").val("add");

	﻿$("#id_modelo").val("");
 	$("#nombre").val("");
	$("#referencia").val("");
	 
}
 
 
 //---------------------------
function accion(id,modo)
{
 
	 
	$("#action").val(modo);
	
	$("#id_modelo").val(id);
	
 
	BusquedaGrillaModelo(oTableModelo);

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
	  
 
	  
	  
		$.ajax({
  		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		    //console.log(s); 
			oTable.fnClearTable();
			if(s)  {
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
     					'<button class="btn btn-default  btn-xs" onClick="javascript:goToURL('+"'" + s[i][0] +"'" +','+ s[i][1] +')"><i class="glyphicon glyphicon-edit"></i></button>',
     					s[i][0]
				]);										
			} // End For
		  } 						
		 } 
	 	});

}   
  
//---------------------
  function BusquedaGrillaModelo(oTableModelo){       
	  
 
 	   	var id_marca         = $("#id_marca").val();
 	       
	    var parametros = {
	  				'id_marca' : id_marca 
	  				};
	  
	 	  	  
	  		$.ajax({
	  		  	data:  parametros,
	   		    url: '../grilla/grilla_' + formulario + '_modelo',
	  			dataType: 'json',
	  			cache: false,
	  			success: function(s){
	  		    //console.log(s); 
	  		    oTableModelo.fnClearTable();
	  			if(s)  {
	  			for(var i = 0; i < s.length; i++) {
	  				oTableModelo.fnAddData([
	       					'<button class="btn btn-default  btn-xs" onClick="javascript:goToURLModelo('+"'editar'"+','+ s[i][1] +')"><i class="glyphicon glyphicon-edit"></i></button>',
	       					s[i][0]
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
  