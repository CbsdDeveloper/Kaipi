<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php';  /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$anio  	 =    $_SESSION['anio'];
 
    
    $sql1 = 'SELECT  cuenta_inv, ncuenta_inv 
            FROM view_inv_movimiento_det
            where anio = '.$bd->sqlvalue_inyeccion($anio ,true)." and tipo_bs = 'B'
            group by cuenta_inv, ncuenta_inv 
            order by cuenta_inv";
    
 
     
    echo '<option value="-">- Todas las Cuentas - </option>';
    
 

$stmt1 = $bd->ejecutar($sql1);


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.trim($fila['cuenta_inv']).'">'.trim($fila['cuenta_inv']).'-'.trim($fila['ncuenta_inv']).'</option>';
    
}


?>
 
  