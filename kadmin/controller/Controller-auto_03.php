<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
  
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$sql1 = 'SELECT iddepartamento,nombre, count(*) as nn
                FROM flow.view_doc_file
                group by iddepartamento,nombre';
	
	/*Ejecutamos la query*/
	$stmt1 = $bd->ejecutar($sql1);
 	
	echo '<div class="list-group">
	<a href="#" class="list-group-item active">Directorio de Unidades</a>';
	
 
	
 	
	while ($x=$bd->obtener_fila($stmt1)){
	    
	    $nombre    = trim($x['nombre']);
	    
	    $nn   =  $x['nn'];
	    $iddepartamento    =  $x['iddepartamento'];
	    $mensaje           = 'BuscaArchivo('.$iddepartamento .')';
	    
	    echo '<a href="#" onClick="'.$mensaje.' " class="list-group-item">'. $nombre .'<span class="badge">'.$nn.'</span></a>';
	    
	    
 	    
 	    
	}
	
	echo '</div>';
	
	 
    
   
 
   

?>