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
    
    
    $hora = $bd->query_array('nom_cvacaciones',  
    'dias_pendientes,dias_tomados,(saldo_anterior + dias_derecho) as total,horas_dias',                       
    'idprov='.$bd->sqlvalue_inyeccion(  trim( $prov),true).' and 
     periodo=' .$bd->sqlvalue_inyeccion(    $anio  ,true) 
    );

                    
    $dias_tomados  = $hora['dias_tomados'];
    $dia_acumula   = $hora['total'];
    $hora_tomados  = $hora['horas_dias'];
    $dia_valida       = $hora['dias_pendientes'];


 
 
    
    echo json_encode( array("a"=>$prov, 
                            "b"=>  $dia_acumula,
                            "c"=>  $dias_tomados ,
                            "d"=>  $hora_tomados ,
                            "e"=>  $dia_valida  
                       )  
                    );
    
     
    
?>