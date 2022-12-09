var modulo1 =  'kdocumento'; 

$(document).ready(function(){
 
 	 
			var parametros = {
						'ViewModulo' : modulo1 
			};
			$.ajax({
					data:  parametros,
					url:   '../model/Model-moduloOpcion.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
								$("#ViewModulo").html('Procesando');
						},
					success:  function (data) {
							$("#ViewModulo").html(data);  
							
						} 
			});
	
			/*
			datos de control
			*/
			$.ajax({
				url: "../model/ajax_lista_doc.php",
				type: "GET",
			success: function(response)
			{
				$('#listaDoc').html(response);
			}  
			});


			$("#MHeader").load('../view/View-HeaderModelDoc.php');
	
			$("#FormPie").load('../view/View-pie.php');
			
			fecha_hoy();
	
	 
	 
});

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
  
    var inicio = yyyy + '-' + mm + '-01' ;
     
    var today = yyyy + '-' + mm + '-' + dd;
    
    document.getElementById('f1_v').value = inicio ;
    
    document.getElementById('f2_v').value = today ;
    
 
            
} 

/*
Lista Documentos filtrato por tipo de documento
*/

function HistorialDoc(tipodoc)
{
	
 	
 	 	var f1 = $("#f1_v").val();   
 		var f2 = $("#f2_v").val();   
 			

 
		  

	   var parametros = {
						'tipodoc' : tipodoc ,
						'f1':f1,
						'f2':f2
		  };
	   
		 $.ajax({
					   data:  parametros,
					   url:   '../model/ajax_lista_doc_tipo.php',
					   type:  'GET' ,
					   cache: false,
					   beforeSend: function () { 
								$("#Visor_documentos").html('Procesando');
						 },
					   success:  function (data) {
								$("#Visor_documentos").html(data);   
								
						 } 
			   }); 

} 