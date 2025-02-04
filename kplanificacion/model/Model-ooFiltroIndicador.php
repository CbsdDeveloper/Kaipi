<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;
    
   		 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
   		 $Q_OBJETIVO= $_GET['Q_OBJETIVO'];  
   		 
   		 $Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];
   		 
 
   		 
   		 
 
   		 if ($Q_OBJETIVO == 0){
   		 	
   		 	$sql1 = 'SELECT idobjetivoindicador, indicador
					FROM planificacion.view_indicadores_oo
					where id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true);
   		 	
   		  	echo '<option value="0">[ No Aplica Indicador ]</option>';
   		 	
   		 	
   		 	
   		 }else{
   		 	
   		 	$sql1 = 'SELECT idobjetivoindicador, indicador
					FROM planificacion.view_indicadores_oo
					where idobjetivo = '.$bd->sqlvalue_inyeccion($Q_OBJETIVO,true);
   		 	
   		 	echo '<option value="0">[ No Aplica Indicador ]</option>';
   		 }
   		 
 
      

          
     
         	$stmt1 = $bd->ejecutar($sql1);
             
        	while ($fila=$bd->obtener_fila($stmt1)){
        
            	echo '<option value="'.$fila['idobjetivoindicador'].'">'.trim($fila['indicador']).'</option>';
        
          	}
           
       
            
    
 
  ?> 
								
 
 
 