<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = 	new Db ;
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$query	= '%' . strtoupper ( $_GET["query"]) .'%'  ;

 
$sql = "SELECT  clase
		  FROM   activo.ac_clase
		  WHERE  clase like ".$bd->sqlvalue_inyeccion($query, true)."
          order by clase";


$stmt = $bd->ejecutar($sql);

$clase_esigef = array();

while ($x=$bd->obtener_fila($stmt)){
    
    $cnombre =  trim($x['clase']);
    
    $clase_esigef[] =  $cnombre ;
    
}

$n = count($clase_esigef);

if ( $n ==  0 ) {
    
    $clase_esigef[] =  'NO EXISTE' ;
    
    
}


echo json_encode($clase_esigef);




?>
 
  