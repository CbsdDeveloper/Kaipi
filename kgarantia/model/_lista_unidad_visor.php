 <?php 
    session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $id_prov = trim($_GET['id_prov']);
    
     
    $sql = "SELECT   unidad
				  FROM view_nomina_rol
				  where upper(idprov) =".$bd->sqlvalue_inyeccion($id_prov,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim( $dataProv['unidad'] ) ) );
    
  //  echo json_encode( array("a"=>trim($dataProv['razon']), "b"=> trim($dataProv['correo']) )  );
    
 
  
    
?>