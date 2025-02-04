<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$ruc       =     $_SESSION['ruc_registro'];

$sql1 = 'SELECT cuenta, cuenta_detalle as detalle
            FROM view_aux
            where registro ='.$bd->sqlvalue_inyeccion($ruc,true) .'  
            group by cuenta, cuenta_detalle 
            having sum(debe) - sum(haber)   <> 0
            order by cuenta ';

 
 

$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-">  [ Seleccione la cuenta ] </option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.trim($fila['cuenta']).'">'.trim($fila['cuenta']).'-'.trim($fila['detalle']).'</option>';
    
}




?>
