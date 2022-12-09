 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = new Db ;
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $term	=	$_GET["term"];
    
    $variable = strtoupper($term).'%';
    
    $sql = "SELECT   razon
				  FROM par_ciu
				  where estado =".$bd->sqlvalue_inyeccion('S',true)."  and
					     UPPER(razon) like ".$bd->sqlvalue_inyeccion($variable, true).' ORDER BY RAZON' ;
    
 
    
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
    	$cnombre =  trim($x['razon']);
    	$proveedor[] =  $cnombre ;
    }
   
    
    echo json_encode($proveedor);
    
?>
 
  