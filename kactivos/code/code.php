<?php
include 'barcode.php';

$id 			= $_GET["id"];


$codigo =  str_pad($id,7,"0",STR_PAD_LEFT );
barcode($codigo . '.png', $codigo, 50, 'horizontal', 'code128', true);
$archivo = $codigo.'.png';

echo $archivo; 



?>
