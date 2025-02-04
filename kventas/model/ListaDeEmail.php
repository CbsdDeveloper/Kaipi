<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
$bandera  = $_GET['bandera'];


$sesion 	 =     trim($_SESSION['email']);

if ($bandera == 0 ){
    
    $sql1 = 'SELECT  email ,  smtp1, puerto1, acceso1
            FROM public.par_usuario
            where email = '.$bd->sqlvalue_inyeccion($sesion,true).' and acceso1 is not null
            union
            SELECT  email, smtp, puerto, acceso
            FROM ven_registro
            union
            SELECT   email1 as email, smtp1, puerto1, acceso1 
            FROM ven_registro';

 
 
}


$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-">'.'[ Correo@Administrador ]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['email'].'">'.$fila['email'].'</option>';
    
}


?>
 
  