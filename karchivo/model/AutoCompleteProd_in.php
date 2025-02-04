<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	 
	$bd	   = 	new Db ;
	
	$registro = $_SESSION['ruc_registro'];
	
	$idbodega = $_SESSION['idbodega']  ;
	
 	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
 	$query	=	 '%'.strtoupper ($_GET["query"]) .'%' ;
  
 
	$sql = "SELECT   (producto ) as producto
				  FROM web_producto
				  where upper(producto) like ".$bd->sqlvalue_inyeccion($query,true)." AND 
                        estado = 'S' and   tipo = 'B' and
                        registro = ".$bd->sqlvalue_inyeccion($registro,true)." AND 
                        idbodega = ".$bd->sqlvalue_inyeccion($idbodega,true)."
                  order by producto";
	
 
  	 	 
	$articulo = array();
	
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['producto']);
		    	
		    	$articulo[] =  $cnombre ;
		    
		    }
		    
		    $n = count($articulo);
		    
		    if ( $n ==  0 ) {
		        
		        $articulo[] =  'NO EXISTE' ;
		        
		        
		    }
		    
		    
		    echo json_encode($articulo);
		    
 
		    pg_free_result($stmt);
   
    
?> 