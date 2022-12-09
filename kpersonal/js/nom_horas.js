var oTable;
  
$(function(){
    $(document).bind("contextmenu",function(e){        return false;    });
    window.addEventListener("keypress", function(event){        if (event.keyCode == 13){            	event.preventDefault();        }    }, false);});
//-------------------------------------------------------------------------$(document).ready(function(){
	   window.addEventListener("keypress", function(event){	        if (event.keyCode == 13){	            event.preventDefault();	        }	    }, false);

		 $.ajax({ 			 url: "../model/Model_nom_horas_lista.php",			 type: "GET",	        success: function(response)	        {	            $('#q_periodo').html(response);	        }		 });
		  $.ajax({	 			 url: "../model/ajax_unidad_lista.php",				 type: "GET",		       success: function(response)		       {		           $('#qunidad').html(response);		       }			 });		    		    $.ajax({				 url: "../model/ajax_regimen_lista.php",				 type: "GET",		       success: function(response)		       {		           $('#qregimen').html(response);		       }			 }); 
		$("#MHeader").load('../view/View-HeaderModel.php');		modulo();		$("#FormPie").load('../view/View-pie.php');
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
					$('#result').html("<b>CREAR UN NUEVO REGISTRO...</b>");
					 
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
function PonerDatos( ) {
 
    var periodo = 	$('#q_periodo').val();
	
 
     var parametros = {
                     'periodo' : periodo
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_horas_view.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#ViewProceso").html('Procesando');
  					},
					success:  function (data) {
							 $("#ViewProceso").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
  
  //------------------------------------------------------------------------- 
  function goToURL(accion, funcionario,idhora){   
	  
	     var id_periodo = 	$('#id_periodo').val();
	     var id_rol     = 	$('#id_rol').val();
	     var anio       = 	$('#anio').val();
	     var mes        = 	$('#mes').val();
		
	     var dia 		= 	$('#d' +funcionario).val();
	     var extra      = 	$('#e' +funcionario).val();
	     var suple      = 	$('#s' +funcionario).val();
	     var atraso     = 	$('#a' +funcionario).val();
 
	     
	     var parametros = {
	                     'id_periodo' : id_periodo, 
	                     'id_rol' : id_rol, 
	                     'anio'   : anio, 
	                     'mes' : mes, 
	                     'idprov' : funcionario, 
	                     'dia' : dia, 
	                     'extra' : extra, 
	                     'suple' : suple,
	                     'atraso':atraso,
	                     'accion':accion,
	                     'idhora':idhora
	 	  };
	     
		  $.ajax({
						data:  parametros,
						url:   '../model/Model-nom_horas_save.php',
						type:  'POST' ,
	 					beforeSend: function () { 
	 							$("#ViewHora").html('Procesando');
	  					},
						success:  function (data) {
								 $("#ViewHora").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				}); 
		  
		  
 
 
  }   
//--------------
//------------------------------------------------------------------------- 
//-----------------
  function accion(id, action)
  {
   
  	$('#action').val(action);
  	
  	
	$('#id_config').val(id);
   
  	
 
  	
  } 
 
 
 function modulo()
 {
  
   

	 var modulo1 =  'kpersonal';
		 
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
    

	 $("#ViewForm").load('../controller/Controller-nom_config.php');
      

 }
    
  