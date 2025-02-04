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
 
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 	if  (isset($_GET['status'])) {
		
			 	$carpeta =  $_GET['file'] ;
		
		 		$id = $_GET['id'] ;
			 
		
				$archivo      =  trim($_POST["userfile"]);
		
				$archivo_file =  trim($_POST["archivo_file"]);
     	
			    $matriz        = guarda_imagen('sas',$carpeta,$archivo,$bd,$id  ); 
				
				$filename = trim($matriz['filename']) ;
		
				$archivo  =  trim($matriz['archivo']) ;
		
	 
		
  
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
 
 
	
</head>
<body>
	<div class="container" style="padding: 15px">
	 
	     <div class="panel panel-primary">
    
      		 <div class="panel-heading">Carga de archivos</div>
        
				<div class="panel-body">

					<form action="uploadDoc_logo?status=ok&file=<?php echo $_GET['file'] ?>&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
						<div class="col-md-10" style="padding: 2px"> 
							<input name="userfile" type="file" id="userfile"  accept=".jpg,.png" class="btn btn-primary" >
				        </div>
								 
						<div class="col-md-10" style="padding: 2px"> 
							 <input type="submit" class="btn btn-info" value="1. Cargar Archivo"  />
						</div>

						
									   
						<div class="col-md-10" style="padding: 2px"> 
												<input name="archivo_file" type="text" class="form-control" id="archivo_file" autocomplete="off" value="<?php 
													global $filename ;
													echo str_replace('"', '&quot;', trim($filename)); 
													?>" size="60" readonly />
						</div>
									   
                        
                        
                       
                        
 						 <div id="procesado">  </div>
                        
                        <input type="hidden" id="idcaso" name="idcaso" value="<?php echo $_GET['id'] ?>">
						
 									   
					 </form>      
                    
                      
                    
        	   </div>  
             
		 </div>  	
        
    </div>  				  
  </body>
</html> 
<?php
   function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd ,$id  ){
 	 
		  global $filename;
	
	    
		    $Afolder = $bd->query_array('wk_config','carpeta', 'tipo='.$bd->sqlvalue_inyeccion(1,true));
	
            $folder = trim($Afolder['carpeta']);

			$archivo_temporal 	= $_FILES["userfile"]['tmp_name'];
			$archivo 			= $_FILES["userfile"]['name'];
			$subir 			    = $_FILES["userfile"]['name'];
  			
 	 
        
            $filename = trim($archivo) ;
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder. $filename); 
	
	
			$matriz['filename'] = $filename;
			$matriz['archivo']  = $archivo;
			$matriz['folder']  = $archivo;
  		   
			if($copiado==false){ 
				return "error"; 
			}else{ 
			    
				
				 $sql = "UPDATE flow.wk_proceso
				 		 SET imagen = " .  $bd->sqlvalue_inyeccion( $filename , true)." 
                   WHERE idproceso =" .  $bd->sqlvalue_inyeccion($id , true);
        										      
           		$bd->ejecutar($sql);
				
				
				return $matriz;
				
				
			}
 	
	
	
		 
	}
?>