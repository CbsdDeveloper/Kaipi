<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
    $id        = $_GET['id'] ;
    
    
 
        
            $sql1 = 'select  variable,   variable_sis
                        FROM flow.view_proceso_var
                        where idproceso= '.$bd->sqlvalue_inyeccion($id,true).'
                        order by variable';
 
 
            

            $stmt1 = $bd->ejecutar($sql1);
            
            
            echo '<ul class="list-group">';
            
            while ($fila=$bd->obtener_fila($stmt1)){
                
                $nombre    =  trim($fila['variable']);
                
                $idproceso =  $fila['variable_sis'];
                
                echo ' <li class="list-group-item">'.$nombre.' [ '.$idproceso.' ]'.'</li>';
                
            }
            
            echo '</ul>';



?>