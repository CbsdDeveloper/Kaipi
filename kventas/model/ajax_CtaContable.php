<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
	$anio       =  $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
     
    
    $term	=	$_GET["query"];
    
    $variable = '%'.strtoupper(trim($term)).'%';
    
    $longitud = strlen($variable);
    
    $txtcuenta = array();
    
    if ($longitud > 5 ) {
    
        $sql = "SELECT   detalle || ' (' || cuenta || ')'  AS detalle  
    				  FROM co_plan_ctas
    				  where registro =".$bd->sqlvalue_inyeccion($registro,true)."  and
                            UPPER(detalle) like ".$bd->sqlvalue_inyeccion($variable, true)."  and
                            anio =  ".$bd->sqlvalue_inyeccion($anio, true)."  and
    						univel = 'S' and  
                            estado = 'S' "   ;
        
       
            
        $stmt = $bd->ejecutar($sql);
       
     
                while ($x=$bd->obtener_fila($stmt)){
                    
                    $cnombre =  trim($x['detalle']);
                    
                    $txtcuenta[] =  $cnombre ;
                    
                }
        
        }
    
    $n = count($txtcuenta);
    
    if ( $n ==  0 ) {
        
        $txtcuenta[] =  'NO EXISTE' ;
        
        
    }
    
 
     echo json_encode($txtcuenta);
    
?>
 
  