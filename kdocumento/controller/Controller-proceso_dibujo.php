<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    
    $id = 21;
    
    $flujo = $bd->query_array('flow.wk_proceso',
						    		'archivo',
						    		'idproceso='.$bd->sqlvalue_inyeccion($id,true)
						    		);
    
    $imagen 		= trim($flujo['archivo']);
    

    $imagen = 'TramiteInternoV1.svg';
 
    $DibujoFlujo = '<img src="../flujo/'.$imagen.'"/>';
    
    echo $DibujoFlujo ;

?>
