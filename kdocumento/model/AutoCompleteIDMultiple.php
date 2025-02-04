 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   idprov,correo,movil
				  FROM par_ciu
				  where upper(razon) =".$bd->sqlvalue_inyeccion(trim($txtcodigo),true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    echo json_encode( array("a"=>trim($dataProv['idprov']),
        "b"=> trim($dataProv['movil']),
        "c"=> trim($dataProv['correo'])
    )  );
    
 
 
  
    
?>