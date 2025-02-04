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
		
				$archivo =  @$_POST["userfile"];
     	
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
 

<script type="text/javascript">

 function procesa_informacion(archivo_file) {
 
       var archivo_file = document.getElementById(archivo_file).value;
       var id 			= document.getElementById('prov').value;
 	   var detalle 		= document.getElementById('detalle').value;
     
     
	   var parametros = {
		 			    'archivo' : archivo_file  ,
                        'id' : id,
                        'detalle' : detalle
		     };
		
		 if (detalle)  {

			   $.ajax({
							data:  parametros,
							 url:   'Model-nom_doc.php',
							type:  'POST' ,
							cache: false,
							success:  function (data) {

									 opener.$("#ViewFormfile").html(data);  

 								     window.top.close(); 	
								} 
					});


		   } else {

			   alert('Ingres detalle del documento');
		   }
	 
}
 
</script> 
	
</head>
<body>
	
	<div class="container" style="padding: 15px">
	 
	     <div class="panel panel-primary">
    
      		 <div class="panel-heading">Carga de archivos</div>
        
				<div class="panel-body">

					<form action="uploadDoc?status=ok&file=<?php echo $_GET['file'] ?>&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
						<div class="col-md-10" style="padding: 2px"> 
							<input name="userfile" type="file" id="userfile"  accept=".pdf"  >
				        </div>
								 
						<div class="col-md-10" style="padding: 5px"> 
							
							 <button type="submit" class="btn btn-success">
												<span class="glyphicon glyphicon-cloud-upload"></span> 1. Cargar archivo
											  </button>
							
 						</div>

						
									   
						<div class="col-md-10" style="padding: 2px"> 
												<input name="archivo_file" type="text" class="form-control" id="archivo_file" autocomplete="off" value="<?php 
													global $filename ;
													echo str_replace('"', '&quot;', trim($filename)); 
													?>" size="60" readonly />
						</div>
						
									   
                        <div class="col-md-10" style="padding: 1px"> 
							
						    <h6>2. Detalle documento</h6>
							
				        </div>
                        
                        <div class="col-md-10" style="padding: 2px"> 
						    <input type="text" class="form-control" name="detalle" id="detalle">
				        </div>
                        
 						 <div id="procesado">  </div>
                        
                         <input type="hidden" id="prov" name="prov" value="<?php echo $_GET['id'] ?>">
									   
					 </form>      
                    
                     <div class="col-md-10" style="padding: 1px"> 
						 
						  <button type="button" name="enviar"  id="enviar"  class="btn btn-info" onClick="procesa_informacion('archivo_file')">
												<span class="glyphicon glyphicon-paste"></span> 3. Guardar Informacion
											  </button>
						 
						 
 					 </div>
                    
        	   </div>  
             
		 </div>  	
        
    </div>  				  
  </body>
</html> 

<?php
   function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd   ){
 	 
		  global $filename;
	   
			$folder    		  = $bd->_carpeta_archivo('62'); // carpeta parametrizada
	
 	
     	
			$archivo_temporal = $_FILES["userfile"]['tmp_name'];
			$archivo 		  = $_FILES["userfile"]['name'];
			$subir 			  = $_FILES["userfile"]['name'];
  			
			$prefijo 		  = substr(md5(uniqid(rand())),0,12);
            $filename 		  = $prefijo.'.pdf';
		   
		    $copiado 		  = move_uploaded_file($archivo_temporal,$folder. $filename); 
  		   
			if($copiado==false){ 
				echo '<div class="alert alert-danger">  <strong>Error!</strong>'."Not uploaded because of error #".$_FILES["userfile"]["error"].'</div>';
				return "error"; 
			}else{ 
				echo '<div class="alert alert-success">  <strong>Success!</strong> El archivo se subio correctamente.</div>';
			    return $filename;
			}
 	
		 
	}
?>