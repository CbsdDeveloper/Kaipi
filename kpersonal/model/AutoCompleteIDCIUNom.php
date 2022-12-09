<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
	$anio  = $_SESSION['anio'];
	
 
	
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   idprov
				  FROM par_ciu
				  where upper(razon) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
    
  
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    $prov = trim($dataProv['idprov']);
    
    
    $x = $bd->query_array('nom_vacaciones',
        ' coalesce(max(dia_derecho),0) as dia_derecho , coalesce(max(dia_acumula),0) as dia_acumula',
        'idprov='.$bd->sqlvalue_inyeccion(trim($prov),true) .' and
         anio ='.$bd->sqlvalue_inyeccion($anio,true) ." and
         cargoa = 'S' "
        );
    
    
 
    
    echo json_encode( array("a"=>$prov, 
                            "b"=> $x['dia_derecho'] ,
                            "c"=> $x['dia_acumula'] 
                       )  
                    );
    
     
    
?>