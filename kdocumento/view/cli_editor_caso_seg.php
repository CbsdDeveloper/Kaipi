<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  
 		require('Head.php')  
     ?> 
	
	  <script src="https://cdn.tiny.cloud/1/64dwu8dg3zi9xhhs2flfk6a7dd0fw3779qwtvovj7dc0d4e3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	
 	
	   <script language="javascript" src="../js/cli_editor_caso_seg.js"></script>;
	 
	   <script>
														 
															tinymce.init({ 
																  selector: 'textarea',
																 language: "es"	  ,
 																  height: 580,
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
 																 toolbar_mode: 'floating'

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
 
</head>

<body>
	 
	<div class="col-md-12" style="padding: 10px"> 
	
		<form action="../model/Model-addDoc02.php" method="post" enctype="application/x-www-form-urlencoded" id="Formdoc" accept-charset="UTF-8">
 
  
											 <div class="col-md-12"> 	
																 
												 	<div class="col-md-9"> 	
			   				   	 										<div id="docu"></div>		
			   										</div>	
													
												 	<div class="col-md-3"> 	
 																	  <div id="docu_par"></div>	
 																	  <div id="docu_serie" style="padding-top: 15px;padding-bottom: 15px"> </div>	
 																	  <div id="serie_mensaje"> </div>	
  													</div>		
											  </div>	
			   
											  <div class="col-md-12" style="padding: 20px"> 
															   
												<input name="botonPlantilla" type="button" onClick="CargaPlantilla();" class="btn btn-sm btn-info" id='botonPlantilla' value="Cargar Plantilla">
												 
												  
												 <input name="idbotDoc" type="submit" class="btn btn-sm btn-warning" id='idbotDoc' value="Guardar Documento">
												  
												  
												  	<button type="button" class="btn btn-sm btn-warning" title="Actualizar informacion del documento" onClick="formato_documento()" > <span style="font-size:13px;cursor:pointer">⛭</span> </button>
												  
												  
												 <input type="button" onClick="formato_doc_visor()" class="btn btn-sm btn-default"   value="Impresion Documento">

													 <div class="btn-group">
												  		<button type="button" class="btn btn-succes btn-sm dropdown-toggle" data-toggle="dropdown">
												  			<b>Generar/Bloquear Documento </b><span class="caret"></span></button>

														  <ul class="dropdown-menu" role="menu">
															<li><a onClick="goToURLDocBloqueaUser(1)" href="#">Generar Sin Firma Electronica</a></li>
															<li><a onClick="goToURLDocBloqueaUser(2)" href="#">Generar Con Firma Electrónica</a></li>

														  </ul>
													</div>
											 
 															   
											 </div>
 
			
 						  			   		  <div class="col-md-12"> 		
 												
												  
											 
 								     				  <textarea cols="80" id="editor1" name="editor1" rows="5" >   </textarea>
									
 											
								    				 <div align="center" style="padding: 10px;font-size: 15px;font-weight: 500" id="result_Doc"></div>	
 									
					 	 				</div>
 								
 
			
	   <input type="hidden" id="idproceso" name="idproceso" value="21">
	   <input type="hidden" id="idtarea" name="idtarea" value="2">
	   <input type="hidden" id="idcaso" name="idcaso" value ="0" >
	   <input type="hidden" id="idcasodoc" name="idcasodoc" value = "0">	
	   <input type="hidden" id="accion" name="accion" value="add">
	  <input type="hidden"  id="docpone" name="docpone" value="">		
			
 			
	  </form>
		
  </div>
	 
	   <script language="javascript">// <![CDATA[

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
								
								$('#accion').val('edit');
								
								
								let text      	 = data;
								const myArray 	 = text.split("-");
								var idcasodoc    = myArray[1]; 		
								let result 		 = idcasodoc.trim();
 								
								jQuery('#result_Doc').html(data);
								
								jQuery('#idcasodoc').val(result);
								
								$('#idcasodoc').val(result); 
								
								alert('Informacion guardada con exito...');
								
				 
 								
								ActualizaDato( idcasodoc)  ;
								
							}
						})        
						return false;
					}); 
				})
		   
		   
		   
		    function ActualizaDato( idcasodoc) {

				
				 

		 			var idcasodoc     = $('#idcasodoc').val();
					var editor1      = $('#editor1').val();
					 

				  var parametros = {
									'idcasodoc' : idcasodoc ,
									'editor1' : editor1 
					  };
					  $.ajax({
									data:  parametros,
									url:   '../model/ajax_editor_actualiza.php',
									type:  'POST' ,
 									success:  function (data) {
											 $("#result_Doc").html(data);   

									} 
							}); 
  		
				 }
		   /**/
		    function formato_documento(  ) {

				
						var   id   		 =  $("#idcaso").val();
					 	var   codigo 	=  $("#idcasodoc").val();
				
				  
				
						var parametros1 =  {
 										   'codigo' : codigo,
										   'idproceso': '21',
										   'idcaso': id
										};


										 $.ajax({
										  type:  'GET' ,
										  data:  parametros1,
										  url:   '../model/carga_editor_doc_ver.php',
										  dataType: "json",
										  success:  function (response) {

												tinyMCE.get('editor1').setContent( response.a );

										  } 
									  });
 

				 }
		 // ]]></script>
	 
	 
	 <div class="modal fade" id="myModalCorreo" role="dialog">
	  
       <div class="modal-dialog" id="mdialTamanioWeb">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Configuracion Firma Electronica</h4>
        </div>
        <div class="modal-body" style="font-size:11px;padding: 1px">
			 
			
					  <div style="padding: 1px" id="perfilUserWeb"> .</div>

					   <div align="center" id="ResultadoUserWeb"> </div>

						<input type="hidden" id="archivo" name="archivo">
					</div>
		  
        <div class="modal-footer">
		  <button type="button" class="btn btn-warning" onClick="Firma_electronica_fin()">Firmar Documento</button>	
		 	
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 
 
  
  
 </body>
</html>
