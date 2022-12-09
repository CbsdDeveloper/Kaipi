 var oTable;
 
 var oTableArticulo;
   

//------------------------
function url_ficha(url){        
	
	 tramite =  $("#a1").val();
	 factura =  $("#a2").val();
	 ruc     =  $("#a3").val();
 
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?a='+tramite + '&b='+ factura + '&c='+ ruc ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }   
//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
        oTable = $('#jsontable').dataTable(); 
	    
 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         

		$("#loadprinter").click(function(){
 	    	 
	    	 var fecha1			= $("#fecha1").val();
	    	 var fecha2			= $("#fecha2").val(); 
	    	 var vidsede		= $("#vidsede").val();
 	    	 
	    	 
	    	 var ancho = 1250; 
	   	     var alto = 400; 
	   	     var posicion_x ; 
	   	     var posicion_y ; 
	   	     var enlace; 

	    	 var cadena 	= 'f1=' + fecha1 + '&f2=' + fecha2 + '&sede=' + vidsede ;
	    	 enlace 		= '../model/_exporta_impresion_ac.php?' + cadena;
 	         posicion_x		= (screen.width/2)-(ancho/2); 
 	   	     posicion_y		= (screen.height/2)-(alto/2); 
	 
  
 	 		 window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 	   	     
	     });
	   
	 
		 $("#loadprinter1").click(function(){
 	    	 
			var fecha1			= $("#fecha1").val();
			var fecha2			= $("#fecha2").val(); 
			var vidsede		= $("#vidsede").val();
			 
			
			var ancho = 1250; 
			   var alto = 400; 
			   var posicion_x ; 
			   var posicion_y ; 
			   var enlace; 

			var cadena 	= 'f1=' + fecha1 + '&f2=' + fecha2 + '&sede=' + vidsede +'&tipo=1';
			enlace 		= '../model/_exporta_impresion_pe.php?' + cadena;
			 posicion_x		= (screen.width/2)-(ancho/2); 
				posicion_y		= (screen.height/2)-(alto/2); 
	
 
			  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
				
		});

		
		$("#loadprinter2").click(function(){
 	    	 
			var fecha1			= $("#fecha1").val();
			var fecha2			= $("#fecha2").val(); 
			var vidsede		= $("#vidsede").val();
			 
			
			var ancho = 1250; 
			   var alto = 400; 
			   var posicion_x ; 
			   var posicion_y ; 
			   var enlace; 

			var cadena 	= 'f1=' + fecha1 + '&f2=' + fecha2 + '&sede=' + vidsede+'&tipo=2';
			enlace 		= '../model/_exporta_impresion_pe.php?' + cadena;
			 posicion_x		= (screen.width/2)-(ancho/2); 
				posicion_y		= (screen.height/2)-(alto/2); 
	
 
			  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
				
		});

		$("#loadprinter3").click(function(){
 	    	 
			var fecha1			= $("#fecha1").val();
			var fecha2			= $("#fecha2").val(); 
			var vidsede		    = $("#vidsede").val();
			var ccuenta         = $("#ccuenta").val();
			 
			
			var ancho = 1250; 
			   var alto = 400; 
			   var posicion_x ; 
			   var posicion_y ; 
			   var enlace; 

			var cadena 	= 'f1=' + fecha1 + '&f2=' + fecha2 + '&sede=' + vidsede+'&tipo=2&cuenta='+ccuenta;
			enlace 		= '../model/_exporta_impresion_compra.php?' + cadena;
			 posicion_x		= (screen.width/2)-(ancho/2); 
				posicion_y		= (screen.height/2)-(alto/2); 
	
 
			  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
				
		});

		
	
	         
});  
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
// ir a la opcion de editar
function goToURL(accion1,id,factura,ruc) {
 
 
	  $("#a1").val(id);
      $("#a2").val(factura);
      $("#a3").val(ruc);
 
	
     var parametros = {
					'accion' : accion1 ,
                    'id' : id ,
                    'factura' :factura,
                    'ruc' : ruc
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_movimientoa.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#DivMovimiento").html('Procesando');
  					},
					success:  function (data) {
							 $("#DivMovimiento").html(data);  // $("#cuenta").html(response);
						     
							 $('#mytabs a[href="#tab2"]').tab('show');
  					} 
			}); 

 
	  
    }
   
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
			var user = $(this).attr('id');
            
            var  proveedor		= $("#proveedor").val();
            var  idtramite      = $("#idtramite").val();
            var  factura       = $("#factura").val();
            
            var  fecha1      = $("#fecha1").val();
            var  fecha2     = $("#fecha2").val();
             var  vidsede     = $("#vidsede").val();
  
         
            var parametros = {
					'vidsede' : vidsede , 
                    'proveedor' : proveedor  ,
                    'fecha1' : fecha1  ,
                    'fecha2' : fecha2  ,
                    'factura' : factura,
                    'idtramite':idtramite
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_movimientoa.php',
				dataType: 'json',
				success: function(s){
				//console.log(s); 
						oTable.fnClearTable();
						if(s ){ 
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
                                s[i][4],
                                s[i][5],
                                s[i][6],
                               	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'visor'"+','+ s[i][0]+','+"'"+s[i][1]+"'"+','+"'"+s[i][3] +"'"+')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;'  
								 
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
 
 function imagenfoto(urlimagen)
{
  
	 
    var path_imagen =  '../'+ urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
 
function modulo()
{
 

	 var moduloOpcion =  'kactivos';
		 
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
function FormView()
{
   
	 
	 $("#ViewForm").load('../controller/Controller-inv_movimientoa.php');
     
	 
 
	 

}
 
 
//----------------------
function FormFiltro()
{
 
	
	 $("#ViewFiltro").load('../controller/Controller-inv_movimientoa_filtro.php');
     
 

}
 
 