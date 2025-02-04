<?php   
session_start(); 
 
include ('../../kconfig/Db.class.php');   

include ('../../kconfig/Obj.conf.php'); 
	
$bd	   =	    new Db ;
   
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
$tipo  = $_GET['tipo'];
$visor = $_GET['visor'];
  

if ( trim($visor)  == '1'){

    $url =  $bd->_carpeta_archivo($tipo,1); // path archivos
    
 
}else{

    $url =  $bd->_carpeta_archivo($tipo); // path archivos
    
 
}
  
echo json_encode( array( "a"=>trim( $url) ) );
  
     
 ?>