 var oTable;
 var oTableArticulo;
   
 
//-------------------------------------------------------------------------
$(document).ready(function(){

 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
 		
 	   $('#boton1').on('click',function(){
             CrearPeriodo( );
  
		});
	 
		
	   $('#boton2').on('click',function(){
             PlanCuentas( );
  
		});
	 

		  $('#boton3').on('click',function(){
             CrearPeriodoPresupuesto( );
  
		});

		  $('#boton4').on('click',function(){
             IngresoPresupuesto( );
  
		});

		  $('#boton5').on('click',function(){
             GastoPresupuesto( );
  
		});

		$('#boton21').on('click',function(){
			CrearSecuencias( );
 
	   });

	   $('#boton22').on('click',function(){
		ValidaCuentas( );

   });
		
		


		$("#FormPie").load('../view/View-pie.php');
     
 	    
	   
	
	         
});  
//-----------------------------------------------------------------
 
//-------------------------------------------------------------------------
function PlanCuentas (){
	
	
	 "use strict";
	  var anio =  	$("#anio").val();
	 		 
	 var parametros = {
				'anio': anio,
				'accion' : 2
    };
	  
	
	 $.ajax({

 			data:  parametros,
			url:   '../model/Model-parametro_anio.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
 					$("#resultado").html('Procesando... ' + anio);
 			},
			success:  function (data) {
 					 $("#resultado").html(data);   
  			} 

	}); 
 
	
}
//-------------------------------------------------------------------------
function CrearPeriodo (){
	
	
	 "use strict";
	 var anio =  	$("#anio").val();
	 var parametros = {
				'anio': anio,
				'accion' : 1
   };
	  
	
	 $.ajax({

 			data:  parametros,
			url:   '../model/Model-parametro_anio.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#resultado").html('Procesando');
			},
			success:  function (data) {
					 $("#resultado").html(data);   
 			} 

	}); 
	
}
//--------
function ValidaCuentas (){
	
	
	"use strict";
	var anio =  	$("#anio").val();
	var parametros = {
			   'anio': anio,
			   'accion' : 22
  };
	 
   
	$.ajax({

			data:  parametros,
		   url:   '../model/Model-parametro_anio.php',
			type:  'GET' ,
		   cache: false,
		   beforeSend: function () { 
				   $("#resultado").html('Procesando');
		   },
		   success:  function (data) {
					$("#resultado").html(data);   
			} 

   }); 
   
}
//------------
function CrearSecuencias (){
	
	
	"use strict";
	var anio =  	$("#anio").val();
	var parametros = {
			   'anio': anio,
			   'accion' : 11
  };
	 
   
	$.ajax({

			data:  parametros,
		   url:   '../model/Model-parametro_anio.php',
			type:  'GET' ,
		   cache: false,
		   beforeSend: function () { 
				   $("#resultado").html('Procesando');
		   },
		   success:  function (data) {
					$("#resultado").html(data);   
			} 

   }); 
   
}
//-------------------
//-------------------------------------------------------------------------
function GastoPresupuesto (){
	
	
	 "use strict";
	 var anio =  	$("#anio").val();
	 var parametros = {
				'anio': anio,
				'accion' : 5
   };
	  
	
	 $.ajax({

 			data:  parametros,
			url:   '../model/Model-parametro_anio.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#resultado").html('Procesando');
			},
			success:  function (data) {
					 $("#resultado").html(data);   
 			} 

	}); 
	
}   
//-------------------------------------------------------------------------
function IngresoPresupuesto (){
	
	
	 "use strict";
	 var anio =  	$("#anio").val();
	 var parametros = {
				'anio': anio,
				'accion' : 4
   };
	  
	
	 $.ajax({

 			data:  parametros,
			url:   '../model/Model-parametro_anio.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#resultado").html('Procesando');
			},
			success:  function (data) {
					 $("#resultado").html(data);   
 			} 

	}); 
	
}   
//-------------------------------------------------------------------------
function CrearPeriodoPresupuesto (){
	
	
	 "use strict";
	 var anio =  	$("#anio").val();
	 var parametros = {
				'anio': anio,
				'accion' : 3
   };
	  
	
	 $.ajax({

 			data:  parametros,
			url:   '../model/Model-parametro_anio.php',
 			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#resultado").html('Procesando');
			},
			success:  function (data) {
					 $("#resultado").html(data);   
 			} 

	}); 
	
}   
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
        var id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  

function modulo()
{
 

	 var modulo1 =  'kadmin';
		 
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
   
	 
	 
	 
	 
     
 
}
 
