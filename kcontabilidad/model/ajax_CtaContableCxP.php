<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	

    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $anio_ejecuta = $_SESSION['anio'];
    $registro     = $_SESSION['ruc_registro'];
    
    
    $term	   =	$_GET["query"];
    $proveedor = array();
    $variable  = strtoupper($term).'%';
    
    $sql = "SELECT   detalle ,cuenta,aux
				  FROM co_plan_ctas
				  where  aux = 'N' AND 
                         tipo_cuenta <> 'B' and 
                         registro =".$bd->sqlvalue_inyeccion($registro,true)."  and
                         anio =".$bd->sqlvalue_inyeccion($anio_ejecuta,true)."  and
						 univel = 'S' and  estado = 'S' and 
                         upper(detalle) like ".$bd->sqlvalue_inyeccion($variable, true) ;
    
 
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
    	$cnombre =  trim($x['detalle']);
    	$proveedor[] =  $cnombre ;
    }
   
    
    echo json_encode($proveedor);
    
?>