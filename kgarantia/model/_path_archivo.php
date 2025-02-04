<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   = new Db ;



$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$folder = $bd->_carpeta_archivo(5);


echo json_encode( array( "a"=>trim($folder)));




?>