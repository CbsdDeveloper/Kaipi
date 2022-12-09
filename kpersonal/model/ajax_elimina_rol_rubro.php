<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
    
    $id_config1   = $_GET['id_config1'] ;
    $id_rol1      = $_GET['id_rol1'] ;
    
 
    
    $variable_ = $bd->query_array('nom_rol_pagod',
        'count(*) as tramite',
        'id_rol='.$bd->sqlvalue_inyeccion($id_rol1,true). ' and 
         id_config='.$bd->sqlvalue_inyeccion($id_config1,true) .'and 
         coalesce(id_tramite,0) > 0 '
         );
 
    
    if ( $variable_['tramite'] == 0 ){
        
        $sql1 = "DELETE FROM nom_rol_pagod
        where id_rol= ".$bd->sqlvalue_inyeccion($id_rol1,true)." and
              id_config = ".$bd->sqlvalue_inyeccion($id_config1,true);
        
         
        $bd->ejecutar($sql1);  
        
        echo 'DATOS ELIMINADOS CORRECTAMENTE...';
    }
 
  

?>