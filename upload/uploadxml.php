<?php
session_start( ); 

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html>
<?php
    require '../kconfig/Db.class.php';    
 	require '../kconfig/Obj.conf.php';  
 
	$obj   = new objects;
	
 	$bd    = new Db ;
 
	//$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	$bd->conectar('postgres','db_kaipi','Cbsd2019');
	
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
 

<script type="text/javascript">

 function procesa_informacion(archivo_file) {
 
      var archivo_file = document.getElementById(archivo_file).value;
 	 
	   var parametros = {
		 			    'archivo' : archivo_file  
		     };
			  
		  	$.ajax({
		 			data:  parametros,
		 			 url:   'Model-xmlcompras.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado").html(data);   
		 				     
		 				} 
		 	});
	 
 
	/*  boton = window.opener.document.getElementById('load');
	 
	 boton.click();
	 
	 
 window.top.close(); 	 
	 
     window.close();
 */
	 
}
 
</script> 
</head>
<body>
	
	<div class="container" style="padding: 15px">
	 
	     <div class="panel panel-primary">
    
      			  <div class="panel-heading">Carga de archivos</div>
        
						<div class="panel-body">

							<form action="uploadxml?status=ok&file=<?php echo $_GET['file'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
									   <div class="col-md-10" style="padding: 2px"> 
												<input name="userfile" type="file" id="userfile"  accept=".xml" class="btn btn-primary" >
									   </div>
								 
										<div class="col-md-10" style="padding: 2px"> 
											 <input type="submit" class="btn btn-info" value="Cargar"  />
									   </div>

										<div class="col-md-10" style="padding: 2px"> 
												<input name="enviar" type="button" class="btn btn-info" value="Procesar" onClick="javascript:procesa_informacion('archivo_file')" />
									   </div>
									   
									   <div class="col-md-10" style="padding: 2px"> 
												<input name="archivo_file" type="text" class="form-control" id="archivo_file" autocomplete="off" value="<?php 
													global $filename ;
													echo str_replace('"', '&quot;', trim($filename)); 
													?>" size="60" readonly />
									   </div>
									   
									<div id="procesado">  </div>
									   
						       </form>       
        	           </div>  
		 </div>  	
		 			  
   	</div>  				  
 		
 </body>
</html> 
<?php
function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd   ){
 		
		
	   
	  /* 	   $ACarpeta = $bd->query_array('wk_config',
										'carpeta', 
										'tipo='.$bd->sqlvalue_inyeccion($carpeta_variable,true)
									   ); 
									   */
		   global $filename;
	       
		//$carpeta_variable
		//	$folder = trim($ACarpeta['carpeta']);
	    $folder = '../archivos/xml/';
	    // $folder = '/var/www/kaipi.cbsd.gob.ec/public_html/archivos/xml/';
		// print_r (sys_get_temp_dir());
	    // $file = '../archivos/'.$archivo ;
	    //$folder.$filename
			$archivo_temporal = $_FILES["userfile"]['tmp_name'];
			$archivo = $_FILES["userfile"]['name'];
			$subir = $_FILES["userfile"]['name'];
  			
			$prefijo = substr(md5(uniqid(rand())),0,6);
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder.$archivo); 
			if($copiado==false){ 
				return "error"; 
			}else{ 
			    return $subir;
			}
 	
		 
	}
?>