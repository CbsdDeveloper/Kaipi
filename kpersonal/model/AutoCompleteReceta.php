<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
  
	$bd	   = 	new Db ;
	
 
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
	$query	=	"'".strtoupper ($_GET["query"]) .'%'."'" ;
	
    
    	
		    $sql = "SELECT  nombre 
					  FROM  medico.me_medicina
					  WHERE estado = 'S'  order by nombre";
					    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['nombre']);
		    	
		    	$razon[] =  $cnombre ;
		    
		    }
		    
		    $n = count($razon);
		    
		    if ( $n ==  0 ) {
		        
		        $razon[] =  'NO EXISTE' ;
		   
		        
		    }
		    
		 
		    echo json_encode($razon);
 
    
		    pg_free_result($stmt);
		    
    
?>
 
  