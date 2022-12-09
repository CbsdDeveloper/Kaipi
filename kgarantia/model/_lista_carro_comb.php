<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$idbien  = $_GET['idbien'];


 
 
    
    $sql1 = "SELECT id_combus ,id_combus|| '- Nro.Comprobante ' || referencia as nombre
		      FROM  adm.view_comb_vehi
			 WHERE id_bien = ".$bd->sqlvalue_inyeccion($idbien,true) ;
    
 
 

$stmt1 = $bd->ejecutar($sql1);

echo '<option value="0"> [  Enlazar Orden de Combustible ]</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['id_combus'].'">'.trim($fila['nombre']).'</option>';
    
}
 

?>
 
  