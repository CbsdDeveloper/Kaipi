<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
 
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
 
	
	$id             = 	$_GET["id"];
	$baseiva        = 	$_GET["baseiva"];
	$monto_iva      = 	$_GET["monto_iva"];
	$tarifa_cero    = 	$_GET["tarifa_cero"];
	$lcantidad      = 	$_GET["lcantidad"];
	$total          = 	$_GET["total"];
	
	
	$ingreso_egreso =  $_GET["ingreso_egreso"];
	 
	if ($ingreso_egreso == 'I'){
	    $ingreso = $lcantidad;
	    $egreso = '0';
	    $costo = ($baseiva + $tarifa_cero)/$lcantidad;
	}else{
	    $ingreso = '0';
	    $egreso = $lcantidad;
	    $costo = $total/$lcantidad;
	}
	
	$DivProducto = 'Cantidad No valida';
	
	if ($lcantidad > 0) {
	    
	
    	
    	 
    	$ATabla = array(
    	    array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'S',   valor => $lcantidad,   filtro => 'N',   key => 'N'),
    	    array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => $id,   filtro => 'N',   key => 'S'),
    	    array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'N',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
    	    array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'N',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
    	    array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'N',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
    	    array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'N',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
    	    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
    	    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'N',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
    	    array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'N',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
    	    array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N')
    	    
    	);
    	 
     	   
    	$bd->_UpdateSQL('inv_movimiento_det',$ATabla,$id);
    	
    	$DivProducto = 'OK';
	}
   
	
	
	echo $DivProducto;
?>
 
  