<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    
    
    $anio		=   $_GET["anio"];
    
      
    $_SESSION['anio'] = $anio;
    
  
    
    $sql = "select estado 
             from presupuesto.pre_periodo 
            where anio = ".$bd->sqlvalue_inyeccion($anio ,true) ;
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $estado_presupuesto  = trim($datos_sql['estado']);
    
    $_SESSION['periodo_presupuesto'] = $estado_presupuesto ;
    
    $response = $anio.' - '. $estado_presupuesto;
    
    echo $response;
     
 
    
?>