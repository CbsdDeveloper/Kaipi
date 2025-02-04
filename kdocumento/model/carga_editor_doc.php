<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 

$idcaso           = $_GET['idcaso'];
 

 

$datos            = $bd->query_array('flow.wk_proceso_casodoc',
                    'documento, asunto, tipodoc, para, de, editor',
                    'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true) .' and 
                     uso = '.$bd->sqlvalue_inyeccion('I',true)  
    );


$editor1 =  $datos['editor']  ;

if (empty($editor1)){

    $editor1 = 'Seleccionar Documento';
    
}  

echo json_encode(    array("a"=> $editor1    )     );



?>