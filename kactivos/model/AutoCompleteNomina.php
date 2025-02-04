<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
  
	$bd	   = 	new Db ;
	
 
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
	$query	=	"'".strtoupper ($_GET["query"]) .'%'."'" ;
	
    
    	
		    $sql = "SELECT  razon 
					  FROM  par_ciu
					  WHERE estado = 'S' and modulo = 'N' AND upper(razon) like ".$query." order by razon";
					    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['razon']);
		    	
		    	$razon[] =  $cnombre ;
		    
		    }
		    
		    $n = count($razon);
		    
		    if ( $n ==  0 ) {
		        
		        $razon[] =  'NO EXISTE' ;
		   
		        
		    }
		    
		 
		    echo json_encode($razon);
 
    
		    pg_free_result($stmt);
		    
    
?>
 
  