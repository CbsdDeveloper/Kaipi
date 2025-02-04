<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
      
         $Q_IDUNIDAD  = $_GET['Q_IDUNIDAD'];  
  
		 $unidad_actual  = $bd->query_array('nom_departamento','orden',  "id_departamento = ".$bd->sqlvalue_inyeccion( $Q_IDUNIDAD  ,true) );
		 $orden         = $unidad_actual['orden'] .'%';

  
          $sql1 = 'SELECT idprov,razon 
					FROM view_nomina_user
					where  cargo is not null and orden like '.$bd->sqlvalue_inyeccion( $orden,true) .' order by razon';
 
     
         	$stmt1 = $bd->ejecutar($sql1);
             
         	echo '<option value="">'.' - Seleccione Funcionarios - '.'</option>';
         	
        	while ($fila=$bd->obtener_fila($stmt1)){
        
            	echo '<option value="'.trim($fila['idprov']).'">'.trim($fila['razon']).'</option>';
        
          	}
 
 
  ?> 
								
 
 
 