<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $sql = "SELECT * FROM co_asiento_aux
            WHERE fecha is null
            ORDER BY id_asiento_aux ASC";

 
    
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $y = $bd->query_array('co_asiento','fecha', 
                              'id_asiento='.$bd->sqlvalue_inyeccion(trim($x['id_asiento']),true)
                            );
        
   
    	 
    	$sql = "UPDATE co_asiento_aux
                  SET fecha = ". $bd->sqlvalue_inyeccion($y['fecha'],true)." ,
                      fechap = ". $bd->sqlvalue_inyeccion($y['fecha'],true)." 
                WHERE id_asiento= " .$bd->sqlvalue_inyeccion( $x['id_asiento'],true);
    	
    	$bd->ejecutar($sql);
    	
     
    	echo $x['id_asiento'].'-';
    	
    }
    
 
 
    
?>
 
  