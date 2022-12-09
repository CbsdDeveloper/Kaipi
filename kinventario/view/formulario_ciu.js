// JavaScript Document
 jQuery.noConflict(); 
 
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
	 jQuery('#chofer_vehiculo').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});



 jQuery('#idprov').typeahead({
	    source:  function (query, process) {
     return $.get('../model/AutoCompleteIDCedula.php', { query: query }, function (data) {
     		console.log(data);
     		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

	jQuery('#id_prov').typeahead({
	    source:  function (query, process) {
     return $.get('../model/AutoCompleteIDCedula.php', { query: query }, function (data) {
     		console.log(data);
     		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
  
 $("#razon").focusin(function(){
	 
	 		    var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
    									$.ajax({
    										    type:  'GET' ,
    											data:  parametros,
    											url:   '../model/AutoCompleteIDMultiple.php',
    											dataType: "json",
     											success:  function (response) {
    
     	 											
    													 $("#idprov").val( response.a );  
    													 
    													 $("#correo").val( response.b );  

    													 $("#id_par_ciu").val( response.c ); 

    													 $("#direccion").val( response.d ); 
    													 
    											} 
    									});
	 
    });


 $("#chofer_vehiculo").focusin(function(){
	 
	 		    var itemVariable = $("#chofer_vehiculo").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
    									$.ajax({
    										    type:  'GET' ,
    											data:  parametros,
    											url:   '../model/AutoCompleteIDMultiple.php',
    											dataType: "json",
     											success:  function (response) {
    
     	 											
    													 $("#idprov").val( response.a );  
    												 
    													 
    											} 
    									});
	 
    });
    
 $("#idprov").focusin(function(){
	 
	    var itemVariable = $("#idprov").val();  

		var parametros = {
									"itemVariable" : itemVariable 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/AutoCompleteIDMultipleID.php',
									dataType: "json",
									success:  function (response) {

										
											 $("#razon").val( response.a );  
											 
											 $("#correo").val( response.b );  

											 $("#id_par_ciu").val( response.c ); 

											 $("#direccion").val( response.d ); 
									} 
							});

});