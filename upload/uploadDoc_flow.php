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
		
				$archivo      =  trim($_POST["userfile"]);
		
				$archivo_file =  trim($_POST["archivo_file"]);
     	
			    $matriz        = guarda_imagen('sas',$carpeta,$archivo,$bd  ); 
				
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
 

<script type="text/javascript">

 function procesa_informacion(archivo_file) {
 
       var archivo_file = document.getElementById(archivo_file).value;
      
       var id = document.getElementById('idcaso').value;
 	 
       var detalle = document.getElementById('detalle').value;
     
     
	   var parametros = {
		 			    'archivo' : archivo_file  ,
                        'id' : id,
                        'detalle' : detalle
		     };
	 
				 if (archivo_file){
					 
						 if (detalle)  {

							   $.ajax({
											data:  parametros,
											 url:   'Model-crm_file.php',
											type:  'POST' ,
											cache: false,
											success:  function (data) {

													 opener.$("#ViewFormfile").html(data);  

												  var ventana = window.self;
												  ventana.opener = window.self;
												  ventana.close();


												} 
									});




						   } else {

							   alert('Ingrese detalle del documento');
						   }
				  } else {

							   alert('No cargo nombre del archivo');
						   }
			}
	  
 
</script> 
	
</head>
<body>
	<div class="container" style="padding: 15px">
	 
	     <div class="panel panel-primary">
    
      		 <div class="panel-heading">Carga de archivos</div>
        
				<div class="panel-body">

					<form action="uploadDoc_flow?status=ok&file=<?php echo $_GET['file'] ?>&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
						<div class="col-md-10" style="padding: 2px"> 
							<input name="userfile" type="file" id="userfile"  accept=".pdf,.jpg,.png,.zip,.rar" class="btn btn-primary" >
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
									   
                        <div class="col-md-10" style="padding: 1px" > 
						    <h5>2. Detalle documento</h5>
				        </div>
                        
                        <div class="col-md-10" style="padding: 1px" > 
						    <input type="text" class="form-control" name="detalle" id="detalle" value="<?php 
													global $archivo ;
													echo str_replace('"', '&quot;', trim($archivo)); 
													?>" >
				        </div>
                        
 						 <div id="procesado">  </div>
                        
                        <input type="hidden" id="idcaso" name="idcaso" value="<?php echo $_GET['id'] ?>">
						
						 <input type="hidden" id="folder1" name="folder1" >
									   
					 </form>      
                    
                     <div class="col-md-10" style="padding: 1px"> 
							 <input name="enviar" type="button" class="btn btn-danger" value="3. Guardar Informacion" onClick=" procesa_informacion('archivo_file')" />
					 </div>
                    
        	   </div>  
             
		 </div>  	
        
    </div>  				  
  </body>
</html> 
<?php
   function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd   ){
 	 
		  global $filename;
	
	    
		    $Afolder = $bd->query_array('wk_config','carpeta', 'tipo='.$bd->sqlvalue_inyeccion(61,true));
	
            $folder = trim($Afolder['carpeta']);

			$archivo_temporal 	= $_FILES["userfile"]['tmp_name'];
			$archivo 			= $_FILES["userfile"]['name'];
			$subir 			    = $_FILES["userfile"]['name'];
  			
			$prefijo 		  = substr(md5(uniqid(rand())),0,12);
	
			$len = strlen($archivo);
			$tipo_archivo	  =  substr($archivo,$len-3);
			$parte_archivo    =  substr($archivo,0,$len-4);
	
	
			$archivo          =   strtoupper(trim($parte_archivo )).' ( '.$tipo_archivo.' )' ;
			
        
            $filename = $parte_archivo.'.'.$tipo_archivo;
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder. $filename); 
	
	
			$matriz['filename'] = $filename;
			$matriz['archivo']  = $archivo;
			$matriz['folder']  = $archivo;
  		   
			if($copiado==false){ 
				return "error"; 
			}else{ 
			    return $matriz;
			}
 	
		 
	}
?>