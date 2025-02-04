<?php
session_start( );

require '../../kconfig/Db.class.php';


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$anio_ejecuta = $_SESSION['anio'];

$sql1 = "SELECT anio, detalle
        FROM presupuesto.view_periodo
        where estado in ('ejecucion','proforma') order by anio desc";



$stmt1 = $bd->ejecutar($sql1);

echo '<option value="'.$anio_ejecuta.'">Periodo Actual- '.$anio_ejecuta.'</option>';


echo '<option value="-">-----------------------------</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['anio'].'">'.$fila['detalle'].'</option>';
    
}





?>
