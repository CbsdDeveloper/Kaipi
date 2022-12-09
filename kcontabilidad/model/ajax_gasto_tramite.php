<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 

$anio   = $_SESSION['anio'];
 
 
        $sql1 = 'SELECT id_tramite,  unidad 
                    FROM presupuesto.view_gasto_devengo_dife
                    where anio = '.$bd->sqlvalue_inyeccion($anio,true) .'
                    group by id_tramite, anio, unidad ';


 
 
        $stmt1 = $bd->ejecutar($sql1);
  
       echo '<option value="0"> [ No Aplica ] </option>';
        
        while ($fila=$bd->obtener_fila($stmt1)){
                    
        echo '<option value="'.$fila['id_tramite'].'">'.$fila['id_tramite'] .' - '. trim($fila['unidad']).'</option>';
                    
      }
        
 

?>
								
 
 