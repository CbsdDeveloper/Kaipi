<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
$obj   = 	new objects;
$bd	   = 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$registro    = $_SESSION['ruc_registro'];
$sesion 	 = $_SESSION['login'];

$sql = "update web_chat_directo 
           set alerta = 1 
         where alerta = 0 and  sesion<>".$bd->sqlvalue_inyeccion( $sesion ,true);

$bd->ejecutar($sql);


$sql = "SELECT * FROM web_chat_directo where sesion <>".$bd->sqlvalue_inyeccion( $sesion ,true)." ORDER BY 1 DESC limit 5";

$stmt = $bd->ejecutar($sql);

while ($x=$bd->obtener_fila($stmt)){
    
    $clase ='';
    
    $mensaje = trim($x['mensaje']);
    $sesion  = trim($x['sesion']);
     
    $fechaOriginal = $x["fecha"];
    $fechaFormateada = date("d-m-Y", strtotime($fechaOriginal));
    
    $response = $response . "<div class='notification-item'>" .
        "<div class='notification-subject'>". $sesion . " - <span>". $fechaFormateada . "</span> </div>" .
        "<div class='notification-comment'>" . $mensaje . "</div>" .
        "</div>";
    
}

if(!empty($response)) {
    print $response;
}
 

?>