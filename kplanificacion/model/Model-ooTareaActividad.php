<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
      
      $Q_IDUNIDAD  = $_GET['Q_IDUNIDAD'];  
      $Q_IDPERIODO = $_GET['Q_IDPERIODO'];  
 
 
          $sql1 = 'SELECT idactividad,actividad 
					FROM planificacion.view_actividad_poa
					where id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
						  anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true);
 
     
         	$stmt1 = $bd->ejecutar($sql1);
             
         	echo '<option value="">'.'[Seleccione Actividad]'.'</option>';
         	
        	while ($fila=$bd->obtener_fila($stmt1)){
        
            	echo '<option value="'.$fila['idactividad'].'">'.trim($fila['actividad']).'</option>';
        
          	}
 
 
  ?> 
								
 
 
 