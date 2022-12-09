<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   = new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$tipo     = trim($_GET['tipo']);



$x = $bd->query_array('nom_accion_lista',   // TABLA
'*',                        // CAMPOS
'nombre='.$bd->sqlvalue_inyeccion($tipo,true) // CONDICION
);
 

    
echo json_encode( array("a"=>trim($x['legal']),
                        "b"=> trim($x['tiempo']) ,
                        "c"=> trim($x['responsable']) 
)  
);


 



?>