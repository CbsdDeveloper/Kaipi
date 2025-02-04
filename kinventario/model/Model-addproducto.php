<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = 	new Db ;
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$idproducto	       =	$_GET["idproducto"];
	
	$id_movimiento     = 	$_GET["id_movimiento"];
	
	$id                = 	$_GET["id"];
	
	$accion            = 	$_GET["accion"];
	 
	$estado 		   =    trim($_GET["estado"]);
	
	$tipo   		   =    trim($_GET["tipo"]);
	
	
	
	if ($accion == 'add'){
	    
	    if ( $idproducto > 0 )  {
	        
	        nuevo( $id_movimiento,$idproducto, $bd ,$estado,$tipo);
	        
	    }
	    
	    
	}
	
	if ($accion == 'eliminar'){

	    elimina_dato( $id, $bd,$estado );

	}
	
/*
--- Agrega variable ----------------  	
*/ 
	function nuevo($id_movimiento,$idproducto, $bd ,$estado,$tipo ){
 	    
		$IVA  		=  $bd->_catalogo_iva(); 	// retorna valor iva para calculos de variables

		$sesion 	=  trim($_SESSION['email']);
 	  
 	    $AProducto  =  $bd->query_array( 'web_producto',
 	        						'costo,tributo,saldo',
 	        						'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
 	        );
 	    
 	    $saldo 	  =  $AProducto['saldo'];
 	    
 	    if ($tipo == 'I'){
 	        $ingreso = 1;
 	        $egreso  = 0;
 	        $nbandera = 1;
 	    }else{
 	        $ingreso = 0;
 	        $egreso  = 1;
 	        
 	        if ($saldo > 0){
 	            $nbandera = 1;
 	        }else{
 	            $nbandera = 0;
 	        }
 	    }
 	    
		$tributa =  trim($AProducto['tributo']);

 	    if ($tributa == 'I'){      
 	        $baseiva     = $AProducto['costo'];
 	        $monto_iva   = round($baseiva * $IVA,2);
  	        $total       = $monto_iva + $baseiva ;
  	        $tarifa_cero = '0.00';
  	        
 	    }elseif  ( $tributa == 'T'){
 	        $monto_iva   = '0.00';
 	        $tarifa_cero = $AProducto['costo'];
 	        $baseiva     = '0.00';
 	        $total       = $tarifa_cero;
 	    }else{
			$tributa     = 'T';
			$monto_iva   = '0.00';
 	        $tarifa_cero = $AProducto['costo'];
 	        $baseiva     = '0.00';
 	        $total       = $tarifa_cero;
		}	 
 	    
 
 	    $ATabla = array(
 	        array( campo => 'idproducto',   	tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
 	        array( campo => 'cantidad',   		tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',     valor => 1,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimiento',    tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',     valor => $id_movimiento,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
 	        array( campo => 'costo',   			tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $AProducto['costo'],   filtro => 'N',   key => 'N'),
 	        array( campo => 'total',   			tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
 	        array( campo => 'monto_iva',  	 	tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'tarifa_cero',   	tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
 	        array( campo => 'estado',   		tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
 	        array( campo => 'tipo',   			tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tributa ,   filtro => 'N',   key => 'N'),
 	        array( campo => 'ingreso',   		tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'egreso',   		tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
 	        array( campo => 'baseiva',   		tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
 	        array( campo => 'sesion',   		tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
 	        array( campo => 'descuento',   		tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
 	        array( campo => 'pdescuento',   	tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N')
 	    );
 	    
		 $Avalida  =  $bd->query_array( 'inv_movimiento_det',
		 'count(*) as nexiste',
		 'sesion ='.$bd->sqlvalue_inyeccion(trim($sesion), true).' and
		  idproducto='.$bd->sqlvalue_inyeccion($idproducto, true) .' and 
		  id_movimiento ='.$bd->sqlvalue_inyeccion($id_movimiento, true) 
		);
    	    
 	    if ($Avalida['nexiste'] == 0 ){
 	        
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