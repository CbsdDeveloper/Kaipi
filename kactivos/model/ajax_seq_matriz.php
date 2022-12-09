<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

  
        
$sql = "SELECT count(*) as secuencia
FROM activo.ac_matriz_esigef ";

$parametros 			= $bd->ejecutar($sql);
$secuencia 				= $bd->obtener_array($parametros);


$contador = $secuencia['secuencia'] + 1;

$input = '99999'.str_pad($contador, 7, "0", STR_PAD_LEFT);

echo $input ;

?>