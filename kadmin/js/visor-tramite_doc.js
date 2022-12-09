 var oTable;
  
 

//-------------------------------------------------------------------------
$(document).ready(function(){
    
	
		$("#MHeader").load('../view/View-HeaderMain.php');
	
  		
 
	    
		$("#FormPie").load('../view/View-pie.php');
   		
		
		 $('#bcodigo').on('click',function(){
			  
			 BuscarArchivos_datos( );
	  			
		 });
		
		 
		 $('#blimpiar').on('click',function(){
			  
			 $("#ccodigo").val( '');       
			 $("#ccedula").val( '');  
			 $("#ccaso").val( '');  
			 
			 
			 BuscarArchivos_datos( );
	  			
		 });
		
		 
 
          
});   
//-------------------------------------------------------------------------
// ir a la opcion de editar
 

$('#bcodigo').on('click',function(){
	  
	 BuscarArchivos_datos( );
			
});


//------------------------------------------------------------------------- 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function BuscarArchivos_datos(   ){        	 

	  
  
	 var cadena =  $("#ccodigo").val( );         
	 
	 var ccedula =  $("#ccedula").val( );  
	 
	 var ccaso =  $("#ccaso").val( );  
	 
	  
	  var parametros = {
			    'cadena' : cadena ,
 			    'ccedula' : ccedula,
 			    'ccaso': ccaso,
			    'accion' : 1
     };
	  
	  
	  $.ajax({
			url:   '../controller/Controller-visor_tramite_doc.php',
			data:  parametros,
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#unidad_file").html('Procesando');
			},
			success:  function (data) {
					 $("#unidad_file").html(data);   
					 
					 $("#ccodigo").val('' );      
					 $("#ccedula").val('' );       
					 $("#ccaso").val('' );       
				     
			} 
	}); 
}  
 //---------------------------
function CargaDatos(idtramite) {


	
	 

	var parametros = {
            'id' : idtramite 
    };

	$.ajax({
				data:  parametros,
				url:   '../model/Model-proceso_recorrido.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#ViewRecorrido").html('Procesando');
					},
				success:  function (data) {
						 $("#ViewRecorrido").html(data);  // $("#cuenta").html(response);
					     
					} 
		}); 


} 	
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
 
 
 function imagenfoto( )
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
 