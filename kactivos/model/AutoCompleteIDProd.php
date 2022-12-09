<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $detalle = trim($_GET['itemVariable']);
 
    $idproducto = 0;
    
    if ( !empty($detalle)) {
     
            $sql = "SELECT   idclasebien
        				  FROM activo.ac_clase
        				  where clase  like ".$bd->sqlvalue_inyeccion(trim($detalle).'%', true) ;
            
            
            $resultado1 = $bd->ejecutar($sql);
            
            $datos_sql  = $bd->obtener_array( $resultado1);
            
            $idproducto=   $datos_sql['idclasebien'];
    
    }
    
    echo $idproducto;
     
    
?>