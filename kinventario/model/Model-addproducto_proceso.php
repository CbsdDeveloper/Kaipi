<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = 	new Db ;
	
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	
	$idproducto	       =	$_GET["idproducto"];
	$tramite           = 	$_GET["tramite"];
	$accion            = 	$_GET["accion"];
	 
 
	$x = $bd->query_array('inv_movimiento',   					   // TABLA
	    '*',                        // CAMPOS
	    'idproceso='.$bd->sqlvalue_inyeccion($tramite,true) 	   // CONDICION
	    );
	
	$id_movimiento = $x["id_movimiento"];
	$idbodega      = $x["idbodega"];

	
	if ($accion == 'add'){
 	    
	    if ( $id_movimiento >  0 ){
	        
	    }else{
	        $id_movimiento =  nuevo_tramite( $bd,$tramite);
			$idbodega      =  $_SESSION['idbodega'];
	    }
	    
	    if ( $idproducto > 0 )  {
	        
	        $mensaje = nuevo( $id_movimiento,$idproducto, $bd, $idbodega  );
	        
	        echo 'Movimiento '.$id_movimiento.$mensaje;
	    }
	   
	    
	    
	}

 
	if ($accion == 'eliminar'){
	    $id           = 	$_GET["id"];
	    elimina_dato( $id, $bd,$id_movimiento );
	}
	 

//--- funciones grud	
	function nuevo_tramite($bd,$tramite ){
	    
	    
	    $x = $bd->query_array('flow.view_proceso_caso01',   // TABLA
	        '*',                        // CAMPOS
	        'idcaso01='.$bd->sqlvalue_inyeccion($tramite,true) // CONDICION
	        );
 
	    $ruc         =     trim($_SESSION['ruc_registro']);
	    $sesion 	 =     trim($_SESSION['email']);
	    $hoy 	     =     date("Y-m-d");    	 
	    
	    $idperiodo   =     periodo($bd,$hoy,$ruc);
	    
	    $documento   =     $tramite . '-'. date("Y");   
	    $idbodega    =     $_SESSION['idbodega'] ;
	    
	    $ATabla = array(
	        array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	        array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'S',   valor => $hoy,   filtro => 'N',   key => 'N'),
	        array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $ruc,   filtro => 'N',   key => 'N'),
	        array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => trim($x['caso']),   filtro => 'N',   key => 'N'),
	        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $sesion ,   filtro => 'N',   key => 'N'),
	        array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
	        array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
	        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
	        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'E',   filtro => 'N',   key => 'N'),
	        array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => $idperiodo,   filtro => 'N',   key => 'N'),
	        array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $documento,   filtro => 'N',   key => 'N'),
	        array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'N',   valor => trim($x['idprov']),   filtro => 'N',   key => 'N'),
	        array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
	        array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor =>$hoy,   filtro => 'N',   key => 'N'),
	        array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'Egreso Bodega',   filtro => 'N',   key => 'N'),
	        array( campo => 'idbodega',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => $idbodega,   filtro => 'N',   key => 'N'),
	        array( campo => 'id_departamento',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => $x['id_departamento'],   filtro => 'N',   key => 'N'),
	        array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'N',   valor => 'FLOW',   filtro => 'N',   key => 'N'),
	        array( campo => 'idproceso',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'N',   valor => $tramite,   filtro => 'N',   key => 'N') 
	    );
	    
	    
	    
	    $tabla 	  	  = 'inv_movimiento';
	    
 	    $id = $bd->_InsertSQL($tabla,$ATabla, '-' );
 
	     
	    return $id;
	    
	    
	}
	
 //----------------------------
	function periodo($bd,$fecha,$ruc ){
	    
	    $anio = substr($fecha, 0, 4);
	    $mes  = substr($fecha, 5, 2);
	    
	    $APeriodo = $bd->query_array('co_periodo',
	        'id_periodo, estado',
	        'registro='.$bd->sqlvalue_inyeccion($ruc,true). ' AND
											  mes = '.$bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$bd->sqlvalue_inyeccion($anio,true)
	        );
	    
 
	    
	    return $APeriodo['id_periodo'];
	    
	}
//-----------------------------	
	function nuevo($id_movimiento,$idproducto, $bd,$idbodega ){
 	    
 	    //---------------------------------------------------
 	  
 
 	    $sesion 	       =    $_SESSION['email'];
 	  
 	    //----------------------------------------------------
 	    
 	    $AProducto = $bd->query_array( 'web_producto',
 	        'costo,tributo,saldo,idbodega',
 	        'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
 	        );
 	    
 	    //----------------------------------------------------
 	    $saldo          = $AProducto['saldo'];
 	    $idbodega_prod  = $AProducto['idbodega'];
 	    
 
 	        $ingreso = 0;
 	        $egreso = 1;
 	        
 	        if ($saldo > 0){
 	            $nbandera = 1;
 	        }else{
 	            $nbandera = 0;
 	        }
 	  
 	    //----------------------------------------------------
 	    
 
 	        $monto_iva   = 0;
 	        $tarifa_cero = $AProducto['costo'];
 	        $baseiva = 0;
 	        $total = $tarifa_cero;
 
  	    
 
 	    $ATabla = array(
 	        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
 	        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
 	        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
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
 	        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
 	        array( campo => 'descuento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
 	        array( campo => 'pdescuento',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N')
 	    );
 	    
 
 	    
 	    $sql = "SELECT count(*) as nexiste
              FROM inv_movimiento_det
             WHERE  sesion =".$bd->sqlvalue_inyeccion($sesion, true).' and
                    idproducto='.$bd->sqlvalue_inyeccion($idproducto, true) .' and 
                    id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento, true);
 	    
 	    
 	    
 	    $resultado = $bd->ejecutar($sql);
 	    
 	    $Avalida = $bd->obtener_array($resultado);
 	       
 	    
 	    if ( trim($idbodega) == trim($idbodega_prod)){

          	    if ($Avalida['nexiste'] == 0 ){
          	            if ($nbandera == 1){
          	                 $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
          	                 
          	                 return ' Articulo asignado... ';
          	            }else{
          	                return ' No existe saldo en el Articulo ... ';
          	            }
           	    }else {
         	        return ' Ya existe en el Articulo ... ';
          	    }
 	    }else{
 	        return ' Articulo no corresponde a la Bodega generada inicialmente...'.$idbodega. ' - '.$idbodega_prod;
 	    }
 	}
 	//--- funciones grud
 	
 	function elimina_dato( $id, $bd,$id_movimiento ){
 	    
 	    $tabla = 'inv_movimiento_det';
 	    
 	    $where = 'id_movimientod = '.$id;
 	    
 	    $x = $bd->query_array( 'inv_movimiento',
 	        '*',
 	        'id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento,true)
 	        );
 	    
 	    
 
 	    /*
 	    if ( trim($x['estado']) == 'aprobado'){
 	        
 	        
 	    }else {
		 */
			$bd->JqueryDeleteSQL($tabla,$where);
/*
		}
 	  */ 
 	    
 	}
    
   
    
?>
 
  