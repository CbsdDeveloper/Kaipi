<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
    
    $regimen   = trim($_GET['regimen']);
    
    $programa   = trim($_GET['programa']);
    
    $id_rol1   = trim($_GET['id_rol1']);
    
 
    
    $variable_ = $bd->query_array('nom_rol_pago',
        'tipo',
        'id_rol='.$bd->sqlvalue_inyeccion($id_rol1,true));
    
    
    if ( $variable_['tipo'] == 0 ){
        
        $sql1 = "SELECT id_config_reg as codigo,    nombre
        FROM view_nomina_rol_reg
        where tipo_config = 'I' and
              regimen= ".$bd->sqlvalue_inyeccion($regimen,true)." and
              programa = ".$bd->sqlvalue_inyeccion($programa,true).'
        order by 1';
        
    }
 

    if ( $variable_['tipo'] == 1 ){
        
        $sql1 = "SELECT id_config_reg as codigo,    nombre
        FROM view_nomina_rol_reg
        where tipo_config = 'I' and
              regimen= ".$bd->sqlvalue_inyeccion($regimen,true)." and  id_config = 8 and 
              programa = ".$bd->sqlvalue_inyeccion($programa,true).'
        order by 1';
        
    }
    
   
    
    if ( $variable_['tipo'] == 2 ){
        
        $sql1 = "SELECT id_config_reg as codigo,    nombre
        FROM view_nomina_rol_reg
        where tipo_config = 'I' and
              regimen= ".$bd->sqlvalue_inyeccion($regimen,true)." and  id_config = 3 and
              programa = ".$bd->sqlvalue_inyeccion($programa,true).'
        order by 1';
        
    }
    
    
 

$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-">[ 0. Seleccione Rubro de Ingreso Aplicar ] </option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}


?>