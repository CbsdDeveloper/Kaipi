<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
    
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = $_GET['itemVariable'];
    
    $sql = "select idprov from par_ciu where razon = ".$bd->sqlvalue_inyeccion($txtcodigo ,true);
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $idprov  = trim( $datos_sql['idprov']);
    
    echo $idprov;
     
    
?>