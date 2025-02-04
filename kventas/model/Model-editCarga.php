<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
	
	$id            = 	$_GET["id"];
 	$lcantidad     = 	$_GET["lcantidad"];
	$total         = 	$_GET["total"];
	 
	if ($lcantidad > 0 ){
	    $costo         = $total/$lcantidad;
	}else{
	    $costo         = 0 ;
	}
	
	  	
	$DivProducto = 'Cantidad No valida';
	
	$ATabla = array(
	    array( campo => 'idcarga_inicial',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	    array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'S',   valor => $lcantidad,   filtro => 'N',   key => 'N'),
	    array( campo => 'costo',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
	    array( campo => 'total',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
	    array( campo => 'saldo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
	    array( campo => 'id_cmovimiento',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N') 
	);
    	 
    	 	 
     	   
    	$bd->_UpdateSQL('inv_carga_inicial',$ATabla,$id);
    	
    	$DivProducto = 'OK';
 
   
	
	
	echo $DivProducto;
?>
 
  