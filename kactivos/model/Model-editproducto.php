<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';    
    
    require '../../kconfig/Obj.conf.php'; 
	
 	$bd	   = 	new Db ;
	
	 
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
	
	$id             = 	$_GET["id"];
	$baseiva        = 	$_GET["baseiva"];
	$monto_iva      = 	$_GET["monto_iva"];
	$tarifa_cero    = 	$_GET["tarifa_cero"];
	$lcantidad      = 	$_GET["lcantidad"];
	$total          = 	$_GET["total"];
	$p1             = 	$_GET["p1"];
	$descuento      = 	$_GET["descuento"];
	$lcosto         = 	$_GET["lcosto"];
	
	$detalle         = 	strtoupper(trim($_GET["detalle"]));

 
 
	    $ingreso = $lcantidad;
	    $egreso = '0';
	  
	 
 
 
	$costo = round($lcosto,4);
	$DivProducto = 'Cantidad No valida';
 
	
	
	
	if ($lcantidad > 0) {
	    
 
    	$ATabla = array(
    	    array( campo => 'idclasebien',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'S',   valor => $lcantidad,   filtro => 'N',   key => 'N'),
    	    array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => $id,   filtro => 'N',   key => 'S'),
    	    array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
    	    array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'N',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
    	    array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'N',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
    	    array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'N',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
    	    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
    	    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'N',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
    	    array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'N',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
    	    array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
    	    array( campo => 'pdescuento',   tipo => 'NUMBER',   id => '13',  add => 'N',   edit => 'S',   valor => $p1,   filtro => 'N',   key => 'N'),
    	    array( campo => 'descuento',   tipo => 'NUMBER',   id => '14',  add => 'N',   edit => 'S',   valor => $descuento,   filtro => 'N',   key => 'N'),
    	    array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '15',  add => 'N',   edit => 'S',   valor => $detalle,   filtro => 'N',   key => 'N')
    	);
    	 
     	   
    	$bd->_UpdateSQL('activo.ac_compra_det',$ATabla,$id);
    	
    	$DivProducto = 'OK';
	}
   
	
	
	echo $DivProducto;
?>
 
  