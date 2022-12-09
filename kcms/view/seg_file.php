<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>

</head>
 
<body>
     <div class="modal-body"> 
                      	
                        	<H5>Carga de archivo de proceso</h5>
                            
                            <form action="seg_file?idfile=<?php  echo $_GET["idfile"]  ?> " method="POST" enctype="multipart/form-data" id="fload1" accept-charset="UTF-8">
                             
                             <div class="col-md-12" style="padding-bottom:5px; padding-top:5px">
                             
								 <input type="file" class="filestyle"  id = 'userfile' name="userfile" data-text="Open" data-input="true" data-iconName="glyphicon-plus" data-btnClass="btn-primary" accept="application/pdf">
								 
								 	  
							
                            </div>
                          
                            <div class="col-md-12" style="padding-bottom:5px; padding-top:5px">
                       		  <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-flash"></span> Cargar Informacion</button>
                             </div>
							 
							 <input name="file" type="hidden" id="file" value="ok"> 
 						   
                           </form> 
      </div>
 </body>
</html>
<?php
	
	if (isset($_POST["file"]))	{
 
 		$valida = $_POST["file"];
		
		if ($valida  == 'ok') {

     	  $folder = "../../archivos/";
   			//$folder.$filename
  		
			$archivo_temporal = $_FILES["userfile"]['tmp_name'];
			$archivo = $_FILES["userfile"]['name'];
			$subir = $_FILES["userfile"]['name'];
  			
			$prefijo = substr(md5(uniqid(rand())),0,6);
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder.$archivo); 
  		   
			if($copiado==false){ 
 				$archivo = 'NO';
 			}else{ 
 				$cargadatos = $archivo;
			}

			if ($_GET["idfile"] == 1){ 
				
				 echo '<script type="text/javascript">
				      window.opener.document.getElementById("documento_respaldo").value="'.$archivo.'"
			          window.close();
					</script>';
			}else{
				
 				  echo '<script type="text/javascript">
				      window.opener.document.getElementById("documento_digital").value="'.$archivo.'"
			          window.close();
					</script>';
			}	 
 
				
   			 
	}		
 }
?>