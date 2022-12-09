<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	 
	
	
	$query	=	"'".strtoupper($_GET["query"]) .'%'."'" ;
	
    
    	
		    $sql = "SELECT  razon 
					  FROM  par_ciu
					  WHERE estado = 'S' AND upper(razon) like ".$query." order by razon";
					    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		    	$cnombre =  trim($x['razon']);
		    	$razon[] =  $cnombre ;
		    }
		    
		    echo json_encode($razon);
 
    
   
    
?>
 
  