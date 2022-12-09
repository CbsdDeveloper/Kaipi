<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   = new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$referencia = trim(strtoupper($_GET['referencia']));

 

$sql = "SELECT   item,   detalle, cuenta,identificador,clase
		 FROM activo.ac_matriz_esigef
				  where upper(detalle) =".$bd->sqlvalue_inyeccion($referencia,true) ;


$resultado1 = $bd->ejecutar($sql);

$dataProv  = $bd->obtener_array( $resultado1);


echo json_encode( array(
                        "a"=>trim($dataProv['identificador']), 
                        "b"=> trim($dataProv['cuenta'])   ,
                        "c"=> trim($dataProv['item'])  ,
                        "d"=> trim($dataProv['clase']) )
                );

 
?>
 
  