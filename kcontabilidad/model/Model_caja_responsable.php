<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$cuenta    = trim($_GET['cuenta']);
$ruc       =     $_SESSION['ruc_registro'];

$sql1 = 'SELECT   a.idprov, b.razon
            FROM  co_plan_ctas a, par_ciu b
            where a.registro = '.$bd->sqlvalue_inyeccion($ruc,true) .'  and	
            	  a.cuenta = '.$bd->sqlvalue_inyeccion($cuenta,true) .' and
            	  a.idprov = b.idprov';

 


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-">  [ Seleccione Responsable ] </option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['idprov'].'">'.$fila['razon'].'</option>';
    
}




?>
