<?php 
session_start( );   
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
$bd	   = 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$query	=	"'".strtoupper($_GET["query"]) .'%'."'" ;
    	
$sql = "SELECT  razon 
					  FROM  par_ciu
					  WHERE estado = 'S' AND UPPER(razon) like ".$query." order by razon";
					    
		 
$stmt = $bd->ejecutar($sql);
		    
while ($x=$bd->obtener_fila($stmt)){
		    	$cnombre =  trim($x['razon']);
		    	$razon[] =  $cnombre ;
		    }
		    
echo json_encode($razon);
 
?>  