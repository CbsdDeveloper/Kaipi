<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



 
$anio   = $_SESSION['anio'];

 
 
  
    
        $sql1 = "select cuenta, cuenta_detalle 
        FROM view_aux
        where anio = ".$bd->sqlvalue_inyeccion($anio,true) ." and 
              estado = 'aprobado' and 
              substring(cuenta,1,3) in ('112','124','224') 
        group by cuenta, cuenta_detalle";
        
        
 
 
        $stmt1 = $bd->ejecutar($sql1);
        

            
               echo '<option value="-"> [ Seleccione Cuenta ] </option>';
        
                while ($fila=$bd->obtener_fila($stmt1)){
                    
                    echo '<option value="'.$fila['cuenta'].'">'.trim($fila['cuenta']).' '. trim($fila['cuenta_detalle']).'</option>';
                    
                }
 
      
 

?>
								
 
 