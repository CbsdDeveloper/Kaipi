<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $sql = " SELECT * from co_asiento WHERE estado ='aprobado' and idprov is not null and apagar is null order by id_asiento ";

 
    
    $stmt = $bd->ejecutar($sql);
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $y = $bd->query_array('co_asiento_aux','sum(haber)  as pago ', 
                              'idprov='.$bd->sqlvalue_inyeccion(trim($x['idprov']),true). ' and 
                               id_asiento='.$bd->sqlvalue_inyeccion( $x['id_asiento'],true). " and cuenta like '213%'"
                            );
        
  
    	 
    	$sql = "UPDATE co_asiento
                  SET apagar = ". $bd->sqlvalue_inyeccion(trim($y['pago']),true)." 
                WHERE id_asiento= " .$bd->sqlvalue_inyeccion( $x['id_asiento'],true). ' and 
                      idprov='.$bd->sqlvalue_inyeccion(trim($x['idprov']),true);
    	
    	$bd->ejecutar($sql);
    	
     
    }
    
 
 
    
?>
 
  