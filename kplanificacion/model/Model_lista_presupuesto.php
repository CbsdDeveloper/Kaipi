<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$valor  = trim($_GET['valor']);
 
$tipo  = trim($_GET['tipo']);
 
if ( $tipo  == 1 ) {
    
    $sql1 = "SELECT codigo, detalle
            FROM presupuesto.pre_catalogo
            where  tipo= 'arbol' and 
                   subcategoria = 'gasto'  and 
                   nivel = 3  and 
                   pac = 'S' and 
                   codigo like ".$bd->sqlvalue_inyeccion($valor.'%', true)."
           order by 1";
    
}else{
    
    $sql1 = "SELECT codigo, detalle
            FROM presupuesto.pre_catalogo
            where  tipo= 'arbol' and
                   subcategoria = 'gasto'  and
                   pac = 'S' and
                   codigo like ".$bd->sqlvalue_inyeccion($valor.'%', true)." and nivel in (4,5)
           order by 1";
    
}

 
 
$stmt1 = $bd->ejecutar($sql1);


echo '<option value="0">-- No Aplica -- </option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
 
    echo '<option value="'.$fila['codigo'].'">'.$fila['codigo'].'. '.trim($fila['detalle']).'</option>';
    
}


?>
 
  