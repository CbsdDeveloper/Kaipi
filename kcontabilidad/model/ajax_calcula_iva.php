 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';    
    
    require '../../kconfig/Obj.conf.php'; 
      
	$bd	   = new Db ;
 
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $anio       =  $_SESSION['anio'];
    
    
    $cuenta = trim(strtoupper($_GET['cuenta']));
    $base   = $_GET['base'] ;
  
 
    
    
    $sql = "SELECT   valor
				  FROM co_plan_ctas
				  where cuenta=".$bd->sqlvalue_inyeccion($cuenta,true) .' and 
                         anio = '.$bd->sqlvalue_inyeccion($anio,true);
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $porcentaje  = $bd->obtener_array( $resultado1);
    
    $retencion = $base * ($porcentaje['valor']/100);
    
     
    if ( $porcentaje['valor'] == '100'){
        $porcentaje_dato = 3;
    }
    
    if ( $porcentaje['valor'] == '0'){
        $porcentaje_dato = 0;
    }
 
    if ( $porcentaje['valor'] == '10'){
        $porcentaje_dato = 9;
    }
    if ( $porcentaje['valor'] == '30'){
        $porcentaje_dato = 1;
    }
    if ( $porcentaje['valor'] == '70'){
        $porcentaje_dato = 2;
    }
    if ( $porcentaje['valor'] == '20'){
        $porcentaje_dato = 10;
    } 
    
    echo json_encode( array("a"=> $porcentaje_dato,
                            "b"=> round($retencion,2)
                            )  
                           );
    
 
  
    
?>