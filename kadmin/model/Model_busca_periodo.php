<?php
session_start( );

$year = date('Y');

$anio_ejecuta = $_SESSION['anio'];

$anio_ejecuta1 = $anio_ejecuta - 1;
$anio_ejecuta2 = $anio_ejecuta - 2;


echo '<option value="'.$anio_ejecuta.'">Periodo Actual- '.$anio_ejecuta.'</option>';


echo '<option value="-">-----------------------------</option>';
 
echo '<option value="'.$year.'">Periodo '.$year.'</option>';
echo '<option value="'.$anio_ejecuta1.'">Periodo '.$anio_ejecuta1.'</option>';
echo '<option value="'.$anio_ejecuta2.'">Periodo '.$anio_ejecuta2.'</option>';
 
 

?>
