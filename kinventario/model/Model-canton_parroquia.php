<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$canton = $_GET['id'];

$sql1 = 'SELECT  cod_parroquia, nom_parroquia
            FROM k_parroquia
            where cod_canton = '.$bd->sqlvalue_inyeccion($canton,true) .' order by 2 asc';

$stmt1 = $bd->ejecutar($sql1);

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['cod_parroquia'].'">'.$fila['nom_parroquia'].'</option>';
    
}

 


?>
