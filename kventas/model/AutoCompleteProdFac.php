<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
	$idbodega = $_SESSION['idbodega']  ;
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	$query	    = '%'.strtoupper ($_GET["query"]) .'%' ;
 	$resultado  = str_replace(" ", "%", $query);	

	
	$query = $resultado;
    
	$sql = "SELECT   producto
				  FROM web_producto
				  where upper(producto) like ".$bd->sqlvalue_inyeccion($query,true)." AND
                        estado = 'S' and saldo > 0 and 
                        registro = ".$bd->sqlvalue_inyeccion($registro,true)." AND
                        idbodega = ".$bd->sqlvalue_inyeccion($idbodega,true)."
                  order by producto";
	
 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre    =  trim($x['producto']);
		    	$articulo[] =  $cnombre ;
		    	
		    }
		    
		    $n = count($articulo);
		    
		    if ( $n ==  0 ) {
		        
		        $articulo[] =  'NO EXISTE' ;
 		      
		        
		    }else{
		        
		        pg_free_result($stmt);
		        
		    }
		        
  		    
		    echo json_encode($articulo);
 
    
   
    
?>
  