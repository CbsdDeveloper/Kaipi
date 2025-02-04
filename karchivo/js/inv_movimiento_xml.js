//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
 	    
		$("#FormPie").load('../view/View-pie.php');
     
 	 
	   
	     $('#loadSaldo').on('click',function(){
		  	  
	   	  
			   $.ajax({
				 url:   '../model/Model-saldo_bodega.php',
				type:  'POST' ,
				cache: false,
				beforeSend: function () { 
							$("#SaldoBodega").html('Procesando');
					},
				success:  function (data) {
						 $("#SaldoBodega").html(data); 

					} 
		});
	
	});
	     
	
	         
});  
//---------------modalProducto
function AsignaBodega()
{
    var  idbodega     = $("#idbodega1").val();
   
    var parametros = {
            'idbodega' : idbodega 
    };
    
    
	$.ajax({
 			 url:   '../model/ajax_bodega.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#SaldoBodega").html('Procesando');
				},
			 success:  function (data) {
					 $("#SaldoBodega").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
	

}
//--------------
function enlace_url(url){   
	
	location.href = url;
}


function modalProducto(url){        
	
    
    var id_movimiento = $('#id_movimiento').val();
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
 

	 var moduloOpcion =  'kinventario';
		 
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
function FormFiltro()
{
 
	 $("#ViewFiltro").load('../controller/Controller-inv_movimiento_xml_filtro.php');
 
}

//-------------------------------------------------------------
//--------------------------------------------------------
 
  
function goToURLCodigo(nombre,codigo){
	
	
 	  
     $('#producto_busca').val(nombre);  
   
     $('#codigo_busca').val(codigo);    
 
}
 

//-----------------
 
//---------
function BuscaCodigo(  ){

	 
	var  idbodega     = $("#idbodega1").val();
	  
	var  nombre =   $('#producto_busca').val();  
  
	var  codigo =   $('#codigo_busca').val();  
	
 
    
    var parametros = {
	 			"idbodega" : idbodega   ,
	 			"nombre" : nombre,
	 			"codigo" : codigo
		};
    
	     $.ajax({
				 url:   '../model/Model-busca_producto.php',
				data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#DatosCarga1").html('Procesando');
				},
			success:  function (data) {
					 $("#DatosCarga1").html(data);  // $("#cuenta").html(response);
				     
				} 
    });
	 
	}

 
//-------
    

