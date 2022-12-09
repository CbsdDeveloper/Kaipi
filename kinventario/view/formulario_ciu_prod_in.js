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
   
jQuery("#razon").focusout(function(){
	
	var itemVariable = $("#razon").val();  
	
			   var parametros = {
										   "itemVariable" : itemVariable 
								   };
									
								   $.ajax({
										   data:  parametros,
										   url:   '../model/AutoCompleteIDCIU.php',
										   type:  'GET' ,
										   beforeSend: function () {
											   $("#idprov").val('...');
										   },
										   success:  function (response) {
											   $("#idprov").val(response);  // $("#cuenta").html(response);
													 
										   } 
								   });
	
   });

//----------------------------------------------
	jQuery('#articulo').typeahead({
		 
		source:  function (query, process) {
			 
	   return $.get('../model/AutoCompleteProd_in.php', { query: query }, function (data) {
			   console.log(data);
			   data = $.parseJSON(data);
			   return process(data);
		   });
	   } 
   });

	  $("#articulo").focusin(function(){
		
		var itemVariable = $("#articulo").val();  
		
				   var parametros = {
											   "itemVariable" : itemVariable 
									   };
										
									   $.ajax({
											   data:  parametros,
											   url:   '../model/AutoCompleteIDProd.php',
											   type:  'GET' ,
											   beforeSend: function () {
												   $("#idproducto").val('...');
											   },
											   success:  function (response) {
												   $("#idproducto").val(response);  // $("#cuenta").html(response);

													if  (response > 0 ){
														 InsertaProducto();
													 }   
											   } 
									   });
		
	   });
 
 