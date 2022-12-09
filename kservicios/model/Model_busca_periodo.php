<?php
session_start( );

$year = date('Y');

 
$anio_ejecuta     = $year;
$anio_ejecuta1 = $anio_ejecuta - 1;
$anio_ejecuta2 = $anio_ejecuta - 2;
$anio_ejecuta3 = $anio_ejecuta - 3;
$anio_ejecuta4 = $anio_ejecuta - 4;
$anio_ejecuta5 = $anio_ejecuta - 5;
$anio_ejecuta6 = $anio_ejecuta - 6;
$anio_ejecuta7 = $anio_ejecuta - 7;


echo '<option value="'.$anio_ejecuta.'">Periodo Actual- '.$anio_ejecuta.'</option>';


echo '<option value="-">-----------------------------</option>';

echo '<option value="'.$year.'">Periodo '.$year.'</option>';
echo '<option value="'.$anio_ejecuta1.'">Periodo '.$anio_ejecuta1.'</option>';
echo '<option value="'.$anio_ejecuta2.'">Periodo '.$anio_ejecuta2.'</option>';

echo '<option value="'.$anio_ejecuta3.'">Periodo '.$anio_ejecuta3.'</option>';
echo '<option value="'.$anio_ejecuta4.'">Periodo '.$anio_ejecuta4.'</option>';
echo '<option value="'.$anio_ejecuta5.'">Periodo '.$anio_ejecuta5.'</option>';
echo '<option value="'.$anio_ejecuta6.'">Periodo '.$anio_ejecuta6.'</option>';
echo '<option value="'.$anio_ejecuta7.'">Periodo '.$anio_ejecuta7.'</option>';
 

?>
