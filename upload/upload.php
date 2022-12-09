<?php
session_start( ); 
?>
<!DOCTYPE html>
<html>
<?php
    require '../kconfig/Db.class.php';    
 	require '../kconfig/Obj.conf.php';  
 
	$obj   = new objects;
	
 	$bd    = new Db ;
 
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
 	if  (isset($_GET['status'])) {
		
			 	$carpeta =  $_GET['file'] ;
		
				$archivo =  $_POST["userfile"];
     	
			    $filename = guarda_imagen('sas',$carpeta,$archivo,$bd  ); 
				
				$filename = trim($filename) ;
 	} 
 ?>
<head>
 <meta charset="utf-8">
   
    <link rel="shortcut icon" href="../app/kaipi-favicon.png">
   
    <link rel="stylesheet" href="../app/fontawesome/font-awesome.min.css"/>
        
    <link href="../app/dist/css/bootstrap.css" rel="stylesheet">
   
    <link href="../app/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    
    <!-- Ionicons -->
	<link href="../app/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../app/css/jquery-ui.min.css" type="text/css" />
      
    
   
   <link rel="stylesheet" href="../app/dist/css/bootstrap.min.css" />
    
   <link rel="stylesheet" href="../app/dist/css/dataTables.bootstrap.min.css" />
 
   
   <script type="text/javascript" src="../app/js/jquery-1.10.2.min.js"></script>
   
   <script src="../app/dist/js/bootstrap.min.js"></script>  
     
   <script src="../app/js/jquery.min.js"></script>  
 
<script type="text/javascript" src="../kconfig/kaipi.js"></script>

<script type="text/javascript">

 function retorna_valor(symbol) {
 
      var valor = document.getElementById(symbol).value;
      window.opener.document.getElementById('url').value = valor;
	  window.top.close(); 	 
	  window.close();
}
function url_query(url) {
 	     window.location= url ;
		 return true;
 } 
</script> 
</head>
<body>
	<div class="container" style="padding: 15px">
	 
	     <div class="panel panel-primary">
    
      			  <div class="panel-heading">Carga de archivos</div>
        
						<div class="panel-body">

							<form action="upload?status=ok&file=<?php echo $_GET['file'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
									   <div class="col-md-10" style="padding: 2px"> 
												<input name="userfile" type="file" id="userfile" class="btn btn-primary" >
									   </div>
								 
										<div class="col-md-10" style="padding: 2px"> 
											 <input type="submit" class="btn btn-info" value="Cargar"  />
									   </div>

										<div class="col-md-10" style="padding: 2px"> 
												<input name="enviar" type="button" class="btn btn-info" value="copiar" onClick="javascript:retorna_valor('archivo_file')" />
									   </div>
									   
									   <div class="col-md-10" style="padding: 2px"> 
												<input name="archivo_file" type="text" class="form-control" id="archivo_file" autocomplete="off" value="<?php 
													global $filename ;
													echo str_replace('"', '&quot;', trim($filename)); 
													?>" size="60" readonly />
									   </div>
									   
									   
						       </form>       
        	           </div>  
		 </div>  	
		 			  
   	</div>  				  
 		
 </body>
</html> 

<?php
   function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd   ){
 		
	   	 global $filename;

		 
        	$folder    		  = $bd->_carpeta_archivo($carpeta_variable); // carpeta parametrizada
  		     
        
 			echo 'Enviado '.$folder.' '.$carpeta_variable ;
  		
			$archivo_temporal = $_FILES["userfile"]['tmp_name'];
	   
			$archivo 		  = $_FILES["userfile"]['name'];
		
	   		$subir 			  = $_FILES["userfile"]['name'];
  			
		 
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder.$archivo); 
  		   
			if($copiado==false){ 
				
				return "error"; 
				
			}else{ 
				
			    return $subir;
				
			}
 	
		 
	}
?>