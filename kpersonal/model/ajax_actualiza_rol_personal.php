<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$id_rol   = $_GET['id_rol'];
$tipo     = $_GET['tipo'];
$monto    = $_GET['monto'];


if ( $tipo == '1'){   
    $sql = 'update nom_rol_pagod
            set ingreso = '.$bd->sqlvalue_inyeccion($monto ,true).' 
            where id_rold = '.$bd->sqlvalue_inyeccion($id_rol ,true);
}else{   
    $sql = 'update nom_rol_pagod
            set descuento = '.$bd->sqlvalue_inyeccion($monto ,true).'
            where id_rold = '.$bd->sqlvalue_inyeccion($id_rol ,true);
}

  

  $bd->ejecutar($sql);


 
 
  echo 'Informacion actualizada: '.$monto;
    
 


?>