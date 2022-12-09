<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
	$registro = $_SESSION['ruc_registro'];
	
	$idbodega = $_SESSION['idbodega']  ;
	
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $detalle = trim($_GET['itemVariable']);
 
    $idproducto = 0;
    
    if ( !empty($detalle)) {
     
            $sql = "SELECT   idproducto
        				  FROM web_producto
        				  where producto  = ".$bd->sqlvalue_inyeccion(trim($detalle), true) ." AND
                                registro = ".$bd->sqlvalue_inyeccion($registro,true)." AND
                                idbodega = ".$bd->sqlvalue_inyeccion($idbodega,true);
            
            
            $resultado1 = $bd->ejecutar($sql);
            
            $datos_sql  = $bd->obtener_array( $resultado1);
            
            $idproducto=   $datos_sql['idproducto'];
    
    }
    
    echo $idproducto;
     
    
?>