<?php
session_start( );

require '../../kconfig/Db.class.php';


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$anio = $_SESSION['anio'];

$tipo=     $_GET["tipo"].'%';


$sql1 = "SELECT subgrupo
        FROM public.view_diario_conta
        where anio = ".$bd->sqlvalue_inyeccion($anio,true) ." and subgrupo like  ".$bd->sqlvalue_inyeccion($tipo,true) ." 
        group by subgrupo
        order by subgrupo";



$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> [ Seleccione Sub Cuenta  ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    $A = $bd->query_array('co_plan_ctas',
        'detalle',
        'cuenta='.$bd->sqlvalue_inyeccion(trim($fila['subgrupo']),true). ' and anio='.$bd->sqlvalue_inyeccion($anio,true)
        );
    
    $detalle = $A['detalle'];
    
    echo '<option value="'.$fila['subgrupo'].'">'.$fila['subgrupo'].'-'.trim($detalle).'</option>';
    
    
}





?>