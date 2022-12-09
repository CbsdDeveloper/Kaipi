 
//-------------------------------------------------------------------------
$(document).ready(function(){
     

    var j = jQuery.noConflict();
	    
    //-- imprime balance de comprobancion

    j("#printButtonBalance").click(function(){
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};

          j("#ViewPOAMatrizOO").printArea( options );

    });


		$("#MHeader").load('../view/View-HeaderModel.php');
		
		$("#FormPie").load('../view/View-Pie.php');
		
		modulo();
 		
		FormView();
		 
 
		$('#load').on('click',function(){
			 
	 	VisorObjetivos();
 
		 });
		
 
       
 
});  
 

function ResumenPOActa() 
{

    var departamento =  $("#Q_IDUNIDADPADRE").val();
 
 	var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
  
	enlace = '../../reportes/resumen_acta_poa.php?id=' + departamento + '&periodo=' + Q_IDPERIODO ;
  
  
	window.open(enlace,'#','width=950,height=520,left=30,top=20');
	   

}

//------------------
function busquedaArticulado ( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
 
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-OOtreeVisor.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#UnidadArticula").html('Procesando');
				},
			success:  function (data) {
					 $("#UnidadArticula").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
 
}
//-------------------------------------------------------------------------
function poa_resumen ( )
{
	
 	
      var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
      
 
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
    };
	 
	  
	 $.ajax({
		    type:  'GET' ,
			data:  parametros,
			 url:   '../model/ajax_resumen_poa.php',
			dataType: "json",
			success:  function (response) {

				     $("#techo").html( response.a );  
					 $("#inicial").html( response.b );  
 					 $("#ejecutado").html( response.c );  
 					 $("#ejecutadop").html( response.d );  
					 
				     $("#nobjetivos").html( response.e );  
					 $("#nindicadores").html( response.f );  
 					 $("#ntareas").html( response.g );  
 					 $("#ntareasp").html( response.h );  
			} 
	});
	 
	  
 
	
} 
//-------------------------------------------------------------------------
//-----------------
function FormView()
{
   
	 
	 $("#ViewFiltro").load('../controller/Controller-poa_filtro.php');
	 
	 
	 $("#ViewForm").load('../controller/Controller-actividad.php');
	 
 
 	
 	 
}

 
 
//-------------------
//---------------------
function modulo ( )
 {
	
	var modulo_sistema =  'kplanificacion';
	 
	 var parametros = {
			    'ViewModulo' : modulo_sistema 
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

//---------------------
function busquedaObjetivos ( )
{
 
    var Q_IDUNIDAD  =   $("#Q_IDUNIDADPADRE").val();
    var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
 
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
 };
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_MATRIZ_visor.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAMatrizOO").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
			     
			} 
    });

	
}
//-------------------
//---------------------
function VisorObjetivos ( )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDADPADRE").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();

     var estado1 =  $("#estado1").val();
    
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO ,
                'estado1':estado1
};
	  
	 
	$.ajax({
		data:  parametros1,
		 url:   '../model/Model-OO-POA_TAREA_S.php',
		type:  'GET' ,
			beforeSend: function () { 
					$("#ViewPOAMatrizOO").html('Procesando');
			},
		success:  function (data) {
				 $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
			     
			} 
  });
 

}
 
function ResumenPOA (tipo )
{

	
     var Q_IDUNIDAD =  $("#Q_IDUNIDADPADRE").val();
     var Q_IDPERIODO =  $("#Q_IDPERIODO").val();

     
	 var parametros1 = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
};
	  

if ( tipo == 1){

            $.ajax({
                data:  parametros1,
                url:   '../model/Model-OO-POA_TAREA_U.php',
                type:  'GET' ,
                    beforeSend: function () { 
                            $("#ViewPOAMatrizOO").html('Procesando');
                    },
                success:  function (data) {
                        $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
                        
                    } 
        });
 
}

        if ( tipo == 2){

                    $.ajax({
                        data:  parametros1,
                        url:   '../model/Model-OO-POA_TAREA_O.php',
                        type:  'GET' ,
                            beforeSend: function () { 
                                    $("#ViewPOAMatrizOO").html('Procesando');
                            },
                        success:  function (data) {
                                $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
                                
                            } 
                });

        }


        
        if ( tipo == 3){

            $.ajax({
                data:  parametros1,
                url:   '../model/Model-OO-POA_TAREA_P.php',
                type:  'GET' ,
                    beforeSend: function () { 
                            $("#ViewPOAMatrizOO").html('Procesando');
                    },
                success:  function (data) {
                        $("#ViewPOAMatrizOO").html(data);  // $("#cuenta").html(response);
                        
                    } 
        });

}


}
 
 