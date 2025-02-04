<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';  
    
    require '../../kconfig/Obj.conf.php';  
	
 
	$bd	   = new Db ;
	
	$obj     = 	new objects;
 	
	$anio       =  $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
  
    $sesion 	 =  trim($_SESSION['email']);
    
    $accion	=	$_GET["accion"];
    $tipo = $bd->retorna_tipo();
    
    
    $sql = "SELECT id_precaja, cuenta, '  ' || partida || '  ' as partida    ,monto, estado, sesion
                          FROM presupuesto.pre_caja
                          where anio = ".$bd->sqlvalue_inyeccion($anio,true);
    

    
    if ( $accion == 'visor'){
             
        $resultado = $bd->ejecutar($sql);
        
        $obj->table->table_basic_js($resultado, // resultado de la consulta
            $tipo,      // tipo de conexoin
            '',         // icono de edicion = 'editar'
            'del',			// icono de eliminar = 'del'
            'elimina_caja-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
            "Referencia, Cuenta Contable,Partida,Monto,Estado, Creado",  // nombre de cabecera de grill basica,
            '12px',      // tama�o de letra
            'Caja1'         // id
            );
        
    }
    
    if ( $accion == 'agregar'){
        
        $cuentaa	=	$_GET["cuentaa"];
        $partidaa	=	$_GET["partidaa"];
        $montoa	   =	$_GET["montoa"];
        
        $fecha         = date('Y-m-d');
        $fecha		   = $bd->fecha($fecha);
        
        $InsertQuery = array(
            array( campo => 'anio', valor => $anio ),
            array( campo => 'monto', valor => $montoa),
            array( campo => 'estado', valor => trim('S')),
            array( campo => 'cuenta', valor => trim($cuentaa)),
            array( campo => 'partida', valor => trim($partidaa)),
            array( campo => 'sesion', valor => trim($sesion)),
            array( campo => 'sesionm', valor => trim($sesion)),
            array( campo => 'creacion', valor => $fecha),
            array( campo => 'modificacion', valor => $fecha)
        );
        
 
        $bd->JqueryInsertSQL('presupuesto.pre_caja',$InsertQuery,'N');
        
        $resultado = $bd->ejecutar($sql);
        
        $obj->table->table_basic_js($resultado, // resultado de la consulta
            $tipo,      // tipo de conexoin
            '',         // icono de edicion = 'editar'
            '',			// icono de eliminar = 'del'
            '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
            "Referencia, Cuenta Contable,Partida,Monto,Estado, Creado",  // nombre de cabecera de grill basica,
            '12px',      // tama�o de letra
            'Caja1'         // id
            );
        
    }
 
    
    if ( $accion == 'del'){
        
        $id	=	$_GET["id"];
   
        $sqldel = 'delete from presupuesto.pre_caja where id_precaja= '.$bd->sqlvalue_inyeccion($id,true);
        
        $bd->ejecutar($sqldel);
        
        $resultado = $bd->ejecutar($sql);
        
        $obj->table->table_basic_js($resultado, // resultado de la consulta
            $tipo,      // tipo de conexoin
            '',         // icono de edicion = 'editar'
            '',			// icono de eliminar = 'del'
            '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
            "Referencia, Cuenta Contable,Partida,Monto,Estado, Creado",  // nombre de cabecera de grill basica,
            '12px',      // tama�o de letra
            'Caja1'         // id
            );
        
    }
    
?>
 
  