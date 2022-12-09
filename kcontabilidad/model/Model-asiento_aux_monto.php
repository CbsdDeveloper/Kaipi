<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $xid_asientoaux =   $_GET['id_asientoaux'];
    $monto          =   $_GET['monto'];
 
 
    $valida = $bd->query_array('co_asiento_aux',
        'debe,haber, id_asientod ',
        'id_asiento_aux ='.$bd->sqlvalue_inyeccion($xid_asientoaux,true)
        );
    
    
    if ( $valida['debe'] > 0 ){
        $sql_uno = 'UPDATE co_asiento_aux
						 		       SET  debe='.$bd->sqlvalue_inyeccion($monto, true).'
								  WHERE id_asiento_aux ='.$bd->sqlvalue_inyeccion($xid_asientoaux ,true);
        
        $bd->ejecutar($sql_uno); 
        
        $total_aux = $bd->query_array('co_asiento_aux',
            'sum(debe) as monto',
            'id_asientod ='.$bd->sqlvalue_inyeccion($valida['id_asientod'],true)
            );
        
    }else{
        
        $sql_uno = 'UPDATE co_asiento_aux
						 		       SET  haber='.$bd->sqlvalue_inyeccion($monto, true).'
								  WHERE id_asiento_aux ='.$bd->sqlvalue_inyeccion($xid_asientoaux ,true);
        
        $bd->ejecutar($sql_uno); 
        
        $total_aux = $bd->query_array('co_asiento_aux',
            'sum(haber) as monto',
            'id_asientod ='.$bd->sqlvalue_inyeccion($valida['id_asientod'],true)
            );
    }
    
   
    
 
    echo 'DATO ACTUALIZADO...Monto Auxiliar: '. $total_aux['monto'].' VERIFIQUE LA INFORMACION';
  
    
?>