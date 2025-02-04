<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
 
	$idcategoriavar      = 	$_GET["idcategoriavar"];
	$id_movimiento       = 	$_GET["id_movimiento"];
	$valor               = 	$_GET["valor"];
	$variable            = 	$_GET["variable"];
	$sesion 	 =  $_SESSION['email'];
	
	$x = $bd->query_array('inv_movimiento_var',
	                      'idmovimientovar', 
	                     'id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento,true). ' and 
                          idcategoriavar='.$bd->sqlvalue_inyeccion($idcategoriavar,true)
	                      );
	
	$ATabla = array(
	    array( campo => 'idmovimientovar',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
	    array( campo => 'id_movimiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => $id_movimiento, key => 'N'),
	    array( campo => 'idcategoriavar',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => $idcategoriavar, key => 'N'),
	    array( campo => 'nombre_variable',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $variable, key => 'N'),
	    array( campo => 'valor_variable',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $valor, key => 'N'),
	    array( campo => 'registro',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => $registro, key => 'N'),
	    array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => $sesion, key => 'N')
	);
	
	$id = $x["idmovimientovar"] ;
	
	if ( $id > 0 ) {

	    $bd->_UpdateSQL('inv_movimiento_var',$ATabla,$id);
	    
	}else{
	    
	    $id = $bd->_InsertSQL('inv_movimiento_var',$ATabla,'inv_movimiento_var_idmovimientovar_seq');
	}
    	 
    	
 
	$GuardaArticulo = 'OK '.$id;
 
	echo $GuardaArticulo;
?>
 
  