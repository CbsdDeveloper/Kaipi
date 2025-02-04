<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$_SESSION['idmarca'] = $_GET['idmarca'];  
 
$SaldoBodega = $_SESSION['idmarca'];
 
echo trim($SaldoBodega);
    
?>					 