<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$sesion  	 =  trim($_SESSION['email']);
 
    
    $sql1 = 'SELECT idbodega, sesion, registro, nombre
		      FROM view_bodega_permiso
			where sesion = '.$bd->sqlvalue_inyeccion($sesion,true).'
           order by idbodega';
    
 
     
    echo '<option value="0">- Todas las Bodegas - </option>';
    
 

$stmt1 = $bd->ejecutar($sql1);


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['idbodega'].'">'.trim($fila['nombre']).'</option>';
    
}


?>
 
  