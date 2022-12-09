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
 		
 	   $('#load').on('click',function(){
 	 		 
 		   			BusquedaGrilla(oTable);
          
		});
     
          
});   
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {
 
 
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-admin_usuarios.php',
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
 
 //---------------------------
 //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

 	  
		var user = $(this).attr('id');
      
     	var GrillaCodigo = $("#qestado").val();
    
          
      var parametros = {
				'GrillaCodigo' : GrillaCodigo  
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_admin_usuarios.php',
			dataType: 'json',
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
 	                        s[i][3],
                          s[i][4],
                          s[i][5],
                        	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][6] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
    

	// $("#ViewForm").load('../controller/Controller-admin_usuarios.php');
      

 }
    
  