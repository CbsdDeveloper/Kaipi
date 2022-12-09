<?php
session_start( );

require '../../kconfig/Db.class.php';


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$anio = $_SESSION['anio'];

$tipo=     $_GET["tipo"].'%';


$sql1 = "SELECT item
        FROM public.view_diario_conta
        where anio = ".$bd->sqlvalue_inyeccion($anio,true) ." and cuenta like  ".$bd->sqlvalue_inyeccion($tipo,true) ." 
        group by item
        order by item";



$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> [ Seleccione Enlace  ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    $A = $bd->query_array('presupuesto.pre_catalogo',
        'detalle',
        'codigo='.$bd->sqlvalue_inyeccion(trim($fila['item']),true). " and tipo='arbol' and categoria='clasificador'"
        );
    
    $detalle = $A['detalle'];
    
    echo '<option value="'.$fila['item'].'">'.$fila['item'].'-'.trim($detalle).'</option>';
    
    
}
 


?>