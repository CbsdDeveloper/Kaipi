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
			require('../controller/Controller-ac_reval.php')  ;
			$gestion   = 	new componente;
	
			
		if  (isset($_POST['bien_tmp'])) {
			$gestion->guarda_nuevo($_POST); 
			
		 
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
                         url:   '../model/ajax_visor_reval.php',
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
 </script>	  
 
	
</head>
<body>

 
	    <div class="col-md-12" style="padding: 5px"> 
 	 
				<div class="panel panel-primary">
				  <div class="panel-heading"><b>TRAMITE DE REVALORIZACION</b></div>
						<div class="panel-body">
							<form action="ac_bienes_revalorizado?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="forma">
									 <div class="col-md-12"> 
												<?php 
													if  (isset($_GET['id'])) {
														
														$gestion->Formulario($_GET['id'],$_GET['action']); 
														
													} 
												?>
												<input type="hidden" id="bien_tmp" name="bien_tmp" value="<?php echo $_GET['id']; ?>">
									  </div>

									 <div class="col-md-12" align="center" style="padding-top: 20px"> 
											<input type="submit" class="btn btn-success" value="Guardar Informacion">
										 
										   <button type="button" class="btn btn-danger" onClick="visor();">Cerrar Ventana</button>
										 
									  </div>	 

							</form>

						</div>
				</div>
 
		</div>
  </body>
 
</html>
