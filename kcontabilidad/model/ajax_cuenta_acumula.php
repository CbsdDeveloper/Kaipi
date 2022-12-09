<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      
    $anio   = $_GET['fanio'];
    $accion = $_GET['accion'];
    
    
    if ($accion == '1'){
        $txtcodigo = 'K';
    }else {
        $txtcodigo = 'H';
    }
 
        
    $sql = "select cuenta,detalle 
            from co_plan_ctas 
            where tipo_cuenta = ".$bd->sqlvalue_inyeccion(trim($txtcodigo) ,true)." and 
                  anio=".$bd->sqlvalue_inyeccion($anio ,true);
    
    $stmt1 = $bd->ejecutar($sql);

     
    
    while ($fila=$bd->obtener_fila($stmt1)){
        
        echo '<option value="'.trim($fila['cuenta']).'">'.trim($fila['cuenta']).'-'.trim($fila['detalle']).'</option>';
        
    }
    
    
?>