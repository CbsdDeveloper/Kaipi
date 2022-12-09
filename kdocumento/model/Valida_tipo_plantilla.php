<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$tipo  = $_GET['tipo'];


 
    
    $sql1 = "SELECT  id_docmodelo as codigo,  plantilla  as nombre
		   FROM flow.wk_doc_modelo
						where visor= 'S' and tipo = ".$bd->sqlvalue_inyeccion(trim($tipo),true) ;
    
    
    
 

$stmt1 = $bd->ejecutar($sql1);


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}
 

?>
 
  