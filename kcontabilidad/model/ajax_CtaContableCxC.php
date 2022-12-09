<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	           = new Db ;
	
	$registro      = $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $anio_ejecuta = $_SESSION['anio'];
      
    $term	      =	$_GET["query"];
    
    $variable = strtoupper($term).'%';
    
    $sql = "SELECT   detalle ,cuenta,aux
				  FROM co_plan_ctas
				  where  aux = 'N' AND 
                         tipo_cuenta <> 'B' and 
                         anio =".$bd->sqlvalue_inyeccion($anio_ejecuta,true)."  and
                         registro =".$bd->sqlvalue_inyeccion($registro,true)."  and
						 univel = 'S' and  estado = 'S' and tipo = 'I' and 
                         detalle like ".$bd->sqlvalue_inyeccion($variable, true) ;
    
 
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
    	$cnombre =  trim($x['detalle']);
    	$proveedor[] =  $cnombre ;
    }
   
    
    echo json_encode($proveedor);
    
?>