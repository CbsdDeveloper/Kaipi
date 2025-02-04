<?php
session_start(); 
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
      
       var id = document.getElementById('prov').value;
 	 
       var detalle = document.getElementById('detalle').value;
     
	   var fecha_val = document.getElementById('fecha_val').value;
	 
     
	   var parametros = {
		 			    'archivo' : archivo_file  ,
                        'id' : id,
                        'detalle' : detalle,
		   				'fecha_val' : fecha_val
		     };
		
       if (detalle)  {
     
				 if ( fecha_val){
				   $.ajax({
								data:  parametros,
								 url:   'Model-nom_doc_chofer.php',
								type:  'POST' ,
								cache: false,
								success:  function (data) {

										 opener.$("#ViewFormfile").html(data);  

										  var ventana = window.self;
									          ventana.opener = window.self;
									          ventana.close();
									
									

									} 
						});
				 }else {

				   alert('Ingres detalle del documento');
				 }
    
       } else {
        
           alert('Ingres detalle del documento');
       }
	 
}
 
</script> 
	
</head>
<body>
	
<div class="col-md-12" style="padding: 5px"> 
	 
	     <div class="panel panel-primary">
    
      		 <div class="panel-heading">Carga de Documentos</div>
        
				<div class="panel-body">

					<form action="uploadChofer?status=ok&file=<?php echo $_GET['file'] ?>&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
						
						<div class="col-md-12" style="padding: 2px"> 
 									<input name="userfile" type="file" id="userfile"  accept=".pdf" class="btn btn-default" >
  						</div>
						<div class="col-md-12" style="padding: 2px"> 
 						 	<input type="submit" class="btn btn-info" value="1. Cargar Archivo"  />
						  </div>	
						
						<div class="col-md-12" style="padding: 2px"> 
 												<input name="archivo_file" type="text" class="form-control" id="archivo_file" autocomplete="off" value="<?php 
													global $filename ;
													echo str_replace('"', '&quot;', trim($filename)); 
													?>" size="60" readonly />
						</div>
  									   
                        <div class="col-md-12" style="padding: 1px"> 
						    <h6>2. Detalle documento</h6>
				        </div>
                        
						 <div class="col-md-12" style="padding: 1px"> 
							    <div class="col-md-2" align="right" style="padding:6px"> 
									Detalle Documento
								</div>	
								<div class="col-md-10"  style="padding: 1px"> 
									<input type="text" class="form-control" name="detalle" id="detalle" placeholder="Nombre documento">
								</div>
							 
							   <div class="col-md-2"  align="right" style="padding:6px"> 
									Fecha Validez
								</div>
							 
							    <div class="col-md-10" style="padding: 1px"> 
									<input type="date" class="form-control" name="fecha_val" id="fecha_val"  placeholder="Fecha validez">
								</div>
							 
						 </div>
						
                        
 						 <div id="procesado">  </div>
                        
                        <input type="hidden" id="prov" name="prov" value="<?php echo $_GET['id'] ?>">
									   
					 </form>      
                    
                     <div class="col-md-10" style="padding: 1px"> 
							 <input name="enviar" type="button" class="btn btn-info" value="3. Guardar Informacion" onClick=" procesa_informacion('archivo_file')" />
					 </div>
                    
        	   </div>  
             
		 </div>  	
        
    </div>  				  
  </body>
</html> 
<?php
   function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd   ){
 	 
		  global $filename;
	   
 	      $folder = '../archivos/doc/';
   	
			$archivo_temporal = $_FILES["userfile"]['tmp_name'];
			$archivo = $_FILES["userfile"]['name'];
			$subir = $_FILES["userfile"]['name'];
  			
			$prefijo = substr(md5(uniqid(rand())),0,12);
       
            $filename = $prefijo.'.pdf';
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder. $filename); 
  		   
			if($copiado==false){ 
				return "error"; 
			}else{ 
			    return $filename;
			}
 	
		 
	}
?>