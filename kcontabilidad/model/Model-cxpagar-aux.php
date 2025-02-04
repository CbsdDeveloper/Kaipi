<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $id_asiento =   $_GET['id_asiento'];
    $idprov     =   $_GET['idprov'];
 
 
    
    $sql = "SELECT  secretencion1,autretencion1,fechaemiret1
				  FROM view_anexos_compras
				  where id_asiento =".$bd->sqlvalue_inyeccion($id_asiento,true).' AND 
                        idprov='. $bd->sqlvalue_inyeccion($idprov,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( array("a"=>trim($dataProv['secretencion1']), 
                            "b"=> trim($dataProv['autretencion1']), 
                            "c"=> trim($dataProv['fechaemiret1']) 
                           )  
                     );
    
 
  
    
?>