<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
	
 
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
 
	
	$cuenta_inventario           = 	$_GET["cuenta_inventario"];
	$id                          = 	$_GET["idproductop"];
	$cuenta_gas                  = 	$_GET["cuenta_gas"];
	 
 
	  	
	$DivProducto = 'No Actualizada';
	
	$ATabla = array(
	    array( campo => 'idproducto',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	    array( campo => 'cuenta_inv',   tipo => 'VARCHAR2',   id => '1',  add => 'N',   edit => 'S',   valor => trim($cuenta_inventario),   filtro => 'N',   key => 'N'),
	    array( campo => 'cuenta_gas',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => trim($cuenta_gas),   filtro => 'N',   key => 'N')
 	);
    	 
	if (trim($cuenta_inventario) <> '-') {
	    
	    $bd->_UpdateSQL('web_producto',$ATabla,$id);
	    
	    $DivProducto = 'OK';
	    
	}
     	   
    	
 
   
	
	
	echo $DivProducto;
?>
 
  