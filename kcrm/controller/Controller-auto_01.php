<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    $DibujoFlujo	    = '';
    
    $sql = "select visor,original  
              from flow.wk_procesoflujo 
             where idproceso = ".$id.' 
             order by idprocesoflujo';
 
    $stmt_nivel1= $bd->ejecutar($sql);
    
    $i = 0;
    while ($x=$bd->obtener_fila($stmt_nivel1)){
  
            $DibujoFlujo= $DibujoFlujo.trim($x['visor']);
  
    	$i++;
    	
    }
 
 
    
    echo $DibujoFlujo ;

?>
