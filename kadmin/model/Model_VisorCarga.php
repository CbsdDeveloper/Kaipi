<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	

	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $id = strtoupper($_GET['id']);
    
  
    
    $sql = "SELECT   cantidad,costo
				  FROM inv_movimiento_det
				  where idproducto  =".$bd->sqlvalue_inyeccion($id,true) ;
 
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim($dataProv['cantidad']), "b"=> trim($dataProv['costo']) )  );
    
 
  
    
?>