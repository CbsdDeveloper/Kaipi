<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
    $idbien   = $_GET['id'] ;
    $accion   = $_GET['accion'] ;
 
    
    
    if ($accion == 'cambio'){
        
        $sql = "UPDATE activo.ac_bienes
                   SET tipo_bien= ".$bd->sqlvalue_inyeccion('BCA',true) .'
                 WHERE id_bien='.$bd->sqlvalue_inyeccion($idbien,true);
        
        $bd->ejecutar($sql);
        
        
        $clase= 'INFORMACION ACTUALIZADA CON EXITO NRO BIEN '. $idbien.' ... Actualice la informacion';
    }
    
     
        
    echo $clase;

?>