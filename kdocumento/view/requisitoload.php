<?php
session_start( );
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>

</head>
 
<body>
     <div class="modal-body"> 
                      	
                        	<H5>Carga de archivo de proceso</h5>
                            
                            <form action="requisitoload.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" id="fload1" accept-charset="UTF-8">
                             
                             <div class="col-md-12" style="padding-bottom:5px; padding-top:5px">
                             
                        		    <input type="file" id = 'userfile' name="userfile" class="filestyle" data-icon="true" accept="pdf/*" data-inputsize="medium">
							
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
 
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

$obj     = 	new objects;

$set     = 	new ItemsController;

$bd	   =	     	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

	
    $id = $_GET['id'];
	
	if (isset($_POST["file"]))	{
 
 		$valida = $_POST["file"];
		
		if ($valida  == 'ok') {

		    
		     $Afolder = $bd->query_array('wk_config','carpeta', 'tipo='.$bd->sqlvalue_inyeccion(61,true));
             $folder = $Afolder['carpeta'];
   			//$folder.$filename
			
			$archivo_temporal 	= $_FILES["userfile"]['tmp_name'];
			$subir 				= $_FILES["userfile"]['name'];
			$archivo 			= $bd->_file_random( $subir );
			//$archivo = $_FILES["userfile"]['name'];
			
  			
			$prefijo = substr(md5(uniqid(rand())),0,6);
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder.$archivo); 
  		   
			if($copiado==false){ 
 			
				$archivo = '-';
 			 
			}
			
			echo $archivo;
 
 	     
    	echo '<script type="text/javascript">
				      window.opener.document.getElementById("fileArchivo_'.$id.'").value="'.$archivo.'"
					  window.opener.document.getElementById("arc_'.$id.'").value="'.$archivo.'"
 			          window.close();
		  </script>'; 
		 
			
	}	
 }
?>