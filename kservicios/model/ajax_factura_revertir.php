<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
$id    = $_GET['id'] ;


$sql = "UPDATE rentas.ren_movimiento
           SET envio=".$bd->sqlvalue_inyeccion('', true).", autorizacion = ".$bd->sqlvalue_inyeccion('', true)."
         WHERE id_ren_movimiento=".$bd->sqlvalue_inyeccion($id, true);

$bd->ejecutar($sql);

 
        
        $div_mistareas = ' Factura eliminada...verifique para emitir posteriormente...';
        
        echo $div_mistareas;
?>