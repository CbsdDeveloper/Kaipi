<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$anio      =     $_GET['anio'];
$idprov    =     trim($_GET['idprov']);
$ruc       =     $_SESSION['ruc_registro'];

$sql1 = 'SELECT cuenta, cuenta_detalle as detalle
            FROM view_aux
            where registro ='.$bd->sqlvalue_inyeccion($ruc,true) .' and 
                  idprov = '.$bd->sqlvalue_inyeccion($idprov,true) .'  and 
                  anio = '.$bd->sqlvalue_inyeccion($anio,true) .'
            group by cuenta, cuenta_detalle order by cuenta';

 


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-">  [ Seleccione la cuenta ] </option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['cuenta'].'">'.trim($fila['cuenta']).'-'.$fila['detalle'].'</option>';
    
}




?>
