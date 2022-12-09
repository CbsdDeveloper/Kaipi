<?php 
session_start( );  

$archivo_temporal = $_FILES["userfile"]['tmp_name'];

$archivo 		  = trim($_FILES["userfile"]['name']);

$subir 			  = trim($_FILES["userfile"]['name']);


$folder = '../../kdocumento/reportes/';

 
$copiado = move_uploaded_file($archivo_temporal,$folder.$archivo);

if($copiado==false){
    
    echo $folder.$archivo." error ".$subir ;
    
}else{
    
    echo trim($subir);
    
}
?>
  
  