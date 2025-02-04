<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    
    
    $flujo = $bd->query_array('wk_proceso',
						    		'archivo',
						    		'idproceso='.$bd->sqlvalue_inyeccion($id,true)
						    		);
    
    $imagen 		= $flujo['archivo'];
    
 
    $DibujoFlujo = '<img src="../flujo/'.$imagen.'"/>';
    
    echo $DibujoFlujo ;

?>
