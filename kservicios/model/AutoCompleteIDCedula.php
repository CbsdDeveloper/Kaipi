 <?php 
    session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	$query	=	"'". $_GET["query"].'%'."'" ;
	
    
    	
		    $sql = "SELECT  idprov 
					  FROM  par_ciu
					  WHERE estado = 'S' AND upper(idprov) like ".$query." order by idprov";
					    
		 
		    $stmt = $bd->ejecutar($sql);
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
		    	$cnombre =  trim($x['idprov']);
		    	$idprov[] =  $cnombre ;
		    
		    }
		    
		    $n = count($idprov);
		    
		    if ( $n ==  0 ) {
		        
		        $idprov[] =  'NO EXISTE' ;
		   
		    }else {
		        
		        $bd->libera_cursor($stmt);
		        
		    }
		    
		 
		    echo json_encode($idprov);
 
     
    
?>  