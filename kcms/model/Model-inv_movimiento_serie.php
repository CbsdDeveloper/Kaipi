<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$idserie= $_GET['idserie'];
$valor  = $_GET['valor'];

$len = strlen($valor);

if (!empty($idserie)){
     
    if ($len >	5){
        $UpdateQuery = array(
            array( campo => 'id_movimiento_serie',   valor => $idserie ,  filtro => 'S'),
            array( campo => 'serie',   valor =>$valor,  filtro => 'N')
        );
        
         
        $bd->JqueryUpdateSQL('inv_movimiento_serie',$UpdateQuery);
    }
}
?>
								
 
 
 