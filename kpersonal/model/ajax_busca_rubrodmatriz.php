<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
$regimen   = trim($_GET['regimen']);
$tipo      = trim($_GET['tipo']);

 

$sql1 = "SELECT id_config as codigo,  nombre
        FROM view_nomina_rol_reg
        where tipo_config = ".$bd->sqlvalue_inyeccion($tipo,true)." and
              regimen= ".$bd->sqlvalue_inyeccion($regimen,true)." 
        group by id_config,nombre
        order by 2";


$stmt1 = $bd->ejecutar($sql1);


echo '<option value="-">[ 0. Seleccione Rubro ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}


?>