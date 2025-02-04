<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	
	
	
	$idproducto	       =	$_GET["idproducto"];
	
	$id_movimiento     = 	$_GET["id_movimiento"];
	
	$id                = 	$_GET["id"];
	
	$accion            = 	$_GET["accion"];
	 
	 
	$estado = trim($_GET["estado"]);
	
	$tipo   = trim($_GET["tipo"]);
	
	
	
	if ($accion == 'add'){
	    nuevo( $id_movimiento,$idproducto, $bd ,$estado,$tipo);
	}
	
	if ($accion == 'eliminar'){
	    elimina_dato( $id, $bd,$estado );
	}
	

//--- funciones grud	
 
	function nuevo($id_movimiento,$idproducto, $bd ,$estado,$tipo ){
 	    
 	    //---------------------------------------------------
 	    $IVA         = 12/100;
 	    $IVADesglose = 1 + $IVA;
 	    $sesion 	       =    $_SESSION['email'];
 	  
 	    //----------------------------------------------------
 	    
 	    $AProducto = $bd->query_array( 'web_producto',
 	        'costo,tributo,saldo',
 	        'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
 	        );
 	    
 	    //----------------------------------------------------
 	    $saldo = $AProducto['saldo'];
 	    
 	    if ($tipo == 'I'){
 	        $ingreso = 1;
 	        $egreso = 0;
 	        $nbandera = 1;
 	    }else{
 	        $ingreso = 0;
 	        $egreso = 1;
 	        
 	        if ($saldo > 0){
 	            $nbandera = 1;
 	        }else{
 	            $nbandera = 0;
 	        }
 	    }
 	    
 	    //----------------------------------------------------
 	    
 	    
 	    if (trim($AProducto['tributo']) == 'I'){
 	     /*   $total = $AProducto['costo'];
 	        $baseiva     = round($total / $IVADesglose,2);
 	        $tarifa_cero = 0;
 	        $monto_iva   = round($baseiva * $IVA,2);*/
 	        
 	        $baseiva     = $AProducto['costo'];
 	        $monto_iva   = round($baseiva * $IVA,2);
  	        $total       = $monto_iva + $baseiva ;
  	        $tarifa_cero = 0;
  	        
 	    }elseif  (trim($AProducto['tributo']) == 'B'){
 	        $monto_iva   = 0;
 	        $tarifa_cero = $AProducto['costo'];
 	        $baseiva = 0;
 	        $total = $tarifa_cero;
 	    }
 	    
 	    
 
 	    $ATabla = array(
 	        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
 	        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'N',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
 	        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $AProducto['costo'],   filtro => 'N',   key => 'N'),
 	        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
 	        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
 	        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
 	        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $AProducto['tributo'],   filtro => 'N',   key => 'N'),
 	        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
 	    );
 	    
 
 	    
 	    $sql = "SELECT count(*) as nexiste
              FROM inv_movimiento_det
             WHERE  sesion =".$bd->sqlvalue_inyeccion($sesion, true).' and
                    idproducto='.$bd->sqlvalue_inyeccion($idproducto, true) .' and id_movimiento is null';
 	    
 	    $resultado = $bd->ejecutar($sql);
 	    
 	    $Avalida = $bd->obtener_array($resultado);
 	       
 	    
 	    if ($Avalida['nexiste'] == 0 ){
 	        
 	        if ( $estado == 'digitado'){
 	            if ($nbandera == 1){
 	               
 	                $id = $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
 	           
 	            }
  	        }
 	    }
 	    
 	}
 	//--- funciones grud
 	
 	function elimina_dato($id, $bd ,$estado ){
 	    
 	    $tabla = 'inv_movimiento_det';
 	    
 	    $where = 'id_movimientod = '.$id;
 	    
 	    if ( $estado == 'digitado'){
 	        
 	        $bd->JqueryDeleteSQL($tabla,$where);
 	        
 	    }
 	   
 	    
 	}
    
   
    
?>
 
  