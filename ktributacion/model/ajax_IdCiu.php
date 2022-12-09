 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = ltrim(rtrim($_GET['itemVariable']));
    
    
    $sql = "SELECT   idprov
				  FROM par_ciu
				  where UPPER(razon) = ".$bd->sqlvalue_inyeccion($txtcodigo,true)  ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $cuenta= ltrim(rtrim($datos_sql['idprov']));
    
    echo $cuenta;
     
    
?>