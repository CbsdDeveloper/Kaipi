<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = new Db ;
	$id     = $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $term	=	$_GET["query"];
    
    $variable = strtoupper($term).'%';
    
    $sql = "select razon
			  from par_ciu
			  where estado <> ".$bd->sqlvalue_inyeccion("N", true).' and
			  		razon like '.$bd->sqlvalue_inyeccion($variable, true) ;
    
    
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
    	$cnombre =  trim($x['razon']);
    	$proveedor[] =  $cnombre ;
    }
   
    $n = count($proveedor);
    
    if ( $n ==  0 ) {
        
        $proveedor[] =  'NO EXISTE' ;
        
        
    }
    
    
    echo json_encode($proveedor);
    
?>