<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
	
 
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
	
	$id            = 	$_GET["idproducto"];
	$detalle       = 	$_GET["detalle"];
 	 
 
	
	$ATabla = array(
	    array( campo => 'idproducto',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	    array( campo => 'unidad',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'S',   valor => $detalle,   filtro => 'N',   key => 'N'),
 	);
    	 
    	 	 
	if (trim($detalle) == 'principal'){
	    $VisorArticuloPrecios = ' ';
	}else {
	    $bd->_UpdateSQL('web_producto',$ATabla,$id);
	    $VisorArticuloPrecios = 'OK';
	}
     	   
    	
    	
    	
 
   
	
	
    	echo $VisorArticuloPrecios;
?>
 
  