 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
	// $_SESSION['idmarca']
	
	
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	$idbodega = $_SESSION['idbodega']  ;
	
	
	$query	= '%'.strtoupper ($_GET["query"]) .'%' ;
	
//	$resultado = str_replace(" ", "%", $query);
 	
	$sql = "SELECT   nombre   || ' '  || trim(codigo) as producto
					  FROM view_producto
					 where upper(cadena) like ".$bd->sqlvalue_inyeccion($query,true)." AND
                           registro = ".$bd->sqlvalue_inyeccion($registro,true) ;
	 
 	    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		    	$cnombre =  trim($x['producto']);
		    	$articulo[] =  $cnombre ;
		    }
		    
		    $n = count($razon);
		    
		    if ( $n ==  0 ) {
		        
		        $articulo[] =  'NO EXISTE' ;
		        
		        
		    }
 		    
		    echo json_encode($articulo);
 
    
   
    
?>
 
  