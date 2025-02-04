<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
    $codigo	         =	$_GET["id"];
 
    $xzq = $bd->query_array('rentas.ren_servicios_var',
                        '*',
                        "id_matriz_var = ".$bd->sqlvalue_inyeccion($codigo, true)) ;


    $mov1 =  $xzq["catalogo"];
 
    echo json_encode( array("a"=>trim($mov1),
                            "b"=> trim($xzq['tipo_cat']) 
                    )   
        );
 

?>
 
  