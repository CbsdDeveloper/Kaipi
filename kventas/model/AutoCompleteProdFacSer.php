 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
  	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
    $query	= strtoupper ($_GET["query"]) .'%' ;
 
    
    $LEN = strlen($query);
    
    
    $sql = "SELECT   producto
					  FROM web_producto
					 where upper(producto) like ".$bd->sqlvalue_inyeccion('%'.$query,true)." AND
                        estado = 'S'  AND
                        tipo = ".$bd->sqlvalue_inyeccion('S',true).'  order by producto';
    
 
    $articulo = array();
	
    if ( $LEN > 6) {
        
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['producto']);
		    	
		    	$articulo[] =  $cnombre ;
		    	
		    }
		    
    }
		    
		    $n = count($articulo);
		    
		    if ( $n ==  0 ) {
		        
		        $articulo[] =  'NO EXISTE' ;
		        
		        
		    }else {
		        
		        $bd->libera_cursor($stmt);
		        
		    }
		        
 		    
		    echo json_encode($articulo);
 
    
		    
    
?>