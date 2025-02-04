<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

 
 $bd	   =	new Db;
    
 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
 
   		 
   		 $Q_IDUNIDAD= $_GET['codigo'];
   		 $idperiodo = $_GET['idperiodo'];
   		 
   		 $WHERE = "  anio=".$bd->sqlvalue_inyeccion($idperiodo,true)." AND 
					 id_departamento=".$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true);
   		 
   		 
   		 
   		 $sql1= "SELECT  idobjetivo  ,  objetivo  
				 FROM planificacion.pyobjetivos WHERE ". 
   		 		$WHERE. " ORDER BY idobjetivo";
   		 
 
     
         	$stmt1 = $bd->ejecutar($sql1);
             
        	while ($fila=$bd->obtener_fila($stmt1)){
        
            	echo '<option value="'.$fila['idobjetivo'].'">'.trim($fila['objetivo']).'</option>';
        
          	}
           
  
 
  ?> 
								
 
 
 