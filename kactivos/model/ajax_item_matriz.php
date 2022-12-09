<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);




     $tipo     = $_GET['cuenta'] ;
    
        
        $sql1 = "select  debito
                    FROM co_plan_ctas
                    WHERE tipo_cuenta = 'A' and cuenta = ".$bd->sqlvalue_inyeccion(trim($tipo), true)."
                    order by cuenta";
        
   


$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
  $cuenta = trim($fila['debito']);
    
}


echo $cuenta;

?>