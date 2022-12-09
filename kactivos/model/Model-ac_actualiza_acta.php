<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php'; 

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$tfecha   = $_GET["tfecha"];
$tdetalle = trim($_GET["tdetalle"]);
$tacta    = $_GET["tacta"];
  
$longitud = strlen($tdetalle);

if ( $longitud > 25 ) {
    $sql = "update activo.ac_movimiento
               set  fecha = ".$bd->sqlvalue_inyeccion($tfecha ,true)." ,
                    detalle = ".$bd->sqlvalue_inyeccion($tdetalle,true)." 
           where    id_acta = ".$bd->sqlvalue_inyeccion(trim($tacta),true);
    
    
    $bd->ejecutar($sql);
    
    echo 'Informacion actualizada... ';
     
} 


?>
 
  