<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
      
      $Q_IDUNIDAD  = $_GET['Q_IDUNIDAD'];  
      $Q_IDPERIODO = $_GET['Q_IDPERIODO'];  
     
 
 
          $sql1 = 'SELECT idobjetivo,objetivo 
					FROM planificacion.pyobjetivos
					where id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
						  anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true);
 
     
         	$stmt1 = $bd->ejecutar($sql1);
             
        	while ($fila=$bd->obtener_fila($stmt1)){
        
            	echo '<option value="'.$fila['idobjetivo'].'">'.trim($fila['objetivo']).'</option>';
        
          	}
           
       
            
    
 
  ?> 
								
 
 
 