<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$id_config_reg  = $_GET['id_config_reg'];
$programap      = $_GET['programap'];
 
 
 
    $sql = 'update nom_config_regimen
            set programa_p = '.$bd->sqlvalue_inyeccion($programap ,true).' 
            where id_config_reg = '.$bd->sqlvalue_inyeccion($id_config_reg ,true);
 
  

  $bd->ejecutar($sql);


 
 
  echo 'Informacion actualizada: '.$programap;
    
 


?>