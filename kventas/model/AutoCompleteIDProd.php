 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
    
	$bd	   = new Db ;
	
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   idproducto
				  FROM web_producto
				  where upper(producto) =".$bd->sqlvalue_inyeccion(trim($txtcodigo),true);
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $idproducto= trim( $datos_sql['idproducto']);
    
   
    echo $idproducto;
     
    
    pg_free_result($resultado1);
    
?>