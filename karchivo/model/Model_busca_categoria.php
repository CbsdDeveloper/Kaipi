<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$sql1 = "select idcategoria as codigo, nombre
                                             from web_categoria ORDER BY nombre ";




$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> [ Seleccione Categoria ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.$fila['nombre'].'</option>';
    
}





?>
