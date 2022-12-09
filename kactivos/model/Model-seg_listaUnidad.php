<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$id_departamento  = $_GET['id_departamento'];
 
 


$sql1 = 'SELECT idusuario, completo
						FROM par_usuario
						where id_departamento = '.$bd->sqlvalue_inyeccion($id_departamento,true) ;


$stmt1 = $bd->ejecutar($sql1);

$idusuario_asignado .= '<option value="">'.'[Seleccione Usuario]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    $idusuario_asignado .= '<option value="'.$fila['idusuario'].'">'.$fila['completo'].'</option>';
    
}

echo $idusuario_asignado;

?>
 
  