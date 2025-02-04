<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
	
 
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
	
	$cuenta_inventario           = 	$_GET["cuenta_inventario"];
	$id                          = 	$_GET["idproductop"];
	$cuenta_gas                  = 	$_GET["cuenta_gas"];
	$fcaducidad                  = 	$_GET["fcaducidad"];
	$id_movimiento = 	$_GET["id_movimiento"];
	 
 
	  	
	$DivProducto = ' ';
	
	$ATabla = array(
	    array( campo => 'idproducto',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
	    array( campo => 'cuenta_inv',   tipo => 'VARCHAR2',   id => '1',  add => 'N',   edit => 'S',   valor => trim($cuenta_inventario),   filtro => 'N',   key => 'N'),
	    array( campo => 'cuenta_gas',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => trim($cuenta_gas),   filtro => 'N',   key => 'N')
 	);
    	 
	if (trim($cuenta_inventario) <> '-') {
	    
	    $bd->_UpdateSQL('web_producto',$ATabla,$id);
	    
	    $DivProducto = 'Cuenta actualizada OK';
	    
	}
     	   
	if ( $id_movimiento > 0 ){

		 
 		
		$sql = 'update inv_movimiento_det  
				   set fcaducidad = '.$bd->sqlvalue_inyeccion($fcaducidad, true).'
				where id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento, true). ' and idproducto='.$bd->sqlvalue_inyeccion($id, true);
		
				$bd->ejecutar($sql);

				$DivProducto = $DivProducto.' Fecha Actualizada... OK';

	}
    	
 
   
	
	
	echo $DivProducto;
?>
 
  