<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);




    $codigo   = $_GET['codigo'] ;
    $tipo   = $_GET['tipo'] ;
    
    if ( $tipo == '0'){
        
        $sql1 = 'select  id_departamento as codigo,unidad as nombre
                    FROM activo.view_bienes_itil
                    where idsede= '.$bd->sqlvalue_inyeccion($codigo,true).'
                    group by id_departamento,unidad
                    order by unidad';
        
        echo '<option value="0"> [ 0. Todas las unidades ]</option>';
    }  

    if ( $tipo == '1'){
        
        $sql1 = 'select  cuenta as codigo,nombre_cuenta as nombre
                    FROM activo.view_bienes_itil
                    where idsede= '.$bd->sqlvalue_inyeccion($codigo,true)."  
                    group by cuenta,nombre_cuenta
                    order by cuenta";
        
    }
    

$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}


?>