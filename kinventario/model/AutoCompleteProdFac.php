<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
	$idbodega = $_SESSION['idbodega']  ;
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
	$query	= '%'.strtoupper ($_GET["query"]) .'%' ;
	
	$resultado = str_replace(" ", "%", $query);	

	
	$query = $resultado;
	
	$long = strlen($query);
    
	$sql = "SELECT   producto
				  FROM web_producto
				  where estado = 'S' and saldo > 0 and 
                        registro = ".$bd->sqlvalue_inyeccion($registro,true)." AND
                        idbodega = ".$bd->sqlvalue_inyeccion($idbodega,true)." and 
                        upper(producto) like ".$bd->sqlvalue_inyeccion($query,true)." 
                  order by producto";
	
 
	$articulo = array();
	$n = 0;
	
	if ( $long > 5 ){
	    
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		        $cnombre =  (trim($x['producto']));
		    	
		        $articulo[] =  strtoupper($cnombre );
		    	
		    }
		    
		    $n = count($articulo);
	}
		
 		    
	if ( $n ==  0 ) {
		        
		        $articulo[] =  'NO EXISTE' ;
		        
		        
	}
 		    
	echo json_encode($articulo);
 
	
   
    
?>
 
  