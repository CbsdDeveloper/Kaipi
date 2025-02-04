 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';    
    
    require '../../kconfig/Obj.conf.php'; 
      
	$bd	   = new Db ;
 
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = trim(strtoupper($_GET['itemVariable']));
    
  
    
    $sql = "SELECT   razon,correo,id_par_ciu,idprov
				  FROM par_ciu
				  where upper(razon) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim($dataProv['idprov']),
                            "b"=> trim($dataProv['correo']) ,
                            "c"=> trim($dataProv['id_par_ciu']) 
                            )  
                           );
    
 
  
    
?>