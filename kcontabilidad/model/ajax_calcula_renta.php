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
    
    
    $dato_porcentaje = explode('.',$porcentaje['valor']);
    
    $entero = $dato_porcentaje[1];
    
    $porcentaje_dato = $porcentaje['valor'];
    
    if ( $entero == '00') {
        $porcentaje_dato = $dato_porcentaje[0];
    }
    
    
    
    echo json_encode( array("a"=> $porcentaje_dato,
                            "b"=> round($retencion,2)
                            )  
                           );
    
 
  
    
?>