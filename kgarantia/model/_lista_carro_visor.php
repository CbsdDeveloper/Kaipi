 <?php 
    session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $idbien = trim($_GET['idbien']);
    
     
    $sql = "SELECT  placa_ve   ,u_km,idprov_chofer
				  FROM adm.view_bien_vehiculo
				  where id_bien =".$bd->sqlvalue_inyeccion($idbien,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
  
    
   echo json_encode( array(
                            "a"=>trim($dataProv['placa_ve']), 
                            "b"=> trim($dataProv['idprov_chofer']) ,
                            "c"=> trim($dataProv['u_km']) ,
                         )
                   );
    
 
   
    
?>