<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

  
        
        $sql1 = 'SELECT last_value  as nn from activo.ac_bienes_id_bien_seq ';
        
 

        $stmt1 = $bd->ejecutar($sql1);
         
        
        while ($fila=$bd->obtener_fila($stmt1)){
          
            $secuencia = $fila['nn'];
             
        }

        echo '<b>Codigo actual ' . $secuencia.'</b>';

?>