<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
       
    $codigo = $_GET['id_departamento'];
    
    $anio   = $_SESSION['anio'];
    
    $memo   = $bd->__documento_secuencia($anio,'Memo',$codigo);
    
    
    echo $memo['documento'];
     
    
?>
