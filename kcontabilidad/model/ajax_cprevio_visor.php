<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	   = new Db ;
	
	$obj     = 	new objects;
 	
	$anio       =  $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
  
    $sesion 	 =  trim($_SESSION['email']);
    
    $idcaso      =	$_GET["idcaso"];


    $tipo = $bd->retorna_tipo();
    
    
    $sql = "SELECT  id_control || ' ' as  id_control, tipo, detalle, sesion, fmodificacion, estado 
                          FROM co_control
                          where idcaso = ".$bd->sqlvalue_inyeccion($idcaso  ,true);
    
 
 
             
        $resultado = $bd->ejecutar($sql);
        
        $obj->table->table_basic_js($resultado, // resultado de la consulta
            $tipo,      // tipo de conexoin
            'aprobar',         // icono de edicion = 'editar'
            'del',			// icono de eliminar = 'del'
            'proceso_doc-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
            "Referencia, Documento,Observacion,Sesion,Fecha, Cumple",  // nombre de cabecera de grill basica,
            '10px',      // tamaño de letra
            'Caja1'         // id
            );
        
    
    
?>
 
  