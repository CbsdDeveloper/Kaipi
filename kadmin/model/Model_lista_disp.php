<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   = new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id_tarea = $_GET['id_tarea'] ;



$sql = " SELECT  codificado ,certificacion ,disponible
               FROM planificacion.view_tarea_poa
				  where idtarea =".$bd->sqlvalue_inyeccion($id_tarea,true) ;


$resultado1 = $bd->ejecutar($sql);

$dataProv  = $bd->obtener_array( $resultado1);


echo json_encode(
    array("a"=> trim($dataProv['codificado']),
        "b"=> trim($dataProv['certificacion']),
        "c"=> trim($dataProv['disponible'])
    )
    );



?>