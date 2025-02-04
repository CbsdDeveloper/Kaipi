<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	 
	$bd	   = 	new Db ;
	
 
	
 	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 	$query	=	 '%'.strtoupper ($_GET["query"]) .'%' ;
  
 
	$sql = "SELECT   clase  as producto
				  FROM  activo.ac_clase
				  where upper(clase) like ".$bd->sqlvalue_inyeccion($query,true)." 
                  order by clase";
 
  	 	 
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
 
  