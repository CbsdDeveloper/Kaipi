<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$_SESSION['idbodega'] = $_GET['idbodega'];  
 
$SaldoBodega = $_SESSION['idbodega'];
 
echo trim($SaldoBodega);
    
?>					 
 
 
 