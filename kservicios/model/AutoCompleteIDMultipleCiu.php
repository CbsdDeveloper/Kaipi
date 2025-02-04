 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';    
    
    require '../../kconfig/Obj.conf.php'; 
      
	$bd	       = new Db ;
    $txtcodigo = $_GET['id_par_ciu'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
       
    
    $sql = "SELECT   razon,correo,id_par_ciu,direccion,idprov
				  FROM par_ciu
				  where id_par_ciu =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim($dataProv['razon']), 
                            "b"=> trim($dataProv['correo']), 
                            "c"=> trim($dataProv['idprov']),
                            "d"=> trim($dataProv['direccion'])
                    )  
                   );
    
 
    $bd->libera_cursor($resultado1);
    
?>