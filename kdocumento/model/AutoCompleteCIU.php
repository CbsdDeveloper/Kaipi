 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = 	new Db ;
	
 
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    
	$nombre = strtoupper ($_GET["query"]);
	
	$query	=	"'".$nombre .'%'."'" ;
	
	$long =  strlen($query); 
	
	$razon = array() ;
    
	if ( $long > 8 ){
	    
		    $sql = "SELECT  razon 
					  FROM  par_ciu
					  WHERE estado = 'S' AND upper(razon) like ".$query." order by razon";
					    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['razon']);
		    	$razon[] =  $cnombre ;
		    
		    }
		    
		    $n = count($razon);
		    
	}else{
	    
	    $n = 0;
	    
	}
	
	
	 if ( $n ==  0 ) {
		        
		        $razon[] =  'NO EXISTE' ;
		   
		        
	  }
		    
		 
	    echo json_encode($razon);
 
    
   
    
?>
 
  