 var oTable;
//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
 
 
  //  oTable =  $('#jsontable').dataTable( );
   
		 oTable =  $('#jsontable').dataTable( {
			    "aoColumnDefs": [
			      { "sClass": "highlight", "aTargets": [ 12] },
			      { "sClass": "ye", "aTargets": [ 4 ] }
			    ]
			  } );
 
 	    
		$("#FormPie").load('../view/View-pie.php');
     
 	 
	   
		   $('#load').on('click',function(){
	 		   
	            BusquedaGrilla( oTable );
	  			
			});
	 
		   $('#devengo').on('click',function(){
	 		   
	            GenerarProcesoDevengado(  );
	  			
			});
		   
	
	         
});  
//---------------modalProducto
 
//--------------
function Procesar( ){   
	
	 
	
		var  isd     = $("#isd").val();
		var  trasporte	  =   $('#trasporte').val();  
		
		var  vip	  =   $('#vip').val();  
		var  integrador	  =   $('#integrador').val();  
		var  pvp1	  =   $('#pvp1').val();  
		var  pvp2	  =   $('#pvp2').val();  
		var  pvp3	  =   $('#pvp3').val();  
		
	    var parametros = {
					   'isd' : isd ,
					   'trasporte' : trasporte ,
	                   'vip' : vip ,
	                   'integrador' : integrador ,
					   'pvp1' : pvp1 ,
	                   'pvp2' : pvp2 ,
	                   'pvp3' : pvp3 
		  };
	    
	 
		  $.ajax({
						data:  parametros,
						url:   '../model/ajax_edita_cotiz.php',
						type:  'GET' ,
						success:  function (data) {
	  							
								$("#procesado").html(data);   
							     
								BusquedaGrilla();
	 					} 
				}); 
	 
		  
	 //isd trasporte vip integrador pvp1 pvp2 pvp3
}


function modalProducto(url){        
	
    
     var estado  = $('#estado').val();
    var tipo    = $('#tipo').val();
    
    AsignaBodega();
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1024;
    
    var alto = 500;
 
	    
	    posicion_x=(screen.width/2)-(ancho/2); 
	    
	    posicion_y=(screen.height/2)-(alto/2); 
	    
	     window.open(enlace ,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
    
 }

//--------------------

function goToURLEdita( id )  {
	 
	 
	var  idbodega     = $("#idbodega1").val();
	var  codigo =   $('#codigo_busca').val();  
	
    var parametros = {
				   'idbodega' : idbodega ,
				   'codigo' : codigo ,
                   'id' : id 
	  };
    
 
	  $.ajax({
					data:  parametros,
					url:   '../model/Model_save_xml_prod.php',
					type:  'GET' ,
					success:  function (data) {
  							
							$("#ViewFiltroCodigo").html(data);   
						     
 					} 
			}); 
 
	   
   }
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
			  	   $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
			  	   
                    LimpiarPantalla();
                    
                 
					 
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
 
function modulo()
{
 

	 var moduloOpcion =  'kpresupuesto';
		 
	 var parametros = {
			    'ViewModulo' : moduloOpcion 
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
   
//----------------------
 

//-------------------------------------------------------------
//--------------------------------------------------------
 
  
function BusquedaGrilla( oTable ){
	
 
	var anio =  $("#banio").val();
	
	var parametros = {
						 'anio'     : anio  
	 	  };
		
	$.ajax({
	 	data:  parametros,
	    url: '../grilla/grilla_enlace_esigef.php',
		dataType: 'json',
		cache: false,
		success: function(s){
		console.log(s); 
		oTable.fnClearTable();

		if(s){
				for(var i = 0; i < s.length; i++) {
		
					  oTable.fnAddData([
		
		                  s[i][0],
 		                  s[i][1],
 		                  s[i][2],
 		                  s[i][3],
 						  s[i][4],
 						  s[i][5],
 						  s[i][6],
						  s[i][7],
						  s[i][8],
						  s[i][9],
 						  s[i][10],
						  s[i][11],
						  s[i][12],
						  s[i][13]
		              ]);									
		
				} // End For
 		     }				
 		},
 			error: function(e){
 		    console.log(e.responseText);	
 		}
 		});

}   
 //---------
function GenerarProcesoDevengado(  ){

	 
	var  banio     = $("#banio").val();
 
 
    
    var parametros = {
	 			"anio" : banio  
		};
    
	     $.ajax({
				 url:   '../model/Model_enlace_esigef_dev.php',
				data:  parametros,
			   type:  'GET' ,
				beforeSend: function () { 
						$("#procesado_archivo").html('Procesando');
				},
			success:  function (data) {
					 $("#procesado_archivo").html(data);  // $("#cuenta").html(response);
				     
				} 
    });
	 
	}
//-----------

