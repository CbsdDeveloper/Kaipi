 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
 	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	$query	=	"'".strtoupper (trim($_GET["query"])) .'%'."'" ;
	
	$longitud = strlen($query);
	
	$n = 0;
    	
	if ( $longitud  > 5 ) {
	    
	       $idprov = array();

		    $sql = "SELECT  idprov 
					  FROM  par_ciu
					  WHERE estado = 'S' AND idprov  like ".$query." order by idprov";
					    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['idprov']);
		    	$idprov[] =  $cnombre ;
		    
		    }
		    
		    $n = count($idprov);
		    
	}
	
		 
		    
		    if ( $n ==  0 ) {
		        
		        $idprov[] =  'NO EXISTE' ;
		   
		        
		    }
		    
		 
		    echo json_encode($idprov);
 
    
   
    
?>
 
  