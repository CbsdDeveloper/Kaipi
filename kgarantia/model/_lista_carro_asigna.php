 <?php 
    session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $idbien     = trim($_GET['id_unidad']);
    $idprov_cho = trim($_GET['idprov_cho']);
    
 
     
    $sql = "update activo.ac_bienes_vehiculo 
               set status ='Asignado',  idprov_chofer = ".$bd->sqlvalue_inyeccion($idprov_cho,true) ." 
				  where id_bien =".$bd->sqlvalue_inyeccion($idbien,true) ;
    
    
    $bd->ejecutar($sql);
    
   echo 'Dato Actualizado...';
   
    
?>