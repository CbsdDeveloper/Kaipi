<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
    $tipo	=	$_GET["tipo"];
    
    if ( $tipo == '0') {
        
        $id	=	$_GET["id"];
        
        $sql = "DELETE FROM co_asientod_manual
				WHERE id_manual  =".$bd->sqlvalue_inyeccion($id, true);
        
        
        $bd->ejecutar($sql);
        
 
    }
    
    
?>
 
  