<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$idtiket        = $_GET['idtiket'];

$sql = "update flow.itil_tiket
        set estado = 'cerrado'
        where estado <> 'cerrado' and id_tiket =".$idtiket;
 
$bd->ejecutar($sql);

echo 'DATOS PROCESADOS CORRECTAMENTE '.$idtiket;

?>