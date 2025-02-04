<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$cuenta = $_GET['cuenta'];

$anio   = $_SESSION['anio'];

$grupo = substr($cuenta, 0,2);

 
 
    if ( $cuenta <> '-') {
    
        $sql1 = 'SELECT cuenta,   detalle  
            FROM co_plan_ctas
            where trim(credito) = '.$bd->sqlvalue_inyeccion($grupo,true) .' and 
                           anio = '.$bd->sqlvalue_inyeccion($anio,true) .' and 
                         univel = '.$bd->sqlvalue_inyeccion('S',true);

 
        $stmt1 = $bd->ejecutar($sql1);
        

            
               echo '<option value="-"> [ No Aplica ] </option>';
        
                while ($fila=$bd->obtener_fila($stmt1)){
                    
                    echo '<option value="'.$fila['cuenta'].'">'.trim($fila['cuenta']).' '. trim($fila['detalle']).'</option>';
                    
                }
        }
        else   {
            
    
            echo '<option value="-"> [ No Aplica ] </option>';
            
        }
      
 

?>
								
 
 