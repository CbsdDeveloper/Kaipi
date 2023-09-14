<?php
session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  
		    require('Head.php')  ;
	
			require('../controller/Controller-ac_novedad.php')  ;
	
			$gestion   = 	new componente;
	
			
				if  (isset($_POST['bien_tmp'])) {

					$gestion->guarda_nuevo($_POST); 


					echo '<div class="alert alert-success">
						  <strong>ADVERTENCIA!</strong> LOS DATOS SE ENCUENTRAN ACTUALIZADOS... <b>VERIFIQUE LA INFORMACION QUE INDICA EL SISTEMA</b>
						</div>';

				} 
	
	
 	?> 
  <script> 
	  
  function visor()
{
	
  	 var variable    = $('#bien_tmp').val();
 		 
	 var parametros = {
			    'id' : variable
   	 };
	  
	  
	  $.ajax({
                        data:  parametros,
                         url:   '../model/ajax_visor_novedad.php',
                        type:  'GET' ,
                        cache: false,
                        success:  function (data) {
  
									  opener.$("#ViewFormReval").html(data);  
									  var ventana = window.self;
									  ventana.opener = window.self;
									  ventana.close();
                            } 
                });
    

}
/*
*/
function selecciona_tipo(tipo)
{
 
 		 
  var parametros = {
 			    'tipo' : tipo
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/ajax_selecciona_tipo_e.php',
			type:  'GET'  ,
			success:  function (data) {
					 $("#lclase").html(data);  
				     
					 $("#clase").val('');  
					 $("#clasificador").val('');  
					 $("#clase_esigef").val('');  
					 $("#cuenta").val('-');  
				} 
	});
     

}
/*
*/

function open_spop_marca(url,ovar,ancho,alto) {

	var posicion_x; 

	var posicion_y; 

	var enlace; 

	var tipo = $("#tipo_bien").val();
	 
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 

	enlace = url +'?tipo='+tipo;

	window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');



}
 </script>	  
 
	
</head>
<body>

 
	    <div class="col-md-12" style="padding: 5px"> 
 	 
				<div class="panel panel-primary">
				  <div class="panel-heading"><b>REGISTRAR NOVEDADES DEL BIEN</b></div>
						<div class="panel-body">
							
							<form action="ac_bienes_novedad?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="forma">
								
									 <div class="col-md-12"> 
												<?php 
													if  (isset($_GET['id'])) {
														
														$gestion->Formulario($_GET['id'],$_GET['action']); 
														
													} 
												?>
												<input type="hidden" id="bien_tmp" name="bien_tmp" value="<?php echo $_GET['id']; ?>">
									  </div>

									 <div class="col-md-12" align="center" style="padding-top: 20px"> 
										 
											<input type="submit" class="btn btn-success" value="Guardar Informacion (*)">
										 
  										 
										   <button type="button" class="btn btn-danger" onClick="visor();">Cerrar Ventana</button>
										 
									  </div>	 

							</form>

						</div>
				</div>
 
		</div>
  </body>
 
</html>
