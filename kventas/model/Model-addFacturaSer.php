 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$idproducto	       =	$_GET["idproducto"];
	
	$id_movimiento     = 	$_GET["id_movimiento"];
	
	$id                = 	$_GET["id"];
	
	$accion            = 	$_GET["accion"];
 
	$registro= $_SESSION['ruc_registro'];
	
 	
 	$estado = trim($_GET["estado"]);
	
	$tipo   = trim($_GET["tipo"]);
	
	
	if ($accion == 'add'){
	    
	    if ($idproducto > 0 ){
	        
	        nuevo( $id_movimiento,$idproducto, $bd ,$estado,$tipo,$registro);
	        
	    }
	}
	
	if ($accion == 'eliminar'){
	    elimina_dato( $id, $bd,$estado );
	}
	

//--- funciones grud	
 
	function nuevo($id_movimiento,$idproducto, $bd ,$estado,$tipo ,$registro){
 	    
 	    //---------------------------------------------------
 	    $IVA              = 12/100;
 	    $sesion 	      =    trim($_SESSION['email']);
 	    
 	    
 	    //------------------------------------------------------
 	    $AProducto = $bd->query_array( 'web_producto',
 	        'costo,tributo,saldo',
 	        'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
 	        );
 	    
 	    //----------------------------------------------------
 	    
 	    
 	    //----------------------------------------------------
 	    $APVP             = $bd->query_array('inv_producto_vta',
 	                                   'monto', 
 	                                   'activo='.$bd->sqlvalue_inyeccion('S',true).' AND 
                                        principal ='.$bd->sqlvalue_inyeccion('S',true). ' AND 
                                        id_producto ='.$bd->sqlvalue_inyeccion( $idproducto,true)
 	                                  );
 	      
 	    
 	    if ( $APVP['monto']  > 0 ) 	{
 	        
 	        $venta = $APVP['monto'];
 	    
 	    }else{
 	    
 	        $venta = $AProducto['costo'];
 	    
 	    }
 	    
 	    
 	   
  	    
 
 	        $ingreso = '0';
 	        $egreso = 1;
            $nbandera = 1;
 	    
 	    
 	    //----------------------------------------------------
  	        
 	    
 	    if (trim($AProducto['tributo']) == 'I'){
 	        $total = $venta;
  	        $baseiva     = round($total,2);
 	        $tarifa_cero = '0.00';
 	        $monto_iva   = round($baseiva * $IVA,2);
 	        $total1      =  $baseiva + $monto_iva;
 	        
 	    }else {
 	        $monto_iva   = '0.00';
 	        $tarifa_cero = $venta;
 	        $baseiva      = '0.00';
 	        $total1       = $venta;
 	        
 	    }
 	    
 	    
 	    
 	    
 	    
 	    $ATabla = array(
 	        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
 	        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
 	        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $venta,   filtro => 'N',   key => 'N'),
 	        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total1,   filtro => 'N',   key => 'N'),
 	        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
 	        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
 	        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $AProducto['tributo'],   filtro => 'N',   key => 'N'),
 	        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
 	        
 	    );
 	    
 	    
 	    $xx = $bd->query_array('inv_movimiento_det',
 	                           'count(*) as nexiste', 
 	                           'sesion='.$bd->sqlvalue_inyeccion($sesion,true).' and 
                               idproducto='.$bd->sqlvalue_inyeccion($idproducto,true).' and 
                               id_movimiento = '.$bd->sqlvalue_inyeccion($id_movimiento,true)
 	        );
 	    
 	    
 
 	    
 	    
 	    if ($xx['nexiste'] == 0 ){
 	        
 	        if ( $estado == 'digitado'){
 	            if ($nbandera == 1){
 	               
 	                 $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
 	           
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
 
  