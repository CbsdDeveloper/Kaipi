<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  
 		require('Head.php')  
     ?> 
   
	    <script language="javascript"> 
 
		   $(document).ready(function(){
				 
 			    var   idcaso    =  getParameterByName('caso');
 
			     $("#idcaso").val(idcaso);
 			   
				  var parametros = {
					  	   'idcaso': idcaso
					};
 
			
				    $.ajax({
							data:  parametros,
							url:   '../controller/Controller-formatoDoc_ver.php',
							type:  'GET' ,
							cache: false,
 							success:  function (data) {
									 $("#docu").html(data);  // $("#cuenta").html(response);

								} 
					}); 
			   
			   		//------------------------------------------------
			      /*
				  
				   var parametros1 = {
						   'tipo': tipo,
						   'codigo' : codigo,
						   'idproceso': idproceso,
						   'idtarea': idtarea,
					  	   'idcaso': idcaso
					};
					
			   		$.ajax({
								    type:  'GET' ,
									data:  parametros1,
								    url:   '../model/carga_editor_doc.php',
									dataType: "json",
									success:  function (response) {
 	 
									      tinyMCE.get('editor1').setContent( response.a );
											  
									} 
							});
			   */
			   
		   			});  
		   
		   function getParameterByName(name) {
				name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
				results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		   	}
 
		   function Finalizar() {        
			   	 
			   			   opener.window.location.reload(); 

 						   window.close();
		   	}
		 
		   //---------------------------------------------
		   function CargaPlantilla() {  
			   
			     var   idplantilla = $("#plantilla").val();
 			     var   idproceso = $("#idproceso").val();
			     var   idtarea = $("#idtarea").val();
			     var   idcaso = $("#idcaso").val();
 			   
 
			   
			     var parametros = {
						   'idplantilla': idplantilla,
					 	   'idproceso' :idproceso,
						   'idtarea' : idtarea,
						   'idcaso' : idcaso
					};
 			   
			    	$.ajax({
								    type:  'GET' ,
									data:  parametros,
								    url:   '../model/carga_plantilla.php',
									dataType: "json",
									success:  function (response) {
 	 
									      tinyMCE.get('editor1').setContent( response.a );
										
										alert('Planitilla cargada al editor de texto')
											  
									} 
							});
	 	   
		      	}	   
		 
		   //---------------------------------------------DocumentoUsuario
 
		  function  DocumentoUsuario( tipo  ) {
 
				var parametros = {
						   'tipo': tipo
					};

				$.ajax({
						type:  'GET' ,
						data:  parametros,
						url:   '../model/Valida_tipo_documento.php',
						dataType: "json",
						success:  function (response) {


								 $("#documento").val( response.a);  
								 $("#tipoDoc").val( tipo);  
								 $("#secuencia_dato").val( response.b);  
							
 
		  
							
							     ListaModelo(tipo) ;
 
						} 
				});

		  	}
			
		  function ListaModelo(tipo) {

				 var parametros = {
							 'tipo'  : tipo  
				  };

					 $.ajax({
						 data:  parametros,
						 url: "../model/Valida_tipo_plantilla.php",
						 type: "GET",
					   success: function(response)
					   {
						   $('#plantilla').html(response);
					   }
					 });

	
	 
}
 
		 
 	   </script>
 	 
<style type="text/css">  
			
	 .form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding-top: 4px;
    padding-right: 10px;
    padding-left: 10px;
    padding-bottom: 4px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #000000;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
 
</style>	
 
</head>

<body>
	
	<div class="col-md-12" style="padding: 15px"> 
   
		
			 
					<form action="../model/Model-addDoc_tramite.php" method="post" enctype="application/x-www-form-urlencoded" id="Formdoc" accept-charset="UTF-8">
						
			  		       
  
									  <div class="col-md-12"> 	
 			   				   	 										<div id="docu"></div>		
 														   </div>	
			   
									  <div class="col-md-12" style="padding: 20px"> 
															   
															   	 <input name="botonPlantilla" type="button" onClick="CargaPlantilla();" class="btn btn-sm btn-warning" id='botonPlantilla' value="Cargar Plantilla">
 															   
															 </div>
 												 
  	 								  <script type="text/javascript" src="../../tinymce/tinymce.min.js"></script>
											
 	 							      <script>
														 
														tinymce.init({ 
															  selector: 'textarea',
															  height: 390,
																plugins: [
																"advlist autolink lists link image charmap print preview anchor",
																"searchreplace visualblocks code fullscreen",
																"insertdatetime media table contextmenu paste"
															],
															 toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect link image | fontselect",
															 relative_urls: false,
															menubar: true,
															image_advtab: true,
															visual : false,
															 remove_script_host : false,
															 file_browser_callback: openKCFinder

													     });
  		
														function openKCFinder(field_name, url, type, win) {
																tinyMCE.activeEditor.windowManager.open({
																 file: '../../keditor/kcfinder/browse.php?opener=tinymce4&field=' + field_name + '&type=' + type,
															 //	file: '../../keditor/ckfinder/ckfinder.html',
																	title: 'KCFinder',
																	width: 750,
																	height: 400,
																	resizable: true,
																	inline: true,
																	close_previous:  false
																}, {
																	window: win,
																	input: field_name
																});
																return false;
          											}
   												  </script> 
											
									  <div class="col-md-12"> 
												
 								     				 		  <textarea cols="80" id="editor1" name="editor1" rows="5" >   </textarea>
														  
													   </div>
									
									  <div class="col-md-12" style="padding: 10px"> 
   
															   		<input name="idbotDoc" type="submit" class="btn btn-sm btn-info" id='idbotDoc' value="Guardar Documento">
   
																	 <button type="button" class="btn btn-sm btn-danger" id='salirtarea' onClick="Finalizar();">Salir</button>
															
															         <div align="center" style="padding: 10px" id="result_Doc"></div>	
														</div>
 					 	 			
 								
 								 
					  		 
						
				    </form>		
					
			 <input type="hidden" name ='sec' id="sec" value=0>
 		
  </div>
	
	 
 <script language="javascript">
	 // <![CDATA[

				jQuery.noConflict(); 
				
				jQuery(document).ready(function() {
				   // Esta primera parte crea un loader no es necesaria
					jQuery().ajaxStart(function() {
 						jQuery('#result_Doc').hide();
					}).ajaxStop(function() {
 						jQuery('#result_Doc').fadeIn('slow');
					});
				   // Interceptamos el evento submit
					jQuery('#Formdoc').submit(function() {
				  // Enviamos el formulario usando AJAX
						jQuery.ajax({
							type: 'POST',
							url: jQuery(this).attr('action'),
							data: jQuery(this).serialize(),
							// Mostramos un mensaje con la respuesta de PHP
							success: function(data) {
								jQuery('#result_Doc').html(data);
								
								var name = data;
								var codigo   = name.trim();
 								jQuery('#casoid').val( codigo );
								
								var id = jQuery('#sec').val( );
								
								if (id == '0'){
										alert('Actualizado documento... presione para actualizar....');
									    jQuery('#sec').val( '1') ;
									}
								else{
										alert('Documento Actualizado con exito...');
									    
										opener.window.location.reload(); 

 						   				window.close();
									}
							}
						})        
						return false;
					}); 
				})
		 // ]]>
	</script>
 
	 
 
  
  
 </body>
</html>
