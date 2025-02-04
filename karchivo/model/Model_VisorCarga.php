<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $id = strtoupper($_GET['id']);
    
    $idbodega =  ($_GET['idbodega']);
    
    
    $x = $bd->query_array('view_inv_movimiento',
                          'max(id_movimiento) as id_movimiento', 
                          'idbodega   ='.$bd->sqlvalue_inyeccion($idbodega,true). ' and 
                           transaccion='.$bd->sqlvalue_inyeccion('carga inicial',true). ' and 
                           registro   ='.$bd->sqlvalue_inyeccion($registro,true)
        );
    
    $id_movimiento = $x['id_movimiento'];
       
    $sql = "SELECT   cantidad,costo
				  FROM inv_movimiento_det
				  where idproducto  =".$bd->sqlvalue_inyeccion($id,true).' and 
                        id_movimiento='. $bd->sqlvalue_inyeccion($id_movimiento,true);
 
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim($dataProv['cantidad']), "b"=> trim($dataProv['costo']) )  );
    
 
  
    
?>