<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
      
    $codigo_programa  = trim($_GET['codigo_programa']).'%';  
 
          $sql1 = 'SELECT codigo, detalle
					FROM presupuesto.pre_catalogo
					where categoria = '.$bd->sqlvalue_inyeccion('actividad',true).' and
						  codigo like '.$bd->sqlvalue_inyeccion($codigo_programa,true) .' ORDER BY 1';
 
     
         	$stmt1 = $bd->ejecutar($sql1);
             
         	echo '<option value="">'.'[ Seleccione Actividad ]'.'</option>';
         	
        	while ($fila=$bd->obtener_fila($stmt1)){
        
            	echo '<option value="'.$fila['codigo'].'">'.trim($fila['detalle']).'</option>';
        
          	}
 
 
  ?> 
								
 
 
 