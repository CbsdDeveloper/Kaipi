<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';    
    
    require '../../kconfig/Obj.conf.php';  
	
	 
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
     
    $txtcodigo = trim($_GET['itemVariable']);
    
    
    $trozos = explode("(", $txtcodigo); 
    
    $detalle =  trim($trozos[0]);
    
 
    $anio_ejecuta = $_SESSION['anio'];
    

    
    $sql = "SELECT cuenta
				  FROM co_plan_ctas
				  where registro =".$bd->sqlvalue_inyeccion($registro,true)."  and 
                        anio =".$bd->sqlvalue_inyeccion($anio_ejecuta,true)."  and 
                        univel = 'S' and  
                        estado = 'S' and 
					    trim(detalle) like ".$bd->sqlvalue_inyeccion(trim($detalle).'%', true) ;
    
 
 
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $cuenta= trim( $datos_sql['cuenta']);
    
    echo $cuenta;
     
    
?>