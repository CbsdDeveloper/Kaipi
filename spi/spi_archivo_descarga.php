<?php
session_start( );

require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

$bd	   =	new Db;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
$tipo        = $_GET['tipo'];

/*
$x = $bd->query_array('tesoreria.te_spi_para',
                      ' fecha_pago, mes_pago, referencia_pago, localidad, responsable1, cargo1, responsable2, cargo2, cuenta_bce, empresa', 
                      '1=1' 
    );

*/

if ( $tipo == 'txt'){
    $file = 'spi-sp.txt';
  }

if ( $tipo == 'md5'){
    $file = 'spi-sp.md5';
  }

if ( $tipo == 'zip'){
     
    $file = 'spi-sp.zip';
 
}
 
 
$nombre = $file;
$filename = $file;
$size = filesize($filename);
header("Content-Transfer-Encoding: binary");
header("Content-type: application/octet-stream");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=$nombre");
header("Content-Length: $size");
readfile("$filename"); 

 
?>