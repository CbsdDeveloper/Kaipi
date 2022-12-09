<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$tipo       = $_GET['tipo'];

 
if ( $tipo == '0') {
    
    $regimen   = trim($_GET['regimen']);
    
    $sql1 = ' SELECT programa as codigo,   detalle as nombre
        FROM view_nomina_reg
        where regimen = '.$bd->sqlvalue_inyeccion($regimen,true).'
        order by 1';
    
 
    echo '<option value="-">[ 0. Todos los programas ] </option>';
    
} 
 

if ( $tipo == '1') {
    
    $regimen   = trim($_GET['regimen']);
    $programa  = trim($_GET['programa']);
    
    $sql1 = ' SELECT id_departamento as codigo,   unidad as nombre
        FROM view_nomina_reg_prog
        where regimen = '.$bd->sqlvalue_inyeccion($regimen,true).' and 
              programa = '.$bd->sqlvalue_inyeccion($programa,true).'
        order by 1';
    
    
    echo '<option value="-">[ 0. Todos las Unidades ] </option>';
    
} 
 



$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}


?>