<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$codigo           = $_GET['codigo'];
$idproceso        = $_GET['idproceso'];
$idcaso           = $_GET['idcaso'];


$datos = $bd->query_array('flow.wk_proceso_casodoc',
    'documento, asunto, tipodoc, para, de, editor',
    'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true) .' and
                                          idproceso = '.$bd->sqlvalue_inyeccion($idproceso,true) .' and
                                          idproceso_docu =  '.$bd->sqlvalue_inyeccion($codigo,true)
    );


$editor1 =  $datos['editor']  ;


echo json_encode(    array("a"=> $editor1    )     );



?>
 