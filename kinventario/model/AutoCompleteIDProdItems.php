<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro = $_SESSION['ruc_registro'];
 	
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = trim(strtoupper($_GET['itemVariable']));
    
    
 
    
    $sql = "SELECT   idproducto
				  FROM web_producto
				  where upper(producto) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ." AND
                        registro = ".$bd->sqlvalue_inyeccion($registro,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $idproducto= trim( $datos_sql['idproducto']);
    
    echo $idproducto;
     
    
?>