<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$cuenta   = trim($_GET['cuenta']);

$anio = $_SESSION['anio'];



$sql = "select debito
			 from co_plan_ctas
		    where univel = 'S' and  
                  cuenta = ".$bd->sqlvalue_inyeccion($cuenta ,true)." and
                  anio =".$bd->sqlvalue_inyeccion($anio ,true)." order by 1";

 

$stmt1 = $bd->ejecutar($sql);



while ($fila=$bd->obtener_fila($stmt1)) {
    
  $partida =   trim($fila['debito']);
    
}
    

echo $partida;
    
 


?>