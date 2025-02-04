<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
	 
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
   	$id             = 	$_GET["id"];
   	$total          =   $_GET["total"];
	 
 

	   $DivProducto = 'Actualizada';
 
	    
 
    	$ATabla = array(
    	    array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
    	    array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => $id,   filtro => 'N',   key => 'S'),
    	    array( campo => 'total',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N')
    	);
    	 
     	   
    	$bd->_UpdateSQL('inv_movimiento_det',$ATabla,$id);
    	
 
	
	
	echo $DivProducto;
?>
 
  