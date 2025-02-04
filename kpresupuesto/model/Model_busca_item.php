<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
    
$tipo          = $_GET['tipo'];

$clasificador    = $_GET['grupo'].'%';
 
 

if ( $tipo == 'I'){
    $tipo_dato = 'ingreso';
    $nivel = 4;
}else{
    $tipo_dato = 'gasto';
    $nivel = 5;
}

$sql1 = "SELECT   codigo, codigo || ' ' || detalle AS nombre
        FROM presupuesto.pre_catalogo
        WHERE categoria = 'clasificador' and 
              subcategoria = ".$bd->sqlvalue_inyeccion($tipo_dato,true). " and
              codigo like ".$bd->sqlvalue_inyeccion($clasificador,true). " and 
              nivel = ".$bd->sqlvalue_inyeccion($nivel,true). "   and 
        estado = 'S' order by 1 asc";


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> [ Seleccione Partida ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.$fila['nombre'].'</option>';
    
}





?>
