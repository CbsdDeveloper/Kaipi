 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo =  ($_GET['codigo']);
    
 
    
    $sql = "SELECT   cuenta,anio,mes
				  FROM co_caja
				  where id_co_caja =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array(
                            "a"=>trim($dataProv['anio']), 
                            "b"=> trim($dataProv['mes']) ,
                            "c"=> trim($dataProv['cuenta']) 
                          )  
                    );
    
  
    
?>