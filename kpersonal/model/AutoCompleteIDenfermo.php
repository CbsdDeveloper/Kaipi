<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
 
    
    $sql = "SELECT   id_enfermedad
				  FROM medico.me_enfermedad
				  where upper(detalle) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
  
 
  
    $resultado1 = $bd->ejecutar($sql);
    
    $x  = $bd->obtener_array( $resultado1);
    
    $prov = trim($x['id_enfermedad']);
 
    
    echo json_encode( array("a"=>$prov   )     );
    
     
    
?>