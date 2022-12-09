<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	

	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $sesion 	 =  trim($_SESSION['email']);

     
  
    
    $sql = "SELECT   rol
				  FROM par_usuario
				  where email  =".$bd->sqlvalue_inyeccion($sesion,true) ;
 
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
 

     echo json_encode( 
                        array( "a"=>trim($dataProv['rol']) ) 
                     );

  
    
?>