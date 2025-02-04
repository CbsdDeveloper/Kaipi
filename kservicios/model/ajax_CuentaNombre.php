<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	 
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = trim($_GET['itemVariable']);
    
    
    $anio_ejecuta = $_SESSION['anio'];
 

    
    $sql = "SELECT detalle
				  FROM co_plan_ctas
				  where registro =".$bd->sqlvalue_inyeccion($registro,true)."  and 
                        anio =".$bd->sqlvalue_inyeccion($anio_ejecuta,true)."  and 
                        univel = 'S' and  
                        estado = 'S' and 
					    trim(cuenta) = ".$bd->sqlvalue_inyeccion(trim($txtcodigo), true) ;
    
 
 
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $cuenta= trim( $datos_sql['detalle']);
    
    echo $cuenta;
     
    
?>