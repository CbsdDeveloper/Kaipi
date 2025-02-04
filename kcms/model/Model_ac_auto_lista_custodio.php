<?php

session_start( );

require '../../kconfig/Db.class.php'; 
require '../../kconfig/Obj.conf.php';  


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$idunidad   = $_GET['idunidad'];

$tipo       = $_GET['tipo'];

$vidsede    = $_GET['vidsede'];

    if ( $tipo == '0') {
        
        $sql1 = ' SELECT id_departamento_ubica as codigo,   unidad_ubica as nombre
        FROM activo.view_custodios
        where idsede = '.$bd->sqlvalue_inyeccion($idunidad,true).'
        group by id_departamento_ubica,   unidad_ubica
        order by  unidad_ubica';
        
        
        echo '<option value="-">[ 0. Seleccione unidad administrativo ] </option>';
        
    }else {
        
        $sql1 = 'SELECT idprov as codigo,   razon as nombre
                FROM activo.view_custodios
                where idsede = '.$bd->sqlvalue_inyeccion($vidsede,true).'  and 
                      id_departamento_ubica = '.$bd->sqlvalue_inyeccion($idunidad,true).' 
                group by idprov,   razon
                order by idprov,   razon';

 
        
        echo '<option value="-">[ 0. Seleccione custodio administrativo ] </option>';
        
    }
        
    
 

$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}
 

?>
 
  