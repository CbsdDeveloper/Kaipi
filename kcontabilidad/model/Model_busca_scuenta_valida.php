<?php
session_start( );

require '../../kconfig/Db.class.php';


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$anio = $_SESSION['anio'];

$tipo=     $_GET["tipo"].'%';


$sql1 = "SELECT cuenta
        FROM public.view_diario_conta
        where anio = ".$bd->sqlvalue_inyeccion($anio,true) ." and cuenta like  ".$bd->sqlvalue_inyeccion($tipo,true) ." 
        group by cuenta
        order by cuenta";



$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> [ Seleccione Cuenta  ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    $A = $bd->query_array('co_plan_ctas',
        'detalle',
        'cuenta='.$bd->sqlvalue_inyeccion(trim($fila['cuenta']),true). ' and anio='.$bd->sqlvalue_inyeccion($anio,true)
        );
    
    $detalle = $A['detalle'];
    
    echo '<option value="'.$fila['cuenta'].'">'.$fila['cuenta'].'-'.trim($detalle).'</option>';
    
    
}





?>