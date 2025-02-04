<?php
session_start( );

/*
SELECCIONA LA BODEGA PARA EL FILTRO DE INFORMACION Y
SELECCION DE PRODUCTOS
*/

$_SESSION['idbodega'] = $_GET['idbodega'];   
$Bodega               = $_SESSION['idbodega'];
 
echo trim($Bodega);
    
?>					 