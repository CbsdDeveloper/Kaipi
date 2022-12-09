 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
//	idtarea,responsable,clasificador,recurso,enlace_pac,tareapac,modulo
	
	
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $idtarea = $_GET['idtarea'];
    
   // 
    
    
    $sql = "SELECT idtarea  , tarea ,recurso ,responsable ,clasificador ,enlace_pac ,modulo 
				  FROM planificacion.sitarea
				  where idtarea =".$bd->sqlvalue_inyeccion($idtarea,true) ;
     
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    $idpac     = $dataProv['enlace_pac'];
    
    $Pac       = $bd->query_array('adm.adm_pac','cpc,detalle,partida,procedimiento', 'id_pac='.$bd->sqlvalue_inyeccion($idpac,true));
    
    $pac =  $Pac['cpc'].' '.$Pac['detalle'].' '.$Pac['partida'].' '.$Pac['procedimiento'];
    
   
    
    
    echo json_encode( 
                array("a"=>trim($dataProv['idtarea']), 
                      "b"=> trim($dataProv['tarea']),
                      "c"=> trim($dataProv['recurso']),
                      "d"=> trim($dataProv['responsable']),
                      "e"=> trim($dataProv['clasificador']),
                      "f"=> trim($dataProv['enlace_pac']),
                      "g"=> trim($dataProv['modulo']),
                      "h"=> trim($pac)
                     )  
                   );
    
 
  
    
?>