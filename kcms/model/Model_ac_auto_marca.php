<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$referencia = trim(strtoupper($_GET['referencia']));



$sql = "SELECT   idmarca,   nombre
		 FROM web_marca
				  where upper(nombre) =".$bd->sqlvalue_inyeccion($referencia,true) ;

  
 
$resultado1 = $bd->ejecutar($sql);

$dataProv  = $bd->obtener_array( $resultado1);


echo json_encode( array(
    "a"=>trim($dataProv['idmarca'])  )
    );


?>
 
  