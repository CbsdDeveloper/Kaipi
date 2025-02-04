 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';    
    
    require '../../kconfig/Obj.conf.php'; 
      
	$bd	   = new Db ;
 
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   razon,correo,id_par_ciu,direccion
				  FROM par_ciu
				  where upper(idprov) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim($dataProv['razon']), 
                            "b"=> trim($dataProv['correo']), 
                            "c"=> trim($dataProv['id_par_ciu']),
                            "d"=> trim($dataProv['direccion'])
                    )  
                   );
    
 
    $bd->libera_cursor($resultado1);
    
?>