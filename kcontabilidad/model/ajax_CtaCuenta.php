<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	       = new Db ;
	
	$registro  = $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $term	            =	$_GET["query"];
    
    $anio_ejecuta       = $_SESSION['anio'];
    
    $variable           =  strtoupper(trim($term)).'%';
    
    $longitud           = strlen($variable);
    
    $txtcuenta          = array();
    
    
    if ($longitud > 2 ) {
    
        $sql = "SELECT   cuenta  
    				  FROM co_plan_ctas
    				  where registro =".$bd->sqlvalue_inyeccion($registro,true)."  and
                            anio =  ".$bd->sqlvalue_inyeccion($anio_ejecuta, true)."  and
                            UPPER(cuenta) like ".$bd->sqlvalue_inyeccion($variable, true)."  and
    						univel = 'S' and  
                            estado = 'S' "   ;
        
       
            
        $stmt = $bd->ejecutar($sql);
        
      
     
                while ($x=$bd->obtener_fila($stmt)){
                    
                    $cnombre =  trim($x['cuenta']);
                    
                    $txtcuenta[] =  $cnombre ;
                    
                }
        
        }
    
    $n = count($txtcuenta);
    
    if ( $n ==  0 ) {
        
        $txtcuenta[] =  'NO EXISTE' ;
        
        
    }
    
 
     echo json_encode($txtcuenta);
    
?>