<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $anio      = $_SESSION['anio'];
    
    $ruc       =  trim($_SESSION['ruc_registro']);
    
    
    $sql = "select estado 
             from presupuesto.pre_periodo 
            where anio = ".$bd->sqlvalue_inyeccion($anio ,true). ' and 
                  registro='.$bd->sqlvalue_inyeccion($ruc ,true);
    
    $resultado1 = $bd->ejecutar($sql);
     $datos_sql  = $bd->obtener_array( $resultado1);
    
    $estado_presupuesto  = trim($datos_sql['estado']);
    
    $_SESSION['periodo_presupuesto'] = $estado_presupuesto ;
    
    $response = json_encode($estado_presupuesto);
    
    echo $response;
     
 
    
?>