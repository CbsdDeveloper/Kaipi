<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
$regimen   = trim($_GET['regimen']);

$programa   = trim($_GET['programa']);


$sql1 = "SELECT id_config_reg as codigo,    nombre
        FROM view_nomina_rol_reg
        where tipo_config = 'E' and
              regimen= ".$bd->sqlvalue_inyeccion($regimen,true)." and
              programa = ".$bd->sqlvalue_inyeccion($programa,true).'
        order by 1';


$stmt1 = $bd->ejecutar($sql1);


echo '<option value="-">[ 0. Seleccione Rubro de Descuento Aplicar ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}


?>