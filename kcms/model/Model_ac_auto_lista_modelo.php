<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$idmarca  = $_GET['idmarca'];




if (isset($_GET['id_modelo']))	{
    
    $id_modelo = $_GET['id_modelo'];
    
    $sql1 = 'SELECT idmodelo, nombre, referencia
		   FROM web_modelo
						where idmarca = '.$bd->sqlvalue_inyeccion($idmarca,true) . ' and idmodelo='.$bd->sqlvalue_inyeccion($id_modelo,true);
    
    
    
}else	{
    
    $sql1 = 'SELECT idmodelo, nombre, referencia
		   FROM web_modelo
						where idmarca = '.$bd->sqlvalue_inyeccion($idmarca,true) ;
 
    
    
}
 

$stmt1 = $bd->ejecutar($sql1);


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['idmodelo'].'">'.trim($fila['nombre']).'</option>';
    
}
 

?>
 
  